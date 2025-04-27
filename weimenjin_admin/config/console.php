<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------
return [
    // 指令定义
    'commands' => [
        'weikaimencardAdd' => 'app\command\CardAdd',
        'weikaimenfaceAdd' => 'app\command\FaceAdd',
        'cacheView' => 'app\command\CacheView',
    ],
];
