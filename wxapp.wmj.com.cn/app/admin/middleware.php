<?php

return [
    // 全局请求缓存
    // 'think\middleware\CheckRequestCache',
    // 多语言加载
    // 'think\middleware\LoadLangPack',
    // Session初始化
    'think\middleware\SessionInit',
	\app\admin\http\middleware\Check::class,
];
