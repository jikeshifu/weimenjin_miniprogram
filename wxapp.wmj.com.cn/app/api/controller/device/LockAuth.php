<?php


namespace app\api\controller\device;


use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\Lock;
use app\module\lockServer\LockLog;
use app\module\member\memberServer\MemberServer;
use app\module\redis\Redis;
use think\facade\Db;
use xhadmin\db\LockAuth as LockAuthDb;
use xhadmin\service\api\LockAuthService;

class LockAuth
{
    public function list()
    {

        $lockauth_id = input("lockauth_id");
        $uidInfo = MemberServer::Uid();

        Redis::Redis()->set("applyAuth:".$uidInfo["uid"],$lockauth_id,360);


        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        $limit = input("limit");

        $page = input("page");
        $search_key = input("search_key");


        $LockAuthModel = \app\module\model\LockAuth::whereNull("deleted_at")->where(function ($q){
            $q->whereOr("auth_member_id",">",0);
            $q->whereOr(function ($q1){
                $q1->whereNull("auth_member_id");
            });
        });
        $LockAuthModel->where(["lock_id" => $lockAuth["lock_id"],])->whereNotNull('member_id');
        if ($search_key) {


                $member =Db::name("member")->where(["mobile"=>$search_key])->find();
                if($member){
                    $LockAuthModel->where(["member_id"=>$member["member_id"]]);
                }else{
                $LockAuthModel->where("arealname", "like", "%{$search_key}%");
            }

        }



        $auth_status = input("auth_status");
        $LockAuthModel->where(["auth_status" => $auth_status]);


        $count = $LockAuthModel->count();
        $list = $LockAuthModel->with(["memberInfo"])->page($page, $limit)->select()->toArray();
        $list1 = [];
        foreach ($list as $vo) {
            $list1[] = [
                "lockauth_id" => $vo["lockauth_id"],
                "aremark" => $vo["aremark"],
                "mobile" => $vo["memberInfo"]["mobile"],
                "headimgurl" => $vo["memberInfo"]["headimgurl"],
                "nickname" => $vo["memberInfo"]["nickname"],
                "auth_status" => $vo["auth_status"],
                "auth_starttime" => $vo["auth_starttime"],
                "auth_endtime" => $vo["auth_endtime"],
                "auth_member_id" => $vo["auth_member_id"],
                "auth_sharelimit" => $vo["auth_sharelimit"],
                "auth_openlimit" => $vo["auth_openlimit"],
                "auth_shareability" => $vo["auth_shareability"],
            ];


        }
        return json(Code::CodeOk([
            "data" => $list1,

//          "list" => $list,

            "count" => $count,
        ]));
    }

    public function info()
    {

        $lockauth_id = input("lockauth_id");


        $LockAuthModel = \app\module\model\LockAuth::whereNull("deleted_at");

        $LockAuthModel->where(["lockauth_id" => $lockauth_id]);

        $info = $LockAuthModel->with(["memberInfo"])->find()->toArray();

        $list1 = [
            "lockauth_id" => $info["lockauth_id"],
            "aremark" => $info["aremark"],
            "mobile" => $info["memberInfo"]["mobile"],
            "headimgurl" => $info["memberInfo"]["headimgurl"],
            "nickname" => $info["memberInfo"]["nickname"],
            "auth_status" => $info["auth_status"],
            "auth_starttime" => $info["auth_starttime"],
            "auth_endtime" => $info["auth_endtime"],
            "auth_member_id" => $info["auth_member_id"],
            "auth_isadmin" => $info["auth_isadmin"],
            "auth_sharelimit" => $info["auth_sharelimit"],
            "auth_openlimit" => $info["auth_openlimit"],
            "auth_shareability" => $info["auth_shareability"],

        ];
        return json(Code::CodeOk([
            "data" => $list1,

        ]));
    }

