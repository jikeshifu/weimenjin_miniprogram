<?php 
/*
 module:		分组管理
 create_time:	2020-02-20 21:19:02
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\GroupService;
use xhadmin\db\Group as GroupDb;

class Group extends Admin {


	/*分组管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['group_id'] = $this->request->param('group_id', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'group_id,name,status,role';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'group_id desc';

			try{
				$res = GroupService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*添加分组*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'name,status,role';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				GroupService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改分组*/
	function update(){
		if (!$this->request->isPost()){
			$group_id = $this->request->get('group_id','','intval');
			if(!$group_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(GroupDb::getInfo($group_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'group_id,name,status,role';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				GroupService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*禁用*/
	function forbidden(){
		$idx =  $this->request->post('group_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			$where['group_id'] = explode(',',$idx);
			GroupDb::editWhere($where,['status'=>'0']);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*启用*/
	function start(){
		$idx =  $this->request->post('group_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			$where['group_id'] = explode(',',$idx);
			GroupDb::editWhere($where,['status'=>'10']);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

