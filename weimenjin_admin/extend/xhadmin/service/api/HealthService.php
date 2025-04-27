<?php 
/*
 module:		健康登记
 create_time:	2020-02-28 08:29:31
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;
use xhadmin\db\Health;

class HealthService extends CommonService {


	/*
 	* @Description  添加
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function add($data){
		try{
			//数据验证
			$rule = [
				'name'=>['require'],
				'mobile'=>['regex'=>'/^1[1-9]\d{9}$/'],
				'first_address'=>['require'],
				'position'=>['require'],
				'yiqu'=>['require'],
				'register_type'=>['require','regex'=>'/^[0-9]*$/'],
				'health'=>['require','regex'=>'/^[0-9]*$/'],
			];
			//错误提示消息
			$msg = [
				'name.require'=>'姓名不能为空',
				'mobile.regex'=>'手机号不正确',
				'first_address.require'=>'居住地址不能为空',
				'position.require'=>'当前位置不能为空',
				'yiqu.require'=>'疫区不能为空',
				'register_type.require'=>'登记类型不能为空',
				'register_type.regex'=>'登记类型错误',
				'health.require'=>'健康状况不能为空',
				'health.regex'=>'健康状况格式错误',
			];
			self::validate($rule,$data,$msg);	//开始验证

			$data['yiqu'] = !is_null($data['yiqu']) ? $data['yiqu'] : '2';
			$data['register_type'] = !is_null($data['register_type']) ? $data['register_type'] : '1';
			$data['health'] = !is_null($data['health']) ? $data['health'] : '1';
			$data['create_time'] = time();
			$data['regpoint_id'] = !is_null($data['regpoint_id']) ? $data['regpoint_id'] : '0';

			$res = Health::createData($data);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Health::loadList($where,$limit,$field,$orderby);
			$count = Health::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return ['list'=>$list,'count'=>$count];
	}




}

