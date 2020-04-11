<?php 
/*
 module:		钥匙管理
 create_time:	2020-04-08 22:56:16
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;
use xhadmin\db\LockAuth;

class LockAuthService extends CommonService {


	/*
 	* @Description  申请钥匙
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function applyauth($data){
		try{
			$data['create_time'] = time();

			$res = LockAuth::createData($data);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  审核钥匙
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function verifyauth($where,$data){
		try{
			!is_null($data['auth_starttime']) && $data['auth_starttime'] = strtotime($data['auth_starttime']);
			!is_null($data['auth_endtime']) && $data['auth_endtime'] = strtotime($data['auth_endtime']);
			!is_null($data['create_time']) && $data['create_time'] = strtotime($data['create_time']);

			$res = LockAuth::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
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
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  生成分享前的临时钥匙
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function shareauth($data){
		try{
			$data['auth_starttime'] = strtotime($data['auth_starttime']);
			$data['auth_endtime'] = strtotime($data['auth_endtime']);
			$data['create_time'] = time();

			$res = LockAuth::createData($data);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  领取钥匙
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function getkey($where,$data){
		try{

			$res = LockAuth::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}




}

