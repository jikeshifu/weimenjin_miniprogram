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

    static function Play($device_sn,$ttscontent,$volume=5,$speaker='prompt_female_high',$number_mode='digit')
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => "play",
                "info"=>[
                    "tts" =>$ttscontent,
                    //"inner"=>10,
                    "volume" => (int)$volume,
                    "speaker" => $speaker,
                    "number_mode" => $number_mode,
                ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        $info = $res["data"]["info"] ?? [];
        if (($info["code"] ?? 0) != 0) {
            return ["err" =>"播放语音".($info["err_code"] ?? ($info["msg"] ?? "")),'data'=>$res];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
    static function LoopPlay($device_sn,$ttscontent,$volume=5,$loopcmd='loop_play',$loopInterval=0,$speaker='prompt_female_high',$number_mode='digit')
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => $loopcmd,
                "info"=>[
                    "tts" =>$ttscontent,
                    "inner"=>10,
                    "volume" => (int)$volume,
                    "interval"=>$loopInterval,
                    "speaker" => $speaker,
                    "number_mode" => $number_mode,
                ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        $info = $res["data"]["info"] ?? [];
        if (($info["code"] ?? 0) != 0) {
            return ["err" =>"播放语音".($info["err_code"] ?? ($info["msg"] ?? "")),'data'=>$res];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
}
