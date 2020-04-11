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


use think\facade\Db; 
use think\facade\Log; 

error_reporting(0);

/**
 * 随机字符
 * @param int $length 长度
 * @param string $type 类型
 * @param int $convert 转换大小写 1大写 0小写
 * @return string
 */
function random($length=10, $type='letter', $convert=0)
{
    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );

    if(!isset($config[$type])) $type = 'letter';
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) -1;
    for($i = 0; $i < $length; $i++){
        $code .= $string{mt_rand(0, $strlen)};
    }
    if(!empty($convert)){
        $code = ($convert > 0)? strtoupper($code) : strtolower($code);
    }
    return $code;
}

/*
 * 生成交易流水号
 * @param char(2) $type
 */
function doOrderSn($type){
	return date('YmdHis') .$type. substr(microtime(), 2, 3) .  sprintf('%02d', rand(0, 99));
}


function deldir($dir) {
//先删除目录下的文件：
   $dh=opendir($dir);
   while ($file=readdir($dh)) {
	  if($file!="." && $file!="..") {
		 $fullpath=$dir."/".$file;
		 if(!is_dir($fullpath)) {
			unlink($fullpath);
		 } else {
			deldir($fullpath);
		 }
	  }
   }
 
   closedir($dh);
   //删除当前文件夹：
   if(rmdir($dir)) {
	  return true;
   } else {
	  return false;
   }
}


