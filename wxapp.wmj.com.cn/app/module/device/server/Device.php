<?php


namespace app\module\device\server;


class Device
{

    static function DeviceType($lock_sn)
    {
        $type = mb_substr($lock_sn, 0, 3);
        $deviceType = "lock";
        switch ($type) {
            case "W72":
            case "W71";
                $deviceType = "switch";
                break;
            case "W70";
                $deviceType = "horn";
                break;
        }
        return $deviceType;
    }

    /**
     * 根据起点坐标和终点坐标测距离
     * @param  [array]   $from    [起点坐标(经纬度),例如:array(118.012951,36.810024)]
     * @param  [array]   $to    [终点坐标(经纬度)]
     * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
     * @param  [int]     $decimal   精度 保留小数位数
     * @return [string]  距离数值
     */
    function get_distance($from, $to, $km = false, $decimal = 2)
    {
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数

        $distance = $EARTH_RADIUS * 2 * asin(sqrt(pow(sin(($from[0] * pi() / 180 - $to[0] * pi() / 180) / 2), 2) + cos($from[0] * pi() / 180) * cos($to[0] * pi() / 180) * pow(sin(($from[1] * pi() / 180 - $to[1] * pi() / 180) / 2), 2))) * 1000;

        if ($km) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }

    //计算经纬度距离
    static function CalculateDistance($latitude1, $longitude1, $latitude2, $longitude2, $unit = "km")
    {
        $earthRadius = ($unit === "km") ? 6371.0 : 3958.8; // Earth radius in kilometers or miles

        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($latitude1);
        $lon1 = deg2rad($longitude1);
        $lat2 = deg2rad($latitude2);
        $lon2 = deg2rad($longitude2);

        // Haversine formula
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1) * cos($lat2) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
    static function SimInfo($iccid)
    {

        $senddata['simiccid']=$iccid;
        $res = self::postsimurl("https://www.wmj.com.cn/api/querysiminfo", $senddata);
        return  json_decode($res);

    }

    static function SimRenew($iccid)
    {


        $res = self::postsimurl("https://www.wmj.com.cn/api/simRenew?sim=".$iccid, []);
        return  json_decode($res,true);

    }
    static function SimPay($iccid,$product_id,$order_sn)
    {

        $url ="https://www.wmj.com.cn/Payback/simPay?sim=".$iccid."&product_id=".$product_id."&extra_no=".$order_sn;
        print_r($url);
        $res = self::postsimurl($url, []);
        return  json_decode($res,true);

    }
    static function postsimurl($url,$params)
    {
        $headers = array('Content-Type: multipart/form-data'); //请求头记得变化-不同的上传方式
        $data = $params;
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data) ); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);
        return $result;

}
    /**
     * 定义设备能力
     * 根据序列号返回设备具备的能力以设置不同的菜单
     */
    static function DeviceAbility($lock_sn)
    {
        $type = mb_substr($lock_sn, 0, 3);
        $res = [
            "face_status" => 0,
            "finger_status" => 0,
            "card_status" => 0,
            "pwd_status" => 0,
            "realTime_status" => 0,
            "audioConfig_status" => 0,
        ];
        switch ($type) {
            case "W76":
                $res["audioConfig_status"] = 1;
                $res["card_status"] = 1;
                $res["pwd_status"] = 1;
                break;
            case "W77":
                $res["face_status"] = 1;
                $res["card_status"] = 1;
                break;
            case "W71":
                $res["realTime_status"] = 1;
                break;
            case "W72":
                $res["realTime_status"] = 1;
                break;
            case "W89":
                $res["finger_status"] = 1;
                $res["pwd_status"] = 1;
                $res["card_status"] = 1;
                break;
        }
        $type = mb_substr($lock_sn, 0, 5);
        switch ($type) {
            case "WMJ62":
                $res["card_status"] = 1;
                $res["audioConfig_status"] = 1;
                break;
        }
        return $res;
    }
}
