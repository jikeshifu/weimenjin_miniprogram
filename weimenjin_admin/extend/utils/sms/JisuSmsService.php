<?php

//极速短信发送

namespace utils\sms;
use think\facade\Cache;
use think\facade\Log;

class JisuSmsService
{
	
	
	/**
	 * 发送短信
	 * @param  array $data [发送参数] $data['mobile'] 发送手机号 $data['code'] 发送验证码
	 * @return  Bool
	 */
	public static function sendSms($data){
		
		$appkey = config('my.jisu_sms_key');
		$mobile = $data['mobile'];
		try{
			$content = self::getContent($data);
			$url = "https://api.jisuapi.com/sms/send?appkey=$appkey&content=$content&mobile=$mobile";
			$result = self::curlOpen($url, ['ssl'=>true]);
			$jsonarr = json_decode($result, true);
		}catch(\Exception $e){
			log::error('极速短信发送失败:'.print_r($jsonarr['msg'],true));
			throw new \Exception('发送失败');
		}
		if($jsonarr['msg'] == 'ok'){
			return true;
		}
	}
	
	/**
	 * 获取短信模板内容
	 * @return  string
	 */
	private static function getContent($data){
		$appkey = config('my.jisu_sms_key');//您申请的APPKEY
		$templateid = config('my.jisu_sms_tempCode');//您申请的短信模板ID，根据实际情况修改
		$url = "https://api.jisuapi.com/sms/templatedetail?appkey=$appkey&templateid=$templateid";
		$result = self::curlOpen($url, ['ssl'=>true]);
		$jsonarr = json_decode($result, true);
		if($jsonarr['status'] != 0)
		{
			throw new \Exception($jsonarr['msg']);
		}
		$result = $jsonarr['result'];
		$tpl_value = $data['code'];
		$content = str_replace("@",$tpl_value,$result['content']);
		return $content;
	}
	
	private static function curlOpen($url, $config = array())
	{
		$arr = array('post' => false,'referer' => $url,'cookie' => '', 'useragent' => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; customie8)', 'timeout' => 20, 'return' => true, 'proxy' => '', 'userpwd' => '', 'nobody' => false,'header'=>array(),'gzip'=>true,'ssl'=>false,'isupfile'=>false);
		$arr = array_merge($arr, $config);
		$ch = curl_init();
		 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $arr['return']);
		curl_setopt($ch, CURLOPT_NOBODY, $arr['nobody']); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $arr['useragent']);
		curl_setopt($ch, CURLOPT_REFERER, $arr['referer']);
		curl_setopt($ch, CURLOPT_TIMEOUT, $arr['timeout']);
		//curl_setopt($ch, CURLOPT_HEADER, true);//获取header
		if($arr['gzip']) curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		if($arr['ssl'])
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}
		if(!empty($arr['cookie']))
		{
			curl_setopt($ch, CURLOPT_COOKIEJAR, $arr['cookie']);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $arr['cookie']);
		}
		 
		if(!empty($arr['proxy']))
		{
			//curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
			curl_setopt ($ch, CURLOPT_PROXY, $arr['proxy']);
			if(!empty($arr['userpwd']))
			{           
				curl_setopt($ch,CURLOPT_PROXYUSERPWD,$arr['userpwd']);
			}       
		}   
		 
		//ip比较特殊，用键值表示
		if(!empty($arr['header']['ip']))
		{
			array_push($arr['header'],'X-FORWARDED-FOR:'.$arr['header']['ip'],'CLIENT-IP:'.$arr['header']['ip']);
			unset($arr['header']['ip']);
		}  
		$arr['header'] = array_filter($arr['header']);
		 
		if(!empty($arr['header']))
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $arr['header']);
		}
	 
		if ($arr['post'] != false)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			if(is_array($arr['post']) && $arr['isupfile'] === false)
			{
				$post = http_build_query($arr['post']);           
			}
			else
			{
				$post = $arr['post'];
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}   
		$result = curl_exec($ch);
		//var_dump(curl_getinfo($ch));
		curl_close($ch);
	 
		return $result;
	}
    
}
