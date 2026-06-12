SET NAMES utf8mb4;

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT
  'hardware_cloud_routes',
  '硬件云路由配置',
  'routes',
  '[{\"name\":\"摄像头官方硬件云\",\"prefixes\":\"W33,W34\",\"url\":\"https://wdev.wmj.com.cn/deviceApi/\",\"appid\":\"\",\"appsecret\":\"\",\"enabled\":1}]',
  'array',
  '按设备前缀选择硬件云',
  NOW(),
  1,
  0,
  97,
  1
WHERE NOT EXISTS (
  SELECT 1 FROM `cd_appconfig`
  WHERE `module` = 'hardware_cloud_routes'
    AND `name` = 'routes'
);

UPDATE `cd_appconfig`
SET `module_name` = '硬件云路由配置',
    `type` = 'array',
    `description` = '按设备前缀选择硬件云',
    `is_grouped` = 1,
    `is_readonly` = 0,
    `sort_order` = 97,
    `group_sort_order` = 1
WHERE `module` = 'hardware_cloud_routes'
  AND `name` = 'routes';

UPDATE `cd_appconfig`
SET `value` = '[{\"name\":\"摄像头官方硬件云\",\"prefixes\":\"W33,W34\",\"url\":\"https://wdev.wmj.com.cn/deviceApi/\",\"appid\":\"\",\"appsecret\":\"\",\"enabled\":1}]'
WHERE `module` = 'hardware_cloud_routes'
  AND `name` = 'routes'
  AND (`value` IS NULL OR `value` = '');
