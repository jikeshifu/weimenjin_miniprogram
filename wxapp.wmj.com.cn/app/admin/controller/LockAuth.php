<?php 
/*
 module:		钥匙管理
 create_time:	2020-04-02 00:39:58
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockAuthService;
use xhadmin\db\LockAuth as LockAuthDb;

class LockAuth extends Admin {


	/*钥匙管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['realname'] = $this->request->param('realname', '', 'serach_in');
			$where['auth_shareability'] = $this->request->param('auth_shareability', '', 'serach_in');
			$where['auth_status'] = $this->request->param('auth_status', '', 'serach_in');
			$where['auth_isadmin'] = $this->request->param('auth_isadmin', '', 'serach_in');
			if(session('admin.role') <> 1){
				$where['user_id'] = session('admin.user_id');
			}
			$where['auth_tmp'] = $this->request->param('auth_tmp', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'lockauth_id,lock_id,member_id,realname,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,auth_status,remark,create_time,auth_openlimit,auth_isadmin,user_id';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'lockauth_id desc';

			try{
				$res = LockAuthService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$postField = 'lockauth_id,auth_shareability,auth_status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['lockauth_id']) $this->error('参数错误');
		try{
			LockAuthDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$lockauth_id = $this->request->get('lockauth_id','','intval');
			if(!$lockauth_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(LockAuthDb::getInfo($lockauth_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'lockauth_id,lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				LockAuthService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('lockauth_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			LockAuthService::delete(['lockauth_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$lockauth_id = $this->request->get('lockauth_id','','intval');
		if(!$lockauth_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LockAuthDb::getInfo($lockauth_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}



}

