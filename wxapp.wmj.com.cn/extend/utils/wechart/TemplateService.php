<?php

//模板消息
namespace utils\wechart;
use EasyWeChat\Factory;
use think\facade\Log;

class TemplateService
{ 
	
	
	/**
	 * 微信公众号模板消息
	 * @param  string openid  用openid
	 * @param  string template_id 模板消息ID 直接到微信公众平台模板消息里面去查看
	 * @param  string url 模板消息的跳转地址 可以留空
	 * @param  string body 模板消息详情
	 $data['body'] = [
		 "first"  => "你好！",
		 "keynote1"   => "鄂A54M57",
		 "keynote2"   => "武汉站东广场",
		 "keynote3"   => "2个小时",
		 "keynote4"   => "20元",
		 "keynote5"   => date('Y-m-d H:i:s'),
		 'remark'		=> '请您于支付时间后15分钟内开车驶离停车场，否则还需再进行超时部分的停车费扫码补缴。',
	 ]
	 * @return array   返回发送详情
	 */
	public function sendOfficialTempLateMsg($data){
		
		$app = Factory::officialAccount(config('my.official_accounts'));
		
		$param['touser']		= $data['openid'];
		$param['template_id']	= config('my.official_template_id');
		$param['url']			= $data['url'];
		$param['data']			= $data['body'];
		
		try{
			$res = $app->template_message->send($param);
		}catch(\Exception $e){
			throw new \Exception('发送失败');
			log::error('模板消息发送错误：'.print_r($e->getMessage()));
		}
		
		return $res;
	}
	
	
	/**
	 * 小程序模板消息
	 * @param  string openid  用openid
	 * @param  string template_id 模板消息ID 直接到微信公众平台模板消息里面去查看
	 * @param  string url 模板消息的跳转地址 可以留空
	 * @param  string body 模板消息详情
	    $data['openid']		= 'oCKGm5MFwS-Uy3VLbmV46O-C4sy4';
		$data['form_id']	= $this->_data['form_id'];
		$data['body'] = [
			 "keyword1"   => "20元",
			 "keyword2"   => "武汉站东广场",
			 "keyword3"   => "鄂A54M57",
			 "keyword4"   => date('Y-m-d H:i:s'),
			 "keyword5"   => '5小时',
		];
	 * @return array   返回发送详情
	 */
	public function sendMiniTempLateMsg($data){
		
		$app = Factory::miniProgram(config('my.mini_program'));
		
		$param['touser']		= $data['openid'];
		$param['template_id']	= config('my.mini_template_id');
		$param['url']			= $data['url'];
		$param['form_id']		= $data['form_id'];
		$param['data']			= $data['body'];
		
		try{
			$res = $app->template_message->send($param);
		}catch(\Exception $e){
			throw new \Exception('发送失败');
			log::error('模板消息发送错误：'.print_r($e->getMessage()));
		}
		
		return $res;
	}
	
    
}
