SET NAMES utf8mb4;

INSERT INTO `cd_appconfig`
(`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT
    'login',
    '登录设置',
    'disclaimer_content',
    '',
    'string',
    '登录页免责声明',
    1,
    0,
    90,
    1
WHERE NOT EXISTS (
    SELECT 1 FROM `cd_appconfig` WHERE `module` = 'login' AND `name` = 'disclaimer_content'
);
