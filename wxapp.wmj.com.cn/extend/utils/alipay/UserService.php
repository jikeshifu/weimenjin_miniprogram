<?php

//支付宝用户授权
namespace utils\alipay;
use think\facade\Log;

class UserService
{
	
	/**
	 * 支付宝授权获取access_token
	 * @param  array $param
	 * @return string access_token
	 */
	public static function getAccessToken($param){	
		require_once app()->getRootPath().'/vendor/aop/AopClient.php';
		require_once app()->getRootPath().'/vendor/aop/request/AlipaySystemOauthTokenRequest.php';
		$aop = new \AopClient();
		$aop->gatewayUrl = config('my.alipay.gatewayUrl');
		$aop->appId = config('my.alipay.appId');
		$aop->rsaPrivateKey = config('my.alipay.rsaPrivateKey');
		$aop->alipayrsaPublicKey=config('my.alipay.alipayrsaPublicKey');
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='utf-8';
		$aop->format='json';
		$request = new \AlipaySystemOauthTokenRequest ();
		$request->setGrantType("authorization_code");
		$request->setCode($param['code']);

		$result = $aop->execute ($request);
		$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
		
		$user_id = $result->$responseNode->user_id;
		$access_token = $result->$responseNode->access_token;
		mlog("getAccessToken_result".json_encode($result));
		mlog("getAccessToken_result_access_token:".json_encode($access_token));
		return $user_id;
	}
	
	
	/**
	 * 支付宝授权获取用户信息
	 * @param  array $param
	 * @return string access_token
		[code] => 10000
		[msg] => Success
		[avatar] => https://tfs.alipayobjects.com/images/partner/T16iNlXh4cXXXXXXXX
		[city] => 武汉市
		[gender] => m   m 男 f 女
		[is_certified] => T
		[is_student_certified] => F
		[nick_name] => 寒塘冷月
		[province] => 湖北省
		[user_id] => 2088512768108082
		[user_status] => T
		[user_type] => 2
	*/
	public function getUserInfo($param){
		mlog("in getUserInfo");
		if(empty($param['code'])) throw new \Exception('code不能为空');
		
		require_once app()->getRootPath().'/vendor/aop/AopClient.php';
		require_once app()->getRootPath().'/vendor/aop/request/AlipayUserInfoShareRequest.php';
		$aop = new \AopClient();
		$aop->gatewayUrl = config('my.alipay.gatewayUrl');
		$aop->appId = config('my.alipay.appId');
		$aop->rsaPrivateKey = config('my.alipay.rsaPrivateKey');
		$aop->alipayrsaPublicKey=config('my.alipay.alipayrsaPublicKey');
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='utf-8';
		$aop->format='json';
		$request = new \AlipayUserInfoShareRequest ();
		mlog("getUserInfo_param:".json_encode($param));
		$backAccessToken = self::getAccessToken($param);
		/*
		mlog("getUserInfo_backAccessToken:".$backAccessToken);
		$result = $aop->execute ( $request, $backAccessToken);
		
		$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
		mlog("getUserInfo_result:".json_encode($result));
		mlog("getUserInfo_responseNode:".json_encode($responseNode));
		if($result->$responseNode->code == '10000'){
			$data['user_id'] = $result->$responseNode->user_id;
			$data['user_name'] = $result->$responseNode->nick_name;
			$data['city'] = $result->$responseNode->city;
			$data['province'] = $result->$responseNode->province;
			$data['avatar'] = $result->$responseNode->avatar;
			$data['gender'] = $result->$responseNode->gender == 'm' ? '1' : '2';
			
			return $data;
		}
		*/
		if($backAccessToken)
		{
			$data['user_id'] = $backAccessToken;
			return $data;
		}
		

		
	} 
   
}
