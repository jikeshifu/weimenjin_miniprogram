<?php 
/*
 module:		钥匙管理
 create_time:	2020-04-08 22:56:16
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\LockAuthService;
use xhadmin\db\LockAuth as LockAuthDb;
use think\facade\Cache;
use think\facade\Log;

class LockAuth extends Common {



/*start*/
	/**
	* @api {post} /LockAuth/applyauth 02、申请钥匙
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  申请钥匙

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				lock_id 锁ID 
	* @apiParam (输入参数：) {string}			member_id 会员ID 
	* @apiParam (输入参数：) {string}			realname 姓名 
	* @apiParam (输入参数：) {string}			remark 备注 
	* @apiParam (输入参数：) {int}				auth_status 审核状态 已审核|1,未审核|0
	* @apiParam (输入参数：) {int}				user_id 管理员ID 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function applyauth(){
		$postField = 'lock_id,member_id,realname,remark,create_time,auth_status,user_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		mlog("isapplylock_postdata".json_encode($data));
		//查询是否已经申请过
		$field='lockauth_id,lock_id,member_id';
		$isapplywhere['member_id']=$data['member_id'];
		$isapplywhere['lock_id']=$data['lock_id'];
		$isapplylock=LockAuthDb::getWhereInfo($isapplywhere,$field);
		if ($isapplylock) {
			mlog("isapplylock".json_encode($isapplylock));
			return json(['status'=>$this->errorCode,'msg'=>'您已经申请过，请等待审核']);
		}
		try {
			$res = LockAuthService::applyauth($data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /LockAuth/verifyauth 03、审核钥匙
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  审核钥匙
	
	* @apiParam (输入参数：) {string}     		lockauth_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				lock_id 锁ID 
	* @apiParam (输入参数：) {string}			member_id 会员ID 
	* @apiParam (输入参数：) {int}				auth_member_id 分享人会员ID 
	* @apiParam (输入参数：) {int}				auth_sharelimit 可分享钥匙数 
	* @apiParam (输入参数：) {int}				auth_openlimit 开门限制次数 
	* @apiParam (输入参数：) {string}			auth_starttime 有效期起始时间 
	* @apiParam (输入参数：) {string}			auth_endtime 有效期结束时间 
	* @apiParam (输入参数：) {int}				auth_isadmin 是否管理员 
	* @apiParam (输入参数：) {int}				auth_shareability 分享权限 开启|1,关闭|0
	* @apiParam (输入参数：) {string}			remark 备注 
	* @apiParam (输入参数：) {string}			create_time 创建时间 
	* @apiParam (输入参数：) {int}				auth_status 审核状态 已审核|1,未审核|0
	* @apiParam (输入参数：) {int}				user_id 管理员ID 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function verifyauth(){
		$postField = 'lockauth_id,lock_id,member_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_isadmin,auth_shareability,remark,create_time,auth_status,user_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lockauth_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
			$where['lockauth_id'] = $data['lockauth_id'];
			$res = LockAuthService::verifyauth($where,$data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /LockAuth/delete 04、删除
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  删除

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}     		lockauth_ids 主键id 注意后面跟了s 多数据删除

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"操作失败"}
	*/
	function delete(){
		$idx =  $this->request->post('lockauth_ids', '', 'serach_in');
		if(empty($idx)) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try{
			$data['lockauth_id'] = explode(',',$idx);
			LockAuthService::delete($data);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>'操作失败']);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /LockAuth/getauthdetailbyid 05、查看数据
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  查看数据
	
	* @apiParam (输入参数：) {string}     		lockauth_id 主键ID

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据详情
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":"201","msg":"没有数据"}
	*/
	function getauthdetailbyid(){
		$data['lockauth_id'] = $this->request->post('lockauth_id','','intval');
		try{
			$field='lockauth_id,lock_id,member_id,auth_member_id,auth_endtime,auth_starttime,auth_shareability,remark,create_time';
			$res  = checkData(LockAuthDb::getWhereInfo($data,$field));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}
/*end*/

 /*start*/
	/**
	* @api {post} /LockAuth/shareauth 06、分享钥匙
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  生成分享前的临时钥匙

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				lock_id 锁ID 
	* @apiParam (输入参数：) {int}				auth_member_id 分享人会员ID 
	* @apiParam (输入参数：) {int}				auth_sharelimit 可分享钥匙数 
	* @apiParam (输入参数：) {int}				auth_openlimit 开门限制次数 
	* @apiParam (输入参数：) {string}			auth_starttime 有效期起始时间 
	* @apiParam (输入参数：) {string}			auth_endtime 有效期结束时间 
	* @apiParam (输入参数：) {int}				auth_shareability 分享权限 开启|1,关闭|0
	* @apiParam (输入参数：) {string}			auth_opentimes 可开时段 
	* @apiParam (输入参数：) {string}			remark 备注 
	* @apiParam (输入参数：) {int}				auth_status 审核状态 已审核|1,未审核|0
	* @apiParam (输入参数：) {int}				user_id 管理员ID 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function shareauth(){
		$postField = 'lock_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_shareability,auth_opentimes,remark,create_time,auth_status,user_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		try {
			$res = LockAuthService::shareauth($data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /LockAuth/getkey 07、领取钥匙
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  领取钥匙
	
	* @apiParam (输入参数：) {string}     		lockauth_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			member_id 会员ID 

	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","msg":"操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function getkey(){
		$postField = 'lockauth_id,member_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lockauth_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		mlog("getkey_lockauth_id:".$data['lockauth_id']);
		mlog("getkey_member_id:".$data['member_id']);
		//查询lockauth_id对应的锁authlock_id
		$authwhere['lockauth_id']=$data['lockauth_id'];
		$field='lockauth_id,lock_id,member_id';
		$resauthdata  = LockAuthDb::getWhereInfo($authwhere,$field);
		//查询是否已经有该锁钥匙
		
		$islockwhere['member_id']=$data['member_id'];
		$islockwhere['lock_id']=$resauthdata['lock_id'];
		$ishavelock=LockAuthDb::getWhereInfo($islockwhere,$field);
		if ($ishavelock['lockauth_id']) 
		{
			return json(['status'=>$this->errorCode,'msg'=>'你已经有该钥匙了']);
		}
		
		if ($resauthdata['member_id']>0) 
		{
			return json(['status'=>$this->errorCode,'msg'=>'钥匙已被其他人领取']);
		}

		try {
			$where['lockauth_id'] = $data['lockauth_id'];
			$updata['member_id']=$data['member_id'];
			$res = LockAuthService::getkey($where,$updata);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}


	/**
	* @api {post} /LockAuth/getauthlistbymemid 01、会员id查询钥匙列表
	* @apiGroup LockAuth
	* @apiVersion 1.0.0
	* @apiDescription  会员id查询钥匙
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {int}		member_id 会员ID 
	
    * @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码 201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.data 返回数据
	* @apiParam (成功返回参数：) {string}     	array.data.list 返回数据列表
	* @apiParam (成功返回参数：) {string}     	array.data.count 返回数据总数
	* @apiSuccessExample {json} 01 成功示例
	* {"status":"200","data":""}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"查询失败"}
	*/
	function getauthlistbymemid(){
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');
		$memberid=$this->request->post('member_id', '', 'serach_in');
        if(!$memberid) return json(['status'=>$this->errorCode,'msg'=>'member_id不能为空']);
		$where = [];
		$where['a.member_id'] = $memberid;

		$limit = ($page-1) * $limit.','.$limit;
		$field = 'a.*,b.*';
		$orderby = 'lockauth_id desc';

		try{
			$res['list'] = LockAuthDb::relateQuery($field,'lock_id',$relate_table='lock',$relate_field='lock_id',formatWhere($where),$limit,$orderby);
			//mlog("LockAuth_getauthlistbymemid_res:".json_encode($res['list'] ));
			$res['count'] = LockAuthDb::relateQueryCount($field,'lock_id',$relate_table='lock',$relate_field='lock_id',formatWhere($where));
			foreach($res['list'] as $key => $value) 
			{
				  //mlog("LockAuth_getauthlistbymemid_res_value:".$value['lock_sn']);
			      $result = wmjHandle($value['lock_sn'], 'lockstate');
			      $res['list'][$key]['online']       = $result['online'];
			       
             }
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}
   /*end*/



}

