<?php 
/*
 module:		分组管理
 create_time:	2020-02-20 21:19:02
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\Group;

class GroupService extends CommonService {


	/*
 	* @Description  分组管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Group::loadList($where,$limit,$field,$orderby);
			$count = Group::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return ['list'=>$list,'count'=>$count];
	}


	/*
 	* @Description  添加分组
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function add($data){
		try{

			//数据验证
			$rule = [
				'name'=>['require'],
			];
			//数据错误提示
			$msg = [
				'name.require'=>'名称不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Group::createData($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  修改分组
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($data){
		try{

			//数据验证
			$rule = [
				'name'=>['require'],
			];
			$msg = [
				'name.require'=>'名称不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Group::edit($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

