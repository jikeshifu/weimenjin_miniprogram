SET NAMES utf8mb4;

UPDATE `cd_appconfig`
SET `module_name` = '备案信息',
    `description` = '是否显示工信部备案'
WHERE `module` = 'siteconfig'
  AND `name` = 'icp_enabled';

UPDATE `cd_appconfig`
SET `module_name` = '备案信息',
    `description` = '工信部备案号'
WHERE `module` = 'siteconfig'
  AND `name` = 'icp_no';

UPDATE `cd_appconfig`
SET `module_name` = '备案信息',
    `description` = '工信部备案链接'
WHERE `module` = 'siteconfig'
  AND `name` = 'icp_url';
