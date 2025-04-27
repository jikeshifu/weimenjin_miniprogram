<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;  // 引入 Argument 类
use think\facade\Cache;

class CacheView extends Command
{
    // 配置命令名称、描述和参数
    protected function configure()
    {
        $this->setName('cacheView')
            ->setDescription('View the content of a specific cache key')
            ->addArgument('key', Argument::OPTIONAL, 'The cache key to view', 'db_configs');  // 添加可选参数，默认值为 'db_configs'
    }

    // 执行命令的逻辑
    protected function execute(Input $input, Output $output)
    {
        // 获取传入的缓存键名
        $key = $input->getArgument('key');

        // 获取缓存中的值
        $value = Cache::get($key);

        // 打印缓存内容或提示错误
        if ($value) {
            $output->writeln("Cache Content for [$key]:");
            $output->writeln(print_r($value, true));
        } else {
            $output->writeln("Cache key [$key] does not exist or is expired.");
        }
    }
}
