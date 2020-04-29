<?php 
/*
 module:		钥匙管理
 create_time:	2020-04-23 15:35:45
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\LockAuth;

class LockAuthService extends CommonService {


	/*
 	* @Description  添加
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function add($data){
		try{
			$data['auth_starttime'] = strtotime($data['auth_starttime']);
			$data['auth_endtime'] = strtotime($data['auth_endtime']);
			$data['create_time'] = time();

			$res = LockAuth::createData($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  修改
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($data){
		try{
			$data['auth_starttime'] = strtotime($data['auth_starttime']);
			$data['auth_endtime'] = strtotime($data['auth_endtime']);

			$res = LockAuth::edit($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  删除
 	* @param (输入参数：)  {array}        where 删除条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function delete($where){
		try{
			$res = LockAuth::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

