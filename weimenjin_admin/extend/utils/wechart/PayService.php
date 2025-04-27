<?php

//微信支付
namespace utils\wechart;
use EasyWeChat\Factory;
use think\facade\Log;

class PayService
{

	/**
	 * 微信jssdk支付
	 * @param  array $data
	 * @param  array $config  小程序支付用小程序的配置 公众号支付用公众号的配置
	 * @return array   返回sdk参数
	 */
	public static function jsapiPay($data,$config){
		
		if(empty($data['body'])) throw new \Exception('交易标题不能为空');
		if(empty($data['out_trade_no'])) throw new \Exception('交易订单号不能为空');
		if(empty($data['total_fee'])) throw new \Exception('交易金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['total_fee'])){
			throw new \Exception('交易金额格式错误');
		}
		if(empty($data['notify_url'])) throw new \Exception('回调地址不能为空');
		if(empty($data['openid'])) throw new \Exception('用户openid不能为空');
		
		$payment = Factory::payment($config);
		
		$orderInfo['trade_type']		= 'JSAPI';					//支付类型
		$orderInfo['body']				= $data['body'];			//交易标题
		$orderInfo['out_trade_no']		= $data['out_trade_no'];	//交易订单号
		$orderInfo['total_fee']			= $data['total_fee'];		//交易金额 单位 分
		$orderInfo['notify_url']		= $data['notify_url'];		//支付成功以后的回调地址
		$orderInfo['openid']			= $data['openid'];			//用户openid
		$orderInfo['attach']			= $data['attach'];			//异步通知原样返回
		
		try{
			$res = $payment->order->unify($orderInfo);
		}catch(\Exception $e){
			log::error('微信支付错误：'.print_r($e->getMessage(),true));
			throw new \Exception('微信支付失败');
		}
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			log::error('微信支付错误：'.print_r($res,true));
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		log::info('微信jssk返回：'.print_r($res,true));
		$jsconfig = $payment->jssdk->sdkConfig($res['prepay_id']);	//返回sdk配置
		return $jsconfig;
	}
	
	/**
	 * 微信扫码支付模式一
	 * @param  array $data
	 * @param  array $config  小程序支付用小程序的配置 公众号支付用公众号的配置
	 * @return array   返回code_url  该返回参数直接生成二维码 扫码即可支付
	 */
	public function nativePay($data){
		
		if(empty($data['body'])) throw new \Exception('交易标题不能为空');
		if(empty($data['out_trade_no'])) throw new \Exception('交易订单号不能为空');
		if(empty($data['total_fee'])) throw new \Exception('交易金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['total_fee'])){
			throw new \Exception('交易金额格式错误');
		}
		if(empty($data['notify_url'])) throw new \Exception('回调地址不能为空');
		
		$payment = Factory::payment(array_merge(config('my.official_accounts'),config('my.wechart_pay')));
		
		$orderInfo['trade_type']		= 'NATIVE';					//支付类型
		$orderInfo['body']				= $data['body'];			//交易标题
		$orderInfo['out_trade_no']		= $data['out_trade_no'];	//交易订单号
		$orderInfo['total_fee']			= $data['total_fee'];		//交易金额 单位 分
		$orderInfo['notify_url']		= $data['notify_url'];		//支付成功以后的回调地址
		$orderInfo['attach']			= $data['attach'];			//异步通知原样返回
		
		$res = $payment->order->unify($orderInfo);
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			log::error('微信扫码支付错误：'.print_r($res,true));
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res['code_url'];
	}
	
