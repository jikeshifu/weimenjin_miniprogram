<?php 
/*
 module:		开门时段
 create_time:	2020-03-30 02:55:58
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\LocktimesService;
use xhadmin\db\Locktimes as LocktimesDb;

class Locktimes extends Admin {


	/*开门时段*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['locktimesname'] = $this->request->param('locktimesname', '', 'serach_in');
			$where['lock_id'] = $this->request->param('lock_id', '', 'serach_in');

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'locktimes_id,locktimesname,user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute,create_time';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'locktimes_id desc';

			try{
				$res = LocktimesService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'locktimesname,user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute,create_time';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				LocktimesService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$locktimes_id = $this->request->get('locktimes_id','','intval');
			if(!$locktimes_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(LocktimesDb::getInfo($locktimes_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'locktimes_id,locktimesname,user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				LocktimesService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('locktimes_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			LocktimesService::delete(['locktimes_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$locktimes_id = $this->request->get('locktimes_id','','intval');
		if(!$locktimes_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(LocktimesDb::getInfo($locktimes_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}



}

