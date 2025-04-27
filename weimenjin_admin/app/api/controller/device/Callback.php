<?php

namespace app\api\controller\device;

use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\LockLog;
use app\module\lockServer\LockCard;
use app\module\redis\Redis;
use app\module\hardwareCloud\server;
use app\module\reqiest\reqiestServer\CurlServer;
use think\facade\Db;
use think\facade\Request;
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
        $device_sn = input("device_sn");
        $lock = Db::name("lock")->where(['lock_sn' => $device_sn])->whereNull("deleted_at")->find();
        Redis::Redis()->set("device_sn:{$cmd}:" . $device_sn, json_encode($info), 360);
        Redis::Redis()->set("device_sntest:{$cmd}:" . $device_sn, file_get_contents("php://input"), 360);
        //在微门禁小程序平台上的设备
        if ($lock) {
            switch ($cmd) {
                case "OnLine":
                    // 更新设备在线状态
                    Db::name("lock")->where(['lock_sn' => $device_sn])->update(["online" => 1, "on_line_time" => $info["time"]]);
                    Db::name("on_line_record")->insert([
                        "device_sn" => $device_sn,
                        "on_line_time" => $info["time"],
                        "cmd" => $cmd,
                    ]);

                    // 更新设备位置信息
                    $this->handleDeviceLocation($device_sn, $info["ipaddress"]);

                    // 准备发送通知的数据
                    $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($lock['lock_id']);
                    $senddata['lock_sn'] = $device_sn;
                    if ((mb_substr($device_sn, 0, 4) == "W894")) {
                        $senddata['lock_name'] = $lock['lock_name'] . "-唤醒";
                        // 从 Redis 中查询是否有缓存的开门请求
                        $cachedData = Redis::Redis()->get("device_sn:open:" . $device_sn);
                        if ($cachedData) {
                            // Redis 中存在开门请求，解析数据获取 tts 和 volume
                            $data = json_decode($cachedData, true);
                            $tts = $data['info']['tts'] ?? '开门';  // 如果没有tts，默认值为 '开门'
                            $volume = (int)($data['info']['volume'] ?? 6);  // 如果没有volume，默认值为 6
                            // 发送开门指令
                            $res = server::Request("send", [
                                "device_cid"=>$lock["device_cid"],
                                "device_sn" => $device_sn,
                                "data" => [
                                    "cmd_type" => "open",
                                    "info" => [
                                        "user_type" => "minipro",
                                        "user_id" => 0,
                                    ],
                                    "data" => [
                                        "user_type" => "minipro",
                                        "user_id" => 0,
                                    ],
                                ],
                            ]);
                            // 根据返回结果记录开门状态
                            if ($res["code"] != 0) {
                                return ["err" => $res["msg"]];
                            }
                            if ($res["data"]["info"]["code"] != 0) {
                                return ["err" => "开门失败" . $res["data"]["info"]["msg"]];
                            }
                            // 成功发送开门指令，删除 Redis 缓存
                            Redis::Redis()->del("device_sn:open:" . $device_sn);
                        }
                    } else {
                        $senddata['lock_name'] = $lock['lock_name'];
                    }
                    $senddata['on_line_time'] = date("Y-m-d H:i", time());

                    // 发送微信消息
                    $miniappconfig = config('my.wxmp');
                    if ($miniappconfig['app_id'] == 'wx7fdcb0b7df1b5439') {
                        $res = wmjSendWechatMsg('donn', $senddata);
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
                    if ((mb_substr($device_sn, 0, 4) == "W894")) {
                        $senddata['lock_name'] = $lock['lock_name'] . "-休眠";
                    } else {
                        $senddata['lock_name'] = $lock['lock_name'];
                    }
                    $senddata['off_line_time'] = date("Y-m-d H:i", time());
                    $miniappconfig = config('my.wxmp');
                    if ($miniappconfig['app_id'] == 'wx7fdcb0b7df1b5439') {
                        $res = wmjSendWechatMsg('dofn', $senddata);
                    } else {

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
                    if (mb_substr($device_sn, 0, 3) == "W77") {
                        $face = Db::name("face")->where(["sCertificateNumber" => $info["sCertificateNumber"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                        if (isset($info['capture_image'])) {
                            $image_data = base64_decode($info['capture_image']);
                            $imgdir = '/upload/captureimages/';
                            $up_loadpath = str_replace('\\', '/', app()->getRootPath() . "\public") . $imgdir;
                            $sub_dir = date('Y/md/');
                            $timenow = time();
                            $rodomnumber = mt_rand(100000, 999999);
                            $filename = $timenow . $rodomnumber . '.jpg';
                            if (!is_dir($up_loadpath . $sub_dir)) {
                                mkdir($up_loadpath . $sub_dir, 0777, true);
                            }
                            $request = Request::instance();
                            $domain = $request->domain();

                            file_put_contents($up_loadpath . $sub_dir . $filename, $image_data);
                            $capture_imageurl = $domain . $imgdir . $sub_dir . $filename;
                            LockLog::add($face["member_id"], $lock["lock_id"], 11, 1, $face["face_name"], $lock["user_id"], $capture_imageurl);
                        } else {
                            LockLog::add($face["member_id"], $lock["lock_id"], 11, 1, $face["face_name"], $lock["user_id"]);
                        }
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
                    if ($lockcard) {
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
                case "power_report":
                    // 获取当天已有的记录（如果有的话）
                    $today_start = date("Y-m-d 00:00:00"); // 当天的开始时间
                    $today_end = date("Y-m-d 23:59:59");   // 当天的结束时间

                    $existing_report = Db::name("switch_daily_report")
                        ->where("device_sn", $info["device_sn"])
                        ->whereBetweenTime("created_at", $today_start, $today_end)
                        ->find();

                    if ($existing_report) {
                        // 如果当天已有记录，更新记录但不更新用电量
                        Db::name("switch_daily_report")
                            ->where("id", $existing_report["id"])
                            ->update([
                                "total_electricity" => (float)$info["total_electricity"],
                                "balance" => (float)$info["balance"],
                                "switch_state" => (int)$info["switch_state"],
                                "heartbeat" => (int)$info["heartbeat"],
                                "voltage" => (float)$info["voltage"],
                                "electric_current" => (float)$info["electric_current"],
                                "power" => (int)$info["power"],
                                "temperature" => (int)$info["temperature"],
                                "prepay" => $info["prepay"],
                                "retainstate" => (int)$info["retainstate"],
                                "updated_at" => time() // 更新记录的时间
                            ]);
                    } else {
                        // 获取上一天的记录，用于计算一天的用电量
                        $previous_report = Db::name("switch_daily_report")
                            ->where("device_sn", $info["device_sn"])
                            ->order("created_at", "desc")
                            ->find();

                        $previous_total_electricity = $previous_report ? (float)$previous_report["total_electricity"] : 0;
                        $today_total_electricity = (float)$info["total_electricity"];

                        // 计算一天的用电量
                        $daily_electricity_usage = $today_total_electricity - $previous_total_electricity;
                        if ($daily_electricity_usage < 0) {
                            $daily_electricity_usage = 0; // 防止负值
                        }

                        // 插入新记录
                        Db::name("switch_daily_report")->insert([
                            "device_sn" => $info["device_sn"],
                            "total_electricity" => $today_total_electricity,
                            "daily_electricity_usage" => $daily_electricity_usage, // 计算用电量
                            "balance" => (float)$info["balance"],
                            "switch_state" => (int)$info["switch_state"],
                            "heartbeat" => (int)$info["heartbeat"],
                            "voltage" => (float)$info["voltage"],
                            "electric_current" => (float)$info["electric_current"],
                            "power" => (int)$info["power"],
                            "temperature" => (int)$info["temperature"],
                            "prepay" => $info["prepay"],
                            "retainstate" => (int)$info["retainstate"],
                            "created" => time() // 插入的时间
                        ]);
                    }
                    break;
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
                            LockLog::add($lock["member_id"], $lock["lock_id"], 4, 1, $lockcard["lockcard_username"] . "(" . $info["open_id"] . ")", $lock["user_id"]);
                            break;
                        //指纹开门
                        case 2:
                            //查询指纹数据
                            $finger = Db::name("finger")->where(["fp_id" => (int)mb_substr($info["open_id"], 0, 2), "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();

                            if (!$finger) {
                                Db::name("finger")->insert([
                                    "fp_id" => (int)mb_substr($info["open_id"], 0, 2),
                                    "lock_id" => $lock["lock_id"],
                                    "created_at" => time(),
                                    "finger_name" => "未命名" . (int)mb_substr($info["open_id"], 0, 2),
                                ]);
                                $finger = Db::name("finger")->where(["fp_id" => (int)mb_substr($info["open_id"], 0, 2), "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                            }
                            LockLog::add($lock["member_id"], $lock["lock_id"], 7, 1, $finger["finger_name"], $lock["user_id"]);
                            break;
                        //固定密码开门
                        case 3:
                            //查询卡数据
                            $pwd = Db::name("pwd")->where(["pwd" => $info["open_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                            $pwd_name = "密码";
                            if ($pwd) {
                                $pwd_name = $pwd["pwd_name"];
                            }
                            LockLog::add($lock["member_id"], $lock["lock_id"], 12, 1, $pwd_name . "(" . $info["open_id"] . ")", $lock["user_id"]);
                            break;
                        //临时密码开门
                        case 4:
                            //查询卡数据
                            $pwd = Db::name("pwd")->where(["pwd" => $info["open_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                            $pwd_name = "临时密码";
                            if ($pwd) {
                                $pwd_name = $pwd["pwd_name"];
                            }
                            LockLog::add($lock["member_id"], $lock["lock_id"], 12, 1, $pwd_name . "(" . $info["open_id"] . ")", $lock["user_id"]);
                            break;
                    }
                    //mlog("lock_open:" . json_encode(input()));
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
        }
        return json(["msg" => "请求成功"]);
    }
}
