<?php 
/*
 module:		钥匙管理
 create_time:	2020-04-23 15:35:45
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockAuthService;
use xhadmin\db\LockAuth as LockAuthDb;

class LockAuth extends Admin {


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
			$postField = 'lockauth_id,realname,auth_starttime,auth_endtime,remark,auth_openlimit';
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


/*start*/
	/*钥匙管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['c.lock_name'] = $this->request->param('lock_name', '', 'serach_in');
			$where['a.realname'] = $this->request->param('realname', '', 'serach_in');
			$where['b.mobile'] = $this->request->param('mobile', '', 'serach_in');
			$where['b.nickname'] = $this->request->param('nickname', '', 'serach_in');
			$where['a.auth_shareability'] = $this->request->param('auth_shareability', '', 'serach_in');
			$where['a.auth_status'] = $this->request->param('auth_status', '', 'serach_in');
			if(session('admin.role') <> 1){
				$where['a.user_id'] = session('admin.user_id');
			}

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'lockauth_id desc';

			try{
				$sql = 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_lockauth as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id';
				$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}
/*end*/



}

