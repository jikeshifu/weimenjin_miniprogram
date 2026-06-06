<?php


namespace app\api\controller\member;


use app\module\code\Code;
use app\module\member\memberServer\MemberServer;
use app\module\redis\Redis;
use app\module\user\userServer\UserServer;
use app\module\adlog\AdlogServer;
use app\module\lockAuthServer\LockAuth;
use xhadmin\db\Lock as LockDb;
use xhadmin\db\LockAuth as LockAuthDb;
use think\facade\Db;

class Member
{
    public function login()
    {
        $code = input("code");

        // 获取微信用户信息
        $wxUserRes = MemberServer::OpenidGet($code);
        if ($wxUserRes["err"]) {
            return json(Code::CodeErr(1000, $wxUserRes["err"], $wxUserRes));
        }

        // 获取会员信息
        $memberInfo = MemberServer::InfoWOpenid($wxUserRes["res"]["openid"]);

        $memberInfo = MemberServer::InfoWOpenid($wxUserRes["res"]["openid"]);
        //查询是否有演示钥匙，没有就加一个，演示钥匙默认id为2
        $testlock = LockDb::getInfo(config("my.autodtkeylockid"));
        if (config("my.autodtkey") && $testlock) {
            $lockauthres = LockAuthDb::getWhereInfo(['lock_id' => config("my.autodtkeylockid"), 'member_id' => $memberInfo['member_id']], 'lockauth_id');
            if (!$lockauthres) {
                LockAuth::Addtestauth(config("my.autodtkeylockid"), $memberInfo['member_id'], 1, 0);
            }
        }
        if (isset($wxUserRes["res"]["unionid"]) && !$memberInfo["unionid"]) {
            MemberServer::Edit($memberInfo["member_id"], ['unionid' => $wxUserRes["res"]["unionid"]]);
        }

        // 生成Token和Refresh Token
        mlog("登录用户 ID: " . $memberInfo['member_id'], "login_debug.txt");
        $token = MemberServer::TokenSet($memberInfo["member_id"]);
        $refreshToken = MemberServer::RefreshTokenSet($memberInfo["member_id"]);

        return json(Code::CodeOk([
            "data" => [
                "memberInfo" => $memberInfo,
                "wxUserRes" => $wxUserRes,
                "token" => $token,
                "refresh_token" => $refreshToken
            ]
        ]));
    }

