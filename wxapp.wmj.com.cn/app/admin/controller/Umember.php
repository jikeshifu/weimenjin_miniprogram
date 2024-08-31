<?php
/*
 module:		用户管理
 create_time:	2022-09-24 18:38:47
 author:
 contact:
*/

namespace app\admin\controller;

use xhadmin\service\admin\UmemberService;
use xhadmin\db\Umember as UmemberDb;

class Umember extends Admin {


	function initialize(){
		if(in_array($this->request->action(),['updateExt','authlocks','update','delete','view'])){
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
		$where['umember_id'] = $this->request->param('umember_id', '', 'serach_in');
		$where['nickname'] = ['like',$this->request->param('nickname', '', 'serach_in')];
		$where['mobile'] = ['like',$this->request->param('mobile', '', 'serach_in')];
		if(session('admin.role') <> 1){
			$where['user_id'] = session('admin.user_id');
		}
		$where['realname'] = ['like',$this->request->param('realname', '', 'serach_in')];
		$where['remark'] = ['like',$this->request->param('remark', '', 'serach_in')];
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


/*start*/
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
			$where['b.realname'] = ['like',$this->request->param('realname', '', 'serach_in')];
			$where['b.remark'] = ['like',$this->request->param('remark', '', 'serach_in')];

			$order  = $this->request->post('order', '', 'serach_in');	//排序字段 bootstrap-table 传入
			$sort  = $this->request->post('sort', '', 'serach_in');		//排序方式 desc 或 asc

			$limit = ($page-1) * $limit.','.$limit;
			$field = '';
			$orderby = ($sort && $order) ? $sort.' '.$order : 'umember_id desc';

			try{
				$sql = 'select a.*,b.headimgurl,b.nickname,b.realname,b.remark,b.member_type,b.mobile from cd_umember as a inner join cd_member as b  where a.member_id=b.member_id';
				$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby,'cd_umember');
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


/*start*/
	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$umember_id = $this->request->get('umember_id','','intval');
			if(!$umember_id) $this->error('参数错误');
			try{
			    $memberid = db()->name('umember')->where(['umember_id'=>$umember_id])->column('member_id');
			    $memberinfo = db()->name('member')->where(['member_id'=>$memberid[0]])->column('realname,remark,mobile');
			    $viewdata=checkData(UmemberDb::getInfo($umember_id));
			 //   mlog("viewdata".json_encode($viewdata));
			 //   mlog("viewdata_meminfo".json_encode($memberinfo));
			    $viewdata['realname'] = $memberinfo[0]['realname'];
			    $viewdata['remark'] = $memberinfo[0]['remark'];
			    $viewdata['mobile'] = $memberinfo[0]['mobile'];
			 //   mlog("viewdata1".json_encode($viewdata));
				$this->view->assign('info',$viewdata);

				return $this->display('update');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'umember_id,status,realname,remark,mobile';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
				UmemberService::update($data);
				$member = db()->name('umember')->where(['umember_id'=>$data['umember_id']])->column('member_id');
				$emwhere['member_id']= $member[0];
				$emfield['realname']=$data['realname'];
				$emfield['remark']=$data['remark'];
				$emfield['mobile']=$data['mobile'];
				$emember = \xhadmin\db\Member::editWhere($emwhere,$emfield);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}
/*end*/


/*start*/
	/*删除*/
	function delete(){
		$idx =  $this->request->post('umember_ids', '', 'serach_in');
		if(!$idx) $this->error('参数错误');
		try{
			$umember=explode(',',$idx);
			foreach ($umember as $um)
			{
			    $umret=UmemberDb::getInfo($um);
			    $delwhere['member_id']=$umret['member_id'];
			    $delwhere['user_id']=session('admin.user_id');
			    $retdel = \xhadmin\service\admin\LockAuthService::delete($delwhere);
			}
			UmemberService::delete(['umember_id'=>explode(',',$idx)]);

		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
/*end*/


/*start*/
	/*编辑数据*/
	function authlocks(){
		if (!$this->request->isPost()){
			$umember_id = $this->request->get('umember_id','','intval');
			if(!$umember_id) $this->error('参数错误');
			try{
			    $user_id = session('admin.user_id');
			    $lock = db()->name('lock')->where(['user_id'=>$user_id])->field(['lock_id','lock_name'])->select()->toArray();
			    $info = UmemberDb::getInfo($umember_id);
			    $authlocks = db()->name('lockauth')->where(['member_id'=>$info['member_id'],'user_id'=>$info['user_id']])->column('lock_id');
			    $this->view->assign('lock',$lock);
			    $this->view->assign('authlocks',$authlocks);
				$this->view->assign('info',checkData($info));
				// mlog("authlocks_getinfo:".json_encode(UmemberDb::getInfo($umember_id)));
				return $this->display('authlocks');
			}catch(\Exception $e){
				$this->error($e->getMessage());
			}
		}else{
			$postField = 'umember_id,status,member_id,authlocks';
			$data = $this->request->only(explode(',',$postField),'post',null);
			try {
			    // mlog("authlocks_before:".json_encode($data));
				$elocks=explode(',',$data['authlocks']);
				$delwhere['member_id']=$data['member_id'];
				$delwhere['user_id']=session('admin.user_id');
//				$retdel = \xhadmin\service\admin\LockAuthService::delete($delwhere);
				if ((int)$elocks[0]>1) {

    				   foreach ($elocks as $elockvalue)
    				    {
    				    $authqr['member_id']=$data['member_id'];
    		            $authqr['lock_id']=$elockvalue;
    				    $lockinfo = \xhadmin\db\Lock::getInfo($elockvalue);
    				    $resauthdata=\xhadmin\db\LockAuth::getWhereInfo($authqr);
    				    if (!$resauthdata['auth_isadmin'])
    				    {
    				        //添加钥匙
    						$authda['lock_id']=$elockvalue;
    						$authda['member_id']=$data['member_id'];
    						$authda['auth_member_id']=$lockinfo['member_id'];//
    						$authda['auth_shareability']=0;
    						$authda['auth_sharelimit']=0;
    						$authda['auth_openlimit']=0;
    						$authda['auth_status']=1;
    						$authda['auth_isadmin']=0;
    						$authda['user_id']=session('admin.user_id');
    				        $ret = \xhadmin\service\admin\LockAuthService::lockadd($authda);
    				    }
    				    else
    				    {
    				        return json(['status'=>'01','msg'=>'不能对管理员进行操作']);
    				    }
				}
				}
				//mlog("authlocks_data:".json_encode($authdata));
				unset($data['member_id']);
				//mlog("authlocks_end:".json_encode($data));
				UmemberService::authlocks($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'授权成功']);
		}
	}
/*end*/



}

