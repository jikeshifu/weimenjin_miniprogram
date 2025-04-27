<?php


namespace app\module\lock;


use app\module\wechat\Wechat;
use think\facade\Db;

class LockNotice
{
    //开门通知
    static function OpenLock($lock_id, $username)
    {

        //查询锁信息
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->cache(true, 60)->find();
        if (!$lock["opsucnt"]) {
            return;
        }

        $lockauth = Db::name("lockauth")->where(["lock_id" => $lock_id, "auth_isadmin" => 1])->cache(true, 60)->select();
        $res = [];
        if ($lockauth) {
            foreach ($lockauth as $vo) {
                $res[] = self::openlockmember($vo["member_id"], $username, $lock["lock_name"]);
            }

        }
        //mlog("发送通知返回：".json_encode($res, JSON_UNESCAPED_UNICODE),"sendnoticelog.txt");
        return $res;

    }

    static function OpenLockApply($lock_id, $username,$mobile)
    {

        //查询锁信息
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->cache(true, 60)->find();



        $lockauth = Db::name("lockauth")->where(["lock_id" => $lock_id, "auth_isadmin" => 1])->cache(true, 60)->select();
        $res = [];

        if ($lockauth) {

            foreach ($lockauth as $vo) {
                $res[] = self::openLockApplyMember($vo["member_id"], $username, $lock["lock_name"],$mobile);

            }

        }
        return $res;

    }
    static function openLockApplyMember($member_id, $username, $lock_name,$mobile)
    {
        //查询用户信息
        $member = Db::name("member")->where(["member_id" => $member_id])->cache(true, 60)->find();

        if (!$member["unionid"]) {
            return;
        }
        //查询对应的公众号用户信息
        $gzh_member = Db::name("gzh_member")->where(["unionid" => $member["unionid"]])->cache(true, 60)->find();

        if (!$gzh_member) {
            return;
        }

        //获取公众号配置
        $offiaccountApp = Wechat::App()->offiaccount()->app(config("my.official_accounts.app_id"),config("my.official_accounts.secret"));
        $res = $offiaccountApp->template_message->send([
            'touser' => $gzh_member["openid"],
            'template_id' => config("my.wechart_template.gzhtempleteid1"),
            "miniprogram" => [
                "appid" => config("my.wxmp.wxmp_appid"),
                "pagepath" => "pages/index/index"
            ],
            'data' => [
                'keyword1' => $username."-".$lock_name,
                'keyword2' => $mobile,
                'keyword3' => date("Y-m-d H:i:s"),

            ],
        ]);
        return $res;
    }

    static function openlockmember($member_id, $username, $lock_name)
    {
        //查询用户信息
        $member = Db::name("member")->where(["member_id" => $member_id])->cache(true, 60)->find();
        if (!$member["unionid"]) {
            return;
        }
        //查询对应的公众号用户信息
        $gzh_member = Db::name("gzh_member")->where(["unionid" => $member["unionid"]])->cache(true, 60)->find();

        if (!$gzh_member) {
            return;
        }

        //获取公众号配置
        $offiaccountApp = Wechat::App()->offiaccount()->app(config("my.official_accounts.app_id"),config("my.official_accounts.secret"));
        $res = $offiaccountApp->template_message->send([
            'touser' => $gzh_member["openid"],
            'template_id' => config("my.wechart_template.gzhtempleteid2"),
            "miniprogram" => [
                "appid" => config("my.wxmp.wxmp_appid"),
                "pagepath" => "pages/index/index"
            ],
            'data' => [
                'keyword1' => $username,
                'keyword2' => $lock_name,
                'keyword3' => '进',
                'keyword4' => '小程序开门',
                'keyword5' => date("Y-m-d H:i:s"),

            ],
        ]);
        return $res;
    }
}
