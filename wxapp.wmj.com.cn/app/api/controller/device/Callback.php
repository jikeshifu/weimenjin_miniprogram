<?php


namespace app\api\controller\device;

use app\module\lockServer\LockLog;
use app\module\redis\Redis;
use app\module\reqiest\reqiestServer\CurlServer;
use think\facade\Db;

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

        switch ($cmd) {
            case "OnLine";

                Db::name("lock")->where(['lock_sn' => $device_sn])->update(["online" => 1, "on_line_time" => $info["time"]]);
                Db::name("on_line_record")->insert([
                    "device_sn" => $device_sn,
                    "on_line_time" => $info["time"],
                    "cmd" => $cmd,
                ]);
                break;
            case "OffLine";
                Db::name("lock")->where(['lock_sn' => $device_sn,])->update(["online" => 0, "on_line_time" => $info["time"]]);
                Db::name("on_line_record")->insert([
                    "device_sn" => $device_sn,
                    "on_line_time" => $info["time"],
                    "cmd" => $cmd,
                ]);
                break;

            case "dev_reg";
                Db::name("lock")->where(['lock_sn' => $device_sn,])->whereNull("deleted_at")->update([
                    "model_number" => $info["model"],
                    "hardware_version" => $info["hw_ver"],
                    "firmware_version" => $info["sw_ver"],
                    "iccid" => $info["iccid"],
                    "imei" => $info["imei"],
                ]);
                break;

            case "notify";
                //查询人脸
                $face = Db::name("face")->where(["sCertificateNumber" =>$info["sCertificateNumber"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                LockLog::add($face["member_id"], $lock["lock_id"], 11,1, $face["face_name"]);
                break;
            case "card_notify";
                //查询卡
                $lockcard = Db::name("lockcard")->where(["lockcard_sn" =>$info["card_id"], "lock_id" => $lock["lock_id"]])->whereNull("deleted_at")->find();
                LockLog::add($lock["member_id"], $lock["lock_id"], 4, 1,$lockcard["lockcard_username"]);
                break;
            case "open":
            case "lock_open";

                switch ($info["open_type"]) {
                    //指纹开门
                    case 2;
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
                        LockLog::add($lock["member_id"], $lock["lock_id"], 7, 1, $finger["finger_name"]);
                        break;
                }


                Db::name("electricity")->insert([
                    "electricity" => $info["data"],
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

    public function lock1()
    {
        $device_sn = input("device_sn");

        $deviceData = Redis::Redis()->get("device_sn:replystatus1:$device_sn");

        $cs = $deviceData;
        echo "<html
        <head>
        <meta http-equiv=\"refresh\" content=\"1\">
        </head>
        <body>
{$cs}
</body>
</html>";


    }
}
