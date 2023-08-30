<?php 
/*
 module:		门锁类型
 create_time:	2020-07-10 10:32:01
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockTypeService;
use xhadmin\db\LockType as LockTypeDb;

class LockType extends Admin {


	/*门锁类型*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['locktype_name'] = ['like',$this->request->param('locktype_name', '', 'serach_in')];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'locktype_id,locktype_name';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'locktype_id desc';

			try{
				$res = LockTypeService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'locktype_name';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				LockTypeService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$locktype_id = $this->request->get('locktype_id','','intval');
			if(!$locktype_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(LockTypeDb::getInfo($locktype_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'locktype_id,locktype_name';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				LockTypeService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('locktype_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			LockTypeService::delete(['locktype_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$locktype_id = $this->request->get('locktype_id','','intval');
		if(!$locktype_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LockTypeDb::getInfo($locktype_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}



}

