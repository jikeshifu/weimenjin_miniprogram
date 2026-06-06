<?php
/*
 module:		会员管理
 create_time:	2020-06-13 23:53:36
 author:
 contact:
*/

namespace app\api\controller;

use app\module\member\memberServer\MemberServer;
use app\module\redis\Redis;
use app\module\user\userServer\UserServer;
use app\module\lockAuthServer\LockAuth;
use think\facade\Db;
use think\facade\Request;
use xhadmin\service\api\MemberService;
use xhadmin\db\Member as MemberDb;
use xhadmin\db\LockAuth as LockAuthDb;
use think\facade\Cache;
use think\facade\Log;
class Member extends Common
{


    /**
     * @api {post} /Member/update 02、更新用户信息
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  编辑数据
     * @apiParam (输入参数：) {string}            member_id 主键ID (必填)
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (输入参数：) {string}            nickname 呢称
     * @apiParam (输入参数：) {string}            headimgurl 头像
     * @apiParam (输入参数：) {string}            openid openid
     * @apiParam (输入参数：) {string}            mobile 手机号
     * @apiParam (输入参数：) {int}                sex 性别
     * @apiParam (输入参数：) {int}                member_ps 同意政策和协议
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码  201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":" 201","msg":"操作失败"}
     */
    function update()
    {
        $postField = 'member_id,nickname,headimgurl,mobile,sex,member_ps';
        $data = $this->request->only(explode(',', $postField), 'post', null);

        try {
            if($data["member_id"]){
                $where['member_id']=$data["member_id"];
            }else{
                $UidRes = MemberServer::Uid();
                $where['member_id']=$UidRes["uid"];
            }
            //mlog("updatemobile:".json_encode($UidRes),"updatemobile.txt");
            if (empty($where['member_id'])) return json(['status' => $this->errorCode, 'msg' => '参数错误']);
            $res = MemberService::update($where, $data);
        } catch (\Exception $e) {
            return json(['status' => $this->errorCode, 'msg' => $e->getMessage()]);
        }
        return json(['status' => $this->successCode, 'msg' => '操作成功']);
    }

