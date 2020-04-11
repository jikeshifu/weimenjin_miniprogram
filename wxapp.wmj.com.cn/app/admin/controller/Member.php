<?php 
/*
 module:		会员管理
 create_time:	2020-04-06 17:03:55
 author:		
 contact:		
*/

namespace app\admin\controller;

use xhadmin\service\admin\MemberService;
use xhadmin\db\Member as MemberDb;

class Member extends Admin {


	/*会员管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where = [];
			$where['nickname'] = $this->request->param('nickname', '', 'serach_in');
			$where['openid'] = $this->request->param('openid', '', 'serach_in');
			$where['ali_user_id'] = $this->request->param('ali_user_id', '', 'serach_in');
			$where['mobile'] = $this->request->param('mobile', '', 'serach_in');
			$where['username'] = $this->request->param('username', '', 'serach_in');

			$create_time_start = $this->request->param('create_time_start', '', 'serach_in');
			$create_time_end = $this->request->param('create_time_end', '', 'serach_in');

			$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
			$where['sex'] = $this->request->param('sex', '', 'serach_in');
			$where['status'] = $this->request->param('status', '', 'serach_in');
			if(session('admin.role') <> 1){
				$where['user_id'] = session('admin.user_id');
			}

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'member_id,nickname,headimgurl,openid,ali_user_id,mobile,username,create_time,sex,status,user_id';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'member_id desc';

			try{
				$res = MemberService::pageList(formatWhere($where),$limit,$field,$orderby);
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
		$postField = 'member_id,status';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(!$data['member_id']) $this->error('参数错误');
		try{
			MemberDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('add');
		}else{
			$postField = 'nickname,headimgurl,openid,mobile,username,password,create_time,sex,status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				MemberService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$member_id = $this->request->get('member_id','','intval');
			if(!$member_id) $this->error('参数错误');
			try{
				$this->view->assign('info',checkData(MemberDb::getInfo($member_id)));
				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'member_id,nickname,headimgurl,openid,mobile,username,create_time,sex,status';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				MemberService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('member_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			MemberService::delete(['member_id'=>explode(',',$idx)]);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*查看数据*/
	function view(){
		$member_id = $this->request->get('member_id','','intval');
		if(!$member_id) $this->error('参数错误');
		try{
			$this->view->assign('info',checkData(MemberDb::getInfo($member_id)));
			return $this->display('view');
		} catch (\Exception $e){
			$this->error($e->getMessage());
		}
	}

	/*修改密码*/
	function resetpassword(){
		if (!$this->request->isPost()){
			$info['member_id'] = $this->request->get('member_id','','intval');
			$this->view->assign('info',$info);
			return $this->display('resetpassword');
		}else{
			$postField = 'member_id,password';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				$data['password'] = md5($data['password'].config('my.password_secrect'));
				MemberDb::edit($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'操作成功']);
		}
	}



}

