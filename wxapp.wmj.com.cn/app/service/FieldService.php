<?php

namespace app\admin\service;
use xhadmin\CommonService;
use app\admin\db\Field;
use app\admin\db\Menu;


class FieldService extends CommonService
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
			$list = Field::loadList($where,$limit,$field,$orderby);
			$count = Field::countList($where);
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
				'field' => 'require',
				'type' => 'require'
			];
			
			$msg = [
				'name.require'  => '字段名称必填',
				'field.require'  => '字段必填',
				'type.require'=>'字段类型必填',
			];
			
			self::validate($rule,$data);
			
			$data['field'] = strtolower(trim($data['field'])); //字段强制小写

			if($type == 'add'){
				$info = Field::getWhereInfo(['menu_id'=>$data['menu_id'],'field'=>$data['field']]);
				if(!$info){
					$reset = Field::createData($data);	//创建操作字段
					if($reset){
						Field::edit(['id'=>$reset,'sortid'=>$reset]); //更新排序
					}
				}else{
					throw new \Exception('字段已经存在');
				}
			}elseif($type == 'edit'){
				$res = Field::edit($data);
				if($res){
					$fieldInfo = Field::getInfo($data['id']);
					if($data['name'] == '编号' && $data['field'] <> $fieldInfo['field']){
						Menu::edit(['pk_id'=>$data['field'],'menu_id'=>$fieldInfo['menu_id']]);
					}
				}
			}
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}
			
		return $reset;
	}
	
	
	/**
     * 移动排序
	 * @param (输入参数：)  {string}        id 当前ID
     * @param (输入参数：)  {string}        type 类型 1上移 2 下移
     * @return (返回参数：) {bool}        
     * @return bool 信息
     */
	public static function arrowsort($id,$type){
		$data = Field::getInfo($id);

		if($type == 1){
			$map = 'sortid < '.$data['sortid'].' and menu_id = '.$data['menu_id'];
			$info = Field::getWhereInfo($map,$order='sortid desc');
		}else{
			$map = 'sortid > '.$data['sortid'].' and menu_id = '.$data['menu_id'];
			$info = Field::getWhereInfo($map,$order='sortid asc');
		}
		try{
			if($info && $data){
				Field::edit(['id'=>$id,'sortid'=>$info['sortid']]);
				Field::edit(['id'=>$info['id'],'sortid'=>$data['sortid']]);
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
			Field::delete(['id'=>$id]);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage());
		}	
		return true;
	}
	
    
}
