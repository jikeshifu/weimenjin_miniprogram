<?php
/**
 * 后台登录控制
 * ============================================================================
 * * COPYRIGHT 2016-2019 xhadmin.com , and all rights reserved.
 * * WEBSITE: http://www.xhadmin.com;
 * ----------------------------------------------------------------------------
 * This is not a free software!You have not used for commercial purposes in the
 * premise of the program code to modify and use; and publication does not allow
 * any form of code for any purpose.
 * ============================================================================
 * Author: 寒塘冷月 QQ：274363574
 */
 
namespace app\admin\controller;
use app\admin\service\AuthService;

class Login extends Admin
{
	
    public function index()
    {
		if (!$this->request->isPost()) {
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
            $this->success('登录成功，正在进入系统...', url('admin/Index/index'));
        }
    }
	
	
	/*验证码*/
	public function Verify()
	{
		ob_clean();
	    return captcha();
	}

    /**
     * 退出登录
     */
    public function out()
    {
        session('admin', null);
        $this->success('退出登录成功！', url('admin/Login/index'));
    }
	
}
