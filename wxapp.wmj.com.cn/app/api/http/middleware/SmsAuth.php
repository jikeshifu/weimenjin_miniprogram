<?php

//短信验证中间件

namespace app\api\http\middleware;
use think\facade\Cache;

class SmsAuth
{
	
	//短信验证
    public function handle($request, \Closure $next)
    {	
		$verify_id = $request->param('verify_id','','strip_tags,trim');	//验证ID
		$verify	= $request->param('verify','','strip_tags,trim');	//验证码
		$mobile	= $request->param('mobile','','strip_tags,trim');	//验证手机号
		if(empty($verify_id) || empty($verify)){
			return json(['status'=>config('my.errorCode'),'msg'=>'短信验证ID或者验证码不能为空']);
		}
		$cacheData = Cache::get($verify_id);
		if($cacheData['code'] <> $verify){
			return json(['status'=>config('my.errorCode'),'msg'=>'验证码错误或者已过期']);
		}
		
		if($cacheData['mobile'] <> $mobile){
			return json(['status'=>config('my.errorCode'),'msg'=>'手机号与验证不一致']);
		}
		
		return $next($request);	
		Cache::delete($verify_id);	//操作完成删除验证码缓存
    }
} 