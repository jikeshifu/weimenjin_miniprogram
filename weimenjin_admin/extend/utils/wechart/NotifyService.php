<?php

//微信支付回调数据验证
namespace utils\wechart;

class NotifyService
{
	
	/**
	 * 微信支付回调签名验证
	 * @param  array $data  微信回调返回的原始xml数据
	 * @return bool
	 */
	public static function checkSign($data){
		
		if($data['return_code'] == "SUCCESS" && $data['result_code'] == "SUCCESS"){
			foreach($data as $k=>$v) {
                if($k == 'sign') {
                    $xmlsign = $data[$k];
                    unset($data[$k]);
                };
            }
			$sign = http_build_query($data);
			$sign = md5($sign.'&key='.config('my.wechart_pay.key'));
			$sign = strtoupper($sign);
			if($xmlsign == $sign){
				return true;
			}else{
				throw new \Exception('微信验证签名错误');
			}
		}
	}
	
	
	
    
}
