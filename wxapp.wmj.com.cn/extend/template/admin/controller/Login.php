<?php

namespace app\ApplicationName\controller;

use app\ApplicationName\service\AuthService;

class Login extends Admin
{

    
    /**
     * 用户登录
     * @return string
     */
    public function index()
    {
        if ($this->request->isGet()) {
            return $this->display('index');
        } else {
            
            $username = $this->request->post('username', '', 'html_in,trim');
            $password = $this->request->post('password', '', 'html_in,trim');
			$verify = $this->request->post('verify', '', 'html_in,trim');
           
            // 用户信息验证
            try {
				if(!captcha_check($verify)){
					throw new \Exception('验证码错误');
				}
                $res = AuthService::checkLogin($username, $password);
            } catch (\Exception $e) {
                $this->error("登陆失败：{$e->getMessage()}");
            }
            $this->success('登录成功，正在进入系统...', url('ApplicationName/Index/index'));
        }
    }
	
	/*验证码*/
	public function Verify()
	{
	    return captcha();
	}

    /**
     * 退出登录
     */
    public function out()
    {
        session('ApplicationName', null);
        $this->success('退出登录成功！', url('ApplicationName/Login/index'));
    }
	
	
}
