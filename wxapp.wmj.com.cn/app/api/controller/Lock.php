<?php 
/*
 module:		门锁列表
 create_time:	2020-04-04 08:30:08
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\LockService;
use xhadmin\db\Lock as LockDb;
use think\facade\Cache;
use think\facade\Log;

class Lock extends Common {


	/**
	* @api {post} /Lock/update 02、修改
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  修改
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {int}				member_id 会员id 
	* @apiParam (输入参数：) {string}			user_id 用户ID 
	* @apiParam (输入参数：) {string}			lock_name 锁名称 (必填) 
	* @apiParam (输入参数：) {string}			lock_sn 序列号 (必填) 
	* @apiParam (输入参数：) {int}				mobile_check 绑定手机 是|1|primary,否|0|info
	* @apiParam (输入参数：) {string}			getkey  
	* @apiParam (输入参数：) {string}			getkey_check  
	* @apiParam (输入参数：) {int}				status 开关 启用|1|success,禁用|0|danger
	* @apiParam (输入参数：) {int}				lock_type 类型 
	* @apiParam (输入参数：) {string}			location 位置 
	* @apiParam (输入参数：) {string}			create_time 添加时间 
	* @apiParam (输入参数：) {string}			lock_qrcode 二维码 
	* @apiParam (输入参数：) {int}				online 状态 在线|1|primary,离线|0|warning

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
	function update(){
		$postField = 'lock_id,member_id,user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time,lock_qrcode,online';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['lock_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
			$where['lock_id'] = $data['lock_id'];
			$res = LockService::update($where,$data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /Lock/view 04、查看数据
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  查看数据
	
	* @apiParam (输入参数：) {string}     		lock_id 主键ID

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
	function view(){
		$data['lock_id'] = $this->request->post('lock_id','','intval');
		try{
			$field='lock_id,user_id,lock_name,lock_sn,mobile_check,location_check,status,lock_type,location,create_time,lock_qrcode,online';
			$res  = checkData(LockDb::getWhereInfo($data,$field));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}


/*start*/
	/**
	* @api {post} /Lock/delete 03、删除
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  删除
	* @apiParam (输入参数：) {string}     		lock_ids 主键id 注意后面跟了s 多数据删除
    * @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
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
		$idx =  $this->request->post('lock_ids', '', 'serach_in');
		if(empty($idx)) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try{
			$data['lock_id'] = explode(',',$idx);
			LockService::delete($data);
			$ret = \xhadmin\service\api\LockAuthService::delete($data);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>'操作失败']);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}
/*end*/


