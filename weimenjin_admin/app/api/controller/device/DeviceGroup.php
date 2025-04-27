<?php


namespace app\api\controller\device;


use app\api\controller\Jwt;
use app\module\code\Code;
use app\module\member\memberServer\MemberServer;
use think\facade\Db;
use think\Request;


class DeviceGroup
{

    public function switch(){


        $device_group_id =input("device_group_id");
        $lockauth_id =input("lockauth_id");
        Db::name("lockauth")->where(["lockauth_id"=>$lockauth_id])->update([
            "device_group_id"=>$device_group_id
        ]);
        $Res = MemberServer::Uid();
        \app\module\device\server\DeviceGroup::ClearCache($Res["uid"]);
        return json(Code::CodeOk(["msg" => "切换成功"]));

    }

    public function all()
    {
        $Res = MemberServer::Uid();
        $all = \app\module\device\server\DeviceGroup::All($Res["uid"]);
        return json(Code::CodeOk(["data" => $all]));
    }


    public function add()
    {
        $Res = MemberServer::Uid();
        $device_group_name = input("device_group_name");


        \app\module\device\server\DeviceGroup::Add([
            "member_id" => $Res["uid"],
            "device_group_name" => $device_group_name
        ]);
        return json(Code::CodeOk(["msg" => "添加分组成功"]));
    }

    public function del()
    {
        $Res = MemberServer::Uid();
        $device_group_id = input("device_group_id");

        $DelRes = \app\module\device\server\DeviceGroup::Del($device_group_id);

        if($DelRes["err"]){

            return json(Code::CodeErr(1000,$DelRes["err"],$DelRes));
        }

        return json(Code::CodeOk(["msg" => "删除分组成功"]));
    }

    public function edit()
    {
        $Res = MemberServer::Uid();
        $device_group_id = input("device_group_id");
        $device_group_name = input("device_group_name");

        \app\module\device\server\DeviceGroup::Edit($device_group_id, ["device_group_name" => $device_group_name]);
        return json(Code::CodeOk(["msg" => "编辑分组成功"]));
    }


}
