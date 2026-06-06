INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'miniapp', '小程序运行配置', 'site_url', 'https://demo.wmj.com.cn', 'string', '小程序站点地址', 1, 0, 90, 1
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'miniapp' AND `name` = 'site_url');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'miniapp', '小程序运行配置', 'api_url', 'https://demo.wmj.com.cn/api', 'string', '小程序接口地址', 1, 0, 90, 2
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'miniapp' AND `name` = 'api_url');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'miniapp', '小程序运行配置', 'asset_url', 'https://demo.wmj.com.cn', 'string', '小程序资源地址', 1, 0, 90, 3
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'miniapp' AND `name` = 'asset_url');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'miniapp', '小程序运行配置', 'camweb_url', 'https://demo.wmj.com.cn/camweb/', 'string', '摄像头 Web 地址', 1, 0, 90, 4
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'miniapp' AND `name` = 'camweb_url');

INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'enabled', '0', 'boolean', '是否启用实时对讲', 1, 0, 89, 1
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'enabled');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'public_wss_base', '', 'string', '公开 WebSocket 基础地址', 1, 0, 89, 2
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'public_wss_base');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'app_ws_protocol', 'wss', 'string', 'WebSocket 协议', 1, 0, 89, 3
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'app_ws_protocol');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'app_ws_host', '', 'string', 'WebSocket 主机', 1, 0, 89, 4
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'app_ws_host');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'app_ws_port', '', 'string', 'WebSocket 端口', 1, 0, 89, 5
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'app_ws_port');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'app_ws_path_prefix', '/ws/horn/live/app', 'string', 'WebSocket 路径前缀', 1, 0, 89, 6
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'app_ws_path_prefix');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'sample_rate', '16000', 'integer', '采样率', 1, 0, 89, 7
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'sample_rate');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'channels', '1', 'integer', '声道数', 1, 0, 89, 8
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'channels');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'encode_bitrate', '64000', 'integer', '编码码率', 1, 0, 89, 9
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'encode_bitrate');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'frame_size_kb', '1', 'integer', '录音分片大小 KB', 1, 0, 89, 10
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'frame_size_kb');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'chunk_delay_ms', '40', 'integer', '音频分片发送间隔毫秒', 1, 0, 89, 11
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'chunk_delay_ms');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'max_duration_sec', '90', 'integer', '单次对讲最长秒数', 1, 0, 89, 12
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'max_duration_sec');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'app_upload_codec', 'mp3', 'string', '小程序上传音频编码', 1, 0, 89, 13
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'app_upload_codec');
INSERT INTO `cd_appconfig` (`module`, `module_name`, `name`, `value`, `type`, `description`, `is_grouped`, `is_readonly`, `sort_order`, `group_sort_order`)
SELECT 'live_talk', '实时对讲配置', 'default_audio_url', '/audio/wmj.mp3', 'string', '默认测试音频地址', 1, 0, 89, 14
WHERE NOT EXISTS (SELECT 1 FROM `cd_appconfig` WHERE `module` = 'live_talk' AND `name` = 'default_audio_url');
