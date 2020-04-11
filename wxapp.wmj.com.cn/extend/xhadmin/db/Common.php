<?php

namespace xhadmin\db;
use \think\facade\Log; 


class Common
{
	
	//记录sql错误日志
	public static function setLog($msg){
		log::error('sql错误：'.$msg);	
	}
	
	
    
}
