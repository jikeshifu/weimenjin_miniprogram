<?php


namespace app\module\hardwareCloud;


class serverConfig
{
    static $WiFIUrl = "https://wdev.wmj.com.cn/deviceApi/";

    static function GetUrl($deviceSn = ''){
        $route = self::ResolveRoute((string)$deviceSn);
        $url = (string)($route['url'] ?? '');
        if ($url === "") {
            $url = self::$WiFIUrl;
        }
        return rtrim($url, "/") . "/";
    }

    static function GetAppId($deviceSn = ''){
        $route = self::ResolveRoute((string)$deviceSn);
        return (string)($route['appid'] ?? '');
    }

    static function GetAppSecret($deviceSn = ''){
        $route = self::ResolveRoute((string)$deviceSn);
        return (string)($route['appsecret'] ?? '');
    }

    static function ResolveRoute(string $deviceSn = ''): array
    {
        $default = [
            'name' => '默认微门禁V2硬件云',
            'url' => (string) config("my.wmjv2.wmjv2_url", self::$WiFIUrl),
            'appid' => (string) config("my.wmjv2.wmjv2_appid", ""),
            'appsecret' => (string) config("my.wmjv2.wmjv2_appsecret", ""),
        ];

        $deviceSn = strtoupper(trim($deviceSn));
        if ($deviceSn === '') {
            return $default;
        }

        foreach (self::ConfiguredRoutes() as $route) {
            if (!self::RouteEnabled($route)) {
                continue;
            }
            foreach (self::RoutePrefixes($route) as $prefix) {
                if ($prefix !== '' && str_starts_with($deviceSn, $prefix)) {
                    return [
                        'name' => (string)($route['name'] ?? '设备前缀硬件云'),
                        'url' => (string)($route['url'] ?? $default['url']),
                        'appid' => (string)($route['appid'] ?? $route['app_id'] ?? $route['wmjv2_appid'] ?? ''),
                        'appsecret' => (string)($route['appsecret'] ?? $route['app_secret'] ?? $route['wmjv2_appsecret'] ?? ''),
                    ];
                }
            }
        }

        return $default;
    }

    private static function ConfiguredRoutes(): array
    {
        $fieldRoutes = self::ConfiguredFieldRoutes();
        if ($fieldRoutes) {
            return $fieldRoutes;
        }

        $routes = config("my.hardware_cloud_routes.routes", []);
        if (is_string($routes)) {
            $decoded = json_decode($routes, true);
            $routes = is_array($decoded) ? $decoded : [];
        }
        if (!is_array($routes)) {
            return [];
        }
        return array_values(array_filter($routes, 'is_array'));
    }

    private static function ConfiguredFieldRoutes(): array
    {
        $routes = [];
        for ($index = 1; $index <= 3; $index++) {
            $prefixes = (string) config("my.hardware_cloud_routes.route{$index}_prefixes", "");
            $url = (string) config("my.hardware_cloud_routes.route{$index}_url", "");
            $appid = (string) config("my.hardware_cloud_routes.route{$index}_appid", "");
            $appsecret = (string) config("my.hardware_cloud_routes.route{$index}_appsecret", "");
            if (trim($prefixes) === '' && trim($url) === '' && trim($appid) === '' && trim($appsecret) === '') {
                continue;
            }
            $routes[] = [
                'name' => (string) config("my.hardware_cloud_routes.route{$index}_name", "硬件云路由{$index}"),
                'prefixes' => $prefixes,
                'url' => $url,
                'appid' => $appid,
                'appsecret' => $appsecret,
                'enabled' => config("my.hardware_cloud_routes.route{$index}_enabled", $index === 1 ? 1 : 0),
            ];
        }
        return $routes;
    }

    private static function RouteEnabled(array $route): bool
    {
        if (!array_key_exists('enabled', $route)) {
            return true;
        }
        $enabled = $route['enabled'];
        return $enabled === true || $enabled === 1 || $enabled === '1' || strtolower((string)$enabled) === 'true';
    }

    private static function RoutePrefixes(array $route): array
    {
        $prefixes = $route['prefixes'] ?? $route['prefix'] ?? [];
        if (is_string($prefixes)) {
            $prefixes = preg_split('/[,，\s]+/u', $prefixes) ?: [];
        }
        if (!is_array($prefixes)) {
            return [];
        }
        return array_values(array_filter(array_map(static function ($prefix) {
            return strtoupper(trim((string)$prefix));
        }, $prefixes), static function ($prefix) {
            return $prefix !== '';
        }));
    }

}
