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
        $offiaccountApp = Wechat::App()->offiaccount()->app(
            config("my.official_accounts.app_id"),
            config("my.official_accounts.secret")
        );
        $oauth = $offiaccountApp->oauth;

        // 未登录
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = 'user/profile';

            // 必须要 ->send() 才会真正发起重定向
            $redirectUrl = $oauth->redirect();
            header("Location: {$redirectUrl}");
            exit; // 后面别的逻辑就不执行了
        }

        // 已经登录过
        $user = $_SESSION['wechat_user'];
        // ... 后续业务处理
    }

    public function oauth_callback()
    {
        // 1. 根据你的配置创建公众号（OfficialAccount）实例
        $offiaccountApp = Wechat::App()
            ->offiaccount()
            ->app(
                config("my.official_accounts.app_id"),
                config("my.official_accounts.secret")
            );

        // 2. 获取 OAuth 模块
        $oauth = $offiaccountApp->oauth;

        // 3. 获取微信回调时带回的 `code`
        //    （根据你使用的框架，改成 request()->get('code')、input('code') 或 $_GET['code'] 皆可）
        $code = request()->get('code');

        // 4. 通过 code 获取用户信息
        //    新版本通常用 userFromCode($code) 来获取
        $user = $oauth->userFromCode($code);

        // 5. 转为数组形式，方便后面取数据
        $wechat_user = $user->toArray();

        // 6. 根据你的需求，存储或更新数据库
        if (!empty($wechat_user["original"])) {
            // 例如：$wechat_user["original"]["openid"]、["unionid"]
            $openid  = $wechat_user["original"]["openid"] ?? null;
            $unionid = $wechat_user["original"]["unionid"] ?? null;

            if ($openid) {
                $memberRes = Db::name("gzh_member")->where(["openid" => $openid])->find();
                if ($memberRes) {
                    // 如果已存在，则更新 unionid
                    Db::name("gzh_member")
                        ->where(["openid" => $openid])
                        ->update(["unionid" => $unionid]);
                } else {
                    // 如果不存在，则插入新记录
                    Db::name("gzh_member")->insert([
                        "unionid"    => $unionid,
                        "openid"     => $openid,
                        "created_at" => time(),
                    ]);
                }
            }
        }

        // 7. 跳转到你想去的页面
        header("Location: /wechat/member.Login/cg");
        exit;
    }

    function cg(){



        return view("offiaccount");
    }

}
