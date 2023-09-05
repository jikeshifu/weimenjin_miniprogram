<?php


namespace app\api\controller\device;


use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use think\facade\Db;

class Finger
{
    public function list()
    {

        $lock_id = input("lock_id");
        $limit = input("limit",100);
        $page = input("page",1);
        $search_key = input("search_key");

       $fingerModel= Db::name("finger")->where(["lock_id" => $lock_id])->whereNull("deleted_at");

       if($search_key){
           $fingerModel->where("finger_name","like","%{$search_key}%");
       }

       $count =$fingerModel->count();
        $fingerS = $fingerModel->page($page,$limit)->select()->toArray();
        return json(Code::CodeOk([
            "data" => $fingerS,
            "count" => $count,
        ]));
    }
    public function info()
    {

        $finger_id = input("finger_id");
        $fingerS = Db::name("finger")->where(["finger_id" => $finger_id])->find();
        if($fingerS["end_time"]==0){
            $fingerS["end_time"]=time();
        }
        return json(Code::CodeOk([
            "data" => $fingerS
        ]));
    }
    public function add()
    {
        $lock_id = input("lock_id");

        $finger_name = input("finger_name");
        $end_time = strtotime(input("end_time"));
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();


       $addres= HardwareCloud::WifiLock()->FingerAdd($lock["lock_sn"],  $lock["device_cid"], 0, $end_time);
        if($addres["err"]){
            return json(Code::CodeErr(1000,$addres["err"]));
        }
        Db::name("finger")->insert([
            "lock_id" => $lock_id,
            "fp_id" => $addres["info"]["fp_id"],
            "finger_name" => $finger_name,
            "end_time" => $end_time,
            "created_at" => time(),
        ]);
        return json(Code::CodeOk([]));
    }

    public function edit()
    {
        $lock_id = input("lock_id");
        $finger_id = input("finger_id");

        $finger_name = input("finger_name");
        $end_time = strtotime(input("end_time"));

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $finger= Db::name("finger")->where(["finger_id" => $finger_id])->find();


        $addres= HardwareCloud::WifiLock()->FingerEdit($lock["lock_sn"],  $lock["device_cid"],$finger["fp_id"], time(), $end_time);
        if($addres["err"]){
            return json(Code::CodeErr(1000,$addres["err"]));
        }
        Db::name("finger")->where(["finger_id"=>$finger_id])->update([

            "finger_name" => $finger_name,
            "end_time" => $end_time,

        ]);
        return json(Code::CodeOk([]));
    }
    public function del()
    {
        $lock_id = input("lock_id");
        $finger_id = input("finger_id");
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $finger = Db::name("finger")->where(["finger_id" => $finger_id])->find();
        $addres= HardwareCloud::WifiLock()->FingerDel($lock["lock_sn"], $finger["fp_id"], $lock["device_cid"]);
        if($addres["err"]){
            return json(Code::CodeErr(1000,$addres["err"],$addres));
        }

        Db::name("finger")->where(["finger_id" => $finger_id])->update(["deleted_at"=>date("Y-m-d H:i:s")]);
        return json(Code::CodeOk([]));
    }
}
