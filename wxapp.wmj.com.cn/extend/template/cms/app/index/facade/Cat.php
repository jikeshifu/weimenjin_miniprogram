<?php
namespace app\ApplicationName\facade;

use think\Facade;

class Cat extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\ApplicationName\service\CatagoryService';
    }
}