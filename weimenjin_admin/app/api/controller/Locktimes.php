<?php 
/*
 module:		开门时段
 create_time:	2020-03-30 03:38:34
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\LocktimesService;
use xhadmin\db\Locktimes as LocktimesDb;
use think\facade\Cache;
use think\facade\Log;

class Locktimes extends Common {



/*start*/
	/**
	* @api {post} /Locktimes/getopentimes 01、查询可开门时段
	* @apiGroup Locktimes
	* @apiVersion 1.0.0
	* @apiDescription  查询可开门时段
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {int}		     lock_id 锁ID 

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
	function getopentimes()
	{
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');
		$lock_id=$this->request->post('lock_id', '', 'serach_in');
        if(empty($lock_id)) return json(['status'=>$this->errorCode,'msg'=>'lock_id不能为空']);
		$where = [];
		$where['lock_id'] = $this->request->post('lock_id', '', 'serach_in');
        $where['type'] =2;
		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'locktimes_id desc';

		try{
			$res = LocktimesService::pageList(formatWhere($where),$limit,$field,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}
/*end*/



}

