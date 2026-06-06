<?php


namespace app\module\lockServer;

use app\module\device\server\Device;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockAuthServer\LockAuth;

use app\module\redis\Redis;
use think\facade\Db;
use xhadmin\service\api\LockService;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
class Lock
{
    static function Del($lock_id)
    {
        $lock_data = self::Info($lock_id);

        self::CacheClear($lock_id);
        \app\module\lockServer\Lock::Logout($lock_data['lock_sn']);
        return Db::name("lock")->where(["lock_id" => $lock_id])->whereNull("deleted_at")->update(["deleted_at" => date("Y-m-d H:i:s")]);
    }

    static function Info($lock_id)
    {
        $key = "lockInfo:" . $lock_id;
        $Redis = Redis::Redis();

        $data = $Redis->get($key);
        if ($data) {
            return json_decode($data, true);
        }
        $lock = Db::name("lock")->where(["lock_id" => $lock_id])->whereNull("deleted_at")->find();
        //mlog("LockInfo_data:".json_encode($lock));
        if ($lock) {
            $Redis->set($key, json_encode($lock), 5);
        }

        return $lock;
    }

    static function InfoWLockSn($lock_sn)
    {

        return Db::name("lock")->where(["lock_sn" => $lock_sn])->whereNull("deleted_at")->find();
    }
    static function LockPower($lock_sn, $page = 1, $limit = 100)
    {
        // 计算偏移量 (分页从0开始计算)
        $offset = ($page - 1) * $limit;

        return Db::name("power")
            ->where(["device_sn" => $lock_sn])
            ->order('created_at', 'desc') // 根据创建时间降序排列
            ->limit($offset, $limit) // 使用偏移量和限制数量进行分页
            ->select();
    }
    static function OnOffline($lock_sn)
    {

        return Db::name("on_line_record")
        ->where(["device_sn" => $lock_sn])
        ->order('on_line_time', 'desc') // 根据创建时间降序排列
        ->limit(100) // 限制结果为最近的100条记录
        ->select();

    }
    static function CacheClear($lock_id)
    {
        $lockInfo = self::Info($lock_id);

        $Redis = Redis::Redis();

        $Redis->del("lockInfo:" . $lock_id);

        $key = "Online:" . $lockInfo["lock_sn"];
        $list = $Redis->keys($key . "*");
        foreach ($list as $vo) {

            $Redis->del($vo);
        }


    }


    static function Edit($lock_id, $data = [])
    {


        self::CacheClear($lock_id);
        Db::name("lock")->where(["lock_id" => $lock_id])->update($data);

        return;
    }

    static function Logout($lock_sn)
    {
        wmjHandle($lock_sn, 'dellock');
        HardwareCloud::App()->Logout($lock_sn);
    }

    /**
     * @param $lockInfo
     * @return mixed
     * 在线
     */
    static function Online($lockInfo, $bw = "")
    {


        if (in_array(mb_substr($lockInfo["lock_sn"], 0, 2), self::$Yjy)) {
            $lockInfo['online'] = HardwareCloud::App()->OnLineGet($lockInfo["lock_sn"]);
        } else {
            if ($lockInfo['lock_type'] == 7) {
                $result = wmjgwHandle($lockInfo['lock_sn'], 'getlplockstate');
                $lockInfo['online'] = $result['online'];
            } else {
                $result = wmjHandle($lockInfo['lock_sn'], 'lockstate');
                //mlog("online" . json_encode($result));
                $lockInfo['online'] = $result['online'];
                $lockInfo['rssi'] = $result['rssi'];
                $lockInfo['imei'] = $result['imei'];
                $lockInfo['iccid'] = $result['iccid'];
                $lockInfo['version'] = $result['version'];
                $lockInfo['type'] = $result['type'];
                $lockInfo['lockstatus'] = $result['lockstatus'];
            }
        }


        return $lockInfo;

    }

