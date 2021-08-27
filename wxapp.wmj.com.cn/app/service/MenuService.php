<?php

namespace app\admin\service;
use xhadmin\CommonService;
use app\admin\db\Menu;
use app\admin\db\Application;


class MenuService extends CommonService
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
			$list = Menu::loadList($where,$limit,$field,$orderby);
			$count = Menu::countList($where);
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
				'title'  => 'require',
			];
			
			$msg = [
				'title.require'=>'控制器名称不能为空',
			];
			self::validate($rule,$data,$msg);
			$controller_name = $data['controller_name'];
			
			if(strpos($controller_name,'/') > 0){
				$arr = explode('/',$controller_name);
				$controller_name = ucfirst($arr[0]).'/'.ucfirst($arr[1]);
			}else{
				$controller_name = ucfirst($controller_name);
			}
			
			$data['controller_name'] = $controller_name;
			$data['table_name'] = strtolower($data['table_name']);
			$data['pk_id'] = strtolower($data['pk_id']);
			
			if($type == 'add'){
				$controllerInfo = Menu::getWhereInfo(['app_id'=>$data['app_id'],'controller_name'=>$data['controller_name']]);
				if($data['controller_name'] && $controllerInfo){
					throw new \Exception('控制器已存在');
				}
				
				$tableInfo = Menu::getWhereInfo(['table_status'=>1,'table_name'=>$data['table_name']]);
				if($data['table_name'] && $tableInfo){
					throw new \Exception('数据表已存在');
				}
				$reset = Menu::createData($data);
				if($reset){
					Menu::edit(['menu_id'=>$reset,'sortid'=>$reset]);
					$applicationInfo = Application::getInfo($data['app_id']);
					if($data['table_name'] && $data['pk_id'] && $applicationInfo['app_type'] == 1){
						self::createDefaultAction($data,$reset);
					}
				}	
			}elseif($type == 'edit'){			
				$reset = Menu::edit($data);
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return $reset;
	}
	
	
	/**
     * 创建默认的控制器方法以及字段
     * @return bool 信息
     */
	public static function createDefaultAction($data,$id){

		//创建默认操作方法
		db('action')->insertGetId(['menu_id'=>$id,'name'=>'首页数据列表','action_name'=>'index','type'=>'1','is_view'=>'0','block_name'=>$data['title'],'sortid'=>'1']);
		db('action')->insertGetId(['menu_id'=>$id,'name'=>'修改排序开关按钮操作','action_name'=>'updateExt','type'=>'16','is_view'=>'0','block_name'=>'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法','sortid'=>'2']);
		
		//创建默认主键
		db('field')->insertGetId(['menu_id'=>$id,'name'=>'编号','field'=>$data['pk_id'],'type'=>'1','list_show'=>'1','search_show'=>'0','is_post'=>'0','is_field'=>'1','align'=>'center','sortid'=>'1','datatype'=>'int','length'=>'11']);
	}
	
	
	
	/**
     * 移动排序
	 * @param (输入参数：)  {string}        id 当前ID
     * @param (输入参数：)  {string}        type 类型 1上移 2 下移
     * @return (返回参数：) {bool}        
     * @return bool 信息
     */
	public static function arrowsort($id,$type){
		$data = Menu::getInfo($id);

		if($type == 1){
			$map = 'sortid < '.$data['sortid'].' and pid = '.$data['pid'];
			$info = Menu::getWhereInfo($map,$order='sortid desc');
		}else{
			$map = 'sortid > '.$data['sortid'].' and pid = '.$data['pid'];
			$info = Menu::getWhereInfo($map,$order='sortid asc');
		}
		try{
			if($info && $data){
				Menu::edit(['menu_id'=>$id,'sortid'=>$info['sortid']]);
				Menu::edit(['menu_id'=>$info['menu_id'],'sortid'=>$data['sortid']]);
			}else{
				throw new \Exception('目标位置没有数据');
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
		
		return true;	
	}
	
	/**
     * 删除信息
     * @return bool 信息
     */
	public static function delete($id){
		try{	
			$reset = Menu::delete(['menu_id'=>$id]);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return $reset;
	}
	
    
}