    function applyAuth()
    {

        $uidInfo = MemberServer::Uid();


        $data['member_id'] = $uidInfo["uid"];


        $data["lock_id"] = input("lock_id");
        $lockauth = Db::name("lockauth")->where(["lock_id" => $data["lock_id"], "member_id" => $data['member_id']])->whereNull("deleted_at")->find();


        if ($lockauth) {
            return json(Code::CodeErr(1000, "您已经申请过，请等待审核"));
        }


        $data["aremark"] = input("aremark");
        $data["realname"] = input("user_name");
        MemberServer::Edit($data['member_id'],["realname"=> $data["realname"],"remark"=>$data["aremark"]]);
        $data["auth_starttime"] = time();
        $data["auth_endtime"] = null;
        $lockInfo = Lock::Info($data["lock_id"]);
        //创建用户
        MemberServer::UMember($uidInfo["uid"],$lockInfo["user_id"]);

        if ($lockInfo) {


            $data["auth_member_id"]=$lockInfo["member_id"];
            if($lockInfo["applyauth_check"]==0){
                $data["auth_status"]=1;
            }
            $data["auth_member_id"]=$lockInfo["member_id"];
        }
        $lockdata = Lock::Info($data["lock_id"]);
        $data["user_id"]=$lockdata["user_id"];
        $res = \app\module\lockAuthServer\LockAuth::AddShareAuth($data);


        if($lockInfo["applyauth_check"]==0){


            return json(Code::CodeErr(1001, "申请成功"));

        }

        $user_name = input("user_name");



        $member = MemberServer::Info($data['member_id']);



        $lockauth = Db::name("lockauth")->where(["lock_id" => $data["lock_id"]])->whereNull("deleted_at")->find();
        $senddata['lock_id'] = $data['lock_id'];
        $senddata['lockauth_id'] = $lockauth['lockauth_id'];
        $senddata['lockname'] = $lockdata['lock_name'];
        $senddata['username'] = $user_name . "-" . $lockdata['lock_name'];
        $senddata['mobile'] = $member["mobile"];
        $senddata['uniondata'] =    \app\module\lockAuthServer\LockAuth::AdminList($data["lock_id"]);

        $examinentRes = wmjSendWechatMsg('examinentNew', $senddata);


        return json(Code::CodeOk(['status' => 200, 'msg' => '操作成功，等待审核', "data" => $examinentRes]));
    }

    function edit()
    {

        $lockauth_id = input("lockauth_id");
        $data["auth_sharelimit"] = input("auth_sharelimit");
        $data["auth_openlimit"] = input("auth_openlimit");
        $data["auth_starttime"] = input("auth_starttime");
        $data["auth_endtime"] = input("auth_endtime");
        $data["auth_shareability"] = input("auth_shareability");
        $data["aremark"] = input("aremark");
        $data["auth_status"] = input("auth_status");
        $data["auth_isadmin"] = input("auth_isadmin");
        \app\module\lockAuthServer\LockAuth::Edit($lockauth_id, $data);
        return json(Code::CodeOk(["msg" => "编辑成功"]));


    }

    function shareAuth()
    {

        $lockauth_id = input("lockauth_id");

        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $uidRes = MemberServer::Uid();
        $data['auth_member_id'] = $uidRes["uid"];


        $data["lock_id"] = $lockAuth["lock_id"];
        $data["auth_sharelimit"] = input("auth_sharelimit");
        $data["auth_openlimit"] = input("auth_openlimit");
        $data["auth_starttime"] = input("auth_starttime");
        $data["auth_endtime"] = input("auth_endtime");
        $data["auth_shareability"] = input("auth_shareability");
        $data["aremark"] = input("remark");
        $data["auth_status"] = input("auth_status");


        $res = \app\module\lockAuthServer\LockAuth::AddShareAuth($data);

        $data['member_id'] = $uidRes["uid"];;
        $data['lock_id'] = $lockAuth["lock_id"];

        $data['status'] = 1;
        $data["type"]=10;

        \xhadmin\service\api\LockLogService::add($data);
        return json(Code::CodeOk(["msg" => "生成钥匙成功", "data" => ["share_lockauth_id" => $res]]));

    }

    function getShareAuth()
    {
        $lockauth_id = input("share_lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $uidRes = MemberServer::Uid();

        if ($lockAuth["auth_member_id"] == $uidRes["uid"]) {
            return json(Code::CodeErr(1000, "本人不能领取"));
        }

        if ($lockAuth["member_id"] == $uidRes["uid"]) {
            return json(Code::CodeErr(1000, "您已领取该钥匙"));
        }

        if ($lockAuth["member_id"] != 0) {
            return json(Code::CodeErr(1001, "钥匙已被领取"));
        }
        \app\module\lockAuthServer\LockAuth::SetMemberId($lockauth_id, $uidRes["uid"]);

        return json(Code::CodeOk(["msg" => "领取成功"]));

    }
}
