<?php


namespace app\module\hardwareCloud\deivce;


use app\common\curl\Curl;
use app\module\hardwareCloud\server;
use app\module\redis\Redis;

class wifiLock
{



    /**
     * @param $device_sn
     * 激活设备
     */
  public   function Activate($device_sn)
    {
        $device_cid = date("ymdHis", time()) . rand(10000000, 99999999);
        $admin_pwd = "0".rand(10000, 49999);
        $device_cid = "88888888888888888888";
        $admin_pwd = "012345";

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=> "FFFFFFFFFFFFFFFFFFFF",
                "cmd_type" => "active",
                "data" => [
                    "admin_pwd" =>$admin_pwd,
                    "device_cid" =>$device_cid,
                ],
            ]
        ]);
        if(!isset($res["code"])){
            return ["err" => "激活失败"];
        }
        if ($res["code"] == 102 || $res["code"] == 1002|| $res["code"] == 1000) {
            return ["err" => $res["msg"]];
        }

        return [
            "err" => null,
            "device_cid"=>$device_cid,
            "admin_pwd"=>$admin_pwd,
        ];
    }

    /**
     * @param $device_sn
     * 设备开锁
     */
    public function OpenLock($device_sn,$device_cid)
    {
        if (strpos($device_sn, 'W894') === 0) {
            // 将开门请求缓存到 Redis，30 秒过期
            $info = [
                "cmd_type" => "open",
                "info" => [
                    "sn" => $device_sn
                ],
            ];
            Redis::Redis()->set("device_sn:open:" . $device_sn, json_encode($info), 3600);
            $res["data"]["info"]["code"]=0;
            $res["data"]["info"]["err_code"]=0;
            $res["data"]["info"]["msg"]="指令已发送，请触摸门锁唤醒开门";
            // 直接返回指令已发送
            return ["err" => null, "msg" => "指令已发送，请触摸门锁唤醒开门","data"=>$res["data"]];
        }
        $W82data=[
            "cmd"=>"unlock",
            "delaytime"=>"1000",
            "openttscontent"=>"门已打开",
            "volume"=>5,
        ];
        $w89Data= [
            "device_cid"=>$device_cid,
            "cmd_type" => "open",
            "data" => [
                "user_type" => "minipro",
                "user_id" => 0,
            ],
            "info" => [
                "sn" =>$device_sn,

            ],
        ];
        $sendData =$w89Data;
        if(mb_substr($device_sn,0,3)=="W82"){
            $sendData=$W82data;
        }
        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => $sendData,
        ]);



        if ($res["code"] != 0) {
            return ["err" => $res["msg"],"errRes"=>$res];
        }
        if ($res["data"]["info"]["err_code"] != 0) {
            return ["err" =>"开锁失败".$res["data"]["info"]["err_code"]];
        }

        return ["err" => null,"data"=>$res["data"]];
    }

    /**
     * @param $device_sn
     * 添加卡
     */
    public function CardAdd($device_sn,$card_sn,$device_cid,$start_time,$endTime)
    {
        $res="";
        try{

            $res = server::Request("send", [
                "device_sn" => $device_sn,
                "data" => [
                    "device_cid"=>$device_cid,
                    "cmd_type" => "card_add",
                    "data" => [
                        "card_id" =>$card_sn,

                        "card_type" => 0,
                        "user_id" => 0,
                        "start_time" => (int)$start_time,
                        "end_time" => (int)$endTime,
                    ],   "info" => [
                        "card_id" =>$card_sn,
                        "card_type" => 0,
                        "user_id" => 0,
                        "start_time" => (int)$start_time,
                        "end_time" => (int)$endTime,
                    ],
                ]
            ]);

            if ($res["code"] != 0) {
                return ["err" => $res["msg"]];
            }

            if ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["code"] !=0) {
                if($res["data"]["info"]["code"] !=17){
                    return ["err" =>"添加失败".$res["data"]["info"]["err_code"].$res["data"]["info"]["msg"]];
                }

            }
        }catch(\Exception $e){
           print_r($e->getMessage());
           print_r($res);

        }


        return ["err" => null,"res"=>$res];
    }

    /**
     * @param $device_sn
     * 添加卡
     */
    public function CardEdit($device_sn,$card_sn,$device_cid,$start_time,$endTime)
    {
        $res="";
        try{

            $res = server::Request("send", [
                "device_sn" => $device_sn,
                "data" => [
                    "device_cid"=>$device_cid,
                    "cmd_type" => "card_edit",
                    "data" => [
                        "card_id" =>$card_sn,

                        "card_type" => 0,
                        "user_id" => 0,
                        "start_time" => (int)$start_time,
                        "end_time" => (int)$endTime,
                    ],   "info" => [
                        "card_id" =>$card_sn,

                        "card_type" => 0,
                        "user_id" => 0,
                        "start_time" => (int)$start_time,
                        "end_time" => (int)$endTime,
                    ],
                ]
            ]);

            if ($res["code"] != 0) {
                return ["err" => $res["msg"]];
            }

            if ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["code"] !=0) {
                if($res["data"]["info"]["code"] !=17){
                    return ["err" =>"编辑失败".$res["data"]["info"]["err_code"].$res["data"]["info"]["msg"]];
                }

            }
        }catch(\Exception $e){
           print_r($e->getMessage());
           print_r($res);

        }


        return ["err" => null,"res"=>$res];
    }

    /**
     * @param $device_sn
     * 删除卡
     */
    public function CardDel($device_sn,$card_sn,$device_cid)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "card_del",
                "data" => [
                    "card_id" =>$card_sn,

                    "user_id" => 0,

                ], "info" => [
                    "card_id" =>$card_sn,

                    "user_id" => 0,

                ],
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 || $res["data"]["info"]["code"] != 0) {

            if($res["data"]["info"]["code"] != 19 &&$res["data"]["info"]["err_code"] != 19){
                return ["err" =>"删除失败".$res["data"]["info"]["err_code"],"data"=>$res];
            }

        }

        return ["err" => null,"data"=>$res];
    }

    /**
     * @param $device_sn
     * 添加指纹
     */
    public function FingerAdd($device_sn,$device_cid,$start_time,$endTime)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "time_out"=>60,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "fp_add",
                "data" => [

                    "start_time" => (int)$start_time,
                    // "end_time" => (int)$endTime,
                ],
            ]
        ]);
        if (!isset($res["code"]) ){
            return ["err" =>"添加失败"];
        }
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0  || $res["data"]["info"]["code"] != 0) {
            return ["err" =>"添加失败".$res["data"]["info"]["err_code"]];
        }

        return ["err" => null,"info"=>$res["data"]["info"]];
    }
    /**
     * @param $device_sn
     * 编辑指纹
     */
    public function FingerEdit($device_sn,$device_cid,$fp_id,$start_time,$endTime)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,

            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "fp_edit",
                "data" => [

                    "fp_id" => $fp_id,
                    "start_time" => (int)$start_time,
                    // "end_time" => (int)$endTime,
                ],
            ]
        ]);
        if (!isset($res["code"]) ){
            return ["err" =>"添加失败"];
        }
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"添加失败".$res["data"]["info"]["err_code"]];
        }

        return ["err" => null,"info"=>$res["data"]["info"]];
    }
    /**
     * @param $device_sn
     * 删除指纹
     */
    public function FingerDel($device_sn,$fp_id,$device_cid)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "fp_del",
                "data" => [
                    "fp_id" =>$fp_id,

                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"],"res"=>$res];
        }
        if ($res["data"]["info"]["err_code"] != 0 &&$res["data"]["info"]["err_code"] != 18 ) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"],"res"=>$res];
        }

        return ["err" => null];
    }
    /**
     * @param $device_sn
     * 清空指纹
     */
    public function FingerClear($device_sn,$device_cid)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "fp_clr",
                "data" => [],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"],"res"=>$res];
        }
        if ($res["data"]["info"]["err_code"] != 0 &&$res["data"]["info"]["err_code"] != 18 ) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"],"res"=>$res];
        }

        return ["err" => null];
    }
    /**
     * @param $device_sn
     * 添加密码
     */
    public function PwdAdd($device_sn,$pwd_sn,$device_cid,$start_time,$endTime)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "pwd_add",
                "data" => [
                    "pwd" =>$pwd_sn,
                    "start_time" => (int)$start_time,
                    "end_time" => (int)$endTime,
                ],   "info" => [
                    "pwd" =>$pwd_sn,
                    "start_time" => (int)$start_time,
                    "end_time" => (int)$endTime,
                ],
            ]
        ]);
        if (!isset($res["code"]) ){
            return ["err" =>"添加失败"];
        }
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 ) {
            return ["err" =>"添加失败".$res["data"]["info"]["err_code"],"msg"=>$res];
        }

        if ($res["data"]["info"]["code"] != 0) {
            return ["err" =>"添加失败".$res["data"]["info"]["msg"],"msg"=>$res];
        }

        return ["err" => null,"res"=>$res];
    }

    /**
     * @param $device_sn
     * 删除密码
     */
    public function PwdDel($device_sn,$pwd_sn,$device_cid)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "pwd_del",
                "data" => [
                    "pwd" =>$pwd_sn,

                ], "info" => [
                    "pwd" =>$pwd_sn,

                ],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 && $res["data"]["info"]["code"] != 0) {
            return ["err" =>"删除失败".$res["data"]["info"]["err_code"]];
        }

        return ["err" => null];
    }
    /**
     * @param $device_sn
     * 清空密码
     */
    public function PwdDelAll($device_sn,$device_cid)
    {

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>$device_cid,
                "cmd_type" => "pwd_clr",
                "data" => [], 
                "info" => [],
            ]
        ]);

        if ( $res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        if ($res["data"]["info"]["err_code"] != 0 && $res["data"]["info"]["code"] != 0) {
            return ["err" =>"清空失败".$res["data"]["info"]["err_code"]];
        }

        return ["err" => null];
    }
    /**
     * @param $device_sn
     * 临时密码
     */
    public function PasswordTemporary($device_sn,$device_cid,$admin_pw)
    {

        $data =[
            "device_sn" => $device_sn,
            "data" => [
                "device_cid"=>"88888888888888888888",
                "admin_pw" => "012345",
                // "device_cid"=>$device_cid,
                // "admin_pw" => $admin_pw,
            ]
        ];
        if(mb_substr($device_sn,0,3)=="W76"){
            $res = server::Request("TPassword", $data);
        }else{
            $res = server::Request("wifiLock/temporaryPassword", $data);
        }
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null,"pwd"=>$res["data"]["pwd"],"data"=>$data];
    }



}
