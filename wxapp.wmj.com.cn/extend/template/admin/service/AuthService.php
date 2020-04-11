<?php

namespace app\ApplicationName\service;
use \think\facade\Db; 

class AuthService
{

    /**
     * 根据用户名密码，验证用户是否能成功登陆
     * 
     * @param string $user
     * @param string $pwd
     * @throws \Exception
     * @return mixed
     */
    public static function checkLogin($user, $pwd) {
		
		try{
			$where['tempUsername'] = strip_tags(trim($user));
			$pwd = !empty(config('my.password_secrect')) ? strip_tags(trim($pwd)).config('my.password_secrect') : strip_tags(trim($pwd));
			$where['tempPassword']  = md5($pwd);
			$info = Db::name('tablename')->where($where)->find();
			if(!$info){
				throw new \Exception("请检查用户名或者密码");
			}
			
			if(!$info['role']){
				$info['role'] = 1;	
			}
			
			if(!$info['username']){
				$info['username'] = $info['tempUsername'];
			}
			
			session('ApplicationName', $info);
			session('ApplicationName_sign', data_auth_sign($info));
		}catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}

        return true;
    }
    
    
}
