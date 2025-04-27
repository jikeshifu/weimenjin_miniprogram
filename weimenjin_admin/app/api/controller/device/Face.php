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
        //查出所有需要同步的人脸
        $lockface = Db::name("face")->where(["lock_id" => $p_lock_id])->whereNull("deleted_at")->select()->toArray();
        //遍历需要同步的人脸设备ID
        //mlog(json_encode($lock_ids),"syncface.txt");
        foreach ($lock_ids as $lock_idsVo) {
            //mlog($lock_idsVo,"syncface.txt");
            foreach ($lockface as $arrVo) {
                $arrVo["lock_id"] = $lock_idsVo;
                $arrVo["sync_status"] = 0;

                // 查询是否存在相同的face_images记录
                $islockface = Db::name("face")
                    ->where(["lock_id" => $lock_idsVo, "face_images" => $arrVo["face_images"]])
                    ->whereNull("deleted_at")
                    ->find();

                if (!$islockface) {
                    // 如果记录不存在，移除face_id并插入新数据
                    unset($arrVo["face_id"]);
                    Db::name("face")->insert($arrVo);
                } else {
                    // 如果记录存在，更新sync_status为0
                    mlog("记录存在:".$islockface["face_id"],"syncface.txt");
                    Db::name("face")
                        ->where("face_id", $islockface["face_id"]) // 使用查询到的face_id
                        ->update(["sync_status" => 0]);
                }
            }
        }
        return json(Code::CodeOk(["msg" => "同步成功"]));

    }

    public function add()
    {
        $uidInfo = MemberServer::Uid();
        $member_id = $uidInfo["uid"];
        $lock_id = input("lock_id");
        $info = \app\module\lockAuthServer\LockAuth::InfoV2([
            "lock_id" => $lock_id,
            "member_id" => $member_id,
        ]);
        //非管理员只能录入1张图片
        if ($info["auth_isadmin"] != 1) {
            //钥匙次数有限制直接不让录人脸
            if ($info["auth_openlimit"] > 0) {
                return json(Code::CodeErr(1000, "没有添加人脸权限"));
            }
            $face = Db::name("face")->where(["lock_id" => $lock_id, "member_id" => $member_id])->whereNull("deleted_at")->find();
            if ($face) {
                return json(Code::CodeErr(1000, "已有人脸不可重复添加"));
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

        $host = "https://" . $_SERVER['HTTP_HOST']; // 获取当前访问的域名
        $face_image_url = $host . $face_images; // 拼接完整的图片 URL
        $addres = HardwareCloud::Face()->Add($lock["lock_sn"], $sCertificateNumber, $face_image_url, $end_time, $face_name);
        mlog(json_encode($addres),"addface.txt");
        if ($addres["err"]) {
            return json(Code::CodeErr(1000, $addres["err"]));
        }
        if ($addres["res"]["data"]["info"]["stateCode"] == 203) {
            $sCertificateNumber = $addres["res"]["data"]["info"]["existCertificateNumber"];
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
                "face_feature" => $addres["res"]["data"]["info"]["feature"],
                "created_at" => time(),
            ]);
        } else {
            Db::name("face")->where(["face_id" => $face["face_id"]])->update([

                "face_name" => $face_name,
                "face_images" => $face_images,
                "face_feature" => $addres["res"]["data"]["info"]["feature"],
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

    //清空设备上的所有人脸
    public function clearallface()
    {
        $lock_id = input("lock_id");
        $type = input("type");
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $addres = HardwareCloud::Face()->Clear($lock["lock_sn"]);
        if ($addres["err"]) {
            return json(Code::CodeErr(1000, $addres["err"], $addres));
        }
        if ($type == "cloud") {
            //Db::name("face")->where(["lock_id" => $lock_id])->update(["deleted_at" => date("Y-m-d H:i:s")]);
            //物理删除
            Db::name("face")->where(["lock_id" => $lock_id])->delete();
        }
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
