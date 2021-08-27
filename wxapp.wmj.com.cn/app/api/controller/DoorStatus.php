<?php 
/*
 module:		门状态数据
 create_time:	2021-02-22 16:40:33
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\DoorStatusService;
use xhadmin\db\DoorStatus as DoorStatusDb;
use think\facade\Cache;
use think\facade\Log;

class DoorStatus extends Common {


	/**
	* @api {get} /DoorStatus/index 01、首页数据列表
	* @apiGroup DoorStatus
	* @apiVersion 1.0.0
	* @apiDescription  门状态数据
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {string}		[doorstatus_sn] 序列号 
	* @apiParam (输入参数：) {int}			[doorstatus_action] 状态 打开|1|success,关闭|0|primary
	* @apiParam (输入参数：) {string}		[doorstatus_time_start] 时间开始
	* @apiParam (输入参数：) {string}		[doorstatus_time_end] 时间结束

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
	function index(){
		$limit  = $this->request->get('limit', 20, 'intval');
		$page   = $this->request->get('page', 1, 'intval');

		$where = [];
		$where['doorstatus_sn'] = $this->request->get('doorstatus_sn', '', 'serach_in');
		$where['doorstatus_action'] = $this->request->get('doorstatus_action', '', 'serach_in');

		$doorstatus_time_start = $this->request->get('doorstatus_time_start', '', 'serach_in');
		$doorstatus_time_end = $this->request->get('doorstatus_time_end', '', 'serach_in');

		$where['doorstatus_time'] = ['between',[strtotime($doorstatus_time_start),strtotime($doorstatus_time_end)]];

		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'doorstatus_id desc';

		try{
			$res = DoorStatusService::pageList(formatWhere($where),$limit,$field,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}



/*start*/
	/**
	* @api {post} /DoorStatus/add 02、添加
	* @apiGroup DoorStatus
	* @apiVersion 1.0.0
	* @apiDescription  添加
	* @apiParam (输入参数：) {string}			doorstatus_sn 序列号 
	* @apiParam (输入参数：) {int}				doorstatus_action 状态 打开|1|success,关闭|0|primary
	* @apiParam (输入参数：) {string}			user_id 管理用户 

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
		$postField = 'doorstatus_sn,doorstatus_action,user_id,doorstatus_time';
		$data = $this->request->only(explode(',',$postField),'post',null);
		if(empty($data['doorstatus_sn'])) return json(['status'=>$this->errorCode,'msg'=>'doorstatus_sn不能为空']);
		$lockwhere['lock_sn']=$data['doorstatus_sn'];
		$lockdata=\xhadmin\db\Lock::getWhereInfo($lockwhere);
		$data['user_id']=$lockdata['user_id'];
		try {
		    $redis = new \redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->set('lock_status', time());
			$res = DoorStatusService::add($data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}
/*end*/



}