    /**
     * @param $lockInfo
     * @return mixed
     * 在线
     */
    static function DeviceInfo($lockInfo, $bw = "")
    {
        if (in_array(mb_substr($lockInfo["lock_sn"], 0, 2), self::$Yjy)) {
            $devInfo = HardwareCloud::App()->getDeviceInfo($lockInfo["lock_sn"]);
            $lockInfo['online'] = $devInfo['on_line'];
            $lockInfo['rssi'] = $devInfo['rssi'];
            $lockInfo['imei'] = $devInfo['imei'];
            $lockInfo['iccid'] = $devInfo['iccid'];
            $lockInfo['version'] = $devInfo['sw_ver'];
            $lockInfo['on_line_time'] = $devInfo['on_line_time'];
            $lockInfo['off_line_time'] = $devInfo['off_line_time'];
            $lockInfo['reason'] = $devInfo['reason'];
        } else {
            if ($lockInfo['lock_type'] == 7) {
                $result = wmjgwHandle($lockInfo['lock_sn'], 'getlplockstate');
                $lockInfo['online'] = $result['online'];
            } else {
                $result = wmjHandle($lockInfo['lock_sn'], 'lockstate');
                //mlog("online" . json_encode($result));
                $lockInfo['online'] = $result['online'];
                $lockInfo['rssi'] = $result['rssi'];
                $lockInfo['imei'] = $result['imei'];
                $lockInfo['iccid'] = $result['iccid'];
                $lockInfo['version'] = $result['version'];
                $lockInfo['type'] = $result['type'];
                $lockInfo['lockstatus'] = $result['lockstatus'];
            }
        }
        return $lockInfo;
    }
    /**
     * @param $lockInfo
     * @return mixed
     * 添加卡
     */
    static function CardAdd($lockInfo, $cardsn, $endtime)
    {
        if (!$endtime) {
            $endtime = "2862831776";
        }
        if (mb_substr($lockInfo["lock_sn"], 0, 3) == "W89" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W76" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W77") {
            $CardAdd = HardwareCloud::WifiLock()->CardAdd($lockInfo["lock_sn"], $cardsn, $lockInfo["device_cid"], 0, $endtime);
            $result["data"] = $CardAdd;
            if ($CardAdd["err"]) {
                $result['state'] = 0;
                $result['state_code'] = 2003;
                $result['state_msg'] = $CardAdd["err"];
            } else {
                $result['state'] = 1;
                $result['state_code'] = 200;
                $result['state_msg'] = "添加卡成功";
            }

        } else {
            $result = self::wmjAddCard($lockInfo['lock_sn'], 'addcard', [
                "sn" => $lockInfo['lock_sn'],
                "cardsn" => $cardsn,
                "endtime" => $endtime,

            ]);
        }
        return $result;

    }

/**
     * @param $lockInfo
     * @return mixed
     * 编辑卡
     */
    static function CardEdit($lockInfo, $cardsn, $endtime)
    {
        if (!$endtime) {
            $endtime = "2862831776";
        }
        if (mb_substr($lockInfo["lock_sn"], 0, 3) == "W89" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W76" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W77") {
            $CardAdd = HardwareCloud::WifiLock()->CardEdit($lockInfo["lock_sn"], $cardsn, $lockInfo["device_cid"], 0, $endtime);
            $result["data"] = $CardAdd;
            if ($CardAdd["err"]) {
                $result['state'] = 0;
                $result['state_code'] = 2003;
                $result['state_msg'] = $CardAdd["err"];
            } else {
                $result['state'] = 1;
                $result['state_code'] = 200;
                $result['state_msg'] = "添加卡成功";
            }


        } else {


            $result = self::wmjAddCard($lockInfo['lock_sn'], 'addcard', [
                "sn" => $lockInfo['lock_sn'],
                "cardsn" => $cardsn,
                "endtime" => $endtime,

            ]);
        }
        return $result;

    }

//卡管理
    static function wmjAddCard($wmjsn, $type, $data = [])
    {
        $data['appid'] = config("my.wmjv1.wmjv1_appid");
        $data['appsecret'] = config("my.wmjv1.wmjv1_appsecret");
        $url = 'https://www.wmj.com.cn/api/' . $type . '.html';
        $result = self::wmjCardHttpPost($url, http_build_query($data));
        return $result;
    }


