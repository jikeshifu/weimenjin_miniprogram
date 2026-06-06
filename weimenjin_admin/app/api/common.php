<?php
// +----------------------------------------------------------------------
// | 应用公共文件
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:
// +----------------------------------------------------------------------

error_reporting(0);
/*start*/
if (!function_exists('wmjV1BaseUrl')) {
    function wmjV1BaseUrl()
    {
        $url = (string) config("my.wmjv1.wmjv1_url", "https://www.wmj.com.cn");
        return rtrim($url ?: "https://www.wmj.com.cn", "/");
    }
}

function wmjHandle($wmjsn, $type)
{
    $value_s = $wmjsn;
    $appid = 'appid='.config("my.wmjv1.wmjv1_appid");
    $appsecret = 'appsecret='.config("my.wmjv1.wmjv1_appsecret");
    $url = wmjV1BaseUrl().'/platformapi/'.$type.'.html?'.$appid.'&'.$appsecret;
    if (mb_substr($wmjsn, 0, 3) == "W66")
    {
        $url = wmjV1BaseUrl().'/faceapi/'.$type.'.html?'.$appid.'&'.$appsecret;
    }
    $result = wmjHttpPost($url, $value_s);
    return $result;
}
//发公众号模板消息
function wmjSendWechatMsg($type,$data)
{
    $url = wmjV1BaseUrl().'/task/'.$type.'.html';
    $result = posturl($url, $data);
    return $result;
}
//卡管理
function wmjManageHandle($wmjsn, $type, $str)
{
    $data=$str;
    $data['appid']=config("my.wmjv1.wmjv1_appid");
    $data['appsecret']=config("my.wmjv1.wmjv1_appsecret");
    $url = wmjV1BaseUrl().'/platformapi/'.$type.'.html';
    $result = wmjCardHttpPost($url, http_build_query($data));
    return $result;
}
//网关锁
function wmjgwHandle($gwcidsn,$cmd)
{
    $data['sncid']=$gwcidsn;
    $data['gwsn']=substr($gwcidsn,0,11);
    $data['cid']=substr($gwcidsn,11,12);
    $data['appid']=config("my.wmjv1.wmjv1_appid");
    $data['appsecret']=config("my.wmjv1.wmjv1_appsecret");
    $url = wmjV1BaseUrl().'/platformapi/'.$cmd.'.html';
    $result = wmjCardHttpPost($url, http_build_query($data));
    return $result;
}
function sendymSms($arr)
{
    if (!is_array($arr) || !$arr) {
        return false;
    }
    if (!isset($arr['content']) || !$arr['content']) {
        return false;
    }
    if (!isset($arr['mobiles'])) {
        return false;
    }

    // 获取配置信息
    $appid = config("my.wmjsms.wmjsms_appid"); // APPid
    $secretkey = config("my.wmjsms.wmjsms_appsecret"); // 秘钥

    // 准备POST请求的数据
    $postData = [
        "appid" => $appid,
        "appsecret" => $secretkey,
        "sms_header" => config("my.wmjsms.wmjsms_lable"), // 固定短信头部
        "phone_number" => $arr['mobiles'], // 接收短信的手机号
        "sms_content" => $arr['content'] // 短信内容
    ];
    //mlog("sendymSms:".json_encode($postData));
    // 发送POST请求到目标URL
    $url = 'https://your-domain.example/webapi/SmsApi/sendSms';
    $sendres = curl_request($url, 'post', json_encode($postData), ['Content-Type: application/json']);
    //mlog("sendymSmssendres:".json_encode($sendres));
    return $sendres;
}
//task
function wmjTaskHandle($unionid,$data,$cmd)
{
    $data['unionid']=$unionid;
    $data['data']=$data;
    $data['appid']=config("my.wmjv1.wmjv1_appid");
    $data['appsecret']=config("my.wmjv1.wmjv1_appsecret");
    $url = wmjV1BaseUrl().'/task/'.$cmd.'.html';
    $result = wmjCardHttpPost($url, http_build_query($data));
    return $result;
}
function wmjCardHttpPost($url, $str) {
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
function posturl($url,$params){

    $headers = array('Content-Type: multipart/form-data'); //请求头记得变化-不同的上传方式
    $data = $params;
//    $headers = array('Content-Type: application/x-www-form-urlencoded');
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
//    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data) ); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
//    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话

    return $result;

}
function wmjHttpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}
function wmjHttpPost($url, $str) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($str))
    );
    $res = curl_exec ($curl);
    curl_close($curl);
    $res = trim($res, "\xEF\xBB\xBF");
    $res = json_decode($res, true);
    return $res;
}

//HTTP请求（支持HTTP/HTTPS，支持GET/POST）
function curl_request($url,$type='post', $data = [],$headers=[],$timeout=20)
{
    $curl = curl_init();
    if (strtolower($type)=='get') {
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (!empty($data)) {
            $url = $url . '?' . http_build_query($data);
        }
    }else{
        if (is_array($data)) {
            $o = "";
            foreach ( $data as $k => $v )
            {
                if (is_array($v)) {
                    $o.= "$k=" . urlencode( json_encode($v) ). "&" ;
                }else{
                    $o.= "$k=" . urlencode( $v ). "&" ;
                }
            }
            $postdata = substr($o,0,-1);
        }else{
            $postdata = $data;
        }
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);//请求超时，默认3秒
    if ($headers) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $output = curl_exec($curl);
    // if (!$output) {
    //     $output = curl_exec($curl);
    // }
    //var_dump($output);
    $output = json_decode($output,true);
    curl_close($curl);
    return $output;
}
function request_post($url = '', $post_data = [],$headers=[]) {
    if (empty($url)) {
        return false;
    }
    if (!$post_data && !$headers) {
        return false;
    }
    $o = "";
    foreach ( $post_data as $k => $v )
    {
        $o.= "$k=" . urlencode( $v ). "&" ;
    }
    $post_data = substr($o,0,-1);
    $postUrl = $url;
    $curlPost = $post_data;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$postUrl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);//
    if ($headers) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if ($post_data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    }
    $data = curl_exec($ch);
    $data = json_decode($data,true);
    curl_close($ch);
    return $data;
}
/*end*/
