<?php
/**
 * 删除菜单中间件
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

class DeleteMenu
{
	
    public function handle($request, \Closure $next)
    {	
		$data = $request->param();
		
		if(in_array($data['menu_id'],[18,19,41,52])){
			return json(['status'=>'01','msg'=>'系统模块禁止卸载']);
		};
		
		$menuInfo = \app\admin\db\Menu::getInfo($data['menu_id']);
		$applicationInfo = \app\admin\db\Application::getInfo($menuInfo['app_id']);
		
		$where['menu_id'] = $data['menu_id'];
		
		//开始删除系统的字段 操作方法
		\app\admin\db\Field::delete($where);
		\app\admin\db\Action::delete($where);
		
		//开始删除数据表
		if(config('my.drop_table_status') && !empty($menuInfo['table_name']) && in_array($applicationInfo['app_type'],[1,3]) && $menuInfo['table_status']){
			$sql = Db::execute('DROP TABLE if exists '.config('database.connections.mysql.prefix').$menuInfo['table_name'] );
		}
		
		//开始删除相关文件
		if(!$menuInfo['url'] && !empty($menuInfo['controller_name'])){
			$rootPath = app()->getRootPath();
			@unlink($rootPath.'/extend/xhadmin/service/'.$applicationInfo['app_dir'].'/'.$menuInfo['controller_name'].'Service.php');  //删除服务层
			deldir($rootPath.'/app/'.$applicationInfo['app_dir'].'/view/'.getViewName($menuInfo['controller_name']));  //删除视图
			@unlink($rootPath.'/app/'.$applicationInfo['app_dir'].'/controller/'.$menuInfo['controller_name'].'.php');  //删除控制器文件
			@unlink('./static/js/'.$applicationInfo['app_dir'].'/'.$menuInfo['controller_name'].'.js');
			
			if($applicationInfo['app_id'] == 1){	
				@unlink($rootPath.'/extend/xhadmin/db/'.$menuInfo['controller_name'].'.php');  //删除模型
			}	
		}
		
		return $next($request);	
		
    }
}