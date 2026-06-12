<?php

namespace app\api\controller\device;

use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockAuthServer\LockAuth as LockAuthServer;
use app\module\lockServer\LockLog;
use app\module\member\memberServer\MemberServer;
use app\module\model\Lock;
use think\exception\ValidateException;
use think\facade\Db;

class Camera
{
    /**
     * 获取用户token
     * @return \think\response\Json
     */
    public function getToken(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'user_id' => 'require',
                'channel_name' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $result = HardwareCloud::KGCamera()::GetUserToken($param["device_sn"],$param['user_id'],$param['channel_name']);
        if ($result["err"]) {
            return json(Code::CodeErr(1000, ($result["err"])));
        }
        if (!isset($result["data"]["app_id"]) && isset($result["data"]["appId"])) {
            $result["data"]["app_id"] = $result["data"]["appId"];
        }
        if (!isset($result["data"]["app_id"]) && isset($result["data"]["appid"])) {
            $result["data"]["app_id"] = $result["data"]["appid"];
        }

        return json(Code::CodeOk($result));
    }

    /**
     * 设备推流
     * @return \think\response\Json
     */
    public function rtspStart(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }

        $DevTokenRes = HardwareCloud::KGCamera()::GetDeviceToken($param["device_sn"],$param["device_sn"]);
        if ($DevTokenRes["err"]) {
            return json(Code::CodeErr(1000, ($DevTokenRes["err"])));
        }

        $token = $DevTokenRes['data']['token'];
        $video_uid = $DevTokenRes['data']['video_uid'];

