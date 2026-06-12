<?php

namespace app\module\model;

use think\Model;

class AppConfig extends Model
{
    // 指定表名
    protected $table = 'cd_appconfig';

    // 关闭自动时间戳（如果不需要）
    public $timestamps = false;

    /**
     * 获取所有配置项并按 module 分组返回
     *
     * @return array
     */
    public static function getAllConfigsGrouped()
    {
        // 查询所有配置项，按 module 排序
        $configs = self::order([ 'sort_order' => 'desc' ,'group_sort_order' => 'asc' ])->select()->toArray();

        // 按 module 分组
        $grouped = [];
        foreach ($configs as $config) {
            if ($config['module'] === 'hardware_cloud_routes' && $config['name'] === 'routes') {
                continue;
            }
            $module = $config['module'];
            if (!isset($grouped[$module])) {
                $grouped[$module] = [
                    'module_name' => $config['module_name'],
                    'module' => $config['module'],
                    'configs' => []
                ];
            }
            $grouped[$module]['configs'][] = $config;
        }

        return $grouped;
    }

    /**
     * 保存配置项
     *
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public static function saveConfigs($data)
    {
        foreach ($data as $name => $value) {
            // 更新配置项的值
            self::where('name', $name)->update(['value' => $value]);
        }
    }
}
