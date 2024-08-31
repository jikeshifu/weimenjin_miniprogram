<?php


namespace app\module\wechat\Offiaccount;

use EasyWeChat\Factory;

class Offiaccount
{
    function app($appid,$appsecret)
    {
        $config = [
            // ...
            'app_id' => $appid,
            'secret' => $appsecret,
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/wechat/member.Login/oauth_callback',
            ],

            // ..
        ];

        $app = Factory::officialAccount($config);
        return $app;
    }


}
