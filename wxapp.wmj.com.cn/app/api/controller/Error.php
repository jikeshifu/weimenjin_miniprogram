<?php

namespace app\api\controller;

class Error 
{
    public function __call($method, $args)
    {
        return json(['status'=>'02','msg'=>'控制器不存在']);
    }
	
}
