<?php


namespace app\wechat\controller\member;

use app\module\wechat\Offiaccount;
use app\module\wechat\Wechat;
use EasyWeChat\Factory;
use think\facade\Db;

class Login
{
    public function offiaccount()
    {
        $resconfig = \app\admin\db\Config::loadList();
        $offiaccountApp = Wechat::App()->offiaccount()->app($resconfig["gzhappid"],$resconfig["gzhappsecret"]);
        $oauth = $offiaccountApp->oauth;

// 未登录
        if (empty($_SESSION['wechat_user'])) {

            $_SESSION['target_url'] = 'user/profile';

            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

// 已经登录过
        $user = $_SESSION['wechat_user'];

    }

    function oauth_callback()
    {
        $resconfig = \app\admin\db\Config::loadList();
        $offiaccountApp = Wechat::App()->offiaccount()->app($resconfig["gzhappid"],$resconfig["gzhappsecret"]);
        $oauth = $offiaccountApp->oauth;

// 获取 OAuth 授权结果用户信息
        $user = $oauth->user();

        $wechat_user = $user->toArray();
        if (isset($wechat_user["original"]) && $wechat_user["original"]) {
            $memberRes = Db::name("gzh_member")->where(["openid" => $wechat_user["original"]["openid"]])->find();
            if ($memberRes) {
                Db::name("gzh_member")->where(["openid" => $wechat_user["original"]["unionid"]])->update([
                    "unionid"=>$wechat_user["original"]["unionid"]
                ]);

            }else{
                Db::name("gzh_member")->insert([
                    "unionid"=>$wechat_user["original"]["unionid"],
                    "openid"=>$wechat_user["original"]["openid"],
                    "created_at"=>time(),
                ]);
            }
        }
        Header("Location: /wechat/member.Login/cg");

    }

    function cg(){



        return view("offiaccount");
    }

}
