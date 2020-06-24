<?php 
/*
 module:		日志管理
 create_time:	2020-04-26 23:09:16
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\LockLogService;
use xhadmin\db\LockLog as LockLogDb;
use think\facade\Cache;
use think\facade\Log;

class LockLog extends Common {



/*start*/
	/**
	* @api {post} /LockLog/getopenlogbylockid 06、根据锁id查询开门记录(管理员)
	* @apiGroup LockLog
	* @apiVersion 1.0.0
	* @apiDescription  根据锁id查询开门记录(管理员)

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {string}		lock_id 锁ID 
	* @apiParam (输入参数：) {string}		[create_time_start] 开门时间开始
	* @apiParam (输入参数：) {string}		[create_time_end] 开门时间结束

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
	function getopenlogbylockid()
	{
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');
        $lock_id = $this->request->post('lock_id', '', 'serach_in');
        if(!$lock_id) return json(['status'=>$this->errorCode,'msg'=>'lock_id不能为空']);
        
		$where = [];
		$where['a.lock_id'] = $lock_id;

		$create_time_start = $this->request->post('create_time_start', '', 'serach_in');
		$create_time_end = $this->request->post('create_time_end', '', 'serach_in');

		$where['a.create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];

		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'locklog_id desc';

		try{
			$sql = 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id';
			$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}

/*end*/

 /*start*/
	/**
	* @api {post} /LockLog/getopenlog 01、获取开门日志
	* @apiGroup LockLog
	* @apiVersion 1.0.0
	* @apiDescription  获取开门日志
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {string}		[member_id] 会员ID 

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
	function getopenlog(){
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');
        $memberid = $this->request->post('member_id', '', 'serach_in');
        if(!$memberid) return json(['status'=>$this->errorCode,'msg'=>'member_id不能为空']);
		$where = [];
		$where['a.member_id'] = $memberid;

		$create_time_start = $this->request->post('create_time_start', '', 'serach_in');
		$create_time_end = $this->request->post('create_time_end', '', 'serach_in');

		$where['a.create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];

		$limit = ($page-1) * $limit.','.$limit;
		$field = 'member_id';
		$orderby = 'locklog_id desc';

		try{
			$sql = 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id';
			$res = \xhadmin\CommonService::loadList($sql,formatWhere($where),$limit,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}
/*end*/



}

