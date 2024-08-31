<?php


namespace app\module\hardwareCloud\deivce;


use app\module\hardwareCloud\server;

class accesscontrol
{

    /**
     * @param $device_sn
     * 配置语音
     */
    static function Configaudio($device_sn,$ttscontent,$volume=5)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_audio",
                "info"=>[
                "pass_tts" =>$ttscontent,
                "no_pass_tts" =>"认证失败",
                "launch_tts" =>"连接成功",
                "volume" => (int)$volume,
            ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"失败".$res["data"]["info"]["err_code"]];
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
                    "inner"=>10,
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
    /*开门函数*/
    static function Unlock($device_sn,$ttscontent="门已打开",$volume=5)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "open",
                "openttscontent" =>$ttscontent,
                "volume" => (int)$volume,
                "info"=>[
                ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] !=0) {
            return ["err" =>"开门结果".$res["data"]["info"]["err_code"],'data'=>$res];
        }
        return ["err" => null,"data"=>$res["data"]];
    }
    /*开门函数*/
    static function SetEs($device_sn,$status)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_es",
                "info"=>[
                    "status" =>$status,
                ]
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] !=0) {
            return ["err" =>"设置结果".$res["data"]["info"]["err_code"],'data'=>$res];
        }
        return ["err" => null,"data"=>$res["data"]];
    }
    /*获取信息*/
    static function GetInfo($device_sn)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "getdevinfo"
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] !=0) {
            return ["err" =>"获取结果".$res["data"]["info"]["err_code"],'data'=>$res];
        }
        return ["err" => null,"data"=>$res["data"]];
    }
}
