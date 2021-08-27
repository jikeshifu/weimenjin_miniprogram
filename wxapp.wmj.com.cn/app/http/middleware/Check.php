<?php
/**
 * 后台验证权限中间件
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

namespace app\admin\http\middleware;

class Check
{
	
    public function handle($request, \Closure $next)
    {	
		$pathinfo = explode('/',$request->pathinfo());
		$controller = !empty($pathinfo[0]) ? str_replace('.html','',$pathinfo[0]) : 'Index';
		$action = !empty($pathinfo[1]) ? str_replace('.html','',$pathinfo[1]) : 'index';
		$app = app('http')->getName();
		
		$admin = session('admin');
        $userid = session('admin_sign') == data_auth_sign($admin) ? $admin['userid'] : 0;
		
        if( !$userid && ( $app <> 'admin' || $controller <> 'Login' )){
			echo '<script type="text/javascript">window.parent.frames.location.href="'.url('admin/Login/index').'";</script>';exit();
        }
		
		//验证权限
		$url =  "/{$app}/{$controller}/{$action}";
		if(session('admin.role') <> 1 && !in_array($url,config('my.nocheck')) && $action !== 'startImport' && $action !== 'getExtends'){	
			if(!in_array($url,session('admin.nodes'))){
				exit('你没权限访问');
			}	
		}

		$list = db("config")->cache(true,60)->select()->column('data','name');
		config($list,'xhadmin');
        return $next($request);
    }
}