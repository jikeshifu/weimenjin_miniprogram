<?php

namespace app\admin\service;
use app\admin\db\Application;
use app\admin\db\Menu;
use app\admin\db\Field;
use app\admin\db\Action;
use xhadmin\CommonService;


class ApplicationService extends CommonService
{
	
	
	/*
     * @Description  获取应用数据列表
	 * @param (输入参数：)  {array}        where 查询条件
	 * @param (输入参数：)  {int}          limit 分页参数
     * @param (输入参数：)  {String}       field 查询字段
     * @param (输入参数：)  {String}       orderby 排序字段
     * @return (返回参数：) {array}        分页数据集
	 */
	public static function pageList($where=[],$limit,$field="*",$orderby=''){
		
		try{
			$list = Application::loadList($where,$limit,$field,$orderby);
			$count = Application::countList($where);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return ['list'=>$list,'count'=>$count];	
	}
	
	
	 /*
     * @Description  添加或修改信息
	 * @param (输入参数：)  {string}        type 操作类型 add 添加 update修改
     * @param (输入参数：)  {array}         data 原始数据
     * @return (返回参数：) {bool}        
	 */
	public static function saveData($type,$data){
		
		try{	
			//调用验证器
			$rule = [
				'name'  => 'require',
				'app_dir' => 'require',
				'app_dir'=>['regex'=>'/^([a-z])+$/'],
				'login_table'=>['regex'=>'/^[a-z_]\w+$/'],
				'pk'=>['regex'=>'/^([a-z_])+$/'],
			];
			$msg = [
				'name.require'=>'应用名称必填',
				'app_dir.require'=>'应用目录必填',
				'login_table.regex'=>'小写字母下划线数字组合',
				'pk.regex'=>'主键小写字母下划线组合',
			];
			self::validate($rule,$data,$msg);
			
			if($data['login_fields'] && false == strpos($data['login_fields'],'|')){
				throw new \Exception('登录字段格式错误');
			}
			
			if($type == 'add'){
				$reset = Application::createData($data);
				if($reset && $data['app_type'] == 1){
					self::createDefaultAction($reset);
				}
			}elseif($type == 'edit'){
				$reset = Application::edit($data);
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return $reset;
	}
	
	/**
     * 创建应用的默认操作
     * @return bool 信息
     */
	public static function createDefaultAction($app_id){
		
		$applicationInfo = Application::getInfo($app_id);
		
		$menu_id = Menu::createData(['title'=>'系统管理','is_create'=>0,'table_status'=>0,'is_url'=>0,'status'=>1,'menu_icon'=>'fa fa-gears','app_id'=>$app_id]);
		if($menu_id){
			Menu::edit(['sortid'=>$menu_id,'menu_id'=>$menu_id]);
			
			$url = !empty($applicationInfo['domain']) ? '/Index/main.html' : '/'.$applicationInfo['app_dir'].'/Index/main.html';
			Menu::createData(['title'=>'后台首页','pid'=>$menu_id,'is_create'=>0,'table_status'=>0,'is_url'=>1,'status'=>1,'sortid'=>1,'menu_icon'=>'fa fa-gears','app_id'=>$app_id,'url'=>$url]);
			
			$url = !empty($applicationInfo['domain']) ? '/Base/password' : '/'.$applicationInfo['app_dir'].'/Base/password';
			Menu::createData(['title'=>'修改密码','pid'=>$menu_id,'is_create'=>0,'table_status'=>0,'is_url'=>1,'status'=>1,'sortid'=>2,'menu_icon'=>'fa fa-gears','app_id'=>$app_id,'url'=>$url]);
		}
	}
	
	/**
     * 卸载应用 应用下的文件全部删除
     * @return bool 信息
     */
	public static function delete($app_id){
		try{
			Application::delete(['app_id'=>$app_id]);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}	
		return $reset;
	}
	
    
}
