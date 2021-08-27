<?php


namespace app\admin\controller;

class Index extends Admin
{
	
    public function index(){
		$menu = $this->getSubMenu(0);
		$cmsMenu = include app()->getRootPath().'/app/admin/controller/Cms/config.php';	//cms菜单配置
		if($cmsMenu){
			foreach($cmsMenu[0]['sub'] as $key=>$val){
				$cmsMenu[0]['sub'][$key]['url'] = $this->getUrl($val['url']);
			}
			$menu = array_merge($cmsMenu,$menu);
		}
		$this->view->assign('menus',$menu);
		return $this->display('index');
    }
	
	
	public function main(){
		return $this->display('main');
	}
	
	
	//生成左侧菜单栏结构列表 递归的方法
	private function getSubMenu($pid){
		$list = db("menu")->where(['status'=>1,'app_id'=>1,'pid'=>$pid])->order('sortid asc')->select()->toArray();
		if($list){
			$menus = [];
			foreach($list as $key=>$val){
				$sublist = db("menu")->where(['status'=>1,'app_id'=>1,'pid'=>$val['menu_id']])->order('sortid asc')->select()->toArray();
				if($sublist){
					$menus[$key]['sub'] = $this->getSubMenu($val['menu_id']);
				}
				$menus[$key]['title'] = $val['title'];
				$menus[$key]['icon'] = !empty($val['menu_icon']) ? $val['menu_icon'] : 'fa fa-clone';
				$menus[$key]['url'] = !empty($val['url']) ? $this->getUrl($val['url']) : $this->getRootPath().'/'.str_replace('/','.',$val['controller_name']);
				$menus[$key]['access_url'] = !empty($val['url']) ? $val['url'] : '/'.app('http')->getName().'/'.str_replace('/','.',$val['controller_name']);		
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
	
}
