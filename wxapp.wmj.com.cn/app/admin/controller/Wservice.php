<?php 
/*
 module:		服务管理
 create_time:	2021-01-11 23:41:08
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\WserviceService;
use xhadmin\db\Wservice as WserviceDb;

class Wservice extends Admin {


	/*服务管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['wservice_type'] = $this->request->param('wservice_type', '', 'serach_in');
			$where['wservice_name'] = ['like',$this->request->param('wservice_name', '', 'serach_in')];
			$where['wservice_appid'] = ['like',$this->request->param('wservice_appid', '', 'serach_in')];
			$where['wservice_url'] = $this->request->param('wservice_url', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'wservice_id,wservice_type,wservice_name,wservice_icon,wservice_appid,wservice_url,wservice_sort,wservice_status';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'wservice_sort';

			try{
				$res = WserviceService::pageList(formatWhere($where),$limit,$field,$orderby);
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
		$postField = 'wservice_id,wservice_status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['wservice_id']) $this->error('参数错误');
		try{
			WserviceDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('wservice_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			WserviceService::delete(['wservice_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$wservice_id = $this->request->get('wservice_id','','intval');
		if(!$wservice_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(WserviceDb::getInfo($wservice_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

 /*start*/
	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'wservice_type,wservice_name,wservice_icon,wservice_appid,wservice_url,wservice_sort,wservice_status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$data['wservice_icon']='https://'.$_SERVER['HTTP_HOST'].$data['wservice_icon'];
			try {
				WserviceService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$wservice_id = $this->request->get('wservice_id','','intval');
			if(!$wservice_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(WserviceDb::getInfo($wservice_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'wservice_id,wservice_type,wservice_name,wservice_icon,wservice_appid,wservice_url,wservice_sort,wservice_status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			$data['wservice_icon']='https://'.$_SERVER['HTTP_HOST'].$data['wservice_icon'];
			try {
				WserviceService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
    /*end*/



}

