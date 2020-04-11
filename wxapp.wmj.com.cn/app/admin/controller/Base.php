<?php

namespace app\admin\controller;
use app\admin\db\Field;
use app\admin\db\Menu;
use app\admin\db\Action;
use app\admin\db\Application;
use xhadmin\db\User;
use xhadmin\db\Group;

class Base extends Admin
{
   
    
    public function password(){
	    if (!$this->request->isPost()){	
			return $this->display('password');
		}else{
			$password = $this->request->post('password', '', 'strval');
			try {
				$dt['user_id'] = session('admin.userid');
				$password = !empty(config('my.password_secrect')) ? trim($password).config('my.password_secrect') : trim($password);
				$dt['pwd'] = md5($password);
				
				User::edit($dt);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
            return json(['status'=>'00','message'=>'修改成功']);
		}
    }
   
	/**
     * 授权管理
     * @return array|string
     */
    public function auth()
    {		
		if (!$this->request->isPost()){
			$id = $this->request->get('group_id', '', 'strval');
			$info = Group::getInfo($id);		
			
			$list = $this->getSubClass(0);
			
			$myAccess = db('access')->where('group_id',$id)->select();
			foreach($myAccess as $val){
				$array[] = $val['purviewval'];
			}
			
			$cmsAccess = include app()->getRootPath().'/app/admin/controller/Cms/config.php';	//cms菜单配置
			$this->view->assign('myAccess',$array);
			$this->view->assign('cmsAccess',$cmsAccess);
			$this->view->assign('list',$list);
			$this->view->assign('id',$id);
			return $this->display('auth');
		}else{			
			$access = $this->request->post('purviewval', '', 'strval');
			$access = explode(',',$access);
			$id = $this->request->post('id', '', 'strval');				
			db('access')->where('group_id',$id)->delete();		
			foreach($access as $val){
				$data = ['purviewval'=>$val,'group_id'=>$id];				
				db('access')->insert($data);								
			}
            $this->success('设置成功');			
		}
		
    }
	
	/**
     * 字体图标选择器
     * @return \think\response\View
     */
    public function icon()
    {
        $field =input('param.field','','strval');
		$this->view->assign('field',$field);
		return $this->display('icon');
    }
	
	//生成树级结构列表 递归的方法
	public function getSubClass($pid){
		$where = [];
		$where['pid'] = $pid;
		$where['app_id'] = 1;
		$list = Menu::loadList($where);
		foreach($list as $key=>$val){
			$map['pid'] = $val['pid'];
			$map['app_id'] = 1;
			$sublist = Menu::loadList($map);;
			$list[$key]['value'] = !empty($val['url']) ? $val['url'] : '/admin/'.getUrlName($val['controller_name']);
			if($sublist){
				$list[$key]['subdata'] = $this->getSubClass($val['menu_id']);
			}
		}
		
		return $list;
	}
	
	//清除缓存 出去session缓存
	public function clearData(){
		$dir = config('my.clear_cache_dir') ? app()->getRootPath().'/runtime/admin' : app()->getRootPath().'/runtime';
		$applicationInfo = Application::getWhereInfo(['app_type'=>3],'app_id desc');
		try{
			deldir($dir) && $applicationInfo['app_dir'] && deldir(app()->getRootPath().'runtime/'.$applicationInfo['app_dir']);
		}catch(\Exception $e){
			return json(['status'=>'01','msg'=>$e->getMessage()]);
		}
		return json(['status'=>'00','msg'=>'删除成功']);
	}
	

}
