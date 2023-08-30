<?php

namespace app\api\http\middleware;
use app\api\controller\Jwt;


class JwtAuth
{
	
    public function handle($request, \Closure $next)
    {	
		$token = $request->header('Authorization');
		if(!$token){
			return json(['status'=>config('my.errorCode'),"code"=>101,'msg'=>'token不能为空']);
		}
		if(count(explode('.',$token)) <> 3){
			return json(['status'=>config('my.errorCode'),"code"=>101,'msg'=>'token格式错误']);
		}
		$jwt = Jwt::getInstance();
		$jwt->setIss(config('my.jwt_iss'))->setAud(config('my.jwt_aud'))->setSecrect(config('my.jwt_secrect'))->setToken($token);

		if($jwt->decode()->getClaim('exp') < time()){
			return json(['status'=>config('my.jwtExpireCode'),"code"=>101,'msg'=>'token过期']);
		}
		if($jwt->validate() && $jwt->verify()){
			$request->uid = $jwt->decode()->getClaim('uid');
			return $next($request);
		}else{
			return json(['status'=>config('my.jwtErrorCode'),"code"=>101,'msg'=>'token失效']);
		}
    }
} 