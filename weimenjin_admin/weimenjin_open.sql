-- ================================================================
-- Weimenjin open-source final database script
-- Import this file into a new database directly.
-- This release keeps only this final SQL file.
-- ================================================================

/*
 Navicat Premium Data Transfer

 Source Server         : weimenjin_open
 Source Server Type    : MySQL
 Source Server Version : 80024
 Source Host           : your-db-host.example:3306
 Source Schema         : weimenjin_open

 Target Server Type    : MySQL
 Target Server Version : 80024
 File Encoding         : 65001

 Date: 30/12/2025 14:00:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cd_access
-- ----------------------------
DROP TABLE IF EXISTS `cd_access`;
CREATE TABLE `cd_access`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `purviewval` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分组对应权限值',
  `group_id` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3114 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_action
-- ----------------------------
DROP TABLE IF EXISTS `cd_action`;
CREATE TABLE `cd_action`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL COMMENT '模块ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '动作名称',
  `action_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '动作名称',
  `type` tinyint NOT NULL,
  `icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'icon图标',
  `pagesize` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '20' COMMENT '每页显示数据条数',
  `is_view` tinyint NULL DEFAULT 0 COMMENT '是否按钮',
  `button_status` tinyint NULL DEFAULT NULL COMMENT '按钮是否显示列表',
  `sql_query` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'sql数据源',
  `block_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注释',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '打开页面尺寸',
  `fields` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '操作的字段',
  `note` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `lable_color` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '按钮背景色',
  `relate_table` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关联表',
  `relate_field` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关联字段',
  `list_field` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '查询的字段',
  `bs_icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '按钮图标',
  `sortid` mediumint NULL DEFAULT 0 COMMENT '排序',
  `orderby` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配置排序',
  `default_orderby` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '默认排序',
  `tree_config` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `jump` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '按钮跳转地址',
  `is_controller_create` tinyint NULL DEFAULT 1 COMMENT '是否生成控制其方法',
  `is_service_create` tinyint NULL DEFAULT NULL COMMENT '是否生成服务层方法',
  `is_view_create` tinyint NULL DEFAULT NULL COMMENT '视图生成',
  `cache_time` mediumint NULL DEFAULT NULL COMMENT '缓存时间',
  `log_status` tinyint NULL DEFAULT NULL COMMENT '是否生成日志',
  `api_auth` tinyint NULL DEFAULT NULL COMMENT '接口是否鉴权',
  `sms_auth` tinyint NULL DEFAULT NULL COMMENT '短信验证',
  `request_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '请求类型 get 或者 post',
  `captcha_auth` tinyint NULL DEFAULT NULL COMMENT '图片验证码验证',
  `do_condition` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作条件',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2915 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_adlog
-- ----------------------------
DROP TABLE IF EXISTS `cd_adlog`;
CREATE TABLE `cd_adlog`  (
  `adlog_id` int NOT NULL AUTO_INCREMENT COMMENT '广告日志id',
  `member_id` int NULL DEFAULT NULL COMMENT '加载广告的用户id',
  `adlog_page` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '广告页面',
  `adlog_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '广告类型',
  `adlog_adtime` int NULL DEFAULT NULL COMMENT '广告时长',
  `adlog_result` tinyint NULL DEFAULT NULL COMMENT '广告观看结果',
  `adlog_msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '消息',
  `adlog_createtime` int NULL DEFAULT NULL COMMENT '创建时间',
  `adlog_points` int NULL DEFAULT 0 COMMENT '积分',
  PRIMARY KEY (`adlog_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 381943 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_appconfig
-- ----------------------------
DROP TABLE IF EXISTS `cd_appconfig`;
CREATE TABLE `cd_appconfig`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `module_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_grouped` tinyint(1) NULL DEFAULT 1 COMMENT '是否分组',
  `is_readonly` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否只读',
  `sort_order` int NOT NULL DEFAULT 0 COMMENT '排序字段',
  `group_sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_module_name`(`module`, `name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 134 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_appconfig
-- ----------------------------
INSERT INTO `cd_appconfig` VALUES (1, 'base', '基本参数', 'drop_table_status', '1', 'boolean', '卸载时数据表是否也删除', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (2, 'base', '基本参数', 'drop_field_status', '1', 'boolean', '删除字段时数据表字段是否也删除', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (3, 'base', '基本参数', 'config_module_id', '41', 'integer', '系统配置业务模块ID', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (4, 'base', '基本参数', 'drop_application_status', '1', 'boolean', '卸载应用时是否删除文件', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (5, 'base', '基本参数', 'max_dump_data', '50000', 'integer', 'excel最大导出数据量', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (6, 'base', '基本参数', 'upload_dir', './uploads', 'string', '文件上传根目录', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (7, 'base', '基本参数', 'upload_subdir', 'Ym', 'string', '文件上传二级目录（日期格式）', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (8, 'base', '基本参数', 'nocheck', '["/admin/Login/Verify","/admin/Login/indexQrCode","/admin/Login/index","/admin/Index/index","/admin/Index/main","/admin/Login/out","/admin/Upload/editorUpload","/admin/Upload/uploadImages","/admin/Upload/uploadUeditor","/admin/Login/captcha","/admin/SystemUpdate/index","/admin/SystemUpdate/check","/admin/SystemUpdate/install","/admin/SystemUpdate/logs","/admin/SystemUpdate/databaseCheck","/admin/SystemUpdate/databaseRepair"]', 'array', '无需验证的权限URL', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (9, 'base', '基本参数', 'img_show_status', '1', 'boolean', '鼠标悬停时是否显示图片', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (10, 'base', '基本参数', 'export_per_num', '50', 'integer', 'excel每次导入数据量', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (11, 'base', '基本参数', 'import_type', 'csv', 'string', '导入文件类型', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (12, 'base', '基本参数', 'clear_cache_dir', '1', 'boolean', '是否清除缓存', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (13, 'base', '基本参数', 'password_secrect', 'change-me', 'string', '密码加密密钥', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (14, 'api', '接口参数', 'api_input_log', '1', 'boolean', '是否记录API输入日志', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (15, 'api', '接口参数', 'successCode', '200', 'string', '成功返回码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (16, 'api', '接口参数', 'errorCode', '201', 'string', '错误返回码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (17, 'api', '接口参数', 'jwtExpireCode', '101', 'string', 'JWT过期码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (18, 'api', '接口参数', 'jwtErrorCode', '102', 'string', 'JWT无效码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (19, 'wmjsms', '短信接口', 'wmjsms_appid', '', 'string', '微门禁短信AppID', '2024-10-13 23:11:54', 1, 0, 93, 1);
INSERT INTO `cd_appconfig` VALUES (20, 'wmjsms', '短信接口', 'wmjsms_appsecret', '', 'string', '微门禁短信AppSecret', '2024-10-13 23:11:54', 1, 0, 93, 2);
INSERT INTO `cd_appconfig` VALUES (21, 'wifilock', '联网锁激活秘钥', 'wifilock_key', '', 'string', '联网锁激活密码', '2024-10-13 23:11:54', 0, 0, 91, 1);
INSERT INTO `cd_appconfig` VALUES (22, 'wifilock', '联网锁激活秘钥', 'wifilock_devicecid', '', 'string', '联网锁devicecid', '2024-10-13 23:11:54', 0, 0, 91, 2);
INSERT INTO `cd_appconfig` VALUES (35, 'jwt', 'JWT配置', 'jwt_expire_time', '2592000', 'integer', 'JWT过期时间（秒）', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (36, 'jwt', 'JWT配置', 'jwt_refresh_expire_time', '2592000', 'integer', 'JWT刷新过期时间（秒）', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (37, 'jwt', 'JWT配置', 'jwt_secret', 'change-me-before-deploy-32-bytes-minimum', 'string', 'JWT签名密钥', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (38, 'jwt', 'JWT配置', 'jwt_iss', 'client.weimenjin', 'string', 'JWT发送端', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (39, 'jwt', 'JWT配置', 'jwt_aud', 'server.weimenjin', 'string', 'JWT接收端', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (40, 'wxmp', '微信小程序配置', 'wxmp_appid', '', 'string', 'AppID(小程序ID)', '2024-10-13 23:11:54', 1, 0, 100, 1);
INSERT INTO `cd_appconfig` VALUES (41, 'wxmp', '微信小程序配置', 'wxmp_appsecret', '', 'string', 'AppSecret(小程序密钥)', '2024-10-13 23:11:54', 1, 0, 100, 2);
INSERT INTO `cd_appconfig` VALUES (74, 'api_upload', 'API上传配置', 'api_upload_domain', '', 'string', 'API 上传域名', '2024-10-13 23:32:26', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (75, 'api_upload', 'API上传配置', 'api_upload_ext', 'jpg,png,gif,mp4', 'string', '允许的上传文件类型', '2024-10-13 23:32:26', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (76, 'api_upload', 'API上传配置', 'api_upload_max', '209715200', 'integer', '上传文件最大大小', '2024-10-13 23:32:26', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (77, 'autodtauth', '演示钥匙', 'autodtkey', '0', 'boolean', '是否启用', '2024-10-13 23:32:26', 0, 0, 94, 1);
INSERT INTO `cd_appconfig` VALUES (78, 'autodtauth', '演示钥匙', 'autodtkeylockid', '', 'integer', '演示钥匙lock_id', '2024-10-13 23:32:26', 0, 0, 94, 2);
INSERT INTO `cd_appconfig` VALUES (94, 'official_accounts', '微信公众号配置', 'app_id', '', 'string', '公众号 AppID', '2024-10-13 23:33:09', 1, 0, 99, 1);
INSERT INTO `cd_appconfig` VALUES (95, 'official_accounts', '微信公众号配置', 'secret', '', 'string', '公众号 Secret', '2024-10-13 23:33:09', 1, 0, 99, 2);
INSERT INTO `cd_appconfig` VALUES (96, 'official_accounts', '微信公众号配置', 'token', '', 'string', '公众号 Token', '2024-10-13 23:33:09', 1, 0, 99, 3);
INSERT INTO `cd_appconfig` VALUES (97, 'pay_display', '支付显示配置', 'pay_display', '0', 'integer', '支付方式显示配置', '2024-10-13 23:33:15', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (98, 'wechart_pay', '微信支付配置', 'mch_id', '', 'string', '微信支付商户号', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (99, 'wechart_pay', '微信支付配置', 'key', '', 'string', '微信支付秘钥', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (100, 'wechart_pay', '微信支付配置', 'cert_path', 'extend/utils/wechart/zcerts/apiclient_cert.pem', 'string', '证书路径', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (101, 'wechart_pay', '微信支付配置', 'key_path', 'extend/utils/wechart/zcerts/apiclient_key.pem', 'string', '证书路径', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (102, 'wechart_pay', '微信支付配置', 'rsa_public_key_path', 'extend/utils/wechart/zcerts/public.pem', 'string', 'RSA 公钥路径', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (103, 'wechart_template', '公众号发送消息配置', 'gzhtempleteid1', '', 'string', '开门通知', '2024-10-13 23:33:26', 1, 0, 98, 1);
INSERT INTO `cd_appconfig` VALUES (104, 'wechart_template', '公众号发送消息配置', 'gzhtempleteid2', '', 'string', '申请审核', '2024-10-13 23:33:26', 1, 0, 98, 2);
INSERT INTO `cd_appconfig` VALUES (129, 'wechart_template', '公众号发送消息配置', 'gzhtempleteid3', '', 'string', '审核通过', '2024-10-13 23:33:26', 1, 0, 98, 3);
INSERT INTO `cd_appconfig` VALUES (134, 'wmjv1', '微门禁V1接口', 'wmjv1_url', 'https://www.wmj.com.cn', 'string', '微门禁V1硬件云地址', '2026-06-06 00:00:00', 1, 0, 96, 1);
INSERT INTO `cd_appconfig` VALUES (124, 'wmjv1', '微门禁V1接口', 'wmjv1_appid', '', 'string', '微门禁V1硬件appid', '2024-10-14 06:10:26', 1, 0, 96, 2);
INSERT INTO `cd_appconfig` VALUES (125, 'wmjv1', '微门禁V1接口', 'wmjv1_appsecret', '', 'string', '微门禁V1硬件appsecret', '2024-10-14 06:11:28', 1, 0, 96, 3);
INSERT INTO `cd_appconfig` VALUES (135, 'wmjv2', '微门禁V2接口', 'wmjv2_url', 'https://wdev.wmj.com.cn/deviceApi/', 'string', '微门禁V2硬件云地址', '2026-06-06 00:00:00', 1, 0, 95, 1);
INSERT INTO `cd_appconfig` VALUES (126, 'wmjv2', '微门禁V2接口', 'wmjv2_appid', '', 'string', '微门禁V2硬件appid', '2024-10-14 06:10:26', 1, 0, 95, 2);
INSERT INTO `cd_appconfig` VALUES (127, 'wmjv2', '微门禁V2接口', 'wmjv2_appsecret', '', 'string', '微门禁V2硬件appsecret', '2024-10-14 06:11:28', 1, 0, 95, 3);
INSERT INTO `cd_appconfig` VALUES (157, 'hardware_cloud_routes', '硬件云路由配置', 'route1_enabled', '1', 'boolean', '路由1启用', '2026-06-12 00:00:00', 1, 0, 97, 1);
INSERT INTO `cd_appconfig` VALUES (158, 'hardware_cloud_routes', '硬件云路由配置', 'route1_name', '摄像头官方硬件云', 'string', '路由1名称', '2026-06-12 00:00:00', 1, 0, 97, 2);
INSERT INTO `cd_appconfig` VALUES (159, 'hardware_cloud_routes', '硬件云路由配置', 'route1_prefixes', 'W33,W34', 'string', '路由1设备前缀', '2026-06-12 00:00:00', 1, 0, 97, 3);
INSERT INTO `cd_appconfig` VALUES (160, 'hardware_cloud_routes', '硬件云路由配置', 'route1_url', 'https://wdev.wmj.com.cn/deviceApi/', 'string', '路由1硬件云地址', '2026-06-12 00:00:00', 1, 0, 97, 4);
INSERT INTO `cd_appconfig` VALUES (161, 'hardware_cloud_routes', '硬件云路由配置', 'route1_appid', '', 'string', '路由1硬件云appid', '2026-06-12 00:00:00', 1, 0, 97, 5);
INSERT INTO `cd_appconfig` VALUES (162, 'hardware_cloud_routes', '硬件云路由配置', 'route1_appsecret', '', 'string', '路由1硬件云appsecret', '2026-06-12 00:00:00', 1, 0, 97, 6);
INSERT INTO `cd_appconfig` VALUES (163, 'hardware_cloud_routes', '硬件云路由配置', 'route2_enabled', '0', 'boolean', '路由2启用', '2026-06-12 00:00:00', 1, 0, 97, 7);
INSERT INTO `cd_appconfig` VALUES (164, 'hardware_cloud_routes', '硬件云路由配置', 'route2_name', '', 'string', '路由2名称', '2026-06-12 00:00:00', 1, 0, 97, 8);
INSERT INTO `cd_appconfig` VALUES (165, 'hardware_cloud_routes', '硬件云路由配置', 'route2_prefixes', '', 'string', '路由2设备前缀', '2026-06-12 00:00:00', 1, 0, 97, 9);
INSERT INTO `cd_appconfig` VALUES (166, 'hardware_cloud_routes', '硬件云路由配置', 'route2_url', '', 'string', '路由2硬件云地址', '2026-06-12 00:00:00', 1, 0, 97, 10);
INSERT INTO `cd_appconfig` VALUES (167, 'hardware_cloud_routes', '硬件云路由配置', 'route2_appid', '', 'string', '路由2硬件云appid', '2026-06-12 00:00:00', 1, 0, 97, 11);
INSERT INTO `cd_appconfig` VALUES (168, 'hardware_cloud_routes', '硬件云路由配置', 'route2_appsecret', '', 'string', '路由2硬件云appsecret', '2026-06-12 00:00:00', 1, 0, 97, 12);
INSERT INTO `cd_appconfig` VALUES (169, 'hardware_cloud_routes', '硬件云路由配置', 'route3_enabled', '0', 'boolean', '路由3启用', '2026-06-12 00:00:00', 1, 0, 97, 13);
INSERT INTO `cd_appconfig` VALUES (170, 'hardware_cloud_routes', '硬件云路由配置', 'route3_name', '', 'string', '路由3名称', '2026-06-12 00:00:00', 1, 0, 97, 14);
INSERT INTO `cd_appconfig` VALUES (171, 'hardware_cloud_routes', '硬件云路由配置', 'route3_prefixes', '', 'string', '路由3设备前缀', '2026-06-12 00:00:00', 1, 0, 97, 15);
INSERT INTO `cd_appconfig` VALUES (172, 'hardware_cloud_routes', '硬件云路由配置', 'route3_url', '', 'string', '路由3硬件云地址', '2026-06-12 00:00:00', 1, 0, 97, 16);
INSERT INTO `cd_appconfig` VALUES (173, 'hardware_cloud_routes', '硬件云路由配置', 'route3_appid', '', 'string', '路由3硬件云appid', '2026-06-12 00:00:00', 1, 0, 97, 17);
INSERT INTO `cd_appconfig` VALUES (174, 'hardware_cloud_routes', '硬件云路由配置', 'route3_appsecret', '', 'string', '路由3硬件云appsecret', '2026-06-12 00:00:00', 1, 0, 97, 18);
INSERT INTO `cd_appconfig` VALUES (128, 'wmjsms', '短信接口', 'wmjsms_lable', '【微门禁】', 'string', '短信签名', '2024-10-14 23:32:23', 1, 0, 93, 3);
INSERT INTO `cd_appconfig` VALUES (130, 'siteconfig', '站点链接', 'siteurl', 'https://demo.wmj.com.cn', 'string', '站点链接', '2024-11-25 13:40:13', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (154, 'siteconfig', '站点链接', 'icp_enabled', '1', 'boolean', '是否显示工信部备案', '2026-06-09 00:00:00', 1, 0, 90, 2);
INSERT INTO `cd_appconfig` VALUES (155, 'siteconfig', '站点链接', 'icp_no', '', 'string', '工信部备案号', '2026-06-09 00:00:00', 1, 0, 90, 3);
INSERT INTO `cd_appconfig` VALUES (156, 'siteconfig', '站点链接', 'icp_url', 'https://beian.miit.gov.cn/', 'string', '工信部备案链接', '2026-06-09 00:00:00', 1, 0, 90, 4);
INSERT INTO `cd_appconfig` VALUES (131, 'update', '系统更新', 'current_version', '2026.06.09.10', 'string', '当前版本号', '2026-06-06 00:00:00', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (132, 'update', '系统更新', 'manifest_url', 'https://demo.wmj.com.cn/updates/manifest.json', 'string', '更新清单地址', '2026-06-06 00:00:00', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (133, 'login', '登录设置', 'disclaimer_content', '开源免责声明
本开源版本仅用于学习、研究、演示和二次开发参考，不承诺适用于任何特定业务场景。使用者应自行评估系统功能、数据安全、网络安全、设备兼容性和合规要求。
因部署、配置、修改、使用本系统或与第三方硬件、云服务、支付、短信、微信接口等集成产生的任何故障、数据丢失、资损、业务中断、法律责任或其他损失，由使用者自行承担。
正式商用、生产部署或接入真实门禁设备前，请完成充分测试、权限隔离、数据备份、安全加固和合规审查。

门禁及远程控制设备免责声明
门禁、开门、摄像头、继电器、开关等远程控制设备涉及人员通行、财产安全和现场设备状态。使用者应确保设备安装、供电、联网、权限分配、日志审计和应急处置符合实际场景要求。
远程开门、批量授权、设备重绑、摄像头控制等操作可能受到网络延迟、设备离线、云服务异常、权限配置错误、人员误操作等因素影响。由此产生的通行风险、设备误动作、现场安全事件或业务损失，由使用者自行承担。
请勿将本系统作为唯一安全保障手段。正式使用前应建立线下核验、人工复核、备用通行、权限回收、数据备份和安全巡检机制。', 'string', '登录页免责声明', '2026-06-06 00:00:00', 1, 0, 90, 1);

INSERT INTO `cd_appconfig` VALUES (136, 'miniapp', '小程序运行配置', 'site_url', 'https://demo.wmj.com.cn', 'string', '小程序站点地址', '2026-06-06 00:00:00', 1, 0, 90, 1);
INSERT INTO `cd_appconfig` VALUES (137, 'miniapp', '小程序运行配置', 'api_url', 'https://demo.wmj.com.cn/api', 'string', '小程序接口地址', '2026-06-06 00:00:00', 1, 0, 90, 2);
INSERT INTO `cd_appconfig` VALUES (138, 'miniapp', '小程序运行配置', 'asset_url', 'https://demo.wmj.com.cn', 'string', '小程序资源地址', '2026-06-06 00:00:00', 1, 0, 90, 3);
INSERT INTO `cd_appconfig` VALUES (139, 'miniapp', '小程序运行配置', 'camweb_url', 'https://demo.wmj.com.cn/camweb/', 'string', '摄像头 Web 地址', '2026-06-06 00:00:00', 1, 0, 90, 4);
INSERT INTO `cd_appconfig` VALUES (140, 'live_talk', '实时对讲配置', 'enabled', '0', 'boolean', '是否启用实时对讲', '2026-06-06 00:00:00', 1, 0, 89, 1);
INSERT INTO `cd_appconfig` VALUES (141, 'live_talk', '实时对讲配置', 'public_wss_base', '', 'string', '公开 WebSocket 基础地址', '2026-06-06 00:00:00', 1, 0, 89, 2);
INSERT INTO `cd_appconfig` VALUES (142, 'live_talk', '实时对讲配置', 'app_ws_protocol', 'wss', 'string', 'WebSocket 协议', '2026-06-06 00:00:00', 1, 0, 89, 3);
INSERT INTO `cd_appconfig` VALUES (143, 'live_talk', '实时对讲配置', 'app_ws_host', '', 'string', 'WebSocket 主机', '2026-06-06 00:00:00', 1, 0, 89, 4);
INSERT INTO `cd_appconfig` VALUES (144, 'live_talk', '实时对讲配置', 'app_ws_port', '', 'string', 'WebSocket 端口', '2026-06-06 00:00:00', 1, 0, 89, 5);
INSERT INTO `cd_appconfig` VALUES (145, 'live_talk', '实时对讲配置', 'app_ws_path_prefix', '/ws/horn/live/app', 'string', 'WebSocket 路径前缀', '2026-06-06 00:00:00', 1, 0, 89, 6);
INSERT INTO `cd_appconfig` VALUES (146, 'live_talk', '实时对讲配置', 'sample_rate', '16000', 'integer', '采样率', '2026-06-06 00:00:00', 1, 0, 89, 7);
INSERT INTO `cd_appconfig` VALUES (147, 'live_talk', '实时对讲配置', 'channels', '1', 'integer', '声道数', '2026-06-06 00:00:00', 1, 0, 89, 8);
INSERT INTO `cd_appconfig` VALUES (148, 'live_talk', '实时对讲配置', 'encode_bitrate', '64000', 'integer', '编码码率', '2026-06-06 00:00:00', 1, 0, 89, 9);
INSERT INTO `cd_appconfig` VALUES (149, 'live_talk', '实时对讲配置', 'frame_size_kb', '1', 'integer', '录音分片大小 KB', '2026-06-06 00:00:00', 1, 0, 89, 10);
INSERT INTO `cd_appconfig` VALUES (150, 'live_talk', '实时对讲配置', 'chunk_delay_ms', '40', 'integer', '音频分片发送间隔毫秒', '2026-06-06 00:00:00', 1, 0, 89, 11);
INSERT INTO `cd_appconfig` VALUES (151, 'live_talk', '实时对讲配置', 'max_duration_sec', '90', 'integer', '单次对讲最长秒数', '2026-06-06 00:00:00', 1, 0, 89, 12);
INSERT INTO `cd_appconfig` VALUES (152, 'live_talk', '实时对讲配置', 'app_upload_codec', 'mp3', 'string', '小程序上传音频编码', '2026-06-06 00:00:00', 1, 0, 89, 13);
INSERT INTO `cd_appconfig` VALUES (153, 'live_talk', '实时对讲配置', 'default_audio_url', '/audio/wmj.mp3', 'string', '默认测试音频地址', '2026-06-06 00:00:00', 1, 0, 89, 14);

-- ----------------------------
-- Table structure for cd_application
-- ----------------------------
DROP TABLE IF EXISTS `cd_application`;
CREATE TABLE `cd_application`  (
  `app_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `app_dir` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint NULL DEFAULT NULL,
  `app_type` tinyint NULL DEFAULT NULL,
  `login_table` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `login_fields` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `domain` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pk` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录表主键',
  PRIMARY KEY (`app_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 182 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_cam_remote_control
-- ----------------------------
DROP TABLE IF EXISTS `cd_cam_remote_control`;
CREATE TABLE `cd_cam_remote_control`  (
  `control_id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'device sn',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'remote control title',
  `member_id` int NULL DEFAULT NULL COMMENT 'member id',
  `open` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'open command',
  `close` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'close command',
  `stop` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'stop command',
  `customize` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'custom command',
  `created_at` int NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`control_id`) USING BTREE,
  INDEX `device_sn`(`device_sn`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_config
-- ----------------------------
DROP TABLE IF EXISTS `cd_config`;
CREATE TABLE `cd_config`  (
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_device_group
-- ----------------------------
DROP TABLE IF EXISTS `cd_device_group`;
CREATE TABLE `cd_device_group`  (
  `device_group_id` bigint NOT NULL AUTO_INCREMENT COMMENT '设备分组·',
  `device_group_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `created_at` bigint NULL DEFAULT NULL,
  `updated_at` bigint NULL DEFAULT 0,
  `deleted_at` datetime NULL DEFAULT NULL,
  `member_id` bigint NULL DEFAULT NULL,
  `type` int NULL DEFAULT 0,
  PRIMARY KEY (`device_group_id`) USING BTREE,
  INDEX `idx_member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_doorstatus
-- ----------------------------
DROP TABLE IF EXISTS `cd_doorstatus`;
CREATE TABLE `cd_doorstatus`  (
  `doorstatus_id` int NOT NULL AUTO_INCREMENT,
  `doorstatus_sn` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `doorstatus_action` smallint NULL DEFAULT NULL COMMENT '状态',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理用户',
  `doorstatus_time` int NULL DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`doorstatus_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 223 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_electricity
-- ----------------------------
DROP TABLE IF EXISTS `cd_electricity`;
CREATE TABLE `cd_electricity`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `electricity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` bigint NULL DEFAULT NULL,
  `device_sn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_ext_health
-- ----------------------------
DROP TABLE IF EXISTS `cd_ext_health`;
CREATE TABLE `cd_ext_health`  (
  `health_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `mobile` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `first_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '第一居住地址',
  `second_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '第二居住地址',
  `job` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '工作或学习单位',
  `yiqu` tinyint UNSIGNED NOT NULL DEFAULT 2 COMMENT '30日内是否来自疫区:1是,默认2否',
  `register_type` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '登记类型:默认1村居,2乡镇社区,3区县,4交通运输',
  `health` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '健康状况默认1健康,2异常,3其他',
  `manyou` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '通行证截图',
  `ctime` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `utime` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  PRIMARY KEY (`health_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_face
-- ----------------------------
DROP TABLE IF EXISTS `cd_face`;
CREATE TABLE `cd_face`  (
  `face_id` bigint NOT NULL AUTO_INCREMENT,
  `face_name` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸备注',
  `face_images` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸图片地址',
  `created_at` int NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint NULL DEFAULT NULL,
  `member_id` bigint NULL DEFAULT NULL,
  `sCertificateNumber` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sync_status` tinyint NULL DEFAULT 1,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sync_time` bigint NULL DEFAULT 0,
  `face_feature` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`face_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_field
-- ----------------------------
DROP TABLE IF EXISTS `cd_field`;
CREATE TABLE `cd_field`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL COMMENT '模块ID',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '字段名称',
  `field` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint NOT NULL COMMENT '表单类型1输入框 2下拉框 3单选框 4多选框 5上传图片 6编辑器 7时间',
  `list_show` tinyint NULL DEFAULT NULL COMMENT '列表显示',
  `search_show` tinyint NULL DEFAULT NULL COMMENT '搜索显示',
  `search_type` tinyint NULL DEFAULT NULL COMMENT '1精确匹配 2模糊搜索',
  `config` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '下拉框或者单选框配置',
  `is_post` tinyint NULL DEFAULT NULL COMMENT '是否前台录入',
  `is_field` tinyint NULL DEFAULT NULL,
  `align` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '表格显示位置',
  `note` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提示信息',
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '错误提示',
  `validate` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '验证方式',
  `rule` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '验证规则',
  `sortid` mediumint NULL DEFAULT 0 COMMENT '排序号',
  `sql` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字段配置数据源sql',
  `tab_menu_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属选项卡名称',
  `default_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `datatype` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字段数据类型',
  `length` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字段长度',
  `indexdata` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '索引',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3588 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_file
-- ----------------------------
DROP TABLE IF EXISTS `cd_file`;
CREATE TABLE `cd_file`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片路径',
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件hash值',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_finger
-- ----------------------------
DROP TABLE IF EXISTS `cd_finger`;
CREATE TABLE `cd_finger`  (
  `finger_id` bigint NOT NULL AUTO_INCREMENT,
  `fp_id` int NULL DEFAULT NULL COMMENT '指纹id',
  `finger_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '指纹名称',
  `created_at` bigint NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`finger_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 136 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_group
-- ----------------------------
DROP TABLE IF EXISTS `cd_group`;
CREATE TABLE `cd_group`  (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分组名称',
  `status` tinyint NULL DEFAULT NULL COMMENT '状态 10正常 0禁用',
  `role` tinyint NULL DEFAULT NULL COMMENT '角色类别 1超级管理员 2普通管理员',
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_gzh_member
-- ----------------------------
DROP TABLE IF EXISTS `cd_gzh_member`;
CREATE TABLE `cd_gzh_member`  (
  `gzh_member_id` int NOT NULL AUTO_INCREMENT,
  `openid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unionid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`gzh_member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_health
-- ----------------------------
DROP TABLE IF EXISTS `cd_health`;
CREATE TABLE `cd_health`  (
  `health_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `first_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '居住地址',
  `second_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '第二居住地址',
  `job` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '工作或学习单位',
  `yiqu` smallint NULL DEFAULT NULL COMMENT '是否来自疫区',
  `register_type` smallint NULL DEFAULT NULL COMMENT '登记类型',
  `health` smallint NULL DEFAULT NULL COMMENT '健康状况',
  `manyou` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '证明图片',
  `ctime` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `position` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定位地址',
  `lat` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经度',
  `lng` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '纬度',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属用户',
  `openid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'openid',
  `regpoint_id` int NULL DEFAULT NULL COMMENT '登记点ID',
  PRIMARY KEY (`health_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_linkspeaker
-- ----------------------------
DROP TABLE IF EXISTS `cd_linkspeaker`;
CREATE TABLE `cd_linkspeaker`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `linkspeaker_sn` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `linkspeaker_tts` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `linkspeaker_volume` int NULL DEFAULT NULL,
  `lock_id` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `linkspeaker_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_linkswitch
-- ----------------------------
DROP TABLE IF EXISTS `cd_linkswitch`;
CREATE TABLE `cd_linkswitch`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `linkswitch_sn` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lock_id` int NULL DEFAULT NULL,
  `linkswitch_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `open_action` int NULL DEFAULT 0,
  `close_delay` int NULL DEFAULT 0,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_lock
-- ----------------------------
DROP TABLE IF EXISTS `cd_lock`;
CREATE TABLE `cd_lock`  (
  `lock_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `lock_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '锁名称',
  `lock_sn` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户ID',
  `mobile_check` tinyint NULL DEFAULT NULL COMMENT '需绑手机',
  `applyauth` tinyint NULL DEFAULT NULL COMMENT '领取钥匙',
  `applyauth_check` tinyint NULL DEFAULT NULL COMMENT '审核钥匙',
  `status` tinyint NULL DEFAULT NULL COMMENT '启用/禁用',
  `lock_type` smallint NULL DEFAULT NULL COMMENT '类型',
  `location` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '位置',
  `create_time` int NULL DEFAULT NULL COMMENT '添加时间',
  `lock_qrcode` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '二维码',
  `online` smallint NULL DEFAULT NULL COMMENT '在线状态',
  `member_id` int NULL DEFAULT NULL COMMENT '会员id',
  `successimg` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '成功提示图片',
  `successadimg` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '成功广告',
  `location_check` int NULL DEFAULT NULL COMMENT '开门距离(米)',
  `hitshowminiad` tinyint(1) NULL DEFAULT NULL COMMENT '点击开门广告',
  `qrshowminiad` tinyint(1) NULL DEFAULT NULL COMMENT '扫码开门广告',
  `volume` int NULL DEFAULT NULL COMMENT '音量',
  `openttscontent` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '语音内容',
  `addcardmode` int NULL DEFAULT 2 COMMENT '进出发卡模式',
  `openadurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开门成功外链',
  `adnum` smallint NULL DEFAULT NULL COMMENT '成功弹层方式',
  `openbtn` tinyint NULL DEFAULT 1 COMMENT '开门按钮',
  `opsucnt` tinyint NULL DEFAULT NULL COMMENT '开门通知',
  `device_cid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '设备cid',
  `admin_pwd` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '激活的管理密码',
  `hw_ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sw_ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wifi_rssi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `on_line_time` int NULL DEFAULT NULL,
  `model_number` varchar(101) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `hardware_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `firmware_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `iccid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `imei` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `batterypower` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  `rssi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `xcx_sound` tinyint(1) NULL DEFAULT 1,
  `switch_state` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`lock_id`) USING BTREE,
  UNIQUE INDEX `lock_id`(`lock_id`) USING BTREE,
  INDEX `idx_lock_name`(`lock_name`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_lockauth
-- ----------------------------
DROP TABLE IF EXISTS `cd_lockauth`;
CREATE TABLE `cd_lockauth`  (
  `lockauth_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `lock_id` int NULL DEFAULT NULL COMMENT '锁ID',
  `member_id` int NULL DEFAULT NULL COMMENT '会员ID',
  `auth_member_id` int NULL DEFAULT NULL COMMENT '分享人ID',
  `auth_endtime` int NULL DEFAULT NULL COMMENT '有效期结束时间',
  `auth_shareability` tinyint NULL DEFAULT NULL COMMENT '分享权限',
  `aremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `auth_starttime` int NULL DEFAULT NULL COMMENT '有效期起始时间',
  `auth_sharelimit` int NULL DEFAULT NULL COMMENT '可分享钥匙数',
  `auth_openlimit` int NULL DEFAULT 0 COMMENT '可开次数',
  `auth_isadmin` smallint NULL DEFAULT 0 COMMENT '是否管理员',
  `auth_status` smallint NULL DEFAULT 0 COMMENT '审核状态',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `arealname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `auth_opentimes` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '可开时段',
  `auth_tmp` smallint NULL DEFAULT NULL COMMENT '领取标志',
  `auth_openused` int NULL DEFAULT NULL COMMENT '已开次数',
  `device_group_id` bigint NULL DEFAULT 0 COMMENT '分组id默认未分组',
  `deleted_at` datetime NULL DEFAULT NULL,
  `updated_at` bigint NULL DEFAULT NULL,
  `auth_sort` int NULL DEFAULT 0 COMMENT '钥匙排序',
  PRIMARY KEY (`lockauth_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 106 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_lockcard
-- ----------------------------
DROP TABLE IF EXISTS `cd_lockcard`;
CREATE TABLE `cd_lockcard`  (
  `lockcard_id` int NOT NULL AUTO_INCREMENT,
  `lock_id` int NULL DEFAULT NULL COMMENT '锁ID',
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `lockcard_sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '卡序列号',
  `lockcard_endtime` int NULL DEFAULT NULL COMMENT '过期时间',
  `lockcard_username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '持有人',
  `lockcard_remark` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `lockcard_createtime` int NULL DEFAULT NULL COMMENT '发卡时间',
  `lockauth_id` int NULL DEFAULT NULL COMMENT '钥匙ID',
  `batchstatus` smallint NULL DEFAULT NULL COMMENT '发卡状态',
  `deleted_at` datetime NULL DEFAULT NULL,
  `sync_status` tinyint(1) NULL DEFAULT 1,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sync_time` bigint NULL DEFAULT 0,
  PRIMARY KEY (`lockcard_id`) USING BTREE,
  INDEX `lkcdsn`(`lockcard_sn`) USING BTREE,
  INDEX `lockcard_sn`(`lockcard_sn`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_locklog
-- ----------------------------
DROP TABLE IF EXISTS `cd_locklog`;
CREATE TABLE `cd_locklog`  (
  `locklog_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NULL DEFAULT NULL COMMENT '会员ID',
  `lock_id` int NULL DEFAULT NULL COMMENT '锁ID',
  `status` smallint NULL DEFAULT NULL COMMENT '状态',
  `type` smallint NULL DEFAULT NULL COMMENT '类型',
  `create_time` int NULL DEFAULT NULL COMMENT '开门时间',
  `user_id` bigint NULL DEFAULT NULL COMMENT '管理员ID',
  `lremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `cardsn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作人',
  `mobile_bak` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cpurl` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`locklog_id`) USING BTREE,
  UNIQUE INDEX `locklog_id`(`locklog_id`) USING BTREE,
  INDEX `idx_cdsn`(`cardsn`) USING BTREE,
  INDEX `idx_lock_id`(`lock_id`) USING BTREE,
  INDEX `idx_member_id`(`member_id`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE,
  INDEX `creattime`(`create_time`) USING BTREE,
  INDEX `idx_member_lock`(`member_id`, `lock_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1555 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_locktimes
-- ----------------------------
DROP TABLE IF EXISTS `cd_locktimes`;
CREATE TABLE `cd_locktimes`  (
  `locktimes_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `lock_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '锁ID',
  `startweek` smallint NULL DEFAULT NULL COMMENT '周开始',
  `starthour` smallint NULL DEFAULT NULL COMMENT '小时开始',
  `startminute` smallint NULL DEFAULT NULL COMMENT '分钟开始',
  `endweek` smallint NULL DEFAULT NULL COMMENT '周结束',
  `endhour` smallint NULL DEFAULT NULL COMMENT '小时结束',
  `endminute` smallint NULL DEFAULT NULL COMMENT '分钟结束',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `locktimesname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '时段名称',
  `type` smallint NULL DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`locktimes_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_locktype
-- ----------------------------
DROP TABLE IF EXISTS `cd_locktype`;
CREATE TABLE `cd_locktype`  (
  `locktype_id` int NOT NULL AUTO_INCREMENT,
  `locktype_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`locktype_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_log
-- ----------------------------
DROP TABLE IF EXISTS `cd_log`;
CREATE TABLE `cd_log`  (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL COMMENT '用户ID',
  `username` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `event` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` int NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_member
-- ----------------------------
DROP TABLE IF EXISTS `cd_member`;
CREATE TABLE `cd_member`  (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '呢称',
  `headimgurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '头像',
  `openid` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'openid',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机号',
  `username` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '密码',
  `create_time` int NULL DEFAULT NULL COMMENT '注册时间',
  `sex` smallint NULL DEFAULT 0 COMMENT '性别',
  `status` tinyint NULL DEFAULT NULL COMMENT '状态',
  `user_id` int NULL DEFAULT NULL COMMENT '所属用户',
  `ali_user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝用户id',
  `member_type` smallint NULL DEFAULT NULL COMMENT '会员类型',
  `member_ps` smallint NULL DEFAULT NULL COMMENT '同意政策和协议',
  `unionid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'unionid',
  `realname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `remark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sCertificateNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸faceid',
  `level` tinyint NULL DEFAULT 0 COMMENT '级别',
  `wx_model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '设备型号',
  `wx_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信版本',
  `wx_platform` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作系统及版本',
  `wx_system` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客户端平台',
  `SDKVersion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客户端基础库版本',
  `bluetoothEnabled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '蓝牙的系统开关',
  `locationEnabled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地理位置的系统开关',
  `tt_user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`member_id`) USING BTREE,
  UNIQUE INDEX `member_id`(`member_id`) USING BTREE,
  UNIQUE INDEX `openid`(`openid`) USING BTREE,
  INDEX `unionid`(`unionid`) USING BTREE,
  INDEX `mobile`(`mobile`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 86 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_menu
-- ----------------------------
DROP TABLE IF EXISTS `cd_menu`;
CREATE TABLE `cd_menu`  (
  `menu_id` int NOT NULL AUTO_INCREMENT,
  `pid` mediumint NULL DEFAULT 0 COMMENT '父级id',
  `controller_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块名称',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块标题',
  `pk_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主键名',
  `table_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块数据库表',
  `is_create` tinyint NULL DEFAULT NULL COMMENT '是否允许生成模块',
  `status` tinyint NULL DEFAULT NULL COMMENT '0隐藏 10显示',
  `sortid` mediumint NULL DEFAULT 0 COMMENT '排序号',
  `table_status` tinyint NULL DEFAULT NULL COMMENT '是否生成数据库表',
  `is_url` tinyint NULL DEFAULT NULL COMMENT '是否只是url链接',
  `url` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `menu_icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'icon字体图标',
  `tab_menu` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'tab选项卡菜单配置',
  `app_id` int NULL DEFAULT NULL COMMENT '所属模块',
  `is_submit` tinyint NULL DEFAULT NULL COMMENT '是否允许投稿',
  PRIMARY KEY (`menu_id`) USING BTREE,
  INDEX `controller_name`(`controller_name`) USING BTREE,
  INDEX `module_id`(`app_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 832 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_on_line_record
-- ----------------------------
DROP TABLE IF EXISTS `cd_on_line_record`;
CREATE TABLE `cd_on_line_record`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `on_line_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cmd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7131 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_order
-- ----------------------------
DROP TABLE IF EXISTS `cd_order`;
CREATE TABLE `cd_order`  (
  `order_id` bigint NOT NULL AUTO_INCREMENT,
  `order_sn` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `pay_time` datetime NULL DEFAULT NULL,
  `pay_status` int NULL DEFAULT 0,
  `pay_price` bigint NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `member_id` bigint NULL DEFAULT NULL,
  `sim_sn` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_status` tinyint NULL DEFAULT 0 COMMENT '0未续费1续费',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_power
-- ----------------------------
DROP TABLE IF EXISTS `cd_power`;
CREATE TABLE `cd_power`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `batterypower` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_pwd
-- ----------------------------
DROP TABLE IF EXISTS `cd_pwd`;
CREATE TABLE `cd_pwd`  (
  `pwd_id` bigint NOT NULL AUTO_INCREMENT,
  `pwd` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `pwd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码名称',
  `created_at` int NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`pwd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_regpoint
-- ----------------------------
DROP TABLE IF EXISTS `cd_regpoint`;
CREATE TABLE `cd_regpoint`  (
  `regpoint_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `member_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员ID',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户ID',
  `regpointname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `regpointurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册点url',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `regpointqrcode` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登记点二维码',
  `lock_id` int NULL DEFAULT NULL COMMENT '门ID',
  PRIMARY KEY (`regpoint_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_switch_daily_report
-- ----------------------------
DROP TABLE IF EXISTS `cd_switch_daily_report`;
CREATE TABLE `cd_switch_daily_report`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_electricity` decimal(10, 2) NULL DEFAULT 0.00,
  `balance` decimal(10, 2) NULL DEFAULT 0.00,
  `switch_state` tinyint(1) NULL DEFAULT 0,
  `heartbeat` int NULL DEFAULT 0,
  `voltage` decimal(10, 1) NULL DEFAULT 0.0,
  `electric_current` decimal(10, 3) NULL DEFAULT 0.000,
  `power` decimal(10, 2) NULL DEFAULT 0.00,
  `temperature` decimal(5, 1) NULL DEFAULT 0.0,
  `prepay` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT '0.00',
  `retainstate` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created` int NULL DEFAULT NULL,
  `daily_electricity_usage` decimal(10, 2) NULL DEFAULT NULL,
  `updated_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_umember
-- ----------------------------
DROP TABLE IF EXISTS `cd_umember`;
CREATE TABLE `cd_umember`  (
  `umember_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NULL DEFAULT NULL COMMENT '用户ID',
  `user_id` bigint NULL DEFAULT NULL COMMENT '管理员ID',
  `status` smallint NULL DEFAULT NULL COMMENT '状态',
  `ucreate_time` int NULL DEFAULT NULL COMMENT '注册时间',
  `urealname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `authlocks` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权锁',
  `uremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`umember_id`) USING BTREE,
  INDEX `idx_member_id_user_id`(`member_id`, `user_id`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_user
-- ----------------------------
DROP TABLE IF EXISTS `cd_user`;
CREATE TABLE `cd_user`  (
  `user_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `user` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录用户名',
  `pwd` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录密码',
  `group_id` tinyint NULL DEFAULT NULL COMMENT '所属分组ID',
  `type` tinyint NULL DEFAULT NULL COMMENT '账户类型 1超级管理员 2普通管理员',
  `note` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `status` tinyint NULL DEFAULT NULL COMMENT '10正常 0禁用',
  `create_time` int NULL DEFAULT NULL COMMENT '添加时间',
  `member_id` int NULL DEFAULT NULL COMMENT '会员ID',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 135 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cd_wservice
-- ----------------------------
DROP TABLE IF EXISTS `cd_wservice`;
CREATE TABLE `cd_wservice`  (
  `wservice_id` int NOT NULL AUTO_INCREMENT,
  `wservice_type` smallint NULL DEFAULT NULL COMMENT '类型',
  `wservice_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `wservice_appid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'appid',
  `wservice_url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'url',
  `wservice_icon` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `wservice_sort` int NULL DEFAULT NULL COMMENT '排序',
  `wservice_status` tinyint NULL DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`wservice_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_wservice
-- ----------------------------
INSERT INTO `cd_wservice` VALUES (1, 1, '添加设备', '', '/pages/addEquipment/addEquipment', '/static/fuwu.png', 1, 1);
INSERT INTO `cd_wservice` VALUES (2, 1, '门锁配网', '', '/pages/wifi/wifi', '/static/shezhi.png', 2, 1);
INSERT INTO `cd_wservice` VALUES (3, 1, '空开配网', '', '/pages/bluetooth/bluetooth', '/static/4GSwitch.png', 3, 1);
INSERT INTO `cd_wservice` VALUES (4, 1, '热点配网', '', '/pages/hotspot/hotspot', '/static/shezhi-on.png', 4, 1);
INSERT INTO `cd_wservice` VALUES (5, 1, '流量续费', '', '/pages/sim/sim', '/static/power.png', 5, 1);

SET FOREIGN_KEY_CHECKS = 1;

-- ================================================================
-- Open source release schema upgrade
-- ================================================================

-- ====================================================================
-- 数据库升级脚本 - bmkk分支同步 weimenjin 新功能
-- 执行日期: 2025-12-30
-- 说明: 本脚本用于升级 wmj_ManagementPlatform 数据库，支持房间绑定、
--      继电器控制、喇叭播报历史等新功能
-- ====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ====================================================================
-- 第一部分：cd_lock 表字段扩展
-- 用途：支持继电器控制、设备区域管理等功能
-- ====================================================================

-- 1.1 添加继电器延时字段（检查后再添加，避免重复）
SET @dbname = DATABASE();
SET @tablename = 'cd_lock';
SET @columnname = 'relay_delay';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN relay_delay INT(11) DEFAULT 1000 COMMENT ''继电器延时（毫秒），默认1000ms'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 1.2 添加继电器常开/常闭模式字段
SET @columnname = 'relay_nonc_mode';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN relay_nonc_mode TINYINT(1) DEFAULT 0 COMMENT ''继电器模式：0-常闭（默认），1-常开'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 1.3 添加设备提示音字段
SET @columnname = 'device_sound';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN device_sound TINYINT(1) DEFAULT 1 COMMENT ''设备提示音：1-开启（默认），0-关闭'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 1.4 添加区域/楼栋/单元关联字段
SET @columnname = 'area_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN area_id INT(11) DEFAULT NULL COMMENT ''所属区域ID'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'building_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN building_id INT(11) DEFAULT NULL COMMENT ''所属楼栋ID'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'unit_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN unit_id INT(11) DEFAULT NULL COMMENT ''所属单元ID'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'device_type';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE (TABLE_SCHEMA = @dbname)
     AND (TABLE_NAME = @tablename)
     AND (COLUMN_NAME = @columnname)) > 0,
  'SELECT 1',
  'ALTER TABLE cd_lock ADD COLUMN device_type VARCHAR(20) DEFAULT ''room'' COMMENT ''设备类型：public-公区门，unit-单元门，room-房间门（默认）'''
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 1.5 为新字段添加索引（使用存储过程方式检查索引是否存在）
DELIMITER $$
CREATE PROCEDURE AddIndexIfNotExists(
    IN tableName VARCHAR(128),
    IN indexName VARCHAR(128),
    IN columnName VARCHAR(128)
)
BEGIN
    DECLARE indexExists INT;
    SELECT COUNT(*) INTO indexExists
    FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = tableName
      AND INDEX_NAME = indexName;

    IF indexExists = 0 THEN
        SET @sql = CONCAT('ALTER TABLE ', tableName, ' ADD INDEX ', indexName, ' (', columnName, ')');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END$$
DELIMITER ;

CALL AddIndexIfNotExists('cd_lock', 'idx_relay_delay', 'relay_delay');
CALL AddIndexIfNotExists('cd_lock', 'idx_relay_nonc_mode', 'relay_nonc_mode');
CALL AddIndexIfNotExists('cd_lock', 'idx_device_sound', 'device_sound');
CALL AddIndexIfNotExists('cd_lock', 'idx_area_id', 'area_id');
CALL AddIndexIfNotExists('cd_lock', 'idx_building_id', 'building_id');
CALL AddIndexIfNotExists('cd_lock', 'idx_unit_id', 'unit_id');
CALL AddIndexIfNotExists('cd_lock', 'idx_device_type', 'device_type');

DROP PROCEDURE IF EXISTS AddIndexIfNotExists;


-- ====================================================================
-- 第二部分：喇叭播报历史表
-- 用途：记录云喇叭设备的播报历史记录（最多保存100条/设备）
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_horn_broadcast_history` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `lock_id` INT(11) NOT NULL COMMENT '设备ID（外键关联cd_lock.lock_id）',
  `member_id` INT(11) DEFAULT NULL COMMENT '操作用户ID',
  `content` TEXT NOT NULL COMMENT '播报内容（TTS文本）',
  `volume` INT(3) DEFAULT 5 COMMENT '音量：1-10',
  `speed` INT(3) DEFAULT 5 COMMENT '语速：1-10',
  `tone` INT(3) DEFAULT 5 COMMENT '语调：1-10',
  `loop_enabled` TINYINT(1) DEFAULT 0 COMMENT '是否循环播报：0-否，1-是',
  `loop_interval` INT(11) DEFAULT 0 COMMENT '循环间隔（秒），0表示不循环',
  `created_at` INT(11) NOT NULL COMMENT '播报时间（Unix时间戳）',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_lock_id` (`lock_id`) USING BTREE,
  INDEX `idx_created_at` (`created_at`) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
COMMENT='云喇叭播报历史记录表';


-- ====================================================================
-- 第三部分：房间管理 - 区域表
-- 用途：小区/园区区域管理
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_areas` (
  `area_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '区域ID',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '创建管理员ID',
  `area_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '区域名称',
  `area_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '区域编码',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '详细地址',
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '省份',
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '城市',
  `district` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '区县',
  `manager_id` int(11) NULL DEFAULT NULL COMMENT '管理员ID',
  `contact_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系人姓名',
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系人电话',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '区域描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态：0=禁用，1=启用',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`area_id`) USING BTREE,
  UNIQUE INDEX `uk_area_code`(`area_code`) USING BTREE,
  INDEX `idx_manager_id`(`manager_id`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '区域表' ROW_FORMAT = DYNAMIC;


-- ====================================================================
-- 第四部分：房间管理 - 楼栋表
-- 用途：小区内楼栋管理
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_buildings` (
  `building_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '楼栋ID',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '创建管理员ID',
  `area_id` int(11) NOT NULL COMMENT '所属区域ID',
  `building_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '楼栋名称（如：1号楼、A栋）',
  `building_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '楼栋编码',
  `floors` int(11) NULL DEFAULT NULL COMMENT '楼层数',
  `unit_count` int(11) NULL DEFAULT NULL COMMENT '单元数量',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '楼栋描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态：0=禁用，1=启用',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`building_id`) USING BTREE,
  UNIQUE INDEX `uk_area_building`(`area_id`, `building_code`) USING BTREE,
  INDEX `idx_area_id`(`area_id`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '楼栋表' ROW_FORMAT = DYNAMIC;


-- ====================================================================
-- 第五部分：房间管理 - 单元表
-- 用途：楼栋内单元管理
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_units` (
  `unit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '单元ID',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '创建管理员ID',
  `building_id` int(11) NOT NULL COMMENT '所属楼栋ID',
  `area_id` int(11) NOT NULL COMMENT '所属区域ID',
  `unit_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '单元名称（如：1单元、2单元）',
  `unit_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '单元编码',
  `floors` int(11) NULL DEFAULT NULL COMMENT '楼层数',
  `room_count` int(11) NULL DEFAULT NULL COMMENT '房号数量',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '单元描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态：0=禁用，1=启用',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`unit_id`) USING BTREE,
  UNIQUE INDEX `uk_building_unit`(`building_id`, `unit_code`) USING BTREE,
  INDEX `idx_building_id`(`building_id`) USING BTREE,
  INDEX `idx_area_id`(`area_id`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '单元表' ROW_FORMAT = DYNAMIC;


-- ====================================================================
-- 第六部分：房间管理 - 房间表
-- 用途：单元内房间管理
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_rooms` (
  `room_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '房号ID',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '创建管理员ID',
  `unit_id` int(11) NOT NULL COMMENT '所属单元ID',
  `building_id` int(11) NOT NULL COMMENT '所属楼栋ID',
  `area_id` int(11) NOT NULL COMMENT '所属区域ID',
  `room_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '房号（如：101、102）',
  `room_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '房号编码',
  `floor` int(11) NULL DEFAULT NULL COMMENT '楼层',
  `room_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'residential' COMMENT '房间类型：residential=住宅，commercial=商业，office=办公',
  `area_size` decimal(10, 2) NULL DEFAULT NULL COMMENT '房间面积（平方米）',
  `owner_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '业主姓名',
  `owner_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '业主电话',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '房号描述',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态：0=禁用，1=启用',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `deleted_at` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`room_id`) USING BTREE,
  UNIQUE INDEX `uk_unit_room`(`unit_id`, `room_number`) USING BTREE,
  INDEX `idx_unit_id`(`unit_id`) USING BTREE,
  INDEX `idx_building_id`(`building_id`) USING BTREE,
  INDEX `idx_area_id`(`area_id`) USING BTREE,
  INDEX `idx_floor`(`floor`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '房号表' ROW_FORMAT = DYNAMIC;


-- ====================================================================
-- 第七部分：房间绑定 - 用户房间绑定关系表
-- 用途：记录用户与房间的绑定关系（业主、租户、家属等）
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_member_rooms` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `member_id` INT(11) NOT NULL COMMENT '用户ID（外键关联cd_member.member_id）',
  `user_id` INT(11) NOT NULL COMMENT '管理员用户ID（member_id）',
  `area_id` INT(11) NOT NULL COMMENT '区域ID',
  `building_id` INT(11) NOT NULL COMMENT '楼栋ID',
  `unit_id` INT(11) NOT NULL COMMENT '单元ID',
  `room_id` INT(11) NOT NULL COMMENT '房间ID',
  `relation_type` VARCHAR(20) DEFAULT 'owner' COMMENT '关系类型：owner-业主，tenant-租户，family-家属，other-其他',
  `is_primary` TINYINT(1) DEFAULT 0 COMMENT '是否主房间：1-是，0-否',
  `status` TINYINT(1) DEFAULT 1 COMMENT '状态：1-正常，0-禁用',
  `create_time` INT(11) NOT NULL COMMENT '创建时间',
  `update_time` INT(11) DEFAULT NULL COMMENT '更新时间',
  `deleted_at` DATETIME DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE,
  INDEX `idx_user_id` (`user_id`) USING BTREE,
  INDEX `idx_room_id` (`room_id`) USING BTREE,
  INDEX `idx_unit_id` (`unit_id`) USING BTREE,
  INDEX `idx_area_id` (`area_id`) USING BTREE,
  INDEX `idx_deleted_at` (`deleted_at`) USING BTREE,
  INDEX `idx_status` (`status`) USING BTREE,
  INDEX `idx_member_room` (`member_id`, `room_id`) USING BTREE COMMENT '联合索引，用于查询绑定关系'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
COMMENT='用户房间绑定关系表';


-- ====================================================================
-- 第八部分：房间绑定 - 房间绑定申请表
-- 用途：记录用户的房间绑定申请及审核流程
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_member_room_applications` (
  `application_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '申请ID',
  `member_id` INT(11) NOT NULL COMMENT '申请用户ID',
  `user_id` INT(11) NOT NULL COMMENT '管理员用户ID（member_id）',
  `area_id` INT(11) NOT NULL COMMENT '区域ID',
  `building_id` INT(11) NOT NULL COMMENT '楼栋ID',
  `unit_id` INT(11) NOT NULL COMMENT '单元ID',
  `room_id` INT(11) NOT NULL COMMENT '房间ID',
  `room_number` VARCHAR(50) NOT NULL COMMENT '房间号（冗余字段）',
  `relation_type` VARCHAR(20) DEFAULT 'owner' COMMENT '关系类型',
  `applicant_name` VARCHAR(50) NOT NULL COMMENT '申请人姓名',
  `applicant_phone` VARCHAR(20) NOT NULL COMMENT '申请人电话',
  `status` TINYINT(1) DEFAULT 0 COMMENT '审核状态：0-待审核，1-已通过，2-已拒绝',
  `audit_time` INT(11) DEFAULT NULL COMMENT '审核时间',
  `audit_user_id` INT(11) DEFAULT NULL COMMENT '审核人ID',
  `audit_remark` VARCHAR(255) DEFAULT NULL COMMENT '审核备注',
  `create_time` INT(11) NOT NULL COMMENT '申请时间',
  `update_time` INT(11) DEFAULT NULL COMMENT '更新时间',
  `deleted_at` DATETIME DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`application_id`) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE,
  INDEX `idx_user_id` (`user_id`) USING BTREE,
  INDEX `idx_room_id` (`room_id`) USING BTREE,
  INDEX `idx_status` (`status`) USING BTREE,
  INDEX `idx_create_time` (`create_time`) USING BTREE,
  INDEX `idx_deleted_at` (`deleted_at`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
COMMENT='房间绑定申请表';


-- ====================================================================
-- 第九部分：推送通知 - 用户推送Token表
-- 用途：存储用户的设备推送Token，用于消息推送
-- ====================================================================

CREATE TABLE IF NOT EXISTS `cd_member_push_tokens` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `member_id` INT(11) NOT NULL COMMENT '用户ID',
  `token` VARCHAR(255) NOT NULL COMMENT '推送Token',
  `platform` VARCHAR(20) DEFAULT 'wechat' COMMENT '平台：wechat-微信，ios-苹果，android-安卓',
  `device_id` VARCHAR(100) DEFAULT NULL COMMENT '设备唯一标识',
  `status` TINYINT(1) DEFAULT 1 COMMENT '状态：1-有效，0-无效',
  `create_time` INT(11) NOT NULL COMMENT '创建时间',
  `update_time` INT(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_member_platform_token` (`member_id`, `platform`, `token`(150)) USING BTREE COMMENT '防止重复Token（token使用前150字符）',
  INDEX `idx_member_id` (`member_id`) USING BTREE,
  INDEX `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
COMMENT='用户推送Token表';


-- ====================================================================
-- 验证脚本：检查所有表和字段是否创建成功
-- ====================================================================

-- 检查 cd_lock 表新增字段
SELECT
    'cd_lock 表字段检查' AS check_type,
    COLUMN_NAME,
    COLUMN_TYPE,
    COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'cd_lock'
  AND COLUMN_NAME IN ('relay_delay', 'relay_nonc_mode', 'device_sound', 'area_id', 'building_id', 'unit_id', 'device_type');

-- 检查新建表
SELECT
    '新建表检查' AS check_type,
    TABLE_NAME,
    TABLE_COMMENT
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME IN (
    'cd_horn_broadcast_history',
    'cd_areas',
    'cd_buildings',
    'cd_units',
    'cd_rooms',
    'cd_member_rooms',
    'cd_member_room_applications',
    'cd_member_push_tokens'
  );

SET FOREIGN_KEY_CHECKS = 1;

-- ====================================================================
-- 升级脚本执行完毕
-- ====================================================================

-- ================================================================
-- Face sync task table
-- ================================================================

-- 人脸同步任务表
-- 用于异步处理大量人脸同步任务

CREATE TABLE IF NOT EXISTS `cd_face_sync_task` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '任务ID',
    `lock_id` int(11) NOT NULL COMMENT '设备ID',
    `lock_sn` varchar(50) DEFAULT NULL COMMENT '设备序列号',
    `lock_name` varchar(100) DEFAULT NULL COMMENT '设备名称',
    `member_id` int(11) DEFAULT NULL COMMENT '创建人ID',
    `total_count` int(11) DEFAULT 0 COMMENT '总条数',
    `processed_count` int(11) DEFAULT 0 COMMENT '已处理条数',
    `success_count` int(11) DEFAULT 0 COMMENT '成功条数',
    `failed_count` int(11) DEFAULT 0 COMMENT '失败条数',
    `faces_data` longtext COMMENT '待同步的人脸数据JSON',
    `status` enum('pending','processing','finished','failed') DEFAULT 'pending' COMMENT '状态',
    `progress` decimal(5,1) DEFAULT 0 COMMENT '进度百分比',
    `result_data` longtext COMMENT '处理结果JSON',
    `error_msg` varchar(500) DEFAULT NULL COMMENT '错误信息',
    `created_at` datetime DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`),
    KEY `idx_lock_id` (`lock_id`),
    KEY `idx_member_id` (`member_id`),
    KEY `idx_status` (`status`),
    KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='人脸同步任务表';

SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------
-- Open source initial records
-- ----------------------------
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE `cd_menu`;
TRUNCATE TABLE `cd_access`;
TRUNCATE TABLE `cd_config`;
TRUNCATE TABLE `cd_group`;
TRUNCATE TABLE `cd_user`;

INSERT INTO `cd_menu` VALUES (12, 0, 'Sys', '系统管理', '', '', 0, 1, 793, 0, 0, '', 'fa fa-gears', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (17, 12, '', '后台首页', '', '', 0, 1, 2, 0, 1, '/admin/Index/main.html', 'fa fa-home', '', 1, 0);
INSERT INTO `cd_menu` VALUES (18, 12, 'User', '管理员', 'user_id', 'user', 1, 1, 4, 1, 0, '', 'fa fa-user-secret', '', 1, 0);
INSERT INTO `cd_menu` VALUES (19, 12, 'Group', '管理组', 'group_id', 'group', 1, 1, 5, 1, 0, '', 'fa fa-user', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (21, 12, '', '菜单管理', '', '', 0, 0, 3, 0, 1, '/admin/Menu/index?app_id=1', '', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (41, 12, 'Config', '系统配置', '', '', 1, 1, 7, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|隐私政策|服务协议', 1, 0);
INSERT INTO `cd_menu` VALUES (52, 12, 'Log', '登录日志', 'log_id', 'log', 1, 1, 6, 1, 0, '', 'glyphicon glyphicon-log-in', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (80, 12, 'AppConfig', '应用配置', '', '', 0, 1, 1, 0, 0, '', 'glyphicon glyphicon-cog', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (524, 12, '', '修改密码', '', '', 0, 1, 8, 0, NULL, '/admin/Base/password', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (525, 12, '', '数据备份', '', '', 0, 0, 9, 0, NULL, '/admin/Backup/index', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (793, 0, 'Member', '会员管理', 'member_id', 'member', 1, 1, 793, 1, NULL, '', 'fa fa-users', '', 1, 0);
INSERT INTO `cd_menu` VALUES (803, 808, 'Lock', '设备列表', 'lock_id', 'lock', 1, 1, 803, 1, NULL, '', 'fa fa-list', '', 1, 0);
INSERT INTO `cd_menu` VALUES (802, 817, 'Health', '登记记录', 'health_id', 'health', 1, 1, 798, 0, NULL, '', 'fa fa-file-text', '', 1, 0);
INSERT INTO `cd_menu` VALUES (804, 817, 'Regpoint', '登记点管理', 'regpoint_id', 'regpoint', 1, 1, 804, 1, NULL, '', 'fa fa-dot-circle-o', '', 1, 0);
INSERT INTO `cd_menu` VALUES (807, 808, 'LockType', '门锁类型', 'locktype_id', 'locktype', 1, 1, 812, 1, NULL, '', 'fa fa-wrench', '', 1, 0);
INSERT INTO `cd_menu` VALUES (808, 0, '', '设备管理', '', '', 0, 1, 809, 1, NULL, '', 'fa fa-unlock', '', 1, 0);
INSERT INTO `cd_menu` VALUES (809, 808, 'LockAuth', '权限管理', 'lockauth_id', 'lockauth', 1, 1, 807, 1, NULL, '', 'fa fa-key', '', 1, 0);
INSERT INTO `cd_menu` VALUES (812, 808, 'LockLog', '操作记录', 'locklog_id', 'locklog', 1, 1, 809, 1, NULL, '', 'fa fa-list-alt', '', 1, 0);
INSERT INTO `cd_menu` VALUES (817, 0, '', '登记开门', '', '', 0, 0, 818, 0, NULL, '', 'fa fa-heartbeat', '', 1, 0);
INSERT INTO `cd_menu` VALUES (818, 808, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 818, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (824, 808, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 824, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (826, 0, 'Umember', '用户管理', 'umember_id', 'umember', 1, 1, 808, 1, NULL, '', 'fa fa-user', '', 1, 0);
INSERT INTO `cd_menu` VALUES (836, 0, 'AreaManage', '区域管理', NULL, NULL, NULL, 1, 100, NULL, NULL, NULL, 'fa fa-building', NULL, 1, 0);
INSERT INTO `cd_menu` VALUES (837, 836, '', '区域列表', NULL, NULL, NULL, 1, 1, NULL, 1, '/admin/AreaManage/index', 'fa fa-list', NULL, 1, 0);
INSERT INTO `cd_menu` VALUES (838, 836, '', '楼栋管理', NULL, NULL, NULL, 1, 2, NULL, 1, '/admin/AreaManage/buildingIndex', 'fa fa-building-o', NULL, 1, 0);
INSERT INTO `cd_menu` VALUES (839, 836, '', '单元管理', NULL, NULL, NULL, 1, 3, NULL, 1, '/admin/AreaManage/unitIndex', 'fa fa-th', NULL, 1, 0);
INSERT INTO `cd_menu` VALUES (840, 836, '', '房号管理', NULL, NULL, NULL, 1, 4, NULL, 1, '/admin/AreaManage/roomIndex', 'fa fa-home', NULL, 1, 0);
INSERT INTO `cd_menu` VALUES (842, 0, 'RoomApplication', '批量授权', NULL, NULL, NULL, 1, 900, NULL, 0, '', 'fa fa-home', NULL, 1, 0);
INSERT INTO `cd_menu` VALUES (843, 842, '', '授权列表', NULL, NULL, NULL, 1, 1, NULL, 1, '/admin/RoomApplication/index', '', NULL, 1, 0);
INSERT INTO `cd_access` VALUES (2522, '/admin/Member/add', 8);
INSERT INTO `cd_access` VALUES (2521, '/admin/Member/updateExt', 8);
INSERT INTO `cd_access` VALUES (2520, '/admin/Member/index', 8);
INSERT INTO `cd_access` VALUES (2324, '/admin/Health/add', 3);
INSERT INTO `cd_access` VALUES (2323, '/admin/Health/update', 3);
INSERT INTO `cd_access` VALUES (2322, '/admin/Health/delete', 3);
INSERT INTO `cd_access` VALUES (2321, '/admin/Health/view', 3);
INSERT INTO `cd_access` VALUES (2320, '/admin/Health/dumpData', 3);
INSERT INTO `cd_access` VALUES (2319, '/admin/Health/index', 3);
INSERT INTO `cd_access` VALUES (2318, '/admin/Health/import', 3);
INSERT INTO `cd_access` VALUES (2317, '/admin/Health', 3);
INSERT INTO `cd_access` VALUES (2519, '/admin/Member', 8);
INSERT INTO `cd_access` VALUES (3373, '/admin/Regpoint/view', 7);
INSERT INTO `cd_access` VALUES (3372, '/admin/Regpoint/delete', 7);
INSERT INTO `cd_access` VALUES (3371, '/admin/Regpoint/updateExt', 7);
INSERT INTO `cd_access` VALUES (3370, '/admin/Regpoint/index', 7);
INSERT INTO `cd_access` VALUES (3369, '/admin/Regpoint', 7);
INSERT INTO `cd_access` VALUES (3367, '/admin/Health/update', 7);
INSERT INTO `cd_access` VALUES (3368, '/admin/Health/add', 7);
INSERT INTO `cd_access` VALUES (3366, '/admin/Health/delete', 7);
INSERT INTO `cd_access` VALUES (3364, '/admin/Health/dumpData', 7);
INSERT INTO `cd_access` VALUES (3365, '/admin/Health/view', 7);
INSERT INTO `cd_access` VALUES (3363, '/admin/Health/index', 7);
INSERT INTO `cd_access` VALUES (3361, '/admin/', 7);
INSERT INTO `cd_access` VALUES (3362, '/admin/Health', 7);
INSERT INTO `cd_access` VALUES (3360, '/admin/LockCard/batchupcard', 7);
INSERT INTO `cd_access` VALUES (3359, '/admin/LockCard/dumpData', 7);
INSERT INTO `cd_access` VALUES (3358, '/admin/LockCard/view', 7);
INSERT INTO `cd_access` VALUES (3357, '/admin/LockCard/delete', 7);
INSERT INTO `cd_access` VALUES (3356, '/admin/LockCard/update', 7);
INSERT INTO `cd_access` VALUES (3355, '/admin/LockCard/add', 7);
INSERT INTO `cd_access` VALUES (2523, '/admin/Member/update', 8);
INSERT INTO `cd_access` VALUES (2524, '/admin/Member/delete', 8);
INSERT INTO `cd_access` VALUES (2525, '/admin/Member/view', 8);
INSERT INTO `cd_access` VALUES (2526, '/admin/Member/resetpassword', 8);
INSERT INTO `cd_access` VALUES (2527, '/admin/', 8);
INSERT INTO `cd_access` VALUES (2528, '/admin/Lock', 8);
INSERT INTO `cd_access` VALUES (2529, '/admin/Lock/updateExt', 8);
INSERT INTO `cd_access` VALUES (2530, '/admin/Lock/index', 8);
INSERT INTO `cd_access` VALUES (2531, '/admin/Lock/add', 8);
INSERT INTO `cd_access` VALUES (2532, '/admin/Lock/update', 8);
INSERT INTO `cd_access` VALUES (2533, '/admin/Lock/view', 8);
INSERT INTO `cd_access` VALUES (2534, '/admin/Lock/dumpData', 8);
INSERT INTO `cd_access` VALUES (2535, '/admin/Lock/opendoor', 8);
INSERT INTO `cd_access` VALUES (2536, '/admin/Locktimes/index', 8);
INSERT INTO `cd_access` VALUES (2537, '/admin/LockAuth', 8);
INSERT INTO `cd_access` VALUES (2538, '/admin/LockAuth/index', 8);
INSERT INTO `cd_access` VALUES (2539, '/admin/LockAuth/updateExt', 8);
INSERT INTO `cd_access` VALUES (2540, '/admin/LockAuth/add', 8);
INSERT INTO `cd_access` VALUES (2541, '/admin/LockAuth/update', 8);
INSERT INTO `cd_access` VALUES (2542, '/admin/LockAuth/delete', 8);
INSERT INTO `cd_access` VALUES (2543, '/admin/LockAuth/view', 8);
INSERT INTO `cd_access` VALUES (2544, '/admin/LockLog', 8);
INSERT INTO `cd_access` VALUES (2545, '/admin/LockLog/index', 8);
INSERT INTO `cd_access` VALUES (2546, '/admin/LockLog/updateExt', 8);
INSERT INTO `cd_access` VALUES (2547, '/admin/LockLog/delete', 8);
INSERT INTO `cd_access` VALUES (2548, '/admin/LockLog/view', 8);
INSERT INTO `cd_access` VALUES (2549, '/admin/LockLog/dumpData', 8);
INSERT INTO `cd_access` VALUES (2550, '/admin/LockType', 8);
INSERT INTO `cd_access` VALUES (2551, '/admin/LockType/index', 8);
INSERT INTO `cd_access` VALUES (2552, '/admin/LockType/updateExt', 8);
INSERT INTO `cd_access` VALUES (2553, '/admin/LockType/add', 8);
INSERT INTO `cd_access` VALUES (2554, '/admin/LockType/update', 8);
INSERT INTO `cd_access` VALUES (2555, '/admin/LockType/delete', 8);
INSERT INTO `cd_access` VALUES (2556, '/admin/LockType/view', 8);
INSERT INTO `cd_access` VALUES (2557, '/admin/Locktimes', 8);
INSERT INTO `cd_access` VALUES (2558, '/admin/Locktimes/index', 8);
INSERT INTO `cd_access` VALUES (2559, '/admin/Locktimes/updateExt', 8);
INSERT INTO `cd_access` VALUES (2560, '/admin/Locktimes/add', 8);
INSERT INTO `cd_access` VALUES (2561, '/admin/Locktimes/update', 8);
INSERT INTO `cd_access` VALUES (2562, '/admin/Locktimes/delete', 8);
INSERT INTO `cd_access` VALUES (2563, '/admin/Locktimes/view', 8);
INSERT INTO `cd_access` VALUES (2564, '/admin/', 8);
INSERT INTO `cd_access` VALUES (2565, '/admin/Health', 8);
INSERT INTO `cd_access` VALUES (2566, '/admin/Health/index', 8);
INSERT INTO `cd_access` VALUES (2567, '/admin/Health/dumpData', 8);
INSERT INTO `cd_access` VALUES (2568, '/admin/Health/view', 8);
INSERT INTO `cd_access` VALUES (2569, '/admin/Health/delete', 8);
INSERT INTO `cd_access` VALUES (2570, '/admin/Health/update', 8);
INSERT INTO `cd_access` VALUES (2571, '/admin/Health/add', 8);
INSERT INTO `cd_access` VALUES (2572, '/admin/Regpoint', 8);
INSERT INTO `cd_access` VALUES (2573, '/admin/Regpoint/index', 8);
INSERT INTO `cd_access` VALUES (2574, '/admin/Regpoint/updateExt', 8);
INSERT INTO `cd_access` VALUES (2575, '/admin/Regpoint/delete', 8);
INSERT INTO `cd_access` VALUES (2576, '/admin/Regpoint/view', 8);
INSERT INTO `cd_access` VALUES (3354, '/admin/LockCard/updateExt', 7);
INSERT INTO `cd_access` VALUES (3353, '/admin/LockCard/index', 7);
INSERT INTO `cd_access` VALUES (3351, '/admin/Locktimes/view', 7);
INSERT INTO `cd_access` VALUES (3352, '/admin/LockCard', 7);
INSERT INTO `cd_access` VALUES (3350, '/admin/Locktimes/delete', 7);
INSERT INTO `cd_access` VALUES (3349, '/admin/Locktimes/update', 7);
INSERT INTO `cd_access` VALUES (3347, '/admin/Locktimes/updateExt', 7);
INSERT INTO `cd_access` VALUES (3348, '/admin/Locktimes/add', 7);
INSERT INTO `cd_access` VALUES (3346, '/admin/Locktimes/index', 7);
INSERT INTO `cd_access` VALUES (3345, '/admin/Locktimes', 7);
INSERT INTO `cd_access` VALUES (3344, '/admin/LockLog/dumpData', 7);
INSERT INTO `cd_access` VALUES (3343, '/admin/LockLog/view', 7);
INSERT INTO `cd_access` VALUES (3342, '/admin/LockLog/delete', 7);
INSERT INTO `cd_access` VALUES (3341, '/admin/LockLog/add', 7);
INSERT INTO `cd_access` VALUES (3340, '/admin/LockLog/updateExt', 7);
INSERT INTO `cd_access` VALUES (3339, '/admin/LockLog/index', 7);
INSERT INTO `cd_access` VALUES (3338, '/admin/LockLog', 7);
INSERT INTO `cd_access` VALUES (3337, '/admin/LockAuth/view', 7);
INSERT INTO `cd_access` VALUES (3336, '/admin/LockAuth/delete', 7);
INSERT INTO `cd_access` VALUES (3335, '/admin/LockAuth/update', 7);
INSERT INTO `cd_access` VALUES (3334, '/admin/LockAuth/add', 7);
INSERT INTO `cd_access` VALUES (3333, '/admin/LockAuth/updateExt', 7);
INSERT INTO `cd_access` VALUES (3332, '/admin/LockAuth/index', 7);
INSERT INTO `cd_access` VALUES (3331, '/admin/LockAuth', 7);
INSERT INTO `cd_access` VALUES (3330, '/admin/LockCard/index', 7);
INSERT INTO `cd_access` VALUES (3329, '/admin/Locktimes/index', 7);
INSERT INTO `cd_access` VALUES (3328, '/admin/Lock/opendoor', 7);
INSERT INTO `cd_access` VALUES (3327, '/admin/Lock/dumpData', 7);
INSERT INTO `cd_access` VALUES (3326, '/admin/Lock/view', 7);
INSERT INTO `cd_access` VALUES (3325, '/admin/Lock/delete', 7);
INSERT INTO `cd_access` VALUES (3324, '/admin/Lock/update', 7);
INSERT INTO `cd_access` VALUES (3323, '/admin/Lock/add', 7);
INSERT INTO `cd_access` VALUES (3322, '/admin/Lock/index', 7);
INSERT INTO `cd_access` VALUES (3320, '/admin/Lock', 7);
INSERT INTO `cd_access` VALUES (3321, '/admin/Lock/updateExt', 7);
INSERT INTO `cd_access` VALUES (3319, '/admin/', 7);
INSERT INTO `cd_access` VALUES (3318, '/admin/Umember/authlocks', 7);
INSERT INTO `cd_access` VALUES (3317, '/admin/Umember/delete', 7);
INSERT INTO `cd_access` VALUES (3316, '/admin/Umember/update', 7);
INSERT INTO `cd_access` VALUES (3315, '/admin/Umember/updateExt', 7);
INSERT INTO `cd_access` VALUES (3314, '/admin/Umember/index', 7);
INSERT INTO `cd_access` VALUES (3313, '/admin/Umember', 7);
INSERT INTO `cd_access` VALUES (3385, '/admin/Lock/powerControl', 7);
INSERT INTO `cd_access` VALUES (3386, '/admin/Lock/batchGetDeviceStatus', 7);
INSERT INTO `cd_access` VALUES (3387, '/admin/Index/stats', 7);
INSERT INTO `cd_access` VALUES (3388, '/admin/AreaManage', 7);
INSERT INTO `cd_access` VALUES (3389, '/admin/AreaManage/index', 7);
INSERT INTO `cd_access` VALUES (3390, '/admin/AreaManage/add', 7);
INSERT INTO `cd_access` VALUES (3391, '/admin/AreaManage/update', 7);
INSERT INTO `cd_access` VALUES (3392, '/admin/AreaManage/delete', 7);
INSERT INTO `cd_access` VALUES (3393, '/admin/AreaManage/buildingIndex', 7);
INSERT INTO `cd_access` VALUES (3394, '/admin/AreaManage/buildingAdd', 7);
INSERT INTO `cd_access` VALUES (3395, '/admin/AreaManage/buildingUpdate', 7);
INSERT INTO `cd_access` VALUES (3396, '/admin/AreaManage/buildingDelete', 7);
INSERT INTO `cd_access` VALUES (3397, '/admin/AreaManage/unitIndex', 7);
INSERT INTO `cd_access` VALUES (3398, '/admin/AreaManage/unitAdd', 7);
INSERT INTO `cd_access` VALUES (3399, '/admin/AreaManage/unitUpdate', 7);
INSERT INTO `cd_access` VALUES (3400, '/admin/AreaManage/unitDelete', 7);
INSERT INTO `cd_access` VALUES (3401, '/admin/AreaManage/roomIndex', 7);
INSERT INTO `cd_access` VALUES (3402, '/admin/AreaManage/roomAdd', 7);
INSERT INTO `cd_access` VALUES (3403, '/admin/AreaManage/roomUpdate', 7);
INSERT INTO `cd_access` VALUES (3404, '/admin/AreaManage/roomDelete', 7);
INSERT INTO `cd_access` VALUES (3405, '/admin/AreaManage/migration', 7);
INSERT INTO `cd_access` VALUES (3406, '/admin/AreaManage', 8);
INSERT INTO `cd_access` VALUES (3407, '/admin/AreaManage/index', 8);
INSERT INTO `cd_access` VALUES (3408, '/admin/AreaManage/add', 8);
INSERT INTO `cd_access` VALUES (3409, '/admin/AreaManage/update', 8);
INSERT INTO `cd_access` VALUES (3410, '/admin/AreaManage/delete', 8);
INSERT INTO `cd_access` VALUES (3411, '/admin/AreaManage/buildingIndex', 8);
INSERT INTO `cd_access` VALUES (3412, '/admin/AreaManage/buildingAdd', 8);
INSERT INTO `cd_access` VALUES (3413, '/admin/AreaManage/buildingUpdate', 8);
INSERT INTO `cd_access` VALUES (3414, '/admin/AreaManage/buildingDelete', 8);
INSERT INTO `cd_access` VALUES (3415, '/admin/AreaManage/unitIndex', 8);
INSERT INTO `cd_access` VALUES (3416, '/admin/AreaManage/unitAdd', 8);
INSERT INTO `cd_access` VALUES (3417, '/admin/AreaManage/unitUpdate', 8);
INSERT INTO `cd_access` VALUES (3418, '/admin/AreaManage/unitDelete', 8);
INSERT INTO `cd_access` VALUES (3419, '/admin/AreaManage/roomIndex', 8);
INSERT INTO `cd_access` VALUES (3420, '/admin/AreaManage/roomAdd', 8);
INSERT INTO `cd_access` VALUES (3421, '/admin/AreaManage/roomUpdate', 8);
INSERT INTO `cd_access` VALUES (3422, '/admin/AreaManage/roomDelete', 8);
INSERT INTO `cd_access` VALUES (3423, '/admin/AreaManage/migration', 8);
INSERT INTO `cd_access` VALUES (3424, '/admin/AreaManage/roomBatchGenerate', 7);
INSERT INTO `cd_access` VALUES (3425, '/admin/AreaManage/roomBatchGenerate', 8);
INSERT INTO `cd_access` VALUES (3426, '/admin/Lock/getBuildingsByArea', 1);
INSERT INTO `cd_access` VALUES (3427, '/admin/Lock/getBuildingsByArea', 7);
INSERT INTO `cd_access` VALUES (3428, '/admin/Lock/getBuildingsByArea', 8);
INSERT INTO `cd_access` VALUES (3429, '/admin/Lock/getUnitsByBuilding', 1);
INSERT INTO `cd_access` VALUES (3430, '/admin/Lock/getUnitsByBuilding', 7);
INSERT INTO `cd_access` VALUES (3431, '/admin/Lock/getUnitsByBuilding', 8);
INSERT INTO `cd_access` VALUES (3432, '/admin/RoomApplication', 1);
INSERT INTO `cd_access` VALUES (3433, '/admin/RoomApplication', 7);
INSERT INTO `cd_access` VALUES (3434, '/admin/RoomApplication', 8);
INSERT INTO `cd_access` VALUES (3435, '/admin/RoomApplication/index', 1);
INSERT INTO `cd_access` VALUES (3436, '/admin/RoomApplication/index', 7);
INSERT INTO `cd_access` VALUES (3437, '/admin/RoomApplication/index', 8);
INSERT INTO `cd_access` VALUES (3438, '/admin/RoomApplication/detail', 1);
INSERT INTO `cd_access` VALUES (3439, '/admin/RoomApplication/detail', 7);
INSERT INTO `cd_access` VALUES (3440, '/admin/RoomApplication/detail', 8);
INSERT INTO `cd_access` VALUES (3441, '/admin/RoomApplication/audit', 1);
INSERT INTO `cd_access` VALUES (3442, '/admin/RoomApplication/audit', 7);
INSERT INTO `cd_access` VALUES (3443, '/admin/RoomApplication/audit', 8);
INSERT INTO `cd_access` VALUES (3444, '/admin/RoomApplication/downloadTemplate', 1);
INSERT INTO `cd_access` VALUES (3445, '/admin/RoomApplication/downloadTemplate', 7);
INSERT INTO `cd_access` VALUES (3446, '/admin/RoomApplication/downloadTemplate', 8);
INSERT INTO `cd_access` VALUES (3447, '/admin/RoomApplication/importExcel', 1);
INSERT INTO `cd_access` VALUES (3448, '/admin/RoomApplication/importExcel', 7);
INSERT INTO `cd_access` VALUES (3449, '/admin/RoomApplication/importExcel', 8);
INSERT INTO `cd_access` VALUES (3450, '/admin/RoomApplication/deleteBinding', 1);
INSERT INTO `cd_access` VALUES (3451, '/admin/RoomApplication/deleteBinding', 7);
INSERT INTO `cd_access` VALUES (3452, '/admin/RoomApplication/deleteBinding', 8);
INSERT INTO `cd_config` (`name`, `data`) VALUES ('site_title', '微门禁');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('site_logo', '/static/img/wmjlogo.png');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('keyword', '微门禁,门禁,小程序');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('description', '微门禁开源版后台服务');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('copyright', 'weimenjin');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('file_size', '20');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('file_type', 'jpg,png,gif,jpeg,mp4,pem,txt');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('domain', 'https://demo.wmj.com.cn');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('autodtkey', '0');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('autodtkeylockid', '1');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('privacypolicy', '<p>请在后台系统配置中完善隐私政策。</p>');
INSERT INTO `cd_config` (`name`, `data`) VALUES ('serviceagreement', '<p>请在后台系统配置中完善用户服务协议。</p>');
INSERT INTO `cd_group` (`group_id`, `name`, `status`, `role`) VALUES (1, '超级管理员', 1, 1);
INSERT INTO `cd_user` (`user_id`, `name`, `user`, `pwd`, `group_id`, `type`, `note`, `status`, `create_time`, `member_id`) VALUES (1, '超级管理员', 'admin', MD5(CONCAT('WmjDemo2026', 'change-me')), 1, 1, 'demo super admin', 1, UNIX_TIMESTAMP(), NULL);

SET FOREIGN_KEY_CHECKS = 1;
