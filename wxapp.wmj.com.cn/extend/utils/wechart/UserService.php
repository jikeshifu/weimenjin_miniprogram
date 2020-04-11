<?php

//获取微信用户信息操作
namespace utils\wechart;
use EasyWeChat\Factory;
use think\facade\Log;
/*start*/
include_once "wxBizDataCrypt.php";
/*end*/
class UserService
{
	
	/**
	 * 获取用户信息
	 * @param  string $redirect_url  授权成功后重定向的url
	 * @param  string $data  授权成功后带的参数 主要是获取code
	 * @param  string $snsapi  授权类型 snsapi_userinfo 普通授权 能获取到用户信息 snsapi_base 静默授权 无法获取用户信息
	 * @return array   返回用户信息
	 
	 Array
		(
			[id] => oswRovy26PHxhshgsgdhsdghsdhgdsgh
			[name] => 寒塘冷月
			[nickname] => 寒塘冷月
			[avatar] => http://thirdwx.qlogo.cn/mmopen/vi_32/BEns1g44v7MaXjqBeJX8kpmibpYl7dhacNFw7P5KItT5FMe9Bq5fcniaxmqE2icwCtPBeJMvOQgA4ekRM6I183Plg/132
			[email] => 
			[original] => Array
				(
					[openid] => oswRovy26PHxfgdsfgdsfgW-99GQ
					[nickname] => 寒塘冷月
					[sex] => 1
					[language] => zh_CN
					[city] => 
					[province] => 科连特斯
					[country] => 阿根廷
					[headimgurl] => http://thirdwx.qlogo.cn/mmopen/vi_32/BEns1g44v7MaXjqBeJX8kpmibpYl7dhacNFw7P5KItT5FMe9Bq5fcniaxmqE2icwCtPBeJMvOQgA4ekRM6I183Plg/132
					[privilege] => Array
						(
						)
				)

			[token] => 24_2DBsKVOHDEvG0qWe73N3rgUEMexPGGvkV9Cd-lUkwQg8kgxnNm_-RxBCj7F9J039DcMZKgqiZhzZ6T3It1_fOA
			[provider] => WeChat
		)
	 */
	 
	public static function getUserInfo($redirect_url,$data,$snsapi='snsapi_userinfo'){
		
		$app = Factory::officialAccount(config('my.official_accounts'));
		if(!isset($data['code'])){
			$response = $app->oauth->scopes([$snsapi])->redirect($redirect_url);
			$response->send();
		}else{
			$user = $app->oauth->user();
			log::info('微信授权返回用户信息：'.print_r($user,true));
			return $user->toArray();
		}
	}
	
	/**
	 * 获取用户openid信息
	 * @param  string $redirect_url  授权成功后重定向的url
	 * @param  string $data  授权成功后带的参数 主要是获取code
	 * @param  string $snsapi  授权类型 snsapi_userinfo 普通授权 能获取到用户信息 snsapi_base 静默授权
	 */
	public static function getOpenId($code){
		$app = Factory::miniProgram(config('my.mini_program'));
		$res = $app->auth->session($code);
		return $res;
	}
	
	
	/**
	 * 获取小程序用户信息
	 * @description 小程序传入 code、iv、encryptedData  先通过code获取 session_key  然后在解码出用户信息
	 */
	public static function getXcxUserInfo($data){
		
		if(empty($data['code'])) throw new \Exception('code不能为空');
		if(empty($data['iv'])) throw new \Exception('iv不能为空');
		if(empty($data['encryptedData'])) throw new \Exception('encryptedData不能为空');
		$app = Factory::miniProgram(config('my.mini_program'));
		try{
			$session = self::getOpenId($data['code']);	//通过code获取 session信息
			//解码用户信息
			$decryptedData = $app->encryptor->decryptData($session['session_key'],$data['iv'],$data['encryptedData']);
		}catch(\Exception $e){
			log::error('小程序获取信息失败:'.print_r($e->getMessage(),true));
		}
		
		return $decryptedData;
	}
	/**
	 * 获取小程序用户信息
	 * @description 小程序传入 code、iv、encryptedData  先通过code获取 session_key  然后在解码出用户信息
	 */
	public static function getXcxUserPhone($data){
		
		if(empty($data['code'])) throw new \Exception('code不能为空');
		if(empty($data['iv'])) throw new \Exception('iv不能为空');
		if(empty($data['encryptedData'])) throw new \Exception('encryptedData不能为空');
		//print_r("code:".$data['code']."\n");
		//print_r("iv:".$data['iv']."\n");
		//print_r("encryptedData:".$data['encryptedData']."\n");
		//exit();
		$app = Factory::miniProgram(config('my.mini_program'));
		try{
			$session = self::getOpenId($data['code']);	//通过code获取 session信息
			//解码用户信息
			$decryptedData = $app->encryptor->decryptPhoneData($data['encryptedData'],$data['iv'],$session['session_key']);
		}catch(\Exception $e){
			log::error('小程序获取信息失败:'.print_r($e->getMessage(),true));
		}
		
		return $decryptedData;
	}
	
    
}
