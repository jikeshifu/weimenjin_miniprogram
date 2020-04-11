<?php 
/*
 module:		系统配置
 create_time:	2020-03-19 22:22:34
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;

class ConfigService extends CommonService {


	/*
 	* @Description  修改
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function index($where,$data){
		try{

			$res = Config::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}




}

