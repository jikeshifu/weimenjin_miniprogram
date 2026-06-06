<?php

namespace app\api\controller\device;

use app\api\controller\Base;
use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\LockLog;
use app\module\member\memberServer\MemberServer;
use app\module\model\Lock;
use think\exception\ValidateException;

class Switch4G extends Base
{
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
     * 通用控制方法，开关停
     * @return \think\response\Json
     */
    public function Operation(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'cmd_type' => 'require',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }
        $cmdType = ['open','close','stop'];
        if(!in_array($param['cmd_type'],$cmdType)){
            return json(Code::CodeErr(1000, "参数错误！"));
        }

        $sandData = [
            "cmd_type" => $param['cmd_type'],
            "info" =>[],
        ];

        $type = 0;
        switch ($param['cmd_type']) {
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

        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'],$sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'],$member_id,$type,0);
            return json(Code::CodeErr(1000, ($res["err"])));
        }
        self::AddDeviceLog($param['device_sn'],$member_id,$type);
        return json(Code::CodeOk($res));

    }

    /**
     * 通用锁止方法  开关停 锁止
     * @return \think\response\Json
     */
    public function Lockup(){
        $param = request()->post();
        try {
            validate([
                'device_sn' => 'require',
                'cmd_type' => 'require',
                'enable' => 'require|in:0,1',
            ])->check($param);
        }catch (ValidateException $e){
            return json(Code::CodeErr(1000,$e->getError()));
        }

        $cmdType = ['open_lockup','close_lockup','stop_lockup'];
        if(!in_array($param['cmd_type'],$cmdType)){
            return json(Code::CodeErr(1000, "参数错误！"));
        }
        $sandData = [
            "cmd_type" => $param['cmd_type'],
            "info" =>[
                "enable" => $param['enable']
            ],
        ];

        $type = 0;
        switch ($param['cmd_type']) {
            case "open_lockup":
                $type = 19;
                break;
            case "close_lockup":
                $type = 20;
                break;
            case "stop_lockup":
                $type = 21;
                break;
        }

        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];

        $res = HardwareCloud::App()::SendData($param['device_sn'],$sandData);
        if ($res["err"]) {
            self::AddDeviceLog($param['device_sn'],$member_id,$type,0);
            return json(Code::CodeErr(1000, ($res["err"])));
        }

        self::AddDeviceLog($param['device_sn'],$member_id,$type);
        return json(Code::CodeOk($res));

    }

    //添加操作记录
    static function AddDeviceLog($device_sn,$member_id,$type,$status = 1){
        $device = Lock::where(["lock_sn"=>$device_sn])->whereNull("deleted_at")->find();
        if (!$device) {
            return;
        }
        LockLog::add($member_id, $device["lock_id"], $type, $status);
    }
}
