<?php 
/*
 module:		服务管理
 create_time:	2021-01-11 23:53:57
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\WserviceService;
use xhadmin\db\Wservice as WserviceDb;
use think\facade\Cache;
use think\facade\Log;

class Wservice extends Common {


 /*start*/
	/**
	* @api {post} /Wservice/index 01、服务列表
	* @apiGroup Wservice
	* @apiVersion 1.0.0
	* @apiDescription  服务管理
	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {int}			[wservice_type] 类型 内部小程序|1,外部小程序|2,外部页面|3
	* @apiParam (输入参数：) {string}		[wservice_name] 名称 
	* @apiParam (输入参数：) {string}		[wservice_appid] appid 
	* @apiParam (输入参数：) {string}		[wservice_url] url 

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
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');

		$where = [];
		$where['wservice_type'] = $this->request->post('wservice_type', '', 'serach_in');
		$where['wservice_name'] = ['like',$this->request->post('wservice_name', '', 'html_in,trim')];
		$where['wservice_appid'] = ['like',$this->request->post('wservice_appid', '', 'html_in,trim')];
		$where['wservice_url'] = $this->request->post('wservice_url', '', 'serach_in');
        $where['wservice_status'] =1;
		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'wservice_sort';

		try{
			$res = WserviceService::pageList(formatWhere($where),$limit,$field,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}
    /*end*/



}

