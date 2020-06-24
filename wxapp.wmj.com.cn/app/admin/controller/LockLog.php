<?php 
/*
 module:		开门记录
 create_time:	2020-06-17 11:13:16
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LockLogService;
use xhadmin\db\LockLog as LockLogDb;

class LockLog extends Admin {


	function initialize(){
		if(in_array($this->request->action(),['updateExt','delete','view'])){
			$id = $this->request->param('locklog_id','','intval');
			$ids = $this->request->param('locklog_ids','','intval');
			if($id){
				$info = LockLogDb::getInfo($id);
				if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
			}
			if($ids){
				foreach(explode(',',$ids) as $v){
					$info = LockLogDb::getInfo($v);
					if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
				}
			}
		}
	}
	/*日志管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			if(session('admin.role') <> 1){
				$where['a.user_id'] = session('admin.user_id');
			}
			$where['c.lock_name'] = ['like',$this->request->param('lock_name', '', 'serach_in')];
			$where['b.mobile'] = ['like',$this->request->param('mobile', '', 'serach_in')];
			$where['a.status'] = $this->request->param('status', '', 'serach_in');
			$where['a.type'] = $this->request->param('type', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'locklog_id desc';

			try{
				$sql = 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id';
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

	/*删除*/
	function delete(){
		$idx =  $this->request->post('locklog_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			LockLogService::delete(['locklog_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$locklog_id = $this->request->get('locklog_id','','intval');
		if(!$locklog_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LockLogDb::getInfo($locklog_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

	/*导出*/
	function dumpData(){
		$where = [];
		if(session('admin.role') <> 1){
			$where['a.user_id'] = session('admin.user_id');
		}
		$where['a.lock_name'] = ['like',$this->request->param('lock_name', '', 'serach_in')];
		$where['a.mobile'] = ['like',$this->request->param('mobile', '', 'serach_in')];
		$where['a.status'] = $this->request->param('status', '', 'serach_in');
		$where['a.type'] = $this->request->param('type', '', 'serach_in');
		$where['a.locklog_id'] = ['in',$this->request->param('locklog_id', '', 'serach_in')];

		$orderby = '';

		try {
			$res = LockLogService::dumpData(formatWhere($where),$orderby);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}



}

