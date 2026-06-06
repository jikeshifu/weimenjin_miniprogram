<?php


namespace app\module\wechat;

use EasyWeChat\Factory;
class WechatServer
{
    /**
     *

     */
    public static function PayApp(){



        $config = [
            // 必要配置
            'app_id'             => config('my.wxmp.wxmp_appid'),
            'mch_id'             => config('my.wechart_pay.mch_id'),
            'key'                => config('my.wechart_pay.key'),

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
//            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
//            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！

            'notify_url'         => rtrim((string) config('my.siteconfig.siteurl'), '/') . '/api/pay.Notify/index',
        ];



      return Factory::payment($config);
    }
}
