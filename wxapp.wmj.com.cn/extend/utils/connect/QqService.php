<?php

//获取qq用户信息操作

namespace utils\connect;

class QqService
{
	
	const APPID = '101176864';
	const APPKEY = 'a49f5bf5b97be84d9f41b1e1886b4a';
	
	//获取用户信息
	public static function getUserInfo($callback,$data){		
		if(!isset($data['code'])){
			$keysArr = array(
				"response_type" => "code",
				"client_id" => self::APPID,
				"redirect_uri" => $callback,
				"state" => md5(uniqid(rand(), TRUE)),
				"scope" => 'get_user_info'
			);
			$login_url =  self::combineURL('https://graph.qq.com/oauth2.0/authorize', $keysArr);
			header('location:'.$login_url);exit();
		}else{
			$keysArr = array(
				"grant_type" => "authorization_code",
				"client_id" => self::APPID,
				"redirect_uri" => urlencode($callback),
				"client_secret" => self::APPKEY,
				"code" => $_GET['code']
			);
			
			$token_url = self::combineURL('https://graph.qq.com/oauth2.0/token', $keysArr);
			$response = self::get_contents($token_url);
			
			if(strpos($response, "callback") !== false){

				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				$msg = json_decode($response);

				if(isset($msg->error)){
					throw new \Exception($msg->error_description);
				}
			}

			$params = array();
			parse_str($response, $params);
			
			//拿用户openid
			$keysArr = array(
				"access_token" => $params["access_token"]
			);

			$graph_url = self::combineURL('https://graph.qq.com/oauth2.0/me', $keysArr);
			$response = self::get_contents($graph_url);

			if(strpos($response, "callback") !== false){

				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response = substr($response, $lpos + 1, $rpos - $lpos -1);
			}

			$user = json_decode($response);
			if(isset($user->error)){
				throw new \Exception($user->error_description);
			}

			$keysArr = array(
				"access_token" => $params["access_token"],
				'oauth_consumer_key' => self::APPID,
				'openid'=> $user->openid,
				'format'=>'json'
			);
			
			$get_user_url = self::combineURL('https://graph.qq.com/user/get_user_info', $keysArr);
			$response = self::get_contents($get_user_url);
			$response = json_decode($response,true);
			$response['openid'] = $user->openid;
			return $response;
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
