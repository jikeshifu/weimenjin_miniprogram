<?php


namespace app\module\hardwareCloud;


use think\facade\Db;

class serverConfig
{
    static $WiFIUrl = "https://wdev.wmj.com.cn/deviceApi/";

    static function GetUrl(){
        return self::$WiFIUrl;
    }

    static function GetAppId(){

       $config= Db::name("config")->where(["name"=>"yjy_appid"])->cache(true,120)->find();
        return $config["data"];
    }

    static function GetAppSecret(){
        $config= Db::name("config")->where(["name"=>"yjy_appsecret"])->cache(true,120)->find();
        return $config["data"];

    }

}
