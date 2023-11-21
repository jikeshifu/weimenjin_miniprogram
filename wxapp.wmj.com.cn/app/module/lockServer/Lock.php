<?php


namespace app\module\lockServer;


use app\module\device\server\Device;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockAuthServer\LockAuth;

use app\module\redis\Redis;
use think\facade\Db;
use xhadmin\service\api\LockService;

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
       if($data){
           return  json_decode($data,true);
       }
       $lock= Db::name("lock")->where(["lock_id" => $lock_id])->whereNull("deleted_at")->find();
       //mlog("LockInfo_data:".json_encode($lock));
       if($lock){
           $Redis->set($key,json_encode($lock),5);
       }

        return $lock;
    }

    static function InfoWLockSn($lock_sn)
    {

        return Db::name("lock")->where(["lock_sn" => $lock_sn])->whereNull("deleted_at")->find();
    }

    static function CacheClear($lock_id){
        $lockInfo = self::Info($lock_id);

        $Redis = Redis::Redis();

        $Redis->del("lockInfo:".$lock_id);

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

        return ;
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
     * 添加卡
     */
    static function CardAdd($lockInfo, $cardsn, $endtime)
    {
        if(!$endtime){
            $endtime ="2862831776";
        }
        if (mb_substr($lockInfo["lock_sn"], 0, 3) == "W89" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W76" || mb_substr($lockInfo["lock_sn"], 0, 3) == "W77") {
            $CardAdd = HardwareCloud::WifiLock()->CardAdd($lockInfo["lock_sn"], $cardsn, $lockInfo["device_cid"], time(), $endtime);
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
   static function wmjAddCard($wmjsn, $type, $data=[])
    {
        $resconfig=\app\admin\db\Config::loadList();

        $data['appid']=$resconfig['wmjappid'];
        $data['appsecret']=$resconfig['wmjappsecret'];

        $url = 'https://www.wmj.com.cn/platformapi/'.$type.'.html';
        $result = self::wmjCardHttpPost($url, http_build_query($data));
        return $result;
    }


   static function wmjCardHttpPost($url, $str) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: ' . strlen($str))
        );
        $res = curl_exec ($curl);
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

        if( $result['state_msg'] == "当前卡未注册过"){
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
                $result['state_msg'] = "开门成功";
            }


        } else {

            if ($lockInfo["lock_type"] == 7) {
                $result = wmjgwHandle($lockInfo["lock_sn"], 'ctrlgwl');
            } else {
                $result = wmjHandle($lockInfo["lock_sn"], 'openlock');
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
        "W8",
        "W7",
    ];

    static function Register($data)
    {
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
            $data['lock_sn'] = strtoupper($data['lock_sn']);
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
        $data['successimg'] = '/uploads/admin/202007/5f1c6367d68fd.jpg';
        $lock_id = LockService::add($data);
        $qrcodeurl = "https://" . $_SERVER['HTTP_HOST'] . "/minilock?" . "user_id=" . $data['user_id'] . "&lock_id=" . $lock_id;

        HardwareCloud::App()->QrCodeSet($data["lock_sn"],$qrcodeurl);
        $data['lock_qrcode'] = self::createmarkqrcode($qrcodeurl, $data['lock_name']);

        LockService::update(["lock_id" => $lock_id], $data);
        //添加钥匙
        LockAuth::Add($lock_id, $data['member_id'], $data['user_id'], $device_group_id);
        return ["err" => null, "lock_id" => $lock_id];

    }

    static function createmarkqrcode($url, $qrcodename)
    {
        $path = app()->getRootPath() . 'public/qrdata/qrcode/';
        $file = time() . '.png';
        $qrcode_file = $path . $file;

        if (!(is_file($qrcode_file))) {
            require_once app()->getRootPath() . '/vendor/phpqrcode/phpqrcode.php';
            $object = new \QRcode();
            $object->png($url, $qrcode_file, QR_ECLEVEL_L, 10);
        }
        $font = app()->getRootPath() . 'public/qrdata/simhei.ttf';
        if ($qrcodename) { // 有文字再往图片上加文字
            $size = 14;
            $box = @imagettfbbox($size, 0, $font, $qrcodename);
            $fontw = abs($box[4] - $box[0]); // 生成文字的width
            $fonth = abs($box[5] - $box[1]);
            $im = imagecreatefrompng($qrcode_file);
            $info = getimagesize($qrcode_file);
            $imgw = $info[0]; // width
            $imgh = $info[1] + $fonth + 10; // height
            $img = imagecreate($imgw, $imgh);//创建一个长为500高为16的空白图片
            imagecolorallocate($img, 0xff, 0xff, 0xff);//设置图片背景颜色，这里背景颜色为#ffffff，也就是白色
            $black = imagecolorallocate($img, 0x00, 0x00, 0x00);//设置字体颜色，这里为#000000，也就是黑色
            $fontx = 10; // 文字距离图片左侧的距离
            if ($imgw > $fontw) {
                $fontx = ceil(($imgw - $fontw) / 2); // 进一法取整
            }
            imagettftext($img, $size, 0, $fontx, ($info[1] + $fonth), $black, $font, $qrcodename);//将ttf文字写到图片中
            // 以 50% 的透明度合并水印和图像
            imagecopymerge($img, $im, 0, 0, 0, 0, $info[0], $info[1], 100);
            // header('Content-Type: image/png');//发送头信息 浏览器显示
            imagepng($img, $qrcode_file);//输出图片，输出png使用imagepng方法，输出gif使用imagegif方法
        }
        return 'https://' . $_SERVER['HTTP_HOST'] . '/qrdata/qrcode/' . $file;
    }
}
