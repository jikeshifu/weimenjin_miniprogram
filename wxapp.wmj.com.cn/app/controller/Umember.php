<?php 
/*
 module:		用户管理
 create_time:	2020-08-23 22:15:59
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\UmemberService;
use xhadmin\db\Umember as UmemberDb;

class Umember extends Admin {


	function initialize(){
		if(in_array($this->request->action(),['updateExt','update','delete','view'])){
			$id = $this->request->param('umember_id','','intval');
			$ids = $this->request->param('umember_ids','','intval');
			if($id){
				$info = UmemberDb::getInfo($id);
				if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
			}
			if($ids){
				foreach(explode(',',$ids) as $v){
					$info = UmemberDb::getInfo($v);
					if(session('admin.role') <> 1 && $info['user_id'] <> session('admin.user_id')) $this->error('你没有操作权限');
				}
			}
		}
	}
	/*用户管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['b.nickname'] = ['like',$this->request->param('nickname', '', 'serach_in')];
			$where['b.mobile'] = ['like',$this->request->param('mobile', '', 'serach_in')];
			if(session('admin.role') <> 1){
				$where['a.user_id'] = session('admin.user_id');
			}

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'umember_id desc';

			try{
				$sql = 'select a.*,b.headimgurl,b.nickname,b.mobile from cd_umember as a inner join cd_member as b  where a.member_id=b.member_id';
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

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'member_id,user_id,status,ucreate_time';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				UmemberService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$umember_id = $this->request->get('umember_id','','intval');
			if(!$umember_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(UmemberDb::getInfo($umember_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'umember_id,member_id,user_id,status,ucreate_time';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				UmemberService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('umember_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			UmemberService::delete(['umember_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$umember_id = $this->request->get('umember_id','','intval');
		if(!$umember_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(UmemberDb::getInfo($umember_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

	/*导出*/
	function dumpData(){
		$where = [];
		$where['nickname'] = $this->request->param('nickname', '', 'serach_in');
		$where['mobile'] = $this->request->param('mobile', '', 'serach_in');
		if(session('admin.role') <> 1){
			$where['user_id'] = session('admin.user_id');
		}
		$where['umember_id'] = ['in',$this->request->param('umember_id', '', 'serach_in')];

		$orderby = '';

		try {
			//此处读取前端传过来的 表格勾选的显示字段
			$fieldInfo = [];
			for($j=0; $j<100;$j++){
				$fieldInfo[] = $this->request->param($j);
			}
			$res = UmemberService::dumpData(formatWhere($where),$orderby,filterEmptyArray(array_unique($fieldInfo)));
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}



}