    /**
     * @api {post} /Member/view 03、查看用户信息
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  查看用户信息
     * @apiParam (输入参数：) {string}            member_id 主键ID
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据详情
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function view()
    {
        $data['member_id'] = $this->request->post('member_id', '', 'intval');
        try {
            $field = 'member_id,nickname,headimgurl,openid,mobile,username,password,sex,status,create_time,member_ps';
            $res = checkData(MemberDb::getWhereInfo($data, $field));
        } catch (\Exception $e) {
            return json(['status' => $this->errorCode, 'msg' => $e->getMessage()]);
        }
        Log::info('接口输出：' . print_r($res, true));
        return json(['status' => $this->successCode, 'data' => $res]);
    }

    /**
     * @api {post} /Member/viewuserid 04、查询管理员ID
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  查询管理员ID
     * @apiParam (输入参数：) {string}            member_id 主键ID
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据详情
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function viewuserid()
    {
        $data['member_id'] = $this->request->post('member_id', '', 'intval');
        try {
            $sql = 'select a.member_id,b.* from cd_member as a left join cd_user as b on a.member_id = b.member_id where a.member_id = ' . $data['member_id'] . ' limit 1';
            $res = checkData(current(MemberDb::query($sql)));
        } catch (\Exception $e) {
            return json(['status' => $this->errorCode, 'msg' => $e->getMessage()]);
        }
        Log::info('接口输出：' . print_r($res, true));
        return json(['status' => $this->successCode, 'data' => $res]);
    }
    /*start*/
    /**
     * @api {post} /Member/getuserbymobile 06、根据手机号查询用户信息
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  根据手机号查询用户
     * @apiParam (输入参数：) {string}            mobile 手机号
     * @apiHeader {String} Authorization 用户授权token
     * @apiHeaderExample {json} Header-示例:
     * "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.data 返回数据详情
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","data":""}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"没有数据"}
     */
    function getuserbymobile()
    {
        $data['mobile'] = $this->request->post('mobile', '', '');
        if (empty($data['mobile'])) return json(['status' => $this->errorCode, 'msg' => 'mobile参数不能为空']);
        $data['member_type'] = 1;
        try {
            $res = checkData(MemberDb::getWhereInfo($data));//查询会员信息
            $userres = db()->table('cd_user')->where(['member_id' => $res['member_id']])->find();//用会员id查询绑定的管理员ID
            //mlog('getuserbymobile:'.json_encode($userres));
            $res['user_id'] = $userres['user_id'];//将管理员ID赋值给输出
        } catch (\Exception $e) {
            return json(['status' => $this->errorCode, 'msg' => $e->getMessage()]);
        }
        Log::info('接口输出：' . print_r($res, true));
        return json(['status' => $this->successCode, 'data' => $res]);
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /Member/alipaylogin 05、支付宝小程序登录
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  支付宝小程序登录
     * @apiParam (输入参数：) {string}            code 小程序传入
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */
    function alipaylogin()
    {

        $userInfo = \utils\alipay\UserService::getUserInfo($this->request->param(false));    //获取小程序用户信息
        if (!$userInfo) return json(['status' => $this->errorCode, 'msg' => '小程序信息获取失败']);
        $memberInfo = MemberDb::getWhereInfo(['ali_user_id' => $userInfo['user_id']], 'member_id,nickname,headimgurl,mobile,sex,ali_user_id,status,create_time');    //查询用户表的当前openid是否存在
        //如果用户信息已经存在 则返回用户信息 并且生成token 将用户ID写入token
        if ($memberInfo) {
            $ret = ['code' => 0,'status' => $this->successCode, 'data' => $memberInfo, 'token' => $this->setToken($memberInfo['member_id'])];
            // //查询是否有演示钥匙，没有就加一个，演示钥匙默认id为2
            $lockauthres = LockAuthDb::getWhereInfo(['lock_id' => 2,'member_id' => $memberInfo['member_id']],'lockauth_id');
            if(!$lockauthres)
            {
                LockAuth::Addtestauth(2, $memberInfo['member_id'], 1, 0);
            }
            return json($ret);
        } else {
            //$data['username']		= $userInfo['user_name'];		//用户名;
            //$data['headimgurl']		= $userInfo['avatar'];	//用户头像
            //$data['sex']			= $userInfo['gender'];		//用户性别;
            $data['ali_user_id'] = $userInfo['user_id'];        //用户openid
            $data['openid'] = $userInfo['user_id'];        //用户openid
            $data['status'] = 1;
            $data['member_type'] = 2;
            $data['create_time'] = time();
            $ret = MemberDb::createData($data);    //创建用户 并且返回用户id
            if ($ret) {
                $data['member_id'] = $ret;
                $res = ['code' => 0,'status' => $this->successCode, 'data' => $data, 'token' => $this->setToken($ret)];
                //添加演示钥匙
                //LockAuth::Addtestauth(11, $data['member_id'], 1, 0);
                return json($res);
            }
            return json($memberInfo);
        }
    }
    /*end*/
/*start*/
    /**
     * @api {post} /Member/alipaylogin 05、支付宝小程序登录
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  支付宝小程序登录
     * @apiParam (输入参数：) {string}            code 小程序传入
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */
    function toutiaoauth()
    {
        $appId = config('my.toutiao.toutiao_appid'); // 抖音小程序的AppID
        $appSecret = config('my.toutiao.toutiao_appsecret'); // 抖音小程序的AppSecret
        $code = $this->request->param('code');

        if (!$code) {
            return json(['error' => 'No code provided'], 400);
        }

        mlog("toutiaoauth_code:".$code,"toutiaoauth.txt");

        $url = "https://developer.toutiao.com/api/apps/jscode2session?appid={$appId}&secret={$appSecret}&code={$code}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            return json(['error' => curl_error($ch)], 500);
        }

        curl_close($ch);
        $data = json_decode($output, true);

        if (isset($data['errcode'])) {
            // 错误处理
            return json(['error' => $data['errmsg']], 400);
        }

        $openid = $data['openid'];
        $session_key = $data['session_key'];

        mlog("toutiaoauth_openid:".$openid,"toutiaoauth.txt");
        mlog("toutiaoauth_session_key:".$session_key,"toutiaoauth.txt");

        // 查询抖音用户是否存在
        $memberInfo = MemberDb::getWhereInfo(['tt_user_id' => $openid], 'member_id,nickname,headimgurl,mobile,sex,ali_user_id,status,create_time');

        // 如果用户信息已经存在，则返回用户信息，并且生成token，将用户ID写入token
        if ($memberInfo) {
            // 更新用户的session_key
            MemberDb::editWhere(['tt_user_id' => $openid], ['session_key' => $session_key]);

            $ret = ['code' => 0, 'status' => $this->successCode, 'data' => $memberInfo, 'token' => $this->setToken($memberInfo['member_id'])];

            // 查询是否有演示钥匙，没有就加一个，演示钥匙默认id为2
            $lockauthres = LockAuthDb::getWhereInfo(['lock_id' => 2, 'member_id' => $memberInfo['member_id']], 'lockauth_id');
            if (!$lockauthres) {
                LockAuth::Addtestauth(2, $memberInfo['member_id'], 1, 0);
            }

            return json($ret);
        } else {
            // 如果用户不存在，创建用户
            $data['tt_user_id'] = $openid; // 用户openid
            $data['openid'] = $openid; // 用户openid
            $data['session_key'] = $session_key; // 存储session_key
            $data['status'] = 1;
            $data['member_type'] = 3;
            $data['create_time'] = time();

            $ret = MemberDb::createData($data); // 创建用户，并且返回用户id

            if ($ret) {
                $data['member_id'] = $ret;
                $res = ['code' => 0, 'status' => $this->successCode, 'data' => $data, 'token' => $this->setToken($ret)];

                // 添加演示钥匙
                LockAuth::Addtestauth(11, $data['member_id'], 1, 0);

                return json($res);
            }

            return json($memberInfo);
        }
    }
    // 解密手机号的函数
    public function gettoutiaophonenumber()
    {
        // 获取前端传递的加密数据和 iv
        $encryptedData =  Request::param('encryptedData');
        $iv = Request::param('iv');
        //获取用户ID
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $memberInfo = MemberDb::getWhereInfo(['member_id' => $member_id], 'session_key');
        $sessionKey = $memberInfo['session_key'];

        if (!$encryptedData || !$iv || !$sessionKey) {
            return json(['code' => 400, 'msg' => '缺少参数']);
        }

        // 开始解密过程
        try {
            $data = $this->decryptData($encryptedData, $iv, $sessionKey);

            if ($data) {
                return json(['code' => 10000, 'msg' => '解密成功', 'data' => $data]);
            } else {
                return json(['code' => 400, 'msg' => '解密失败']);
            }
        } catch (\Exception $e) {
            return json(['code' => 500, 'msg' => '服务器内部错误: ' . $e->getMessage()]);
        }
    }
    // 解密函数
    private function decryptData($encryptedData, $iv, $sessionKey)
    {
        // 使用 base64 解码数据
        $sessionKey = base64_decode($sessionKey);
        $iv = base64_decode($iv);
        $encryptedData = base64_decode($encryptedData);

        // 使用AES解密
        $decrypted = openssl_decrypt($encryptedData, 'AES-128-CBC', $sessionKey, OPENSSL_RAW_DATA, $iv);

        // 转换为 PHP 数组
        $data = json_decode($decrypted, true);

        if ($data == null) {
            return false; // 解密失败
        }

        return $data;
    }
    /*end*/

