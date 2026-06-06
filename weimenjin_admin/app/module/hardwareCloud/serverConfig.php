<?php


namespace app\module\hardwareCloud;


class serverConfig
{
    static $WiFIUrl = "https://wdev.wmj.com.cn/deviceApi/";

    static function GetUrl(){
        $url = (string) config("my.wmjv2.wmjv2_url", "");
        if ($url === "") {
            $url = self::$WiFIUrl;
        }
        return rtrim($url, "/") . "/";
    }

    static function GetAppId(){
        return (string) config("my.wmjv2.wmjv2_appid", "");
    }

    static function GetAppSecret(){
        return (string) config("my.wmjv2.wmjv2_appsecret", "");
    }

}
