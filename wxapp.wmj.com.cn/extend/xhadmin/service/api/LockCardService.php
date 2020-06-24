<?php 
/*
 module:		卡管理
 create_time:	2020-06-07 01:10:35
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;
use xhadmin\db\LockCard;

class LockCardService extends CommonService {


	/*
 	* @Description  添加钥匙下的卡
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function addauthcard($data){
		try{
			$data['lockcard_endtime'] = strtotime($data['lockcard_endtime']);
			$data['lockcard_createtime'] = time();

			$res = LockCard::createData($data);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  更新卡
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function updatecard($where,$data){
		try{
			!is_null($data['lockcard_endtime']) && $data['lockcard_endtime'] = strtotime($data['lockcard_endtime']);

			$res = LockCard::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  删除卡
 	* @param (输入参数：)  {array}        where 删除条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function delcard($where){
		try{
			$res = LockCard::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}




}