    /*start*/
    /**
     * @api {post} /Member/xcxlogin 01、小程序登录
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  小程序登录
     * @apiParam (输入参数：) {string}            code 小程序传入
     * @apiParam (输入参数：) {string}            encryptedData 小程序传入
     * @apiParam (输入参数：) {string}            iv 小程序传入
     * @apiParam (输入参数：) {string}            user_id 扫码带过来的管理员id
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */
    function xcxlogin()
    {
        $wxuser = \utils\wechart\UserService::getXcxUserInfo($this->_data);    //获取小程序用户信息
        if (!$wxuser) return json(['status' => $this->errorCode, 'msg' => '小程序信息获取失败']);
        //mlog("xcxlogin_wxuser:" . json_encode($wxuser));
        $returnField = 'member_id,nickname,headimgurl,openid,mobile,username,password,sex,status,create_time';
        $res = MemberDb::getWhereInfo(['openid' => $wxuser['openId']], $returnField);    //查询用户表的当前openid是否存在
        //如果用户信息已经存在 则返回用户信息 并且生成token 将用户ID写入token
        if ($res) {
            $ret = ['status' => $this->successCode, 'data' => $res, 'token' => $this->setToken($res[''])];

            return json($ret);
        } else {
            $data['nickname'] = $wxuser['nickName'];        //用户名;
            $data['headimgurl'] = $wxuser['avatarUrl'];    //用户头像
            $data['sex'] = $wxuser['gender'];        //用户性别;
            $data['openid'] = $wxuser['openId'];        //用户openid
            $data['username'] = $wxuser['openId'];        //用户名
            $data['password'] = md5($wxuser['openId'] . config('my.password_secrect'));    //密码
            $data['status'] = 1;
            $data['member_type'] = 1;
            $data['user_id'] = $this->_data['user_id'];
            $data['create_time'] = time();

            $ret = MemberDb::createData($data);    //创建用户 并且返回用户id
            if ($ret) {
                $returnField = 'member_id,nickname,headimgurl,openid,mobile,username,password,sex,status,create_time';
                $reu = MemberDb::getWhereInfo(['openid' => $wxuser['openId']], $returnField);    //查询用户表的当前openid是否存在

                $reut = ['status' => $this->successCode, 'data' => $reu, 'token' => $this->setToken($res[''])];
                return json($reut);
            }
            return json($res);
        }
    }
    /*end*/
    /*start*/
    /**
     * @api {post} /Member/login 10、小程序登录
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  小程序登录
     * @apiParam (输入参数：) {string}            code 小程序传入
     * @apiParam (输入参数：) {string}            encryptedData 小程序传入
     * @apiParam (输入参数：) {string}            iv 小程序传入
     * @apiParam (输入参数：) {string}            user_id 扫码带过来的管理员id
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */
    function login()
    {
        $wxuser = \utils\wechart\UserService::getXcxUserOpenid($this->_data);    //获取小程序用户信息
        if (!$wxuser) return json(['status' => $this->errorCode, 'msg' => '小程序信息获取失败']);
        $returnField = 'member_id,nickname,headimgurl,openid,mobile,username,password,sex,status,create_time';
        $memberInfo = MemberDb::getWhereInfo(['openid' => $wxuser['openid']], $returnField);    //查询用户表的当前openid是否存在

        //如果用户信息已经存在 则返回用户信息 并且生成token 将用户ID写入token
        if ($wxuser['unionid'] && !$memberInfo['unionid']) {
            MemberDb::editWhere(['openid' => $memberInfo['openid']], ['unionid' => $wxuser['unionid']]);
        }
        if (!$memberInfo) {
            //$data['nickname']		= $wxuser['nickname'];		//用户名;
            //$data['headimgurl']		= $wxuser['headimgurl'];	//用户头像
            //$data['sex']			= $wxuser['sex'];		//用户性别;
            $data['openid'] = $wxuser['openid'];        //用户openid
            $data['username'] = $wxuser['openid'];        //用户名
            $data['password'] = md5($wxuser['openid'] . config('my.password_secrect'));    //密码
            $data['status'] = 1;//默认启用状态
            $data['member_type'] = 1;//微信用户
            $data['user_id'] = 0;
            $data['create_time'] = time();
            $data['unionid'] = $wxuser['unionid'] ? $wxuser['unionid'] : '0';
            $ret = MemberDb::createData($data);    //创建用户 并且返回用户id
            if ($ret) {
                $returnField = 'member_id,nickname,headimgurl,openid,mobile,username,password,sex,status,create_time';
                $memberInfo = MemberDb::getWhereInfo(['openid' => $wxuser['openid']], $returnField);    //查询用户表的当前openid是否存在
                $reu['useradmininfo'] = [];

            }
        }

        $useradmininfo = db()->name('user')->where(["member_id" => $memberInfo['member_id']])->find();
        if ($useradmininfo) {
            $memberInfo['useradmininfo'] = $useradmininfo;
        } else {
//
//            UserServer::Add("默认用户",uniqid(),"a123456",$memberInfo['member_id']);
//            $useradmininfo=db()->name('user')->where(["member_id"=>$memberInfo['member_id']])->find();
            $memberInfo['useradmininfo'] = [];
        }
        return json([
            'status' => $this->successCode,
            "code" => 0,
            'data' => $memberInfo,
            'token' => $this->setToken($memberInfo['member_id'])
        ]);

    }


