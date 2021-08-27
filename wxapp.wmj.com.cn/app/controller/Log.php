<?php 
/*
 module:		登录日志
 create_time:	2020-02-20 21:19:04
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LogService;
use xhadmin\db\Log as LogDb;

class Log extends Admin {


	/*登录日志管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['a.username'] = $this->request->param('username', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'log_id desc';

			try{
				$sql = 'select a.*,b.name as group_name,c.name as nickname from cd_log as a inner join cd_group as b inner join cd_user as c on a.user_id = c.user_id and c.group_id= b.group_id';
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
		$idx =  $this->request->post('log_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			LogService::delete(['log_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

