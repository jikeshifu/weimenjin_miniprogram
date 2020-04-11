<?php 
/**
 *系统配置
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\Config;

class ConfigService extends Commonservice {


	/*
 	* @Description  修改
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function index($data){
		try{
			//数据验证
			$rule = [
					'site_title'=>'require',
					];
			self::validate($rule,$data);
			$res = Config::edit($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