    function loginQrCode()
    {
        $uid = $this->_data["uid"];

        $result = input("result");
        $key = "login:" . $result;
        $useradmininfo=db()->name('user')->where(["member_id"=>$uid])->find();
        if(!$useradmininfo){
            UserServer::Add("默认用户",uniqid(),"a123456",$uid);

        }
        $res = Redis::Redis()->get($key);
        if (!$res) {
            Redis::Redis()->set($key, $uid,7200);
            return json(["code" => 0]);
        }
        return json(["code" =>1]);

    }
    /*end*/
    /*start*/
    /**
     * @api {post} /Member/getphonenumber 08、获取微信绑定手机号
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  获取绑定手机号
     * @apiParam (输入参数：) {string}            code 小程序传入
     * @apiParam (输入参数：) {string}            encryptedData 小程序传入
     * @apiParam (输入参数：) {string}            iv 小程序传入
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * {"status":"200","msg":"操作成功"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */

    function getphonenumber()
    {

        $phonenumberdata = \utils\wechart\UserService::getXcxUserPhone($this->_data);    //获取小程序用户信息
        if (!$phonenumberdata) return json(['status' => $this->errorCode, 'msg' => '用户信息获取失败']);
        //mlog("getweixinphonenumber_data:".json_encode($phonenumberdata));

        Db::name("member")->where(["member_id"=>$this->_data["uid"]])->update(["mobile"=>$phonenumberdata]);

        return $phonenumberdata;
    }
    /*end*/


