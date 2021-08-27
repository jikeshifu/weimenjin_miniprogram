<?php
/**
 * 菜单管理
 */
 
namespace app\admin\controller;
use app\admin\service\FieldSetService;
use app\admin\service\FieldService;
use app\admin\db\Field as FieldDb;
use app\admin\db\Menu;
use app\admin\db\Application;

class Field extends Admin
{
	
	
    public function index(){
	   
	   if (!$this->request->isAjax()){
		    $menu_id = $this->request->get('menu_id','','intval');
			if($menu_id == config('my.config_module_id')){
				$tpl = 'config_index';
			}else{
				$tpl = $this->getTpl(Menu::getInfo($menu_id)['app_id'],'index');
			}
			$this->view->assign('menu_id',$menu_id);
			return $this->display($tpl);
		}else{
			$limit  = input('post.limit', 0, 'intval');
			$offset = input('post.offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;
			
			$menu_id = $this->request->get('menu_id','','intval');

			$limit = ($page-1) * $limit.','.$limit;
			try{
				$res = FieldService::pageList(['menu_id'=>$menu_id],$limit);
			}catch(\Exception $e){
				exit($e->getMessage());
			}
			$list = $res['list'];
			foreach($list as $key=>$val){
				$typeField = FieldSetService::typeField();
				$fieldInfo = $typeField[$val['type']];
				$list[$key]['type'] = $fieldInfo['name'];
				if(!empty($val['datatype'])){
					$list[$key]['datatype'] = $val['datatype'] !== 'decimal' ? $val['datatype'].'('.$val['length'].')' : $val['datatype'].'('.$val['length'].',2)' ;
				}
			}
			$data['rows']  = $list;
			$data['total'] = $res['count'];

			return json($data);
		}
    }
	
	public function add(){
		if (!$this->request->isPost()){
			$menu_id = $this->request->get('menu_id','','intval');
			$this->view->assign('fieldList',FieldSetService::typeField());
			$this->view->assign('tabList',FieldSetService::tabList($menu_id));
			$this->view->assign('ruleList',FieldSetService::ruleList());
			$this->view->assign('dateList',FieldSetService::dateList());
			$this->view->assign('propertyList',FieldSetService::propertyField());
			if($menu_id == config('my.config_module_id')){
				$tpl = 'config';
			}else{
				$menuInfo = Menu::getInfo($menu_id);
				$tpl = $this->getTpl(Menu::getInfo($menu_id)['app_id'],'info');
			}
			$this->view->assign('menu_id',$menu_id);
			return $this->display($tpl);
		}else{
			$data = $this->request->post();
			$data['sql'] = $this->request->post('sql','','sql_replace');
			try{
				FieldService::saveData('add',$data);
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
			$info = checkData(FieldDb::getInfo($id));
			$menuInfo = Menu::getInfo($info['menu_id']);
			$this->view->assign('fieldList',FieldSetService::typeField());
			$this->view->assign('tabList',FieldSetService::tabList($info['menu_id']));
			$this->view->assign('ruleList',FieldSetService::ruleList());
			$this->view->assign('dateList',FieldSetService::dateList());
			$this->view->assign('propertyList',FieldSetService::propertyField());
			$this->view->assign('info',$info);
			if($menuInfo['menu_id'] == config('my.config_module_id')){
				$tpl = 'config';
			}else{
				$applicationInfo = Application::getInfo($menuInfo['app_id']);
				$tpl = $this->getTpl($menuInfo['app_id'],'info');
			}
			$this->view->assign('menu_id',$info['menu_id']);
			return $this->display($tpl);
		}else{
			$data = $this->request->post();
			$data['sql'] = $this->request->post('sql','','sql_replace');
			try{
				FieldService::saveData('edit',$data);
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
			FieldDb::edit(['id'=>$id,'sortid'=>$sortid]);
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
			FieldService::arrowsort($id,$type);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'设置成功']);
	}
	
	public function delete(){
		$id = $this->request->post('id','','intval');
		if(!$id) $this->error('参数错误');
		try{
			FieldService::delete($id);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'删除成功']);
	}
	
	
	//通过字段type获取当前字段的数据配置
	public function getFieldConfig(){
		$type = $this->request->post('type','','intval');
		$typeField = FieldSetService::typeField();
        $propertyField = FieldSetService::propertyField();
        $typeData = $typeField[$type];
        $property = $propertyField[$typeData['property']];
		
		return json($property);
	}
	
	
	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$data = $this->request->post();
		if(!$data['id']) $this->error('参数错误');
		try{
			FieldDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	
	public function getPy(){
		$fieldname = $this->request->post('fieldname');
		$filed_name_status = !is_null(config('my.filed_name_status')) ? config('my.filed_name_status') : false;
		if($filed_name_status){
			$fieldname = preg_replace('/\s+/', '_', $fieldname);
			$fieldname = substr(\org\Pinyin::output($fieldname, true),0,30);
			return json(['status'=>'00','fieldname'=>$fieldname]);
		}
	}
	
}
