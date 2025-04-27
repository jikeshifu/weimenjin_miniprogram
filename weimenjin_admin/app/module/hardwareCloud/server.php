<?php


namespace app\module\hardwareCloud;


use app\common\curl\Curl;

class server
{
    /**
     * @param $device_sn
     * 注册设备
     */
    public function Register($device_sn)
    {
        $res = self::Request("register", ["device_sn" => $device_sn]);
        if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null,"msg"=>$res["msg"]];
    }
  /**
     * @param $device_sn
     * 设置二维码
     */
    public function QrCodeSet($device_sn,$qrcode_data)
    {
        $res = self::Request("send", [
            "device_sn" => $device_sn,
            "data"=>[
                "cmd_type"=>"set_qrcode",
                "info"=>[
                    "qrcode_data"=>$qrcode_data,
                    "qrcode"=>$qrcode_data,
                    "mode"=>"passive",
                    "update_time"=>10,
                ],
            ]
        ]);
        if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"]];
        }


        return ["err" => null];
    }

    /**
     * @param $device_sn
     * 获取设备在线状态
     */
    public function OnLineGet($device_sn)
    {
        $res = self::Request("getOnLine", ["device_sn" => $device_sn]);
        if ($res["code"] != 0) {
            return 0;
        }


        return $res["data"]["on_line"];
    }
    /**
     * @param $device_sn
     * 获取设备信息
     */
    public function getDeviceInfo($device_sn)
    {
        $res = self::Request("getDeviceInfo", ["device_sn" => $device_sn]);
        if ($res["code"] != 0) {
            return 0;
        }
        return $res["data"];
    }
    /**
     * @param $device_sn
     * 设置二维码
     */
    public function QrSet($device_sn,$qr,$mode ="passive")
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => "set_qrcode",
                "info" => [
                    "qrcode" =>$qr,
                    "qrcode_data" =>$qr,
                    "mode" =>$mode,

                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"]];
        }

        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>$res["data"]["info"]["msg"],"msg"=>$res];
        }

        return ["err" => null];
    }
    /**
     * @param $device_sn
     * 重启设备
     */
    public function Restart($device_sn)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd" => "restart",
                "cmd_type" => "restart",
                "info" => [
                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"重启失败".$res["data"]["info"]["err_code"]];
        }

        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>$res["data"]["info"]["msg"],"msg"=>$res];
        }

        return ["err" => null];
    }
    /**
     * @param $device_sn
     * 应用端注册设备
     */
    public function Appreg($device_sn)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd" => "appreg",
                "cmd_type" => "appreg",
                "info" => [
                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"注册失败".$res["data"]["info"]["err_code"]];
        }

        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>$res["data"]["info"]["msg"],"msg"=>$res];
        }

        return ["err" => null];
    }
  /**
     * @param $device_sn
     * 设置发卡模式
     */
    public function CardModeSet($device_sn,$state =0)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => "device_add_card",
                "info" => [
                    "state" =>$state,


                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>$res["data"]["info"]["msg"],"msg"=>$res];
        }
        return ["err" => null];
    }
    /*开门函数*/
    static function GetDevInfo($device_sn,$ttscontent="门已打开",$volume=5)
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
    /**
     * @param $device_sn
     * 设置发卡模式
     */
    public function NoNcModeSet($device_sn,$state =0)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [

                "cmd_type" => "set_nonc",
                "data" => [
                    "type" =>$state,
                ],
                "info" => [
                    "type" =>$state,
                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>$res["data"]["info"]["msg"],"msg"=>$res];
        }
        return ["err" => null];
    }
    public function cpimgModeSet($device_sn,$state =0)
    {
        $status="disable";
        if($state==1)
        {
            $status="enable";
        }else
        {
            $status="disable";
        }
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "device_info_set",
                "info" => [
                    "face_capture_func" =>$status,
                    "face_capture_width"=>"400",
                    "face_capture_height"=>"640"
                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"]];
        }
        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>$res["data"]["info"]["msg"],"msg"=>$res];
        }
        return ["err" => null];
    }
    /**
     * @param $path
     * @param array $data
     * @return int|mixed|string
     * 请求
     */
    public static function Request($path, $data = [])
    {
        $data["app_id"] = serverConfig::GetAppId();
        $data["app_secret"] =  serverConfig::GetAppSecret();
        $res = Curl::PostJson(serverConfig::GetUrl() . $path, $data);

        return $res;
    }
    /**
     * 注销设备
     */

    public function Logout($device_sn)
    {
        if (mb_substr($device_sn, 0, 3) == "W77"||mb_substr($device_sn, 0, 4) == "W766"||mb_substr($device_sn, 0, 4) == "W765") {
            $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "card_clr",
                "info" => [],
            ]
            ]);
            $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_qrcode",
                "info" => ["qrcode" =>$device_sn,
                    "mode" =>"both",
                    ],
            ]
            ]);
            if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"]];
            }
        }
        if (mb_substr($device_sn, 0, 4) == "W766") {
            $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "pwd_clr",
                "info" => [],
            ]
            ]);
            if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"]];
            }
        }
        if (mb_substr($device_sn, 0, 3) == "W77") {
            $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_clr",
                "info" => [],
            ]
            ]);
            if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"]];
            }
        }
        $res = self::Request("logout", ["device_sn" => $device_sn]);
        if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null];
    }



}