    /*start*/
    /**
     * @api {post} /Member/getalipayphonenumber 09、获取支付宝绑定手机号
     * @apiGroup Member
     * @apiVersion 1.0.0
     * @apiDescription  获取绑定手机号
     * @apiParam (输入参数：) {string}            encryptedData 小程序传入
     * @apiParam (失败返回参数：) {object}        array 返回结果集
     * @apiParam (失败返回参数：) {string}        array.status 返回错误码 201
     * @apiParam (失败返回参数：) {string}        array.msg 返回错误消息
     * @apiParam (成功返回参数：) {string}        array 返回结果集
     * @apiParam (成功返回参数：) {string}        array.status 返回错误码 200
     * @apiParam (成功返回参数：) {string}        array.msg 返回成功消息
     * @apiSuccessExample {json} 01 成功示例
     * 支付宝小程序端代码示例
     * onGetAuthorize(){
     * my.getPhoneNumber({
     * success: (res) => {
     * let encryptedData = res.response;
     * console.log('getPhoneNumber-res')
     * console.log(encryptedData)
     * my.request({
     * url: 'https://your-domain.example/api/Member/getalipayphonenumber',
     * method:'POST',
     * data:encryptedData,
     * success: (resa) => {
     * console.log('request-resa')
     * console.log(resa)
     * },
     * fail: (error) => {
     * console.log('error')
     * console.log(error)
     * }
     * });
     * },
     * fail: (res) => {
     * console.log(res);
     * console.log('getPhoneNumber_fail');
     * },
     * });
     * }
     * {"code":"10000","msg":"Success","mobile":"13800000000"}
     * @apiErrorExample {json} 02 失败示例
     * {"status":"201","msg":"操作失败"}
     */

    function getalipayphonenumber()
    {
        $param = $this->request->param(false);

        if (!$param) return json(['status' => $this->errorCode, 'msg' => '加密串不能为空']);
        $phonenumberdata = \utils\alipay\UserService::getAlipayUserPhone($param);    //获取小程序用户信息
        if (!$phonenumberdata) return json(['status' => $this->errorCode, 'msg' => '用户信息获取失败']);
        //mlog("getalipayphonenumber_data:".json_encode($phonenumberdata));
        return $phonenumberdata;
    }
    /*end*/


}
