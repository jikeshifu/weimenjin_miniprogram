<?php 
/*
 module:		登记点管理
 create_time:	2020-02-28 10:01:07
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\RegpointService;
use xhadmin\db\Regpoint as RegpointDb;

class Regpoint extends Admin {


	/*登记点管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['member_id'] = $this->request->param('member_id', '', 'serach_in');
			if(session('admin.role') <> 1){
				$where['user_id'] = session('admin.user_id');
			}
			$where['regpointname'] = $this->request->param('regpointname', '', 'serach_in');

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'regpoint_id,member_id,user_id,regpointname,regpointqrcode,create_time';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'regpoint_id desc';

			try{
				$res = RegpointService::pageList(formatWhere($where),$limit,$field,$orderby);
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
		$idx =  $this->request->post('regpoint_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			RegpointService::delete(['regpoint_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$regpoint_id = $this->request->get('regpoint_id','','intval');
		if(!$regpoint_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(RegpointDb::getInfo($regpoint_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}



}

