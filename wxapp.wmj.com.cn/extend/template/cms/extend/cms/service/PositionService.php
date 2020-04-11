<?php 
/**
 *推荐位管理
*/

namespace cms\service;

use cms\db\Position;
use xhadmin\CommonService;


class PositionService extends CommonService {


	/*
 	* @Description  推荐位管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Position::loadList($where,$limit,$field,$orderby);
			$count = Position::countList($where);
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
			//数据验证
			$rule = [
				'title'=>['require'],
			];
			//数据错误提示
			$msg = [
				'title.require'=>'标题不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Position::createData($data);

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
			//数据验证
			$rule = [
				'title'=>['require'],
			];
			$msg = [
				'title.require'=>'标题不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Position::edit($data);
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
			$res = Position::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

