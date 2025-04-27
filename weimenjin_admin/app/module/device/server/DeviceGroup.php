<?php


namespace app\module\device\server;


use app\module\lockAuthServer\LockAuth;
use app\module\redis\Redis;
use think\facade\Db;

class DeviceGroup
{
    static function All($member_id)
    {





        $device_group = Db::name("device_group")->where(["member_id" => $member_id])->whereNull("deleted_at")->order("updated_at desc")->select()->toArray();

        if (!$device_group) {

            self::Add(["member_id" => $member_id, "type" => 1, "device_group_name" => "默认分组"]);
            $device_group = Db::name("device_group")->where(["member_id" => $member_id])->whereNull("deleted_at")->select();
        }

        foreach ($device_group as &$vo) {

            $vo["device_count"] = LockAuth::CountWDeviceGroupId($vo["device_group_id"], $member_id);
        }


        return $device_group;
    }


    static function Add($data)
    {



        $data["created_at"] = time();
        Db::name("device_group")->insert($data);

    }

    static function Info($device_group_id)
    {

        return Db::name("device_group")->where(["device_group_id" => $device_group_id])->whereNull("deleted_at")->find();
    }

    static function Del($device_group_id)
    {

        $res["err"] = null;

        $device_group = self::Info($device_group_id);



        //默认分组不可删除
        if ($device_group["type"] == 1) {
            $res["err"] = "默认分组不可删除";
            return $res;
        }
        $LockAuthInfo = LockAuth::InfoWDeviceGroupId($device_group_id);
        //查询分组下设备
        if ($LockAuthInfo) {
            $res["err"] = "分组下存在设备不可删除";
            return $res;
        }

        Db::name("device_group")->where(["device_group_id" => $device_group_id])->update(["deleted_at" => date("Y-m-d H:i:s")]);
        return $res;
    }

    static function Edit($device_group_id, $data)
    {
        Db::name("device_group")->where(["device_group_id" => $device_group_id])->update($data);


    }
}
