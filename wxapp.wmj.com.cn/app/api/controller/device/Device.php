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
use app\module\user\userServer\UserServer;
use app\module\wechat\WechatServer;
use think\facade\Db;
use xhadmin\db\Lock as LockDb;
use xhadmin\service\api\LockService;

class Device extends Base
{

    function add()
    {

        $data["lock_name"] = input("lock_name");
        $data["lock_sn"] = input("lock_sn");
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
                if ($DeviceGroupInfo["type"] == 1) {
                    $device_group_id = 0;
                }


                $lockAddRes = \app\module\lockServer\Lock::Add($data, $device_group_id);
                if ($lockAddRes["err"]) {
                    return json(Code::CodeErr(1000, $lockAddRes["err"], $lockAddRes));

                }


            }
        } catch (\Exception $e) {
            return json(Code::CodeOk(['msg' => $e->getMessage()]));
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

        if ($result['state'] == 1) {

            $senddata['lock_id'] = $data['lock_id'];
            $senddata['lockname'] = $lock['lock_name'];
            $senddata['locksn'] = $lock['lock_sn'];
            $senddata['opentype'] = 2;
            $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($data['lock_id']);

            $res = wmjSendWechatMsg('wxappopsucntNew', $senddata);

            if ($lockAuth["auth_isadmin"] != 1) {
                //增加开门次数
                \app\module\lockAuthServer\LockAuth::OpenusedAdd($lockauth_id);
            }


            return json(Code::CodeOk(["msg" => "开门成功", "data" => [
                "xcx_sound" => $lock["xcx_sound"]
            ]]));
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
            return json(Code::CodeErr(1000, "设备已停用", $lock['status']));
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

            //钥匙校验
            $VerifyRes = \app\module\lockAuthServer\LockAuth::Verify($lockauth["lockauth_id"]);
            if ($VerifyRes["err"]) {
                return json(Code::CodeErr(1000, $VerifyRes['err'], $VerifyRes));
            }

        }
        //创建和普通管理员用户关联的用户信息(umember)
        $UMemberRes = MemberServer::UMember($data['member_id'], $lock["user_id"]);
        //mlog("openinfo:" . $data['member_id'] . "_" . $lock["user_id"] . "_" . $UMemberRes["status"]);
        if (!empty($UMemberRes["status"])&&$UMemberRes["status"] == 0) {
            return json(Code::CodeErr(1000, "异常用户", $UMemberRes));
        }
        if ($UMemberRes["status"] == 2) {
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
            $prex = "【微门禁提示】";
            db()->name('lock')->where('lock_id', $lock_id)->update(['status' => 0]);
            $content = "有黑名单用户进入" . $lock['lock_name'] . ",该门已禁用,设备序列号为" . $lock['lock_sn'];
            $smsdata = array("mobiles" => $mobiles, "content" => $prex . $content);
            $result = sendymSms($smsdata);
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


        if ($result['state'] == 1) {

            $senddata['lock_id'] = $lock_id;
            $senddata['lockname'] = $lock['lock_name'];
            $senddata['locksn'] = $lock['lock_sn'];
            $senddata['opentype'] = 1;
            $senddata['uniondata'] = \app\module\lockAuthServer\LockAuth::AdminList($lock_id);
            wmjSendWechatMsg('wxappopsucntNew', $senddata);

            return json(Code::CodeOk(["msg" => "开门成功", "data" => [
                "successimg" => "https://wxapp.wmj.com.cn/" . $lock["successimg"],
                "xcx_sound" => $lock["xcx_sound"],
            ]]));
        }
        if ($result['state_msg'] == "失败,网络故障" || $result['state_msg'] == "设备不在线") {
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
            LockLog::add($member_id, $lock["lock_id"], 5, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 5, 1);
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
            LockLog::add($member_id, $lock["lock_id"], 5, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 5, 1);
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
            LockLog::add($member_id, $lock["lock_id"], 5, 0);
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        LockLog::add($member_id, $lock["lock_id"], 5, 1);
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

    function info()
    {
        $lock_id = input("lock_id");
        $lockInfo = LockDb::getInfo($lock_id);
        $OpenLock = HardwareCloud::AirSwitch()->Getdevinfo($lockInfo["lock_sn"]);
        if ($OpenLock["err"]) {
            return json(Code::CodeErr(1000, ($OpenLock["err"])));
        }
        if ($OpenLock["data"]["info"]["switch_state"] == 1) {
            $OpenLock["data"]["info"]["switch_state"] = "接通";
        } else {
            $OpenLock["data"]["info"]["switch_state"] = "断开";
        }

        Db::name("lock")->where(["lock_id" => $lock_id])->update([
            "imei" => $OpenLock["data"]["info"]["imei"],
            "iccid" => $OpenLock["data"]["info"]["iccid"],
        ]);


        return json(Code::CodeOk(["msg" => "获取成功", "data" => $OpenLock["data"]["info"], "sql" => Db::name("lock")->getLastSql()]));

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
        $data["user_id"] = $LockInfo["user_id"];

        $qrcodeurl = "https://" . $_SERVER['HTTP_HOST'] . "/minilock?" . "user_id=" . $data['user_id'] . "&lock_id=" . $lockAuth["lock_id"];
        $data['lock_qrcode'] = \app\module\lockServer\Lock::createmarkqrcode($qrcodeurl, $data['lock_name']);
        \app\module\lockServer\Lock::Edit($lockAuth["lock_id"], $data);
        return json(Code::CodeOk([
            "msg" => "更新成功",
            "sql" => Db::name("lock")->getLastSql()

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
        ];
        $info["addcardmode_status"] = 0;
        $info["qrServer_status"] = 0;
        $info["qrServer_type"] = 0;
        if (mb_substr($lock["lock_sn"], 0, 5) == "WMJ62" || mb_substr($lock["lock_sn"], 0, 3) == "W76") {
            $info["addcardmode_status"] = 1;
            $info["qrServer_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 3) == "W77") {
            $info["addcardmode_status"] = 0;
            $info["qrServer_status"] = 1;
        }
        if (mb_substr($lock["lock_sn"], 0, 3) == "W76") {
            $info["qrServer_type"] = 1;

        }
        mlog("infoV2:" . json_encode($info));
        return json(Code::CodeOk([
            "msg" => "获取成功",
            "data" => $info,

        ]));

    }

    function list()
    {


        $res = MemberServer::Uid();
        $member_id = $res["uid"];
        $page = input("page");
        $limit = input("limit");

        $device_group_id = input("device_group_id");
        $DeviceGroupInfo = \app\module\device\server\DeviceGroup::Info($device_group_id);
        //更新分组时间
        Db::name("device_group")->where(["device_group_id" => $device_group_id])->update(["updated_at" => time()]);


        $search_key = input("search_key");


        $model = LockAuth::where(["member_id" => $member_id])->whereNull("deleted_at")->where(["auth_status" => 1]);

        if ($DeviceGroupInfo["type"] == 1) {
            $model->where(function ($q) use ($DeviceGroupInfo) {
                $q->whereOr(["device_group_id" => 0]);
                $q->whereOr(["device_group_id" => $DeviceGroupInfo["device_group_id"]]);
            });

        } else {
            $model->where(["device_group_id" => $DeviceGroupInfo["device_group_id"]]);
        }


        if ($search_key) {

            $model->where(function ($query) use ($search_key) {
                $query->whereOr("user_name", "like", "%{$search_key}%");
                $query->whereOr("mobile", "like", "%{$search_key}%");
            });
        }
        $count = $model->count();
        $lockauth = $model->with("lock")->order("lockauth_id desc")->page($page, $limit)->select()->toArray();

        foreach ($lockauth as &$vo) {

            $vo["lock"] = \app\module\lockServer\Lock::Online($vo["lock"]);

            if (mb_substr($vo["lock"]["lock_sn"], 0, 3) == "W71" || mb_substr($vo["lock"]["lock_sn"], 0, 3) == "W72") {
                $Getdevinfo = HardwareCloud::AirSwitch()->Getdevinfo($vo["lock"]["lock_sn"]);
                if (!$Getdevinfo["err"]) {
                    $vo["lock"]["switch_state"] = $Getdevinfo["data"]["info"]["switch_state"];

                } else {
                    $vo["lock"]["switch_state"] = 0;
                }

            }

            $vo["auth_endtime1"] = " ";
            $vo["cs"] = " ";
            $delimiter = " ";
            $unt = " ";
            if ($vo["auth_isadmin"] != 1) {
                if ($vo["auth_openlimit"]) {
                    $vo["cs"] = $vo["auth_openlimit"] - $vo["auth_openused"];
                    $delimiter = ",";
                    $unt = "次";
                }
                if ($vo["auth_endtime"]) {
                    $vo["auth_endtime1"] = date("Y-m-d", $vo["auth_endtime"]);
                } else {
                    $delimiter = " ";
                }
            }
            $vo["auth_endtime1"] = $vo["auth_endtime1"] . $delimiter . $vo["cs"] . $unt;
            $vo["device_type"] = \app\module\device\server\Device::DeviceType($vo["lock"]["lock_sn"]);
            $vo["lock_ability"] = \app\module\device\server\Device::DeviceAbility($vo["lock"]["lock_sn"]);


        }


        return json(Code::CodeOk(["msg" => "获取成功", "data" => $lockauth, "count" => $count]));

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


        $model = LockAuth::where(["member_id" => $member_id])->whereNull("deleted_at")->where([
            "auth_status" => 1,
            "auth_isadmin" => 1,
        ]);


        $lockauth = $model->with("lock")->order("lockauth_id desc")->select()->toArray();
        $arr = [];
        foreach ($lockauth as $vo) {

            $lock_ability = \app\module\device\server\Device::DeviceAbility($vo["lock"]["lock_sn"]);
            if ($lock_ability["face_status"]) {
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
        $count = $model->count();

        $search_key = input("search_key");
        if ($search_key) {
            $model->leftJoin("member m", "m.member_id = log.member_id");
            $model->where("m.mobile","like","%{$search_key}%");
        }

        $LockLog = $model->with(["lock", "memberInfo"])->order("locklog_id desc")->page($page, $limit)->select();

        foreach ($LockLog as &$vo) {

            if ($vo["headimgurl"]) {
                $vo["headimgurl"] = "https://wxapp.wmj.com.cn/" . $vo["headimgurl"];
            } else {
                $vo["headimgurl"] = null;
            }


            if (!$vo["user_name"]) {

                $memberInfo = MemberServer::Info($vo["member_id"]);
                if ($memberInfo["nickname"] != "微信用户") {
                    $vo["user_name"] = $memberInfo["nickname"];

                } else {
                    $vo["user_name"] = $memberInfo["realname"];
                }
                Db::name("locklog")->where(["locklog_id" => $vo["locklog_id"]])->update([
                    "user_name" => $vo["user_name"]
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
        if (!$lockauth) {
            return json(Code::CodeErr(1000, "没有权限"));
        }
        if ($lockauth["auth_member_id"] != 0) {
            return json(Code::CodeErr(1000, "没有权限"));
        }
        Db::name("lockauth")->where(['lockauth_id' => $lockauth_id, "member_id" => $res["uid"]])->update([
            "member_id" => $member_id,
            "device_group_id"=>0
        ]);

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


        $lockAuth = \app\module\lockAuthServer\LockAuth::Info($lockauth_id);

        $lock = Lock::Info($lockAuth["lock_id"]);

        $UidRes = MemberServer::Uid();
        $res = HardwareCloud::Horn()->Play($lock["lock_sn"], $tts, $volume);
        if ($res["err"]) {


            LockLog::add($UidRes["uid"], $lock["lock_id"], 9, 0);
            return json(Code::CodeErr(1000, $res["err"]));
        } else {
            LockLog::add($UidRes["uid"], $lock["lock_id"], 9, 1);
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
            'notify_url' => 'https://wxapp.wmj.com.cn/api/pay.Notify/index', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
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
}
