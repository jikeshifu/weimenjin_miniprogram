<?php 
/*
 module:		会员管理
 create_time:	2021-02-02 11:38:13
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\Member;

class MemberService extends CommonService {


	/*
 	* @Description  会员管理列表数据
 	* @param (输入参数：)  {array}        where 查询条件
 	* @param (输入参数：)  {int}          limit 分页参数
 	* @param (输入参数：)  {String}       field 查询字段
 	* @param (输入参数：)  {String}       orderby 排序字段
 	* @return (返回参数：) {array}        分页数据集
 	*/
	public static function pageList($where=[],$limit,$field='*',$orderby=''){
		try{
			$list = Member::loadList($where,$limit,$field,$orderby);
			$count = Member::countList($where);
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
			$data['create_time'] = strtotime($data['create_time']);

			//数据验证
			$rule = [
				'mobile'=>['regex'=>'/^1[3456789]\d{9}$/'],
			];
			//数据错误提示
			$msg = [
				'mobile.regex'=>'手机号格式错误',
			];
			self::validate($rule,$data,$msg);

			$data['password'] = md5($data['password'].config('my.password_secrect'));
			$res = Member::createData($data);
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
			$data['create_time'] = strtotime($data['create_time']);

			//数据验证
			$rule = [
				'mobile'=>['regex'=>'/^1[3456789]\d{9}$/'],
			];
			$msg = [
				'mobile.regex'=>'手机号格式错误',
			];
			self::validate($rule,$data,$msg);

			$res = Member::edit($data);
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
			$res = Member::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

