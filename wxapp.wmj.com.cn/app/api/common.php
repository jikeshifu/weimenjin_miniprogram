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
function wmjHandle($wmjsn, $type)
{
	//mlog("wmjHandle:".$wmjsn);
	$resconfig=\app\admin\db\Config::loadList();
	//mlog("api_wmjHandle_config:".json_encode($resconfig));
    $value_s = $resconfig['wmjaeskey'] ? aesEncrypt($wmjsn, $resconfig['wmjaeskey']) : $wmjsn;
    $appid = 'appid='.$resconfig['wmjappid'];
    $appsecret = 'appsecret='.$resconfig['wmjappsecret'];
    $url = 'https://www.wmj.com.cn/api/'.$type.'.html?'.$appid.'&'.$appsecret;
    //mlog("wmjHandle_url:".$url);
    $result = wmjHttpPost($url, $value_s);
    return $result;
}
//发公众号模板消息
function wmjSendWechatMsg($type,$data)
{
    $url = 'https://www.wmj.com.cn/task/'.$type.'.html';
    $result = posturl($url, $data);
    return $result;
}
//卡管理
function wmjManageHandle($wmjsn, $type, $str)
{
	$resconfig=\app\admin\db\Config::loadList();
    $data=$str;
    $data['appid']=$resconfig['wmjappid'];
    $data['appsecret']=$resconfig['wmjappsecret'];
    $url = 'https://www.wmj.com.cn/api/'.$type.'.html';
    $result = wmjCardHttpPost($url, http_build_query($data));
    return $result;
}
//网关锁
function wmjgwHandle($gwcidsn,$cmd)
{
    $resconfig=\app\admin\db\Config::loadList();
    $data['sncid']=$gwcidsn;
    $data['gwsn']=substr($gwcidsn,0,11);
    $data['cid']=substr($gwcidsn,11,12);
    $data['appid']=$resconfig['wmjappid'];
    $data['appsecret']=$resconfig['wmjappsecret'];
    mlog("wmjgwHandle:".json_encode($data));
    $url = 'https://www.wmj.com.cn/api/'.$cmd.'.html';
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
    $urlarr = ['www.btom.cn:8080','bjmtn.b2m.cn','shmtn.b2m.cn','bjksmtn.b2m.cn','gzmtn.b2m.cn:8080'];
    $appid = 'EUCP-EMY-SMS1-23EYV'; // 亿美APPid
    $secretkey = '4FC6015807E792CE'; // 秘钥
    $content = '';/* 短信内容请以商务约定的为准，如果已经在通道端绑定了签名，则无需在这里添加签名 */
    $timestamp = date("YmdHis");
    $sign = md5($appid.$secretkey.$timestamp);
    // $sign = signmd5($appid,$secretkey,$timestamp);
    // 如果您的系统环境不是UTF-8，需要转码到UTF-8。如下：从gb2312转到了UTF-8
    // $content = mb_convert_encoding( $content,"UTF-8","gb2312");
    // 另外，如果包含特殊字符，需要对内容进行urlencode
    $data = [];
    $data['appId'] = $appid;
    $data['timestamp'] = $timestamp;
    $data['sign'] = $sign;
    $data = array_merge($data,$arr);
    $urlk = mt_rand(0,3);
    $url = $urlarr[$urlk].'/simpleinter/sendSMS';
    $sendres = curl_request($url,'get',$data);
    return $sendres;
}
//task
function wmjTaskHandle($unionid,$data,$cmd)
{
    $resconfig=\app\admin\db\Config::loadList();
    $data['unionid']=$unionid;
    $data['data']=$data;
    $data['appid']=$resconfig['wmjappid'];
    $data['appsecret']=$resconfig['wmjappsecret'];
    //mlog("wmjTaskHandle:".json_encode($data));
    $url = 'https://www.wmj.com.cn/task/'.$cmd.'.html';
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
function aesEncrypt($value, $key) {
    $padSize = 16 - (strlen($value) % 16);
    $value   = $value . str_repeat(chr($padSize), $padSize);
    $output  = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $value, MCRYPT_MODE_CBC, str_repeat(chr(0), 16));
    return base64_encode($output);
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