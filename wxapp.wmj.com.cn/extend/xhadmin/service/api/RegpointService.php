<?php 
/*
 module:		登记点管理
 create_time:	2020-02-24 01:20:15
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;
use xhadmin\db\Regpoint;

class RegpointService extends CommonService {


	/*
 	* @Description  修改
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($where,$data){
		try{
			!is_null($data['create_time']) && $data['create_time'] = strtotime($data['create_time']);

			$res = Regpoint::editWhere($where,$data);
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
			$res = Regpoint::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


 /*start*/
	/*
 	* @Description  添加
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function add($data){
		try{
			$data['create_time'] = time();

			$res = Regpoint::createData($data);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}
    /*end*/

 /*start*/
	/*
 	* @Description  登记点管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Regpoint::loadList($where,$limit,$field,$orderby);
			$count = Regpoint::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return ['list'=>$list,'count'=>$count];
	}
    /*end*/



}

