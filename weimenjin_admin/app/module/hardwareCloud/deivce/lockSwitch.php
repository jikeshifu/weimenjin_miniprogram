<?php


namespace app\module\hardwareCloud\deivce;


use app\module\hardwareCloud\server;

class lockSwitch
{

    /**
     * @param $device_sn
     * 开
     */
    public static function Open($device_sn, $tts = "开门", $volume = 6)
    {
        // 检查序列号前缀是否为 "W894"
        if (strpos($device_sn, 'W894') === 0) {
            // 将开门请求缓存到 Redis，30 秒过期
            $info = [
                "cmd_type" => "open",
                "info" => [
                    "tts" => $tts,
                    "volume" => (int)$volume,
                ],
            ];
            Redis::Redis()->set("device_sn:open:" . $device_sn, json_encode($info), 30);

            // 直接返回指令已发送
            return ["err" => null, "msg" => "指令已发送，请触摸门锁唤醒开门"];
        }

        // 如果序列号不是 W894 开头，直接发送开门请求
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "open",
                "info" => [
                    "tts" => $tts,
                    "volume" => (int)$volume,
                ],
            ],
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" => "开失败" . $res["data"]["info"]["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }
    /**
     * @param $device_sn
     * 关
     */
 public   static function Close($device_sn,$tts="关门",$volume=6)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "close",
                "info" =>[
                    "tts"=>$tts,
                    "volume"=>(int)$volume,
                ],
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"关失败".$res["data"]["info"]["msg"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
    /**
     * @param $device_sn
     * 停
     */
    public   static function Pause($device_sn,$tts="停止",$volume=6)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "pause",
                "info" =>[
                    "tts"=>$tts,
                    "volume"=>(int)$volume,
                ],
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"关失败".$res["data"]["info"]["msg"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
}
