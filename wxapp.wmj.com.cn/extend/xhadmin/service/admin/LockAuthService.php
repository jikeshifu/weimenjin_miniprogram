<?php 
/*
 module:		钥匙管理
 create_time:	2020-04-02 00:39:58
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\LockAuth;

class LockAuthService extends CommonService {


	/*
 	* @Description  钥匙管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = LockAuth::loadList($where,$limit,$field,$orderby);
			$count = LockAuth::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return ['list'=>$list,'count'=>$count];
	}


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
			$data['create_time'] = strtotime($data['create_time']);

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

