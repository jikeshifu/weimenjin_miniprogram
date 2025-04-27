<?php 
/*
 module:		开门时段
 create_time:	2020-07-09 20:13:50
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\Locktimes;

class LocktimesService extends CommonService {


	/*
 	* @Description  开门时段列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Locktimes::loadList($where,$limit,$field,$orderby);
			$count = Locktimes::countList($where);
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
			$data['user_id'] = session('admin.user_id');
			$data['create_time'] = time();

			//数据验证
			$rule = [
				'locktimesname'=>['require'],
			];
			//数据错误提示
			$msg = [
				'locktimesname.require'=>'时段名称不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Locktimes::createData($data);
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
				'locktimesname'=>['require'],
			];
			$msg = [
				'locktimesname.require'=>'时段名称不能为空',
			];
			self::validate($rule,$data,$msg);

			$res = Locktimes::edit($data);
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
			$res = Locktimes::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