    /**
     * 刷新Token，使用refresh_token获取新的access_token
     */
    public function refreshToken()
    {
        $refreshToken = input("refresh_token");

        // 验证 refresh_token 的有效性
        $refreshTokenData = MemberServer::VerifyRefreshToken($refreshToken);
        if ($refreshTokenData['err']) {
            return json(Code::CodeErr(1001, "refresh_token 无效或已过期", $refreshTokenData));
        }

        // 生成新的Token
        $newToken = MemberServer::TokenSet($refreshTokenData['member_id']);
        return json(Code::CodeOk([
            'token' => $newToken
        ]));
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
    //登记广告日志
    function addadlog()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $adlog_page = input("adlog_page");
        $adlog_type = input("adlog_type");
        $adlog_adtime = input("adlog_adtime");
        $adlog_result = input("adlog_result");
        $adlog_msg = input("adlog_msg");
        $adlog_points = input("adlog_points");
        AdlogServer::Add($member_id, $adlog_page,$adlog_type,$adlog_adtime,$adlog_result, $adlog_msg,$adlog_points);
        return json(Code::CodeOk(["msg" => "登记成功"]));

        // Redis 键，用于存储最后一次短信发送的时间戳
        $redisKey = "adlog_sms_last_send_time";

        // 如果是广告展示失败，并且展示失败标志为 false
        if ($adlog_type == "show" && !$adlog_result) {
            // 检查 Redis 缓存中是否有最后发送短信的时间戳
            $lastSendTime = Redis::Redis()->get($redisKey);
            $currentTime = time();  // 当前时间戳

            // 如果 Redis 中没有记录或距离上次发送短信已经超过 2 小时（7200秒）
            if (!$lastSendTime || ($currentTime - $lastSendTime) > 21600) {
                // 发送短信逻辑
                $mobiles = "13800000000,13900000000";
                $content = "小程序激励广告展示失败，请检查是否有配置异常";
                $smsdata = array("mobiles" => $mobiles, "content" => $content);
                sendymSms($smsdata);

                // 发送成功后，将当前时间戳存入 Redis，过期时间设置为 2 小时
                Redis::Redis()->set($redisKey, $currentTime, 21600);
            }
        }

        // 记录广告日志
        AdlogServer::Add($member_id, $adlog_page, $adlog_type, $adlog_adtime, $adlog_result, $adlog_msg, $adlog_points);

        return json(Code::CodeOk(["msg" => "登记成功"]));
    }
    //获取积分
    function getpoints()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $points=AdlogServer::GetPoints($member_id);
        $countshow=AdlogServer::GetCountShow();
        $countcomplete=AdlogServer::GetComplete();
        return json(Code::CodeOk(["msg" => "获取成功","points"=>$points,"countshow"=>$countshow,"countcomplete"=>$countcomplete]));
    }
    function adUnitId()
    {
        // 构建广告ID数组
        $adUnitIds = [
            'adunit-670eb5fcd3308a6e',
            'adunit-af0a43edb1e542c8',
            'adunit-dbda0dd32d69a16c',
            'adunit-bb23a400b29876a9',
            'adunit-66ef6e75a61d8ecd',
            'adunit-7d92b727f6325a2d',
            'adunit-5c5c526bd0c1cae1',
            'adunit-87e105b0b9e2dca3',
            'adunit-7b8818e168163c47',
            'adunit-7cab059a840fb768',
            'adunit-0c439c6b09456c11',
            'adunit-83117a58894d7908',
            'adunit-ff26bb6013e1a0ba',
            'adunit-18a0e5ccd9a109db',
            'adunit-2e69061ea77aabc5',
            'adunit-5aec0fcedede8d3c',
            'adunit-a1838065fa25edf2',
            'adunit-1895d641f9d487ae',
            'adunit-065f8f2f8c66f480',
            'adunit-688be33fd1317ddf',
        ];

        // 随机选择一个广告ID
        $randomIndex = array_rand($adUnitIds);
        $randomAdUnitId = $adUnitIds[$randomIndex];

        // 返回结果（含随机广告ID）
        return json(Code::CodeOk([
            "code" => 0,
            "msg" => "获取成功",
            "adUnitId" => $randomAdUnitId,
        ]));
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
    function sendSms() {
        // 获取传入的手机号参数
        $phoneNumber = input("phoneNumber");

        // 检查手机号是否为空
        if (empty($phoneNumber)) {
            return json(['code' => 1, 'msg' => '手机号不能为空']);
        }

        // 检查手机号格式是否正确
        if (!preg_match("/^1[3456789]\d{9}$/", $phoneNumber)) {
            return json(['code' => 1, 'msg' => '手机号格式不正确']);
        }

        // 生成随机验证码
        $code = rand(100000, 999999);

        // 将验证码保存到缓存，保存5分钟
        cache('sms_code_' . $phoneNumber, $code, 300);

        // 短信前缀
        $prex = "【微门禁】";

        // 构造短信内容
        $content = $prex . "您的验证码是" . $code . "，请在5分钟内输入。";

        // 构造发送短信的参数
        $smsdata = array(
            "mobiles" => $phoneNumber,
            "content" => $content
        );

        // 调用短信发送接口
        try {
            $smsSent = sendymSms($smsdata);

            // 检查发送结果
            if ($smsSent && isset($smsSent['code']) && $smsSent['code'] === 'SUCCESS') {
                return json(['code' => 0, 'msg' => '验证码发送成功']);
            } else {
                return json(['code' => 1, 'msg' => '验证码发送失败']);
            }
        } catch (Exception $e) {
            return json(['code' => 1, 'msg' => $smsSent]);
        }
    }
    public function smsLogin() {
        // 1. 获取传入的手机号和验证码
        $phoneNumber = input("phoneNumber");
        $code = input("code");

        // 2. 验证验证码是否正确
        $cachedCode = cache('sms_code_' . $phoneNumber); // 从缓存中获取验证码
        if (!$cachedCode || $cachedCode != $code) {
            // 验证码错误或已过期
            return json(Code::CodeErr(1001, "验证码错误或已过期"));
        }

        // 3. 获取会员信息，如果会员不存在则创建
        $memberInfo = MemberServer::InfoByPhone($phoneNumber); // 假设根据手机号获取会员信息


        // 4. 查询是否有演示钥匙，没有则添加
        $lockauthres = LockAuthDb::getWhereInfo(['lock_id' => 2, 'member_id' => $memberInfo['member_id']], 'lockauth_id');
        if (!$lockauthres) {
            LockAuth::Addtestauth(2, $memberInfo['member_id'], 1, 0);
        }

        // 5. 生成Token和Refresh Token
        mlog("登录用户 ID: " . $memberInfo['member_id'], "login_debug.txt");
        $token = MemberServer::TokenSet($memberInfo["member_id"]);
        $refreshToken = MemberServer::RefreshTokenSet($memberInfo["member_id"]);

        // 6. 返回用户信息和Token
        return json(Code::CodeOk([
            "data" => [
                "memberInfo" => $memberInfo,
                "token" => $token,
                "refresh_token" => $refreshToken
            ]
        ]));
    }

    /**
     * 获取广告控制ID
     */
    function adControlUnitId()
    {
        // 构建广告ID数组
        $adUnitIds = [
            'adunit-0e87a5e81426df4d',
            'adunit-1f2cc93a5f37dfbe',
            'adunit-9d0785032deb294a',
            'adunit-0fb599f5889ed107',
            'adunit-e3f40118ce312724',
            'adunit-5e70db7fb35b4022',
            'adunit-eaf9cd6f80816628',
            'adunit-21217ce01adca0c8',
            'adunit-55a602453119e2af',
            'adunit-4cd5db86277afc5e',
        ];

        // 随机选择一个广告ID
        $randomIndex = array_rand($adUnitIds);
        $randomAdUnitId = $adUnitIds[$randomIndex];

        // 返回结果（含随机广告ID）
        return json(Code::CodeOk([
            "code" => 0,
            "msg" => "获取成功",
            "adUnitId" => $randomAdUnitId,
        ]));
    }

    /**
     * 解绑用户手机号
     * @return \think\Response 返回JSON格式的响应
     */
    public function unbindPhone()
    {
        try {
            // 获取当前用户ID
            $res = MemberServer::Uid();
            if (!isset($res['uid']) || empty($res['uid'])) {
                return json(['code' => 1, 'msg' => '用户身份验证失败']);
            }

            $member_id = $res['uid'];

            // 执行数据库更新操作
            $result = Db::name('member')
                ->where(['member_id' => $member_id])
                ->update(['mobile' => null]);

            // 检查更新是否成功
            if ($result === false) {
                return json(['code' => 1, 'msg' => '解绑手机号失败']);
            }

            // 返回成功响应
            return json(['code' => 0, 'msg' => '解绑成功']);
        } catch (\Exception $e) {
            // 捕获异常并返回错误信息
            return json(['code' => 1, 'msg' => '服务器错误: ' . $e->getMessage()]);
        }
    }

}
