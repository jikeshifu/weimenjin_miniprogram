<?php 
/*
 module:		用户管理
 create_time:	2020-03-20 23:43:44
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\UserService;
use xhadmin\db\User as UserDb;
use think\facade\Cache;
use think\facade\Log;

class User extends Common {


	/**
	* @api {post} /User/update 01、修改
	* @apiGroup User
	* @apiVersion 1.0.0
	* @apiDescription  修改账户
	
	* @apiParam (输入参数：) {string}     		user_id 主键ID (必填)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (输入参数：) {string}			name 真实姓名 (必填) 
	* @apiParam (输入参数：) {string}			user 用户名 (必填) 
	* @apiParam (输入参数：) {string}			group_id 所属分组 (必填) 
	* @apiParam (输入参数：) {int}				type 类别 超级管理员|1|success,普通管理员|2|warning
	* @apiParam (输入参数：) {string}			note 备注 
	* @apiParam (输入参数：) {int}				status 状态 正常|1|primary,禁用|0|danger
	* @apiParam (输入参数：) {int}				member_id 会员ID 
	* @apiParam (输入参数：) {string}			create_time 创建时间 

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
		$postField = 'user_id,name,user,group_id,type,note,status,member_id,create_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['user_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
			$where['user_id'] = $data['user_id'];
			$res = UserService::update($where,$data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /User/updatePassword 02、修改密码
	* @apiGroup User
	* @apiVersion 1.0.0
	* @apiDescription  修改密码
	
	* @apiParam (输入参数：) {string}     		user_id 主键ID
	* @apiParam (输入参数：) {string}     		pwd 新密码(必填)
	* @apiParam (输入参数：) {string}     		repwd 重复密码(必填)

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
	function updatePassword(){
		$postField = 'user_id,pwd,repwd';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['user_id'])) return json(['status'=>$this->errorCode,'msg'=>'参数错误']);
		try {
			$where['user_id'] = $data['user_id'];
			$res = UserService::updatePassword($where,$data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /User/view 03、查询管理员
	* @apiGroup User
	* @apiVersion 1.0.0
	* @apiDescription  查询管理员
	
	* @apiParam (输入参数：) {string}     		user_id 主键ID

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
	function view(){
		$data['user_id'] = $this->request->post('user_id','','intval');
		try{
			$res  = checkData(UserDb::getWhereInfo($data['user_id']));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}

	/*start*/
	/**
	* @api {post} /User/adduser 00、添加后台管理员
	* @apiGroup User
	* @apiVersion 1.0.0
	* @apiDescription  创建数据
	* 
	* @apiParam (输入参数：) {string}			name 真实姓名 (必填) 
	* @apiParam (输入参数：) {string}			user 用户名 (必填) 
	* @apiParam (输入参数：) {string}			pwd 密码 (必填) 
	* @apiParam (输入参数：) {string}			member_id 会员id (必填) 
	* 
    * @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"
	* @apiParam (失败返回参数：) {object}     	array 返回结果集
	* @apiParam (失败返回参数：) {string}     	array.status 返回错误码  201
	* @apiParam (失败返回参数：) {string}     	array.msg 返回错误消息
	* @apiParam (成功返回参数：) {string}     	array 返回结果集
	* @apiParam (成功返回参数：) {string}     	array.status 返回错误码 200
	* @apiParam (成功返回参数：) {string}     	array.msg 返回成功消息
	* @apiSuccessExample {json} 01 成功示例
	* {"status": "200", "user_id": "23", "msg": "操作成功"}
	* @apiErrorExample {json} 02 失败示例
	* {"status":" 201","msg":"操作失败"}
	*/
	function adduser(){
		$postField = 'name,user,pwd,member_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		$data['group_id']=7;
		$data['type']=2;
		$data['status']=1;
		$data['create_time']=time();
		try {
			$res = UserService::adduser($data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'user_id'=>$res,'msg'=>'操作成功']);
	}
   /*end*/



}

