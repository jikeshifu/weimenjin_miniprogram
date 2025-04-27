<?php 
/*
 module:		用户管理
 create_time:	2020-03-20 23:43:44
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;
use xhadmin\db\User;

class UserService extends CommonService {


	/*
 	* @Description  修改账户
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($where,$data){
		try{
			//数据验证
			$rule = [
				'name'=>['require'],
				'user'=>['require','unique:user'],
				'group_id'=>['require'],
			];
			//错误提示消息
			$msg = [
				'name.require'=>'真实姓名不能为空',
				'user.require'=>'用户名不能为空',
				'user.unique'=>'用户名已经存在',
				'group_id.require'=>'所属分组不能为空',
			];
			self::validate($rule,$data,$msg);	//错误提示

			!is_null($data['create_time']) && $data['create_time'] = strtotime($data['create_time']);

			$res = User::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}


	/*
 	* @Description  修改密码
 	* @param (输入参数：)  {array}        data 原始数据
 	* @return (返回参数：) {bool}        
 	*/
	public static function updatePassword($where,$data){
		try{
			if(is_null($data['pwd'])) throw new \Exception("密码不能为空");
			if($data['pwd'] <> $data['repwd']) throw new \Exception("两次密码输入不一致");
			if(!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/',$data['pwd'])) throw new \Exception("密码格式错误");
			$res = User::editWhere($where,['pwd'=>md5($data['pwd'].config('my.password_secrect'))]);
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
	public static function adduser($data){
		try{
			//数据验证
			$rule = [
				'name'=>['require'],
				'user'=>['require','unique:user'],
				'pwd'=>['require','regex'=>'/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/'],
				'group_id'=>['require'],
			];
			//错误提示消息
			$msg = [
				'name.require'=>'真实姓名不能为空',
				'user.require'=>'用户名不能为空',
				'user.unique'=>'用户名已经存在',
				'member_id.require'=>'管理员id不能为空',
				'pwd.require'=>'密码不能为空',
				'pwd.regex'=>'6-21位数字字母组合',
				'group_id.require'=>'所属分组不能为空',
			];
			self::validate($rule,$data,$msg);	//开始验证

			$data['pwd'] = md5($data['pwd'].config('my.password_secrect'));
			$data['create_time'] = time();

			$res = User::createData($data);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}
   /*end*/



}

