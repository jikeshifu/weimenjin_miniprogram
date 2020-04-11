<?php 
/*
 module:		日志管理
 create_time:	2020-03-21 23:31:15
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
        $create_time_start = $this->request->post('create_time', '', 'serach_in');
		$create_time_end = $this->request->post('end_time', '', 'serach_in');

		$where['a.create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
		$limit = ($page-1) * $limit.','.$limit;
		$field = 'a.*,b.nickname,b.headimgurl,b.mobile';
		$orderby = 'locklog_id desc';

		try{
			$res['list'] = LockLogDb::relateQuery($field,'member_id',$relate_table='member',$relate_field='member_id',formatWhere($where),$limit,$orderby);
			$res['count'] = LockLogDb::relateQueryCount($field,'member_id',$relate_table='member',$relate_field='member_id',formatWhere($where));
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}
/*end*/



}

