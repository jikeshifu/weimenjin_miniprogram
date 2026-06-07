SET NAMES utf8mb4;

UPDATE `cd_config`
SET `data` = '/static/img/wmjlogo.png'
WHERE `name` = 'site_logo'
  AND (
    `data` IS NULL
    OR `data` = ''
    OR `data` = '/static/css/patterns/header-profile.png'
    OR `data` = '/static/img/head.jpg'
  );
