<?php


namespace app\module\hardwareCloud\deivce;


use app\common\curl\Curl;
use app\module\hardwareCloud\server;

class face
{


    /**
     * @param $device_sn
     * 添加人脸
     */
    public function Add($device_sn, $sCertificateNumber, $picURI, $iEndTime,$face_name="")
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_add",
                "info" => [
                    "sCertificateNumber" => $sCertificateNumber,
                    "picURI" => $picURI,
                    "iEndTime" => (int)$iEndTime,
                    "sName" => $face_name,
                    "iType" => 1,
                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }


        if ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["stateCode"] != 200) {
            if (isset($res["data"]["info"]["stateCode"]) && $res["data"]["info"]["stateCode"] != 203) {


                return ["err" => "添加失败" . $res["data"]["info"]["err_code"] . $res["data"]["info"]["detail"]];
            }

        }

        return ["err" => null, 'res' => $res];
    }

    public function Del($device_sn, $sCertificateNumber)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_del",
                "info" => [
                    "sCertificateNumber" => $sCertificateNumber,

                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }


        if ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["stateCode"] != 200) {


            if (isset($res["data"]["info"]["stateCode"]) && $res["data"]["info"]["stateCode"] != 211) {


                return ["err" => "删除失败" . $res["data"]["info"]["err_code"] . $res["data"]["info"]["detail"],"res"=>$res];
            }


        }

        return ["err" => null, 'res' => $res];
    }


}
