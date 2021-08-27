<?php
/**
 * 更新字段中间件
 * ============================================================================
 * * COPYRIGHT 2016-2019 xhadmin.com , and all rights reserved.
 * * WEBSITE: http://www.xhadmin.com;
 * ----------------------------------------------------------------------------
 * This is not a free software!You have not used for commercial purposes in the
 * premise of the program code to modify and use; and publication does not allow
 * any form of code for any purpose.
 * ============================================================================
 * Author: 寒塘冷月 QQ：274363574
 */

namespace app\admin\http\middleware;
use think\facade\Db; 

class UpField
{
	
    public function handle($request, \Closure $next)
    {	
		$data = $request->param();
		
		$data['field'] = strtolower(trim($data['field']));
		$data['pk_id'] = strtolower(trim($data['pk_id']));
		
		if(!preg_match('/^[a-z_|0-9]+$/',$data['field'])){
			return json(['status'=>'01','msg'=>'字段格式错误']);
		}

		$fieldInfo = \app\admin\db\Field::getInfo($data['id']);
		
		if($data['is_field'] && $fieldInfo['menu_id'] <> config('my.config_module_id')){
			$typeField = \app\admin\service\FieldSetService::typeField();
			$propertyField =\app\admin\service\FieldSetService::propertyField();
			
			$typeData = $typeField[$data['type']];
			$property = $propertyField[$typeData['property']];
			
			$property['decimal'] = !empty($property['decimal']) ? ','.$property['decimal'] : '';
			$maxlen = !empty($data['length']) ? $data['length'] : $property['maxlen'];
			$datatype = !empty($data['datatype']) ? $data['datatype'] : $property['name'];
			$default = $data['type'] == 13 ? "DEFAULT '0'" : 'DEFAULT NULL';
			
			$menuInfo = \app\admin\db\Menu::getInfo($fieldInfo['menu_id']);
			
			if($data['name'] == '编号'){
				$auto = 'AUTO_INCREMENT';
				$maxlen = !empty($data['length']) ? $data['length'] : 11;
				$datatype = !empty($data['datatype']) ? $data['datatype'] : 'int';
			}else{
				$auto = '';
			}
			
			$fields = explode('|',$data['field']);
			$tableFileds = explode('|',$fieldInfo['field']);

			
			try{
				foreach($fields as $key=>$val){
					if(self::getFieldStatus(config('database.connections.mysql.prefix').$menuInfo['table_name'],$tableFileds[$key])){
						$sql="ALTER TABLE ".config('database.connections.mysql.prefix')."{$menuInfo['table_name']} CHANGE {$tableFileds[$key]} {$fields[$key]} {$datatype}({$maxlen}{$property['decimal']}) COMMENT '{$data['name']}' {$default} {$auto}";
						Db::execute($sql);
					}else{
						$sql="ALTER TABLE ".config('database.connections.mysql.prefix')."{$menuInfo['table_name']} ADD {$val} {$datatype}({$maxlen}{$property['decimal']}) COMMENT '{$data['name']}' {$default}";
						Db::execute($sql);
					}
					
					//判断是否存在索引  不存在则创建
					$status = self::getTableIndex(config('database.connections.mysql.prefix').$menuInfo['table_name'],$fields[$key]);
					if(!empty($data['indexdata']) && !$status){
						Db::execute("ALTER TABLE ".config('database.connections.mysql.prefix')."{$menuInfo['table_name']} ADD ".$data['indexdata']." (  `".$val."` )");
					}
				}
				
				if($data['name'] == '编号' && $data['field'] <> $menuInfo['pk_id']){
					$where['menu_id'] = $fieldInfo['menu_id'];
					\app\admin\db\Menu::editWhere($where,['pk_id'=>$data['field']]);
				}
				
			}catch(\Exception $e){
				return json(['status'=>'01','msg'=>$e->getMessage()]);
			}	
		}
		
		return $next($request);
    }
	
	//查看索引是否存在
	public static function getTableIndex($tablename,$indexName){
		$list = Db::query('show index from '.$tablename);
		foreach($list as $k=>$v){
			if($v['Column_name'] == $indexName){
				$status = true;
			}
		}
		return $status;
	}
	
	//判断数据表字段是否存在
	public static function getFieldStatus($tablename,$field){
		$list = Db::query('show columns from '.$tablename);
		foreach($list as $v){
			$arr[] = $v['Field'];
		}
		if(in_array($field,$arr)){
			return true;
		}
	}
}