<?php

use app\ExceptionHandle;
use app\Request;
use think\facade\Db;
use think\facade\Cache;   // 引入Cache
use think\facade\Config;  // 引入Config
use think\facade\Log;
// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    'think\exception\Handle' => ExceptionHandle::class,
];
