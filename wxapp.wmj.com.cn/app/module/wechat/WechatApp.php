<?php


namespace app\module\wechat;


use app\module\wechat\Offiaccount\Offiaccount;

class WechatApp
{
     function offiaccount()
    {
        return new Offiaccount();
    }
}
