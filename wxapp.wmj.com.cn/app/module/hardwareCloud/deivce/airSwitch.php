<?php


namespace app\module\hardwareCloud\deivce;


use app\module\hardwareCloud\server;

class airSwitch
{

    /**
     * @param $device_sn
     * 开电
     */
    static function ElectricityStart($device_sn)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "turnon",

            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"开电失败".$res["data"]["info"]["msg"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
    /**
     * @param $device_sn
     * 关电
     */
    static function ElectricityStop($device_sn)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "turnoff",

            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"关电失败".$res["data"]["info"]["msg"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }  /**
 * @param $device_sn
 * 获取信息
 */
    static function Getdevinfo($device_sn)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "getdevinfo",

            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"获取失败".$res["data"]["info"]["msg"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }
}
