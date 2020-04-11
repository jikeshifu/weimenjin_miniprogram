<?php 
/**
 *栏目管理
*/

namespace app\admin\controller\Cms;

use cms\service\CatagoryService;
use cms\db\Catagory as CatagoryDb;
use app\admin\controller\Admin;


class Catagory extends Admin {


	/*栏目管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('cms/catagory/index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;
			
			$where = [];
			$limit = ($page-1) * $limit.','.$limit;
			$field = 'a.*,b.title as module_name';
			$orderby = 'sortid asc';

			try{
				$list = CatagoryDb::relateQuery($field,'module_id',$relate_table='menu',$relate_field='menu_id',formatWhere($where),$limit,$orderby);
				$res['count'] = CatagoryDb::relateQueryCount($field,'module_id',$relate_table='menu',$relate_field='menu_id',formatWhere($where));
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$list = formartList(['class_id', 'pid', 'class_name','class_name'],$list);
			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$data = $this->request->post();
		if(!$data['class_id']) $this->error('参数错误');
		try{
			CatagoryDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			$class_id = $this->request->get('class_id','','intval');
			$info = CatagoryDb::getInfo($class_id);
			
			$data['type'] = $info['type'];
			$data['list_tpl'] = $info['list_tpl'];
			$data['detail_tpl'] = $info['detail_tpl'];
			$data['pid'] = $info['class_id'];
			$data['module_id'] = $info['module_id'];
			$data['filepath'] = $info['filepath'];
			
			$this->view->assign('info',$data);
			$default_themes = config('xhadmin.default_themes') ? config('xhadmin.default_themes') : 'index';
			$this->view->assign('tpList',CatagoryService::tplList($default_themes));
			return $this->display('cms/catagory/add');
		}else{
			$data = $this->request->post();
			try {
				CatagoryService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$class_id = $this->request->get('class_id','','intval');
			if(!$class_id) $this->error('参数错误');
			$this->view->assign('info',checkData(CatagoryDb::getInfo($class_id)));
			$default_themes = config('xhadmin.default_themes') ? config('xhadmin.default_themes') : 'index';
			$this->view->assign('tpList',CatagoryService::tplList($default_themes));
			return $this->display('cms/catagory/update');
		}else{
			$data = $this->request->post();
			if($data['class_id'] == $data['pid']) $this->error('当前分类不能作为父分类');
			try {
				CatagoryService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('class_ids', '', 'strip_tags');
		if(!$idx) $this->error('参数错误');
		try{
			$where['class_id'] = explode(',',$idx);
			CatagoryService::delete($where);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	//排序上下移动操作
	function setSort(){
		$class_id  = input('post.class_id', 0, 'intval');
		$type  = input('post.type', 0, 'intval');
		if(empty($class_id) || empty($type)){
			$this->error('参数错误');
		}
		
		try{
			CatagoryService::setSort($class_id,$type);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
		
	}



}

