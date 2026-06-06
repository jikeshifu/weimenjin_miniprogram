SET NAMES utf8mb4;

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `created_at`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
VALUES
('wmjv1', '微门禁V1接口', 'wmjv1_url', 'https://www.wmj.com.cn', 'string', '微门禁V1硬件云地址', NOW(), 1, 0, 96, 1),
('wmjv2', '微门禁V2接口', 'wmjv2_url', 'https://wdev.wmj.com.cn/deviceApi/', 'string', '微门禁V2硬件云地址', NOW(), 1, 0, 95, 1)
ON DUPLICATE KEY UPDATE
`module_name` = VALUES(`module_name`),
`description` = VALUES(`description`),
`type` = VALUES(`type`),
`is_grouped` = VALUES(`is_grouped`),
`is_readonly` = VALUES(`is_readonly`),
`sort_order` = VALUES(`sort_order`),
`group_sort_order` = VALUES(`group_sort_order`);

UPDATE `cd_appconfig`
SET `module_name` = '微门禁V1接口',
    `description` = CASE `name`
        WHEN 'wmjv1_appid' THEN '微门禁V1硬件appid'
        WHEN 'wmjv1_appsecret' THEN '微门禁V1硬件appsecret'
        ELSE `description`
    END,
    `sort_order` = 96,
    `group_sort_order` = CASE `name`
        WHEN 'wmjv1_url' THEN 1
        WHEN 'wmjv1_appid' THEN 2
        WHEN 'wmjv1_appsecret' THEN 3
        ELSE `group_sort_order`
    END
WHERE `module` = 'wmjv1'
  AND `name` IN ('wmjv1_url', 'wmjv1_appid', 'wmjv1_appsecret');

UPDATE `cd_appconfig`
SET `module_name` = '微门禁V2接口',
    `description` = CASE `name`
        WHEN 'wmjv2_appid' THEN '微门禁V2硬件appid'
        WHEN 'wmjv2_appsecret' THEN '微门禁V2硬件appsecret'
        ELSE `description`
    END,
    `sort_order` = 95,
    `group_sort_order` = CASE `name`
        WHEN 'wmjv2_url' THEN 1
        WHEN 'wmjv2_appid' THEN 2
        WHEN 'wmjv2_appsecret' THEN 3
        ELSE `group_sort_order`
    END
WHERE `module` = 'wmjv2'
  AND `name` IN ('wmjv2_url', 'wmjv2_appid', 'wmjv2_appsecret');