    static function wmjCardHttpPost($url, $str)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . strlen($str))
        );
        $res = curl_exec($curl);
        curl_close($curl);
        $res = trim($res, "\xEF\xBB\xBF");
        $res = json_decode($res, true);
        return $res;
    }

    /**
     * @param $lockInfo
     * @return mixed
     * 删除卡
     */
    static function CardDel($lockInfo, $cardsn)
    {
        if (mb_substr($lockInfo["lock_sn"], 0, 3) == "W89" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W76" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W77") {
            $CardAdd = HardwareCloud::WifiLock()->CardDel($lockInfo["lock_sn"], $cardsn, $lockInfo["device_cid"]);
            $result['data'] = $CardAdd;
            if ($CardAdd["err"]) {
                $result['state'] = 0;
                $result['state_code'] = 2003;
                $result['state_msg'] = $CardAdd["err"];
            } else {
                $result['state'] = 1;
                $result['state_code'] = 200;
                $result['state_msg'] = "删除卡成功";
            }


        } else {


            $result = wmjManageHandle($lockInfo['lock_sn'], 'delcard', [
                "sn" => $lockInfo['lock_sn'],
                "cardsn" => $cardsn,


            ]);
        }

        if ($result['state_msg'] == "当前卡未注册过") {
            $result['state'] = 1;
            $result['state_code'] = 200;
            $result['state_msg'] = "删除卡成功";
        }

        return $result;

    }

    /**
     * @param $lockInfo
     * @return mixed
     * 开门
     */
    static function OpenLock($lockInfo, $latitude = null, $longitude = null)
    {

        //计算距离
//        if (!$lockInfo["openbtn"]) {
//            $result['state'] = 0;
//            $result['state_code'] = 2003;
//            $result['state_msg'] = "无远程开门权限";
//            return $result;
//        }
        if (self::checkCamString($lockInfo["lock_sn"] ?? '')) {
            $result['state'] = 0;
            $result['state_code'] = 2003;
            $result['state_msg'] = "摄像头设备不支持开门操作";
            return $result;
        }
        if ($lockInfo["location_check"] != 0 && $lockInfo["location"]) {
            $location = json_decode(html_entity_decode($lockInfo["location"]), true);
            if ($latitude != null) {
                $CalculateDistanceRes = Device::CalculateDistance($latitude, $longitude, $location["latitude"], $location["longitude"]);
                $juli = floor($CalculateDistanceRes * 1000);
                if ($juli > $lockInfo["location_check"] + 1) {
                    $result['state'] = 0;
                    $result['state_code'] = 2003;

                    $result['state_msg'] = "超出开门距离" . ($juli - $lockInfo["location_check"]) . "米";
                    return $result;
                }

            }

        }


        if (mb_substr($lockInfo["lock_sn"], 0, 3) == "W89" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W82" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W76" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W77") {
            $OpenLock = HardwareCloud::WifiLock()->OpenLock($lockInfo["lock_sn"], $lockInfo["device_cid"]);

            if ($OpenLock["err"]) {
                $result['state'] = 0;
                $result['state_code'] = 2003;
                $result['state_msg'] = $OpenLock["err"];
                $result['err'] = $OpenLock;
            } else {
                $result['state'] = 1;
                $result['state_code'] = 200;
                $result['state_msg'] = isset($OpenLock["data"]["info"]["msg"])?$OpenLock["data"]["info"]["msg"]:"门已打开";
            }


        } else {

            if ($lockInfo["lock_type"] == 7) {
                $result = wmjgwHandle($lockInfo["lock_sn"], 'ctrlgwl');
            } else {
                $result = wmjHandle($lockInfo["lock_sn"], 'openlock');
                //mlog("OpenLock:".$result);
            }
        }


        return $result;

    }

    /**
     * @param $lockInfo
     * @return mixed
     * 开门
     */
    static function OpenLockTest($lock_sn)
    {

        //计算距离


        if (self::checkCamString($lock_sn)) {
            $result['state'] = 0;
            $result['state_code'] = 2003;
            $result['state_msg'] = "摄像头设备不支持开门操作";
            return $result;
        }

        if (mb_substr($lock_sn, 0, 3) == "W89" || mb_substr($lock_sn, 0, 3) == "W82" || mb_substr($lock_sn, 0, 3) == "W76" || mb_substr($lock_sn, 0, 3) == "W77") {
            $OpenLock = HardwareCloud::WifiLock()->OpenLock($lock_sn, "88888888888888888888");

            if ($OpenLock["err"]) {
                $result['state'] = 0;
                $result['state_code'] = 2003;
                $result['state_msg'] = $OpenLock["err"];
                $result['err'] = $OpenLock;
            } else {
                $result['state'] = 1;
                $result['state_code'] = 200;
                $result['state_msg'] = "开门成功";
            }


        } else {

            wmjgwHandle($lock_sn, 'ctrlgwl');
            $result = wmjHandle($lock_sn, 'openlock');

        }


        return $result;

    }

    static $Yjy = [
        "W8",
        "W7",
        "W3",
    ];

    static function Register($data)
    {
        $data['lock_sn'] = strtoupper($data['lock_sn']);
        if (self::checkCamString($data["lock_sn"])) {
            $Register = HardwareCloud::KGCamera()::Register($data["lock_sn"]);
            if ($Register["err"]) {
                return ["err" => $Register["err"]];
            }
            return null;
        }

        if (in_array(mb_substr($data["lock_sn"], 0, 2), self::$Yjy)) {
            $Register = HardwareCloud::App()->Register($data["lock_sn"]);


            if ($Register["err"]) {
                return ["err" => $Register["err"]];

            }
            if (mb_substr($data["lock_sn"], 0, 3) == "W89") {
                $ActivateRes = HardwareCloud::WifiLock()->Activate($data["lock_sn"]);
                if ($ActivateRes["err"]) {
                    return ["err" => $ActivateRes["err"]];

                }
            }
            $data["device_cid"] = $ActivateRes["device_cid"];
            $data["admin_pwd"] = $ActivateRes["admin_pwd"];
            $data["online"] = 1;
        } else {
            $wmjapiresult = wmjHandle($data['lock_sn'], 'postlock');

            if ($wmjapiresult['state'] == 0) {
                return ["err" => $wmjapiresult['state_msg']];
            }
        }
    }

    static function Add($data, $device_group_id = 0)
    {

        $RegisterRes = self::Register($data);
        if ($RegisterRes) {
            return $RegisterRes;
        }
        $data['mobile_check'] = 1;
        $data['device_group_id'] = $device_group_id;
        $data['applyauth'] = 0;
        $data['applyauth_check'] = 0;
        $data['status'] = 1;
        $data['location_check'] = 0;
        $data['openbtn'] = 1;
        $data['hitshowminiad'] = 1;
        $data['qrshowminiad'] = 1;
        $data['create_time'] = time();
        $data['successimg'] = '/static/img/shareimg.jpg';
        Db::startTrans();
        try {
            $lock_id = LockService::add($data);
            $qrcodeurl = "https://" . $_SERVER['HTTP_HOST'] . "/minilock?" . "user_id=" . $data['user_id'] . "&lock_id=" . $lock_id;

            if(!self::checkCamString($data["lock_sn"])){
                $skip_apis = false;
                $device_prefix = mb_substr($data["lock_sn"], 0, 4);
                if (in_array($device_prefix, ["W761", "W762", "W763", "W764", "W767", "W76C", "W76F"])) {
                    $skip_apis = true;
                }

                if (!$skip_apis) {
                    $isOnline = HardwareCloud::App()->OnLineGet($data["lock_sn"]);
                    if ($isOnline) {
                        HardwareCloud::App()->QrCodeSet($data["lock_sn"], $qrcodeurl);
                    }
                }
                $data['lock_qrcode'] = self::createmarkqrcode($qrcodeurl, $data['lock_name']);
                LockService::update(["lock_id" => $lock_id], $data);
            }else{
                Db::name("cam_remote_control")->insert([
                    'device_sn' => $data["lock_sn"],
                    'title' => "遥控器",
                    'member_id' => $data['member_id']
                ]);
            }
            //添加钥匙
            LockAuth::Add($lock_id, $data['member_id'], $data['user_id'], $device_group_id);
            Db::commit();
        } catch (\Throwable $e) {
            Db::rollback();
            throw $e;
        }
        //重启设备
        usleep(1000);
        $skip_appreg = false;
        $device_prefix = mb_substr($data["lock_sn"], 0, 4);
        if (self::checkCamString($data["lock_sn"]) || in_array($device_prefix, ["W761", "W762", "W763", "W764", "W767", "W76C", "W76F"])) {
            $skip_appreg = true;
        }
        if (!$skip_appreg) {
            $isOnline = HardwareCloud::App()->OnLineGet($data["lock_sn"]);
            if ($isOnline) {
                HardwareCloud::App()->Appreg($data["lock_sn"]);
            }
        }
        return ["err" => null, "lock_id" => $lock_id];

    }

    static function checkCamString($str) {
        if (!is_string($str) || strlen($str) < 10) {
            return false;
        }

        $target = substr($str, -10, 2);

        return $target === '33' || $target === '34';
    }

    /**
     * 生成带文字的二维码
     *
     * @param string $url 二维码包含的URL
     * @param string $qrcodename 二维码下方显示的文字
     * @return string|false 返回二维码图片的完整URL，失败返回false
     */
    public static function createmarkqrcode($url, $qrcodename)
    {
        // 验证URL是否为空
        if (empty($url)) {
            mlog("二维码生成失败: URL为空");
            return false;
        }

        // 定义二维码存储路径
        $path = app()->getRootPath() . 'public/qrdata/qrcode/';

        // 确保目录存在
        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true)) {
                mlog("二维码目录创建失败: " . $path);
                return false;
            }
        }

        // 生成唯一文件名
        $file = time() . '.png';
        $qrcode_file = $path . $file;

        // 直接生成二维码并保存到文件
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG, // 输出类型为 PNG 图片
            'eccLevel'   => QRCode::ECC_L,            // 容错级别为低
            'scale'      => 10,                       // 缩放比例
        ]);

        try {
            // 生成二维码并保存到文件
            $qrcode = new QRCode($options);
            $qrcode->render($url, $qrcode_file);  // 直接将二维码生成到文件
        } catch (\Exception $e) {
            mlog("二维码生成失败: " . $e->getMessage());
            return false;
        }

        // 如果有文字需要添加到二维码上
        if ($qrcodename) {
            $font = app()->getRootPath() . 'public/qrdata/simhei.ttf';

            // 验证字体文件是否存在
            if (!file_exists($font)) {
                mlog("二维码生成失败: 字体文件不存在 - " . $font);
                return false;
            }

            $size = 14;
            // 计算文字的宽度和高度
            $box = @imagettfbbox($size, 0, $font, $qrcodename);
            $fontw = abs($box[4] - $box[0]); // 文字宽度
            $fonth = abs($box[5] - $box[1]); // 文字高度

            // 创建二维码图像资源
            $im = imagecreatefrompng($qrcode_file);
            $info = getimagesize($qrcode_file);
            $imgw = $info[0]; // 图片宽度
            $imgh = $info[1] + $fonth + 10; // 图片高度加上文字高度和间距

            // 创建新的空白图像
            $img = imagecreatetruecolor($imgw, $imgh);
            // 设置背景为白色
            $white = imagecolorallocate($img, 255, 255, 255);
            imagefill($img, 0, 0, $white);
            // 设置文字颜色为黑色
            $black = imagecolorallocate($img, 0, 0, 0);

            // 计算文字的X坐标，使其居中
            $fontx = ($imgw > $fontw) ? ceil(($imgw - $fontw) / 2) : 10;

            // 在新图像上添加文字
            imagettftext($img, $size, 0, $fontx, ($info[1] + $fonth), $black, $font, $qrcodename);

            // 合并二维码图像到新图像
            imagecopymerge($img, $im, 0, 0, 0, 0, $imgw, $info[1], 100);

            // 保存最终的二维码图像
            imagepng($img, $qrcode_file);

            // 释放内存
            imagedestroy($im);
            imagedestroy($img);
        }

        // 返回二维码图片的完整URL
        return 'https://' . $_SERVER['HTTP_HOST'] . '/qrdata/qrcode/' . $file;
    }


    /**
     * @param $lock_id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 开门时间
     *
     */
    public static function OpenLockTimes($lock_id)
    {

        $res["err"] = null;
        $lockauthtimes = db()->name('locktimes')->where(["lock_id" => $lock_id])->select();
        $lockatcount = count($lockauthtimes);
        if ($lockatcount > 0) {
            $isauthopen = 0;
            foreach ($lockauthtimes as $value) {
                if (date('N') >= $value['startweek'] && date("N") <= $value['endweek']) {
                    $nowtime = intval(date("Hi"));

                    $startth = str_pad($value['starthour'], 2, '0', STR_PAD_LEFT) . str_pad($value['startminute'], 2, '0', STR_PAD_LEFT);
                    $endth = str_pad($value['endhour'], 2, '0', STR_PAD_LEFT) . str_pad($value['endminute'], 2, '0', STR_PAD_LEFT);

                    if ($nowtime >= $startth && $nowtime <= $endth) {
                        $isauthopen = 1;
                        break;
                    } else {
                        $isauthopen = 0;
                    }
                } else {
                    $isauthopen = 0;
                }
            }
            if (!$isauthopen) {

                $res["err"] = "不在可开门时段";
                return $res;
            }
        }
        return $res;
    }
}
