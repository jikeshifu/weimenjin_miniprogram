<?php

namespace app\admin\controller;
use app\BaseController;
use think\facade\Config;
use think\facade\Cache;

class Admin extends BaseController
{
	
	//视图全局过滤
	public function display($tpl){
		$this->filterView();
		return $this->view->fetch($tpl);
	}
	
	public function __call($method, $args)
    {
        return json(['status'=>'01','msg'=>'方法不存在']);
    }
	
	protected function getTpl($app_id,$extend){
		$applicationInfo = \app\admin\db\Application::getInfo($app_id);
		switch($applicationInfo['app_type']){
			case 1:
				$tpl = $extend;
			break;
			
			case 2:
				$tpl = 'api_'.$extend;
			break;
			
			case 3:
				$tpl = 'cms_'.$extend;
			break;
		}
		
		return $tpl;
	}
	
}
