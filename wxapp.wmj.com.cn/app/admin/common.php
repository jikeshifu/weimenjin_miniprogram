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


use think\helper\Str;

error_reporting(0);


//多级控制器 获取控制其名称
function getControllerName($controller_name){
	if($controller_name && strpos($controller_name,'/') > 0){
		$controller_name = explode('/',$controller_name)[1];
	}
	return $controller_name;
}

//多级控制器 获取use名称
function getUseName($controller_name){
	if($controller_name && strpos($controller_name,'/') > 0){
		$controller_name = str_replace('/','\\',$controller_name);
	}
	return $controller_name;
}

//多级控制器 获取db命名空间
function getDbName($controller_name){
	if($controller_name && strpos($controller_name,'/') > 0){
		$controller_name = '\\'.explode('/',$controller_name)[0];
	}else{
		$controller_name = '';
	}
	return $controller_name;
}


//多级控制器获取视图名称
function getViewName($controller_name){
	if($controller_name && strpos($controller_name,'/') > 0){
		$arr = explode('/',$controller_name);
		$controller_name = ucfirst($arr[0]).'/'.Str::snake($arr[1]);
	}else{
		$controller_name = Str::snake($controller_name);
	}
	return $controller_name;
}

//多级控制器获取url名称
function getUrlName($controller_name){
	if($controller_name && strpos($controller_name,'/') > 0){
		$controller_name = str_replace('/','.',$controller_name);
	}
	return $controller_name;
}


function killword($str, $start=0, $length, $charset="utf-8", $suffix=true) {
	if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		$slice = iconv_substr($str,$start,$length,$charset);
	}else{
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice.'...' : $slice;
}
	
function killhtml($str, $length=0){
	if(is_array($str)){
		foreach($str as $k => $v) $data[$k] = killhtml($v, $length);
			 return $data;
	}

	if(!empty($length)){
		$estr = htmlspecialchars( preg_replace('/(&[a-zA-Z]{2,5};)|(\s)/','',strip_tags(str_replace('[CHPAGE]','',$str))) );
		if($length<0) return $estr;
		return killword($estr,0,$length);
	}
	return htmlspecialchars( trim(strip_tags($str)) );
}



function getClassUrl($class){
	if(empty($class['jumpurl'])){
		$url_type = config('url_type') ? config('url_type') : 1;
		if($url_type == 1){
			$url =  url('index/About/index',['class_id'=>$class['class_id']]);
		}else{
			if($class['filepath'] == '/'){
				$url = '/'.$class['filename'];
			}else{
				$url =  $class['filepath'].'/'.$class['filename'];
			}	
		}		
	}else{
		$url =$class['jumpurl'];
	}
	return $url;
}

function getListUrl($newslist){
	if(!empty($newslist['jumpurl'])){
		$url =  $newslist['jumpurl'];
	}else{
		$url_type = config('url_type') ? config('url_type') : 1;
		if($url_type == 1){
			$url =  url('index/View/index',['content_id'=>$newslist['content_id']]);
		}else{
			$info = db('content')->alias('a')->join('catagory b','a.class_id=b.class_id')->where(['a.content_id'=>$newslist['content_id']])->field('a.content_id,b.filepath')->find();
			$url = $info['filepath'].'/'.$info['content_id'].'.html';
		}
		
	}
	return $url;
}

//返回图片缩略后 或水印后不覆盖情况下的图片路径
function getSpic($newslist){
	if($newslist){
		$targetimages = pathinfo($newslist['pic']);
		$newpath = $targetimages['dirname'].'/'.'s_'.$targetimages['basename'];
		return $newpath;
	}
}

function U($classid){
	$url_type = config('xhadmin.url_type') ? config('xhadmin.url_type') : 1;
	if($url_type == 1){
		$url = url('index/About/index',['class_id'=>$classid]);
	}else{
		$info = \cms\db\Catagory::getInfo($classid);
		$url = $info['filepath'].'/'.$info['filename'];
	}
	return $url;
}

function wmjHandle($wmjsn, $type)
{
	//mlog("wmjHandle:".$wmjsn);
    $value_s = config('xhadmin.wmjaeskey') ? aesEncrypt($wmjsn, C('wmjaeskey')) : $wmjsn;
    $appid = 'appid='.config('xhadmin.wmjappid');
    $appsecret = 'appsecret='.config('xhadmin.wmjappsecret');
    //mlog("wmjHandle_appid:".$appid);
    //mlog("wmjHandle_appsecret:".$appsecret);
    $url = 'https://www.wmj.com.cn/api/'.$type.'.html?'.$appid.'&'.$appsecret;
    //mlog("wmjHandle_url:".$url);
    $result = wmjHttpPost($url, $value_s);
    return $result;
}
//卡管理
function wmjCardHandle($wmjsn, $type, $str)
{
	//mlog("wmjHandle:".$wmjsn);
    //$value_s = config('xhadmin.wmjaeskey') ? aesEncrypt($wmjsn, C('wmjaeskey')) : $wmjsn;
    $data=$str;
    //$appid = 'appid='.config('xhadmin.wmjappid');
    //$appsecret = 'appsecret='.config('xhadmin.wmjappsecret');
    //mlog("wmjHandle_appid:".$appid);
    //mlog("wmjHandle_appsecret:".$appsecret);
    $data['appid']=config('xhadmin.wmjappid');
    $data['appsecret']=config('xhadmin.wmjappsecret');
    $url = 'https://www.wmj.com.cn/api/'.$type.'.html';
    //mlog("wmjHandle_url:".$url);
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