if (!function_exists('p')) {
    function p($var, $die = 0) {
        print_r($var);
        $die && die();
    }
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

function ip(){
    $ip='未知IP';
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        return is_ip($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:$ip;
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        return is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$ip;
    }else{
        return is_ip($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$ip;
    }
}
function is_ip($str){
    $ip=explode('.',$str);
    for($i=0;$i<count($ip);$i++){ 
        if($ip[$i]>255){ 
            return false; 
        } 
    } 
    return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$str); 
}


//通过字段值获取字段配置的名称
function getFieldVal($val,$fieldConfig){
	if($fieldConfig){
		foreach(explode(',',$fieldConfig) as $k=>$v){
			$tempstr = explode('|',$v);
			foreach(explode(',',$val) as $m=>$n){
				if($tempstr[1] == $n){
					$fieldvals .= $tempstr[0].',';
				}
			}
			
		}
		return rtrim($fieldvals,',');
	}
}



//通过字段名称获取字段配置的值
function getFieldName($val,$fieldConfig){
	if($fieldConfig){
		foreach(explode(',',$fieldConfig) as $k=>$v){
			$tempstr = explode('|',$v);
			if($tempstr[0] == $val){
				$fieldval = $tempstr[1];
			}
		}
		return $fieldval;
	}
}


//通过键值返回键名
function getKeyByVal($array,$data){
	foreach($array as $key=>$val){
		if($val == $data){
			$data = $key;
		}
	}
	return $data;
}


//导出时候当有三级联动字段的时候 需要将查询字段重载
function formartExportWhere($field){
	foreach($field as $k=>$v){
		if(strpos($v,'|') > 0){
			$dt = $field[$k];
			unset($field[$k]);
		}
	}
	
	return \xhadmin\CommonService::filterEmptyArray(array_merge($field,explode('|',$dt)));
}


/*格式化列表*/
function formartList($fieldConfig,$list)
{
	$cat = new \org\Category($fieldConfig);
	$ret=$cat->getTree($list);
	return $ret;
}

/*写入
* @param  string  $type 1 为生成控制器
*/

function filePutContents($content,$filepath,$type){
	if(in_array($type,[1,3])){
		$str = file_get_contents($filepath);
		$parten = '/\s\/\*+start\*+\/(.*)\/\*+end\*+\//iUs';
		preg_match_all($parten,$str,$all);
		if($all[0]){
			foreach($all[0] as $key=>$val){
				$ext_content .= $val."\n\n";
			}
		}
		
		$content .= $ext_content."\n\n";
		if($type == 1){
			$content .="}\n\n";
		}
	}
	
	ob_start();
	echo $content;
	$_cache=ob_get_contents();
	ob_end_clean();
	
	if($_cache){
		$File = new \think\template\driver\File();
		$File->write($filepath, $_cache);	
	}
}

function htmlOutList($list,$err_status=false){
	foreach($list as $key=>$row) {
		$res[$key] = checkData($row,$err_status);	
	}
	
	return $res;
}

//err_status  没有数据是否抛出异常 true 是 false 否
function checkData($data,$err_status=true){	
	if(!$data && $err_status){
		throw new \Exception('没有数据');
	}
	
	foreach($data as $k=>$v){
		if($v && is_array($v)){
			$data[$k] = checkData($v);
		}else{
			$data[$k] = html_out($v);
		}
	}
	return $data;
	
}

//html代码输入
function html_in($str){
    $str=htmlspecialchars($str);
	$str=strip_tags($str);
    if(!get_magic_quotes_gpc()) {
        $str = addslashes($str);
    }

   return $str;
}


//html代码输出
function html_out($str){
    if(function_exists('htmlspecialchars_decode')){
        $str=htmlspecialchars_decode($str);
    }else{
        $str=html_entity_decode($str);
    }
    $str = stripslashes($str);
    return $str;
}

//后台sql输入框语句过滤
function sql_replace($str){
	$farr = ["/insert|update|create|alter|delete|drop|load_file|outfile|dump/is"];
	$str = preg_replace($farr,'',$str);
	return $str;
}

//上传文件黑名单过滤
function upload_replace($str){
	$farr = ["/php|php3|php4|php5|phtml|pht|/is"];
	$str = preg_replace($farr,'',$str);
	return $str;
}

//查询方法过滤
function serach_in($str){
	$farr = ["/^select|insert|and|or|create|update|delete|alter|count|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i"];
	$str = preg_replace($farr,'',html_in($str));
	return trim($str);
}

function datetime($time){
	return date('Y-m-d H:i:s',$time);
}

//返回字段定义的时间格式
function getTimeFormat($val){
	$default_time_format = explode('|',$val['default_value']);
	$time_format = $default_time_format[0];
	if(!$time_format || $val['default_value'] == 'null'){
		$time_format = 'Y-m-d H:i:s';
	}
	return $time_format;
}

/**
 * 过滤掉空的数组
 * @access protected
 * @param  array        $data     数据
 * @return array
 */
function filterEmptyArray($data = []){
	foreach( $data as $k=>$v){   
		if( !$v && $v !== 0)   
			unset( $data[$k] );   
	}
	return $data;
}

function isNotEmpty($str){
	if(is_array($str)){
		if(filterEmptyArray($str)){
			return true;
		}
	}else{
		if($str){
			return true;
		}
	}
}

/**
 * tp官方数组查询方法废弃，数组转化为现有支持的查询方法
 * @param array $data 原始查询条件
 * @return array
 */
function formatWhere($data){
	$where = [];
	foreach( $data as $k=>$v){
		if(is_array($v)){
			if(isNotEmpty($v[1])){
				switch(strtolower($v[0])){			
					//模糊查询
					case 'like':
						$v[1] = '%'.$v[1].'%';
					break;
					
					//表达式查询
					case 'exp':
						$v[1] = Db::raw($v[1]);
					break;
					
					//区间查询
					case 'between':
						if($v[1] && is_array($v[1])){
							if(!empty($v[1][0]) && empty($v[1][1])){
								$v[0] = '>';
								$v[1] = $v[1][0];
							}
							if(empty($v[1][0]) && !empty($v[1][1])){
								$v[0] = '<';
								$v[1] = $v[1][1];
							}
						}
					break;
				}
				$where[] = [$k,$v[0],$v[1]];
			}
		}else{
			if((string) $v != null){
				$where[] = [$k,'=',$v];
			}
		}
	}
	return $where;
}

//导出excel表头设置
function getTag($key3,$no=100){
	$data=[];
	$key = ord("A");//A--65
	$key2 = ord("@");//@--64	
	for($n=1;$n<=$no;$n++){
		if($key>ord("Z")){
			$key2 += 1;
			$key = ord("A");
			$data[$n] = chr($key2).chr($key);//超过26个字母时才会启用  
		}else{
			if($key2>=ord("A")){
				$data[$n] = chr($key2).chr($key);//超过26个字母时才会启用  
			}else{
				$data[$n] = chr($key);
			}
		}
		$key += 1;
	}
	return $data[$key3];
}

/**
 * 实例化数据库类
 * @param string        $name 操作的数据表名称（不含前缀）
 * @param array|string  $config 数据库配置参数
 * @param bool          $force 是否强制重新连接
 * @return \think\db\Query
 */
if (!function_exists('db')) {
    function db($name = '')
    {
        return Db::connect('mysql',false)->name($name);
    }
}

function mlog($txt,$filename='log.txt') {
    $txt = date('Y/m/d H:i:s').": {$txt}\r\n";
    file_put_contents('./'.$filename, $txt, FILE_APPEND); //追加内容
}
function sign($data, $key)
{
    array_filter($data);
    ksort($data);
    return strtoupper(md5(urldecode(http_build_query($data) . '&key=' . $key)));
}
