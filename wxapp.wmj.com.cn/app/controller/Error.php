<?php

namespace app\admin\controller;

class Error 
{
    public function __call($method, $args)
    {
        return '控制器不存在，请检查是否生成';
    }
	
}
