<?php

namespace app\admin\controller;

use app\admin\service\SystemUpdateService;
use app\module\model\AppConfig as AppConfigModel;
use think\facade\Db;
use think\Request;

class AppConfig extends Admin
{
    /**
     * 显示配置管理页面
     *
     * @return mixed
     */
    public function index()
    {
        try {
            SystemUpdateService::ensureApplicationConfigReady();
        } catch (\Throwable $e) {
        }

        // 获取所有配置项并按分组返回
        $configs = AppConfigModel::getAllConfigsGrouped();

        // 单独处理 nocheck 项，确保解析为数组
        if (isset($configs['base']['nocheck'])) {
            $configs['base']['nocheck'] = json_decode($configs['base']['nocheck'], true) ?? [];
        }

        $this->view->assign('configs', $configs);
        return $this->display('index');
    }


    /**
     * 保存配置
     *
     * @param Request $request
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        $data = $request->post();

        try {
            // 批量保存配置项
            // 确保 'nocheck' 是数组格式并存入 JSON 字符串
            if (isset($data['nocheck']) && is_array($data['nocheck'])) {
                $data['nocheck'] = json_encode($data['nocheck'], JSON_UNESCAPED_SLASHES);
            }
            AppConfigModel::saveConfigs($data);
            if(SystemUpdateService::refreshRuntimeConfigFromDatabase())
            {return json(['status' => 'success', 'message' => '配置保存成功']);}
            else
            {return json(['status' => 'error', 'message' => '保存失败,请记得给目录www用户写入权限']);}

        } catch (\Exception $e) {
            return json(['status' => 'error', 'message' => '保存失败: ' . $e->getMessage()]);
        }
    }
    /**
     * 从数据库生成 my.php 配置文件
     */
    function generateMyPhpConfig()
    {
        $configs = Db::table('cd_appconfig')->select();

        // 结构化配置，根据是否需要分组进行分类
        $structuredConfig = [];
        foreach ($configs as $config) {
            $value = $this->parseConfigValue($config['value'], $config['type']);
            if ($config['is_grouped']) {
                $structuredConfig[$config['module']][$config['name']] = $value;
            } else {
                $structuredConfig[$config['name']] = $value;
            }
        }

        // 将配置数组导出为 PHP 代码
        $content = "<?php\n\nreturn " . $this->exportArray($structuredConfig) . ";\n";

        // 写入配置文件
        $filePath = __DIR__ . '/../../../config/my.php'; // 根据实际路径调整
        if (file_put_contents($filePath, $content) === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 根据数据类型解析数据库中的值
     *
     * @param string $value 数据库中的原始值
     * @param string $type  数据类型
     * @return mixed        解析后的值
     */
    function parseConfigValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value === '1' || strtolower($value) === 'true';
            case 'integer':
                return (int)$value;
            case 'array':
                return json_decode($value, true); // 直接返回数组
            case 'string':
            default:
                return (string)$value;
        }
    }

    /**
     * 将数组导出为格式化的 PHP 代码。
     *
     * @param array $array 需要导出的数组
     * @param int   $indent 缩进级别
     * @param string|null $parentKey 父级键名，用于判断特殊处理
     * @return string 格式化后的 PHP 数组代码
     */
    function exportArray(array $array, $indent = 1, $parentKey = null)
    {
        $indentation = str_repeat('    ', $indent);
        $code = "[\n";

        foreach ($array as $key => $value) {
            // 如果父级键名为 'nocheck'，只输出值，不输出键名
            if ($parentKey === 'nocheck') {
                $formattedValue = $this->formatValue($value, $indent + 1);
                $code .= "{$indentation}{$formattedValue},\n";
            } else {
                $formattedKey = is_int($key) ? $key : "'$key'";
                $formattedValue = $this->formatValue($value, $indent + 1, $key);
                $code .= "{$indentation}{$formattedKey} => {$formattedValue},\n";
            }
        }

        $code .= str_repeat('    ', $indent - 1) . "]";
        return $code;
    }

    /**
     * 格式化数组中的值。
     *
     * @param mixed  $value 值
     * @param int    $indent 缩进级别
     * @param string|null $parentKey 父级键名，用于传递给 exportArray
     * @return string 格式化后的值
     */
    function formatValue($value, $indent, $parentKey = null)
    {
        if (is_array($value)) {
            return $this->exportArray($value, $indent, $parentKey);
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_int($value)) {
            return $value;
        } else {
            return var_export($value, true);
        }
    }
}
