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

        // 添加人脸（循环处理可能存在重复人脸的情况）
        $maxRetries = 5; // 最多处理5个重复人脸
        $retryCount = 0;

        do {
            $addres = HardwareCloud::Face()->Add($lock["lock_sn"], $sCertificateNumber, $face_image_url, $end_time, $face_name);
            mlog(json_encode($addres), "addface.txt");

            if ($addres["err"]) {
                return json(Code::CodeErr(1000, $addres["err"]));
            }

            $stateCode = $addres["res"]["data"]["info"]["stateCode"] ?? 0;
            if ($stateCode != 203) {
                break; // 不是203，退出循环
            }

            // 获取设备上已存在的人脸ID
            $existCertNum = $addres["res"]["data"]["info"]["existCertificateNumber"] ??
                            $addres["res"]["data"]["info"]["repeat_face_id"] ?? null;

            if (!$existCertNum) {
                mlog("add-203但无已存在ID，无法处理", "addface.txt");
                break;
            }

            mlog("add-检测到人脸已注册(203)[第{$retryCount}次]: 要添加的ID={$sCertificateNumber}, 已存在ID={$existCertNum}", "addface.txt");

            // 1. 先删除设备上已存在的人脸
            $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $existCertNum);
            if ($delRes["err"]) {
                mlog("add-删除设备人脸失败: {$existCertNum}, " . $delRes["err"], "addface.txt");
            } else {
                mlog("add-删除设备人脸成功: {$existCertNum}", "addface.txt");
            }

            // 2. 同时清理云端数据库中该重复ID的记录（软删除）
            $deletedCount = Db::name("face")
                ->where(["lock_id" => $lock_id, "sCertificateNumber" => $existCertNum])
                ->whereNull("deleted_at")
                ->update(["deleted_at" => date("Y-m-d H:i:s")]);
            if ($deletedCount > 0) {
                mlog("add-清理云端重复记录: lock_id={$lock_id}, sCertificateNumber={$existCertNum}, 删除{$deletedCount}条", "addface.txt");
            }

            $retryCount++;
        } while ($retryCount < $maxRetries);

        // 检查最终添加结果
        $finalStateCode = $addres["res"]["data"]["info"]["stateCode"] ?? 0;
        if ($finalStateCode != 200) {
            $detail = $addres["res"]["data"]["info"]["detail"] ?? "添加失败";
            return json(Code::CodeErr(1000, "添加人脸失败: stateCode={$finalStateCode}, {$detail}"));
        }

        $face = Db::name("face")->where(["lock_id" => $lock_id])->whereNull("deleted_at")->where(["sCertificateNumber" => $sCertificateNumber])->find();
        $face_id = null;
        if (!$face) {
            $face_id = Db::name("face")->insertGetId([
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
            $face_id = $face["face_id"];
            Db::name("face")->where(["face_id" => $face["face_id"]])->update([
                "face_name" => $face_name,
                "face_images" => $face_images,
                "face_feature" => $addres["res"]["data"]["info"]["feature"],
                "end_time" => $end_time,
            ]);
        }

        return json(Code::CodeOk([
            "data" => $addres,
            "face_id" => $face_id
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
        $face_images = input("face_images"); // 新增：获取可能的新图片

        if (!is_numeric($end_time)) {
            $end_time = strtotime(input("end_time"));
        }
        $face_name = input("face_name");
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        $face = Db::name("face")->where(["face_id" => $face_id])->find();

        // 判断是否重新上传了图片
        $hasNewImage = $face_images && $face_images != $face["face_images"];

        if ($hasNewImage) {
            // 情况1：重新上传了图片，需要完全重新添加
            // 先删除旧人脸
            $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $face["sCertificateNumber"]);
            if ($delRes["err"]) {
                mlog("编辑人脸-删除旧数据失败: " . json_encode($delRes), "face_edit.txt");
            }

            // 使用新图片添加（处理可能的203重复人脸情况）
            $host = "https://" . $_SERVER['HTTP_HOST'];
            $face_image_url = $host . $face_images;
            $certNum = $face["sCertificateNumber"];
            $maxRetries = 5;
            $retryCount = 0;

            do {
                $addRes = HardwareCloud::Face()->Add(
                    $lock["lock_sn"],
                    $certNum,
                    $face_image_url,
                    $end_time,
                    $face_name
                );

                if ($addRes["err"]) break;

                $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                if ($stateCode != 203) break;

                // 获取设备上已存在的人脸ID
                $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                $addRes["res"]["data"]["info"]["repeat_face_id"] ?? null;

                if (!$existCertNum) break;

                mlog("edit-检测到人脸已注册(203): 要添加的ID={$certNum}, 已存在ID={$existCertNum}", "face_edit.txt");

                // 删除设备上重复的人脸
                HardwareCloud::Face()->Del($lock["lock_sn"], $existCertNum);

                // 清理云端数据库中该重复ID的记录
                Db::name("face")
                    ->where(["lock_id" => $lock_id, "sCertificateNumber" => $existCertNum])
                    ->where("face_id", "<>", $face_id) // 排除当前编辑的人脸
                    ->whereNull("deleted_at")
                    ->update(["deleted_at" => date("Y-m-d H:i:s")]);

                $retryCount++;
            } while ($retryCount < $maxRetries);

            if ($addRes["err"]) {
                return json(Code::CodeErr(1000, "更新人脸失败: " . $addRes["err"], $addRes));
            }

            $finalStateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
            if ($finalStateCode != 200) {
                $detail = $addRes["res"]["data"]["info"]["detail"] ?? "更新失败";
                return json(Code::CodeErr(1000, "更新人脸失败: stateCode={$finalStateCode}, {$detail}"));
            }

            // 更新数据库，包括新图片和新特征值
            Db::name("face")->where(["face_id" => $face_id])->update([
                "end_time" => $end_time,
                "face_name" => $face_name,
                "face_images" => $face_images,
                "face_feature" => $addRes["res"]["data"]["info"]["feature"] ?? $face["face_feature"],
            ]);

            return json(Code::CodeOk(["msg" => "人脸信息更新成功！"]));

        } else {
            // 情况2：只修改时间/名称，不重新上传图片
            // 使用 Edit 接口直接更新

            // 1. 先更新数据库
            Db::name("face")->where(["face_id" => $face_id])->update([
                "end_time" => $end_time,
                "face_name" => $face_name,
            ]);

            // 2. 使用编辑接口同步到设备
            $phone = $face["phone"] ?? "";
            $editRes = HardwareCloud::Face()->Edit($lock["lock_sn"], $face["sCertificateNumber"], $end_time, $face_name, $phone);

            if ($editRes["err"]) {
                // 同步失败，但数据库已更新
                mlog("编辑人脸-Edit接口失败: " . json_encode($editRes), "face_edit.txt");
                return json(Code::CodeOk([
                    "msg" => "人脸信息已更新，但设备同步失败。如果设备在线，请稍后手动同步人脸数据。",
                    "sync_status" => "failed"
                ]));
            }

            return json(Code::CodeOk(["msg" => "人脸信息更新成功！"]));
        }
    }

    // 查询设备上的人脸信息
    public function find()
    {
        $lock_id = input("lock_id");
        $face_id = input("face_id");

        if (!$lock_id || !$face_id) {
            return json(Code::CodeErr(1000, "缺少必要参数"));
        }

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备不存在"));
        }

        // 调用硬件云API查询人脸信息
        $result = HardwareCloud::Face()->Find($lock["lock_sn"], $face_id);

        if ($result["err"]) {
            return json(Code::CodeErr(1000, $result["err"], $result["res"]));
        }

        return json(Code::CodeOk([
            "data" => $result["res"]["data"]
        ]));
    }

    // 批量同步人脸到多台设备
    public function syncToDevices()
    {
        $source_lock_id = input("source_lock_id");
        $face_id = input("face_id");
        $target_lock_ids = input("target_lock_ids/a"); // 强制转为数组
        $face_name = input("face_name");
        $end_time = input("end_time");
        $face_images = input("face_images");

        // 调试日志
        mlog("syncToDevices 收到参数: face_id={$face_id}, target_lock_ids=" . json_encode($target_lock_ids), "face_sync.txt");

        if (!$face_id || empty($target_lock_ids)) {
            mlog("syncToDevices 缺少参数: face_id={$face_id}, target_lock_ids=" . json_encode($target_lock_ids), "face_sync.txt");
            return json(Code::CodeErr(1000, "缺少必要参数: face_id=" . ($face_id ?: "空") . ", devices=" . count($target_lock_ids ?: [])));
        }

        if (!is_numeric($end_time)) {
            $end_time = strtotime($end_time);
        }

        // 获取源人脸数据
        $sourceFace = Db::name("face")->where(["face_id" => $face_id])->find();
        if (!$sourceFace) {
            return json(Code::CodeErr(1000, "人脸数据不存在"));
        }

        // 获取当前用户ID
        $uidInfo = \app\module\member\memberServer\MemberServer::Uid();
        $member_id = $uidInfo["uid"];

        $host = "https://" . $_SERVER['HTTP_HOST'];
        $faceImagesPath = $face_images ?: $sourceFace["face_images"];
        $face_image_url = $host . $faceImagesPath;
        $feature = $sourceFace["face_feature"];

        $successCount = 0;
        $failCount = 0;
        $offlineCount = 0;
        $results = []; // 详细结果

        foreach ($target_lock_ids as $target_lock_id) {
            $lock = Db::name("lock")->where(["lock_id" => $target_lock_id])->find();
            if (!$lock) {
                $failCount++;
                $results[] = [
                    "lock_id" => $target_lock_id,
                    "lock_name" => "未知设备",
                    "status" => "fail",
                    "error" => "设备不存在"
                ];
                mlog("同步人脸失败-设备不存在: lock_id={$target_lock_id}", "face_sync.txt");
                continue;
            }

            // 关键修正：使用源人脸的ID，确保同一个人在所有设备上的ID一致
            $useCertificateNumber = $sourceFace["sCertificateNumber"];

            // 检查目标设备上是否已存在该人脸ID的记录
            $existFace = Db::name("face")
                ->where(["lock_id" => $target_lock_id, "sCertificateNumber" => $useCertificateNumber])
                ->whereNull("deleted_at")
                ->find();

            $isUpdate = false;
            $isUpdate = false;

            if ($existFace) {
                // 目标设备上已存在该人脸ID，标记为更新模式
                $isUpdate = true;
                mlog("同步人脸-目标设备已存在该人脸ID[{$lock['lock_name']}]: {$useCertificateNumber}，执行更新", "face_sync.txt");
            } else {
                mlog("同步人脸-目标设备新增人脸[{$lock['lock_name']}]: {$useCertificateNumber}", "face_sync.txt");
            }

            // 无论是新增还是更新，都先删除设备上可能存在的旧数据（确保能更新时间）
            // 这里删除失败不阻断流程，因为可能本来就不存在
            $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $useCertificateNumber);
            if (!$delRes["err"]) {
                mlog("同步人脸-已删除设备上的旧数据[{$lock['lock_name']}]: {$useCertificateNumber}", "face_sync.txt");
            }

            // 关键修正：必须使用图片URL添加，不使用特征值
            // 原因：使用特征值添加时，设备无法检测到人脸已存在（无法返回203）
            // 使用图片URL时，设备会自动识别并返回203，我们就能找到并删除重复的人脸
            mlog("同步人脸-使用图片URL添加[{$lock['lock_name']}]: {$face_image_url}", "face_sync.txt");
            $addRes = HardwareCloud::Face()->Add(
                $lock["lock_sn"],
                $useCertificateNumber,
                $face_image_url,
                $end_time,
                $face_name
            );

            // 详细记录添加结果
            mlog("同步人脸-添加结果[{$lock['lock_name']}]: " . json_encode($addRes), "face_sync.txt");

            // 处理结果 - 增加更严格的校验
            if ($addRes["err"]) {
                // API 调用失败
                $isOffline = strpos($addRes["err"], "离线") !== false ||
                             strpos($addRes["err"], "offline") !== false ||
                             strpos($addRes["err"], "超时") !== false ||
                             strpos($addRes["err"], "timeout") !== false;

                if ($isOffline) {
                    $offlineCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "offline",
                        "error" => "设备离线"
                    ];
                } else {
                    $failCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "fail",
                        "error" => $addRes["err"]
                    ];
                }
                continue;
            }

            // API 调用成功，但需要验证 stateCode
            $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;

            // 处理 stateCode 203（设备检测到人脸特征已存在）
            // 关键：设备返回的 existCertificateNumber 可能与我们要添加的 useCertificateNumber 不同
            // 需要删除设备上已存在的旧ID，然后用新ID重新添加
            if ($stateCode == 203) {
                $existCertificateNumber = $addRes["res"]["data"]["info"]["existCertificateNumber"] ?? null;

                if (!$existCertificateNumber) {
                    // 没有返回已存在的ID，无法处理
                    $failCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "fail",
                        "error" => "人脸已存在但设备未返回ID"
                    ];
                    mlog("同步人脸-203错误无ID[{$lock['lock_name']}]: " . json_encode($addRes), "face_sync.txt");
                    continue;
                }

                mlog("同步人脸-检测到人脸已存在(203)[{$lock['lock_name']}]，设备上ID={$existCertificateNumber}，需要替换为新ID={$useCertificateNumber}", "face_sync.txt");

                // 删除设备上已存在的旧ID
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $existCertificateNumber);
                if ($delRes["err"]) {
                    $failCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "fail",
                        "error" => "删除设备上旧人脸(ID:{$existCertificateNumber})失败: " . $delRes["err"]
                    ];
                    mlog("同步人脸-删除旧ID失败[{$lock['lock_name']}]: ID={$existCertificateNumber}, " . json_encode($delRes), "face_sync.txt");
                    continue;
                }

                mlog("同步人脸-已删除旧ID[{$lock['lock_name']}]: {$existCertificateNumber}，准备添加新ID: {$useCertificateNumber}", "face_sync.txt");

                // 用新的 useCertificateNumber 重新添加（必须使用图片URL）
                $addRes = HardwareCloud::Face()->Add(
                    $lock["lock_sn"],
                    $useCertificateNumber,
                    $face_image_url,
                    $end_time,
                    $face_name
                );

                mlog("同步人脸-重新添加结果[{$lock['lock_name']}]: " . json_encode($addRes), "face_sync.txt");

                if ($addRes["err"]) {
                    $failCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "fail",
                        "error" => "重新添加失败: " . $addRes["err"]
                    ];
                    continue;
                }

                $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;

                // 如果重新添加后还是 203，说明有问题
                if ($stateCode == 203) {
                    $failCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "fail",
                        "error" => "删除后重新添加仍返回人脸已存在"
                    ];
                    mlog("同步人脸-重复203错误[{$lock['lock_name']}]", "face_sync.txt");
                    continue;
                }

                // 同时需要检查并删除数据库中旧ID的记录（如果存在）
                if ($existCertificateNumber != $useCertificateNumber) {
                    Db::name("face")
                        ->where(["lock_id" => $target_lock_id, "sCertificateNumber" => $existCertificateNumber])
                        ->whereNull("deleted_at")
                        ->update(["deleted_at" => date("Y-m-d H:i:s")]);
                    mlog("同步人脸-清理数据库旧ID记录[{$lock['lock_name']}]: {$existCertificateNumber}", "face_sync.txt");
                }
            }

            // 验证 stateCode 必须是 200 才算成功
            if ($stateCode != 200) {
                $failCount++;
                $errorDetail = $addRes["res"]["data"]["info"]["detail"] ?? "未知错误";
                $results[] = [
                    "lock_id" => $target_lock_id,
                    "lock_name" => $lock["lock_name"],
                    "status" => "fail",
                    "error" => "设备返回错误(状态码{$stateCode}): {$errorDetail}"
                ];
                mlog("同步人脸-stateCode错误[{$lock['lock_name']}]: stateCode={$stateCode}, detail={$errorDetail}", "face_sync.txt");
                continue;
            }

            // 成功添加，获取实际使用的 CertificateNumber
            $actualCertificateNumber = $addRes["res"]["data"]["info"]["sCertificateNumber"] ?? $useCertificateNumber;

            if ($isUpdate) {
                Db::name("face")->where(["face_id" => $existFace["face_id"]])->update([
                    "end_time" => $end_time,
                    "face_name" => $face_name,
                    "face_feature" => $addRes["res"]["data"]["info"]["feature"] ?? $feature,
                    "sCertificateNumber" => $actualCertificateNumber,
                    "sync_status" => 1,
                    "sync_time" => time(),
                ]);
            } else {
                Db::name("face")->insert([
                    "lock_id" => $target_lock_id,
                    "member_id" => $member_id,
                    "face_name" => $face_name,
                    "face_images" => $faceImagesPath,
                    "end_time" => $end_time,
                    "sCertificateNumber" => $actualCertificateNumber,
                    "face_feature" => $addRes["res"]["data"]["info"]["feature"] ?? $feature,
                    "created_at" => time(),
                    "sync_status" => 1,
                    "sync_time" => time(),
                ]);
            }

            $successCount++;
            $results[] = [
                "lock_id" => $target_lock_id,
                "lock_name" => $lock["lock_name"],
                "status" => "success",
                "error" => null
            ];
            mlog("同步人脸-成功[{$lock['lock_name']}]: face_id={$actualCertificateNumber}, end_time={$end_time}", "face_sync.txt");
        }

        // 生成汇总消息
        $msg = "";
        if ($successCount > 0) {
            $msg .= "{$successCount}台设备同步成功";
        }
        if ($offlineCount > 0) {
            $msg .= ($msg ? "，" : "") . "{$offlineCount}台设备离线";
        }
        if ($failCount > 0) {
            $msg .= ($msg ? "，" : "") . "{$failCount}台设备同步失败";
        }
        if (!$msg) {
            $msg = "同步完成";
        }

        return json(Code::CodeOk([
            "msg" => $msg,
            "success_count" => $successCount,
            "fail_count" => $failCount,
            "offline_count" => $offlineCount,
            "results" => $results
        ]));
    }

    /**
     * 人脸校对 - 比对云端应发到设备的人脸与设备中的人脸，找出差异
     */
    public function compare()
    {
        $startTime = microtime(true);
        $lock_id = input("lock_id");

        if (!$lock_id) {
            return json(Code::CodeErr(1000, "缺少设备ID"));
        }

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备不存在"));
        }

        // 1. 获取云端应下发到此设备的人脸列表
        $cloudFaces = Db::name("face")
            ->where(["lock_id" => $lock_id])
            ->whereNull("deleted_at")
            ->select()
            ->toArray();

        // 2. 从设备获取所有人脸列表（优先使用带时间的接口）
        $deviceResult = HardwareCloud::Face()->GetListWithTime($lock["lock_sn"]);
        $hasTimeInfo = true;

        // 如果 face_find_alltime 失败，回退到 face_find_all
        if ($deviceResult["err"]) {
            $deviceResult = HardwareCloud::Face()->GetList($lock["lock_sn"]);
            $hasTimeInfo = false;

            if ($deviceResult["err"]) {
                return json(Code::CodeErr(1000, "获取设备人脸列表失败: " . $deviceResult["err"], $deviceResult["res"]));
            }
        }

        // 3. 解析设备返回的人脸列表
        $deviceFaceIds = [];
        $deviceFaceMap = [];
        $deviceDuplicates = [];  // 设备上的重复记录（需要删除的）

        // 兼容两种字段名：list 和 face_list
        $rawList = $deviceResult["res"]["data"]["info"]["list"] ?? $deviceResult["res"]["data"]["info"]["face_list"] ?? [];
        mlog("compare - 设备返回数据字段: list=" . (isset($deviceResult["res"]["data"]["info"]["list"]) ? "存在" : "不存在") .
             ", face_list=" . (isset($deviceResult["res"]["data"]["info"]["face_list"]) ? "存在" : "不存在") .
             ", rawList数量=" . count($rawList), "face_compare.txt");

        if (!empty($rawList)) {
            // 先统计每个face_id的所有记录
            $faceIdRecords = [];
            foreach ($rawList as $item) {
                if (is_string($item) || is_numeric($item)) {
                    $faceId = (string)$item;
                    if (!isset($faceIdRecords[$faceId])) {
                        $faceIdRecords[$faceId] = [];
                    }
                    $faceIdRecords[$faceId][] = [
                        "face_id" => $faceId,
                        "end_time" => 0,
                        "name" => ""
                    ];
                } elseif (is_array($item)) {
                    $faceId = (string)($item["face_id"] ?? $item["sCertificateNumber"] ?? "");
                    if ($faceId) {
                        if (!isset($faceIdRecords[$faceId])) {
                            $faceIdRecords[$faceId] = [];
                        }
                        $faceIdRecords[$faceId][] = [
                            "face_id" => $faceId,
                            "end_time" => $item["end_time"] ?? $item["iEndTime"] ?? 0,
                            "name" => $item["name"] ?? $item["sName"] ?? ""
                        ];
                    }
                }
            }

            // 处理每个face_id，保留end_time最大的，其他记录为重复
            foreach ($faceIdRecords as $faceId => $records) {
                if (count($records) > 1) {
                    // 有重复记录，按end_time降序排列
                    usort($records, function($a, $b) {
                        return ($b["end_time"] ?? 0) - ($a["end_time"] ?? 0);
                    });
                    // 第一个是end_time最大的，保留
                    $deviceFaceMap[$faceId] = $records[0];
                    // 其余的是重复记录，需要删除
                    for ($i = 1; $i < count($records); $i++) {
                        $deviceDuplicates[] = [
                            "face_id" => $faceId,
                            "sCertificateNumber" => $faceId,  // 兼容syncDiff方法
                            "name" => $records[$i]["name"],
                            "end_time" => $records[$i]["end_time"],
                            "keep_end_time" => $records[0]["end_time"],
                            "type" => "device_duplicate"
                        ];
                    }
                } else {
                    $deviceFaceMap[$faceId] = $records[0];
                }
            }
        }

        // 4. 比对并找出差异
        $differences = [
            "missing" => [],      // 云端有，设备没有
            "expired_mismatch" => [], // 过期时间不一致
            "extra" => [],        // 设备有，云端没有
            "device_duplicate" => $deviceDuplicates  // 设备上的重复记录
        ];

        // 检测云端face_id重复（同一个face_id在云端数据库有多条记录）
        $cloudFaceIdCount = [];
        $cloudFaceIdRecords = [];  // 存储每个face_id的所有记录
        $cloudDuplicateFaceIds = [];
        foreach ($cloudFaces as $cf) {
            $certNum = (string)$cf["sCertificateNumber"];
            if (!isset($cloudFaceIdCount[$certNum])) {
                $cloudFaceIdCount[$certNum] = 0;
                $cloudFaceIdRecords[$certNum] = [];
            }
            $cloudFaceIdCount[$certNum]++;
            $cloudFaceIdRecords[$certNum][] = $cf;
        }
        foreach ($cloudFaceIdCount as $faceId => $count) {
            if ($count > 1) {
                $cloudDuplicateFaceIds[$faceId] = $count;
            }
        }
        $uniqueCloudFaceIds = count($cloudFaceIdCount);

        // 自动清理云端重复记录（只保留最新的一条），并同步设备
        $cloudCleanedCount = 0;
        $cloudCleanedIds = [];
        $deviceSyncCount = 0;
        if (!empty($cloudDuplicateFaceIds)) {
            mlog("compare - ⚠️ 云端存在重复face_id: " . json_encode($cloudDuplicateFaceIds) . " (共" . count($cloudDuplicateFaceIds) . "个重复)", "face_compare.txt");
            mlog("compare - 开始自动清理云端重复记录并同步设备...", "face_compare.txt");

            foreach ($cloudDuplicateFaceIds as $dupFaceId => $dupCount) {
                $records = $cloudFaceIdRecords[$dupFaceId];
                // 按 created_at 或 face_id 降序排列，保留最新的
                usort($records, function($a, $b) {
                    // 优先按 created_at 排序，如果没有则按 face_id 排序
                    $aTime = strtotime($a["created_at"] ?? "1970-01-01") ?: ($a["face_id"] ?? 0);
                    $bTime = strtotime($b["created_at"] ?? "1970-01-01") ?: ($b["face_id"] ?? 0);
                    return $bTime - $aTime;  // 降序，最新的在前
                });

                // 保留第一条（最新的），软删除其他记录
                $keepRecord = array_shift($records);
                $deleteIds = [];
                foreach ($records as $delRecord) {
                    $deleteIds[] = $delRecord["face_id"];
                }

                if (!empty($deleteIds)) {
                    // 软删除重复记录
                    $affected = Db::name("face")
                        ->whereIn("face_id", $deleteIds)
                        ->update(["deleted_at" => date("Y-m-d H:i:s")]);

                    $cloudCleanedCount += $affected;

                    // 同步设备：确保设备上的记录和保留的云端记录一致
                    $deviceSyncResult = "skipped";
                    if (isset($deviceFaceMap[$dupFaceId])) {
                        $deviceRecord = $deviceFaceMap[$dupFaceId];
                        $deviceEndTime = (int)($deviceRecord["end_time"] ?? 0);
                        $keepEndTime = (int)$keepRecord["end_time"];

                        // 如果设备上的时间和保留记录不一致，更新设备
                        if (abs($deviceEndTime - $keepEndTime) > 60) {
                            mlog("compare - 同步设备: sCertificateNumber={$dupFaceId}, 设备end_time={$deviceEndTime}, 云端保留end_time={$keepEndTime}", "face_compare.txt");

                            // 使用Edit更新设备上的记录
                            $editResult = HardwareCloud::Face()->Edit(
                                $lock["lock_sn"],
                                $dupFaceId,
                                $keepEndTime,
                                $keepRecord["face_name"]
                            );

                            if (!$editResult["err"]) {
                                $deviceSyncResult = "updated";
                                $deviceSyncCount++;
                                mlog("compare - 设备更新成功: sCertificateNumber={$dupFaceId}", "face_compare.txt");
                            } else {
                                $deviceSyncResult = "failed: " . $editResult["err"];
                                mlog("compare - 设备更新失败: sCertificateNumber={$dupFaceId}, err=" . $editResult["err"], "face_compare.txt");
                            }
                        } else {
                            $deviceSyncResult = "already_consistent";
                        }
                    } else {
                        $deviceSyncResult = "not_on_device";
                    }

                    $cloudCleanedIds[$dupFaceId] = [
                        "keep_face_id" => $keepRecord["face_id"],
                        "keep_name" => $keepRecord["face_name"],
                        "keep_end_time" => $keepRecord["end_time"],
                        "deleted_face_ids" => $deleteIds,
                        "deleted_count" => $affected,
                        "device_sync" => $deviceSyncResult
                    ];

                    mlog("compare - 清理重复: sCertificateNumber={$dupFaceId}, 保留face_id={$keepRecord["face_id"]}({$keepRecord["face_name"]}), 删除face_ids=" . json_encode($deleteIds) . ", device_sync={$deviceSyncResult}", "face_compare.txt");
                }
            }

            mlog("compare - 云端重复清理完成: 共清理{$cloudCleanedCount}条重复记录, 设备同步{$deviceSyncCount}条", "face_compare.txt");

            // 重新获取云端数据（清理后）
            $cloudFaces = Db::name("face")
                ->where(["lock_id" => $lock_id])
                ->whereNull("deleted_at")
                ->select()
                ->toArray();
        }

        mlog("compare - 开始对比: 云端数量=" . count($cloudFaces) . ", 云端唯一face_id数=" . $uniqueCloudFaceIds . ", 设备去重后数量=" . count($deviceFaceMap), "face_compare.txt");

        // 记录设备上的所有ID（前20个）
        $deviceIds = array_keys($deviceFaceMap);
        mlog("compare - 设备ID样本(前20): " . json_encode(array_slice($deviceIds, 0, 20)), "face_compare.txt");

        // 记录云端的所有ID（前20个）
        $cloudSample = [];
        foreach (array_slice($cloudFaces, 0, 20) as $cf) {
            $cloudSample[] = $cf["sCertificateNumber"];
        }
        mlog("compare - 云端ID样本(前20): " . json_encode($cloudSample), "face_compare.txt");

        // 找出云端有但设备没有的ID（missing candidates）
        $missingCandidates = [];
        foreach ($cloudFaces as $cf) {
            $certNum = (string)$cf["sCertificateNumber"];
            if (!isset($deviceFaceMap[$certNum])) {
                $missingCandidates[] = $certNum;
            }
        }
        mlog("compare - Missing候选数量=" . count($missingCandidates) . ", IDs=" . json_encode($missingCandidates), "face_compare.txt");

        $cloudFaceIds = [];
        $missingCount = 0;
        $matchedCount = 0;
        mlog("compare - 开始遍历云端人脸, 共" . count($cloudFaces) . "条", "face_compare.txt");
        foreach ($cloudFaces as $idx => $cf) {
            $certNum = (string)$cf["sCertificateNumber"];
            $cloudFaceIds[] = $certNum;

            if (!isset($deviceFaceMap[$certNum])) {
                // 云端有，设备没有
                $missingCount++;
                mlog("compare - [{$idx}] 发现missing: certNum={$certNum}, name={$cf["face_name"]}", "face_compare.txt");
                $differences["missing"][] = [
                    "face_id" => $cf["face_id"],
                    "sCertificateNumber" => $certNum,
                    "face_name" => $cf["face_name"],
                    "face_images" => $cf["face_images"],
                    "cloud_end_time" => $cf["end_time"],
                    "cloud_end_time_str" => $cf["end_time"] == 2147483647 ? "永久有效" : date("Y-m-d H:i:s", $cf["end_time"]),
                    "type" => "missing"
                ];
            } elseif ($hasTimeInfo) {
                // 有时间信息时，检查过期时间是否一致
                $matchedCount++;
                $deviceEndTime = (int)$deviceFaceMap[$certNum]["end_time"];
                $cloudEndTime = (int)$cf["end_time"];

                // 调试日志：记录时间对比
                mlog("时间对比: certNum={$certNum}, name={$cf["face_name"]}, cloud_end_time={$cloudEndTime}(" . date("Y-m-d H:i:s", $cloudEndTime) . "), device_end_time={$deviceEndTime}(" . date("Y-m-d H:i:s", $deviceEndTime) . "), diff=" . abs($deviceEndTime - $cloudEndTime) . ", cloud_raw=" . var_export($cf["end_time"], true), "face_compare.txt");

                // 允许一定的时间误差（1分钟）
                if (abs($deviceEndTime - $cloudEndTime) > 60) {
                    $differences["expired_mismatch"][] = [
                        "face_id" => $cf["face_id"],
                        "sCertificateNumber" => $certNum,
                        "face_name" => $cf["face_name"],
                        "face_images" => $cf["face_images"],
                        "cloud_end_time" => $cloudEndTime,
                        "cloud_end_time_str" => $cloudEndTime == 2147483647 ? "永久有效" : date("Y-m-d H:i:s", $cloudEndTime),
                        "device_end_time" => $deviceEndTime,
                        "device_end_time_str" => $deviceEndTime == 2147483647 ? "永久有效" : date("Y-m-d H:i:s", $deviceEndTime),
                        "type" => "expired_mismatch"
                    ];
                }
            }
        }

        mlog("compare - 遍历完成: 总云端=" . count($cloudFaces) . ", 匹配数={$matchedCount}, missing数={$missingCount}", "face_compare.txt");

        // 5. 查找设备有但云端没有的
        foreach ($deviceFaceMap as $faceId => $df) {
            if (!in_array((string)$faceId, $cloudFaceIds)) {
                $differences["extra"][] = [
                    "sCertificateNumber" => $faceId,
                    "device_name" => $df["name"] ?? "",
                    "device_end_time" => $df["end_time"] ?? 0,
                    "device_end_time_str" => ($df["end_time"] ?? 0) == 2147483647 ? "永久有效" : (($df["end_time"] ?? 0) > 0 ? date("Y-m-d H:i:s", $df["end_time"]) : "未知"),
                    "type" => "extra"
                ];
            }
        }

        // 6. 检测云端重复记录（同一张图片在同一设备上有多条记录）
        $duplicateList = [];
        $imageGroups = [];
        foreach ($cloudFaces as $cf) {
            $img = $cf["face_images"];
            if (!isset($imageGroups[$img])) {
                $imageGroups[$img] = [];
            }
            $imageGroups[$img][] = $cf;
        }
        foreach ($imageGroups as $img => $faces) {
            if (count($faces) > 1) {
                // 保留最新的一条，其他标记为重复
                usort($faces, function($a, $b) {
                    return ($b["created_at"] ?? 0) - ($a["created_at"] ?? 0);
                });
                $keep = array_shift($faces); // 保留第一条（最新的）
                foreach ($faces as $dupFace) {
                    $duplicateList[] = [
                        "face_id" => $dupFace["face_id"],
                        "sCertificateNumber" => $dupFace["sCertificateNumber"],
                        "face_name" => $dupFace["face_name"],
                        "face_images" => $dupFace["face_images"],
                        "keep_id" => $keep["face_id"],
                        "keep_sCertificateNumber" => $keep["sCertificateNumber"],
                    ];
                }
            }
        }

        $duration = round((microtime(true) - $startTime) * 1000, 2);

        $totalDiff = count($differences["missing"]) + count($differences["expired_mismatch"]) + count($differences["extra"]) + count($differences["device_duplicate"]);

        // 构建提示信息
        $msgParts = [];

        // 添加云端重复清理提示（放在最前面）
        if ($cloudCleanedCount > 0) {
            $syncMsg = $deviceSyncCount > 0 ? ", 设备同步{$deviceSyncCount}条" : "";
            $msgParts[] = "✅ 已自动清理" . count($cloudDuplicateFaceIds) . "个重复face_id(" . $cloudCleanedCount . "条冗余记录{$syncMsg})";
        }

        if ($totalDiff > 0) {
            $msgParts[] = "发现 {$totalDiff} 处差异";
            if (count($differences["device_duplicate"]) > 0) {
                $msgParts[] = "包含" . count($differences["device_duplicate"]) . "条设备重复记录";
            }
        } else {
            $msgParts[] = "云端与设备数据一致";
        }

        return json(Code::CodeOk([
            "cloud_count" => count($cloudFaces),
            "cloud_unique_count" => $uniqueCloudFaceIds,
            "cloud_duplicate_cleaned" => $cloudCleanedCount,
            "cloud_duplicate_details" => $cloudCleanedIds,
            "device_sync_count" => $deviceSyncCount,
            "device_count" => count($deviceFaceMap),
            "device_duplicate_count" => count($differences["device_duplicate"]),
            "diff_count" => $totalDiff,
            "differences" => $differences,
            "duplicate_list" => $duplicateList,
            "duplicate_count" => count($duplicateList),
            "duration_ms" => $duration,
            "msg" => implode("；", $msgParts)
        ]));
    }

    /**
     * 清理云端重复人脸记录
     */
    public function cleanDuplicate()
    {
        $lock_id = input("lock_id");
        $duplicate_list = input("duplicate_list/a");

        if (!$lock_id) {
            return json(Code::CodeErr(1000, "缺少设备ID"));
        }

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备不存在"));
        }

        $successCount = 0;
        $failCount = 0;
        $results = [];

        // 如果没有传入 duplicate_list，自动检测
        if (empty($duplicate_list)) {
            $cloudFaces = Db::name("face")
                ->where(["lock_id" => $lock_id])
                ->whereNull("deleted_at")
                ->select()
                ->toArray();

            $imageGroups = [];
            foreach ($cloudFaces as $cf) {
                $img = $cf["face_images"];
                if (!isset($imageGroups[$img])) {
                    $imageGroups[$img] = [];
                }
                $imageGroups[$img][] = $cf;
            }

            foreach ($imageGroups as $img => $faces) {
                if (count($faces) > 1) {
                    // 保留最新的一条
                    usort($faces, function($a, $b) {
                        return ($b["created_at"] ?? 0) - ($a["created_at"] ?? 0);
                    });
                    $keep = array_shift($faces);
                    foreach ($faces as $dupFace) {
                        $duplicate_list[] = [
                            "face_id" => $dupFace["face_id"],
                            "sCertificateNumber" => $dupFace["sCertificateNumber"],
                        ];
                    }
                }
            }
        }

        foreach ($duplicate_list as $dup) {
            $faceId = $dup["face_id"];
            $certNum = $dup["sCertificateNumber"] ?? null;

            // 软删除云端记录
            $deleted = Db::name("face")->where(["face_id" => $faceId])->update(["deleted_at" => date("Y-m-d H:i:s")]);

            if ($deleted) {
                // 同时删除设备上的人脸
                if ($certNum) {
                    $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                    if ($delRes["err"]) {
                        mlog("cleanDuplicate-删除设备人脸失败: {$certNum}, " . $delRes["err"], "face_sync.txt");
                    }
                }
                $successCount++;
                $results[] = ["face_id" => $faceId, "status" => "success"];
            } else {
                $failCount++;
                $results[] = ["face_id" => $faceId, "status" => "fail", "error" => "记录不存在或已删除"];
            }
        }

        return json(Code::CodeOk([
            "msg" => "清理完成，成功 {$successCount} 条，失败 {$failCount} 条",
            "success_count" => $successCount,
            "fail_count" => $failCount,
            "results" => $results
        ]));
    }

    /**
     * 同步差异人脸到设备
     */
    public function syncDiff()
    {
        $lock_id = input("lock_id");
        $faces = input("faces/a"); // 需要同步的人脸列表
        $limit = input("limit", 10); // 每次处理的最大条数，默认10条
        $offset = input("offset", 0); // 从第几条开始处理

        if (!$lock_id || empty($faces)) {
            return json(Code::CodeErr(1000, "缺少必要参数"));
        }

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备不存在"));
        }

        // 限制处理条数，防止超时
        $totalCount = count($faces);
        $limit = min($limit, 20); // 最多一次处理20条
        $faces = array_slice($faces, $offset, $limit);
        $processedCount = count($faces);
        $hasMore = ($offset + $processedCount) < $totalCount;

        $results = [
            "success" => [],
            "failed" => []
        ];

        $host = "https://" . ($_SERVER['HTTP_HOST'] ?? "your-domain.example");

        foreach ($faces as $face) {
            $type = $face["type"] ?? "";
            $certNum = $face["sCertificateNumber"] ?? "";

            if ($type === "missing") {
                // 需要添加到设备
                $faceData = Db::name("face")->where(["sCertificateNumber" => $certNum, "lock_id" => $lock_id])->whereNull("deleted_at")->find();
                if (!$faceData) {
                    $results["failed"][] = ["sCertificateNumber" => $certNum, "reason" => "云端数据不存在"];
                    continue;
                }

                // 添加人脸（循环处理可能存在多个重复人脸的情况）
                $face_url = $host . $faceData["face_images"];
                $feature = $faceData["face_feature"] ?? "";
                $end_time = (int)$faceData["end_time"];
                $face_name = $faceData["face_name"];
                $maxRetries = 5; // 最多处理5个重复人脸
                $retryCount = 0;

                do {
                    if (!empty($feature)) {
                        $addRes = HardwareCloud::Face()->AddFeature(
                            $lock["lock_sn"],
                            $certNum,
                            $feature,
                            $end_time,
                            $face_name
                        );
                    } else {
                        $addRes = HardwareCloud::Face()->Add(
                            $lock["lock_sn"],
                            $certNum,
                            $face_url,
                            $end_time,
                            $face_name
                        );
                    }

                    // 检查是否需要处理 stateCode 203（人脸已注册）
                    if ($addRes["err"]) {
                        break; // API调用失败，退出循环
                    }

                    $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                    if ($stateCode != 203) {
                        break; // 不是203，退出循环（可能是200成功或其他错误）
                    }

                    // 获取设备上已存在的人脸ID
                    $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                    $addRes["res"]["data"]["info"]["repeat_face_id"] ?? null;

                    if (!$existCertNum) {
                        mlog("syncDiff-203但无已存在ID，无法处理", "face_sync.txt");
                        break;
                    }

                    mlog("syncDiff-检测到人脸已注册(203)[第{$retryCount}次]: 要添加的ID={$certNum}, 已存在ID={$existCertNum}", "face_sync.txt");

                    // 1. 先删除设备上已存在的人脸
                    $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $existCertNum);
                    if ($delRes["err"]) {
                        mlog("syncDiff-删除设备人脸失败: {$existCertNum}, " . $delRes["err"], "face_sync.txt");
                    } else {
                        mlog("syncDiff-删除设备人脸成功: {$existCertNum}", "face_sync.txt");
                    }

                    // 2. 同时清理云端数据库中该重复ID的记录（软删除）
                    // 无论 existCertNum 是否等于 certNum，都要检查并清理
                    $deletedCount = Db::name("face")
                        ->where(["lock_id" => $lock_id, "sCertificateNumber" => $existCertNum])
                        ->whereNull("deleted_at")
                        ->update(["deleted_at" => date("Y-m-d H:i:s")]);
                    if ($deletedCount > 0) {
                        mlog("syncDiff-清理云端重复记录: lock_id={$lock_id}, sCertificateNumber={$existCertNum}, 删除{$deletedCount}条", "face_sync.txt");
                    }

                    $retryCount++;
                } while ($retryCount < $maxRetries);

                if ($addRes["err"]) {
                    $results["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceData["face_name"], "reason" => $addRes["err"]];
                } else {
                    // 再次检查 stateCode，确保添加成功
                    $finalStateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                    if ($finalStateCode == 200) {
                        $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceData["face_name"]];
                    } else {
                        $detail = $addRes["res"]["data"]["info"]["detail"] ?? $addRes["res"]["data"]["info"]["msg"] ?? "未知错误";
                        $results["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceData["face_name"], "reason" => "stateCode={$finalStateCode}: {$detail}"];
                    }
                }
            } elseif ($type === "expired_mismatch") {
                // 过期时间不一致，先尝试删除设备上的旧记录再重新添加
                $faceData = Db::name("face")->where(["sCertificateNumber" => $certNum, "lock_id" => $lock_id])->whereNull("deleted_at")->find();
                if (!$faceData) {
                    $results["failed"][] = ["sCertificateNumber" => $certNum, "reason" => "云端数据不存在"];
                    continue;
                }

                $faceImg = $host . $faceData["face_images"];
                $faceName = $faceData["face_name"];
                $endTime = (int)$faceData["end_time"];

                mlog("syncDiff - expired_mismatch先删除: lock_sn={$lock["lock_sn"]}, certNum={$certNum}", "face_sync.txt");
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                mlog("syncDiff - 删除结果: " . json_encode($delRes), "face_sync.txt");

                // 等待500ms让设备处理删除
                usleep(500000);

                // 验证删除是否成功（查询设备上是否还有该人脸）
                $verifyRes = HardwareCloud::Face()->GetListWithTime($lock["lock_sn"]);
                $stillExists = false;
                // 兼容两种字段名
                $verifyList = $verifyRes["res"]["data"]["info"]["list"] ?? $verifyRes["res"]["data"]["info"]["face_list"] ?? [];
                if (!$verifyRes["err"] && !empty($verifyList)) {
                    foreach ($verifyList as $face) {
                        $faceId = is_array($face) ? ($face["face_id"] ?? "") : (string)$face;
                        if ($faceId == $certNum) {
                            $stillExists = true;
                            break;
                        }
                    }
                }
                mlog("syncDiff - 删除后验证: certNum={$certNum}, 是否仍存在=" . ($stillExists ? "是" : "否"), "face_sync.txt");

                // 尝试添加
                mlog("syncDiff - expired_mismatch重新添加: lock_sn={$lock["lock_sn"]}, certNum={$certNum}, end_time={$endTime}", "face_sync.txt");
                $addRes = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                mlog("syncDiff - 添加结果: " . json_encode($addRes), "face_sync.txt");

                // 检查是否返回203（人脸已注册）且existCertificateNumber与当前ID相同
                $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                if ($stateCode == 203) {
                    $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                    $addRes["res"]["data"]["info"]["repeat_face_id"] ?? "";

                    if ($existCertNum == $certNum) {
                        // 相同ID返回203，等待后再试一次Add
                        mlog("syncDiff - 203且ID相同，等待1秒后重试Add: certNum={$certNum}", "face_sync.txt");
                        usleep(1000000); // 等待1秒

                        $addRes2 = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                        mlog("syncDiff - 第二次Add结果: " . json_encode($addRes2), "face_sync.txt");

                        $stateCode2 = $addRes2["res"]["data"]["info"]["stateCode"] ?? 0;
                        if ($stateCode2 == 200) {
                            $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_retry_add"];
                            continue;
                        }

                        // 还是203，再尝试删除一次再添加（设备可能需要多次删除才能彻底清除）
                        if ($stateCode2 == 203) {
                            mlog("syncDiff - 第二次Add仍然203，再次尝试删除: certNum={$certNum}", "face_sync.txt");
                            $delRes2 = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                            mlog("syncDiff - 第二次删除结果: " . json_encode($delRes2), "face_sync.txt");
                            usleep(1000000); // 等待1秒

                            $addRes3 = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                            mlog("syncDiff - 第三次Add结果: " . json_encode($addRes3), "face_sync.txt");

                            $stateCode3 = $addRes3["res"]["data"]["info"]["stateCode"] ?? 0;
                            if ($stateCode3 == 200) {
                                $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_double_delete"];
                                continue;
                            }
                        }

                        // 所有重试都失败，尝试Edit接口作为最后手段
                        mlog("syncDiff - 重试Add仍失败，改用Edit接口: certNum={$certNum}, end_time={$endTime}", "face_sync.txt");
                        $editRes = HardwareCloud::Face()->Edit($lock["lock_sn"], $certNum, $endTime, $faceName);
                        mlog("syncDiff - Edit结果: " . json_encode($editRes), "face_sync.txt");

                        if ($editRes["err"]) {
                            $results["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "更新失败(多次Del+Add和Edit都失败): " . $editRes["err"]];
                        } else {
                            $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_edit"];
                        }
                        continue;
                    }
                }

                if ($addRes["err"]) {
                    $results["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "重新添加失败: " . $addRes["err"]];
                } else {
                    $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_readd"];
                }
            } elseif ($type === "extra") {
                // 设备多余的，从设备删除
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                if ($delRes["err"]) {
                    $results["failed"][] = ["sCertificateNumber" => $certNum, "reason" => $delRes["err"]];
                } else {
                    // 同时检查并清理云端数据库中该ID的记录（可能是残留的脏数据）
                    $deletedCount = Db::name("face")
                        ->where(["lock_id" => $lock_id, "sCertificateNumber" => $certNum])
                        ->whereNull("deleted_at")
                        ->update(["deleted_at" => date("Y-m-d H:i:s")]);
                    if ($deletedCount > 0) {
                        mlog("syncDiff-extra类型同时清理云端记录: lock_id={$lock_id}, sCertificateNumber={$certNum}, 删除{$deletedCount}条", "face_sync.txt");
                    }
                    $results["success"][] = ["sCertificateNumber" => $certNum, "action" => "deleted", "cloud_cleaned" => $deletedCount];
                }
            } elseif ($type === "device_duplicate") {
                // 设备上的重复记录，需要删除后重新添加正确记录
                $faceData = Db::name("face")->where(["sCertificateNumber" => $certNum, "lock_id" => $lock_id])->whereNull("deleted_at")->find();

                mlog("syncDiff - 处理设备重复记录: lock_sn={$lock["lock_sn"]}, certNum={$certNum}", "face_sync.txt");

                // 先删除设备上的该face_id记录
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                mlog("syncDiff - 删除重复记录结果: " . json_encode($delRes), "face_sync.txt");

                // 等待500ms让设备处理删除
                usleep(500000);

                // 如果云端有数据，重新添加正确的记录
                if ($faceData) {
                    $faceImg = $host . $faceData["face_images"];
                    $faceName = $faceData["face_name"];
                    $endTime = (int)$faceData["end_time"];

                    mlog("syncDiff - 重新添加正确记录: lock_sn={$lock["lock_sn"]}, certNum={$certNum}, end_time={$endTime}", "face_sync.txt");
                    $addRes = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                    mlog("syncDiff - 添加结果: " . json_encode($addRes), "face_sync.txt");

                    // 检查是否返回203且ID相同
                    $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                    if ($stateCode == 203) {
                        $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                        $addRes["res"]["data"]["info"]["repeat_face_id"] ?? "";

                        if ($existCertNum == $certNum) {
                            // 等待后再试一次Add
                            mlog("syncDiff - device_duplicate 203且ID相同，等待1秒后重试: certNum={$certNum}", "face_sync.txt");
                            usleep(1000000);

                            $addRes2 = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                            mlog("syncDiff - 第二次Add结果: " . json_encode($addRes2), "face_sync.txt");

                            $stateCode2 = $addRes2["res"]["data"]["info"]["stateCode"] ?? 0;
                            if ($stateCode2 == 200) {
                                $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "duplicate_cleaned_by_retry"];
                                continue;
                            }

                            // 还是失败，尝试Edit
                            mlog("syncDiff - device_duplicate 重试失败，改用Edit接口: certNum={$certNum}", "face_sync.txt");
                            $editRes = HardwareCloud::Face()->Edit($lock["lock_sn"], $certNum, $endTime, $faceName);
                            mlog("syncDiff - Edit结果: " . json_encode($editRes), "face_sync.txt");

                            if ($editRes["err"]) {
                                $results["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "更新失败: " . $editRes["err"]];
                            } else {
                                $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "duplicate_cleaned_by_edit"];
                            }
                            continue;
                        }
                    }

                    if ($addRes["err"]) {
                        $results["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "重新添加失败: " . $addRes["err"]];
                    } else {
                        $results["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "duplicate_cleaned"];
                    }
                } else {
                    // 云端没有数据，只删除设备上的记录
                    if ($delRes["err"]) {
                        $results["failed"][] = ["sCertificateNumber" => $certNum, "reason" => "删除重复记录失败: " . $delRes["err"]];
                    } else {
                        $results["success"][] = ["sCertificateNumber" => $certNum, "action" => "duplicate_deleted"];
                    }
                }
            }
        }

        return json(Code::CodeOk([
            "success_count" => count($results["success"]),
            "failed_count" => count($results["failed"]),
            "processed_count" => $processedCount,
            "total_count" => $totalCount,
            "has_more" => $hasMore,
            "next_offset" => $hasMore ? ($offset + $processedCount) : null,
            "results" => $results,
            "msg" => "同步完成，成功 " . count($results["success"]) . " 个，失败 " . count($results["failed"]) . " 个" . ($hasMore ? "，还有 " . ($totalCount - $offset - $processedCount) . " 条待处理" : "")
        ]));
    }

    /**
     * 批量删除人脸（从多台设备删除相同图片的人脸）
     */
    public function delFromDevices()
    {
        $source_lock_id = input("source_lock_id");
        $face_id = input("face_id");
        $target_lock_ids = input("target_lock_ids/a"); // 需要同步删除的设备ID数组
        $face_images = input("face_images"); // 用于匹配其他设备上的相同人脸

        if (!$face_id) {
            return json(Code::CodeErr(1000, "缺少人脸ID"));
        }

        // 获取源人脸数据
        $sourceFace = Db::name("face")->where(["face_id" => $face_id])->find();
        if (!$sourceFace) {
            return json(Code::CodeErr(1000, "人脸数据不存在"));
        }

        $faceImagesPath = $face_images ?: $sourceFace["face_images"];

        $successCount = 0;
        $failCount = 0;
        $offlineCount = 0;
        $results = [];

        // 删除其他设备上的相同人脸
        if (!empty($target_lock_ids)) {
            foreach ($target_lock_ids as $target_lock_id) {
                $lock = Db::name("lock")->where(["lock_id" => $target_lock_id])->find();
                if (!$lock) {
                    $failCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => "未知设备",
                        "status" => "fail",
                        "error" => "设备不存在"
                    ];
                    continue;
                }

                // 查找该设备上相同图片的人脸
                $targetFace = Db::name("face")
                    ->where(["lock_id" => $target_lock_id, "face_images" => $faceImagesPath])
                    ->whereNull("deleted_at")
                    ->find();

                if (!$targetFace) {
                    // 数据库中没有该人脸记录，标记为跳过（不计入成功也不计入失败）
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "skip",
                        "error" => null,
                        "msg" => "云端无此人脸记录"
                    ];
                    continue;
                }

                // 从设备删除人脸
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $targetFace["sCertificateNumber"]);

                if ($delRes["err"]) {
                    $errMsg = $delRes["err"];
                    $errLower = strtolower($errMsg);
                    // 判断是否是设备离线/网络问题
                    $isOffline = strpos($errMsg, "不在线") !== false ||
                                 strpos($errMsg, "网络故障") !== false ||
                                 strpos($errMsg, "网络") !== false ||
                                 strpos($errLower, "offline") !== false ||
                                 strpos($errLower, "timeout") !== false;

                    if ($isOffline) {
                        $offlineCount++;
                        $results[] = [
                            "lock_id" => $target_lock_id,
                            "lock_name" => $lock["lock_name"],
                            "status" => "offline",
                            "error" => $errMsg
                        ];
                    } else {
                        $failCount++;
                        $results[] = [
                            "lock_id" => $target_lock_id,
                            "lock_name" => $lock["lock_name"],
                            "status" => "fail",
                            "error" => $delRes["err"]
                        ];
                    }
                } else {
                    // 删除成功，更新数据库
                    Db::name("face")->where(["face_id" => $targetFace["face_id"]])->update(["deleted_at" => date("Y-m-d H:i:s")]);
                    $successCount++;
                    $results[] = [
                        "lock_id" => $target_lock_id,
                        "lock_name" => $lock["lock_name"],
                        "status" => "success",
                        "error" => null
                    ];
                }
            }
        }

        // 统计跳过的设备数
        $skipCount = 0;
        foreach ($results as $r) {
            if ($r["status"] === "skip") {
                $skipCount++;
            }
        }

        // 生成汇总消息
        $msg = "";
        if ($successCount > 0) {
            $msg .= "{$successCount}台设备删除成功";
        }
        if ($skipCount > 0) {
            $msg .= ($msg ? "，" : "") . "{$skipCount}台设备无此记录";
        }
        if ($offlineCount > 0) {
            $msg .= ($msg ? "，" : "") . "{$offlineCount}台设备离线";
        }
        if ($failCount > 0) {
            $msg .= ($msg ? "，" : "") . "{$failCount}台设备删除失败";
        }
        if (!$msg) {
            $msg = "删除完成";
        }

        return json(Code::CodeOk([
            "msg" => $msg,
            "success_count" => $successCount,
            "skip_count" => $skipCount,
            "fail_count" => $failCount,
            "offline_count" => $offlineCount,
            "results" => $results
        ]));
    }

    /**
     * 创建异步同步任务
     * 将差异人脸同步任务放入队列，后台异步处理
     */
    public function createSyncTask()
    {
        $lock_id = input("lock_id");
        $faces = input("faces/a"); // 需要同步的人脸列表

        mlog("createSyncTask 被调用: lock_id={$lock_id}, faces_count=" . count($faces ?? []), "face_sync_task.txt");

        if (!$lock_id || empty($faces)) {
            mlog("createSyncTask 错误: 缺少必要参数", "face_sync_task.txt");
            return json(Code::CodeErr(1000, "缺少必要参数"));
        }

        // 记录 faces 数据类型
        $facesTypes = [];
        foreach ($faces as $idx => $f) {
            $facesTypes[] = ($f["type"] ?? "无type") . ":" . ($f["sCertificateNumber"] ?? "无ID");
            if ($idx >= 5) break; // 只记录前5个
        }
        mlog("createSyncTask faces样本: " . implode(", ", $facesTypes), "face_sync_task.txt");

        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->find();
        if (!$lock) {
            return json(Code::CodeErr(1000, "设备不存在"));
        }

        // 获取当前用户信息
        $uidInfo = \app\module\member\memberServer\MemberServer::Uid();
        $member_id = $uidInfo["uid"];

        // 检查是否存在该设备未完成的同步任务
        $existingTask = Db::name("face_sync_task")
            ->where(["lock_id" => $lock_id])
            ->whereIn("status", ["pending", "processing"])
            ->order("id", "desc")
            ->find();

        if ($existingTask) {
            // 返回现有任务信息，让前端继续跟踪
            return json(Code::CodeOk([
                "task_id" => $existingTask["id"],
                "total_count" => $existingTask["total_count"],
                "processed_count" => $existingTask["processed_count"],
                "success_count" => $existingTask["success_count"],
                "failed_count" => $existingTask["failed_count"],
                "progress" => $existingTask["progress"],
                "status" => $existingTask["status"],
                "is_existing" => true,
                "msg" => "存在进行中的同步任务，已恢复跟踪"
            ]));
        }

        // 创建同步任务
        $task_id = Db::name("face_sync_task")->insertGetId([
            "lock_id" => $lock_id,
            "lock_sn" => $lock["lock_sn"],
            "lock_name" => $lock["lock_name"],
            "member_id" => $member_id,
            "total_count" => count($faces),
            "processed_count" => 0,
            "success_count" => 0,
            "failed_count" => 0,
            "faces_data" => json_encode($faces, JSON_UNESCAPED_UNICODE),
            "status" => "pending", // pending, processing, finished, failed
            "progress" => 0,
            "result_data" => null,
            "error_msg" => null,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);

        return json(Code::CodeOk([
            "task_id" => $task_id,
            "total_count" => count($faces),
            "msg" => "同步任务已创建，共 " . count($faces) . " 条待处理"
        ]));
    }

    /**
     * 查询同步任务进度
     */
    public function getSyncTaskProgress()
    {
        $task_id = input("task_id");

        if (!$task_id) {
            return json(Code::CodeErr(1000, "缺少任务ID"));
        }

        $task = Db::name("face_sync_task")->where(["id" => $task_id])->find();
        if (!$task) {
            return json(Code::CodeErr(1000, "任务不存在"));
        }

        $result_data = $task["result_data"] ? json_decode($task["result_data"], true) : null;

        return json(Code::CodeOk([
            "task_id" => $task["id"],
            "lock_id" => $task["lock_id"],
            "lock_name" => $task["lock_name"],
            "status" => $task["status"],
            "total_count" => $task["total_count"],
            "processed_count" => $task["processed_count"],
            "success_count" => $task["success_count"],
            "failed_count" => $task["failed_count"],
            "progress" => $task["progress"],
            "error_msg" => $task["error_msg"],
            "result_data" => $result_data,
            "created_at" => $task["created_at"],
            "updated_at" => $task["updated_at"],
        ]));
    }

    /**
     * 处理同步任务（供后台Worker调用或手动触发）
     * 支持分批处理，每次处理一定数量
     */
    public function processSyncTask()
    {
        $task_id = input("task_id");
        $batch_size = input("batch_size", 5); // 每次处理条数

        mlog("processSyncTask 被调用: task_id={$task_id}, batch_size={$batch_size}", "face_sync_task.txt");

        if (!$task_id) {
            mlog("processSyncTask 错误: 缺少任务ID", "face_sync_task.txt");
            return json(Code::CodeErr(1000, "缺少任务ID"));
        }

        $task = Db::name("face_sync_task")->where(["id" => $task_id])->find();
        if (!$task) {
            mlog("processSyncTask 错误: 任务不存在 task_id={$task_id}", "face_sync_task.txt");
            return json(Code::CodeErr(1000, "任务不存在"));
        }

        mlog("processSyncTask 任务信息: status={$task['status']}, total={$task['total_count']}, processed={$task['processed_count']}", "face_sync_task.txt");

        if ($task["status"] === "finished") {
            return json(Code::CodeOk([
                "msg" => "任务已完成",
                "status" => "finished",
                "has_more" => false
            ]));
        }

        // 更新状态为处理中
        if ($task["status"] === "pending") {
            Db::name("face_sync_task")->where(["id" => $task_id])->update([
                "status" => "processing",
                "updated_at" => date("Y-m-d H:i:s")
            ]);
        }

        $lock = Db::name("lock")->where(["lock_id" => $task["lock_id"]])->find();
        if (!$lock) {
            Db::name("face_sync_task")->where(["id" => $task_id])->update([
                "status" => "failed",
                "error_msg" => "设备不存在",
                "updated_at" => date("Y-m-d H:i:s")
            ]);
            return json(Code::CodeErr(1000, "设备不存在"));
        }

        $faces = json_decode($task["faces_data"], true);
        $totalCount = count($faces);
        $processedCount = $task["processed_count"];
        $successCount = $task["success_count"];
        $failedCount = $task["failed_count"];

        // 获取已有的结果数据
        $existingResults = $task["result_data"] ? json_decode($task["result_data"], true) : ["success" => [], "failed" => []];

        // 取出待处理的批次
        $batch = array_slice($faces, $processedCount, $batch_size);
        $batchCount = count($batch);

        if ($batchCount === 0) {
            // 没有更多待处理，标记完成
            Db::name("face_sync_task")->where(["id" => $task_id])->update([
                "status" => "finished",
                "progress" => 100,
                "updated_at" => date("Y-m-d H:i:s")
            ]);
            return json(Code::CodeOk([
                "msg" => "任务已完成",
                "status" => "finished",
                "has_more" => false
            ]));
        }

        $host = "https://" . ($_SERVER['HTTP_HOST'] ?? "your-domain.example");
        $lock_id = $task["lock_id"];

        // 处理这一批
        foreach ($batch as $face) {
            $type = $face["type"] ?? "";
            $certNum = $face["sCertificateNumber"] ?? "";

            mlog("processSyncTask - 处理: type={$type}, certNum={$certNum}", "face_sync_task.txt");

            if ($type === "missing") {
                // 设备缺失的，需要添加到设备
                $faceData = Db::name("face")->where(["sCertificateNumber" => $certNum, "lock_id" => $lock_id])->whereNull("deleted_at")->find();
                if (!$faceData) {
                    $failedCount++;
                    $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "reason" => "云端数据不存在"];
                    $processedCount++;
                    continue;
                }

                $face_url = $host . $faceData["face_images"];
                $feature = $faceData["face_feature"] ?? "";
                $end_time = (int)$faceData["end_time"];
                $face_name = $faceData["face_name"];
                $maxRetries = 5;
                $retryCount = 0;

                do {
                    if (!empty($feature)) {
                        $addRes = HardwareCloud::Face()->AddFeature($lock["lock_sn"], $certNum, $feature, $end_time, $face_name);
                    } else {
                        $addRes = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $face_url, $end_time, $face_name);
                    }

                    if ($addRes["err"]) break;

                    $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                    if ($stateCode != 203) break;

                    $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                    $addRes["res"]["data"]["info"]["repeat_face_id"] ?? null;

                    if (!$existCertNum) break;

                    HardwareCloud::Face()->Del($lock["lock_sn"], $existCertNum);
                    Db::name("face")->where(["lock_id" => $lock_id, "sCertificateNumber" => $existCertNum])
                        ->whereNull("deleted_at")->update(["deleted_at" => date("Y-m-d H:i:s")]);

                    $retryCount++;
                } while ($retryCount < $maxRetries);

                if ($addRes["err"]) {
                    $failedCount++;
                    $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $face_name, "reason" => $addRes["err"]];
                } else {
                    $finalStateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                    if ($finalStateCode == 200) {
                        $successCount++;
                        $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $face_name];
                    } else {
                        $failedCount++;
                        $detail = $addRes["res"]["data"]["info"]["detail"] ?? "未知错误";
                        $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $face_name, "reason" => "stateCode={$finalStateCode}: {$detail}"];
                    }
                }
            } elseif ($type === "expired_mismatch") {
                // 过期时间不一致，先尝试删除再重新添加
                $faceData = Db::name("face")->where(["sCertificateNumber" => $certNum, "lock_id" => $lock_id])->whereNull("deleted_at")->find();
                if (!$faceData) {
                    $failedCount++;
                    $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "reason" => "云端数据不存在"];
                    $processedCount++;
                    continue;
                }

                $faceImg = $host . $faceData["face_images"];
                $faceName = $faceData["face_name"];
                $endTime = (int)$faceData["end_time"];

                mlog("processSyncTask - expired_mismatch先删除: lock_sn={$lock["lock_sn"]}, certNum={$certNum}", "face_sync_task.txt");
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                mlog("processSyncTask - 删除结果: " . json_encode($delRes), "face_sync_task.txt");

                // 等待500ms让设备处理删除
                usleep(500000);

                // 不管删除是否成功，都尝试添加
                mlog("processSyncTask - expired_mismatch重新添加: lock_sn={$lock["lock_sn"]}, certNum={$certNum}, end_time={$endTime}", "face_sync_task.txt");
                $addRes = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                mlog("processSyncTask - 添加结果: " . json_encode($addRes), "face_sync_task.txt");

                // 检查是否返回203且ID相同
                $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                if ($stateCode == 203) {
                    $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                    $addRes["res"]["data"]["info"]["repeat_face_id"] ?? "";

                    if ($existCertNum == $certNum) {
                        // 等待1秒后再试一次Add
                        mlog("processSyncTask - 203且ID相同，等待1秒后重试: certNum={$certNum}", "face_sync_task.txt");
                        usleep(1000000);

                        $addRes2 = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                        mlog("processSyncTask - 第二次Add结果: " . json_encode($addRes2), "face_sync_task.txt");

                        $stateCode2 = $addRes2["res"]["data"]["info"]["stateCode"] ?? 0;
                        if ($stateCode2 == 200) {
                            $successCount++;
                            $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_retry"];
                            $processedCount++;
                            continue;
                        }

                        // 还是失败，尝试Edit
                        mlog("processSyncTask - 重试失败，改用Edit接口: certNum={$certNum}", "face_sync_task.txt");
                        $editRes = HardwareCloud::Face()->Edit($lock["lock_sn"], $certNum, $endTime, $faceName);
                        mlog("processSyncTask - Edit结果: " . json_encode($editRes), "face_sync_task.txt");

                        if ($editRes["err"]) {
                            $failedCount++;
                            $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "Edit更新失败: " . $editRes["err"]];
                        } else {
                            $successCount++;
                            $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_edit"];
                        }
                        $processedCount++;
                        continue;
                    }
                }

                if ($addRes["err"]) {
                    $failedCount++;
                    $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "重新添加失败: " . $addRes["err"]];
                } else {
                    $successCount++;
                    $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "time_updated_by_readd"];
                }
            } elseif ($type === "extra") {
                // 设备多余的，从设备删除
                mlog("processSyncTask - 删除extra: lock_sn={$lock["lock_sn"]}, certNum={$certNum}", "face_sync_task.txt");
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                mlog("processSyncTask - 删除结果: " . json_encode($delRes), "face_sync_task.txt");
                if ($delRes["err"]) {
                    $failedCount++;
                    $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "reason" => $delRes["err"]];
                } else {
                    // 同时检查并清理云端数据库中该ID的记录（可能是残留的脏数据）
                    $deletedCount = Db::name("face")
                        ->where(["lock_id" => $lock_id, "sCertificateNumber" => $certNum])
                        ->whereNull("deleted_at")
                        ->update(["deleted_at" => date("Y-m-d H:i:s")]);
                    if ($deletedCount > 0) {
                        mlog("processSyncTask-extra类型同时清理云端记录: lock_id={$lock_id}, sCertificateNumber={$certNum}, 删除{$deletedCount}条", "face_sync_task.txt");
                    }
                    $successCount++;
                    $existingResults["success"][] = ["sCertificateNumber" => $certNum, "action" => "deleted", "cloud_cleaned" => $deletedCount];
                }
            } elseif ($type === "device_duplicate") {
                // 设备上的重复记录，需要删除后重新添加正确的记录
                $faceData = Db::name("face")->where(["sCertificateNumber" => $certNum, "lock_id" => $lock_id])->whereNull("deleted_at")->find();

                mlog("processSyncTask - 处理设备重复记录: lock_sn={$lock["lock_sn"]}, certNum={$certNum}", "face_sync_task.txt");

                // 先删除设备上的该face_id记录
                $delRes = HardwareCloud::Face()->Del($lock["lock_sn"], $certNum);
                mlog("processSyncTask - 删除重复记录结果: " . json_encode($delRes), "face_sync_task.txt");

                // 等待500ms让设备处理删除
                usleep(500000);

                // 如果云端有数据，重新添加正确的记录
                if ($faceData) {
                    $faceImg = $host . $faceData["face_images"];
                    $faceName = $faceData["face_name"];
                    $endTime = (int)$faceData["end_time"];

                    mlog("processSyncTask - 重新添加正确记录: lock_sn={$lock["lock_sn"]}, certNum={$certNum}, end_time={$endTime}", "face_sync_task.txt");
                    $addRes = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                    mlog("processSyncTask - 添加结果: " . json_encode($addRes), "face_sync_task.txt");

                    // 检查是否返回203且ID相同
                    $stateCode = $addRes["res"]["data"]["info"]["stateCode"] ?? 0;
                    if ($stateCode == 203) {
                        $existCertNum = $addRes["res"]["data"]["info"]["existCertificateNumber"] ??
                                        $addRes["res"]["data"]["info"]["repeat_face_id"] ?? "";

                        if ($existCertNum == $certNum) {
                            // 等待1秒后再试一次Add
                            mlog("processSyncTask - device_duplicate 203且ID相同，等待1秒后重试: certNum={$certNum}", "face_sync_task.txt");
                            usleep(1000000);

                            $addRes2 = HardwareCloud::Face()->Add($lock["lock_sn"], $certNum, $faceImg, $endTime, $faceName);
                            mlog("processSyncTask - 第二次Add结果: " . json_encode($addRes2), "face_sync_task.txt");

                            $stateCode2 = $addRes2["res"]["data"]["info"]["stateCode"] ?? 0;
                            if ($stateCode2 == 200) {
                                $successCount++;
                                $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "duplicate_cleaned_by_retry"];
                                $processedCount++;
                                continue;
                            }

                            // 还是失败，尝试Edit
                            mlog("processSyncTask - device_duplicate 重试失败，改用Edit接口: certNum={$certNum}", "face_sync_task.txt");
                            $editRes = HardwareCloud::Face()->Edit($lock["lock_sn"], $certNum, $endTime, $faceName);
                            mlog("processSyncTask - Edit结果: " . json_encode($editRes), "face_sync_task.txt");

                            if ($editRes["err"]) {
                                $failedCount++;
                                $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "Edit更新失败: " . $editRes["err"]];
                            } else {
                                $successCount++;
                                $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "duplicate_cleaned_by_edit"];
                            }
                            $processedCount++;
                            continue;
                        }
                    }

                    if ($addRes["err"]) {
                        $failedCount++;
                        $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "reason" => "重新添加失败: " . $addRes["err"]];
                    } else {
                        $successCount++;
                        $existingResults["success"][] = ["sCertificateNumber" => $certNum, "face_name" => $faceName, "action" => "duplicate_cleaned"];
                    }
                } else {
                    // 云端没有数据，只删除设备上的记录
                    if ($delRes["err"]) {
                        $failedCount++;
                        $existingResults["failed"][] = ["sCertificateNumber" => $certNum, "reason" => "删除重复记录失败: " . $delRes["err"]];
                    } else {
                        $successCount++;
                        $existingResults["success"][] = ["sCertificateNumber" => $certNum, "action" => "duplicate_deleted"];
                    }
                }
            }

            $processedCount++;
        }

        // 更新任务进度
        $progress = $totalCount > 0 ? round(($processedCount / $totalCount) * 100, 1) : 100;
        $hasMore = $processedCount < $totalCount;
        $status = $hasMore ? "processing" : "finished";

        Db::name("face_sync_task")->where(["id" => $task_id])->update([
            "processed_count" => $processedCount,
            "success_count" => $successCount,
            "failed_count" => $failedCount,
            "progress" => $progress,
            "status" => $status,
            "result_data" => json_encode($existingResults, JSON_UNESCAPED_UNICODE),
            "updated_at" => date("Y-m-d H:i:s")
        ]);

        return json(Code::CodeOk([
            "task_id" => $task_id,
            "status" => $status,
            "processed_count" => $processedCount,
            "total_count" => $totalCount,
            "success_count" => $successCount,
            "failed_count" => $failedCount,
            "progress" => $progress,
            "has_more" => $hasMore,
            "batch_processed" => $batchCount,
            "msg" => $hasMore ? "已处理 {$processedCount}/{$totalCount}" : "同步完成"
        ]));
    }
}
