<?php


namespace app\module\member\memberServer;


use app\api\controller\Jwt;
use app\module\redis\Redis;
use EasyWeChat\Factory;
use think\facade\Db;
use think\facade\Log;

class MemberServer
{
    static function TokenSet($uid)
    {
        $jwt = Jwt::getInstance();
        $jwt->setIss(config('my.jwt_iss'))->setAud(config('my.jwt_aud'))->setSecrect(config('my.jwt_secrect'))->setExpTime(config('my.jwt_expire_time'));
        $token = $jwt->setUid($uid)->encode()->getToken();
        return $token;


    }

    public static function OpenidGet($code)
    {


        $app = Factory::miniProgram(config('my.mini_program'));
        $res = $app->auth->session($code);
        $err = null;
        //解码用户信息
        if (isset($res["errmsg"])) {
            $err = $res["errmsg"];
        }


        return ["err" => $err, "res" => $res];
    }

    static function Add($data)
    {
        $data["create_time"] = time();
        Db::name("member")->insert($data);
    }

    static function InfoWOpenid($openid)
    {
        $member = Db::name("member")->where(["openid" => $openid])->order("member_id desc")->find();
        if (!$member) {
            self::Add(["openid" => $openid]);
            $member = Db::name("member")->where(["openid" => $openid])->find();

        }

        return $member;
    }

    static function Uid(){
        $token =   $_SERVER["HTTP_AUTHORIZATION"];
        $err=null;
        $uid=0;
        if($token){
            $jwt = Jwt::getInstance();
            $jwt->setIss(config('my.jwt_iss'))->setAud(config('my.jwt_aud'))->setSecrect(config('my.jwt_secrect'))->setToken($token);

            if($jwt->decode()->getClaim('exp') < time()){
                return ["err"=>"token过期","data"=>0];
            }
            $uid= $jwt->decode()->getClaim('uid');
        }

       return ["err"=>$err,"uid"=>$uid];
    }

    static function Edit($member_id,$data)
    {

        Db::name("member")->where(["member_id"=>$member_id])->update($data);
    }
    static function Info($member_id)
    {

      return  Db::name("member")->where(["member_id"=>$member_id])->find();
    }
    static function InfoWMobile($mobile)
    {

      return  Db::name("member")->where(["mobile"=>$mobile])->find();
    }

    static function UMember($member_id,$user_id){

        $res["err"]=null;
        $umemdata['member_id']=$member_id;
        $umemdata['user_id']=$user_id;
        $resumemdata=\xhadmin\db\Umember::getWhereInfo($umemdata);//获取当前这个普通管理员下这个用户是否有信息

        //创建用户信息
        if (!$resumemdata)
        {
            $umemdata['status']=1;
            $umemdata['ucreate_time']=time();
            $umemcreate=\xhadmin\db\Umember::createData($umemdata);
        }
        // if($resumemdata["status"]==0)
        // {
        //     $res["err"]="黑名单用户";
        // }
        // elseif($resumemdata["status"]==2)
        // {
        //     $Redis =Redis::Redis();
        //     $key ="blacklist:".$resumemdata["status"];
        //     if($Redis->get($key)==1)
        //     {
        //         $res["err"]="黑名单用户".  $resumemdata["umember_id"];
        //     }
        //     else
        //     {
        //         $Redis->set($key,1,3600*24);
        //     }
        // }
        return $resumemdata;
    }
}
