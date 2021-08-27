<?php 
/*
 module:		健康登记
 create_time:	2020-03-23 14:29:28
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\HealthService;
use xhadmin\db\Health as HealthDb;

class Health extends Admin {


	function initialize(){
		if(in_array($this->request->action(),['update','delete','view'])){
			$id = $this->request->param('health_id','','intval');
			$ids = $this->request->param('health_ids','','intval');
			if($id){
				$info = HealthDb::getInfo($id);
				if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
			}
			if($ids){
				foreach(explode(',',$ids) as $v){
					$info = HealthDb::getInfo($v);
					if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
				}
			}
		}
	}
	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				HealthService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$health_id = $this->request->get('health_id','','intval');
			if(!$health_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(HealthDb::getInfo($health_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'health_id,name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				HealthService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('health_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			HealthService::delete(['health_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$health_id = $this->request->get('health_id','','intval');
		if(!$health_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(HealthDb::getInfo($health_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

	/*导出*/
	function dumpData(){
		$where = [];
		$where['name'] = $this->request->param('name', '', 'serach_in');
		$where['mobile'] = $this->request->param('mobile', '', 'serach_in');
		$where['yiqu'] = $this->request->param('yiqu', '', 'serach_in');
		$where['register_type'] = $this->request->param('register_type', '', 'serach_in');
		$where['health'] = $this->request->param('health', '', 'serach_in');

		$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
		$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

		$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
		if(session('admin.role') <> 1){
			$where['user_id'] = session('admin.user_id');
		}
		$where['health_id'] = ['in',$this->request->param('health_id', '', 'serach_in')];

		$orderby = '';

		try {
			//此处读取前端传过来的 表格勾选的显示字段
			$fieldInfo = [];
			for($j=0; $j<100;$j++){
				$fieldInfo[] = $this->request->param($j);
			}
			$res = HealthService::dumpData(formatWhere($where),$orderby,filterEmptyArray(array_unique($fieldInfo)));
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	/**/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['name'] = $this->request->param('name', '', 'serach_in');
			$where['mobile'] = $this->request->param('mobile', '', 'serach_in');
			$where['yiqu'] = $this->request->param('yiqu', '', 'serach_in');
			$where['register_type'] = $this->request->param('register_type', '', 'serach_in');
			$where['health'] = $this->request->param('health', '', 'serach_in');

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
			if(session('admin.role') <> 1){
				$where['user_id'] = session('admin.user_id');
			}

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'health_id,name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'health_id desc';

			try{
				$res = HealthService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}



}

