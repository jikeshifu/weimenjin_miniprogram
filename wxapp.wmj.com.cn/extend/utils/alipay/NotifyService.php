<?php

//微信支付回调数据验证
namespace utils\alipay;

class NotifyService
{
	
	/**
	 * 支付宝回调签名验证
	 * @param  array $data  微信回调返回的原始xml数据
	 * @return bool
	 */
	public static function checkSign($data){
		require_once app()->getRootPath().'/vendor/aop/AopClient.php';
		
		$aop = new \AopClient();
		$aop->alipayrsaPublicKey = config('my.alipayrsaPublicKey');
		$result = $aop->rsaCheckV1($arr, config('my.alipayrsaPublicKey'), 'RSA2');

		return $result;
	}
	
	
	
    
}
