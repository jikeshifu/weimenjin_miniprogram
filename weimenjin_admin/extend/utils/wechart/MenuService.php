<?php

//设置菜单
namespace utils\wechart;
use EasyWeChat\Factory;
use think\facade\Log;

class MenuService
{
	
	
	
	public static function getMenu(){
		$app = Factory::officialAccount(config('my.official_accounts'));
		$list = $app->menu->list();
		return $list;
	}
	
	public static function setMenu(){
		
	}
	
    
}
