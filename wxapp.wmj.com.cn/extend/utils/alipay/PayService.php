<?php

//支付宝支付
namespace utils\alipay;
use think\facade\Log;

class PayService
{
	
	/**
	 * 支付宝pc扫码支付
	 * @param  array $param
	 * @return array   直接跳转到支付宝收银台
	 */
	public function nativePay($param){
		
		if(empty($param['subject'])) throw new \Exception('订单标题不能为空');
		if(empty($param['out_trade_no'])) throw new \Exception('交易订单号不能为空');
		if(empty($param['total_amount'])) throw new \Exception('交易金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$param['total_amount'])){
			throw new \Exception('交易金额格式错误');
		}
		if(empty($param['notify_url'])) throw new \Exception('异步回调地址不能为空');
		//if(empty($param['return_url'])) throw new \Exception('同步回调地址不能为空');
		
		require_once app()->getRootPath().'/vendor/aop/AopClient.php';
		require_once app()->getRootPath().'/vendor/aop/request/AlipayTradePagePayRequest.php';
		$aop = new \AopClient();
		$aop->gatewayUrl = config('my.alipay.gatewayUrl');
		$aop->appId = config('my.alipay.appId');
		$aop->rsaPrivateKey = config('my.alipay.rsaPrivateKey');
		$aop->alipayrsaPublicKey=config('my.alipay.alipayrsaPublicKey');
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='utf-8';
		$aop->format='json';
		$request = new \AlipayTradePagePayRequest();
		
		$request->setNotifyUrl($param['notify_url']);		//异步回调地址
		$request->setReturnUrl($param['return_url']);		//异步回调地址

		$data['body'] 			= $param['body'];			//订单描述
		$data['subject'] 		= $param['subject'];		//订单标题
		$data['out_trade_no'] 	= $param['out_trade_no'];	//订单号
		$data['total_amount'] 	= $param['total_amount'];	//订单金额
		$data['product_code'] 	= 'FAST_INSTANT_TRADE_PAY';		
		
		$request->setBizContent(json_encode($data));	
		$result = $aop->pageExecute ( $request);
		echo $result;
	}
	
	
	/**
	 * 支付宝移动端wap支付
	 * @param  array $param
	 * @return array  欢迎支付宝app收银台
	 */
	public function wapPay($param){
		
		if(empty($param['subject'])) throw new \Exception('订单标题不能为空');
		if(empty($param['out_trade_no'])) throw new \Exception('交易订单号不能为空');
		if(empty($param['total_amount'])) throw new \Exception('交易金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$param['total_amount'])){
			throw new \Exception('交易金额格式错误');
		}
		if(empty($param['notify_url'])) throw new \Exception('回调地址不能为空');
		
		require_once app()->getRootPath().'/vendor/aop/AopClient.php';
		require_once app()->getRootPath().'/vendor/aop/request/AlipayTradeWapPayRequest.php';
		$aop = new \AopClient();
		$aop->gatewayUrl = config('my.alipay.gatewayUrl');
		$aop->appId = config('my.alipay.appId');
		$aop->rsaPrivateKey = config('my.alipay.rsaPrivateKey');
		$aop->alipayrsaPublicKey=config('my.alipay.alipayrsaPublicKey');
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='utf-8';
		$aop->format='json';
		$request = new \AlipayTradeWapPayRequest();
		
		$request->setNotifyUrl($param['notify_url']);		//异步回调地址

		$data['body'] 			= $param['body'];			//订单描述
		$data['subject'] 		= $param['subject'];		//订单标题
		$data['out_trade_no'] 	= $param['out_trade_no'];	//订单号
		$data['total_amount'] 	= $param['total_amount'];	//订单金额
		$data['product_code'] 	= 'QUICK_WAP_WAY';		
		
		$request->setBizContent(json_encode($data));	
		$result = $aop->pageExecute ( $request);
		echo $result;
	}
	
	/**
	 * 支付宝移动端app支付
	 * @param  array $param
	 * @return array  直接唤醒支付宝app收银台
	 */
	public function appPay($param){
		
		if(empty($param['subject'])) throw new \Exception('订单标题不能为空');
		if(empty($param['out_trade_no'])) throw new \Exception('交易订单号不能为空');
		if(empty($param['total_amount'])) throw new \Exception('交易金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$param['total_amount'])){
			throw new \Exception('交易金额格式错误');
		}
		if(empty($param['notify_url'])) throw new \Exception('回调地址不能为空');
		
		require_once app()->getRootPath().'/vendor/aop/AopClient.php';
		require_once app()->getRootPath().'/vendor/aop/request/AlipayTradeAppPayRequest.php';
		$aop = new \AopClient();
		$aop->gatewayUrl = config('my.alipay.gatewayUrl');
		$aop->appId = config('my.alipay.appId');
		$aop->rsaPrivateKey = config('my.alipay.rsaPrivateKey');
		$aop->alipayrsaPublicKey=config('my.alipay.alipayrsaPublicKey');
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='utf-8';
		$aop->format='json';
		$request = new \AlipayTradeAppPayRequest();
		
		$request->setNotifyUrl($param['notify_url']);		//异步回调地址

		$data['body'] 			= $param['body'];			//订单描述
		$data['subject'] 		= $param['subject'];		//订单标题
		$data['out_trade_no'] 	= $param['out_trade_no'];	//订单号
		$data['total_amount'] 	= $param['total_amount'];	//订单金额
		
		$request->setBizContent(json_encode($data));	
		$result = $aop->sdkExecute  ( $request);
		return $result;
	}
   
}
