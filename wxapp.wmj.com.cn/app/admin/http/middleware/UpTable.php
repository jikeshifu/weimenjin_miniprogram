<?php
/**
 * 更新数据表中间件
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
use think\helper\Str;

class UpTable
{
	
    public function handle($request, \Closure $next)
    {	
		$data = $request->param();
		
		$menuInfo = \app\admin\db\Menu::getInfo($data['menu_id']);
		
		if($data['table_status'] && $data['table_name'] && $data['pk_id']){
			try{
				$data['table_name'] = strtolower(trim($data['table_name']));
				$data['pk_id'] = strtolower(trim($data['pk_id']));
				
				//数据表存在直接修改表 不存在重新创建表
				if(self::getTable($menuInfo['table_name'])){				
					if($data['pk_id'] <> $menuInfo['pk_id']){
						$sql = "ALTER TABLE ".config('database.connections.mysql.prefix')."".$menuInfo['table_name']." CHANGE ".$menuInfo['pk_id']." ".$data['pk_id']." INT( 11 ) COMMENT '编号' NOT NULL AUTO_INCREMENT";
						$res = Db::execute($sql);
						
						//主键修改以后 字段对应的id名称也要做相应的修改
						
						$where['name'] = '编号';
						$where['menu_id'] = $data['menu_id'];
						\app\admin\db\Field::editWhere($where,['field'=>$data['pk_id']]);
							
					}
					
					if($data['table_name'] && $data['table_name'] <> $menuInfo['table_name']){
						$sql="ALTER TABLE ".config('database.connections.mysql.prefix')."".$menuInfo['table_name']." RENAME TO ".config('database.connections.mysql.prefix')."".$data['table_name'];
						Db::execute($sql);
					}
				}else{
					//创建数据表
					$sql=" CREATE TABLE IF NOT EXISTS `".config('database.connections.mysql.prefix')."".$data['table_name']."` ( ";
					$sql .= '
						`'.$data['pk_id'].'` int(10) NOT NULL AUTO_INCREMENT ,
						PRIMARY KEY (`'.$data['pk_id'].'`)
						) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
					';
					Db::execute($sql);
					
					$info = \app\admin\db\Field::getWhereInfo(['name'=>'编号','menu_id'=>$data['menu_id']]);
					if(!$info){
						$defaultData['pk_id'] = $data['pk_id'];
						$defaultData['title'] = $data['title'];
						\app\admin\service\MenuService::createDefaultAction($defaultData,$data['menu_id']);
					}
				}

				
			}catch(\Exception $e){
				return json(['status'=>'01','msg'=>$e->getMessage()]);
			}
		}
		
		//当菜单控制器名改变了开始删除之前的相关文件
		if(!$menuInfo['url'] && !empty($menuInfo['controller_name']) && $data['controller_name'] <> $menuInfo['controller_name']){
			$rootPath = app()->getRootPath();
			$applicationInfo = \app\admin\db\Application::getInfo($menuInfo['app_id']);
			@unlink($rootPath.'/extend/xhadmin/service/'.$applicationInfo['app_dir'].'/'.$menuInfo['controller_name'].'Service.php');  //删除服务层
			deldir($rootPath.'/app/'.$applicationInfo['app_dir'].'/view/'.getViewName($menuInfo['controller_name']));  //删除视图
			@unlink($rootPath.'/app/'.$applicationInfo['app_dir'].'/controller/'.$menuInfo['controller_name'].'.php');  //删除控制器文件
			@unlink('./static/js/'.$applicationInfo['app_dir'].'/'.$menuInfo['controller_name'].'.js');	
			@unlink($rootPath.'/extend/xhadmin/db/'.$menuInfo['controller_name'].'.php');  //删除模型	
		}
		
		return $next($request);
    }
	
	
	//查看数据表是否存在
	public static function getTable($tableName){
		$list = Db::query('show tables');
		foreach($list as $k=>$v){
			$array[] = $v['Tables_in_'.config('database.connections.mysql.database')];
		}
		if(in_array(config('database.connections.mysql.prefix').$tableName,$array)){
			return true;
		}
	}
	
}