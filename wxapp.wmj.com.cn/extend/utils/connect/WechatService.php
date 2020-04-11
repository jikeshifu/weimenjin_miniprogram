<?php

//获取qq用户信息操作

namespace utils\connect;

class WechatService
{
	
	const APPID = 'wx14291d5af03ae978';
	const SECRET = 'de8ad20299cfa214dff29448f9daff';
	
	//获取用户信息
	public static function getUserInfo($callback,$data){		
		if(!isset($data['code'])){
			$keysArr = array(
				"response_type" => "code",
				"appid" => self::APPID,
				"redirect_uri" => $callback,
				"state" => md5(uniqid(rand(), TRUE)),
				"scope" => 'snsapi_login'
			);
			$login_url =  self::combineURL('https://open.weixin.qq.com/connect/qrconnect', $keysArr);
			header('location:'.$login_url);exit();
		}else{
			$keysArr = array(
				"grant_type" => "authorization_code",
				"appid" => self::APPID,
				"redirect_uri" => urlencode($callback),
				"secret" => self::SECRET,
				"code" => $data['code']
			);
			
			$token_url = self::combineURL('https://api.weixin.qq.com/sns/oauth2/access_token', $keysArr);
			$response = self::get_contents($token_url);

			$params = json_decode($response,true);
			
			$keysArr = array(
				"access_token" => $params["access_token"],
				'openid'=> $params["openid"]
			);

			$graph_url = self::combineURL('https://api.weixin.qq.com/sns/userinfo', $keysArr);
			$response = self::get_contents($graph_url);
			$user = json_decode($response,true);
			return $user;
		}
	}
	
	private static function combineURL($baseURL,$keysArr){
        $combined = $baseURL."?";
        $valueArr = array();

        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);
        
        return $combined;
    }
	
	/**
     * get_contents
     * 服务器通过get请求获得内容
     * @param string $url       请求的url,拼接后的
     * @return string           请求返回的内容
     */
    private function get_contents($url){
        if (ini_get("allow_url_fopen") == "1") {
            $response = file_get_contents($url);
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response =  curl_exec($ch);
            curl_close($ch);
        }

        //-------请求为空
        if(empty($response)){
            throw new \Exception('50001');
        }

        return $response;
    }
	
    
}
