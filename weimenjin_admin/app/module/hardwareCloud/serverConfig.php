<?php


namespace app\module\hardwareCloud;


class serverConfig
{
    static $WiFIUrl = "https://wdev.wmj.com.cn/deviceApi/";

    static function GetUrl(){
        return self::$WiFIUrl;
    }

    static function GetAppId(){
        return (string) config("my.wmjv2.wmjv2_appid", "");
    }

    static function GetAppSecret(){
        return (string) config("my.wmjv2.wmjv2_appsecret", "");
    }

}
