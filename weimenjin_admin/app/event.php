<?php
// 事件定义文件
return [
    'bind'      => [
		
    ],
    'AppInit' => function () {
        loadDatabaseConfigWithCache();
    },
    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
    ],
];

/**
 * 动态加载数据库配置，并合并到系统配置中
 */
function loadDatabaseConfigWithCache()
{
    // 添加日志输出，确保函数被调用
    \think\facade\Log::info('Loading database config...');

    // 从缓存或数据库中读取配置
    $configs = Cache::remember('db_configs', function () {
        return Db::name('appconfig')->select();
    }, 3600); // 缓存1小时

    // 将配置转换为结构化数组
    $structuredConfig = [];
    foreach ($configs as $config) {
        $structuredConfig[$config['module']][$config['name']] =
            json_decode($config['value'], true) ?? $config['value'];
    }

    // 将结构化配置写入 ThinkPHP 的配置系统
    foreach ($structuredConfig as $module => $config) {
        Config::set($config, "my.$module");
    }

    // 添加日志输出，确认配置加载成功
    \think\facade\Log::info('Database config loaded successfully.');
}