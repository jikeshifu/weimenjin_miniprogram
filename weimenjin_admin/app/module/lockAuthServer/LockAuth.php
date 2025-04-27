<?php


namespace app\module\lockAuthServer;


use app\module\code\Code;
use app\module\device\server\DeviceGroup;
use app\module\member\memberServer\MemberServer;
use think\facade\Db;

class LockAuth
{
    static function Add($lock_id, $member_id, $user_id, $device_group_id = 0)
    {

        $authdata['lock_id'] = $lock_id;
        $authdata['member_id'] = $member_id;
        $authdata['auth_member_id'] = 0;
        $authdata['auth_shareability'] = 1;
        $authdata['auth_sharelimit'] = 0;
        $authdata['auth_openlimit'] = 0;
        $authdata['auth_starttime'] = time();
        $authdata['auth_isadmin'] = 1;
        $authdata['auth_status'] = 1;
        $authdata['device_group_id'] = $device_group_id;
        $authdata['user_id'] = $user_id;
        \xhadmin\service\api\LockAuthService::applyauth($authdata);
    }
    //添加演示钥匙
    static function Addtestauth($lock_id, $member_id, $user_id, $device_group_id = 0)
    {

        $authdata['lock_id'] = $lock_id;
        $authdata['member_id'] = $member_id;
        $authdata['auth_member_id'] = 1;
        $authdata['auth_shareability'] = 0;
        $authdata['auth_sharelimit'] = 0;
        $authdata['auth_openlimit'] = 0;
        $authdata['auth_starttime'] = time();
        $authdata['auth_isadmin'] = 0;
        $authdata['auth_status'] = 1;
        $authdata['device_group_id'] = $device_group_id;
        $authdata['user_id'] = $user_id;
        \xhadmin\service\api\LockAuthService::applyauth($authdata);
    }

    static function AddShareAuth($authdata)
    {

        return \xhadmin\service\api\LockAuthService::applyauth($authdata);
    }


    static function AdminList($lock_id){
        $lockauth = Db::name("lockauth")->where(["lock_id" => $lock_id, "auth_isadmin" => 1])->whereNull("deleted_at")->select()->toArray();

        $ntres = [];
        foreach ($lockauth as $vo) {
            $memberInfo = MemberServer::Info($vo["member_id"]);
            if($memberInfo["unionid"]){
                $ntres[] = ["unionid" => $memberInfo["unionid"]];
            }


        }
        return $ntres;
    }
    static function Info($lockauth_id)
    {

        return Db::name("lockauth")->where(["lockauth_id" => $lockauth_id])->whereNull("deleted_at")->find();
    }

    static function InfoV2($where = [])
    {
        $lockauth = Db::name("lockauth");
        if (isset($where["lock_id"])) {
            $lockauth->where(["lock_id" => $where["lock_id"]]);
        }
        if (isset($where["member_id"])) {
            $lockauth->where(["member_id" => $where["member_id"]]);
        }
        return $lockauth->whereNull("deleted_at")->find();
    }

    static function OpenusedAdd($lockauth_id)
    {
        $info = self::Info($lockauth_id);
        return Db::name("lockauth")->where(["lockauth_id" => $lockauth_id])->update([
            "auth_openused" => $info["auth_openused"] + 1
        ]);
    }

    static function Verify($lockauth_id)
    {
        $err = null;

        $lockAuth = self::Info($lockauth_id);
        if ($lockAuth["auth_isadmin"] != 1) {
            if ($lockAuth["auth_openlimit"] <= $lockAuth["auth_openused"] && $lockAuth["auth_openlimit"] != 0) {
                $err = "开门次数已用完";

            }

            if ($lockAuth["auth_endtime"] && $lockAuth["auth_endtime"] < time()) {
                $err = "钥匙已过期";

            }
            if ($lockAuth["auth_starttime"] && $lockAuth["auth_starttime"] > time()) {
                $err = "未到可开时间";

            }
        }
        return [
            "err" => $err
        ];
    }


    static function Edit($lockauth_id, $data)
    {
        $data["updated_at"] = time();

        return Db::name("lockauth")->where(["lockauth_id" => $lockauth_id])->update($data);
    }

    static function InfoWDeviceGroupId($device_group_id)
    {

        return Db::name("lockauth")->where(["device_group_id" => $device_group_id])->whereNull("deleted_at")->find();
    }


    static function CountWDeviceGroupId($device_group_id, $member_id)
    {
        $device_group = DeviceGroup::Info($device_group_id);
        $lockauth = Db::name("lockauth");
        if ($device_group["type"] == 1) {
            $device_group_id = 0;
            $lockauth->where(["member_id" => $member_id]);
        }
        return $lockauth->where(["device_group_id" => $device_group_id])->whereNull("deleted_at")->count();
    }

    static function DelLockId($lock_id)
    {

        return Db::name("lockauth")->where(["lock_id" => $lock_id])->whereNull("deleted_at")->update(["deleted_at" => date("Y-m-d H:i:s")]);
    }

    static function Del($lockauth_id)
    {

        return Db::name("lockauth")->where(["lockauth_id" => $lockauth_id])->whereNull("deleted_at")->update(["deleted_at" => date("Y-m-d H:i:s")]);
    }

    static function SetMemberId($lockauth_id, $memberId)
    {

        return Db::name("lockauth")->where(["lockauth_id" => $lockauth_id])->update(["member_id" => $memberId]);
    }
}
