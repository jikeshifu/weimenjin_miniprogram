<?php

namespace app\module\member\memberServer;

use app\api\controller\Jwt;
use app\module\redis\Redis;
use EasyWeChat\Factory;
use think\facade\Db;
use think\facade\Log;

class MemberServer
{
    /**
     * 生成Token
     * @param int $uid
     * @return string
     */
    public static function TokenSet($uid)
    {
        $jwt = Jwt::getInstance();
        $jwt->setIss(config('my.jwt_iss'))->setAud(config('my.jwt_aud'))->setSecret(config('my.jwt_secret'))->setExpTime(config('my.jwt_expire_time'));
        $token = $jwt->setUid($uid)->encode()->getToken();
        return $token;
    }

    public static function RefreshTokenSet($uid)
    {
        $jwt = Jwt::getInstance();
        $jwt->setIss(config('my.jwt_iss'))->setAud(config('my.jwt_aud'))->setSecret(config('my.jwt_secret'))->setExpTime(config('my.jwt_refresh_expire_time'));
        $refreshToken = $jwt->setUid($uid)->encode()->getToken();
        return $refreshToken;
    }

    public static function VerifyRefreshToken($refreshToken)
    {
        try {
            $jwt = Jwt::getInstance();
            $jwt->setToken($refreshToken)->decode();
            $uid = $jwt->getUid();
            return ['err' => null, 'member_id' => $uid];
        } catch (\Exception $e) {
            return ['err' => $e->getMessage()];
        }
    }


    /**
     * 获取OpenID
     * @param string $code
     * @return array
     */
    public static function OpenidGet($code)
    {
        $wxappconfigdata['app_id']=config('my.wxmp.wxmp_appid');
        $wxappconfigdata['secret']=config('my.wxmp.wxmp_appsecret');
        $app = Factory::miniProgram($wxappconfigdata);
        $res = $app->auth->session($code);
        $err = null;

        // 检查是否有错误信息
        if (isset($res["errmsg"])) {
            $err = $res["errmsg"];
        }

        return ["err" => $err, "res" => $res];
    }

    /**
     * 新增用户
     * @param array $data
     */
    static function Add($data)
    {
        $data["create_time"] = time();
        Db::name("member")->insert($data);
    }

    /**
     * 根据OpenID获取用户信息
     * @param string $openid
     * @return array|null
     */
    static function InfoWOpenid($openid)
    {
        $member = Db::name("member")->where(["openid" => $openid])->order("member_id desc")->find();
        if (!$member) {
            self::Add(["openid" => $openid, "member_type" => 1, "status" => 1]);
            $member = Db::name("member")->where(["openid" => $openid])->find();
        }
        return $member;
    }
    public static function InfoByPhone($phoneNumber) {
        // 1. 查询数据库是否存在该手机号的用户
        $member = Db::name("member")->where(["mobile" => $phoneNumber,"member_type" => 1])->order("member_id desc")->find();

        // 2. 如果用户不存在，则创建新用户
        if (!$member) {
            // 创建新用户，设置 'mobile' 和 'member_type'
            self::Add([
                "mobile" => $phoneNumber,
                "member_type" => 4,  // 4 表示 app 用户
                "status" => 1,  // 用户状态设为启用
                "create_time" => time()
            ]);

            // 3. 再次查询并返回新创建的用户信息
            $member = Db::name("member")->where(["mobile" => $phoneNumber,"member_type" => 4])->find();
        }

        // 4. 返回用户信息
        return $member;
    }
    /**
     * 获取用户UID
     * @return array
     */
    static function Uid()
    {
        // 获取请求头中的 Authorization
        $token = $_SERVER["HTTP_AUTHORIZATION"];
        //mlog("请求中的 Token: " . $token, "uid_debug.log");

        $err = null;
        $uid = 0;

        if ($token) {
            $jwt = Jwt::getInstance();
            $jwt->setIss(config('my.jwt_iss'))
                ->setAud(config('my.jwt_aud'))
                ->setSecret(config('my.jwt_secret'))
                ->setToken($token);

            try {
                // 解析 Token
                $decodedToken = $jwt->decode();

                // 获取 uid 并记录日志
                $uid = $decodedToken->claims()->get('uid');
                //mlog("解析到的 uid: " . $uid, "uid_debug.txt");

            } catch (\Exception $e) {
                //mlog("Token 解析失败: " . $e->getMessage(), "uid_debug.txt");
                return ["err" => "Token 无效或过期", "data" => 0];
            }
        } else {
            $err = "未提供 Token";
            //mlog($err, "uid_debug.log");
        }

        return ["err" => $err, "uid" => $uid];
    }


    /**
     * 编辑用户信息
     * @param int $member_id
     * @param array $data
     */
    static function Edit($member_id, $data)
    {
        Db::name("member")->where(["member_id" => $member_id])->update($data);
    }

    /**
     * 获取用户信息
     * @param int $member_id
     * @return array|null
     */
    static function Info($member_id)
    {
        return Db::name("member")->where(["member_id" => $member_id])->find();
    }

    /**
     * 根据手机号获取用户信息
     * @param string $mobile
     * @return array|null
     */
    static function InfoWMobile($mobile)
    {
        return Db::name("member")->where(["mobile" => $mobile])->find();
    }

    /**
     * 创建用户信息
     * @param int $member_id
     * @param int $user_id
     * @return array
     */
    static function UMember($member_id, $user_id)
    {
        $res["err"] = null;
        $umemdata['member_id'] = $member_id;
        $umemdata['user_id'] = $user_id;
        $resumemdata = \xhadmin\db\Umember::getWhereInfo($umemdata); // 获取当前这个普通管理员下这个用户是否有信息

        // 创建用户信息
        if (!$resumemdata) {
            $umemdata['status'] = 1;
            $umemdata['ucreate_time'] = time();
            \xhadmin\db\Umember::createData($umemdata);
        }

        return $resumemdata;
    }
}
