<?php


namespace app\module\hardwareCloud\deivce;


use app\module\hardwareCloud\server;

class horn
{

    /**
     * @param $device_sn
     * 扬声器
     */
    static function Cloudspeaker($device_sn,$ttscontent,$volume=5)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd" => "cloudspeaker",
                "ttscontent" =>$ttscontent,
                "volume" => $volume,
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["status"] != 1) {
            return ["err" =>"开锁失败".$res["data"]["info"]["err_code"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }

    static function Play($device_sn,$ttscontent,$volume=5)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => "play",
                "info"=>[
                    "tts" =>$ttscontent,
                    //"inner"=>10,
                    "volume" => (int)$volume,
                ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] !=0) {
            return ["err" =>"播放语音".$res["data"]["info"]["err_code"],'data'=>$res];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
    static function LoopPlay($device_sn,$ttscontent,$volume=5,$loopcmd,$loopInterval)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => $loopcmd,
                "info"=>[
                    "tts" =>$ttscontent,
                    "inner"=>10,
                    "volume" => (int)$volume,
                    "interval"=>$loopInterval
                ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] !=0) {
            return ["err" =>"播放语音".$res["data"]["info"]["err_code"],'data'=>$res];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
}
