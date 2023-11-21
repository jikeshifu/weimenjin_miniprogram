<?php


namespace app\module\hardwareCloud\deivce;


use app\module\hardwareCloud\server;

class lockSwitch
{

    /**
     * @param $device_sn
     * 开
     */
   public static function Open($device_sn,$tts="开门",$volume=6)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "open",
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
            return ["err" =>"开失败".$res["data"]["info"]["msg"]];
        }

        return ["err" => null,"data"=>$res["data"]];
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
