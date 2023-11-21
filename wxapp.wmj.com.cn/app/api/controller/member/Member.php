<?php


namespace app\api\controller\member;


use app\module\code\Code;
use app\module\member\memberServer\MemberServer;
use app\module\redis\Redis;
use app\module\user\userServer\UserServer;
use think\facade\Db;

class Member
{
    function login()
    {
        $code = input("code");

        $wxUserRes = MemberServer::OpenidGet($code);
        if ($wxUserRes["err"]) {

            return json(Code::CodeErr(1000, $wxUserRes["err"], $wxUserRes));
        }

//        if ($wxUserRes["res"]["openid"] == "oEHaL5ZaiZabEBwJfAkDlTwuyRl0") {
//            $wxUserRes["res"]["openid"] = "oEHaL5ZDm9e0PexYt1PrCuWoNv0E";
//
//        }

        $memberInfo = MemberServer::InfoWOpenid($wxUserRes["res"]["openid"]);
        if (isset($wxUserRes["res"]["unionid"]) && !$memberInfo["unionid"]) {
            MemberServer::Edit($memberInfo["member_id"], ['unionid' => $wxUserRes["res"]["unionid"]]);
        }

        return json(Code::CodeOk(["data" => [
            "memberInfo" => $memberInfo,
            "wxUserRes" => $wxUserRes,
            "token" => MemberServer::TokenSet($memberInfo["member_id"])
        ]]));

    }

    function deviceInfoSet()
    {
        $res = MemberServer::Uid();
        $data = [
            "SDKVersion" => input("SDKVersion"),
            "bluetoothEnabled" => input("bluetoothEnabled"),
            "locationEnabled" => input("locationEnabled"),
            "wx_model" => input("wx_model"),
            "wx_platform" => input("wx_platform"),
            "wx_system" => input("wx_system"),
            "wx_version" => input("wx_version"),
        ];
        $member_id = $res["uid"];
        $memberInfo = MemberServer::Edit($member_id, $data);
        return json(Code::CodeOk(["data" => $memberInfo]));

    }

    function edit()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $nickname = input("nickname");
        $headimgurl = input("headimgurl");
        MemberServer::Edit($member_id, [
            "nickname" => $nickname,
            "headimgurl" => $headimgurl,
        ]);
        return json(Code::CodeOk());

    }


    function info()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $memberInfo = MemberServer::Info($member_id);
        return json(Code::CodeOk(["data" => $memberInfo]));
    }

    //
    function wxXcxMobile()
    {
        $code = input("code");
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $phonenumberdata = \utils\wechart\UserService::GetMobile($code);    //获取小程序用户信息

        if ($phonenumberdata["errcode"] != 0) {
            return json(Code::CodeErr(1000, $phonenumberdata["errmsg"], $phonenumberdata));
        }

        Db::name("member")->where(["member_id" => $member_id])->update(["mobile" => $phonenumberdata["phone_info"]["phoneNumber"]]);


        return json(Code::CodeOk(["data" => $phonenumberdata["phone_info"]]));
    }

    function loginQrCode()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];

        $key = input("key");
        $key = "login:" . $key;
        $useradmininfo = db()->name('user')->where(["member_id" => $member_id])->find();
        if (!$useradmininfo) {
            UserServer::Add("默认用户", uniqid(), "a123456", $member_id);

        }
        $res = Redis::Redis()->get($key);
        if (!$res) {
            Redis::Redis()->set($key, $member_id, 7200);
            return json(Code::CodeOk(["msg" => "登录成功"]));
        }
        return json(Code::CodeErr(1000, "扫描登录失败"));

    }


    function account()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];

        $user = Db::name("user")->where(["member_id" => $member_id])->find();
        return json(Code::CodeOk(["msg" => "查询成功", "data" => $user]));
    }

    function accountSet()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $user = input("user");
        $password = input("pwd");
        $password = !empty(config('my.password_secrect')) ? trim($password) . config('my.password_secrect') : trim($password);
        $password = md5($password);


        $user1 = Db::name("user")->where(["user" => $user])->where("member_id", "<>", $member_id)->find();
        if ($user1) {
            return json(Code::CodeErr(1000, "账号已存在"));
        }
        $user = Db::name("user")->where(["member_id" => $member_id])->update([
            "pwd" => $password,
            "user" => $user
        ]);
        return json(Code::CodeOk(["msg" => "查询成功", "data" => $user]));
    }
}
