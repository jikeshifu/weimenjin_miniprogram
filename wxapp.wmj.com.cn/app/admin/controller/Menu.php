<?php

namespace app\admin\controller;
use app\admin\service\MenuService;
use app\admin\db\Menu as MenuDb;
use app\admin\db\Application;
use think\facade\Db; 

class Menu extends Admin
{
	
	
    public function index(){	   
	   if (!$this->request->isAjax()){
		    $app_id = $this->request->get('app_id','','intval');
			$this->view->assign('app_id',$app_id);
			$list = Db::query('show tables');
			foreach($list as $k=>$v){
				$tableList[] = str_replace(config('database.connections.mysql.prefix'),'',$v['Tables_in_'.config('database.connections.mysql.database')]);
			}
			$no_show_table = ['application','menu','config','action','access','field','exp_level_price'];
			foreach($tableList as $key=>$val){
				if(in_array($val,$no_show_table)){
					unset($tableList[$key]);
				}
			}
			$this->view->assign('tableList',$tableList);
			return $this->display($this->getTpl($app_id,'index'));
		}else{
			$limit  = input('post.limit', 0, 'intval');
			$offset = input('post.offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;
			
			$app_id = $this->request->get('app_id','','intval');

			$limit = ($page-1) * $limit.','.$limit;
			try{
				$res = MenuService::pageList(['app_id'=>$app_id],$limit);
			}catch(\Exception $e){
				exit($e->getMessage());
			}
			$data['rows']  = formartList(['menu_id', 'pid', 'title','cname'],$res['list']);
			$data['total'] = $res['count'];

			return json($data);
		}
    }
	
	public function add(){
		if (!$this->request->isPost()){
			$app_id = $this->request->get('app_id','','intval');
			if(!$app_id) $this->error('参数错误');
			$this->view->assign('menuList',formartList(['menu_id','pid','title','title'],MenuDb::loadList(['app_id'=>$app_id])));
			$this->view->assign('app_id',$app_id);
			return $this->display($this->getTpl($app_id,'info'));
		}else{
			$data = input('post.');
			try{
				MenuService::saveData('add',$data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}
	
	public function update(){
		if (!$this->request->isPost()){
			$menu_id = $this->request->get('menu_id','','intval');
			if(!$menu_id) $this->error('参数错误');
			$info = MenuDb::getInfo($menu_id);
			$this->view->assign('info',$info);
			$this->view->assign('menuList',formartList(['menu_id','pid','title','title'],MenuDb::loadList(['app_id'=>$info['app_id']])));
			$this->view->assign('app_id',$info['app_id']);
			return $this->display($this->getTpl($info['app_id'],'info'));
		}else{
			$data = input('post.');
			try{
				MenuService::saveData('edit',$data);
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
			MenuDb::edit(['menu_id'=>$id,'sortid'=>$sortid]);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'修改成功']);
	}
	
	//箭头排序
	public function arrowsort(){
		$id = $this->request->post('menu_id','','intval');
		$type = $this->request->post('type','','intval');		
		if(!$id || !$type) $this->error('参数错误');	
		try{
			MenuService::arrowsort($id,$type);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'设置成功']);
	}
	
	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$data = $this->request->post();
		if(!$data['menu_id']) $this->error('参数错误');
		try{
			MenuDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	//卸载业务模块
	public function delete(){
		$menu_id = $this->request->post('menu_id','','intval');
		if(!$menu_id) $this->error('参数错误');
		
		try{
			$res = MenuService::delete($menu_id);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'删除成功']);
	}
	
	//复制菜单
	public function copyMenu(){
		$app_id  = $this->request->post('app_id', '', 'intval');
		$menu_id  = $this->request->post('menu_id', '', 'intval');
		
		if(!$app_id || !$menu_id){
			return json(['status'=>'01','msg'=>'参数错误']);
		}	
		try{
			$menuInfo = MenuDb::getInfo($menu_id);
			
			$menuInfo['table_status'] = 0;
			$table_name = $menuInfo['table_name'];
			
			if($menuInfo['app_id'] == $app_id){
				$menuInfo['table_name'] = 'ext_'.$menuInfo['table_name'];
				$menuInfo['controller_name'] = $menuInfo['controller_name'].'Ext';
				$menuInfo['table_status'] = 1;
			}
			$target_appid = $menuInfo['app_id'];
			$menuInfo['app_id'] = $app_id;
			

			$menuInfo['pid'] = 0;
			unset($menuInfo['menu_id']);
			
			$res = MenuDb::createData($menuInfo);
			
			$fieldList = \app\admin\db\Field::loadList(['menu_id'=>$menu_id]);
			if($fieldList){
				foreach($fieldList as $key=>$val){
					unset($val['id']);
					$val['menu_id'] = $res;
					if($target_appid == $app_id){
						$val['is_field'] = 1;
					}else{
						$val['is_field'] = 0;
					}
					\app\admin\db\Field::createData($val);
				}
			}
			
			$applicationInfo = Application::getInfo($app_id);
			
			$actionList = \app\admin\db\Action::loadList(['menu_id'=>$menu_id]);
			if($actionList){
				foreach($actionList as $key=>$val){
					unset($val['id']);
					$val['menu_id'] = $res;
					$val['log_status'] = 1;
					if($applicationInfo['app_type'] == 2 && $val['type'] <> 6){
						$val['remark'] = '';
					}
					if($applicationInfo['app_type'] == 1){
						\app\admin\db\Action::createData($val);
					}elseif($applicationInfo['app_type'] == 2){
						if($val['type'] <> 16){
							\app\admin\db\Action::createData($val);
						}
					}	
				}
			}
			if($applicationInfo['app_type'] == 1){
				db()->execute('CREATE TABLE '.config('database.connections.mysql.prefix').'ext_'.$table_name.' SELECT * FROM '.config('database.connections.mysql.prefix').$table_name.' WHERE 1=2');
				db()->execute("ALTER TABLE ".config('database.connections.mysql.prefix')."ext_{$table_name} ADD PRIMARY KEY (  `".$menuInfo['pk_id']."` )");
				db()->execute("ALTER TABLE ".config('database.connections.mysql.prefix')."ext_{$table_name} CHANGE {$menuInfo['pk_id']} {$menuInfo['pk_id']} int(11) COMMENT '编号' DEFAULT NULL AUTO_INCREMENT");
			}
			
		}catch(\Exception $e){
			return json($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	
	//通过数据表直接生成模块
	public function createModuleByTable(){
		try{
			
			$table_name = $this->request->post('table_name');
			if(!$table_name){
				return json(['status'=>'01','msg'=>'请选择数据表']);
			}
			
			$list = db()->query('show full columns from '.config('database.connections.mysql.prefix').$table_name);
			if(!$list){
				return json(['status'=>'01','msg'=>'数据表不存在']);
			}
			
			foreach($list as $key=>$val){
				if($val['Extra'] == 'auto_increment'){
					$pk_id = $val['Field'];
				}
			}
			
			//第一步创建菜单
			$menu['controller_name'] = str_replace('_','',$table_name);
			$menu['title']	= $table_name;
			$menu['table_name'] = $table_name;
			$menu['pk_id'] = $pk_id;
			$menu['is_create'] = 1;
			$menu['table_status'] = 0;
			$menu['status'] = 1;
			$menu['app_id'] = 1;
			
			$menu_id = MenuService::saveData('add',$menu);
			
			//第二步创建字段
			foreach($list as $key=>$val){
				if($val['Extra'] <> 'auto_increment'){
					$field['menu_id'] = $menu_id;
					$field['name'] = !empty($val['Comment']) ? $val['Comment'] : $val['Field'];
					$field['field'] = $val['Field'];
					$field['type'] = 1;
					$field['list_show'] = 1;
					$field['search_show'] = 1;
					$field['search_type'] = 0;
					$field['is_post'] = 1;
					$field['is_field'] = 0;
					$field['align'] = 'center';
					$res = Db::name('field')->insertGetId($field);
					if($res){
						Db::name('field')->where('id',$res)->update(['sortid'=>$res]);
					}
				}
			}
				
			//第三部创建方法
			$action['actions'] = '添加|add|3|fa fa-plus,修改|update|4|fa fa-pencil,删除|delete|5|fa fa-trash,查看数据|view|15|fa fa-plus';
			$action['menu_id'] = $menu_id;
			\app\admin\service\ActionService::addFast($action);

		}catch(\Exception $e){
			return json(['status'=>'01','msg'=>$e->getMessage()]);
		}
		return json(['status'=>'00','menu_id'=>$menu_id,'msg'=>'操作成功']);
	}
	
	
}