	/**
	 * 企业付款到用户零钱
	 * @param  string transactionId  微信订单号
	 * @return array   返回订单详情
	 */
	public static function payToUserBlance($data,$config){
		
		if(empty($data['openid'])) throw new \Exception('用户openid不能为空');
		if(empty($data['re_user_name'])) throw new \Exception('用户真实姓名不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['amount'])){
			throw new \Exception('付款金额格式错误');
		}
		if(empty($data['desc'])) throw new \Exception('付款说明不能为空');
		
		$payment = Factory::payment($config);
		
		$payInfo['partner_trade_no'] = doOrderSn('001');		// 商户订单号，需保持唯一性
		$payInfo['openid'] = $data['openid'];					// 用户openid
		$payInfo['check_name'] = 'FORCE_CHECK';					//NO_CHECK 不校验真实姓名,FORCE_CHECK 强校验真实姓名
		$payInfo['re_user_name'] = $data['re_user_name'];		//如果 check_name设置为FORCE_CHECK，则必填用户真实姓名
		$payInfo['amount'] = $data['amount'] * 100;				// 企业付款金额，单位为分
		$payInfo['desc'] = $data['desc'];						//企业付款操作说明信息。必填
		
		try{
			$res = $payment->transfer->toBalance($payInfo);
		}catch(\Exception $e){
			log::error('微信企业付款错误：'.print_r($e->getMessage()));
		}
		
		log::info('企业付款到零钱返回：'.print_r($res,true));
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
	
	/**
	 * 企业付款到用户银行卡号 需要配置rsa公钥证书
	 * @param  string transactionId  微信订单号
	 * @return array   返回订单详情
	 * https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_4&index=5  银行卡编号的查找
	 */
	public static function payToUserCard($data){
		
		if(empty($data['enc_bank_no'])) throw new \Exception('银行卡号不能为空');
		if(empty($data['enc_true_name'])) throw new \Exception('用户真实姓名不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['amount'])){
			throw new \Exception('付款金额格式错误');
		}
		if(empty($data['bank_code'])) throw new \Exception('银行编号不能为空');
		if(empty($data['desc'])) throw new \Exception('付款说明不能为空');
		
		$payment = Factory::payment(config('my.wechart_pay'));
		
		$payInfo['partner_trade_no']    = doOrderSn('002');
		$payInfo['enc_bank_no']			= $data['enc_bank_no'];		//银行卡号
		$payInfo['enc_true_name']		= $data['enc_true_name'];	//用户姓名
		$payInfo['bank_code']			= $data['bank_code'];		//银行编码 请到微信平台查看
		$payInfo['amount']				= $data['amount'] * 100;	//付款金额
		$payInfo['desc']				= $data['desc'];			//付款说明
		
		try{
			$res = $payment->transfer->toBankCard($data);
		}catch(\Exception $e){
			log::error('微信企业付款错误：'.print_r($e->getMessage()));
		}
		
		log::info('企业付款到零钱返回：'.print_r($res,true));
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
	
	
	/**
	 * 发送普通红包
	 * @param  string transactionId  微信订单号
	 * @return array   返回订单详情
	 */
	public static function sendNormalRedpack($data){
		
		if(empty($data['send_name'])) throw new \Exception('商户名称不能为空');
		if(empty($data['re_openid'])) throw new \Exception('用户openid不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['total_amount'])){
			throw new \Exception('红包金额格式错误');
		}
		if(empty($data['wishing'])) throw new \Exception('祝福语不能为空');
		if(empty($data['act_name'])) throw new \Exception('活动名称不能为空');
		if(empty($data['remark'])) throw new \Exception('活动备注不能为空');
		
		$payment = Factory::payment(array_merge(config('my.official_accounts'),config('my.wechart_pay')));
		
		$payInfo['mch_billno']    		= doOrderSn('004');
		$payInfo['send_name']			= $data['send_name'];			//发送说明
		$payInfo['re_openid']			= $data['re_openid'];			//用户openid
		$payInfo['total_amount']		= $data['total_amount'] * 100;	//发送红包金额
		$payInfo['wishing']				= $data['wishing'];				//祝福语
		$payInfo['act_name']			= $data['act_name'];			//活动名称
		$payInfo['remark']				= $data['remark'];				//活动备注
		
		try{
			$res = $payment->redpack->sendNormal($payInfo);
		}catch(\Exception $e){
			log::error('微信企业付款错误：'.print_r($e->getMessage()));
		}
		
		log::info('企业付款到零钱返回：'.print_r($res,true));
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
	
	/**
	 * 发送裂变红包
	 * @param  string transactionId  微信订单号
	 * @return array   返回订单详情
	 */
	public static function sendGroupRedpack($data){
		
		if(empty($data['send_name'])) throw new \Exception('商户名称不能为空');
		if(empty($data['re_openid'])) throw new \Exception('用户openid不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['total_amount'])){
			throw new \Exception('红包金额格式错误');
		}
		if($data['total_amount'] < 3) throw new \Exception('裂变红包码最少3元');
		if($data['total_num'] < 3) throw new \Exception('裂变次数最少三次');
		if(empty($data['wishing'])) throw new \Exception('祝福语不能为空');
		if(empty($data['act_name'])) throw new \Exception('活动名称不能为空');
		if(empty($data['remark'])) throw new \Exception('活动备注不能为空');
		
		$payment = Factory::payment(array_merge(config('my.official_accounts'),config('my.wechart_pay')));
		
		$payInfo['mch_billno']    		= doOrderSn('004');
		$payInfo['send_name']			= $data['send_name'];			//发送说明
		$payInfo['re_openid']			= $data['re_openid'];			//用户openid
		$payInfo['total_amount']		= $data['total_amount'] * 100;	//发送红包金额
		$payInfo['wishing']				= $data['wishing'];				//祝福语
		$payInfo['act_name']			= $data['act_name'];			//活动名称
		$payInfo['remark']				= $data['remark'];				//活动名称
		$payInfo['total_num']			= $data['total_num'];			//裂变次数 不小于3
		
		try{
			$res = $payment->redpack->sendGroup($payInfo);
		}catch(\Exception $e){
			log::error('微信企业付款错误：'.print_r($e->getMessage()));
		}
		
		log::info('企业付款到零钱返回：'.print_r($res,true));
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
	
	/**
	 * 微信订单支付查询
	 * @param  string transactionId  微信订单号
	 * @return array   返回订单详情
	 */
	public static function payQuery($out_trade_no){
		
		if(empty($out_trade_no)) throw new \Exception('交易订单号不能为空');
		
		$payment = Factory::payment(array_merge(config('my.official_accounts'),config('my.wechart_pay')));
		
		try{
			$res = $payment->order->queryByOutTradeNumber($out_trade_no);
		}catch(\Exception $e){
			log::error('微信支付查询错误：'.print_r($e->getMessage()));
		}
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
	
	
	/**
	 * 微信支付退款
	 * @param  array $data
	 * @param  string data.out_trade_no  交易单号 商户订单号
	 * @param  float data.totalFee  订单金额
	 * @param  float data.refundFee  退款金额
	 * @param  float data.desc  退款说明
	 * @return array   返回退款详情
	 */
	public static function refund($data){
		
		if(empty($data['out_trade_no'])) throw new \Exception('交易订单号不能为空');
		if(empty($data['total_fee'])) throw new \Exception('订单金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['total_fee'])){
			throw new \Exception('订单金额格式错误');
		}
		if(empty($data['refund_fee'])) throw new \Exception('退款金额不能为空');
		if(!preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',$data['refund_fee'])){
			throw new \Exception('退款金额格式错误');
		}
		if(empty($data['desc'])) throw new \Exception('退款说明不能为空');
		
		$payment = Factory::payment(array_merge(config('my.official_accounts'),config('my.wechart_pay')));
		try{		
			$res = $payment->refund->byOutTradeNumber($data['out_trade_no'],doOrderSn('000'),$data['total_fee'] * 100,$data['refund_fee'] * 100,['refund_desc' => $data['desc']]);		
		}catch(\Exception $e){
			log::error('微信退款错误：'.print_r($e->getMessage()));
		}
		
		log::info('微信退款订单详情：'.print_r($res,true));
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
	
	
	/**
	 * 微信退款查询
	 * @param  string refundId
	 * @return array   返回退款详情
	 */
	public static function refundQuery($refundId){
		
		if(empty($refundId)) throw new \Exception('退款交易号不能为空');
		$payment = Factory::payment(array_merge(config('my.official_accounts'),config('my.wechart_pay')));
		try{
			$res = $payment->refund->queryByRefundId($refundId);
		}catch(\Exception $e){
			log::error('微信退款查询错误：'.print_r($e->getMessage()));
		}
		
		if($res['result_code'] == 'FAIL' || $res['return_code'] == 'FAIL'){
			$msg = $res['err_code_des'] ? $res['err_code_des'] : $res['return_msg'];
			throw new \Exception($msg);
		}
		
		return $res;
	}
   
}
