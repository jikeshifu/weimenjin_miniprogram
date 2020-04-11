<?php 
/*
 module:		会员管理
 create_time:	2020-04-06 17:22:54
 author:		
 contact:		
*/

namespace xhadmin\service\api;

use xhadmin\CommonService;
use xhadmin\db\Member;

class MemberService extends CommonService {


	/*
 	* @Description  编辑数据
 	* @param (输入参数：)  {array}        data 原始数据
 	* @param (输入参数：)  {array}        where 修改条件
 	* @return (返回参数：) {bool}        
 	*/
	public static function update($where,$data){
		try{
			//数据验证
			$rule = [
				'mobile'=>['regex'=>'/^1[345678]\d{9}$/'],
			];
			//错误提示消息
			$msg = [
				'mobile.regex'=>'手机号格式错误',
			];
			self::validate($rule,$data,$msg);	//错误提示


			$res = Member::editWhere($where,$data);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		if(!$res){
			throw new \Exception('操作失败');
		}
		return $res;
	}




}

