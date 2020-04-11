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
			$url =  url('ApplicationName/About/index',['class_id'=>$class['class_id']]);
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
			$url =  url('ApplicationName/View/index',['content_id'=>$newslist['content_id']]);
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
		$url = url('ApplicationName/About/index',['class_id'=>$classid]);
	}else{
		$info = \xhadmin\db\Catagory::getInfo($classid);
		$url = $info['filepath'].'/'.$info['filename'];
	}
	return $url;
}

