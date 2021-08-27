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

class DeleteApplication
{
	
    public function handle($request, \Closure $next)
    {	
		$data = $request->param();
		
		$applicationInfo = \app\admin\db\Application::getInfo($data['app_id']);
		
		if(config('my.drop_application_status')){
			$rootPath = app()->getRootPath();
			
			if($applicationInfo['app_type'] == 3){
				
				if($applicationInfo['app_dir']){
					deldir($rootPath.'/app/'.$applicationInfo['app_dir']); //删除前端应用
					deldir($rootPath.'/route/'.$applicationInfo['app_dir']); //删除路由
				}
				
				$cmsCount = \app\admin\db\Application::countList(['app_type'=>3]);
				if($cmsCount <= 1){
					deldir($rootPath.'/app/admin/controller/Cms'); //删除控制器
					deldir($rootPath.'/app/admin/view/cms'); //删除视图
					deldir($rootPath.'/extend/cms'); //删除应用
					deldir('./static/js/admin/cms'); //删除静态资源
					
					Db::execute('DROP TABLE IF EXISTS '.config('database.connections.mysql.prefix').'content');
					Db::execute('DROP TABLE IF EXISTS '.config('database.connections.mysql.prefix').'catagory');
					Db::execute('DROP TABLE IF EXISTS '.config('database.connections.mysql.prefix').'frament');
					Db::execute('DROP TABLE IF EXISTS '.config('database.connections.mysql.prefix').'position');
				
				
					$extendList = \app\admin\db\Menu::loadList(['app_id'=>$data['app_id']]);
					
					if($extendList){
						foreach($extendList as $key=>$val){
							\app\admin\db\Field::delete(['menu_id'=>$val['menu_id']]);
							\app\admin\db\Menu::delete(['menu_id'=>$val['menu_id']]);
							Db::execute('DROP TABLE IF EXISTS '.config('database.connections.mysql.prefix').$val['table_name']);
						}
					}
				}
			}else{
				if($applicationInfo['app_dir']){
					deldir($rootPath.'/app/'.$applicationInfo['app_dir']); //删除应用
					deldir($rootPath.'/extend/xhadmin/service/'.$applicationInfo['app_dir']); //删除服务层
					deldir($rootPath.'/route/'.$applicationInfo['app_dir']); //删除路由
				}
				
				$where['menu_id'] = \app\admin\db\Menu::getFieldList(['app_id'=>$data['app_id']]);
				
				\app\admin\db\Menu::delete(['app_id'=>$data['app_id']]);
				\app\admin\db\Field::delete($where);
				\app\admin\db\Action::delete($where);
			}	
		}
		
		return $next($request);	
		
    }
}