<?php


namespace app\api\controller\device;


use app\module\code\Code;

use app\module\hardwareCloud\HardwareCloud;
use think\facade\Db;

class Pwd
{
    public function list()
    {




        $lock_id = input("lock_id");
        $limit = input("limit",100);
        $page = input("page",1);
        $search_key = input("search_key");

        $fingerModel= Db::name("pwd")->where(["lock_id" => $lock_id])->whereNull("deleted_at");

        if($search_key){
            $fingerModel->where("finger_name","like","%{$search_key}%");
        }

        $count =$fingerModel->count();
        $pwdS = $fingerModel->page($page,$limit)->select()->toArray();
        return json(Code::CodeOk([
            "data" => $pwdS,
            "count" => $count,
        ]));
    }

    public function add()
    {
        $lock_id = input("lock_id");
        $pwd = input("pwd");
        $pwd_name = input("pwd_name");
        $end_time = input("end_time");


        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if (strlen($pwd)<4){
            return json(Code::CodeErr(1001,"密码不能小于4位"));
        }

       $addres= HardwareCloud::WifiLock()->PwdAdd($lock["lock_sn"], $pwd, $lock["device_cid"], 0, $end_time);
        if($addres["err"]){
           return json(Code::CodeErr(1000,$addres["err"],[$addres,$end_time]));
        }
        Db::name("pwd")->insert([
            "lock_id" => $lock_id,
            "pwd" => $pwd,
            "pwd_name" => $pwd_name,
            "end_time" => $end_time,
            "created_at" => time(),
        ]);
        return json(Code::CodeOk(["res"=>$addres,"cs"=>[$end_time]]));
    }

    public function temporaryPassword()
    {
        $lock_id = input("lock_id");

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();

        $addres= HardwareCloud::WifiLock()->PasswordTemporary($lock["lock_sn"], $lock["device_cid"], $lock["admin_pwd"]);
        if($addres["err"]){
            return json(Code::CodeErr(1000,$addres["err"]));
        }

        return json(Code::CodeOk([
            "data"=>$addres,



        ]));
    }

    public function del()
    {
        $lock_id = input("lock_id");
        $pwd_id = input("pwd_id");
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if($pwd_id)
        {
            $pwd = Db::name("pwd")->where(["pwd_id" => $pwd_id])->find();
            $addres= HardwareCloud::WifiLock()->PwdDel($lock["lock_sn"], $pwd["pwd"], $lock["device_cid"]);
            if($addres["err"]){
                return json(Code::CodeErr(1000,$addres["err"],[$lock,$addres,$pwd]));
            }
            Db::name("pwd")->where(["pwd_id" => $pwd_id])->update(["deleted_at"=>date("Y-m-d H:i:s")]);
        }
        else
        {
            $delres= HardwareCloud::WifiLock()->PwdDelAll($lock["lock_sn"], $lock["device_cid"]);
            if($delres["err"]){
                return json(Code::CodeErr(1000,$delres["err"],[$lock,$delres]));
            }
            Db::name("pwd")->where(["lock_id" => $lock_id])->update(["deleted_at"=>date("Y-m-d H:i:s")]);
        }
        return json(Code::CodeOk([]));
    }
}
