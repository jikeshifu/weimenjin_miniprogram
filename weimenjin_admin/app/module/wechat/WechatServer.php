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
            'app_id'             => 'wx7fdcb0b7df1b5439',
            'mch_id'             => '1360430502',
            'key'                => 'Kjdkslieaojkjdmuhri893w992939eki',   // API v2 密钥 (注意: 是v2密钥 是v2密钥 是v2密钥)

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
//            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
//            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！

            'notify_url'         => '/api/',     // 你也可以在下单时单独设置来想覆盖它
        ];



      return Factory::payment($config);
    }
}