/*start*/
	/**
	* @api {post} /Lock/add 01、添加
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  添加

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			user_id 用户ID 
	* @apiParam (输入参数：) {string}			lock_name 锁名称 (必填) 
	* @apiParam (输入参数：) {string}			lock_sn 序列号 (必填) 
	* @apiParam (输入参数：) {int}				mobile_check 绑定手机 是|1|primary,否|0|info
	* @apiParam (输入参数：) {int}				getkey 领取钥匙 开启|1,关闭|0
	* @apiParam (输入参数：) {int}				getkey_check 审核钥匙 开启|1,关闭|0
	* @apiParam (输入参数：) {int}				status 开关 启用|1|success,禁用|0|danger
	* @apiParam (输入参数：) {int}				lock_type 类型 
	* @apiParam (输入参数：) {string}			location 位置 

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
	function add(){
		$postField = 'member_id,user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,status,lock_type,location,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		try {
			$res = LockService::add($data);
				if ($res) 
			{   $authdata['lock_id']=$res;
				$authdata['member_id']=$data['member_id'];
				$authdata['auth_member_id']=0;
				$authdata['auth_shareability']=1;
				$authdata['auths_sharelimit']=0;
				$authdata['auths_openlimit']=0;
				$authdata['auths_starttime']=time();
				$authdata['auths_endtime']=0;
				$authdata['auths_isadmin']=1;
				$authdata['user_id']=$data['user_id'];
				$ret = \xhadmin\service\api\LockAuthService::add($authdata);
			}
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}
/*end*/

 /*start*/
	/**
	* @api {post} /Lock/opendoor 05、开门
	* @apiGroup Lock
	* @apiVersion 1.0.0
	* @apiDescription  编辑数据
	
	* @apiParam (输入参数：) {int}     		lock_id 主键ID (必填)
    *@apiParam (输入参数：) {int}     		member_id 会员ID (必填)
    * @apiParam (输入参数：) {int}     		user_id  管理员ID (必填)
    * @apiParam (输入参数：) {int}     		type 1扫码开门,2菜单开门,管理员开门 (必填)
    * @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.opendoor_status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.opendoor_status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiParam (需要绑定手机返回参数：) {string}     	array 返回结果集
	* @apiParam (需要绑定手机返回参数：) {string}     	array.opendoor_status 返回错误码 202
	* @apiParam (需要绑定手机返回参数：) {string}     	array.msg 返回需要绑定手机消息
	* @apiParam (需要申请钥匙且审核返回参数：) {string}     	array 返回结果集
	* @apiParam (需要申请钥匙且审核返回参数：) {string}     	array.opendoor_status 返回错误码 203
	* @apiParam (需要申请钥匙且审核返回参数：) {string}     	array.msg 返回需要申请钥匙且审核消息
	* @apiParam (需要申请钥匙返回参数：) {string}     	array 返回结果集
	* @apiParam (需要申请钥匙返回参数：) {string}     	array.opendoor_status 返回错误码 204
	* @apiParam (需要申请钥匙返回参数：) {string}     	array.msg 返回需要申请钥匙消息
	* @apiSuccessExample {json} 01 成功示例
	* {"opendoor_status":"200","msg":"开门成功",'successimg'=>'/uploads/admin/202003/5e758dd0d7d15.png','successadimg'=>'/uploads/admin/202003/5e758e6fe9216.png'}
	* @apiErrorExample {json} 02 失败示例
	* {"opendoor_status":"201","msg":"错误信息"}
	* @apiErrorExample {json} 03 需要绑定手机示例
	* {"opendoor_status":"202","msg":"需要绑定手机号"}
	* @apiErrorExample {json} 04 需要申请钥匙且审核示例
	* {"opendoor_status":"203","msg":"需要申请钥匙且审核"}
	* @apiErrorExample {json} 05 需要申请钥匙示例
	* {"opendoor_status":"204","msg":"需要申请钥匙"}
	*/
	function opendoor()
	{
		
		$lock_id = $this->request->post('lock_id','','intval');
		$member_id = $this->request->post('member_id','','intval');
		$user_id = $this->request->post('user_id','','intval');
		$type = $this->request->post('type','','intval');
		if(!$lock_id) return json(['opendoor_status'=>'101','msg'=>'lock_id不能为空']);
		if(!$member_id) return json(['opendoor_status'=>'101','msg'=>'member_id不能为空']);
		if(!$user_id) return json(['opendoor_status'=>'101','msg'=>'$user_id不能为空']);
		//根据锁id拿到锁信息,根据会员id拿到会员信息，根据会员id和锁id拿到钥匙信息
		$reslookdata=LockDb::getInfo($lock_id);
		$resmemdata=\xhadmin\db\Member::getInfo($member_id);
		$authdata['member_id']=$member_id;
		$authdata['lock_id']=$lock_id;
		$resauthdata=\xhadmin\db\LockAuth::getWhereInfo($authdata);
		//mlog("opendoor_reslookdata:".json_encode($reslookdata));
		//mlog("opendoor_resmemdata:".json_encode($resmemdata));
		//mlog("opendoor_resauthdata:".json_encode($resauthdata));
		//判断设备是否停用
		
		if (!$reslookdata['status']) 
		{
			return json(['opendoor_status'=>'205','msg'=>'设备已停用']);
		}
		
		//判断是否要绑定手机号
		if ($reslookdata['mobile_check']&&!$resmemdata['mobile']) 
		{
			return json(['opendoor_status'=>'202','msg'=>'需要绑定手机号']);
		}
		//判断钥匙是否审核
		if ($reslookdata['applyauth_check']&&!$resauthdata['auth_status']) 
		{
			return json(['opendoor_status'=>'203','msg'=>'需要申请钥匙且审核']);
		}
		//判断钥匙是否有效
		if ($resauthdata&&!$resauthdata['auth_status']) 
		{
			return json(['opendoor_status'=>'201','msg'=>'钥匙已被禁用']);
		}
		//判断钥匙是否过期
		mlog("resauthdata:".$resauthdata['auth_endtime']);
		mlog("now:".time());
		if ($resauthdata&&$resauthdata['auth_starttime']&&$resauthdata['auth_endtime']&&$resauthdata['auth_endtime']<time()) 
		{
			return json(['opendoor_status'=>'201','msg'=>'钥匙已过期']);
		}
		//判断用户申请钥匙自动获得
		if ($reslookdata['applyauth']&&!$resauthdata['auth_status']) 
		{
			return json(['opendoor_status'=>'204','msg'=>'需要申请钥匙']);
		}
		
		try{
				$resdata=LockDb::getInfo($lock_id);
				//mlog("Lock_opendoor_data:".json_encode($resdata));
				if ($resdata) 
				{
					$result = wmjHandle($resdata['lock_sn'], 'openlock');
					$data['member_id']=$member_id;
					$data['lock_id']=$lock_id;
					$data['user_id']=$user_id;
					$data['type']=(int)$type;
					//mlog("Lock_opendoor_wmjHandle:".json_encode($result));
					if ($result['state'])
					{
						$data['status']=1;
						\xhadmin\service\api\LockLogService::add($data);
						return json(['opendoor_status'=>'200','msg'=>'开门成功','successimg'=>$resdata['successimg'],'successadimg'=>$resdata['successadimg']]);
					}
					else {
						$data['status']=0;
						$data['remark']=$result['state_msg'];
						\xhadmin\service\api\LockLogService::add($data);
						return json(['opendoor_status'=>'201','msg'=>$result['state_msg']]);
					}
				}
			}catch(\Exception $e){
				//$this->error($e->getMessage());
				return json(['opendoor_status'=>'201','msg'=>$result['state_msg']]);
			}
	}
/*end*/



}

