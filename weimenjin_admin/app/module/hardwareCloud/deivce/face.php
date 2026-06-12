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
                    "face_id" => $sCertificateNumber,
                    "picURI" => $picURI,
                    "img_url" => $picURI,
                    "iEndTime" => (int)$iEndTime,
                    "sName" => $face_name,
                    "name" => $face_name,
                    "iType" => 1,
                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"],"res"=>$res];
        }

        // 获取 stateCode
        $stateCode = $res["data"]["info"]["stateCode"] ?? 0;

        // 203 表示人脸已存在，不视为错误，返回给调用方处理
        if ($stateCode == 203) {
            return ["err" => null, 'res' => $res];
        }

        if (isset($res["data"]["info"]["code"]) && $res["data"]["info"]["code"]  != 0 ) {
            return ["err" => "添加失败" . $res["data"]["info"]["code"] . $res["data"]["info"]["detail"],"res"=>$res];
        }

        if (isset($res["data"]["info"]["err_code"]) && ($res["data"]["info"]["err_code"] != 0 || $stateCode != 200)) {
            return ["err" => "添加失败" . $res["data"]["info"]["err_code"] . $res["data"]["info"]["detail"],"res"=>$res];
        }

        return ["err" => null, 'res' => $res];
    }
    /**
     * @param $device_sn
     * 添加人脸
     */
    public function AddFeature($device_sn, $sCertificateNumber, $feature, $iEndTime,$face_name="")
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_add",
                "info" => [
                    "sCertificateNumber" => $sCertificateNumber,
                    "face_id" => $sCertificateNumber,
                    "feature" => $feature,
                    "iEndTime" => (int)$iEndTime,
                    "sName" => $face_name,
                    "name" => $face_name,
                    "iType" => 1,
                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"],"res"=>$res];
        }
        if (isset($res["data"]["info"]["code"]) && $res["data"]["info"]["code"]  != 0 ) {

            if (isset($res["data"]["info"]["stateCode"]) && $res["data"]["info"]["stateCode"] != 203) {

                return ["err" => "添加失败" . $res["data"]["info"]["code"] . $res["data"]["info"]["detail"],"res"=>$res];

            }


        }

        if (isset($res["data"]["info"]["err_code"]) && ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["stateCode"] != 200)) {

            return ["err" => "添加失败" . $res["data"]["info"]["err_code"] . $res["data"]["info"]["detail"],"res"=>$res];
        }

        return ["err" => null, 'res' => $res];
    }
    public function Del($device_sn, $face_id)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_del",
                "info" => [
                    "face_id" => $face_id,
                    "sCertificateNumber" => $face_id,
                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"], "res" => $res];
        }


        if (isset($res["data"]["info"]["err_code"]) && ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["stateCode"] != 200)) {


            if (isset($res["data"]["info"]["stateCode"]) && $res["data"]["info"]["stateCode"] != 211) {


                return ["err" => "删除失败" . $res["data"]["info"]["err_code"] . $res["data"]["info"]["detail"],"res"=>$res];
            }


        }

        return ["err" => null, 'res' => $res];
    }

    /**
     * 编辑人脸信息（更新过期时间等）
     * @param string $device_sn 设备SN
     * @param string $face_id 人脸ID
     * @param int $end_time 过期时间戳
     * @param string $face_name 人脸名称
     * @param string $phone_number 手机号（可选）
     */
    public function Edit($device_sn, $face_id, $end_time, $face_name = "", $phone_number = "")
    {
        $info = [
            "face_id" => $face_id,
            "sCertificateNumber" => $face_id,  // 同时传递两个字段确保兼容
            "name" => $face_name,
            "sName" => $face_name,
            "start_time" => 0,
            "iBeginTime" => 0,
            "end_time" => (int)$end_time,
            "iEndTime" => (int)$end_time,
        ];

        if (!empty($phone_number)) {
            $info["phone_number"] = $phone_number;
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_edit",
                "info" => $info,
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"], "res" => $res];
        }

        if (isset($res["data"]["info"]["stateCode"]) && $res["data"]["info"]["stateCode"] != 200) {
            $errCode = $res["data"]["info"]["err_code"] ?? $res["data"]["info"]["code"] ?? "";
            $detail = $res["data"]["info"]["detail"] ?? "编辑失败";
            return ["err" => "编辑失败: {$errCode} {$detail}", "res" => $res];
        }

        return ["err" => null, 'res' => $res];
    }

//清空人脸
    public function Clear($device_sn)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_clr",
                "info" => [
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

    // 查询人脸信息
    public function Find($device_sn, $face_id)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_find",
                "info" => [
                    "face_id" => $face_id,
                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"], "res" => $res];
        }

        // 检查返回的状态码
        if (isset($res["data"]["info"]["stateCode"]) && $res["data"]["info"]["stateCode"] != 200) {
            $errMsg = "查询失败";
            if ($res["data"]["info"]["stateCode"] == 211) {
                $errMsg = "人脸不存在";
            }
            return ["err" => $errMsg, "res" => $res];
        }

        return ["err" => null, 'res' => $res];
    }

    /**
     * 获取设备上的所有人脸列表
     */
    public function GetList($device_sn)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_find_all",
                "info" => [],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"], "res" => $res];
        }

        if (isset($res["data"]["info"]["err_code"]) && $res["data"]["info"]["err_code"] != 0) {
            return ["err" => "查询失败" . $res["data"]["info"]["err_code"] . ($res["data"]["info"]["detail"] ?? ''), "res" => $res];
        }

        return ["err" => null, 'res' => $res];
    }

    /**
     * 获取设备上所有人脸的详细信息（包含过期时间）
     */
    public function GetListWithTime($device_sn)
    {
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "face_find_alltime",
                "info" => [],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"], "res" => $res];
        }

        if (isset($res["data"]["info"]["err_code"]) && $res["data"]["info"]["err_code"] != 0) {
            return ["err" => "查询失败" . $res["data"]["info"]["err_code"] . ($res["data"]["info"]["detail"] ?? ''), "res" => $res];
        }

        return ["err" => null, 'res' => $res];
    }


}
