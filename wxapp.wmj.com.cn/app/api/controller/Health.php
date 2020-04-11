<?php 
/*
 module:		健康登记
 create_time:	2020-02-28 08:29:31
 author:		
 contact:		
*/

namespace app\api\controller;

use xhadmin\service\api\HealthService;
use xhadmin\db\Health as HealthDb;
use think\facade\Cache;
use think\facade\Log;

class Health extends Common {


	/**
	* @api {post} /Health/add 01、添加
	* @apiGroup Health
	* @apiVersion 1.0.0
	* @apiDescription  添加
	* @apiParam (输入参数：) {string}			name 姓名 (必填) 
	* @apiParam (输入参数：) {string}			mobile 手机号 手机号
	* @apiParam (输入参数：) {string}			first_address 居住地址 (必填) 第一居住地址
	* @apiParam (输入参数：) {string}			second_address 第二居住地址 第二居住地址
	* @apiParam (输入参数：) {string}			position 当前位置 (必填) 
	* @apiParam (输入参数：) {string}			job 工作或学习单位 工作或学习单位
	* @apiParam (输入参数：) {int}				yiqu 疫区 (必填) 30日内是否来自疫区,1是,2否
	* @apiParam (输入参数：) {int}				register_type 登记类型 (必填) 登记类型默认1村居,2乡镇社区,3区县,4交通运输,5校园
	* @apiParam (输入参数：) {int}				health 健康状况 (必填) 健康状况默认1健康,2异常,3其他
	* @apiParam (输入参数：) {string}			manyou 漫游地截图 漫游地截图
	* @apiParam (输入参数：) {string}			txz 证明图片 证明图片
	* @apiParam (输入参数：) {string}			lat 经度 
	* @apiParam (输入参数：) {string}			lng 纬度 
	* @apiParam (输入参数：) {string}			user_id 所属用户 
	* @apiParam (输入参数：) {string}			openid openid 
	* @apiParam (输入参数：) {int}				regpoint_id 登记点ID 

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
		$postField = 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id';
		$data = $this->request->only(explode(',',$postField),'post',null);
		try {
			$res = HealthService::add($data);
		} catch (\Exception $e) {
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		return json(['status'=>$this->successCode,'data'=>$res,'msg'=>'操作成功']);
	}

	/**
	* @api {post} /Health/list 02、查看数据列表
	* @apiGroup Health
	* @apiVersion 1.0.0
	* @apiDescription  查看数据列表

	* @apiHeader {String} Authorization 用户授权token
	* @apiHeaderExample {json} Header-示例:
	* "Authorization: eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOjM2NzgsImF1ZGllbmNlIjoid2ViIiwib3BlbkFJZCI6MTM2NywiY3JlYXRlZCI6MTUzMzg3OTM2ODA0Nywicm9sZXMiOiJVU0VSIiwiZXhwIjoxNTM0NDg0MTY4fQ.Gl5L-NpuwhjuPXFuhPax8ak5c64skjDTCBC64N_QdKQ2VT-zZeceuzXB9TqaYJuhkwNYEhrV3pUx1zhMWG7Org"

	* @apiParam (输入参数：) {int}     		[limit] 每页数据条数（默认20）
	* @apiParam (输入参数：) {int}     		[page] 当前页码
	* @apiParam (输入参数：) {string}		[name] 姓名 
	* @apiParam (输入参数：) {string}		[mobile] 手机号 手机号
	* @apiParam (输入参数：) {string}		[position] 当前位置 
	* @apiParam (输入参数：) {string}		[create_time_start] 创建时间开始
	* @apiParam (输入参数：) {string}		[create_time_end] 创建时间结束
	* @apiParam (输入参数：) {string}		[openid] openid 

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
	function list(){
		$limit  = $this->request->post('limit', 20, 'intval');
		$page   = $this->request->post('page', 1, 'intval');

		$where = [];
		$where['name'] = $this->request->post('name', '', 'serach_in');
		$where['mobile'] = $this->request->post('mobile', '', 'serach_in');
		$where['position'] = $this->request->post('position', '', 'serach_in');

		$create_time_start = $this->request->post('create_time_start', '', 'serach_in');
		$create_time_end = $this->request->post('create_time_end', '', 'serach_in');

		$where['create_time'] = ['between',[strtotime($create_time_start),strtotime($create_time_end)]];
		$where['openid'] = $this->request->post('openid', '', 'serach_in');

		$limit = ($page-1) * $limit.','.$limit;
		$field = '*';
		$orderby = 'health_id desc';

		try{
			$res = HealthService::pageList(formatWhere($where),$limit,$field,$orderby);
		}catch(\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}

		return json(['status'=>$this->successCode,'data'=>htmlOutList($res)]);
	}


	/**
	* @api {post} /Health/view 03、查看数据详情页
	* @apiGroup Health
	* @apiVersion 1.0.0
	* @apiDescription  查看数据
	
	* @apiParam (输入参数：) {string}     		health_id 主键ID

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
		$data['health_id'] = $this->request->post('health_id','','intval');
		try{
			$field='health_id,name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid';
			$res  = checkData(HealthDb::getWhereInfo($data,$field));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}

 /*start*/
	/**
	* @api {post} /Health/viewrecently 04、根据openid获取最近填写的记录
	* @apiGroup Health
	* @apiVersion 1.0.0
	* @apiDescription  查看数据
	
	* @apiParam (输入参数：) {string}     		openid openid

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
	function viewrecently(){
		$data['openid'] = $this->request->post('openid');
		try{
			$res = checkData(HealthDb::query("select * from cd_health where openid ='".$data['openid']."' ORDER BY create_time DESC LIMIT 0,1;"));
		}catch (\Exception $e){
			return json(['status'=>$this->errorCode,'msg'=>$e->getMessage()]);
		}
		Log::info('接口输出：'.print_r($res,true));
		return json(['status'=>$this->successCode,'data'=>$res]);
	}
    /*end*/



}