        $sandData = [
            "cmd_type" => "rtsp_start",
            "info" =>[
                "token"=>       $token,
                "channel"=>     $param['device_sn'],
                "user_id"=>     $video_uid,
                "out_time"=>    600,
                "client_type"=> 1,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        $result = [
            "device_sn"=>     $param['device_sn'],
            "channel"=>     $param['device_sn'],
            "video_uid"=>     $video_uid,
        ];
        return json(Code::CodeOk($result));
    }

    /**
     * 获取license
     * @param $device_sn
     * @return \think\response\Json
     */
    public static function getLicense($device_sn){
        $Res = HardwareCloud::KGCamera()::GetDeviceLicense($device_sn);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        $license = $Res['data']['license'];
        $sandData = [
            "cmd_type" => "get_lic",
            "info" =>[
                "license"=> $license,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($device_sn["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * PTZ控制
     * @return \think\response\Json
     */
    public function SetPtz(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'axis' => 'require',
                'direction' => 'require',
                'step' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_ptz",
            "info" =>[
                "axis"=> $param['axis'],
                "direction"=> $param['direction'],
                "step"=> $param['step'],
            ],
        ];


        $type = 0;
        switch ($param['direction']) {
            case 1:
                $type = 24;
                break;
            case 2:
                $type = 25;
                break;
            case 3:
                $type = 22;
                break;
            case 4:
                $type = 23;
                break;
        }

        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],$type,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],$type);
        return json(Code::CodeOk($Res));
    }

    /**
     * 静音设置
     * @return \think\response\Json
     */
    public function SetMute(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'mute' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_mute",
            "info" =>[
                "mute"=> (int)$param['mute'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],33,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],33);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置自动夜视模式
     * @return \think\response\Json
     */
    public function SetNightAuto(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'auto' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_night_auto",
            "info" =>[
                "auto"=> (int)$param['auto'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],27,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],27);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置夜视
     * @return \think\response\Json
     */
    public function SetNight(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'is_night' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_night",
            "info" =>[
                "is_night"=> (int)$param['is_night'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],29,1);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],29);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置夜视模式
     * @return \think\response\Json
     */
    public function SetNightMode(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'mode' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_night_mode",
            "info" =>[
                "mode"=> (int)$param['mode'], //1-全彩模式 | 0-红外模式
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],39,1);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],39);
        return json(Code::CodeOk($Res));
    }

    //设置白光照明
    public function SetWLight(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'on' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_w_light",
            "info" =>[
                "on"=> (int)$param['on'], //1-开启白光 | 0-关闭白光
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],40,1);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],40);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置视频旋转
     * @return \think\response\Json
     */
    public function SetRot(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'rot' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_rot",
            "info" =>[
                "rot"=> (int)$param['rot'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 获取配置信息
     * @return \think\response\Json
     */
    public function GetConfig(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'cfg' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "get_cfg",
            "info" =>[
                "cfg"=> $param['cfg'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 获取SD卡状态
     * @return \think\response\Json
     */
    public function GetSdSta(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "get_sd_sta",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }


    /**
     * 设备注册
     * @return \think\response\Json
     */
    public function Register(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $Res = HardwareCloud::App()->Register($param["device_sn"]);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置重启
     * @return \think\response\Json
     */
    public function Reboot(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_reboot",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],30,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],30);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设备renew_token
     * @param $device_sn
     * @param $channle_name
     * @return \think\response\Json
     */
    public static function DevRenewToken($device_sn,$channle_name){
        //第一步：获取设备token
        $DevTokenRes = HardwareCloud::KGCamera()::GetDeviceToken($device_sn,$channle_name);
        if ($DevTokenRes["err"]) {
            return json(Code::CodeErr(1000, ($DevTokenRes["err"])));
        }

        $token = $DevTokenRes['data']['token'];
        $video_uid = $DevTokenRes['data']['video_uid'];

        //发送设备推流
        $sandData = [
            "cmd_type" => "renew_token",
            "info" =>[
                "token"=>       $token,
                "channel"=>     $channle_name,
                "user_id"=>     $video_uid,
                "out_time"=>    600,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($device_sn,$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 获取设备信息
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getDeviceInfo(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $res = Lock::where(["lock_sn"=>$param['device_sn']])->whereNull("deleted_at")->find();
        $res['online'] = HardwareCloud::App()->OnLineGet($param['device_sn']);
        return json(Code::CodeOk($res));
    }

    /**
     * 遥控器列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getRemoteControl(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $result = Db::name("cam_remote_control")->where(['device_sn'=>$param['device_sn']])->whereNull("deleted_at")->select()->toArray();
        return json(Code::CodeOk(["data"=>$result]));
    }

    /**
     * 添加遥控器
     * @return \think\response\Json
     */
    public function addControl(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'member_id' => 'require',
                'title' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }

        $device = Lock::where(["lock_sn"=>$param['device_sn']])->whereNull("deleted_at")->find();

        if(empty($device)){
            return json(Code::CodeErr(1001,"数据出错！"));
        }

        if ($device['member_id'] != $param['member_id']){
            return json(Code::CodeErr(1001,"暂无权限添加遥控器！"));
        }
        $controlCount  = Db::name("cam_remote_control")->where(['device_sn'=>$param['device_sn'],'title'=>$param['title']])->whereNull("deleted_at")->count();
        if($controlCount > 0){
            return json(Code::CodeErr(1001,"遥控器已存在！"));
        }
        $result = Db::name("cam_remote_control")->insert(['device_sn'=>$param['device_sn'],"title"=>$param['title'],"member_id"=>$param['member_id']]);
        self::AddDeviceLog($param['device_sn'],$param['member_id'],31);
        return json(Code::CodeOk(["data"=>$result]));
    }

    /**
     * 删除遥控器
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function delControl(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'member_id' => 'require',
                'control_id' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }

        $device = Lock::where(["lock_sn"=>$param['device_sn']])->whereNull("deleted_at")->find();

        if(empty($device)){
            return json(Code::CodeErr(1001,"数据出错！"));
        }

        if ($device['member_id'] != $param['member_id']){
            return json(Code::CodeErr(1001,"暂无权限删除遥控器！"));
        }

        $ControlCount = Db::name("cam_remote_control")->where(['device_sn'=>$param['device_sn']])->whereNull("deleted_at")->count();
        if($ControlCount == 1){
            return json(Code::CodeErr(1001,"不能删除唯一的遥控器！"));
        }

        $result = Db::name("cam_remote_control")->where(['control_id'=>$param['control_id']])->update(["deleted_at" => date("Y-m-d H:i:s")]);
        self::AddDeviceLog($param['device_sn'],$param['member_id'],32);
        return json(Code::CodeOk(["data"=>$result]));

    }

    /**
     * 遥控器学习
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function controlStudy(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'member_id' => 'require',
                'control_id' => 'require',
                'study_type' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }

        $device = Lock::where(["lock_sn"=>$param['device_sn']])->whereNull("deleted_at")->find();

        if(empty($device)){
            return json(Code::CodeErr(1001,"数据出错！"));
        }

        if ($device['member_id'] != $param['member_id']){
            return json(Code::CodeErr(1001,"暂无权限学习遥控器！"));
        }

        $sandData = [
            "cmd_type" => "rmt_learn",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param['device_sn'],$sandData,60);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],34,0);
            return json(Code::CodeErr(1000, $Res["err"]));
        }



        if(empty($Res['data']['info'])){
            self::AddDeviceLog($param['device_sn'],$param['member_id'],34,0);
            return json(Code::CodeErr(1001, "学习失败"));
        }

        $info = $Res['data']['info'];

        if($info['code'] > 0){
            self::AddDeviceLog($param['device_sn'],$param['member_id'],34,0);
            return json(Code::CodeErr(1003, "学习失败"));
        }

        if($info['rmt_code'] == ""){
            self::AddDeviceLog($param['device_sn'],$param['member_id'],34,0);
            return json(Code::CodeErr(1004, "学习失败"));
        }

        $rmt_code = $info['rmt_code'];

        Db::name("cam_remote_control")->where(['control_id'=>$param['control_id']])->update([$param['study_type']=>$rmt_code]);
        self::AddDeviceLog($param['device_sn'],$param['member_id'],34);
        return json(Code::CodeOk(["data"=>$info]));
    }

    /**
     * 退出学习
     * @return \think\response\Json
     */
    public function controlStudyStop(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "rmt_learn_stop",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param['device_sn'],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, $Res["err"]));
        }

        return json(Code::CodeOk($Res));
    }

    /**
     * 控制rmt
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function controlRmt(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'control_id' => 'require',
                'study_type' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }

        $deviceRmt = Db::name("cam_remote_control")->where(["control_id"=>$param['control_id']])->whereNull("deleted_at")->find();
        if(empty($deviceRmt[$param['study_type']])){
            return json(Code::CodeErr(1000,"请先学习遥控器！"));
        }
        $rmt_code = $deviceRmt[$param['study_type']];
        $sandData = [
            "cmd_type" => "rmt",
            "info" =>[
                "rmt_code" => $rmt_code
            ],
        ];

        $type = 0;
        switch ($param['study_type']) {
            case "open":
                $type = 13;
                break;
            case "close":
                $type = 14;
                break;
            case "stop":
                $type = 15;
                break;
        }

        $Res = HardwareCloud::KGCamera()::SendData($param['device_sn'],$sandData,60);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],$type,0);
            return json(Code::CodeErr(1000, $Res["err"]));
        }

        self::AddDeviceLog($param['device_sn'],$param['member_id'],$type);

        return json(Code::CodeOk($Res));
    }

    /**
     * 切换设备编码格式
     * @return \think\response\Json
     */
    public function switchVideoCodec(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_video_codec",
            "info" =>[
                "codec"=> 0,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }
    /**
     * 获取回放可用时长（按年月获取有录像的日期）
     * @return mixed
     */
    public function getReplayDate(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'month' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "get_replay_date",
            "info" =>[
                "month"=> $param['month'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 获取回放可用时长
     * @return mixed
     */
    public function getReplayTime(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'date' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "get_replay_time",
            "info" =>[
                "date"=> $param['date'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 根据时间戳查询是否有回放文件
     * @return mixed
     */
    public function getReplayFind(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'timestamp' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "replay_find",
            "info" =>[
                "timestamp"=> $param['timestamp'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 格式化SD卡
     * @return mixed
     */
    public function setSdFormat(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_sd_format",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],35,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],35);
        return json(Code::CodeOk($Res));
    }

    /**
     * SD卡安全弹出
     * @return \think\response\Json
     */
    public function SdSafeEject(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "sd_safe_eject",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            self::AddDeviceLog($param['device_sn'],$param['member_id'],41,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$param['member_id'],41);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设备回放推流
     * @return \think\response\Json
     */
    public function replayRtspStart(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'user_id' => 'require',
                'timestamp' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }

        //$DevTokenRes = HardwareCloud::KGCamera()::GetDeviceReplayToken($param["device_sn"],$param["user_id"]);
        $channel = "replay_{$param['device_sn']}_{$param['user_id']}";
        $DevTokenRes = HardwareCloud::KGCamera()::GetDeviceToken($param["device_sn"],$channel);
        if ($DevTokenRes["err"]) {
            return json(Code::CodeErr(1000, ($DevTokenRes["err"])));
        }

        $token = $DevTokenRes['data']['token'];
        $video_uid = $DevTokenRes['data']['video_uid'];

        $sandData = [
            "cmd_type" => "rtsp_replay",
            "info" =>[
                "token"=>       $token,
                "channel"=>     $channel,
                "timestamp"=>     $param['timestamp'],
                "user_id"=>     $video_uid,
                "out_time"=>    600,
                "client_type"=> 1,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        $result = [
            "device_sn"=>     $param['device_sn'],
            "channel"=>     $param['device_sn'],
            "video_uid"=>     $video_uid,
        ];
        return json(Code::CodeOk($result));
    }

    /**
     * 设置 RF 发送次数
     * @return \think\response\Json
     */
    public function setSendLimit(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'set_send_limit' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_send_limit",
            "info" =>[
                "set_send_limit"=> (int)$param['set_send_limit'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * ##### 声光报警(NEW)
     * @return \think\response\Json
     */
    public function setWarning(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'set_warning' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_warning",
            "info" =>[
                "times"=> 1,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * TTS语音播放
     * @return \think\response\Json
     */
    public function ttsPlay(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'text' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "tts_play",
            "info" =>[
                "text"=> $param['text'],
                "speaker"=> $param['speaker'] ?? "prompt_female_high",
                "speed"=> $param['speed'] ?? 1.0,
                "sample_rate"=> $param['sample_rate'] ?? 16000,
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置NN检测框显示
     * @return \think\response\Json
     */
    public function setNnDraw(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'enable' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_nn_draw",
            "info" =>[
                "text"=> $param['text'],
                "enable"=> $param['enable'],

            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 获取NN检测框显示状态
     * @return \think\response\Json
     */
    public function getNnDraw(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "get_nn_draw",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置电机转速
     * @return \think\response\Json
     */
    public function setPtzSpeed(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'speed' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_ptz_speed",
            "info" =>[
                "text"=> $param['text'],
                "speed"=> $param['speed'],

            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置云台位置百分比
     * @return \think\response\Json
     */
    public function setPtzPct(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'x_pct' => 'require',
                'y_pct' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_ptz_pct",
            "info" =>[
                "x_pct"=> $param['x_pct'],
                "y_pct"=> $param['y_pct'],

            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 云台位置复位
     * @return \think\response\Json
     */
    public function resetPtz(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "reset_ptz",
            "info" =>[],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置强光抑制
     * @return \think\response\Json
     */
    public function setHlc(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'hlc' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_hlc",
            "info" =>[
                "hlc" => $param['hlc'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置强光抑制等级
     * @return \think\response\Json
     */
    public function setHlcLevel(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'hlc' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_hlc_level",
            "info" =>[
                "hlc" => (int)$param['hlc'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置红外灯
     * @return \think\response\Json
     */
    public function setIrLight(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'on' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_ir_light",
            "info" =>[
                "on" => (int)$param['on'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置运动检测灵敏度
     * @return \think\response\Json
     */
    public function setMdSens(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'sensitivity' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_md_sens",
            "info" =>[
                "sensitivity" => (int)$param['sensitivity'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 遮挡检测开关
     * @return \think\response\Json
     */
    public function setOd(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'od' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_od",
            "info" =>[
                "od" => (int)$param['od'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 自动维护
     * @return \think\response\Json
     */
    public function setAme(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'enable' => 'require',
                'hour' => 'require',
                'minite' => 'require',
                'repeat' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_ame",
            "info" =>[
                "enable" => (int)$param['enable'],
                "hour" => (int)$param['hour'],
                "minite" => (int)$param['minite'],
                "repeat" => $param['repeat'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    /**
     * 设置心跳上报开关
     * @return \think\response\Json
     */
    public function setHeart(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'on' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $sandData = [
            "cmd_type" => "set_heart",
            "info" =>[
                "on" => (int)$param['on'],
            ],
        ];
        $Res = HardwareCloud::KGCamera()::SendData($param["device_sn"],$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }
    public function setCfg(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        //检查用户权限
        $authResult = self::checkUserAuth($param['device_sn'], $param['member_id'] ?? 0);
        if ($authResult !== true) {
            return $authResult;
        }
        $deviceSn = $param['device_sn'];
        if(count($param) > 1){
            unset($param['device_sn']);
        }else{
            return json(Code::CodeErr(1000,"设置参数不能为空！"));
        }

        $sandData = [
            "cmd_type" => "set_cfg",
            "info" => $param,
        ];
        $Res = HardwareCloud::KGCamera()::SendData($deviceSn,$sandData);
        if ($Res["err"]) {
            //self::AddDeviceLog($param['device_sn'],$param['member_id'],26,0);
            return json(Code::CodeErr(1000, ($Res["err"])));
        }
        //self::AddDeviceLog($param['device_sn'],$param['member_id'],26);
        return json(Code::CodeOk($Res));
    }

    //检查用户权限
    static function checkUserAuth($device_sn,$member_id){
        $lock = Lock::where(["lock_sn"=>$device_sn])->whereNull("deleted_at")->find();
        if (!$lock){
            return json(Code::CodeErr(1000, "设备不存在或未添加，请先在小程序中添加设备"));
        }

        $uidInfo = MemberServer::Uid();
        $requestMemberId = intval($member_id);
        $currentMemberId = intval($uidInfo["uid"] ?? 0);
        $memberIds = [];
        if ($requestMemberId > 0) {
            $memberIds[] = $requestMemberId;
        }
        if ($currentMemberId > 0 && $currentMemberId !== $requestMemberId) {
            $memberIds[] = $currentMemberId;
        }

        if (empty($memberIds)) {
            return json(Code::CodeErr(1000, "您没有权限操作该设备"));
        }

        $lastErr = "";
        foreach ($memberIds as $candidateMemberId) {
            $lockAuth = Db::name("lockauth")
                ->where(["lock_id" => $lock["lock_id"], "member_id" => $candidateMemberId])
                ->where("auth_status", "<>", 0)
                ->whereNull("deleted_at")
                ->order("auth_isadmin", "desc")
                ->order("lockauth_id", "desc")
                ->find();

            if (!$lockAuth){
                continue;
            }

            $verifyRes = LockAuthServer::Verify($lockAuth["lockauth_id"]);
            if ($verifyRes["err"]) {
                $lastErr = $verifyRes["err"];
                continue;
            }
            return true;
        }

        return json(Code::CodeErr(1000, $lastErr ?: "您没有权限操作该设备"));
    }

    //添加操作记录
    static function AddDeviceLog($device_sn,$member_id,$type,$status = 1){
        $device = Lock::where(["lock_sn"=>$device_sn])->whereNull("deleted_at")->find();
        LockLog::add($member_id, $device["lock_id"], $type, $status);
    }

}
