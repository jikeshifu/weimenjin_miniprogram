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