<?php 
/*
 module:		用户管理
 create_time:	2020-03-19 00:05:52
 author:		
 contact:		
*/

namespace xhadmin\service\admin;

use xhadmin\CommonService;
use xhadmin\db\User;

class UserService extends CommonService {


	/*
 	* @Description  添加账户
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function add($data){
		try{
			$data['create_time'] = time();

			//数据验证
			$rule = [
				'name'=>['require'],
				'user'=>['require','unique:user'],
				'pwd'=>['require','regex'=>'/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/'],
			];
			//数据错误提示
			$msg = [
				'name.require'=>'真实姓名不能为空',
				'user.require'=>'用户名不能为空',
				'user.unique'=>'用户名已经存在',
				'pwd.require'=>'密码不能为空',
				'pwd.regex'=>'6-21位数字字母组合',
			];
			self::validate($rule,$data,$msg);

			$data['pwd'] = md5($data['pwd'].config('my.password_secrect'));
			$res = User::createData($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  修改账户
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($data){
		try{
			$data['create_time'] = strtotime($data['create_time']);

			//数据验证
			$rule = [
				'name'=>['require'],
				'user'=>['require','unique:user'],
			];
			$msg = [
				'name.require'=>'真实姓名不能为空',
				'user.require'=>'用户名不能为空',
				'user.unique'=>'用户名已经存在',
			];
			self::validate($rule,$data,$msg);

			$res = User::edit($data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}


	/*
 	* @Description  删除数据
 	* @param (输入参数：)  {array}        where 删除条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function delete($where){
		try{
			$res = User::delete($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		return $res;
	}




}

