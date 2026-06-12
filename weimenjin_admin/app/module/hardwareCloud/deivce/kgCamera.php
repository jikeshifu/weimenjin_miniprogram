<?php

namespace app\module\hardwareCloud\deivce;

use app\module\hardwareCloud\server;

class kgCamera
{
    public static function Register($device_sn){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }
        $res = server::Request("register", [
            "device_sn" => $device_sn,
            "data" => []
        ]);
        if ($res["code"] != 0 && $res["code"] != 1005) {
            return ["err" => $res["msg"] ?? "摄像头注册失败", "data" => $res];
        }
        return ["err" => null, "msg" => $res["msg"] ?? "摄像头注册成功", "data" => $res["data"] ?? []];
    }

    public static function GetUserToken($device_sn,$user_id,$channel_name){
        if(empty($device_sn) || $user_id === null || $user_id === '' || empty($channel_name)){
            return ["err" =>"device_sn和user_id和channel_name不能为空!"];
        }
        $res = server::Request("kgCameraApi/getUserToken", [
            "device_sn" => $device_sn,
            "data" => [
                "user_id" => (int)$user_id,
                "channel_name" => $channel_name
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null,"data"=>$res["data"]];
    }

    public static function GetDeviceToken($device_sn,$channel){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }
        $res = server::Request("kgCameraApi/getDevToken", [
            "device_sn" => $device_sn,
            "data" => [
                "channel_name"=>$channel
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null,"data"=>$res["data"]];
    }

    public static function GetDeviceLicense($device_sn){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }
        $res = server::Request("kgCameraApi/getLicense", [
            "device_sn" => $device_sn,
            "data" => []
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null,"data"=>$res["data"]];
    }

    public static function GetDeviceReplayToken($device_sn,$user_id){
        if(empty($device_sn) || $user_id === null || $user_id === ''){
            return ["err" =>"device_sn和user_id不能为空!"];
        }
        $res = server::Request("kgCameraApi/getDevReplayToken", [
            "device_sn" => $device_sn,
            "data" => [
                "user_id" => (int)$user_id,
            ]
        ]);
        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }
        return ["err" => null,"data"=>$res["data"]];
    }

    public static function RtspStart($device_sn, $token, $channel, $user_id, $out_time = 600){
        if(empty($device_sn) || empty($token) || empty($channel) || $user_id === null || $user_id === ''){
            return ["err" =>"device_sn、token、channel、user_id不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "rtsp_start",
                "info" => [
                    "token" => $token,
                    "channel" => $channel,
                    "user_id" => (int)$user_id,
                    "out_time" => (int)$out_time,
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"], "code" => $res["code"]];
        }

        if(isset($res["data"]["info"]["code"]) && $res["data"]["info"]["code"] == 1002){
            return ["err" => "设备离线", "code" => 1002];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function RtspReplay($device_sn, $token, $channel, $timestamp, $user_id, $out_time = 600){
        if(empty($device_sn) || empty($token) || empty($channel) || empty($timestamp) || $user_id === null || $user_id === ''){
            return ["err" =>"参数不完整!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "rtsp_replay",
                "info" => [
                    "token" => $token,
                    "channel" => $channel,
                    "timestamp" => (int)$timestamp,
                    "user_id" => (int)$user_id,
                    "out_time" => (int)$out_time,
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function Restart($device_sn){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "restart",
                "info" => []
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function SetNight($device_sn, $is_night){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_night",
                "info" => [
                    "is_night" => (int)$is_night
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function SetRotation($device_sn, $rot){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_rot",
                "info" => [
                    "rot" => (int)$rot
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function SetPtz($device_sn, $axis, $direction, $step = 1){
        if(empty($device_sn) || empty($axis) || empty($direction)){
            return ["err" =>"device_sn、axis、direction不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_ptz",
                "info" => [
                    "axis" => (int)$axis,
                    "direction" => (int)$direction,
                    "step" => (int)$step
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function GetReplayDates($device_sn, $month){
        if(empty($device_sn) || empty($month)){
            return ["err" =>"device_sn和month不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "get_replay_date",
                "info" => [
                    "month" => $month
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function GetReplayTime($device_sn, $date){
        if(empty($device_sn) || empty($date)){
            return ["err" =>"device_sn和date不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "get_replay_time",
                "info" => [
                    "date" => $date
                ]
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function FormatSdCard($device_sn){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }

        $res = server::Request("send", [
            "device_sn" => $device_sn,
            "data" => [
                "cmd_type" => "set_sd_format",
                "info" => []
            ]
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }

    public static function SendData($device_sn,$data=[],$time_out=15){
        if(empty($device_sn)){
            return ["err" =>"device_sn不能为空!"];
        }

        $res = server::Request("mqtt/send", [
            "device_sn" => $device_sn,
            "time_out" => $time_out,
            "data" => $data,
        ]);

        if ($res["code"] != 0) {
            return ["err" => $res["msg"]];
        }

        return ["err" => null, "data" => $res["data"]];
    }
}
