<?php

namespace app\api\controller\device;

use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\LockLog;
use app\module\lockServer\LockCard;
use app\module\redis\Redis;
use app\module\reqiest\reqiestServer\CurlServer;
use think\facade\Db;
use app\module\lock\LockNotice;

class Callback
{
    public function lock()
    {
        $cmd = input("cmd");
        if (!$cmd) {
            $cmd = input("cmd_type");
        }
        $info = input("info");
        //mlog("Callback_Input:" . json_encode(input()));
        $device_sn = input("device_sn");
        $lock = Db::name("lock")->where(['lock_sn' => $device_sn])->whereNull("deleted_at")->find();
        Redis::Redis()->set("device_sn:{$cmd}:" . $device_sn, json_encode($info), 360);
        Redis::Redis()->set("device_sntest:{$cmd}:" . $device_sn, file_get_contents("php://input"), 360);
        switch ($cmd) {
            case "OnLine":
                Db::name("lock")->where(['lock_sn' => $device_sn])->update(["online" => 1, "on_line_time" => $info["time"]]);
                Db::name("on_line_record")->insert([
                    "device_sn" => $device_sn,
                    "on_line_time" => $info["time"],
                    "cmd" => $cmd,
                ]);
                //mlog("Callback_Input:" . json_encode(input()));
                //发通知
                $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($lock['lock_id']);
                $senddata['lock_sn'] = $device_sn;
                $senddata['lock_name'] = $lock['lock_name'];
                $senddata['on_line_time'] = date("Y-m-d H:i",time());
                $miniappconfig=config('my.mini_program');
                if ($miniappconfig['app_id']=='wx7fdcb0b7df1b5439') {
                    $res = wmjSendWechatMsg('donn', $senddata);
                }
                else
                {

                }
                break;
            case "OffLine":
                Db::name("lock")->where(['lock_sn' => $device_sn,])->update(["online" => 0, "on_line_time" => $info["time"]]);
                Db::name("on_line_record")->insert([
                    "device_sn" => $device_sn,
                    "on_line_time" => $info["time"],
                    "cmd" => $cmd,
                ]);
                $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($lock['lock_id']);
                $senddata['lock_sn'] = $device_sn;
                $senddata['lock_name'] = $lock['lock_name'];
                $senddata['off_line_time'] = date("Y-m-d H:i",time());
                $miniappconfig=config('my.mini_program');
                if ($miniappconfig['app_id']=='wx7fdcb0b7df1b5439') {
                    $res = wmjSendWechatMsg('dofn', $senddata);
                }
                else
                {

                }
                break;

            case "dev_reg":
                // 基础更新数组
                $updateData = [
                    "model_number" => $info["model"],
                    "hardware_version" => $info["hw_ver"],
                    "firmware_version" => $info["sw_ver"],
                    "rssi" => $info["rssi"],
                    "iccid" => $info["iccid"],
                    "imei" => $info["imei"],
                ];
                // 如果$info["volt"]不为空，则添加到更新数组中
                if (!empty($info["volt"])) {
                    $updateData["batterypower"] = $info["volt"];
                    Db::name("power")->insert([
                    "batterypower" => $info["volt"],
                    "created_at" => time(),
                    "device_sn" => $device_sn,
                    ]);
                }
                //mlog("Callback_Input:" . json_encode(input()));
                // 执行更新操作
                Db::name("lock")->where(['lock_sn' => $device_sn,])->whereNull("deleted_at")->update($updateData);
                break;

            case "notify":
                //人脸设备记录日志
                if (mb_substr($device_sn,0,3)=="W77")
                {
                    $face = Db::name("face")->where(["sCertificateNumber" => $info["sCertificateNumber"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                    LockLog::add($face["member_id"], $lock["lock_id"], 11, 1, $face["face_name"], $lock["user_id"]);
                }
                break;
            case "card_notify":
                //查询卡
                $lockcard = Db::name("lockcard")->where(["lockcard_sn" => $info["card_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                LockLog::add($lock["member_id"], $lock["lock_id"], 4, 1, $lockcard["lockcard_username"], $lockcard["user_id"]);
                break;
            case "add_card_notify":
                //发卡模式添加卡
                $lockcard = Db::name("lockcard")->where(["lockcard_sn" => $info["card_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                if($lockcard) {
                    Db::name("lockcard")->where(["lockcard_sn" => $info["card_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->update([
                        "lockcard_endtime" => $info["end_time"],
                    ]);
                } else {
                    LockCard::add($info["card_id"], $lock["lock_id"], $info["end_time"]);
                }

                break;
            case "open_notify":
                if ($info["type"] == "card") {
                    //查询卡
                    $lockcard = Db::name("lockcard")->where(["lockcard_sn" => $info["data"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                    LockLog::add($lock["member_id"], $lock["lock_id"], 4, 1, $lockcard["lockcard_username"], $lock["user_id"]);

                }
                break;
            case "door_state_notify":
                Db::name("lock")->where(['lock_sn' => $device_sn])->whereNull("deleted_at")->update(["switch_state" => $info["state"]]);
                break;
            case "open":
            case "lock_open":
                switch ($info["open_type"]) {
                    //刷卡开门
                    case 1:
                        //查询卡数据
                        $lockcard = Db::name("lockcard")->where(["lockcard_sn" => $info["open_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();

                        if (!$lockcard) {
                            Db::name("lockcard")->insert([
                                "lockcard_sn" => $info["open_id"],
                                "lock_id" => $lock["lock_id"],
                                "lockcard_createtime" => time(),
                                "lockcard_username" => "未命名" . $info["open_id"],
                            ]);
                            $lockcard = Db::name("lockcard")->where(["lockcard_sn" => $info["open_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                        }
                        LockLog::add($lock["member_id"], $lock["lock_id"], 4, 1, $lockcard["lockcard_username"]."(".$info["open_id"].")", $lock["user_id"]);
                        break;
                    //指纹开门
                    case 2:
                        //查询指纹数据
                        $finger = Db::name("finger")->where(["fp_id" => (int) mb_substr($info["open_id"], 0, 2), "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();

                        if (!$finger) {
                            Db::name("finger")->insert([
                                "fp_id" => (int) mb_substr($info["open_id"], 0, 2),
                                "lock_id" => $lock["lock_id"],
                                "created_at" => time(),
                                "finger_name" => "未命名" . (int) mb_substr($info["open_id"], 0, 2),
                            ]);
                            $finger = Db::name("finger")->where(["fp_id" => (int) mb_substr($info["open_id"], 0, 2), "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                        }
                        LockLog::add($lock["member_id"], $lock["lock_id"], 7, 1, $finger["finger_name"], $lock["user_id"]);
                        break;
                    //固定密码开门
                    case 3:
                        //查询卡数据
                        $pwd = Db::name("pwd")->where(["pwd" => $info["open_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                        $pwd_name="密码";
                        if ($pwd) {
                            $pwd_name=$pwd["pwd_name"];
                        }
                        LockLog::add($lock["member_id"], $lock["lock_id"], 12, 1, $pwd_name."(".$info["open_id"].")", $lock["user_id"]);
                        break;
                    //临时密码开门
                    case 4:
                        //查询卡数据
                        $pwd = Db::name("pwd")->where(["pwd" => $info["open_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                        $pwd_name="临时密码";
                        if ($pwd) {
                            $pwd_name=$pwd["pwd_name"];
                        }
                        LockLog::add($lock["member_id"], $lock["lock_id"], 12, 1, $pwd_name."(".$info["open_id"].")", $lock["user_id"]);
                        break;
                }
                mlog("lock_open:" . json_encode(input()));
                Db::name("power")->insert([
                    "batterypower" => $info["data"],
                    "created_at" => time(),
                    "device_sn" => $device_sn,
                ]);
                if ($info["data"] && $info["data"] > 0) {
                    Db::name("lock")->where(['lock_sn' => $device_sn])->update(["batterypower" => $info["data"]]);
                }
                break;
        }
        $upData = [];
        if (isset($info["wifi_rssi"])) {
            $upData["wifi_rssi"] = $info["wifi_rssi"];
        }
        if ($upData) {
            Db::name("lock")->where(['lock_sn' => $device_sn])->update($upData);
        }
        return json(["msg" => "请求成功"]);
    }

}
