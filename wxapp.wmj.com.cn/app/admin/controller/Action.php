<?php

namespace app\admin\controller;
use app\admin\service\ActionService;
use app\admin\service\ActionSetService;
use app\admin\db\Action as ActionDb;
use app\admin\db\Menu;
use app\admin\db\Application;

class Action extends Admin
{
	
	
    public function index(){
	   
	   if (!$this->request->isAjax()){
		    $menu_id = $this->request->get('menu_id','','intval');
		    $menuInfo = Menu::getInfo($menu_id);
			$applicationInfo = Application::getInfo($menuInfo['app_id']);
			$tpl = $applicationInfo['app_type'] == 1 ? 'index' : 'api_index';
			$this->view->assign('menu_id',$menu_id);
			return $this->display($tpl);
		}else{
			$limit  = input('post.limit', 0, 'intval');
			$offset = input('post.offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;
			
			$menu_id = $this->request->get('menu_id','','intval');

			$limit = ($page-1) * $limit.','.$limit;
			try{
				$res = ActionService::pageList(['menu_id'=>$menu_id],$limit);
			}catch(\Exception $e){
				exit($e->getMessage());
			}
			$list = $res['list'];
			$menuInfo = Menu::getInfo($menu_id);
			$applicationInfo = Application::getInfo($menuInfo['app_id']);
			if($applicationInfo['app_type'] == 1){
				$actionList = ActionSetService::actionList();
			}else{
				$actionList = ActionSetService::apiList();
			}
			
			foreach($list as $key=>$val){
				$list[$key]['type'] = $actionList[$val['type']];
			}
			
			$data['rows']  = $list;
			$data['total'] = $res['count'];

			return json($data);
		}
    }
	
	public function add(){
		if (!$this->request->isPost()){
			$menu_id = $this->request->get('menu_id','','intval');
			$menuInfo = Menu::getInfo($menu_id);
			$applicationInfo = Application::getInfo($menuInfo['app_id']);
			$tpl = $applicationInfo['app_type'] == 1 ? 'info' : 'api_info';
			$actionList = $applicationInfo['app_type'] == 1 ? ActionSetService::actionList() : ActionSetService::apiList();
			$this->view->assign('menu_id',$menu_id);
			$this->view->assign('actionList',$actionList);
			$this->view->assign('requestList',ActionSetService::requestList());
			return $this->display($tpl);
		}else{
			$data = $this->request->post();
			$data['sql_query'] = $this->request->post('sql_query','','sql_replace');
			try{
				ActionService::saveData('add',$data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}
	
	//快速生成
	public function fast(){
		if (!$this->request->isPost()){
			$this->view->assign('menu_id',$this->request->param('menu_id'));
			return $this->display('fast');
		}else{
			$data = $this->request->post();
			try{
				ActionService::addFast($data);	
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}
	
	public function update(){
		if (!$this->request->isPost()){
			$id = $this->request->get('id','','intval');
			if(!$id) $this->error('参数错误');
			$actionInfo = ActionDb::getInfo($id);
			$menuInfo = Menu::getInfo($actionInfo['menu_id']);
			$applicationInfo = Application::getInfo($menuInfo['app_id']);
			$tpl = $applicationInfo['app_type'] == 1 ? 'info' : 'api_info';
			$actionList = $applicationInfo['app_type'] == 1 ? ActionSetService::actionList() : ActionSetService::apiList();
			$this->view->assign('actionList',$actionList);
			$this->view->assign('info',$actionInfo);
			$this->view->assign('menu_id',$actionInfo['menu_id']);
			$this->view->assign('requestList',ActionSetService::requestList());
			return $this->display($tpl);
		}else{
			$data = $this->request->post();
			$data['sql_query'] = $this->request->post('sql_query','','sql_replace');
			try{
				ActionService::saveData('edit',$data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
	
	//更新排序
	public function setSort(){
		$id = $this->request->post('id','','intval');
		$sortid = $this->request->post('sortid','','intval');
		if(!$id || !$sortid) $this->error('参数错误');

		try{
			ActionDb::edit(['id'=>$id,'sortid'=>$sortid]);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'修改成功']);
	}
	
	//箭头排序
	public function arrowsort(){
		$id = $this->request->post('id','','intval');
		$type = $this->request->post('type','','intval');		
		if(!$id || !$type) $this->error('参数错误');	
		try{
			ActionService::arrowsort($id,$type);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'设置成功']);
	}
	
	public function delete(){
		$id = $this->request->post('id','','intval');
		if(!$id) $this->error('参数错误');

		try{
			ActionService::delete($id);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'删除成功']);
	}
	
	
	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$data = $this->request->post();
		if(!$data['id']) $this->error('参数错误');
		try{
		ActionDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	public function config(){
		return $this->display('config');
	}
	
}
