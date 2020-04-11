<?php

namespace app\ApplicationName\controller;
use app\BaseController;
use think\App;
use think\View;
use app\admin\db\Config as ConfigDb;
use think\facade\Config;


class Base extends BaseController
{
	
	protected $request;
	protected $app;
	protected $view;
	
	/**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app,View $view)
    {
        $this->app     = $app;
		$this->view     = $view;
        $this->request = $this->app->request;
		$this->initConfig();
    }
	
	//初始化配置文件
	public function initConfig(){
		$list = ConfigDb::loadList();
		Config::set($list,'xhadmin');
		if(config('xhadmin.site_status') == 2){
			exit(config('xhadmin.off_msg'));
		}
		
		//检测终端
		if($this->request->isMobile() && config('xhadmin.mobil_status') == 1){
			$url = $_SERVER['HTTP_HOST'];
			if(config('xhadmin.mobil_domain') && config('xhadmin.mobil_domain') <> $url){
				header('location:http://'.config('xhadmin.mobil_domain'));
			}
			$list['default_themes'] = config('xhadmin.mobil_themes');
			Config::set($list,'xhadmin');
		}
	}
	
	//视图全局过滤
	public function display($tpl){
		$this->filterView();
		return $this->view->fetch($tpl);
	}
	
	public function __call($method, $args)
    {
        return json(['status'=>'01','msg'=>'方法不存在']);
    }
	
	

}
