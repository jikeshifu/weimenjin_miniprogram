<?php
/**
 * 创建字段中间件
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

class SetField
{
	
    public function handle($request, \Closure $next)
    {	
		$data = $request->param();
		
		$data['field'] = strtolower(trim($data['field']));
		if(!preg_match('/^[a-z_|0-9]+$/',$data['field'])){
			return json(['status'=>'01','msg'=>'字段格式错误']);
		}
		
		if($data['is_field']){
			$typeField = \app\admin\service\FieldSetService::typeField();
			$propertyField =\app\admin\service\FieldSetService::propertyField();
			$typeData = $typeField[$data['type']];
			$property = $propertyField[$typeData['property']];

			$property['decimal'] = !empty($property['decimal']) ? ','.$property['decimal'] : '';
			$maxlen = !empty($data['length']) ? $data['length'] : $property['maxlen'];
			$datatype = !empty($data['datatype']) ? $data['datatype'] : $property['name'];
			$default = $data['type'] == 13 ? "DEFAULT '0'" : 'DEFAULT NULL';
			
			$menuInfo = \app\admin\db\Menu::getInfo($data['menu_id']);
			$fields = explode('|',$data['field']);
			
			try{
				foreach($fields as $key=>$val){
					$sql="ALTER TABLE ".config('database.connections.mysql.prefix')."{$menuInfo['table_name']} ADD {$val} {$datatype}({$maxlen}{$property['decimal']}) COMMENT '{$data['name']}' {$default}";
					Db::execute($sql);

					if(!empty($data['indexdata'])){
						Db::execute("ALTER TABLE ".config('database.connections.mysql.prefix')."{$menuInfo['table_name']} ADD ".$data['indexdata']." (  `".$val."` )");
					}
				}
			}catch(\Exception $e){
				return json(['status'=>'01','msg'=>$e->getMessage()]);
			}
		}
		
		return $next($request);
		
		
    }
}