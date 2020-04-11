<?php

namespace app\ApplicationName\controller;

class Index extends Admin
{
	
    public function index(){
		$this->view->assign('menus',$this->getSubMenu(0));
		return $this->display('index');
    }
	
	
	public function main(){
		return $this->display('main');
	}
	
	
	//生成左侧菜单栏结构列表 递归的方法
	public function getSubMenu($pid){
		$list = db("menu")->where(['status'=>1,'app_id'=>appId,'pid'=>$pid])->order('sortid asc')->select()->toArray();
		if($list){
			$menus = [];
			foreach($list as $key=>$val){
				$sublist = db("menu")->where(['status'=>1,'app_id'=>appId,'pid'=>$val['menu_id']])->order('sortid asc')->select()->toArray();
				if($sublist){
					$menus[$key]['sub'] = $this->getSubMenu($val['menu_id']);
				}
				$menus[$key]['title'] = $val['title'];
				$menus[$key]['icon'] = !empty($val['menu_icon']) ? $val['menu_icon'] : 'fa fa-clone';
				$menus[$key]['url'] = !empty($val['url']) ? $this->getUrl($val['url']) : $this->getRootPath().'/'.$this->getUrlName($val['controller_name']);		
			}
			return $menus;
		}	
	}
	
	//判断当前应用是否绑定了域名
	private function getRootPath(){
		$domains = config('app.domain_bind');
		if(in_array(app('http')->getName(),$domains)){
			$ctxPathUrl = '';
		}else{
			$ctxPathUrl = '/'.getKeyByVal(config('app.app_map'),app('http')->getName());
		}
		
		return $ctxPathUrl;
	}
	
	private function getUrl($url){
		$domains = config('app.domain_bind');
		if(in_array(app('http')->getName(),$domains)){
			return str_replace('/'.app('http')->getName(),'',$url);
		}else{
			return str_replace(app('http')->getName(),getKeyByVal(config('app.app_map'),app('http')->getName()),$url);
		}	
	}
	
	//多级控制器获取url名称
	private function getUrlName($controller_name){
		if($controller_name && strpos($controller_name,'/') > 0){
			$controller_name = str_replace('/','.',$controller_name);
		}
		return $controller_name;
	}
	
	
}
