<?php


namespace app\api\controller\device;


use app\api\controller\Base;
use app\BaseController;
use app\module\code\Code;
use app\module\lockServer\Lock;
use app\module\lockServer\LockLog;
use app\module\hardwareCloud\HardwareCloud;
use app\module\member\memberServer\MemberServer;
use app\module\model\LockAuth;
use app\module\order\OrderServer;
use app\module\redis\Redis;
use app\module\user\userServer\UserServer;
use app\module\wechat\WechatServer;
use app\module\lock\LockNotice;
use think\facade\Db;
use xhadmin\db\Lock as LockDb;
use xhadmin\service\api\LockService;

class Device extends Base
{

    function add()
    {

        $data["lock_name"] = trim(input("lock_name"));
        if ($data["lock_name"] === '') {
            $data["lock_name"] = trim((string)input("device_name"));
        }
        $data["lock_sn"] = strtoupper(trim(input("lock_sn")));
        if ($data["lock_name"] === '' && Lock::checkCamString($data["lock_sn"])) {
            $data["lock_name"] = "摄像头";
        }
        $device_group_id = input("device_group_id");


        $uidInfo = MemberServer::Uid();
        $data['member_id'] = $uidInfo["uid"];
        $useradmininfo = db()->name('user')->where(["member_id" => $data['member_id']])->find();
        if (!$useradmininfo) {
            UserServer::Add("默认用户", uniqid(), "a123456", $data['member_id']);
            $useradmininfo = db()->name('user')->where(["member_id" => $data['member_id']])->find();
            $data['user_id'] = $useradmininfo["user_id"];
        } else {
            $data['user_id'] = $useradmininfo["user_id"];
        }

        try {
            $lockmap['lock_sn'] = $data['lock_sn'];
            //根据锁sn拿到锁信息,根据会员id拿到会员信息，根据会员id和锁id拿到钥匙信息
            $reslookdata = LockDb::getWhereInfo($lockmap);
            if ($reslookdata) {

                return json(Code::CodeErr(1000, "设备已添加过", $reslookdata));
            } else {
                //为了兼容过去设备在默认分组情况下id=0
                $DeviceGroupInfo = \app\module\device\server\DeviceGroup::Info($device_group_id);
                if ($DeviceGroupInfo && $DeviceGroupInfo["type"] == 1) {
                    $device_group_id = 0;
                }


                $lockAddRes = \app\module\lockServer\Lock::Add($data, $device_group_id);
                if ($lockAddRes["err"]) {
                    return json(Code::CodeErr(1000, $lockAddRes["err"], $lockAddRes));

                }


            }
        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));
        }
        return json(Code::CodeOk(['data' => $lockAddRes]));
    }

    function del()
    {
        $lockauth_id = input("lockauth_id");
        $info = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        if ($info["auth_member_id"] === 0) {
            \app\module\lockAuthServer\LockAuth::DelLockId($info["lock_id"]);
            Lock::Del($info["lock_id"]);
            return json(Code::CodeOk(['msg' => "超管删除成功"]));
        }
        \app\module\lockAuthServer\LockAuth::Del($info["lockauth_id"]);
        return json(Code::CodeOk(['msg' => "超管删除成功"]));
    }

    function openLock()
    {
        $lockauth_id = input("lockauth_id");


        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);
        //判断设备是否停用
        if (!$lock['status'] && !$lockAuth['auth_isadmin']) {
            return json(Code::CodeErr(1000, "设备已停用", $lock['status']));
        } //判断设备是否停用
        if (!$lock['openbtn'] && !$lockAuth['auth_isadmin']) {
            return json(Code::CodeErr(1000, "设备关闭小程序操作", $lock['status']));
        }
        $memberInfo = MemberServer::Info($lockAuth['member_id']);
        if ($lock['mobile_check'] && strlen($memberInfo['mobile']) < 10) {
            return json(Code::CodeErr(1001, "需要先绑定手机号", $memberInfo));
        }
        if (!$lockAuth['auth_isadmin'] || $lockAuth["lock_id"] == 2706) {

            //判断时间段
            $OpenLockTimesErr = Lock::OpenLockTimes($lockAuth["lock_id"]);

            if ($OpenLockTimesErr["err"]) {
                return json(Code::CodeErr(1000, $OpenLockTimesErr["err"], $lock['status']));
            }
        }

        $latitude = input("latitude");
        $longitude = input("longitude");
        $uidInfo = MemberServer::Uid();
        $UMemberRes = MemberServer::UMember($uidInfo["uid"], $lock["user_id"]);
        if ($UMemberRes["err"]) {
            return json(Code::CodeErr(1000, $UMemberRes['err'], $UMemberRes));
        }
        //钥匙校验
        $VerifyRes = \app\module\lockAuthServer\LockAuth::Verify($lockauth_id);
        if ($VerifyRes["err"]) {
            return json(Code::CodeErr(1000, $VerifyRes['err'], $VerifyRes));
        }


        $result = \app\module\lockServer\Lock::OpenLock($lock, $latitude, $longitude);


        $data['type'] = 2;
        $data['user_id'] = $lock["user_id"];
        $data['member_id'] = $uidInfo["uid"];
        $data['lock_id'] = $lockAuth["lock_id"];


        if ($result['state'] == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
            $data['remark'] = $result['state_msg'];
        }
        \xhadmin\service\api\LockLogService::add($data);
        //用户类型判断
        $member_type = $memberInfo["member_type"];
        $member_type_head = '';
        switch ($member_type) {
            case 1:
                $member_type_head = '微信用户';
                break;
            case 2:
                $member_type_head = '支付宝用户';
                break;
            case 3:
                $member_type_head = '抖音用户';
                break;
            default:
                // code...
                break;
        }
        $senddata['lock_id'] = $lockAuth["lock_id"];
        $senddata['lockname'] = $lock['lock_name'];
        $senddata['locksn'] = $lock['lock_sn'];
        $senddata['username'] = $member_type_head;
        $senddata['mobile'] = $memberInfo["mobile"] ? $memberInfo["mobile"] : '未登记号码';;
        $senddata['opentime'] = date("Y年m月d日 H:i", time());
        $senddata['opentype'] = "小程序菜单";
        $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($data['lock_id']);
        if ($result['state'] == 1) {
            //联动喇叭
            $linkspeakers = Db::name('linkspeaker')->where(['lock_id' => $lockAuth["lock_id"]])->select();
            if ($linkspeakers) {
                foreach ($linkspeakers as $linkspeaker) {
                    $res = HardwareCloud::Horn()->Play(
                        $linkspeaker["linkspeaker_sn"],
                        $linkspeaker["linkspeaker_tts"],
                        $linkspeaker["linkspeaker_volume"]
                    );
                }
            }
            if ($lock['opsucnt']) {
                $miniappconfig = config('my.wxmp');
                if ($miniappconfig['app_id'] == 'wx7fdcb0b7df1b5439') {
                    $senddata['openstatus'] = "成功";
                    $res = wmjSendWechatMsg('socn', $senddata);
                } else {
                    $LockNoticeres = LockNotice::OpenLock($data['lock_id'], $member_type_head . "-" . $memberInfo["mobile"]);
                }
            }


            if ($lockAuth["auth_isadmin"] != 1) {
                //增加开门次数
                \app\module\lockAuthServer\LockAuth::OpenusedAdd($lockauth_id);
            }
            $openmsg=isset($result['state_msg'])?$result['state_msg']:'开门成功';
            if(strlen($openmsg)<2)
            {
                $openmsg="门已打开";
            }
            return json(Code::CodeOk(["msg" => $openmsg, "data" => [
                "xcx_sound" => $lock["xcx_sound"]
            ]]));
        } else {
            $senddata['openstatus'] = "失败";
            $res = wmjSendWechatMsg('socn', $senddata);
            return json(Code::CodeErr(1000, $result['state_msg'], $result));
        }

        return json(Code::CodeErr(1000, $result['state_msg'], $result));
    }

    function openLockTest()
    {
        $lock_sn = input("lock_sn");


        $result = \app\module\lockServer\Lock::OpenLockTest($lock_sn);


        if ($result['state'] == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
            $data['remark'] = $result['state_msg'];
        }


        if ($result['state'] == 1) {
            return json(Code::CodeOk([
                "msg" => "开门成功",

            ]));

        }

        return json(Code::CodeErr(1000, $result['state_msg'], $result));
    }

    //重启设备
    function restartDevice()
    {
        $lock_sn = input("lock_sn");
        $result = HardwareCloud::App()->Restart($lock_sn);
        if ($result["err"]) {
            return json(Code::CodeErr(1001, $result["err"]));
        } else {
            return json(Code::CodeOk([
                "msg" => "重启成功",
            ]));
        }
    }

    function qrOpenLock()
    {
        $lock_id = input("lock_id");
        $lock = Lock::Info($lock_id);

        $uidInfo = MemberServer::Uid();
        $data['member_id'] = $uidInfo["uid"];
        $data['lock_id'] = $lock_id;

        $memberInfo = MemberServer::Info($data['member_id']);
        if ($lock['mobile_check'] && strlen($memberInfo['mobile']) < 10) {
            return json(Code::CodeErr(1001, "需要先绑定手机号", $memberInfo));
        }
        //查询是否有钥匙
        $lockauth = Db::name("lockauth")->where(["lock_id" => $lock_id, "member_id" => $data['member_id']])->whereNull("deleted_at")->find();
        //判断设备是否停用
        if (!$lock['status'] && !$lockauth['auth_isadmin']) {
            //mlog("设备已停用:" . $data['member_id'] . "_" . $lock_id);
            return json(Code::CodeErr(1000, "设备已停用", $lock['status']));
        }

        if (!$lockauth['auth_isadmin']) {
            //判断时间段
            $OpenLockTimesErr = Lock::OpenLockTimes($lock["lock_id"]);
            if ($OpenLockTimesErr["err"]) {
                return json(Code::CodeErr(1000, $OpenLockTimesErr["err"], $lock['status']));
            }
        }
        //如果需要申请钥匙
        if ($lock["applyauth"] == 1) {

            if (!$lockauth) {
                return json(Code::CodeErr(1002, "需要申请钥匙", $lockauth));
            }
            //判断审核状态
            if ($lockauth["auth_status"] == 0) {
                return json(Code::CodeErr(1000, "您的钥匙正在审核中", $lockauth));
            }
        }
        //钥匙校验
        $VerifyRes = \app\module\lockAuthServer\LockAuth::Verify($lockauth["lockauth_id"]);
        if ($VerifyRes["err"]) {
            return json(Code::CodeErr(1000, $VerifyRes['err'], $VerifyRes));
        }
        //创建和普通管理员用户关联的用户信息(umember)
        $UMemberRes = MemberServer::UMember($data['member_id'], $lock["user_id"]);
        //mlog("openinfo:" . $data['member_id'] . "_" . $lock["user_id"] . "_" . $UMemberRes["status"]);
        if (isset($UMemberRes["status"]) && $UMemberRes["status"] == 0) {
            return json(Code::CodeErr(1000, "异常用户", $UMemberRes));
        }
        if (isset($UMemberRes["status"]) && $UMemberRes["status"] == 2) {
            //查询管理员手机号
            //先查询所有管理员ID
            $mawhere['lock_id'] = $lock_id;
            $mawhere['auth_isadmin'] = 1;
            $mobiles = "";
            $madataid = db()->name('lockauth')->where($mawhere)->select();
            foreach ($madataid as $nvalue) {
                $maphonedata = \xhadmin\db\Member::getInfo($nvalue['member_id']);
                $mobiles = $mobiles . "," . $maphonedata['mobile'];
            }
            //mlog("mobiles:".$mobiles);
            db()->name('lock')->where('lock_id', $lock_id)->update(['status' => 0]);
            if (mb_substr($lock["lock_sn"], 0, 4) == "W763") {
                $content1 = "有黑名单用户".$memberInfo['mobile']."进入" . $lock['lock_name'] . ",门状态和出门开关已禁用,设备序列号" . $lock['lock_sn']."";
                $smsdata1 = array("mobiles" => $mobiles, "content" => $content1);
                sendymSms($smsdata1);
                HardwareCloud::Accesscontrol()::SetEs($lock["lock_sn"],0);
            }
            else
            {
                $content2 = "有黑名单用户".$memberInfo['mobile']."进入" . $lock['lock_name'] . ",门状态已禁用,设备序列号" . $lock['lock_sn'];
                $smsdata2 = array("mobiles" => $mobiles, "content" => $content2);
                sendymSms($smsdata2);
            }
        }
        $latitude = input("latitude");
        $longitude = input("longitude");
        $result = \app\module\lockServer\Lock::OpenLock($lock, $latitude, $longitude);

        if ($result['state'] == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
            $data['remark'] = $result['state_msg'];
        }

        $data['user_id'] = $lock["user_id"];
        $data['type'] = 1;
        \xhadmin\service\api\LockLogService::add($data);
        //用户类型判断
        $member_type = $memberInfo["member_type"];
        $member_type_head = '';
        switch ($member_type) {
            case 1:
                $member_type_head = '微信用户';
                break;
            case 2:
                $member_type_head = '支付宝用户';
                break;
            case 3:
                $member_type_head = '抖音用户';
                break;
            default:
                // code...
                break;
        }
        $senddata['lock_id'] = $lock_id;
        $senddata['lockname'] = $lock['lock_name'];
        $senddata['locksn'] = $lock['lock_sn'];
        $senddata['username'] = $member_type_head;
        $senddata['mobile'] = $memberInfo["mobile"] ? $memberInfo["mobile"] : '未登记号码';
        $senddata['opentime'] = date("Y年m月d日 H:i", time());
        $senddata['opentype'] = "小程序扫码";
        $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($lock_id);
        if ($result['state'] == 1) {
            //联动喇叭
            $linkspeakers = Db::name('linkspeaker')->where(['lock_id' => $lock_id])->select();
            if ($linkspeakers) {
                foreach ($linkspeakers as $linkspeaker) {
                    $res = HardwareCloud::Horn()->Play(
                        $linkspeaker["linkspeaker_sn"],
                        $linkspeaker["linkspeaker_tts"],
                        $linkspeaker["linkspeaker_volume"]
                    );
                }
            }
            if ($lock['opsucnt']) {
                $LockNoticeres = LockNotice::OpenLock($data['lock_id'], $member_type_head . "-" . $memberInfo["mobile"]);
                return json(Code::CodeOk(["msg" => "开门成功", "data" => [
                    "successimg" => "https://" . $_SERVER['HTTP_HOST'] . "/" . $lock["successimg"],
                    'LockNoticeres' => $LockNoticeres,
                    "xcx_sound" => $lock["xcx_sound"],
                ]]));
            }
            if ($lockauth["auth_isadmin"] != 1) {
                //增加开门次数
                \app\module\lockAuthServer\LockAuth::OpenusedAdd($lockauth["lockauth_id"]);
            }
            return json(Code::CodeOk(["msg" => "开门成功", "data" => [
                "successimg" => "https://" . $_SERVER['HTTP_HOST'] . "/" . $lock["successimg"],
                "xcx_sound" => $lock["xcx_sound"],
                "qrshowminiad" => $lock["qrshowminiad"],
            ]]));
        }
        if ($result['state_msg'] == "失败,网络故障" || $result['state_msg'] == "设备不在线") {
            $senddata['openstatus'] = "失败";
            $res = wmjSendWechatMsg('socn', $senddata);
            return json(Code::CodeErr(1003, $result['state_msg'], $lock));
        }
        return json(Code::CodeErr(1000, $result['state_msg'], $result));
    }


    function start()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);
        $OpenLock = HardwareCloud::AirSwitch()->ElectricityStart($lock["lock_sn"]);
        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock["lock_id"], 5, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 5, 1);
        return json(Code::CodeOk(["msg" => "开成功"]));

    }

    function open()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);
        $OpenLock = HardwareCloud::LockSwitch()->Open($lock["lock_sn"]);

        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock["lock_id"], 13, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 13, 1);
        return json(Code::CodeOk(["msg" => "开成功"]));

    }

    function close()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);
        $OpenLock = HardwareCloud::LockSwitch()->Close($lock["lock_sn"]);

        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock["lock_id"], 14, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 14, 1);
        return json(Code::CodeOk(["msg" => "关成功"]));

    }

    function pause()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);
        $OpenLock = HardwareCloud::LockSwitch()->Pause($lock["lock_sn"]);

        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock["lock_id"], 15, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 15, 1);
        return json(Code::CodeOk(["msg" => "停成功"]));

    }

    function startTest()
    {
        $lock_sn = input("lock_sn");

        $lock = Lock::InfoWLockSn($lock_sn);
        $OpenLock = HardwareCloud::AirSwitch()->ElectricityStart($lock_sn);


        if ($OpenLock["err"]) {

            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }

        return json(Code::CodeOk(["msg" => "开成功"]));

    }

    function stop()
    {

        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);
        $OpenLock = HardwareCloud::AirSwitch()->ElectricityStop($lock["lock_sn"]);
        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock["lock_id"], 6, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 6, 1);
        return json(Code::CodeOk(["msg" => "关成功"]));

    }

    function stopTest()
    {

        $lock_sn = input("lock_sn");

        $lock = Lock::InfoWLockSn($lock_sn);
        $OpenLock = HardwareCloud::AirSwitch()->ElectricityStop($lock_sn);
        $UidRes = MemberServer::Uid();

        $member_id = $UidRes["uid"];
        if ($OpenLock["err"]) {

            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }

        return json(Code::CodeOk(["msg" => "关成功"]));

    }

    function electricityStart()
    {
        $lock_id = input("lock_id");
        $lockInfo = LockDb::getInfo($lock_id);
        $OpenLock = HardwareCloud::AirSwitch()->ElectricityStart($lockInfo["lock_sn"]);
        $member_id = $this->_data["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock_id, 5, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock_id, 5, 1);
        return json(Code::CodeOk(["msg" => "开电成功"]));

    }

    function electricityStop()
    {
        $lock_id = input("lock_id");
        $lockInfo = LockDb::getInfo($lock_id);
        $OpenLock = HardwareCloud::AirSwitch()->ElectricityStop($lockInfo["lock_sn"]);
        $member_id = $this->_data["uid"];
        if ($OpenLock["err"]) {
            LockLog::add($member_id, $lock_id, 6, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock_id, 6, 1);
        return json(Code::CodeOk(["msg" => "关电成功"]));

    }

//    function info()
//    {
//        $lock_id = input("lock_id");
//        $lockInfo = LockDb::getInfo($lock_id);
//        $OpenLock = HardwareCloud::AirSwitch()->Getdevinfo($lockInfo["lock_sn"]);
//        if ($OpenLock["err"]) {
//            return json(Code::CodeErr(1000, ($OpenLock["err"])));
//        }
//        if ($OpenLock["data"]["info"]["switch_state"] == 1) {
//            $OpenLock["data"]["info"]["switch_state"] = "接通";
//        } else {
//            $OpenLock["data"]["info"]["switch_state"] = "断开";
//        }
//
//        Db::name("lock")->where(["lock_id" => $lock_id])->update([
//            "imei" => $OpenLock["data"]["info"]["imei"],
//            "iccid" => $OpenLock["data"]["info"]["iccid"],
//        ]);
//
//
//        return json(Code::CodeOk(["msg" => "获取成功", "data" => $OpenLock["data"]["info"]]));
//
//    }
    function info()
    {
        $lock_id = input("lock_id");

        // 尝试从 Redis 中读取缓存的数据
        $cacheKey = "switch_info:" . $lock_id;
        $cachedData = Redis::Redis()->get($cacheKey);

        if ($cachedData) {
            // 如果缓存存在，直接返回缓存数据
            return json(Code::CodeOk(["msg" => "获取成功", "data" => json_decode($cachedData,true)]));
        }

        // 缓存不存在，继续获取数据
        $lockInfo = LockDb::getInfo($lock_id);
        $OpenLock = HardwareCloud::AirSwitch()->Getdevinfo($lockInfo["lock_sn"]);

        // 判断接口调用是否成功
        if ($OpenLock["err"]) {
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }

        // 更新开关状态
        if ($OpenLock["data"]["info"]["switch_state"] == 1) {
            $OpenLock["data"]["info"]["switch_state"] = "接通";
        } else {
            $OpenLock["data"]["info"]["switch_state"] = "断开";
        }

        // 更新数据库中的IMEI和ICCID
        Db::name("lock")->where(["lock_id" => $lock_id])->update([
            "imei" => $OpenLock["data"]["info"]["imei"],
            "iccid" => $OpenLock["data"]["info"]["iccid"],
        ]);

        // 如果数据成功获取并且code为0，缓存数据
        if ($OpenLock["data"]["code"] == 0) {
            Redis::Redis()->set($cacheKey, json_encode($OpenLock["data"]["info"]), 60); // 缓存时间为60秒
        }

        return json(Code::CodeOk(["msg" => "获取成功", "data" => $OpenLock["data"]["info"]]));
    }
    function getLastUsage()
    {
        $lock_id = input("lock_id");
        $days = input("days", 7); // 默认获取最近7天数据
        $page = input("page", 0); // 当前页数，默认第0页（最近的数据）

        // 尝试从 Redis 中读取缓存的数据
        $cacheKey = "getLastUsage:" . $lock_id . ":page:" . $page;
        $cachedData = Redis::Redis()->get($cacheKey);

        if ($cachedData) {
            // 如果缓存存在，直接返回缓存数据
            return json(Code::CodeOk([
                "msg" => "获取成功1",
                "data" => json_decode($cachedData, true),
                "sql" => "Data from cache, no SQL executed"
            ]));
        }

        // 获取锁的信息
        $lockInfo = LockDb::getInfo($lock_id);
        if (!$lockInfo) {
            return json(Code::CodeError(["msg" => "设备信息不存在"]));
        }

        // 计算日期范围：根据当前页和天数
        $startDate = date('Y-m-d 00:00:00', strtotime("-" . ($days * ($page + 1)) . " days"));
        $endDate = date('Y-m-d 23:59:59', strtotime("-" . ($days * $page) . " days"));

        // 从数据库中获取数据
        $LastUsage = Db::name("switch_daily_report")
            ->where("device_sn", $lockInfo['lock_sn'])
            ->whereBetween("created_at", [$startDate, $endDate]) // 日期范围
            ->order("created_at", "desc") // 按时间倒序
            ->select();

        // 获取执行的 SQL 语句
        $lastSql = Db::getLastSql();

        if ($LastUsage) {
            // 缓存数据到 Redis
            Redis::Redis()->set($cacheKey, json_encode($LastUsage), 5); // 缓存时间为10小时
            return json(Code::CodeOk([
                "msg" => "获取成功2",
                "data" => $LastUsage,
                "sql" => $lastSql // 输出执行的 SQL 语句
            ]));
        }

        return json(Code::CodeError([
            "msg" => "没有找到相关数据",
            "sql" => $lastSql // 如果没有找到数据，也输出 SQL 语句
        ]));
    }


    function config()
    {

        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);


        $config = [
            "lock_id" => $lock["lock_id"],
            "applyauth" => $lock["applyauth"],
            "applyauth_check" => $lock["applyauth_check"],
            "location_check" => $lock["location_check"],
            "lock_name" => $lock["lock_name"],
            "mobile_check" => $lock["mobile_check"],
            "status" => $lock["status"],
            "xcx_sound" => $lock["xcx_sound"],
            "device_sound" => isset($lock["device_sound"]) ? $lock["device_sound"] : 1,
            "opsucnt" => $lock["opsucnt"],
            "qrshowminiad" => $lock["qrshowminiad"],
            "relay_delay" => $lock["relay_delay"] ? intval($lock["relay_delay"]) / 1000 : 1,
            "relay_nonc_mode" => $lock["relay_nonc_mode"] !== null ? intval($lock["relay_nonc_mode"]) : 0,
        ];

        // 添加设备能力信息
        $lock_ability = \app\module\device\server\Device::DeviceAbility($lock["lock_sn"]);
        $config["lock_ability"] = $lock_ability;

        if(mb_substr($lock["lock_sn"], 0, 3) == "W70")
        {
            $devinfo = HardwareCloud::App()->GetDevInfo($lock["lock_sn"]);

            if(isset($devinfo["data"]["info"]["volume"]) && !empty($devinfo["data"]["info"]["volume"])) {
                $config["volume"] = $devinfo["data"]["info"]["volume"];
            }
            if(isset($devinfo["data"]["info"]["speaker"]) && !empty($devinfo["data"]["info"]["speaker"])) {
                $config["speaker"] = $devinfo["data"]["info"]["speaker"];
            }
            if(isset($devinfo["data"]["info"]["speed"]) && !empty($devinfo["data"]["info"]["speed"])) {
                $config["speed"] = $devinfo["data"]["info"]["speed"];
            }
            if(isset($devinfo["data"]["info"]["tone"]) && !empty($devinfo["data"]["info"]["tone"])) {
                $config["tone"] = $devinfo["data"]["info"]["tone"];
            }
        }

        return json(Code::CodeOk([
            "msg" => "获取成功",
            "data" => $config,

        ]));
    }
    function authconfig()
    {

        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);


        $config = [
            "lockauth_id" => $lockauth_id,
            "auth_sort" => $lockAuth["auth_sort"]
        ];

        return json(Code::CodeOk([
            "msg" => "获取成功",
            "data" => $config,

        ]));
    }
    function configSet()
    {

        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        $LockInfo = \app\module\lockServer\Lock::Info($lockAuth["lock_id"]);
        $data["applyauth"] = input("applyauth");
        $data["applyauth_check"] = input("applyauth_check");
        $data["location_check"] = input("location_check");
        $data["lock_name"] = input("lock_name");
        $data["mobile_check"] = input("mobile_check");
        $data["status"] = input("status");
        $data["xcx_sound"] = input("xcx_sound");
        $data["opsucnt"] = input("opsucnt");
        $data["user_id"] = $LockInfo["user_id"];
        $data["qrshowminiad"] = input("advertising_enabled");
        if ($data["status"]==1)
        {
            $reslockdata=LockDb::getInfo($lockAuth["lock_id"]);
            if ($reslockdata&& mb_substr($reslockdata["lock_sn"],0,4)=="W763")
            {
                HardwareCloud::Accesscontrol()::SetEs($reslockdata["lock_sn"],1);
            }
        }
        $qrcodeurl = "https://" . $_SERVER['HTTP_HOST'] . "/minilock?" . "user_id=" . $data['user_id'] . "&lock_id=" . $lockAuth["lock_id"];
        $data['lock_qrcode'] = \app\module\lockServer\Lock::createmarkqrcode($qrcodeurl, $data['lock_name']);
        \app\module\lockServer\Lock::Edit($lockAuth["lock_id"], $data);
        return json(Code::CodeOk([
            "msg" => "更新成功",
            "sql" => Db::name("lock")->getLastSql()

        ]));
    }
    function authconfigSet()
    {
        $lockauth_id = input("lockauth_id");
        $data["auth_sort"] = input("auth_sort");
        \app\module\lockAuthServer\LockAuth::Edit($lockauth_id,$data);
        return json(Code::CodeOk([
            "msg" => "更新成功",
            "code" => 0
        ]));
    }

    function infoV2()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);

        $lock = \app\module\lockServer\Lock::Online($lock);

        $info = [
            "lock_sn" => $lock["lock_sn"],
            "lock_name" => $lock["lock_name"],
            "lock_qrcode" => $lock["lock_qrcode"],
            "batterypower" => $lock["batterypower"],
            "rssi" => $lock["rssi"],
            "iccid" => $lock["iccid"],
            "version" => $lock["firmware_version"] ? $lock["firmware_version"] : $lock["version"],
            "addcardmode" => $lock["addcardmode"],
            "noncmode" => $lock["noncmode"],
            "cpimgmode" => $lock["cpimgmode"],
            "on_line_time" => $lock["on_line_time"],
        ];
        $info["addcardmode_status"] = 0;
        $info["qrServer_status"] = 0;
        $info["qrServer_type"] = 0;
        $info["iccid_status"] = 0;
        if (mb_substr($lock["lock_sn"], 0, 4) == "W765" || mb_substr($lock["lock_sn"], 0, 4) == "W766") {
            $info["addcardmode_status"] = 1;
            $info["qrServer_status"] = 1;
            $info["qrServer_type"] = 1;
            $info["iccid_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 4) == "W761") {
            $info["nonc_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 4) == "W763") {
            $info["nonc_status"] = 1;
        }
        //WiFi锁
        if (mb_substr($lock["lock_sn"], 0, 4) == "W896") {
            $info["nonc_status"] = 1;
        }
        //4G锁
        if (mb_substr($lock["lock_sn"], 0, 4) == "W894") {
            $info["nonc_status"] = 1;
            $info["iccid_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 5) == "WMJ62") {
            $info["addcardmode_status"] = 1;
            $info["qrServer_status"] = 1;
            $info["iccid_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 3) == "W77") {
            $info["addcardmode_status"] = 0;
            $info["qrServer_status"] = 1;
            $info["cpimg"] = 1;
        }
        //mlog("infoV2:" . json_encode($info));
        return json(Code::CodeOk([
            "msg" => "获取成功",
            "data" => $info,

        ]));

    }

    function infobysn()
    {
        $locksn = input("deviceSn");
        $lock = Lock::InfoWLockSn($locksn);

        $lock = \app\module\lockServer\Lock::Online($lock);

        $info = [
            "lock_sn" => $lock["lock_sn"],
            "lock_name" => $lock["lock_name"],
            "lock_qrcode" => $lock["lock_qrcode"],
            "batterypower" => $lock["batterypower"],
            "rssi" => $lock["rssi"],
            "iccid" => $lock["iccid"],
            "version" => $lock["firmware_version"] ? $lock["firmware_version"] : $lock["version"],
            "addcardmode" => $lock["addcardmode"],
            "noncmode" => $lock["noncmode"],
            "on_line_time" => $lock["on_line_time"],
        ];
        $info["addcardmode_status"] = 0;
        $info["qrServer_status"] = 0;
        $info["qrServer_type"] = 0;
        $info["iccid_status"] = 0;
        if (mb_substr($lock["lock_sn"], 0, 4) == "W763" || mb_substr($lock["lock_sn"], 0, 4) == "W765" || mb_substr($lock["lock_sn"], 0, 4) == "W766") {
            $info["addcardmode_status"] = 1;
            $info["qrServer_status"] = 1;
            $info["qrServer_type"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 3) == "W89") {
            $info["nonc_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 4) == "W763") {
            $info["nonc_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 5) == "WMJ62") {
            $info["addcardmode_status"] = 1;
            $info["qrServer_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 3) == "W77") {
            $info["addcardmode_status"] = 0;
            $info["qrServer_status"] = 1;
        }
        //mlog("infoV2:" . json_encode($info));
        return json(Code::CodeOk([
            "msg" => "获取成功",
            "data" => $info,

        ]));

    }

    function list()
    {
        $res = MemberServer::Uid();  // 获取用户的 UID
        // mlog("list_uid:".json_encode($res),"device.txt");

        $member_id = $res["uid"];

        // 如果 UID 无效（如用户未登录或身份验证失败），则直接返回错误
        if (empty($member_id)) {
            return json(Code::CodeErr(401, "Unauthorized: UID 获取失败或用户未登录"));
        }

        $page = input("page");
        $limit = input("limit");
        $device_group_id = input("device_group_id");
        $DeviceGroupInfo = \app\module\device\server\DeviceGroup::Info($device_group_id);

        // 更新分组时间
        Db::name("device_group")->where(["device_group_id" => $device_group_id])->update(["updated_at" => time()]);

        $search_key = trim((string)input("search_key"));

        // 构建查询模型，首先只查找与当前用户相关的设备
        $model = LockAuth::where(["member_id" => $member_id])
            ->whereNull("deleted_at")
            ->where(["auth_status" => 1]);

        // 根据设备分组类型执行不同的查询逻辑
        if ($DeviceGroupInfo["type"] == 1) {
            $model->where(function ($q) use ($DeviceGroupInfo) {
                $q->whereOr(["device_group_id" => 0]);
                $q->whereOr(["device_group_id" => $DeviceGroupInfo["device_group_id"]]);
            });
        } else {
            $model->where(["device_group_id" => $DeviceGroupInfo["device_group_id"]]);
        }

        // 如果有搜索关键字，增加搜索条件
        if ($search_key !== '') {
            $matchedLockIds = Db::name("lock")
                ->where(function ($query) use ($search_key) {
                    $query->whereOr("lock_sn", "like", "%{$search_key}%");
                    $query->whereOr("lock_name", "like", "%{$search_key}%");
                })
                ->column("lock_id");

            $matchedGroupIds = Db::name("device_group")
                ->where("device_group_name", "like", "%{$search_key}%")
                ->column("device_group_id");

            $matchedMemberIds = Db::name("member")
                ->where(function ($query) use ($search_key) {
                    $query->whereOr("mobile", "like", "%{$search_key}%");
                    $query->whereOr("realname", "like", "%{$search_key}%");
                    $query->whereOr("nickname", "like", "%{$search_key}%");
                })
                ->column("member_id");

            $model->where(function ($query) use ($search_key, $matchedLockIds, $matchedGroupIds, $matchedMemberIds) {
                $query->whereOr("arealname", "like", "%{$search_key}%");

                if (!empty($matchedLockIds)) {
                    $query->whereOr("lock_id", "in", $matchedLockIds);
                }

                if (!empty($matchedGroupIds)) {
                    $query->whereOr("device_group_id", "in", $matchedGroupIds);
                }

                if (!empty($matchedMemberIds)) {
                    $query->whereOr("member_id", "in", $matchedMemberIds);
                }
            });
        }

        // 统计结果并分页获取数据
        $count = $model->count();
        $lockauth = $model->with("lock")->order("auth_sort desc")->page($page, $limit)->select()->toArray();

        foreach ($lockauth as &$vo) {
            $vo["lock"] = \app\module\lockServer\Lock::ensureQrcode($vo["lock"] ?: []);
            $vo["lock"] = \app\module\lockServer\Lock::Online($vo["lock"]);
            $vo["lock"]["switch_state"] = 0;
            $vo["auth_endtime1"] = " ";
            $vo["auth_starttime1"] = " ";
            $vo["cs"] = " ";
            $delimiter = " ";
            $unt = " ";
            if ($vo["auth_isadmin"] != 1) {
                if ($vo["auth_openlimit"]) {
                    $vo["cs"] = $vo["auth_openlimit"] - $vo["auth_openused"];
                    $delimiter = ",";
                    $unt = "次";
                    $vo["auth_limit"] = "剩余" . $vo["cs"] . $unt;
                }
                if ($vo["auth_endtime"]) {
                    $vo["auth_endtime1"] = "过期:" . date("Y-m-d H:i", $vo["auth_endtime"]);
                } else {
                    $delimiter = " ";
                }
                if ($vo["auth_starttime"]) {
                    $vo["auth_starttime1"] = "生效:" . date("Y-m-d H:i", $vo["auth_starttime"]);
                } else {
                    $delimiter = " ";
                }
            }
            $vo["device_type"] = \app\module\device\server\Device::DeviceType($vo["lock"]["lock_sn"]);
            $vo["lock_ability"] = \app\module\device\server\Device::DeviceAbility($vo["lock"]["lock_sn"]);
        }

        return json(Code::CodeOk(["msg" => "获取成功", "data" => $lockauth, "count" => $count]));
    }


    function getDeviceStatus()
    {
        $deviceSn = input("deviceSn");
        if (mb_substr($deviceSn, 0, 3) == "W71" || mb_substr($deviceSn, 0, 3) == "W72") {
            $Getdevinfo = HardwareCloud::AirSwitch()->Getdevinfo($deviceSn);
            if (!$Getdevinfo["err"]) {
                return json(Code::CodeOk(["msg" => "获取成功", "switch_state" => $Getdevinfo["data"]["info"]["switch_state"]]));
            }
        }
    }

    function getStatus()
    {
        $deviceSn = input("deviceSn");
        $lockInfo['lock_sn'] = $deviceSn;
        $lockinfo = \app\module\lockServer\Lock::DeviceInfo($lockInfo);
        return json(Code::CodeOk(["msg" => "获取成功", "lockinfo" => $lockinfo]));
    }
    function deviceInfo()
    {
        $lock_id = input("lock_id");
        $deviceinfo = Lock::Info($lock_id);
        $deviceinfo = \app\module\lockServer\Lock::ensureQrcode($deviceinfo ?: []);
        return json(Code::CodeOk(["msg" => "获取成功", "deviceinfo" => $deviceinfo]));
    }
    function audioConfig()
    {
        $lock_id = input("lock_id");
        $info = Db::name("lock")->where(["lock_id" => $lock_id])->field(["openttscontent", "volume"])->find();
        return json(Code::CodeOk(["msg" => "获取成功", "data" => $info,]));
    }

    function audioConfigSet()
    {
        $lock_id = input("lock_id");
        $tts = input("tts");
        $volume = input("volume");
        Db::name("lock")->where(["lock_id" => $lock_id])->update([
            "openttscontent" => $tts,
            "volume" => $volume,
        ]);
        //查询锁序列号
        $lockdata = \xhadmin\db\Lock::getInfo($lock_id);

        if (mb_substr($lockdata["lock_sn"], 0, 3) == "W82") {
            $Cloudspeaker = HardwareCloud::Horn()->Cloudspeaker($lockdata["lock_sn"], $tts, $volume);
            if ($Cloudspeaker["err"]) {

                return json(Code::CodeErr(1000, $Cloudspeaker["err"]));
            }


        } elseif (mb_substr($lockdata["lock_sn"], 0, 3) == "W76") {
            $Accesscontrolres = HardwareCloud::Accesscontrol()->Configaudio($lockdata["lock_sn"], $tts, $volume);
            if ($Accesscontrolres["err"]) {
                return json(Code::CodeErr(1000, $Accesscontrolres["err"]));
            }
        } else {

            $stateresult = wmjHandle($lockdata['lock_sn'], 'lockstate');
            $postdata['sn'] = $lockdata['lock_sn'];
            $postdata['openttscontent'] = $tts;
            $postdata['volume'] = $volume;
            if ($stateresult['online']) {

                $result = wmjManageHandle($lockdata['lock_sn'], 'audioconfig', $postdata);
                if (!$result['state']) {

                    return json(Code::CodeErr(1000, $result['state_msg']));
                }

            } else {

                return json(Code::CodeErr(1000, "操作失败,设备不在线"));
            }

        }


        return json(Code::CodeOk(["msg" => "设置成功",]));
    }


    function listCard()
    {


        $res = MemberServer::Uid();
        $member_id = $res["uid"];


        $model = LockAuth::where(["member_id" => $member_id])->whereNull("deleted_at")->where([
            "auth_status" => 1,
            "auth_isadmin" => 1,
        ]);


        $lockauth = $model->with("lock")->order("lockauth_id desc")->select()->toArray();
        $arr = [];
        foreach ($lockauth as $vo) {

            $lock_ability = \app\module\device\server\Device::DeviceAbility($vo["lock"]["lock_sn"]);
            if ($lock_ability["card_status"]) {
                $arr[] = [
                    "lock_id" => $vo["lock_id"],
                    "lock_name" => $vo["lock"]["lock_name"],
                    "lock_sn" => $vo["lock"]["lock_sn"],
                ];
            }

        }


        return json(Code::CodeOk(["msg" => "获取成功", "data" => $arr,]));

    }

    function listFace()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $now = time();
        $exclude_lock_id = input("exclude_lock_id"); // 排除指定设备

        // 只要用户拥有该设备的有效钥匙权限（不限于管理员），就可以同步人脸
        // 需要检查：钥匙已启用、未过期、已到生效时间
        $model = LockAuth::where(["member_id" => $member_id])->whereNull("deleted_at")->where([
            "auth_status" => 1,
        ])->where(function($query) use ($now) {
            // 管理员不受时间限制，或者钥匙在有效期内
            $query->where("auth_isadmin", 1)
                  ->whereOr(function($q) use ($now) {
                      $q->where(function($q2) use ($now) {
                          // 生效时间：未设置或已到时间
                          $q2->whereNull("auth_starttime")
                             ->whereOr("auth_starttime", "<=", $now);
                      })->where(function($q3) use ($now) {
                          // 过期时间：未设置或未过期
                          $q3->whereNull("auth_endtime")
                             ->whereOr("auth_endtime", "=", 0)
                             ->whereOr("auth_endtime", ">", $now);
                      });
                  });
        });


        $lockauth = $model->with("lock")->order("lockauth_id desc")->select()->toArray();
        $arr = [];
        foreach ($lockauth as $vo) {

            $lock_ability = \app\module\device\server\Device::DeviceAbility($vo["lock"]["lock_sn"]);
            if ($lock_ability["face_status"]) {
                // 如果设置了 exclude_lock_id，则排除该设备
                if ($exclude_lock_id && $vo["lock_id"] == $exclude_lock_id) {
                    continue;
                }
                $arr[] = [
                    "lock_id" => $vo["lock_id"],
                    "lock_name" => $vo["lock"]["lock_name"],
                    "lock_sn" => $vo["lock"]["lock_sn"],
                ];
            }

        }


        return json(Code::CodeOk(["msg" => "获取成功", "data" => $arr,]));

    }

    function sendCard()
    {

        $lock_ids = input("lock_ids");
        $lockcard_id = input("lockcard_id");
        $lockcard = Db::name("lockcard")->where(["lockcard_id" => $lockcard_id])->find();
        unset($lockcard["lockcard_id"]);

        foreach ($lock_ids as $vo) {
            $lockcard1 = Db::name("lockcard")->where(["lockcard_sn" => $lockcard["lockcard_sn"], "lock_id" => $vo])->whereNull("deleted_at")->find();
            if ($lockcard1) {
                Db::name("lockcard")->where(["lockcard_id" => $lockcard1["lockcard_id"]])->update([
                    "lockcard_endtime" => $lockcard["lockcard_endtime"],
                    "lockcard_username" => $lockcard["lockcard_username"],
                    "lockcard_remark" => $lockcard["lockcard_remark"],
                ]);
            } else {

                $lockcard["lock_id"] = $vo;
                Db::name("lockcard")->insert($lockcard);


            }
            $lockdata = Lock::Info($vo);
            $res = \app\module\lockServer\Lock::CardAdd($lockdata, $lockcard['lockcard_sn'], $lockcard['lockcard_endtime']);

        }


        return json(Code::CodeOk(["msg" => "发卡成功"]));
    }

    function devAddCard()
    {
        $lockauth_id = input("lockauth_id");
        $addcardmode = input("addcardmode");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        $lockdata = Lock::Info($lockAuth["lock_id"]);
        try {
            $postdata['sn'] = $lockdata['lock_sn'];
            $postdata['addcardmode'] = $addcardmode;

            if (mb_substr($lockdata['lock_sn'], 0, 3) == "W76") {
                if ($addcardmode == 1) {
                    $state = 1;
                } else {
                    $state = 0;
                }
                $res = HardwareCloud::App()->CardModeSet($lockdata['lock_sn'], $state);
                if ($res["err"]) {
                    return json(Code::CodeErr(1001, $res["err"]));
                } else {
                    db()->name('lock')->where('lock_id', $lockdata['lock_id'])->update(['addcardmode' => $addcardmode]);
                }

            } else {
                $stateresult = wmjHandle($lockdata['lock_sn'], 'lockstate');
                if ($stateresult['online']) {
                    $result = wmjManageHandle($lockdata['lock_sn'], 'devaddcard', $postdata);
                    if (!$result['state']) {

                        return json(Code::CodeErr(1000, $result['state_msg']));
                    } else {
                        db()->name('lock')->where('lock_id', $lockdata['lock_id'])->update(['addcardmode' => $addcardmode]);
                    }
                } else {
                    return json(Code::CodeErr(1000, "设置失败,设备不在线"));
                }
            }

        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));
        }
        return json(Code::CodeOk());
    }

    function devNoNc()
    {
        $lockauth_id = input("lockauth_id");
        $noncmode = input("noncmode");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        $lockdata = Lock::Info($lockAuth["lock_id"]);
        try {
            $postdata['sn'] = $lockdata['lock_sn'];
            $postdata['noncmode'] = $noncmode;

            if (mb_substr($lockdata['lock_sn'], 0, 3) == "W76") {
                if ($noncmode == 0) {
                    $state = 1;
                } else {
                    $state = 0;
                }
                $res = HardwareCloud::App()->NoNcModeSet($lockdata['lock_sn'], $state);
                if ($res["err"]) {
                    return json(Code::CodeErr(1001, $res["err"]));
                } else {
                    db()->name('lock')->where('lock_id', $lockdata['lock_id'])->update(['noncmode' => $noncmode]);
                }
            }
            if (mb_substr($lockdata['lock_sn'], 0, 3) == "W89") {
                if ($noncmode == 1) {
                    $state = 1;
                } else {
                    $state = 0;
                }
                $res = HardwareCloud::App()->NoNcModeSet($lockdata['lock_sn'], $state);
                if ($res["err"]) {
                    return json(Code::CodeErr(1001, $res["err"]));
                } else {
                    db()->name('lock')->where('lock_id', $lockdata['lock_id'])->update(['noncmode' => $noncmode]);
                }
            }
        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));
        }
        return json(Code::CodeOk());
    }
    function devToggleCapture()
    {
        $lockauth_id = input("lockauth_id");
        $cpimgmode = input("cpimgmode");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        $lockdata = Lock::Info($lockAuth["lock_id"]);
        try {
            $res = HardwareCloud::App()->cpimgModeSet($lockdata['lock_sn'], $cpimgmode);
            if ($res["err"]) {
                return json(Code::CodeErr(1001, $res["err"]));
            } else {
                db()->name('lock')->where('lock_id', $lockdata['lock_id'])->update(['cpimgmode' => $cpimgmode]);
            }
        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));
        }
        return json(Code::CodeOk());
    }

    function qrSave()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lockdata = Lock::Info($lockAuth["lock_id"]);
        try {


            $postdata['sn'] = $lockdata['lock_sn'];
            $postdata['qrcodeurl'] = 'https://' . $_SERVER['HTTP_HOST'] . '/minilock?user_id=' . $lockdata['user_id'] . '&lock_id=' . $lockdata['lock_id'] . '&st=';
            if (mb_substr($lockdata['lock_sn'], 0, 3) == "W76") {
                $type = input("type");
                $model = "passive";
                switch ($type) {
                    case 2;
                        $model = "active";
                        break;
                    case 3;
                        $model = "both";
                        break;

                }

                $res = HardwareCloud::App()->QrSet($lockdata['lock_sn'], $postdata['qrcodeurl'], $model);
                if ($res["err"]) {
                    return json(Code::CodeErr(1001, $res["err"]));
                }

            } elseif (mb_substr($lockdata['lock_sn'], 0, 3) == "W77") {
                $type = input("type");
                $model = "passive";
                switch ($type) {
                    case 2;
                        $model = "active";
                        break;
                    case 3;
                        $model = "both";
                        break;
                }
                $res = HardwareCloud::App()->QrSet($lockdata['lock_sn'], $postdata['qrcodeurl'], $model);
                if ($res["err"]) {
                    return json(Code::CodeErr(1001, $res["err"]));
                }
            } else {
                $stateresult = wmjHandle($lockdata['lock_sn'], 'lockstate');
                if ($stateresult['online']) {

                    $result = wmjManageHandle($lockdata['lock_sn'], 'lcdconfig', $postdata);
                    if (!$result['state']) {
                        return json(Code::CodeErr(1000, $result['state_msg']));

                    }
                } else {

                    return json(Code::CodeErr(1000, "设置失败,设备不在线"));
                }
            }


        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));

        }
        return json(Code::CodeOk());
    }

    function record()
    {


        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $lock_id = input("lock_id");
        $page = input("page");
        $limit = input("limit");


        $model = \app\module\model\LockLog::where([]);
        $model->alias("log")->field("log.*");
        if ($lock_id) {
            $model->where(["log.lock_id" => $lock_id]);
        } else {
            $model->where(["log.member_id" => $member_id]);
        }
//        $model->whereNull("mobile");


        $search_key = input("search_key");
        if ($search_key) {
            $model->leftJoin("member m", "m.member_id = log.member_id");
            $model->where("m.mobile", "like", "%{$search_key}%");
        }
        $startTime = input("startTime");
        if ($startTime) {

            $model->where("log.create_time", ">", $startTime);
        }
        $endTime = input("endTime");
        if ($endTime) {

            $model->where("log.create_time", "<", $endTime);
        }
        $count = $model->count();
        $LockLog = $model->with(["lock", "memberInfo"])->order("locklog_id desc")->page($page, $limit)->select();

        foreach ($LockLog as &$vo) {

            if ($vo["headimgurl"]) {
                $vo["headimgurl"] = $vo["headimgurl"];
            } else {
                $vo["headimgurl"] = null;
            }
            if (!$vo["user_name"]) {
                $memberInfo = MemberServer::Info($vo["member_id"]);
                $nickname = $memberInfo["nickname"] ?? ''; // 检查是否存在nickname
                $realname = $memberInfo["realname"] ?? ''; // 检查是否存在realname
                $remark = $memberInfo["remark"] ?? '';     // 检查是否存在remark
                // 创建一个数组并使用array_filter移除空值，然后用下划线拼接
                $username = implode('_', array_filter([$nickname, $realname, $remark]));
                $vo["user_name"]=$username;
                Db::name("locklog")->where(["locklog_id" => $vo["locklog_id"]])->update([
                    "user_name" => $username
                ]);
            }

            if (!$vo["mobile"]) {
                $memberInfo = MemberServer::Info($vo["member_id"]);
                if ($memberInfo["mobile"]) {
                    Db::name("locklog")->where(["locklog_id" => $vo["locklog_id"]])->update([
                        "mobile" => $memberInfo["mobile"]
                    ]);
                    $vo["mobile"] = $memberInfo["mobile"];
                }


                if (!$vo["mobile"]) {
                    $vo["mobile"] = "00000000000";
                }
            }
            $vo["mobileShow"] = $vo["mobile"];
            $vo["mobile"] = mb_substr($vo["mobile"], 0, 3) . "****" . mb_substr($vo["mobile"], 7, 4);

            $vo["type_name"] = \app\module\lockServer\LockLog::$type[$vo["type"]];
        }


        return json(Code::CodeOk(["msg" => "获取成功", "data" => $LockLog, "count" => $count]));

    }

    function power()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $lock_sn = input("lock_sn");
        $page = input("page", 1); // 默认第一页
        $limit = input("limit", 100); // 默认每页100条

        // 获取分页后的数据
        $LockPower = Lock::LockPower($lock_sn, $page, $limit);

        // 获取总记录数以便返回总数
        $totalCount = Db::name("power")->where(["device_sn" => $lock_sn])->count();

        return json(Code::CodeOk(["msg" => "获取成功", "data" => $LockPower, "count" => $totalCount]));
    }

    function onoffline()
    {
        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $lock_sn = input("lock_sn");
        $page = input("page");
        $limit = input("limit");
        $LockPower = Lock::OnOffline($lock_sn);
        return json(Code::CodeOk(["msg" => "获取成功", "data" => $LockPower, "count" => 100]));

    }

    function all()
    {


        $res = MemberServer::Uid();
        $member_id = $res["uid"];

        $device_group_id = input("device_group_id");
        $DeviceGroupInfo = \app\module\device\server\DeviceGroup::Info($device_group_id);

        $model = LockAuth::where(["member_id" => $member_id])->where("auth_status", "<>", 0)->whereNull("deleted_at");

        if ($DeviceGroupInfo["type"] == 1) {
            $model->where(function ($q) use ($DeviceGroupInfo) {
                $q->whereOr(["device_group_id" => 0]);
                $q->whereOr(["device_group_id" => $DeviceGroupInfo["device_group_id"]]);
            });
        } else {
            $model->where(["device_group_id" => $DeviceGroupInfo["device_group_id"]]);
        }
        $count = $model->count();
        $lockauth = $model->with("lock")->order("lockauth_id desc")->select();


        return json(Code::CodeOk(["msg" => "获取成功", "data" => [
            "all" => $lockauth,
            "info" => $DeviceGroupInfo,
            "count" => $count
        ]]));

    }


    public function transfer()
    {
        $lockauth_id = input("lockauth_id");
        $member_id = input("member_id");
        $res = MemberServer::Uid();

        $lockauth = Db::name("lockauth")->where(['lockauth_id' => $lockauth_id, "member_id" => $res["uid"]])->find();
        $userdata = Db::name("user")->where(['member_id' => $member_id])->find();
        if (!$lockauth) {
            return json(Code::CodeErr(1000, "没有权限"));
        }
        if (!$userdata) {
            return json(Code::CodeErr(1000, "对方未创建管理账号"));
        }
        if ($lockauth["auth_member_id"] != 0) {
            return json(Code::CodeErr(1000, "只有超级管理员可以转移"));
        }

        Db::name('lock')->where('lock_id', $lockauth['lock_id'])->update(['user_id' => $userdata['user_id'],'member_id'=>$member_id]);
        Db::name("lockauth")->where(['lockauth_id' => $lockauth_id, "member_id" => $res["uid"]])->update([
            "member_id" => $member_id,
            "device_group_id" => 0,
            "user_id" => $userdata['user_id'],
            "auth_member_id"=>0
        ]);
        db()->name('locklog')->where('lock_id', $lockauth['lock_id'])->update(['user_id' => $userdata['user_id']]);
        db()->name('lockcard')->where('lock_id', $lockauth['lock_id'])->update(['user_id' => $userdata['user_id']]);
        db()->name('locktimes')->where('lock_id', $lockauth['lock_id'])->update(['user_id' => $userdata['user_id']]);
        return json(Code::CodeOk(["msg" => "转移成功",]));
    }

    public function memberInfo()
    {
        $mobile = input("mobile");
        $memberInfo = MemberServer::InfoWMobile($mobile);
        if (!$memberInfo) {
            return json(Code::CodeErr(1000, "没有找到用户"));
        }

        return json(Code::CodeOk(["msg" => "查询成功", "data" => $memberInfo]));

    }

    public function horn()
    {

        $lockauth_id = input("lockauth_id");
        $volume = input("volume");
        $tts = input("tts");
        $isLoopEnabled = input("isLoopEnabled");
        $stopplay = input("stopplay");
        $loopInterval = input("loopInterval");
        $speaker = input("speaker", "prompt_female_high");
        $number_mode = input("number_mode", "digit");

        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        if (!$lockAuth || empty($lockAuth["lock_id"])) {
            return json(Code::CodeErr(1000, "设备授权不存在"));
        }
        $lock = Lock::Info($lockAuth["lock_id"]);
        if (!$lock || empty($lock["lock_sn"])) {
            return json(Code::CodeErr(1000, "设备不存在"));
        }
        Db::name("lock")->where(["lock_id" => $lockAuth["lock_id"]])->update([
            "openttscontent" => $tts,
            "volume" => $volume,
        ]);
        $UidRes = MemberServer::Uid();
        $res = [];
        if (isset($stopplay) && $stopplay) {
            $res = HardwareCloud::Horn()->LoopPlay($lock["lock_sn"], $tts, $volume, "loop_stop", (int)$loopInterval, $speaker, $number_mode);
        } else {
            if ($isLoopEnabled) {
                $res = HardwareCloud::Horn()->LoopPlay($lock["lock_sn"], $tts, $volume, "loop_play", (int)$loopInterval, $speaker, $number_mode);
            } else {
                $res = HardwareCloud::Horn()->Play($lock["lock_sn"], $tts, $volume, $speaker, $number_mode);
            }
        }
        if (!is_array($res)) {
            $res = ["err" => "硬件云返回异常", "data" => $res];
        }
        if (!empty($res["err"])) {
            LockLog::add($UidRes["uid"], $lock["lock_id"], 9, 0);
            return json(Code::CodeErr(1000, $res["err"]));
        } else {
            LockLog::add($UidRes["uid"], $lock["lock_id"], 9, 1);

            if (!isset($stopplay) || !$stopplay) {
                try {
                    $speed = input("speed", 5);
                    $tone = input("tone", 5);
                    $this->ensureHornBroadcastHistoryTable();

                    $existRecord = Db::name("horn_broadcast_history")
                        ->where("lock_id", $lock["lock_id"])
                        ->where("content", $tts)
                        ->where("volume", $volume)
                        ->where("speed", $speed)
                        ->where("tone", $tone)
                        ->find();

                    if ($existRecord) {
                        Db::name("horn_broadcast_history")
                            ->where("id", $existRecord["id"])
                            ->update([
                                "created_at" => time(),
                                "loop_enabled" => $isLoopEnabled ? 1 : 0,
                                "loop_interval" => $loopInterval ? (int)$loopInterval : 0
                            ]);
                    } else {
                        Db::name("horn_broadcast_history")->insert([
                            "lock_id" => $lock["lock_id"],
                            "member_id" => $UidRes["uid"],
                            "content" => $tts,
                            "volume" => $volume,
                            "speed" => $speed,
                            "tone" => $tone,
                            "loop_enabled" => $isLoopEnabled ? 1 : 0,
                            "loop_interval" => $loopInterval ? (int)$loopInterval : 0,
                            "created_at" => time()
                        ]);

                        $count = Db::name("horn_broadcast_history")
                            ->where("lock_id", $lock["lock_id"])
                            ->count();

                        if ($count > 100) {
                            $keepIds = Db::name("horn_broadcast_history")
                                ->where("lock_id", $lock["lock_id"])
                                ->order("created_at", "desc")
                                ->limit(100)
                                ->column("id");

                            Db::name("horn_broadcast_history")
                                ->where("lock_id", $lock["lock_id"])
                                ->where("id", "not in", $keepIds)
                                ->delete();
                        }
                    }
                } catch (\Throwable $e) {
                    // 历史记录是辅助功能，写入失败不能影响云喇叭播报。
                }
            }
        }

        return json(Code::CodeOk(["data" => $res]));

    }

    public function simInfo()
    {
        $sim_sn = input("sim_sn");
        $res = \app\module\device\server\Device::SimInfo($sim_sn);

        return json($res);
    }

    //查询续费信息
    public function simRenew()
    {
        $sim_sn = input("sim_sn");
        $res = \app\module\device\server\Device::SimRenew($sim_sn);
        if ($res["code"] != 0) {
            return json(Code::CodeErr(1000, $res["msg"]));
        }
        $price = $res["data"]["price"];
        $product_id = $res["data"]["product_id"];


        return json(Code::CodeOk(["data" => [
            "price" => ($price / 100) . "元",
            "product_id" => $product_id,
        ]]));
    }

    //下单支付
    public function simOrder()
    {
        $sim_sn = input("sim_sn");
        $res = \app\module\device\server\Device::SimRenew($sim_sn);
        if ($res["code"] != 0) {
            return json(Code::CodeErr(1000, $res["msg"]));
        }
        $price = $res["data"]["price"];
        $product_id = $res["data"]["product_id"];
        $Uid = MemberServer::Uid();


        $data = OrderServer::Add($Uid["uid"], $price, $product_id, $sim_sn);


        //查询用户信息
        $memberInfo = MemberServer::Info($Uid["uid"]);

        $app = WechatServer::PayApp();
        $result = $app->order->unify([
            'body' => 'sim卡续费',
            'out_trade_no' => $data["order_sn"],
            'total_fee' => $price,
//            'total_fee' => 1,
//            'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'notify_url' => 'https://your-domain.example/api/pay.Notify/index', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $memberInfo["openid"],
        ]);

        $jssdk = $app->jssdk;
        $config = $jssdk->bridgeConfig($result["prepay_id"], false); // 返回数组

        return json(Code::CodeOk(["data" => [
            "price" => ($price / 100) . "元",
            "product_id" => $product_id,
            "payData" => $config
        ]]));
    }

    public function hornTest()
    {

        $lock_sn = input("lock_sn");
        $volume = input("volume");
        $tts = input("tts");


        $lock = Lock::InfoWLockSn($lock_sn);


        $res = HardwareCloud::Horn()->Play($lock_sn, $tts, $volume);
        if ($res["err"]) {
            return json(Code::CodeErr(1000, $res["err"]));
        }

        return json(Code::CodeOk(["data" => $res]));

    }

    public function binding()
    {

        $lock_sn = input("lock_sn");

        $res = Lock::Register([
            "lock_sn" => $lock_sn,

        ]);


        return json(Code::CodeOk(["data" => $res, "msg" => "绑定成功"]));

    }

    public function Unbinding()
    {

        $lock_sn = input("lock_sn");


        $res = HardwareCloud::App()->Logout($lock_sn);


        $wmjHandleRes = wmjHandle($lock_sn, 'dellock');

        return json(Code::CodeOk(["data" => [$res, $wmjHandleRes], "msg" => "解绑成功"]));

    }
    function getuserdevice()
    {
        $res = MemberServer::Uid();  // 获取用户的 UID
        $member_id = $res["uid"];

        // 如果 UID 无效（如用户未登录或身份验证失败），则直接返回错误
        if (empty($member_id)) {
            return json(Code::CodeErr(401, "Unauthorized: UID 获取失败或用户未登录"));
        }

        // 查询用户的设备数据并计算数量
        $userDevicesQuery = Db::name("lock")
            ->where(["member_id" => $member_id])
            ->whereNull("deleted_at")
            ->field(['lock_name', 'lock_sn']);  // 仅获取 lock_name 和 lock_sn 字段

        $userDevices = $userDevicesQuery->select();  // 获取用户设备信息
        $count = $userDevicesQuery->count();  // 获取设备数量

        return json(Code::CodeOk(["msg" => "获取成功", "data" => $userDevices, "count" => $count]));
    }
    public function addlinkspeaker()
    {
        // 使用 input() 获取参数
        $lock_id = (int)input("lock_id");
        $linkspeaker_sn = input("linkspeaker_sn");
        $linkspeaker_tts = input("linkspeaker_tts");
        $linkspeaker_name = input("linkspeaker_name");
        $linkspeaker_volume = (int)input("linkspeaker_volume");

        // 验证数据
        $validate = \think\facade\Validate::rule([
            'lock_id' => 'require', // 确保 lock_id 存在且有效
            'linkspeaker_sn' => 'require',
            'linkspeaker_tts' => 'require',
            'linkspeaker_volume' => 'require|integer|between:1,7' // 假设音量等级是 1 到 7
        ]);

        $data = [
            'lock_id' => $lock_id,
            'linkspeaker_sn' => $linkspeaker_sn,
            'linkspeaker_tts' => $linkspeaker_tts,
            'linkspeaker_volume' => $linkspeaker_volume,
            'linkspeaker_name' => $linkspeaker_name
        ];

        if (!$validate->check($data)) {
            return json(Code::CodeErr(422, "参数验证失败", $validate->getError()));
        }

        try {
            // 检查是否已存在相同的 linkspeaker_sn
            $exists = Db::name('linkspeaker')
                ->where('linkspeaker_sn', $linkspeaker_sn)
                ->find();

            if ($exists) {
                return json(Code::CodeErr(409, "该喇叭已存在，无法重复添加"));
            }

            // 插入数据到 linkspeaker 表
            $id = Db::name('linkspeaker')->insertGetId([
                'lock_id' => $lock_id,
                'linkspeaker_sn' => $linkspeaker_sn,
                'linkspeaker_tts' => $linkspeaker_tts,
                'linkspeaker_volume' => $linkspeaker_volume,
                'linkspeaker_name' => $linkspeaker_name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return json(Code::CodeOk(["msg" => "添加喇叭成功", "data" => ['id' => $id]]));
        } catch (\Exception $e) {
            // 如果插入失败，返回错误信息
            return json(Code::CodeErr(500, "添加喇叭失败", $e->getMessage()));
        }
    }

    public function getlinkSpeakers()
    {
        // 获取参数
        $lock_id = (int)input('lock_id');
        $page = (int)input('page', 1);
        $limit = (int)input('limit', 10);

        // 查询联动喇叭列表
        try {
            $query = Db::name('linkspeaker')
                ->where('lock_id', $lock_id)
                ->field(['id', 'linkspeaker_name', 'linkspeaker_sn']);

            $total = $query->count(); // 总记录数
            $data = $query->page($page, $limit)->select();

            return json([
                'code' => 0,
                'msg' => '获取成功',
                'data' => $data,
                'count' => $total
            ]);
        } catch (\Exception $e) {
            return json([
                'code' => 500,
                'msg' => '获取联动喇叭失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function getlinkSwitches()
    {
        // 获取参数
        $lock_id = (int)input('lock_id');
        $page = (int)input('page', 1);
        $limit = (int)input('limit', 10);

        // 查询联动空开列表
        try {
            $query = Db::name('linkswitch')
                ->where('lock_id', $lock_id)
                ->field(['id', 'linkswitch_name', 'linkswitch_sn']);

            $total = $query->count(); // 总记录数
            $data = $query->page($page, $limit)->select();

            return json([
                'code' => 0,
                'msg' => '获取成功',
                'data' => $data,
                'count' => $total
            ]);
        } catch (\Exception $e) {
            return json([
                'code' => 500,
                'msg' => '获取联动空开失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function getlinkspeakerBySn()
    {
        // 使用 input() 获取设备序列号参数
        $linkspeaker_sn = input('linkspeaker_sn');

        try {
            // 查询设备信息
            $device = Db::name('linkspeaker')
                ->where('linkspeaker_sn', $linkspeaker_sn)
                ->field(['id', 'linkspeaker_name', 'linkspeaker_sn', 'linkspeaker_tts', 'linkspeaker_volume'])
                ->find();

            if ($device) {
                return json([
                    'code' => 0,
                    'msg' => '获取成功',
                    'data' => $device
                ]);
            } else {
                return json([
                    'code' => 404,
                    'msg' => '设备不存在'
                ]);
            }
        } catch (\Exception $e) {
            return json([
                'code' => 500,
                'msg' => '获取设备数据失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function getlinkswitchBySn()
    {
        // 使用 input() 获取设备序列号参数
        $linkswitch_sn = input('linkswitch_sn');

        try {
            // 查询设备信息
            $device = Db::name('linkswitch')
                ->where('linkswitch_sn', $linkswitch_sn)
                ->field(['id', 'linkswitch_name', 'linkswitch_sn', 'open_action', 'close_delay'])
                ->find();

            if ($device) {
                return json([
                    'code' => 0,
                    'msg' => '获取成功',
                    'data' => $device
                ]);
            } else {
                return json([
                    'code' => 404,
                    'msg' => '设备不存在'
                ]);
            }
        } catch (\Exception $e) {
            return json([
                'code' => 500,
                'msg' => '获取设备数据失败',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function editlinkspeaker()
    {
        // 使用 input() 获取参数
        $lock_id = (int)input("lock_id");
        $linkspeaker_sn = input("linkspeaker_sn");
        $linkspeaker_name = input("linkspeaker_name");
        $linkspeaker_tts = input("linkspeaker_tts");
        $linkspeaker_volume = (int)input("linkspeaker_volume");

        // 验证数据
        $validate = \think\facade\Validate::rule([
            'lock_id' => 'require', // 确保 lock_id 存在
            'linkspeaker_sn' => 'require',
            'linkspeaker_tts' => 'require',
            'linkspeaker_volume' => 'require|integer|between:1,7'
        ]);

        $data = [
            'lock_id' => $lock_id,
            'linkspeaker_sn' => $linkspeaker_sn,
            'linkspeaker_tts' => $linkspeaker_tts,
            'linkspeaker_volume' => $linkspeaker_volume,
            'linkspeaker_name' => $linkspeaker_name
        ];

        // 检查数据验证是否通过
        if (!$validate->check($data)) {
            return json(Code::CodeErr(422, "参数验证失败", $validate->getError()));
        }

        try {
            // 根据序列号和锁ID查找并更新 linkspeaker 表中的数据
            $result = Db::name('linkspeaker')
                ->where(['lock_id' => $lock_id, 'linkspeaker_sn' => $linkspeaker_sn])
                ->update([
                    'linkspeaker_name' => $linkspeaker_name,
                    'linkspeaker_tts' => $linkspeaker_tts,
                    'linkspeaker_volume' => $linkspeaker_volume,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            if ($result === false) {
                return json(Code::CodeErr(500, "更新失败"));
            }

            return json(Code::CodeOk(["msg" => "编辑喇叭成功"]));
        } catch (\Exception $e) {
            // 如果更新失败，返回错误信息
            return json(Code::CodeErr(500, "编辑喇叭失败", $e->getMessage()));
        }
    }
    public function addlinkswitch()
    {
        // 获取参数
        $lock_id = (int)input("lock_id");
        $linkswitch_sn = input("linkswitch_sn");
        $linkswitch_name = input("linkswitch_name");
        $open_action = input("open_action", 0); // 0 表示立即开电，其他数值表示延迟分钟数
        $close_delay = input("close_delay", 0); // 表示关电延时

        // 验证数据
        $validate = \think\facade\Validate::rule([
            'lock_id' => 'require',
            'linkswitch_sn' => 'require',
            'linkswitch_name' => 'require',
            'open_action' => 'integer',
            'close_delay' => 'integer'
        ]);

        $data = [
            'lock_id' => $lock_id,
            'linkswitch_sn' => $linkswitch_sn,
            'linkswitch_name' => $linkswitch_name,
            'open_action' => $open_action,
            'close_delay' => $close_delay
        ];

        if (!$validate->check($data)) {
            return json(Code::CodeErr(422, "参数验证失败", $validate->getError()));
        }

        try {
            // 检查是否已存在相同序列号的设备
            $exists = Db::name('linkswitch')->where(['lock_id' => $lock_id, 'linkswitch_sn' => $linkswitch_sn])->find();
            if ($exists) {
                return json(Code::CodeErr(409, "该联动空开已存在"));
            }

            // 插入数据
            $id = Db::name('linkswitch')->insertGetId([
                'lock_id' => $lock_id,
                'linkswitch_sn' => $linkswitch_sn,
                'linkswitch_name' => $linkswitch_name,
                'open_action' => $open_action,
                'close_delay' => $close_delay,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return json(Code::CodeOk(["msg" => "添加联动空开成功", "data" => ['id' => $id]]));
        } catch (\Exception $e) {
            return json(Code::CodeErr(500, "添加联动空开失败", $e->getMessage()));
        }
    }
    public function editlinkswitch()
    {
        // 获取参数
        $lock_id = (int)input("lock_id");
        $linkswitch_sn = input("linkswitch_sn");
        $linkswitch_name = input("linkswitch_name");
        $open_action = input("open_action", 0);
        $close_delay = input("close_delay", 0);

        // 验证数据
        $validate = \think\facade\Validate::rule([
            'lock_id' => 'require',
            'linkswitch_sn' => 'require',
            'linkswitch_name' => 'require',
            'open_action' => 'integer',
            'close_delay' => 'integer'
        ]);

        $data = [
            'lock_id' => $lock_id,
            'linkswitch_sn' => $linkswitch_sn,
            'linkswitch_name' => $linkswitch_name,
            'open_action' => $open_action,
            'close_delay' => $close_delay
        ];

        if (!$validate->check($data)) {
            return json(Code::CodeErr(422, "参数验证失败", $validate->getError()));
        }

        try {
            // 更新数据
            $result = Db::name('linkswitch')
                ->where(['lock_id' => $lock_id, 'linkswitch_sn' => $linkswitch_sn])
                ->update([
                    'linkswitch_name' => $linkswitch_name,
                    'open_action' => $open_action,
                    'close_delay' => $close_delay,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            if ($result === false) {
                return json(Code::CodeErr(500, "更新失败"));
            }

            return json(Code::CodeOk(["msg" => "编辑联动空开成功"]));
        } catch (\Exception $e) {
            return json(Code::CodeErr(500, "编辑联动空开失败", $e->getMessage()));
        }
    }
    public function deleteLinkSpeaker()
    {
        // 获取请求中的喇叭设备 ID 参数
        $id = (int)input("id");

        // 验证 ID 是否有效
        if (!$id) {
            return json(Code::CodeErr(400, "无效的喇叭设备 ID"));
        }

        try {
            // 从 linkspeaker 表中删除指定 ID 的记录
            $result = Db::name('linkspeaker')->where('id', $id)->delete();

            if ($result) {
                return json(Code::CodeOk(["msg" => "喇叭设备删除成功"]));
            } else {
                return json(Code::CodeErr(404, "喇叭设备未找到或删除失败"));
            }
        } catch (\Exception $e) {
            return json(Code::CodeErr(500, "删除失败", $e->getMessage()));
        }
    }
    public function deleteLinkSwitch()
    {
        // 获取请求中的空开设备 ID 参数
        $id = (int)input("id");

        // 验证 ID 是否有效
        if (!$id) {
            return json(Code::CodeErr(400, "无效的空开设备 ID"));
        }

        try {
            // 从 linkswitch 表中删除指定 ID 的记录
            $result = Db::name('linkswitch')->where('id', $id)->delete();

            if ($result) {
                return json(Code::CodeOk(["msg" => "空开设备删除成功"]));
            } else {
                return json(Code::CodeErr(404, "空开设备未找到或删除失败"));
            }
        } catch (\Exception $e) {
            return json(Code::CodeErr(500, "删除失败", $e->getMessage()));
        }
    }

    /**
     * 设置语音参数（音量、语速、音调）
     */
    function voiceConfigSet()
    {
        $lockauth_id = input("lockauth_id");
        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        $reslockdata = Lock::Info($lockAuth["lock_id"]);
        $onlinestatus = HardwareCloud::App()->OnLineGet($reslockdata["lock_sn"]);
        if ($reslockdata && mb_substr($reslockdata["lock_sn"], 0, 3) == "W70" && $onlinestatus) {
            $horndata["volume"] = input("volume");
            $horndata["speed"] = input("speed");
            $horndata["tone"] = input("tone");
            HardwareCloud::Horn()::Setting($reslockdata["lock_sn"], $horndata);
            return json(Code::CodeOk([
                "msg" => "更新成功",
            ]));
        } else {
            return json(Code::CodeErr(1000, "设备不在线"));
        }
    }

    /**
     * 设置继电器常开/常闭模式
     */
    function relayNoncModeSet()
    {
        $lockauth_id = input("lockauth_id");
        $nonc_mode = input("nonc_mode"); // 0:常闭，1:常开

        if (!$lockauth_id || $nonc_mode === null) {
            return json(Code::CodeErr(1000, "参数不完整"));
        }

        // 验证模式值
        if ($nonc_mode != 0 && $nonc_mode != 1) {
            return json(Code::CodeErr(1000, "模式值必须为0或1"));
        }

        try {
            $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
            $lockdata = Lock::Info($lockAuth["lock_id"]);

            // 检查设备是否在线
            $onlineStatus = HardwareCloud::App()->OnLineGet($lockdata["lock_sn"]);
            if (!$onlineStatus) {
                return json(Code::CodeErr(1000, "设备不在线"));
            }

            // 调用硬件接口设置模式
            $result = HardwareCloud::Accesscontrol()->SetNonc($lockdata["lock_sn"], $nonc_mode);
            if ($result["err"]) {
                return json(Code::CodeErr(1000, $result["err"]));
            }

            // 保存到数据库
            Db::name("lock")->where(["lock_id" => $lockAuth["lock_id"]])->update(["relay_nonc_mode" => $nonc_mode]);

            // 记录继电器模式设置日志
            $uidInfo = MemberServer::Uid();
            $modeText = $nonc_mode == 0 ? '常闭' : '常开';
            LockLog::add($uidInfo["uid"], $lockAuth['lock_id'], 38, 1, "", "", "", "", "设置继电器模式: {$modeText}");

            return json(Code::CodeOk([
                "msg" => "继电器模式设置成功",
            ]));
        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));
        }
    }

    /**
     * 设置继电器延时
     */
    function relayDelaySet()
    {
        $lockauth_id = input("lockauth_id");
        $relay_delay = input("relay_delay"); // 延时时间（秒）

        if (!$lockauth_id || $relay_delay === null) {
            return json(Code::CodeErr(1000, "参数不完整"));
        }

        // 验证延时范围：1-30秒
        $delay_ms = (int)$relay_delay * 1000; // 转换为毫秒
        if ($delay_ms < 1000 || $delay_ms > 30000) {
            return json(Code::CodeErr(1000, "延时时间必须在1-30秒之间"));
        }

        try {
            $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
            $lockdata = Lock::Info($lockAuth["lock_id"]);

            // 检查设备是否在线
            $onlineStatus = HardwareCloud::App()->OnLineGet($lockdata["lock_sn"]);
            if (!$onlineStatus) {
                return json(Code::CodeErr(1000, "设备不在线"));
            }

            // 调用硬件接口设置继电器延时
            $result = HardwareCloud::Accesscontrol()->SetRelay($lockdata["lock_sn"], $delay_ms);
            if ($result["err"]) {
                return json(Code::CodeErr(1000, $result["err"]));
            }

            // 保存到数据库
            Db::name("lock")->where(["lock_id" => $lockAuth["lock_id"]])->update(["relay_delay" => $delay_ms]);

            // 记录继电器延时设置日志
            $uidInfo = MemberServer::Uid();
            LockLog::add($uidInfo["uid"], $lockAuth['lock_id'], 37, 1, "", "", "", "", "设置继电器延时: {$relay_delay}秒");

            return json(Code::CodeOk([
                "msg" => "继电器延时设置成功",
            ]));
        } catch (\Exception $e) {
            return json(Code::CodeErr(1000, $e->getMessage()));
        }
    }

    /**
     * 获取喇叭播报历史
     */
    public function getHornHistory()
    {
        $lockauth_id = input("lockauth_id");
        $page = input("page", 1);
        $limit = input("limit", 20);

        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);
        if (!$lockAuth || empty($lockAuth["lock_id"])) {
            return json(Code::CodeOk([
                "data" => $this->emptyHornHistoryData($page, $limit)
            ]));
        }
        $lock = Lock::Info($lockAuth["lock_id"]);
        if (!$lock || empty($lock["lock_id"])) {
            return json(Code::CodeOk([
                "data" => $this->emptyHornHistoryData($page, $limit)
            ]));
        }

        try {
            $this->ensureHornBroadcastHistoryTable();

            // 获取历史记录，按时间降序，最多100条
            $list = Db::name("horn_broadcast_history")
                ->where("lock_id", $lock["lock_id"])
                ->order("created_at", "desc")
                ->limit(($page - 1) * $limit, $limit)
                ->select();

            // 获取总数，但最多100条
            $total = Db::name("horn_broadcast_history")
                ->where("lock_id", $lock["lock_id"])
                ->count();
        } catch (\Throwable $e) {
            return json(Code::CodeOk([
                "data" => $this->emptyHornHistoryData($page, $limit)
            ]));
        }

        $total = min($total, 100);

        return json(Code::CodeOk([
            "data" => [
                "list" => $list,
                "total" => $total,
                "page" => (int)$page,
                "limit" => (int)$limit
            ]
        ]));
    }

    private function emptyHornHistoryData($page = 1, $limit = 20)
    {
        return [
            "list" => [],
            "total" => 0,
            "page" => (int)$page,
            "limit" => (int)$limit
        ];
    }

    private function ensureHornBroadcastHistoryTable()
    {
        $prefix = (string) config('database.connections.mysql.prefix', '');
        $table = $prefix . 'horn_broadcast_history';
        Db::execute("CREATE TABLE IF NOT EXISTS `{$table}` (
            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
            `lock_id` INT(11) NOT NULL COMMENT '设备ID',
            `member_id` INT(11) DEFAULT NULL COMMENT '操作用户ID',
            `content` TEXT NOT NULL COMMENT '播报内容',
            `volume` INT(3) DEFAULT 5 COMMENT '音量',
            `speed` INT(3) DEFAULT 5 COMMENT '语速',
            `tone` INT(3) DEFAULT 5 COMMENT '语调',
            `loop_enabled` TINYINT(1) DEFAULT 0 COMMENT '是否循环播报',
            `loop_interval` INT(11) DEFAULT 0 COMMENT '循环间隔',
            `created_at` INT(11) NOT NULL COMMENT '播报时间',
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `idx_lock_id` (`lock_id`) USING BTREE,
            INDEX `idx_created_at` (`created_at`) USING BTREE,
            INDEX `idx_member_id` (`member_id`) USING BTREE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='云喇叭播报历史记录表'");
    }
}
