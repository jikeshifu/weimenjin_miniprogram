<?php


namespace app\api\controller\device;


use app\api\controller\Base;
use app\module\code\Code;

use app\module\hardwareCloud\HardwareCloud;
use app\module\member\memberServer\MemberServer;
use think\facade\Db;

class Face extends Base
{
    public function list()
    {


        $uidInfo = MemberServer::Uid();
        $data['member_id'] = $uidInfo["uid"];
        $lock_id = input("lock_id");
        $info = \app\module\lockAuthServer\LockAuth::InfoV2([
            "lock_id" => $lock_id,
            "member_id" => $data['member_id'],
        ]);

        $search_key = input("search_key");

        $faceModel = Db::name("face")->where(["lock_id" => $lock_id])->whereNull("deleted_at");

        if ($info["auth_isadmin"] != 1) {
            $faceModel->where(["member_id" => $data['member_id']]);
        }

        if ($search_key) {
            $faceModel->where("face_name", "like", "%{$search_key}%");
        }

        $count = $faceModel->count();
        $pwdS = $faceModel->select()->toArray();
        return json(Code::CodeOk([
            "data" => $pwdS,
            "count" => $count,
        ]));
    }




    public function sync()
    {
        $lock_ids = input("lock_ids");
        $p_lock_id = input("p_lock_id");

        $lockcard = Db::name("face")->where(["lock_id" => $p_lock_id])->whereNull("deleted_at")->select()->toArray();



        foreach ($lock_ids as $lock_idsVo) {
            if($lock_idsVo !=$p_lock_id){
                foreach ($lockcard as $arrVo) {
                    unset($arrVo["face_id"]);
                    $arrVo["lock_id"] = $lock_idsVo;
                    $arrVo["sync_status"] = 0;

                    $lockcard = Db::name("face")->where(["lock_id"=>$lock_idsVo,"face_images"=> $arrVo["face_images"]])->whereNull("deleted_at")->find();
                    if(!$lockcard){
                        Db::name("face")->insert($arrVo);
                    }


                }
            }


        }



        return json(Code::CodeOk(["msg" => "同步成功"]));

    }
    public function add()
    {


        $uidInfo = MemberServer::Uid();
        $member_id= $uidInfo["uid"];
        $lock_id = input("lock_id");
        $info = \app\module\lockAuthServer\LockAuth::InfoV2([
            "lock_id" => $lock_id,
            "member_id" => $member_id,
        ]);

        if ($info["auth_isadmin"] != 1) {
           $face = Db::name("face")->where(["lock_id" => $lock_id,"member_id"=>$member_id])->whereNull("deleted_at")->find();
           if($face){
               return json(Code::CodeErr(1000,"已有人脸不可重复添加"));
           }

        }

        $sCertificateNumber = rand(10000, 99999) . time();

        $face_images = input("face_images");
        $face_name = input("face_name");


        $end_time = input("end_time");

        if (!is_numeric($end_time)) {
            $end_time = strtotime(input("end_time"));
        }

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();


        $addres = HardwareCloud::Face()->Add($lock["lock_sn"], $sCertificateNumber, "https://wxapp.wmj.com.cn" . $face_images, $end_time, $face_name);
        if ($addres["err"]) {


            return json(Code::CodeErr(1000, $addres["err"]));
        }
        if ($addres["data"]["info"]["stateCode"] == 203) {
            $sCertificateNumber = $addres["data"]["info"]["existCertificateNumber"];
        }
        $face = Db::name("face")->where(["lock_id" => $lock_id])->whereNull("deleted_at")->where(["sCertificateNumber" => $sCertificateNumber])->find();
        if (!$face) {
            Db::name("face")->insert([
                "lock_id" => $lock_id,
                "face_name" => $face_name,
                "face_images" => $face_images,
                "member_id" => $member_id,
                "end_time" => $end_time,
                "sCertificateNumber" => $sCertificateNumber,
                "created_at" => time(),
            ]);
        } else {
            Db::name("face")->where(["face_id" => $face["face_id"]])->update([

                "face_name" => $face_name,
                "face_images" => $face_images,
                "end_time" => $end_time,
            ]);
        }

        return json(Code::CodeOk([
            "data" => $addres
        ]));
    }


    public function del()
    {
        $lock_id = input("lock_id");
        $face_id = input("face_id");
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $face = Db::name("face")->where(["face_id" => $face_id])->find();
        $addres = HardwareCloud::Face()->Del($lock["lock_sn"], $face["sCertificateNumber"]);
        if ($addres["err"]) {
            return json(Code::CodeErr(1000, $addres["err"], $addres));
        }
        Db::name("face")->where(["face_id" => $face_id])->update(["deleted_at" => date("Y-m-d H:i:s")]);
        return json(Code::CodeOk([]));
    }


    public function edit()
    {
        $lock_id = input("lock_id");
        $face_id = input("face_id");
        $end_time = input("end_time");

        if (!is_numeric($end_time)) {
            $end_time = strtotime(input("end_time"));
        }
        $face_name = input("face_name");
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $face = Db::name("face")->where(["face_id" => $face_id])->find();
//        $addres = HardwareCloud::Face()->Edit($lock["lock_sn"], $face["sCertificateNumber"]);
//        if ($addres["err"]) {
//            return json(Code::CodeErr(1000, $addres["err"], $addres));
//        }

        Db::name("face")->where(["face_id" => $face_id])->update([
            "end_time" => $end_time,
            "face_name" => $face_name,
        ]);
        return json(Code::CodeOk([]));
    }
}
