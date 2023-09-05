<?php


namespace app\api\controller\device;

use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\Lock;
use think\facade\Db;

class Card
{
    public function list()
    {

        $lock_id = input("lock_id");
        $limit = input("limit");
        $page = input("page");
        $search_key = input("search_key");

        $cardModel= Db::name("lockcard")->where(["lock_id" => $lock_id])->whereNull("deleted_at");

        if($search_key){
            $cardModel->where("lockcard_username","like","%{$search_key}%");
        }

        $count =$cardModel->count();
        $cardS = $cardModel->page($page,$limit)->order("lockcard_id desc")->select()->toArray();
        return json(Code::CodeOk([
            "data" => $cardS,
            "count" => $count,
        ]));
    }
    public function info()
    {

        $lockcard_id = input("lockcard_id");
        $cardS = Db::name("lockcard")->where(["lockcard_id" => $lockcard_id])->find();
        if($cardS["end_time"]==0){
            $cardS["end_time"]=time();
        }
        return json(Code::CodeOk([
            "data" => $cardS
        ]));
    }
    public function add()
    {




        $data["lockcard_username"] = input("lockcard_username");
        $data["lockcard_endtime"] =  input("lockcard_endtime");
        $data["lockcard_remark"] = input("lockcard_remark");
        $data["lockcard_sn"] = input("lockcard_sn");
        $data["lock_id"] = input("lock_id");
        $data["lockcard_createtime"] =time();
        $lockdata= Lock::Info($data["lock_id"]);
        $result = \app\module\lockServer\Lock::CardAdd($lockdata,$data['lockcard_sn'],$data['lockcard_endtime']);
        if($result["state"]==0){
//            [state] => 0
//    [state_code] => 2002
//    [state_msg] => 卡序列号应为8位,不含:号
            return json(Code::CodeErr(1000,$result["state_msg"],$result));
        }

        Db::name("lockcard")->insert($data);
        return json(Code::CodeOk(["data"=>$result]));
    }

    public function edit()
    {
        $lock_id = input("lock_id");
        $lockcard_id = input("lockcard_id");



        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $card= Db::name("lockcard")->where(["lockcard_id" => $lockcard_id])->find();

        $data["lockcard_username"] = input("lockcard_username");
        $data["lockcard_endtime"] = input("lockcard_endtime");
        $data["lockcard_remark"] = input("lockcard_remark");

        $data["lockcard_sn"] = input("lockcard_sn");
        $lockdata= Lock::Info($lock_id);
        $result = \app\module\lockServer\Lock::CardAdd($lockdata,$data['lockcard_sn'],$data['lockcard_endtime']);
        if($result["state"]==0){
//            [state] => 0
//    [state_code] => 2002
//    [state_msg] => 卡序列号应为8位,不含:号
            return json(Code::CodeErr(1000,$result["state_msg"],$result));
        }

        Db::name("lockcard")->where(["lockcard_id"=>$lockcard_id])->update($data);
        return json(Code::CodeOk([]));
    }
    public function del()
    {

        $lockcard_id = input("lockcard_id");

        $lockcard=  Db::name("lockcard")->where(["lockcard_id"=>$lockcard_id])->find();
        $lockdata= Lock::Info($lockcard["lock_id"]);

        //执行远程删除
        $result=  \app\module\lockServer\Lock::CardDel($lockdata,$lockcard['lockcard_sn']);
        if($result["state"]==0){

            return json(Code::CodeErr(1000,$result["state_msg"],[$lockcard,$result]));
        }

        Db::name("lockcard")->where(["lockcard_id" => $lockcard_id])->update(["deleted_at"=>date("Y-m-d H:i:s")]);
        return json(Code::CodeOk([]));
    }
}
