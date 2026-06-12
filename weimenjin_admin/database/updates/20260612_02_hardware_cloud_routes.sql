SET NAMES utf8mb4;

DELETE FROM `cd_appconfig`
WHERE `module` = 'hardware_cloud_routes'
  AND `name` = 'routes';

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_enabled', '1', 'boolean', '路由1启用', NOW(), 1, 0, 97, 1
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_enabled');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_name', '摄像头官方硬件云', 'string', '路由1名称', NOW(), 1, 0, 97, 2
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_name');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_prefixes', 'W33,W34', 'string', '路由1设备前缀', NOW(), 1, 0, 97, 3
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_prefixes');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_url', 'https://wdev.wmj.com.cn/deviceApi/', 'string', '路由1硬件云地址', NOW(), 1, 0, 97, 4
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_url');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_appid', '', 'string', '路由1硬件云appid', NOW(), 1, 0, 97, 5
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_appid');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_appsecret', '', 'string', '路由1硬件云appsecret', NOW(), 1, 0, 97, 6
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_appsecret');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', `name`, `value`, `type`, `description`, NOW(), 1, 0, 97, `group_sort_order`
FROM (
  SELECT 'route2_enabled' AS `name`, '0' AS `value`, 'boolean' AS `type`, '路由2启用' AS `description`, 7 AS `group_sort_order`
  UNION ALL SELECT 'route2_name', '', 'string', '路由2名称', 8
  UNION ALL SELECT 'route2_prefixes', '', 'string', '路由2设备前缀', 9
  UNION ALL SELECT 'route2_url', '', 'string', '路由2硬件云地址', 10
  UNION ALL SELECT 'route2_appid', '', 'string', '路由2硬件云appid', 11
  UNION ALL SELECT 'route2_appsecret', '', 'string', '路由2硬件云appsecret', 12
  UNION ALL SELECT 'route3_enabled', '0', 'boolean', '路由3启用', 13
  UNION ALL SELECT 'route3_name', '', 'string', '路由3名称', 14
  UNION ALL SELECT 'route3_prefixes', '', 'string', '路由3设备前缀', 15
  UNION ALL SELECT 'route3_url', '', 'string', '路由3硬件云地址', 16
  UNION ALL SELECT 'route3_appid', '', 'string', '路由3硬件云appid', 17
  UNION ALL SELECT 'route3_appsecret', '', 'string', '路由3硬件云appsecret', 18
) AS route_defaults
WHERE NOT EXISTS (
  SELECT 1 FROM `cd_appconfig`
  WHERE `module` = 'hardware_cloud_routes'
    AND `name` = route_defaults.`name`
);

UPDATE `cd_appconfig`
SET `module_name` = '硬件云路由配置',
    `is_grouped` = 1,
    `is_readonly` = 0,
    `sort_order` = 97
WHERE `module` = 'hardware_cloud_routes';
