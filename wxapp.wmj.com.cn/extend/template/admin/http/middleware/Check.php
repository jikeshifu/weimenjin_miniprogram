<?php

namespace app\ApplicationName\http\middleware;

class Check
{
	
    public function handle($request, \Closure $next)
    {	
		$pathinfo = explode('/',$request->pathinfo());
		$controller = !empty($pathinfo[0]) ? str_replace('.html','',$pathinfo[0]) : 'Index';
		$action = !empty($pathinfo[1]) ? str_replace('.html','',$pathinfo[1]) : 'index';
		$app = app('http')->getName();
		
		$ApplicationName = session('ApplicationName');
        $userid = session('ApplicationName_sign') == data_auth_sign($ApplicationName) ? true : false;
        if( !$userid && ( $app <> 'ApplicationName' || $controller <> 'Login' )){
			echo '<script type="text/javascript">window.parent.frames.location.href="'.url('ApplicationName/Login/index').'";</script>';exit();
        }
		
		//验证权限
		$url =  "/{$app}/{$controller}/{$action}";
		
		foreach(config('my.nocheck') as $val){
			$nocheck[] = str_replace('admin','ApplicationName',$val);
		}

		if(session('ApplicationName.role') <> 1 && !in_array($url,$nocheck) && $action !== 'startImport'){	
			if(!in_array($url,session('ApplicationName.nodes'))){
				exit('你没权限访问');
			}	
		}
		
		$list = db("config")->cache(true,60)->select()->column('data','name');
		config($list,'xhadmin');
		
        return $next($request);
    }
}