SET NAMES utf8mb4;

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'wmjv2', '微门禁V2接口', 'video_sdk_appid', '', 'string', '视频SDK AppID', NOW(), 1, 0, 95, 4
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'wmjv2' AND `name` = 'video_sdk_appid');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route1_video_sdk_appid', 'f268a2e5eff745cdba45ea00ec806f6c', 'string', '路由1视频SDK AppID', NOW(), 1, 0, 97, 7
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route1_video_sdk_appid');

UPDATE `cd_appconfig`
SET `value` = 'f268a2e5eff745cdba45ea00ec806f6c'
WHERE `module` = 'hardware_cloud_routes'
  AND `name` = 'route1_video_sdk_appid'
  AND (`value` IS NULL OR `value` = '');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route2_video_sdk_appid', '', 'string', '路由2视频SDK AppID', NOW(), 1, 0, 97, 13
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route2_video_sdk_appid');

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'hardware_cloud_routes', '硬件云路由配置', 'route3_video_sdk_appid', '', 'string', '路由3视频SDK AppID', NOW(), 1, 0, 97, 19
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'hardware_cloud_routes' AND `name` = 'route3_video_sdk_appid');

UPDATE `cd_appconfig`
SET `module_name` = '硬件云路由配置',
    `description` = CASE `name`
        WHEN 'route1_video_sdk_appid' THEN '路由1视频SDK AppID'
        WHEN 'route2_video_sdk_appid' THEN '路由2视频SDK AppID'
        WHEN 'route3_video_sdk_appid' THEN '路由3视频SDK AppID'
        ELSE `description`
    END,
    `type` = 'string',
    `is_grouped` = 1,
    `is_readonly` = 0,
    `sort_order` = 97
WHERE `module` = 'hardware_cloud_routes'
  AND `name` IN ('route1_video_sdk_appid', 'route2_video_sdk_appid', 'route3_video_sdk_appid');
