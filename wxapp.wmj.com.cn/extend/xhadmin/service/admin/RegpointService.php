<?php 
/*
 module:		登记点管理
 create_time:	2020-02-28 10:01:07
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\Regpoint;

class RegpointService extends CommonService {


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
		return $res;
	}




}

