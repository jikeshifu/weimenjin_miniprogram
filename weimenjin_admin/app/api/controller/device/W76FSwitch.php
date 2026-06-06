<?php

namespace app\api\controller\device;

use app\api\controller\Base;
use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\Lock;
use app\module\lockServer\LockLog;
use app\module\member\memberServer\MemberServer;
use think\exception\ValidateException;
use think\facade\Db;

class W76FSwitch extends Base
{
    /**
     * 获取W76F继电器配置(支持动态路数)
     * @return \think\response\Json
     */
    public function getConfig(){
        $param = request()->post();
        try {
            validate([
                'lockauth_id' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        $lock = $this->getLockByAuthId($param['lockauth_id']);
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备授权不存在"));
        }

        // 获取设备路数配置
        $deviceConfig = Db::name('w76f_device_config')
            ->where('lock_id', $lock["lock_id"])
            ->find();

        // 如果没有配置路数，返回空数据
        if (!$deviceConfig || empty($deviceConfig['relay_count'])) {
            return json(Code::CodeOk([
                "msg" => "获取成功",
                "data" => [
                    'device_sn' => $lock["lock_sn"],
                    'lock_id' => $lock["lock_id"],
                    'lock_name' => $lock["lock_name"],
                    'relay_count' => 0,
                    'relays' => [],
                ],
            ]));
        }

        $relayCount = intval($deviceConfig['relay_count']);

        // 获取设备实时状态
        $statusRes = HardwareCloud::App()::SendData($lock["lock_sn"], [
            "cmd_type" => "get_sta",
            "info" => []
        ]);
        $statusInfo = [];
        if (!$statusRes["err"] && isset($statusRes["data"]["info"])) {
            $statusInfo = $statusRes["data"]["info"];
        }

        // 从数据库获取继电器的名称配置
        $relayConfig = Db::name('w76f_relay_config')
            ->where('lock_id', $lock["lock_id"])
            ->select()
            ->toArray();

        // 根据配置的路数组织返回数据
        $relays = [];
        for($i = 1; $i <= $relayCount; $i++){
            $config = array_filter($relayConfig, function($item) use ($i) {
                return $item['relay_num'] == $i;
            });
            $config = !empty($config) ? array_values($config)[0] : null;

            $relays[] = [
                'relay_num' => $i,
                'relay_name' => $config ? $config['relay_name'] : "继电器{$i}",
                'relay_mode' => $config ? intval($config['relay_mode']) : 0,
                'relay_delay' => $config ? intval($config['relay_delay']) : 1000,
                'status' => isset($statusInfo["relay{$i}"]) ? intval($statusInfo["relay{$i}"]) : 0,
            ];
        }

        return json(Code::CodeOk([
            "msg" => "获取成功",
            "data" => [
                'device_sn' => $lock["lock_sn"],
                'lock_id' => $lock["lock_id"],
                'lock_name' => $lock["lock_name"],
                'relay_count' => $relayCount,
                'relays' => $relays,
            ],
        ]));
    }

    /**
     * 保存继电器配置(名称、模式、延迟)
     * @return \think\response\Json
     */
    public function setRelayConfig(){
        $param = request()->post();
        try {
            validate([
                'lockauth_id' => 'require',
                'relay_num' => 'require|number|>:0',
                'relay_name' => 'require|max:20',
                'relay_mode' => 'require|in:0,1',
                'relay_delay' => 'require|number|between:100,60000',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        $lock = $this->getLockByAuthId($param['lockauth_id']);
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备授权不存在"));
        }

        // 检查是否已存在配置
        $exists = Db::name('w76f_relay_config')
            ->where('lock_id', $lock["lock_id"])
            ->where('relay_num', $param['relay_num'])
            ->find();

        $data = [
            'relay_name' => $param['relay_name'],
            'relay_mode' => intval($param['relay_mode']),
            'relay_delay' => intval($param['relay_delay']),
            'update_time' => time(),
        ];

        if($exists){
            // 更新
            Db::name('w76f_relay_config')
                ->where('id', $exists['id'])
                ->update($data);
        }else{
            // 插入
            $data['lock_id'] = $lock["lock_id"];
            $data['relay_num'] = $param['relay_num'];
            $data['create_time'] = time();
            Db::name('w76f_relay_config')->insert($data);
        }

        // 如果是点动模式,同步设置到设备
        if($param['relay_mode'] == 0){
            $this->syncRelayDelayToDevice($lock["lock_sn"], $param['relay_num'], $param['relay_delay']);
        }

        return json(Code::CodeOk([
            "msg" => "保存成功",
        ]));
    }

    /**
     * 同步继电器延迟到设备
     */
    private function syncRelayDelayToDevice($device_sn, $relay_num, $delay){
        try{
            $sandData = [
                "cmd_type" => "set_relay",
                "info" => [
                    "relay{$relay_num}" => intval($delay)
                ]
            ];
            HardwareCloud::App()::SendData($device_sn, $sandData);
        }catch(\Exception $e){
            // 忽略错误,不影响配置保存
        }
    }

    /**
     * 控制指定路继电器
     * @return \think\response\Json
     */
    public function controlRelay(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'relay' => 'require|number|>:0',
                'cmd_type' => 'require|in:relay_ctrl,turn_on,turn_off',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        // 直接使用小程序传来的命令类型
        // relay_ctrl: 点动模式
        // turn_on: 锁定模式开启
        // turn_off: 锁定模式关闭
        $sandData = [
            "cmd_type" => $param['cmd_type'],
            "info" =>[
                "relay" => intval($param['relay'])
            ],
        ];

        // 记录操作类型 39=W76F开启继电器，40=W76F关闭继电器
        $type = ($param['cmd_type'] == 'relay_ctrl' || $param['cmd_type'] == 'turn_on') ? 39 : 40;

        $UidRes = MemberServer::Uid();
        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'],$sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'], $member_id, $type, 0, $param['relay']);
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'], $member_id, $type, 1, $param['relay']);
        return json(Code::CodeOk($res));
    }

    /**
     * 生成单路二维码
     * @return \think\response\Json
     */
    public function createQrcode(){
        $param = request()->post();
        try {
            validate([
                'lockauth_id' => 'require',
                'relay_num' => 'require|number|>:0',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        $lock = $this->getLockByAuthId($param['lockauth_id']);
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备授权不存在"));
        }

        // 获取继电器名称
        $relayConfig = Db::name('w76f_relay_config')
            ->where('lock_id', $lock["lock_id"])
            ->where('relay_num', $param['relay_num'])
            ->find();

        $relayName = $relayConfig ? $relayConfig['relay_name'] : "继电器 {$param['relay_num']}";

        // 构建二维码URL，包含relay_num参数
        // 使用与添加设备时相同的URL格式
        $qrcodeUrl = "https://" . $_SERVER['HTTP_HOST'] . "/minilock?user_id=" . $lock['user_id'] . "&lock_id=" . $lock["lock_id"] . "&relay_num={$param['relay_num']}";

        // 生成带名称的二维码图片
        $qrcodeImage = Lock::createmarkqrcode($qrcodeUrl, $relayName);

        if(!$qrcodeImage){
            return json(Code::CodeErr(1000, "生成二维码失败"));
        }

        // 返回完整的图片URL
        $qrcodeImageUrl = request()->domain() . '/qrdata/qrcode/' . basename($qrcodeImage);

        return json(Code::CodeOk([
            "msg" => "生成成功",
            "data" => [
                'qrcode_url' => $qrcodeImageUrl,
                'relay_num' => $param['relay_num'],
                'relay_name' => $relayName,
            ],
        ]));
    }

    /**
     * 获取设备状态
     * @return \think\response\Json
     */
    public function GetSta(){
        $device_sn = trim(input("device_sn"));
        if(empty($device_sn)){
            return json(Code::CodeErr(1000, "device_sn不能为空！"));
        }

        $sandData = [
            "cmd_type" => "get_sta",
            "info" =>[],
        ];

        $res = HardwareCloud::App()::SendData($device_sn,$sandData);
        if ($res["err"]) {
            return json(Code::CodeErr(1000, ($res["err"])));
        }
        return json(Code::CodeOk($res));
    }

    /**
     * 设置设备路数
     * @return \think\response\Json
     */
    public function setRelayCount(){
        $param = request()->post();
        try {
            validate([
                'lockauth_id' => 'require',
                'relay_count' => 'require|number|between:1,16',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        $lock = $this->getLockByAuthId($param['lockauth_id']);
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备授权不存在"));
        }

        // 更新或插入设备路数配置
        $exists = Db::name('w76f_device_config')
            ->where('lock_id', $lock["lock_id"])
            ->find();

        if($exists){
            Db::name('w76f_device_config')
                ->where('lock_id', $lock["lock_id"])
                ->update([
                    'relay_count' => $param['relay_count'],
                    'update_time' => time(),
                ]);
        } else {
            Db::name('w76f_device_config')->insert([
                'lock_id' => $lock["lock_id"],
                'relay_count' => $param['relay_count'],
                'create_time' => time(),
                'update_time' => time(),
            ]);
        }

        return json(Code::CodeOk([
            "msg" => "设置成功",
        ]));
    }

    /**
     * 添加操作记录
     */
    private function getLockByAuthId($lockauthId)
    {
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauthId);
        if (!$lockAuth || empty($lockAuth["lock_id"])) {
            return null;
        }

        $lock = Lock::Info($lockAuth["lock_id"]);
        if (!$lock || empty($lock["lock_id"])) {
            return null;
        }

        return $lock;
    }

    static function AddDeviceLog($device_sn, $member_id, $type, $status = 1, $relay_num = 0){
        $device = Db::name('lock')
            ->where('lock_sn', $device_sn)
            ->whereNull("deleted_at")
            ->find();

        if(!$device){
            return;
        }

        // 获取用户自定义的继电器名称
        $remark = "";
        if ($relay_num > 0) {
            $relayConfig = Db::name('w76f_relay_config')
                ->where('lock_id', $device["lock_id"])
                ->where('relay_num', $relay_num)
                ->find();

            // 优先使用用户配置的名称，如果没有则使用默认名称
            if ($relayConfig && !empty($relayConfig['relay_name'])) {
                $remark = $relayConfig['relay_name'];
            } else {
                // 如果没有配置名称，使用默认格式："第X路"
                $remark = "第".$relay_num."路";
            }
        }

        LockLog::add($member_id, $device["lock_id"], $type, $status, "", "", "", "", $remark);
    }
}
