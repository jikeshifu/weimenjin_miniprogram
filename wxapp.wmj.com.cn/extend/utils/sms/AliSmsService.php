<?php

//阿里大鱼短信发送
namespace utils\sms;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use think\facade\Log;

class AliSmsService
{
	
	/**
	 * 发送短信
	 * @param  array $data [发送参数] $data['mobile'] 发送手机号 $data['code'] 发送验证码
	 * @return  Bool
	 */
	public function sendSms($data){
		require_once app()->getRootPath().'/vendor/aliyunsms/vendor/autoload.php';
		require_once app()->getRootPath().'/vendor/aliyunsms/lib/Api/Sms/Request/V20170525/SendSmsRequest.php';
		Config::load();
		$product = "Dysmsapi";
		$domain = "dysmsapi.aliyuncs.com";
		$region = "cn-hangzhou";
		$profile = DefaultProfile::getProfile($region, config('my.ali_sms_accessKeyId'), config('my.ali_sms_accessKeySecret'));
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
		$acsClient= new DefaultAcsClient($profile);
		$request = new SendSmsRequest();
		$request->setPhoneNumbers($data['mobile']);//必填-短信接收号码
		$request->setSignName(config('my.ali_sms_signname'));//必填-短信签名
		$request->setTemplateCode(config('my.ali_sms_tempCode'));//必填-短信模板 Code
		//选填-假如模板中存在变量需要替换则为必填(JSON 格式)
		$code = $data['code'];
		$request->setTemplateParam("{\"code\":$code}");//短信签名内容:
		//发起访问请求
		$resp = $acsClient->getAcsResponse($request);
		if($resp->Code == 'OK'){
			return true;
		}else{
			log::error('阿里大鱼短信发送失败:'.print_r($resp,true));
			throw new \Exception('发送失败');
		}
	}
    
}
