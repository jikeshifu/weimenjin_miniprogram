<?php 
/*
 module:		门状态数据
 create_time:	2021-02-22 17:35:59
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\DoorStatusService;
use xhadmin\db\DoorStatus as DoorStatusDb;

class DoorStatus extends Admin {



/*start*/
	/*门状态数据*/
	function index(){
		if (!$this->request->isAjax()){
		    
		    $redis = new \redis();
            $redis->connect('127.0.0.1', 6379);
            $lock_status =  $redis->get('lock_status');
			$this->view->assign('lock_status',$lock_status);
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['a.doorstatus_sn'] = $this->request->param('doorstatus_sn', '', 'serach_in');
			$where['a.lock_name'] = $this->request->param('lock_name', '', 'serach_in');
			$where['a.doorstatus_action'] = $this->request->param('doorstatus_action', '', 'serach_in');

			$doorstatus_time_start = $this->request->param('doorstatus_time_start', '', 'serach_in');
			$doorstatus_time_end = $this->request->param('doorstatus_time_end', '', 'serach_in');

			$where['a.doorstatus_time'] = ['between',[strtotime($doorstatus_time_start),strtotime($doorstatus_time_end)]];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'doorstatus_id desc';

			try{
				$sql = 'select a.*,b.lock_name from cd_doorstatus as a inner join cd_lock as b  where a.doorstatus_sn=b.lock_sn';
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
	/*start*/
	function lock_status(){
	        $redis = new \redis();
            $redis->connect('127.0.0.1', 6379);
          $lock_status =  $redis->get('lock_status');
          print_r($lock_status);
	}
    /*end*/



}

