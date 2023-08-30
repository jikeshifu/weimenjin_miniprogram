<?php 
/*
 module:		用户管理
 create_time:	2020-04-29 13:12:58
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\UserService;
use xhadmin\db\User as UserDb;

class User extends Admin {


	/*用户管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['a.user'] = ['like',$this->request->param('user', '', 'serach_in')];
			$where['a.group_id'] = $this->request->param('group_id', '', 'serach_in');
			$where['a.type'] = $this->request->param('type', '', 'serach_in');
			$where['a.status'] = $this->request->param('status', '', 'serach_in');
			$where['a.member_id'] = $this->request->param('member_id', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'a.*,b.name as group_name';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'user_id desc';

			try{
				$list = UserDb::relateQuery($field,'group_id',$relate_table='group',$relate_field='group_id',formatWhere($where),$limit,$orderby);
				$res['count'] = UserDb::relateQueryCount($field,'group_id',$relate_table='group',$relate_field='group_id',formatWhere($where));
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*添加账户*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'name,user,pwd,group_id,type,note,status,create_time';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				UserService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改账户*/
	function update(){
		if (!$this->request->isPost()){
			$user_id = $this->request->get('user_id','','intval');
			if(!$user_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(UserDb::getInfo($user_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'user_id,name,user,group_id,type,note,status,member_id,create_time';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				UserService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*修改密码*/
	function updatePassword(){
		if (!$this->request->isPost()){
			$info['user_id'] = $this->request->get('user_id','','intval');
			$this->view->assign('info',$info);
			return $this->display('updatePassword');
		}else{
			$postField = 'user_id,pwd';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				$data['pwd'] = md5($data['pwd'].config('my.password_secrect'));
				UserDb::edit($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}

	/*删除数据*/
	function delete(){
		$idx =  $this->request->post('user_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			UserService::delete(['user_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*修改状态*/
	function start(){
		$idx =  $this->request->post('user_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			$where['user_id'] = explode(',',$idx);
			UserDb::editWhere($where,['status'=>'1']);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*修改状态*/
	function forbidden(){
		$idx =  $this->request->post('user_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			$where['user_id'] = explode(',',$idx);
			UserDb::editWhere($where,['status'=>'0']);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$user_id = $this->request->get('user_id','','intval');
		if(!$user_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(UserDb::getInfo($user_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}



}

