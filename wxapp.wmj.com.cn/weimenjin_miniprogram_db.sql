/*
 Navicat Premium Data Transfer

 Source Server         : miniprogram
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : mpdemo.wmj.com.cn:3306
 Source Schema         : miniprogram

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 01/07/2023 18:33:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cd_access
-- ----------------------------
DROP TABLE IF EXISTS `cd_access`;
CREATE TABLE `cd_access`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `purviewval` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分组对应权限值',
  `group_id` tinyint(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3048 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_access
-- ----------------------------
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
INSERT INTO `cd_access` VALUES (3046, '/admin/DoorStatus/index', 7);
INSERT INTO `cd_access` VALUES (3045, '/admin/DoorStatus', 7);
INSERT INTO `cd_access` VALUES (3044, '/admin/', 7);
INSERT INTO `cd_access` VALUES (3043, '/admin/Regpoint/view', 7);
INSERT INTO `cd_access` VALUES (3042, '/admin/Regpoint/delete', 7);
INSERT INTO `cd_access` VALUES (3041, '/admin/Regpoint/updateExt', 7);
INSERT INTO `cd_access` VALUES (3040, '/admin/Regpoint/index', 7);
INSERT INTO `cd_access` VALUES (3039, '/admin/Regpoint', 7);
INSERT INTO `cd_access` VALUES (3038, '/admin/Health/add', 7);
INSERT INTO `cd_access` VALUES (3037, '/admin/Health/update', 7);
INSERT INTO `cd_access` VALUES (3036, '/admin/Health/delete', 7);
INSERT INTO `cd_access` VALUES (3035, '/admin/Health/view', 7);
INSERT INTO `cd_access` VALUES (3034, '/admin/Health/dumpData', 7);
INSERT INTO `cd_access` VALUES (3033, '/admin/Health/index', 7);
INSERT INTO `cd_access` VALUES (3032, '/admin/Health', 7);
INSERT INTO `cd_access` VALUES (3031, '/admin/', 7);
INSERT INTO `cd_access` VALUES (3030, '/admin/LockCard/batchupcard', 7);
INSERT INTO `cd_access` VALUES (3029, '/admin/LockCard/dumpData', 7);
INSERT INTO `cd_access` VALUES (3028, '/admin/LockCard/view', 7);
INSERT INTO `cd_access` VALUES (3027, '/admin/LockCard/delete', 7);
INSERT INTO `cd_access` VALUES (3026, '/admin/LockCard/update', 7);
INSERT INTO `cd_access` VALUES (3025, '/admin/LockCard/add', 7);
INSERT INTO `cd_access` VALUES (3024, '/admin/LockCard/updateExt', 7);
INSERT INTO `cd_access` VALUES (3023, '/admin/LockCard/index', 7);
INSERT INTO `cd_access` VALUES (3022, '/admin/LockCard', 7);
INSERT INTO `cd_access` VALUES (3021, '/admin/Locktimes/view', 7);
INSERT INTO `cd_access` VALUES (3020, '/admin/Locktimes/delete', 7);
INSERT INTO `cd_access` VALUES (3019, '/admin/Locktimes/update', 7);
INSERT INTO `cd_access` VALUES (3018, '/admin/Locktimes/add', 7);
INSERT INTO `cd_access` VALUES (3017, '/admin/Locktimes/updateExt', 7);
INSERT INTO `cd_access` VALUES (3016, '/admin/Locktimes/index', 7);
INSERT INTO `cd_access` VALUES (3013, '/admin/LockLog/view', 7);
INSERT INTO `cd_access` VALUES (3014, '/admin/LockLog/dumpData', 7);
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
INSERT INTO `cd_access` VALUES (3015, '/admin/Locktimes', 7);
INSERT INTO `cd_access` VALUES (3012, '/admin/LockLog/delete', 7);
INSERT INTO `cd_access` VALUES (3011, '/admin/LockLog/add', 7);
INSERT INTO `cd_access` VALUES (3010, '/admin/LockLog/updateExt', 7);
INSERT INTO `cd_access` VALUES (3009, '/admin/LockLog/index', 7);
INSERT INTO `cd_access` VALUES (3008, '/admin/LockLog', 7);
INSERT INTO `cd_access` VALUES (3007, '/admin/LockAuth/view', 7);
INSERT INTO `cd_access` VALUES (3006, '/admin/LockAuth/delete', 7);
INSERT INTO `cd_access` VALUES (3005, '/admin/LockAuth/update', 7);
INSERT INTO `cd_access` VALUES (3004, '/admin/LockAuth/add', 7);
INSERT INTO `cd_access` VALUES (3003, '/admin/LockAuth/updateExt', 7);
INSERT INTO `cd_access` VALUES (3002, '/admin/LockAuth/index', 7);
INSERT INTO `cd_access` VALUES (3001, '/admin/LockAuth', 7);
INSERT INTO `cd_access` VALUES (3000, '/admin/LockCard/index', 7);
INSERT INTO `cd_access` VALUES (2999, '/admin/Locktimes/index', 7);
INSERT INTO `cd_access` VALUES (2998, '/admin/Lock/opendoor', 7);
INSERT INTO `cd_access` VALUES (2997, '/admin/Lock/dumpData', 7);
INSERT INTO `cd_access` VALUES (2996, '/admin/Lock/view', 7);
INSERT INTO `cd_access` VALUES (2995, '/admin/Lock/delete', 7);
INSERT INTO `cd_access` VALUES (2994, '/admin/Lock/update', 7);
INSERT INTO `cd_access` VALUES (2993, '/admin/Lock/add', 7);
INSERT INTO `cd_access` VALUES (2992, '/admin/Lock/index', 7);
INSERT INTO `cd_access` VALUES (2991, '/admin/Lock/updateExt', 7);
INSERT INTO `cd_access` VALUES (2990, '/admin/Lock', 7);
INSERT INTO `cd_access` VALUES (2989, '/admin/', 7);
INSERT INTO `cd_access` VALUES (2988, '/admin/Umember/delete', 7);
INSERT INTO `cd_access` VALUES (2987, '/admin/Umember/update', 7);
INSERT INTO `cd_access` VALUES (2986, '/admin/Umember/updateExt', 7);
INSERT INTO `cd_access` VALUES (2985, '/admin/Umember/index', 7);
INSERT INTO `cd_access` VALUES (2984, '/admin/Umember', 7);
INSERT INTO `cd_access` VALUES (3047, '/admin/DoorStatus/updateExt', 7);

-- ----------------------------
-- Table structure for cd_action
-- ----------------------------
DROP TABLE IF EXISTS `cd_action`;
CREATE TABLE `cd_action`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(9) NOT NULL COMMENT '模块ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '动作名称',
  `action_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '动作名称',
  `type` tinyint(4) NOT NULL,
  `icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'icon图标',
  `pagesize` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '20' COMMENT '每页显示数据条数',
  `is_view` tinyint(4) NULL DEFAULT 0 COMMENT '是否按钮',
  `button_status` tinyint(4) NULL DEFAULT NULL COMMENT '按钮是否显示列表',
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
  `sortid` mediumint(9) NULL DEFAULT 0 COMMENT '排序',
  `orderby` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配置排序',
  `default_orderby` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '默认排序',
  `tree_config` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `jump` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '按钮跳转地址',
  `is_controller_create` tinyint(4) NULL DEFAULT 1 COMMENT '是否生成控制其方法',
  `is_service_create` tinyint(4) NULL DEFAULT NULL COMMENT '是否生成服务层方法',
  `is_view_create` tinyint(4) NULL DEFAULT NULL COMMENT '视图生成',
  `cache_time` mediumint(9) NULL DEFAULT NULL COMMENT '缓存时间',
  `log_status` tinyint(4) NULL DEFAULT NULL COMMENT '是否生成日志',
  `api_auth` tinyint(4) NULL DEFAULT NULL COMMENT '接口是否鉴权',
  `sms_auth` tinyint(4) NULL DEFAULT NULL COMMENT '短信验证',
  `request_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '请求类型 get 或者 post',
  `captcha_auth` tinyint(4) NULL DEFAULT NULL COMMENT '图片验证码验证',
  `do_condition` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作条件',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2915 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_action
-- ----------------------------
INSERT INTO `cd_action` VALUES (78, 18, '首页数据列表', 'index', 1, '', '', 0, 0, '', '用户管理', '', 'group_id', '', 'primary', 'group', 'group_id', 'a.*,b.name as group_name', '', 1, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (80, 18, '添加', 'add', 3, '', '20', 1, 0, '', '添加账户', '800px|600px', 'name,user,pwd,group_id,type,note,status,create_time', '', 'primary', '', '', '', 'fa fa-plus', 3, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (81, 18, '修改', 'update', 4, '', '', 1, 1, '', '修改账户', '800px|600px', 'name,user,group_id,type,note,status,member_id,create_time', '', 'success', '', '', '', 'fa fa-edit', 4, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (82, 18, '修改密码', 'updatePassword', 9, '', '', 1, 0, '', '修改密码', '600px|300px', 'pwd', '', 'warning', '', '', '', '', 6, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (85, 19, '首页数据列表', 'index', 1, '', '', 0, 0, '', '分组管理', '600px|250px', '', '', 'primary', '', '', '', '', 1, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (87, 19, '添加', 'add', 3, '', '', 1, 0, '', '添加分组', '800px|400px', 'name,status,role', '', 'primary', '', '', '', 'plus', 3, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (88, 19, '修改', 'update', 4, '', '', 1, 1, '', '修改分组', '800px|400px', 'name,status,role', '', 'primary', '', '', '', '', 4, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (89, 19, '禁用', 'forbidden', 6, '', '', 1, 0, '', '禁用', '0', 'status', '', 'warning', '', '', '', 'edit', 5, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (90, 19, '启用', 'start', 6, '', '', 1, 0, '', '启用', '10', 'status', '', 'warning', '', '', '', 'edit', 6, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (91, 19, '设置权限', 'auth', 11, '', '', 1, 0, '', '弹窗连接', '90%|90%', '', '', 'info', '', '', '', 'plus', 7, '', '', '', '/Base/auth', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (106, 19, '查看用户', 'viewUser', 11, '', '', 1, 1, '', '弹窗连接', '90%|90%', '', '', 'success', '', '', '', 'plus', 8, '', '', '', '/User/index', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (124, 52, '首页数据列表', 'index', 1, '', '', 0, 0, 'select a.*,b.name as group_name,c.name as nickname from cd_log as a inner join cd_group as b inner join cd_user as c on a.user_id = c.user_id and c.group_id= b.group_id', '登录日志管理', '', '', '', 'primary', '', '', '', '', 1, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (128, 52, '删除', 'delete', 5, '', NULL, 1, 0, '', '删除', '', '', '', 'danger', '', '', '', 'trash', 4, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (130, 41, '修改配置', 'index', 4, '', '', 1, 0, '', '修改', '600px|300px', '', '', 'primary', '', '', '', '', 127, '', '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (1668, 18, '删除', 'delete', 5, NULL, '', 1, 1, '', '删除数据', '', '', NULL, 'danger', '', '', '', 'fa fa-trash', 1668, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2076, 18, '禁用', 'forbidden', 6, NULL, '', 1, 0, '', '修改状态', '0', 'status', NULL, 'success', '', '', '', 'fa fa-pencil', 2076, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2075, 18, '启用', 'start', 6, NULL, '', 1, 0, '', '修改状态', '1', 'status', NULL, 'success', '', '', '', 'fa fa-pencil', 2075, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2726, 793, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '会员管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2727, 793, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2728, 793, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'nickname,headimgurl,openid,mobile,username,password,create_time,sex,status', NULL, 'primary', '', '', '', 'fa fa-plus', 2728, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2729, 793, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|600px', 'nickname,headimgurl,openid,mobile,username,create_time,sex,status', NULL, 'success', '', '', '', 'fa fa-pencil', 2729, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2730, 793, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '800px|600px', 'nickname,headimgurl,openid,mobile,username,create_time,sex,status', NULL, 'danger', '', '', '', 'fa fa-trash', 2730, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2731, 793, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|600px', 'nickname,headimgurl,openid,mobile,username,create_time,sex,status', NULL, 'info', '', '', '', 'fa fa-plus', 2731, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2770, 803, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2734, 794, '更新用户信息', 'update', 4, NULL, '20', 1, 1, '', '编辑数据', '', 'nickname,headimgurl,openid,mobile,sex,member_ps', NULL, 'success', '', '', '', 'fa fa-pencil', 2746, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2736, 794, '查看用户信息', 'view', 15, NULL, '20', 1, 0, '', '查看用户信息', '', 'nickname,headimgurl,openid,mobile,username,password,sex,status,create_time,member_ps', NULL, 'info', '', '', '', 'fa fa-plus', 2747, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2769, 803, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '门锁管理', '', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,online,lock_qrcode,create_time,successimg,successadimg,opsucnt', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2747, 794, '小程序登录', 'xcxlogin', 28, NULL, '', 0, NULL, '', '小程序登录', 'openid', 'nickname,headimgurl,openid,mobile,username,password,sex,status,create_time', NULL, NULL, 'user', 'member_id', 'a.*,b.user_id', NULL, 2728, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2740, 793, '重置密码', 'resetpassword', 9, NULL, '', 1, 0, '', '修改密码', '600px|350px', 'password', NULL, 'primary', '', '', '', 'fa fa-lock', 2740, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2741, 797, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id', NULL, 'primary', '', '', '', 'fa fa-plus', 2741, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2767, 802, '数据列表', 'index', 1, NULL, '', 1, 0, '', '', '', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id', NULL, 'primary', '', '', '', '', 2767, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2744, 797, '查看数据详情页', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'info', '', '', '', 'fa fa-plus', 2768, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2768, 797, '查看数据列表', 'list', 1, NULL, '20', 0, NULL, '', '', '', '', NULL, NULL, '', '', '', NULL, 2744, NULL, 'health_id desc', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2765, 802, '导出', 'dumpData', 12, NULL, '20', 1, 0, NULL, '导出', '', 'user_id,create_time,lat,lng,txz,manyou,register_type,yiqu,health,job,position,second_address,first_address,name,mobile', NULL, 'warning', NULL, NULL, NULL, 'fa fa-download', 2765, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2764, 802, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'info', '', '', '', 'fa fa-plus', 2764, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2763, 802, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'user_id,create_time,lat,lng,txz,manyou,register_type,yiqu,health,job,position,second_address,first_address,name,mobile', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2763, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2762, 802, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'success', '', '', '', 'fa fa-pencil', 2762, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2761, 802, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'primary', '', '', '', 'fa fa-plus', 2761, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2771, 804, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '登记点管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2772, 804, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2775, 804, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2775, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2776, 804, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|450px', 'member_id,user_id,regpointname,regpointqrcode,create_time', NULL, 'info', '', '', '', 'fa fa-plus', 2776, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2794, 803, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,adnum,successimg,successadimg,hitshowminiad,openbtn,qrshowminiad,openadurl,opsucnt', NULL, 'primary', '', '', '', 'fa fa-plus', 2794, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2779, 805, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'success', '', '', '', 'fa fa-pencil', 2774, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2780, 805, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2775, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2781, 805, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'info', '', '', '', 'fa fa-plus', 2776, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2789, 806, '查询管理员', 'view', 15, NULL, '', 0, NULL, '', '', '', '', NULL, NULL, '', '', '', NULL, 2789, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2795, 803, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|100%', 'lock_name,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,lock_qrcode,adnum,successimg,successadimg,hitshowminiad,openbtn,qrshowminiad,openadurl,opsucnt', NULL, 'success', '', '', '', 'fa fa-pencil', 2795, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2784, 806, '修改', 'update', 4, '', '', 1, 1, '', '修改账户', '', 'name,user,group_id,type,note,status,member_id,create_time', '', 'success', '', '', '', 'fa fa-edit', 4, '', '', '', '', 1, 1, 1, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2785, 806, '修改密码', 'updatePassword', 9, '', '', 1, 0, '', '修改密码', '', 'pwd', '', 'warning', '', '', '', '', 6, '', '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2793, 794, '查询管理员ID', 'viewuserid', 15, NULL, '', 0, NULL, '', '查询管理员ID', '', '', NULL, NULL, 'user', 'member_id', 'a.member_id,b.*', NULL, 2793, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2796, 803, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2796, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2797, 803, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,lock_qrcode,create_time,adnum,successimg,successadimg,openadurl,opsucnt', NULL, 'info', '', '', '', 'fa fa-plus', 2797, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2798, 803, '导出', 'dumpData', 12, NULL, '20', 1, 0, '', '导出', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time', NULL, 'warning', '', '', '', 'fa fa-download', 2798, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2799, 807, '首页数据列表', 'index', 1, NULL, '20', 0, NULL, NULL, '门锁类型', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2800, 807, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2801, 807, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '600px|350px', 'locktype_name', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2801, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2802, 807, '修改', 'update', 4, NULL, '20', 1, 1, NULL, '修改', '600px|350px', 'locktype_name', NULL, 'success', NULL, NULL, NULL, 'fa fa-pencil', 2802, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2803, 807, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'locktype_name', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2803, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2804, 807, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '600px|350px', 'locktype_name', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2804, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2805, 803, '开门', 'opendoor', 4, NULL, '', 1, 0, '', '编辑数据', '', '', NULL, 'primary', '', '', '', 'fa fa-edit', 2805, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2806, 809, '首页列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_lockauth as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '钥匙管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2807, 809, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2808, 809, '添加', 'add', 3, NULL, '20', 0, 0, '', '添加', '800px|100%', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin', NULL, 'primary', '', '', '', 'fa fa-plus', 2808, NULL, '', '', '', 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2809, 809, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|450px', 'realname,auth_starttime,auth_endtime,remark,auth_openlimit', NULL, 'success', '', '', '', 'fa fa-pencil', 2809, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2810, 809, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '800px|100%', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin', NULL, 'danger', '', '', '', 'fa fa-trash', 2810, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2811, 809, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin', NULL, 'info', '', '', '', 'fa fa-plus', 2811, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2834, 813, '查询锁信息', 'view', 15, NULL, '20', 1, 0, '', '根据lock_id查询锁信息', '', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,lock_qrcode,online,successimg,successadimg,volume,openttscontent,addcardmode', NULL, 'info', '', '', '', 'fa fa-plus', 2797, NULL, '', '', '', 1, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2833, 813, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'member_id,user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time,lock_qrcode,online', NULL, 'danger', '', '', '', 'fa fa-trash', 2796, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2832, 813, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '', 'lock_name,mobile_check,applyauth,applyauth_check,location_check,status', NULL, 'success', '', '', '', 'fa fa-pencil', 2795, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2831, 813, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '', '', NULL, 'primary', '', '', '', 'fa fa-plus', 2794, NULL, '', '', '', 0, 1, 1, 0, 1, 0, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2847, 18, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|100%', 'name,user,pwd,group_id,type,note,status,create_time,member_id', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2847, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2840, 814, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'lock_id,member_id,auth_member_id,auth_endtime,auth_starttime,auth_shareability,remark,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2810, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2839, 814, '审核钥匙', 'verifyauth', 4, NULL, '20', 1, 1, '', '审核钥匙', '', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_isadmin,auth_shareability,remark,create_time,auth_status,user_id', NULL, 'success', '', '', '', 'fa fa-pencil', 2809, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2838, 814, '申请钥匙', 'applyauth', 3, NULL, '20', 1, 0, '', '申请钥匙', '', 'lock_id,member_id,realname,remark,create_time,auth_status,user_id', NULL, 'primary', '', '', '', 'fa fa-plus', 2808, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2836, 813, '开门', 'opendoor', 4, NULL, '', 1, 0, '', '编辑数据', '', '', NULL, 'primary', '', '', '', 'fa fa-edit', 2805, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2837, 814, '根据会员id查询钥匙列表', 'getauthlistbymemid', 1, NULL, '20', 0, NULL, '', '根据会员id查询钥匙', '', 'lock_id', NULL, NULL, 'lock', 'lock_id', '', NULL, 1, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2824, 812, '首页数据列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '日志管理', '', '', NULL, 'primary', '', '', '', 'fa fa-bars', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2825, 812, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2868, 812, '添加', 'add', 3, NULL, '20', 0, 0, NULL, '添加', '800px|550px', 'member_id,lock_id,status,type,create_time,user_id,remark', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2868, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2867, 816, '获取隐私政策和服务协议', 'getps', 15, NULL, '20', 1, 0, '', '获取隐私政策和服务协议', '800px|100%', 'privacypolicy,serviceagreement', NULL, 'info', '', '', '', 'fa fa-plus', 2867, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2828, 812, '删除', 'delete', 5, NULL, '20', 0, 1, NULL, '删除', '', 'member_id,lock_id,status,type,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2828, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2829, 812, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|450px', 'member_id,lock_id,status,type,create_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2829, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2841, 814, '查看数据', 'getauthdetailbyid', 15, NULL, '20', 1, 0, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_lockauth as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '查看数据', '', 'lock_id,member_id,realname,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_isadmin,auth_shareability,remark,create_time,auth_status', NULL, 'info', '', '', '', 'fa fa-plus', 2811, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2842, 815, '获取开门记录', 'getopenlog', 1, NULL, '20', 0, NULL, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '获取开门日志', '', 'member_id', NULL, NULL, '', '', '', NULL, 1, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2843, 815, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '', 'member_id,lock_id,status,type,create_time', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2826, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2844, 815, '修改', 'update', 4, NULL, '20', 1, 1, NULL, '修改', '', 'member_id,lock_id,status,type,create_time', NULL, 'success', NULL, NULL, NULL, 'fa fa-pencil', 2827, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2845, 815, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,lock_id,status,type,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2828, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2846, 815, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '', 'member_id,lock_id,status,type,create_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2829, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2848, 816, '修改配置', 'index', 4, '', '', 1, 0, '', '修改', '', '', '', 'primary', '', '', '', '', 127, '', '', '', '', 0, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2849, 816, '获取配置信息', 'getconfig', 15, NULL, '20', 1, 0, '', '查看数据', '', 'site_title,site_logo,keyword,description,file_size,file_type,domain,copyright,wmjappid,wmjappsecret,wmjaeskey', NULL, 'info', '', '', '', 'fa fa-plus', 2849, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2871, 824, '首页数据列表', 'index', 1, NULL, '20', 0, NULL, NULL, '卡管理', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2850, 812, '导出', 'dumpData', 12, NULL, '20', 1, 0, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '导出', '', '', NULL, 'warning', '', '', '', 'fa fa-download', 2850, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2851, 803, '可开门时段设置', 'enopentimesset', 11, NULL, '', 1, 0, '', '可开门时段管理', '90%|90%', '', NULL, 'primary', '', '', '', 'fa fa-plus', 2851, NULL, '', '', '/Locktimes/index', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2852, 818, '首页数据列表', 'index', 1, NULL, '20', 0, NULL, NULL, '开门时段', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2853, 818, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2854, 818, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'locktimesname,user_id,lock_id,type,startweek,starthour,startminute,endweek,endhour,endminute,create_time', NULL, 'primary', '', '', '', 'fa fa-plus', 2854, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2855, 818, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|100%', 'locktimesname,user_id,type,startweek,starthour,startminute,endweek,endhour,endminute', NULL, 'success', '', '', '', 'fa fa-pencil', 2855, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2856, 818, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2856, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2857, 818, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'locktimesname,user_id,lock_id,type,startweek,starthour,startminute,endweek,endhour,endminute,create_time', NULL, 'info', '', '', '', 'fa fa-plus', 2857, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2858, 814, '分享钥匙', 'shareauth', 3, NULL, '', 0, NULL, '', '生成分享前的临时钥匙', '', 'lock_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_shareability,auth_opentimes,remark,create_time,auth_status,user_id', NULL, NULL, '', '', '', NULL, 2858, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2859, 814, '领取钥匙', 'getkey', 4, NULL, '', 0, NULL, '', '领取钥匙', '', 'lock_id,member_id', NULL, NULL, '', '', '', NULL, 2859, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2860, 819, '查询可开门时段', 'getopentimes', 1, NULL, '20', 0, NULL, '', '查询可开门时段', '', '', NULL, NULL, '', '', '', NULL, 1, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2865, 794, '支付宝小程序登录', 'alipaylogin', 29, NULL, '', 0, NULL, '', '', 'ali_user_id', 'headimgurl,username,sex', NULL, NULL, '', '', '', NULL, 2865, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2869, 814, '根据锁id查询钥匙', 'getauthlistbylockid', 1, NULL, '', 0, NULL, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_lockauth as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '', '', '', NULL, NULL, '', '', '', NULL, 2869, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2870, 815, '根据锁id查询开门记录(管理员)', 'getopenlogbylockid', 1, NULL, '', 0, NULL, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '', '', '', NULL, NULL, '', '', '', NULL, 2870, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2872, 824, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2873, 803, '卡管理', 'lockcardmanage', 11, NULL, '', 1, 0, '', '卡管理', '90%|90%', '', NULL, 'primary', '', '', '', 'fa fa-plus', 2873, NULL, '', '', '/LockCard/index', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2874, 824, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '800px|550px', 'lockcard_createtime,lockcard_remark,lockcard_username,lockcard_endtime,lockcard_sn,lock_id,user_id', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2874, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2875, 824, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|400px', 'lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark', NULL, 'success', '', '', '', 'fa fa-pencil', 2875, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2876, 824, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'lockcard_createtime,lockcard_remark,lockcard_username,lockcard_endtime,lockcard_sn,lock_id,user_id', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2876, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2877, 824, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|550px', 'lockcard_createtime,lockcard_remark,lockcard_username,lockcard_endtime,lockcard_sn,lock_id,user_id', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2877, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2878, 825, '获取锁下卡列表', 'getcardlistbylockid', 1, NULL, '20', 0, NULL, 'select t.*,c.nickname,c.mobile from (select a.*,b.auth_status,b.auth_starttime,b.auth_endtime,b.member_id from cd_lockcard as a left join cd_lockauth as b on a.lockauth_id=b.lockauth_id) as t left join cd_member as c on t.member_id=c.member_id', '获取锁下卡列表', '', '', NULL, NULL, '', '', '', NULL, 1, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2879, 825, '添加钥匙下的卡', 'addauthcard', 3, NULL, '20', 1, 0, '', '添加钥匙下的卡', '', 'lock_id,user_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark,lockcard_createtime', NULL, 'primary', '', '', '', 'fa fa-plus', 2874, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2880, 825, '更新卡', 'updatecard', 4, NULL, '20', 1, 1, '', '更新卡', '', 'lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark', NULL, 'success', '', '', '', 'fa fa-pencil', 2875, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2881, 825, '删除卡', 'delcard', 5, NULL, '20', 1, 1, '', '删除卡', '', 'lock_id,user_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark,lockcard_createtime', NULL, 'danger', '', '', '', 'fa fa-trash', 2876, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2882, 825, '查看卡数据', 'viewcarddetail', 15, NULL, '20', 1, 0, 'select t.*,c.nickname,c.mobile from (select a.*,b.auth_status,b.auth_starttime,b.auth_endtime,b.member_id from cd_lockcard as a left join cd_lockauth as b on a.lockauth_id=b.lockauth_id) as t left join cd_member as c on t.member_id=c.member_id', '查看卡数据', '', 'lock_id,user_id,lockcard_sn,lockcard_endtime,lockcard_username,lockcard_remark,lockcard_createtime', NULL, 'info', '', '', '', 'fa fa-plus', 2877, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2884, 813, '语音设置', 'configaudio', 4, NULL, '', 0, NULL, '', '修改语音设置', '', 'volume,openttscontent', NULL, NULL, '', '', '', NULL, 2884, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2885, 813, '配置显示屏二维码', 'configlcd', 4, NULL, '', 0, NULL, '', '配置显示屏二维码', '', '', NULL, NULL, '', '', '', NULL, 2885, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2886, 794, '根据手机号查询用户信息', 'getuserbymobile', 15, NULL, '', 0, NULL, '', '根据手机号查询用户', '', '', NULL, NULL, '', '', '', NULL, 2886, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2887, 813, '转移所有权', 'townership', 4, NULL, '', 0, NULL, '', '转移所有权', '', 'member_id,user_id', NULL, NULL, '', '', '', NULL, 2887, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2888, 813, '控制设备进出发卡模式', 'devaddcard', 4, NULL, '', 0, NULL, '', '控制设备进出发卡模式', '', '', NULL, NULL, '', '', '', NULL, 2888, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2889, 824, '导出', 'dumpData', 12, NULL, '20', 1, 0, NULL, '导出', '', NULL, NULL, 'warning', NULL, NULL, NULL, 'fa fa-download', 2889, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2890, 826, '首页数据列表', 'index', 1, NULL, '20', 1, 0, 'select a.*,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile from cd_umember as a inner join cd_member as b  where a.member_id=b.member_id', '用户管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2891, 826, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2892, 826, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2892, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2893, 826, '修改', 'update', 4, NULL, '20', 1, 1, NULL, '修改', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'success', NULL, NULL, NULL, 'fa fa-pencil', 2893, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2894, 826, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,user_id,status,ucreate_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2894, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2895, 826, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2895, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2896, 826, '导出', 'dumpData', 12, NULL, '20', 1, 0, NULL, '导出', '', 'member_id,user_id,status,ucreate_time', NULL, 'warning', NULL, NULL, NULL, 'fa fa-download', 2896, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2897, 827, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '服务管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, 'wservice_sort', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2898, 827, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2899, 827, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|500px', 'wservice_type,wservice_name,wservice_icon,wservice_appid,wservice_url,wservice_sort', NULL, 'primary', '', '', '', 'fa fa-plus', 2899, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2900, 827, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|500px', 'wservice_type,wservice_name,wservice_icon,wservice_appid,wservice_url,wservice_sort', NULL, 'success', '', '', '', 'fa fa-pencil', 2900, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2901, 827, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'wservice_type,wservice_name,wservice_appid,wservice_url,wservice_icon', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2901, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2902, 827, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|500px', 'wservice_type,wservice_name,wservice_icon,wservice_appid,wservice_url,wservice_sort', NULL, 'info', '', '', '', 'fa fa-plus', 2902, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2903, 828, '服务列表', 'index', 1, NULL, '20', 0, NULL, '', '服务管理', '', '', NULL, NULL, '', '', '', NULL, 1, NULL, 'wservice_sort', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2908, 824, '批量续卡', 'batchupcard', 14, NULL, '', 1, 0, '', '批量编辑数据', '600px|400px', 'lockcard_endtime,batchstatus', NULL, 'primary', '', '', '', 'fa fa-edit', 2908, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2909, 825, '队列任务', 'cardtask', 4, NULL, '', 0, NULL, '', '编辑数据', '', '', NULL, NULL, '', '', '', NULL, 2909, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2910, 830, '首页数据列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.lock_name from cd_doorstatus as a inner join cd_lock as b  where a.doorstatus_sn=b.lock_sn', '门状态数据', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2911, 830, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2912, 831, '首页数据列表', 'index', 1, NULL, '20', 0, NULL, NULL, '门状态数据', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2913, 831, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|400px', 'doorstatus_sn,doorstatus_action,user_id,doorstatus_time', NULL, 'primary', '', '', '', 'fa fa-plus', 2913, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2914, 832, '首页数据列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.lock_name from cd_doorstatus as a inner join cd_lock as b  where a.doorstatus_sn=b.lock_sn', '门状态数据', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, '');

-- ----------------------------
-- Table structure for cd_application
-- ----------------------------
DROP TABLE IF EXISTS `cd_application`;
CREATE TABLE `cd_application`  (
  `app_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `app_dir` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(4) NULL DEFAULT NULL,
  `app_type` tinyint(4) NULL DEFAULT NULL,
  `login_table` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `login_fields` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `domain` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pk` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录表主键',
  PRIMARY KEY (`app_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 182 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_application
-- ----------------------------
INSERT INTO `cd_application` VALUES (1, '后台管理端', 'admin', 1, 1, '', '', '', NULL);
INSERT INTO `cd_application` VALUES (179, 'api', 'api', 1, 2, '', '', 'https://wxapp.wmj.com.cn/api', '');
INSERT INTO `cd_application` VALUES (181, 'minilock', 'minilock', 1, 2, '', '', '', '');

-- ----------------------------
-- Table structure for cd_config
-- ----------------------------
DROP TABLE IF EXISTS `cd_config`;
CREATE TABLE `cd_config`  (
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `data` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_config
-- ----------------------------
INSERT INTO `cd_config` VALUES ('copyright', '黔ICP备12003086号-3');
INSERT INTO `cd_config` VALUES ('default_themes', '');
INSERT INTO `cd_config` VALUES ('description', '微门禁小程序管理平台');
INSERT INTO `cd_config` VALUES ('domain', '');
INSERT INTO `cd_config` VALUES ('file_size', '100');
INSERT INTO `cd_config` VALUES ('file_type', 'gif,png,jpg,jpeg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt,mp4,flv');
INSERT INTO `cd_config` VALUES ('images_size', '10M');
INSERT INTO `cd_config` VALUES ('keyword', '');
INSERT INTO `cd_config` VALUES ('privacypolicy', '&lt;p&gt;&amp;lt;p&amp;gt;&amp;amp;lt;p&amp;amp;gt;隐私政策&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;贵州智云信通科技有限公司（以下简称&amp;amp;amp;quot;本公司&amp;amp;amp;quot;，产品“微门禁”）在此郑重承诺，尊重和保护您的个人隐私，在使用微门禁相关产品前，请务必仔细阅读并理解本政策，在同意的情况下使用相关产品或服务。您一旦访问本公司旗下产品微门禁公众号及小程序等应用平台，则表明您已同意本《隐私政策》的内容。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;一、个人信息定义&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;个人信息是指您的任何标识性信息，包括：姓名、性别、身份证件号码、地址、健康状况、定位信息、电话号码、工作单位等。通常情况下，您无须提供您的个人信息即可，访问本网站。但为了提高服务质量，本公司可能需要您提供一些个人信息，以使本公司更好地了解您的需求来为您服务，同时，本公司有权采取措施验证您提供的个人信息的真实性。如果您提供了有关他人的个人信息，则表明您已取得了他人的正式许可。本公司承诺，除非出于您自己的意愿，本公司不会将您的个人信息提供给本公司之外的任何第三方。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;二、个人信息的收集目的&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;微门禁需要您提供个人信息的目的是确保您有权开启所需要的门禁系统，门禁所属单位对您进行验证审核并开放使用权限，提供安全便捷的开门服务，我们会征求您的同意，以便根据您的请求向您提供服务或执行事务，包括：接收有关本公司的产品和服务的信息、注册参加活、购买或注册本公司的产品、客户满意度调查、法律强制性规定等。另外，为抗击新冠肺炎疫情需要，我们提供的健康登记系统，将采集您的健康相关信息，为抗击疫情提供基础信息技术服务。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;3、 个人信息的使用&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;您提供的个人信息将仅在本公司内部使用，使用您的个人信息只是为了更好地了解您的需要并为您提供更好的服务或执行事务，同时本公司可能会使用您的个人信息与您联系以便向您提供服务。为抗击新冠肺炎疫情需要，我们开发了健康登记系统平台，健康相关信息由相应申请使用单位掌握，请知悉。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;4、 个人信息的安全&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;本公司承诺，保护您个人信息的安全性，同时，本公司已采取现有的可靠的安全措施保护您的个人信息免于未经授权的访问、使用或泄露。这些安全措施包括向云服务提供商备份数据和对用户密码加密。尽管有这些安全措施，但本公司不保证这些信息的绝对安全。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;5、 未成年人保护&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;未满十八岁的未成年人可在父母或监护人指导使用我们的服务。我们建议未成年人的父母或监护人阅读本《隐私政策》，并建议未成年人在提交的个人信息之前寻求父母或监护人的同意和指导。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;6、 关于Cookie&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;当您访问微门禁微信公众号、微信小程序、支付宝小程序及Web管理站点时，本公司可能会以&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;的形式将某些信息存入您的手机或计算机，&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;是网页服务器放置在您的计算机上的一个小的文本文件，&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;不能用于运行程序，也不会将病毒传播到您的计算机上。使用&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;的目的是为您提供一项节省时间的简便功能，但并不表示本公司可自动获悉有关您的任何个人信息。本网站可能还会使用session技术或其他技术以便能更好地调整本网站，从而提供优质服务。您可以选择接受或拒绝&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;7、 其他站点的链接&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;微门禁各平台及网站可能包含与其他站点的链接，但都是只读服务。本公司不对其他站点内容突变造成的《隐私政策》或内容负责。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;8、 法律性公开&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;根据法律强制性规定，安防法规条款等约束，微门禁应用平台及网站可能需要公开您的个人信息而无须获得您的预先同意并对此不负任何责任。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;9、 本《隐私政策》的修改&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;本《隐私政策》的修改权和解释权属于本公司。本公司可能适时修订本《隐私政策》的条款并予以公布，修订的内容自公布之日起生效，若您继续使用我们的服务，即表示同意受经修订的本《隐私政策》的约束。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;10、 纠纷解决&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;本《隐私政策》或有关使用微门禁应用平台及网站的任何行为受中华人民共和国法律管辖，如双方发生争议先协商解决，协商不成的，则交由本公司法定地址所在地的人民法院作出裁决。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;11、 联系方式&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;如果您有任何疑问和建议，可以通过微门禁应用平台及网站上的联系方式与本公司联系，本公司将尽最大的努力去解决。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;&amp;amp;lt;br/&amp;amp;gt;&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;贵州智云信通科技有限公司&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;二零二零年三月&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;&amp;amp;lt;br/&amp;amp;gt;&amp;amp;lt;/p&amp;amp;gt;&amp;lt;/p&amp;gt;&lt;/p&gt;');
INSERT INTO `cd_config` VALUES ('serviceagreement', '&lt;p&gt;&amp;lt;p&amp;gt;微门禁用户服务协议&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;一、服务条款&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;您在使用微门禁服务前，应当仔细阅读《微门禁用户服务协议》（以下简称&amp;amp;quot;本协议&amp;amp;quot;或&amp;amp;quot;用户协议&amp;amp;quot;）的全部内容，您在用户注册页面点击&amp;amp;quot;同意以下协议并注册&amp;amp;quot;按钮后，即视为您已阅读、理解并同意本协议的全部内容。敬请注意，一旦您注册（登录）成功，本协议即在您与微门禁之间产生法律效力，成为对双方均具有约束力的法律文件。您应遵守以下协议的各项条款。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;二、目的&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;本协议是约定您使用微门禁提供的服务时，微门禁与您的权利、义务、服务条款等基本事宜为目的。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;三、遵守法律及法律效力&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;在您完成在线注册成功后，您就已与微门禁缔结了本协议，且本协议自您注册（登录）成功之日起产生法律效力。 您同意遵守《中华人民共和国保密法》、《计算机信息系统国际联网保密管理规定》、《中华人民共和国计算机信息系统安全保护条例》、《计算机信息网络国际联网安全保护管理办法》、《中华人民共和国计算机信息网络国际联网管理暂行规定》及其实施办法等相关法律法规的任何及所有的规定，并对您以任何方式使用服务的任何行为及其结果承担全部责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;在任何情况下，如果微门禁合理地认为您的任何行为，包括但不限于您的任何言论和其他违反或可能违反上述法律法规规定的任何行为，微门禁可在不经任何事先通知的情况下终止向您提供服务。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁有权利修改更新本协议的有关条款，一旦条款内容发生变动，微门禁将会在相关的页面提示修改内容。在更改此用户服务协议时，微门禁将说明更改内容的执行日期，变更理由等。且应同现行的使用服务协议一起，在更改内容发生效力前7日内向您公告。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;请仔细阅读用户协议更改内容，如因个人原因未能获知变更内容所带来的损害，微门禁一概不予负责。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如果不同意微门禁对服务条款所做的修改，用户有权停止使用网络服务。如果用户继续使用网络服务，则视为用户接受变更后的用户协议。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;四、服务内容&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁服务的具体内容由微门禁根据实际情况提供，微门禁保留随时变更、中断或终止部分或全部微门禁服务的权利。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;五、您的义务&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户在申请使用微门禁服务时，必须向微门禁提供准确的个人资料，如个人资料有任何变动，必须及时更新。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户注册成功后，微门禁将给予每个用户一个用户帐号及相应的密码，该用户帐号和密码由用户负责保管；用户应当对以其用户帐号进行的所有活动和事件负法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户在使用微门禁网络服务过程中，必须遵循以下原则：&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;遵守中国有关的法律和法规；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得为任何非法目的而使用网络服务系统；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;遵守所有与网络服务有关的网络协议、规定和程序&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统传输任何危害社会，侵蚀道德风尚，宣传不法宗教组织等内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统进行任何可能对互联网的正常运转造成不利影响的行为；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统上传、传输任何非法、有害、胁迫、滥用、骚扰、侵害、中伤、粗俗、猥亵、诽谤、侵害他人隐私、辱骂性的、恐吓性的、庸俗淫秽的及有害或种族歧视的或道德上令人不快的包括其他任何非法的信息资料；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统进行任何不利于微门禁的行为；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如发现任何非法使用用户帐号或帐号出现安全漏洞的情况，应立即通知微门禁。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;六、微门禁的权利及义务&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁除特殊情况外（例如：协助公安等相关部门调查破案等），致力于努力保护您的个人资料不被外漏，且不得在未经本人的同意下向第三者提供您的个人资料。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁根据提供服务的过程，经营上的变化，有权变更所提供服务的内容。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁在提供服务过程中，应及时解决您提出的不满事宜，如在解决过程中确有难处，可以采取公开通知方式或向您发送电子邮件寻求解决办法。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁在下列情况下有权未经通知，直接删除您上载的内容：&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;有损于微门禁，您或第三者名誉的内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;利用微门禁服务系统上载、张贴或传送任何非法、有害、胁迫、滥用、骚扰、侵害、中伤、粗俗、猥亵、诽谤、侵害他人隐私、辱骂性的、恐吓性的、庸俗淫秽的及有害或种族歧视的或道德上令人不快的包括其他任何非法的内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;侵害微门禁或第三者的版权，著作权等内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;存在与微门禁提供的服务无关的内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;无故盗用他人的ID(固有用户名)，姓名上传、传播任何内容及恶意更改，伪造他人上载内容。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;七、知识产权声明&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁所有的产品、技术、程序、页面（包括但不限于页面设计及内容）以及资料内容（包括但不限于本站所刊载的图片、视频）均属于知识产权，仅供用户交流、学习、研究和欣赏，未经授权，任何人不得擅自使用，否则，将依法追究法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁用户上传的资料内容（包括但不限于图片、视频、点评等），应保证为原创或已得到充分授权，并具有准确性、真实性、正当性、合法性，且不含任何侵犯第三人权益的内容，因抄袭、转载、侵权等行为所产生的纠纷由用户自行解决，微门禁不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;八、免责声明&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;任何人因使用微门禁而可能遭致的意外及其造成的损失（包括因使用微门禁可能链接的第三方网站内容而感染电脑病毒），我们对此概不负责，亦不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁禁止制作、复制、发布、传播等具有反动、色情、暴力、淫秽等内容的信息，一经发现，立即删除。若您因此触犯法律，我们对此不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;您自行上传或通过网络收集的资源，我们仅提供一个展示、交流的平台，不对其内容的准确性、真实性、正当性、合法性负责，也不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;任何单位或个人认为通过微门禁展示的内容可能涉嫌侵犯其著作权，应该及时向我们提出书面权利通知，并提供身份证明、权属证明及详细侵权情况证明。我们收到上述法律文件后，将会依法尽快处理。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;九、服务变更、中断或终止&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如因系统维护或升级的需要而需暂停微门禁服务，微门禁将尽可能事先进行通告。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如发生下列任何一种情形，微门禁有权随时中断或终止向用户提供本协议项下的微门禁服务而无需通知用户：&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户提供的个人资料不真实；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户违反本用户协议中规定的使用规则。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;在用户违反本协议时，微门禁同时保留在不事先通知用户的情况下随时中断或终止部分或全部微门禁服务的权利，对于所有服务的中断或终止而造成的任何损失，微门禁无需对用户或任何第三方承担任何责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;2020.03&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;（以下无正文）&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&lt;/p&gt;');
INSERT INTO `cd_config` VALUES ('site_logo', '');
INSERT INTO `cd_config` VALUES ('site_title', '微门禁小程序管理平台');
INSERT INTO `cd_config` VALUES ('wmjaeskey', '');
INSERT INTO `cd_config` VALUES ('wmjappid', 'wmj_3bd1gtYMxxx');
INSERT INTO `cd_config` VALUES ('wmjappsecret', 'xxxxxxBwIvl2dwD0pST2dIMm8MZOxxxxxx');

-- ----------------------------
-- Table structure for cd_doorstatus
-- ----------------------------
DROP TABLE IF EXISTS `cd_doorstatus`;
CREATE TABLE `cd_doorstatus`  (
  `doorstatus_id` int(11) NOT NULL AUTO_INCREMENT,
  `doorstatus_sn` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `doorstatus_action` smallint(6) NULL DEFAULT NULL COMMENT '状态',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理用户',
  `doorstatus_time` int(11) NULL DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`doorstatus_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 223 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_doorstatus
-- ----------------------------

-- ----------------------------
-- Table structure for cd_electricity
-- ----------------------------
DROP TABLE IF EXISTS `cd_electricity`;
CREATE TABLE `cd_electricity`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `electricity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` bigint(20) NULL DEFAULT NULL,
  `device_sn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_electricity
-- ----------------------------

-- ----------------------------
-- Table structure for cd_ext_health
-- ----------------------------
DROP TABLE IF EXISTS `cd_ext_health`;
CREATE TABLE `cd_ext_health`  (
  `health_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `mobile` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `first_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '第一居住地址',
  `second_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '第二居住地址',
  `job` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '工作或学习单位',
  `yiqu` tinyint(4) UNSIGNED NOT NULL DEFAULT 2 COMMENT '30日内是否来自疫区:1是,默认2否',
  `register_type` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '登记类型:默认1村居,2乡镇社区,3区县,4交通运输',
  `health` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '健康状况默认1健康,2异常,3其他',
  `manyou` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '通行证截图',
  `ctime` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `utime` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  PRIMARY KEY (`health_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_ext_health
-- ----------------------------

-- ----------------------------
-- Table structure for cd_face
-- ----------------------------
DROP TABLE IF EXISTS `cd_face`;
CREATE TABLE `cd_face`  (
  `face_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `face_name` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸备注',
  `face_images` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸图片地址',
  `created_at` int(255) NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint(11) NULL DEFAULT NULL,
  `member_id` bigint(11) NULL DEFAULT NULL,
  `sCertificateNumber` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`face_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_face
-- ----------------------------

-- ----------------------------
-- Table structure for cd_field
-- ----------------------------
DROP TABLE IF EXISTS `cd_field`;
CREATE TABLE `cd_field`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(9) NOT NULL COMMENT '模块ID',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '字段名称',
  `field` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '表单类型1输入框 2下拉框 3单选框 4多选框 5上传图片 6编辑器 7时间',
  `list_show` tinyint(4) NULL DEFAULT NULL COMMENT '列表显示',
  `search_show` tinyint(4) NULL DEFAULT NULL COMMENT '搜索显示',
  `search_type` tinyint(4) NULL DEFAULT NULL COMMENT '1精确匹配 2模糊搜索',
  `config` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '下拉框或者单选框配置',
  `is_post` tinyint(4) NULL DEFAULT NULL COMMENT '是否前台录入',
  `is_field` tinyint(4) NULL DEFAULT NULL,
  `align` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '表格显示位置',
  `note` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提示信息',
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '错误提示',
  `validate` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '验证方式',
  `rule` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '验证规则',
  `sortid` mediumint(9) NULL DEFAULT 0 COMMENT '排序号',
  `sql` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字段配置数据源sql',
  `tab_menu_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属选项卡名称',
  `default_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `datatype` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字段数据类型',
  `length` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字段长度',
  `indexdata` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '索引',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3593 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_field
-- ----------------------------
INSERT INTO `cd_field` VALUES (134, 18, '编号', 'user_id', 1, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 1, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (135, 18, '真实姓名', 'name', 1, 1, 0, NULL, '', 1, 0, 'center', '', '用户名不能为空', 'notEmpty', '', 2, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (136, 18, '用户名', 'user', 1, 1, 1, 1, '', 1, 0, 'center', '', '用户名不能为空', 'notEmpty,unique', '', 3, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (137, 18, '密码', 'pwd', 5, 0, 0, 0, '', 1, 0, 'center', '', '6-21位数字字母组合', 'notEmpty', '/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/', 4, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (138, 18, '所属分组', 'group_id', 29, 0, 1, 0, '', 1, 0, 'center', '', '', '', '', 5, 'select  group_id,name from pre_group', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (139, 18, '类别', 'type', 3, 1, 1, 0, '超级管理员|1|success,普通管理员|2|warning', 1, 0, 'center', '', '', '', '', 6, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (140, 18, '备注', 'note', 1, 1, 0, NULL, '', 1, 0, 'center', '', '', '', '', 7, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (141, 18, '状态', 'status', 3, 1, 1, 0, '正常|1|primary,禁用|0|danger', 1, 0, 'center', '', '', '', '', 7, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (142, 18, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3338, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (143, 18, '所属分组', 'group_name', 1, 1, 0, NULL, '', 0, 0, 'center', '', '', '', '', 5, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (144, 19, '编号', 'group_id', 1, 1, 1, NULL, '', 0, 0, 'center', '', '', '', '', 1, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (145, 19, '名称', 'name', 1, 1, 0, NULL, '', 1, 0, 'center', '', '名称不能为空', 'notEmpty', '', 2, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (146, 19, '状态', 'status', 3, 1, 0, NULL, '正常|10|primary,禁用|0|danger', 1, 0, 'center', '', '', '', '', 3, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (147, 19, '类别', 'role', 3, 1, 0, NULL, '普通管理员|2|success,超级管理员|1|primary', 1, 0, 'center', '', '', '', '', 4, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (187, 52, '编号', 'log_id', 1, 1, 0, NULL, '', 0, 0, 'center', '', '', '', '', 1, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (188, 52, '用户名', 'username', 1, 1, 1, NULL, '', 1, 1, 'center', '', '', '', '', 188, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (189, 52, '操作', 'event', 1, 1, 0, NULL, '', 1, 1, 'center', '', '', '', '', 191, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (190, 52, '登录IP', 'ip', 1, 1, 0, NULL, '', 1, 1, 'center', '', '', '', '', 192, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (191, 52, '最后登录时间', 'time', 7, 1, 0, NULL, '', 1, 1, 'center', '', '', '', '', 193, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (192, 52, '昵称', 'nickname', 1, 1, 0, NULL, '', 0, 0, 'center', '', '', '', '', 189, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (193, 52, '所属分组', 'group_name', 1, 1, 0, NULL, '', 0, 0, 'center', '', '', '', '', 190, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (194, 41, '站点名称', 'site_title', 1, 0, 0, NULL, '', 1, 0, 'center', '', '', 'notEmpty', '', 194, '', '基本设置', '', '', '', '');
INSERT INTO `cd_field` VALUES (195, 41, '关键词站点', 'keyword', 28, 0, 0, NULL, '', 1, 0, 'center', '', '', '', '', 196, '', '基本设置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (196, 41, '站点描述', 'description', 6, 0, 0, NULL, '', 1, 0, 'center', '', '', '', '', 197, '', '基本设置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (198, 41, '站点LOGO', 'site_logo', 8, 0, 0, NULL, '', 1, 0, 'center', '', '', '', '', 195, '', '基本设置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (200, 41, '上传文件大小', 'file_size', 1, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 200, '', '上传配置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (488, 41, '文件类型', 'file_type', 6, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 488, '', '上传配置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (700, 41, '绑定域名', 'domain', 1, 0, 0, 0, '', 1, 1, 'center', '上传目录绑定域名访问，请解析域名到 /public/upload目录  前面带上http://  非必填项', '', '', '', 700, '', '上传配置', '', '', '', '');
INSERT INTO `cd_field` VALUES (1462, 41, '站点版权', 'copyright', 1, NULL, 0, NULL, '', 1, NULL, 'center', '', '', '', '', 1462, NULL, '基本设置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3213, 793, '编号', 'member_id', 1, 1, 1, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3214, 793, '呢称', 'nickname', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3214, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3215, 793, '头像', 'headimgurl', 8, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3215, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3216, 793, 'openid', 'openid', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3216, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3217, 793, '手机号', 'mobile', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '/^1[3456789]\\\\d{9}$/', 3223, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3218, 794, '编号', 'member_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3219, 794, '呢称', 'nickname', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3214, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3220, 794, '头像', 'headimgurl', 8, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3215, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3221, 794, 'openid', 'openid', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3216, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3222, 794, '手机号', 'mobile', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '/^1[23456789]\\\\d{9}$/', 3236, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3223, 793, '用户名', 'username', 1, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3224, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3224, 793, '密码', 'password', 5, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3238, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3225, 797, '手机号', 'mobile', 1, 1, 1, 0, '手机号', 1, 1, 'center', NULL, '手机号不正确', '', '/^1[1-9]\\\\d{9}$/', 3226, '', NULL, '', 'varchar', '11', '');
INSERT INTO `cd_field` VALUES (3226, 797, '居住地址', 'first_address', 1, 1, 0, 1, '第一居住地址', 1, 1, 'center', NULL, '请输入居住地址', 'notEmpty', '', 3227, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3227, 797, '第二居住地址', 'second_address', 1, 1, 0, 1, '第二居住地址', 1, 1, 'center', NULL, '', '', '', 3228, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3228, 797, '工作或学习单位', 'job', 1, 1, 0, 1, '工作或学习单位', 1, 1, 'center', NULL, '', '', '', 3230, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3229, 797, '疫区', 'yiqu', 20, 1, 0, 0, '30日内是否来自疫区,1是,2否', 1, 1, 'center', NULL, '', 'notEmpty', '', 3231, '', NULL, '2', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3230, 797, '登记类型', 'register_type', 20, 1, 1, 0, '登记类型默认1村居,2乡镇社区,3区县,4交通运输,5校园', 1, 1, 'center', NULL, '登记类型错误', 'notEmpty', '/^[0-9]*$/', 3232, '', NULL, '1', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3231, 797, '健康状况', 'health', 20, 1, 1, 0, '健康状况默认1健康,2异常,3其他', 1, 1, 'center', NULL, '', 'notEmpty', '/^[0-9]*$/', 3233, '', NULL, '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3232, 797, '漫游地截图', 'manyou', 8, 1, 0, 0, '漫游地截图', 1, 1, 'center', NULL, '', '', '', 3235, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3233, 797, '证明图片', 'txz', 8, 1, 0, 0, '证明图片', 1, 1, 'center', NULL, '', '', '', 3258, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3315, 804, '编号', 'regpoint_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3235, 797, '创建时间', 'create_time', 12, 1, 1, 0, '', 1, 1, 'center', NULL, '', 'notEmpty', '', 3259, '', NULL, '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3236, 794, '用户名', 'username', 1, 1, 1, 0, '', 1, 0, 'center', NULL, '', '', '', 3237, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3237, 794, '密码', 'password', 5, 1, 0, 0, '', 1, 0, 'center', NULL, '', '', '', 3241, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3238, 793, '注册时间', 'create_time', 7, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3239, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3239, 793, '性别', 'sex', 3, 1, 1, 0, '男|1|success,女|2|warning', 1, 1, 'center', '', '', '', '', 3240, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3240, 793, '状态', 'status', 23, 1, 1, 0, '开启|1,关闭|0', 1, 1, 'center', '', '', '', '', 3244, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3241, 794, '性别', 'sex', 3, 1, 1, 0, '', 1, 0, 'center', NULL, '', '', '', 3242, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3242, 794, '状态', 'status', 23, 1, 1, 0, '', 1, 0, 'center', NULL, '', '', '', 3243, '', NULL, '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3243, 794, '创建时间', 'create_time', 7, 1, 1, 0, '', 1, 0, 'center', NULL, '', '', '', 3245, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3244, 793, '所属用户', 'user_id', 15, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3490, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3245, 794, '所属用户', 'user_id', 15, 1, 1, 0, '', 1, 0, 'center', NULL, '', '', '', 3489, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3309, 802, 'openid', 'openid', 1, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3309, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3307, 802, '所属用户', 'user_id', 15, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3262, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3304, 802, '登记时间', 'create_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3259, '', '', '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3305, 802, '经度', 'lat', 1, 0, 0, 0, '', 1, 0, 'center', NULL, '', '', '', 3260, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3306, 802, '纬度', 'lng', 1, 0, 0, 0, '', 1, 0, 'center', NULL, '', '', '', 3261, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3303, 802, '通行证截图', 'txz', 8, 0, 0, 0, '通行证截图', 1, 0, 'center', '', '', '', '', 3258, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3302, 802, '漫游地截图', 'manyou', 8, 1, 0, 0, '漫游地截图', 1, 0, 'center', NULL, '', '', '', 3235, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3300, 802, '登记类型', 'register_type', 3, 1, 1, 0, '村居(物业)|1,乡镇社区|2,区县|3,交通运输|4,其他|5', 1, 1, 'center', '', '登记类型错误', '', '/^[0-9]*$/', 3232, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3299, 802, '是否来自疫区', 'yiqu', 3, 1, 1, 0, '是|1,否|2', 1, 1, 'center', '', '', '', '', 3231, '', '', '2', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3258, 797, '姓名', 'name', 1, 1, 1, 0, '', 1, 0, 'center', NULL, '', 'notEmpty', '', 3225, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3259, 797, '当前位置', 'position', 1, 1, 1, 0, '', 1, 0, 'center', NULL, '', 'notEmpty', '', 3229, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3301, 802, '健康状况', 'health', 3, 1, 1, 0, '健康|1|primary,发热|2|danger,发热咳嗽|3|danger,头晕乏力|4|warning,腹泻|5|warning,其他|6|warning', 1, 1, 'center', '', '', 'notEmpty', '/^[0-9]*$/', 3233, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3260, 797, '经度', 'lat', 1, 0, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 3260, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3261, 797, '纬度', 'lng', 1, 0, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 3261, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3262, 797, '所属用户', 'user_id', 15, 1, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 3262, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3310, 803, '编号', 'lock_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3311, 803, '锁名称', 'lock_name', 1, 1, 1, 1, '', 1, 1, 'center', '', '', 'notEmpty', '', 3314, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3312, 803, '序列号', 'lock_sn', 1, 1, 1, 0, '', 1, 1, 'center', '', '', 'notEmpty,unique', '', 3344, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3308, 797, 'openid', 'openid', 1, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3308, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3298, 802, '工作或学习单位', 'job', 1, 1, 0, 1, '', 1, 0, 'center', '', '', '', '', 3230, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3297, 802, '当前位置', 'position', 1, 1, 0, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3229, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3296, 802, '第二居住地址', 'second_address', 1, 1, 0, 1, '', 1, 0, 'center', '', '', '', '', 3228, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3295, 802, '家庭地址', 'first_address', 1, 1, 0, 1, '', 1, 0, 'center', '', '请输入居住地址', 'notEmpty', '', 3227, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3293, 802, '姓名', 'name', 1, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3225, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3294, 802, '手机号', 'mobile', 1, 1, 1, 0, '', 1, 0, 'center', '', '手机号不正确', '', '/^1[1-9]\\\\d{9}$/', 3226, '', '', '', 'varchar', '11', '');
INSERT INTO `cd_field` VALUES (3347, 803, '启用/禁用', 'status', 23, 1, 1, 0, '启用|1|success,禁用|0|danger', 1, 1, 'center', '', '', '', '', 3349, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3314, 803, '用户ID', 'user_id', 15, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3313, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3316, 804, '会员ID', 'member_id', 20, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3316, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3317, 804, '用户ID', 'user_id', 15, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3317, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3318, 804, '名称', 'regpointname', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3318, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3319, 804, '注册点url', 'regpointurl', 1, 0, 0, 0, '', 0, 1, 'center', '', '', '', '', 3319, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3320, 804, '创建时间', 'create_time', 12, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3340, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3321, 805, '编号', 'regpoint_id', 1, 1, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 1, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3322, 805, '会员ID', 'member_id', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3316, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3323, 805, '用户ID', 'user_id', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3317, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3324, 805, '名称', 'regpointname', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3318, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3325, 805, '注册点url', 'regpointurl', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3319, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3326, 805, '创建时间', 'create_time', 12, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3320, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3327, 806, '编号', 'user_id', 1, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 1, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3328, 806, '真实姓名', 'name', 1, 1, 0, NULL, '', 1, 0, 'center', '', '用户名不能为空', 'notEmpty', '', 2, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3329, 806, '用户名', 'user', 1, 1, 1, 1, '', 1, 0, 'center', '', '用户名不能为空', 'notEmpty,unique', '', 3, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (3330, 806, '密码', 'pwd', 5, 0, 0, 0, '', 1, 0, 'center', '', '6-21位数字字母组合', 'notEmpty', '/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/', 4, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (3331, 806, '所属分组', 'group_id', 29, 0, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 5, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3332, 806, '所属分组', 'group_name', 1, 1, 0, NULL, '', 0, 0, 'center', '', '', '', '', 5, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3333, 806, '类别', 'type', 3, 1, 1, 0, '超级管理员|1|success,普通管理员|2|warning', 1, 0, 'center', '', '', '', '', 6, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (3334, 806, '备注', 'note', 1, 1, 0, NULL, '', 1, 0, 'center', '', '', '', '', 7, '', '', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3335, 806, '状态', 'status', 3, 1, 1, 0, '正常|1|primary,禁用|0|danger', 1, 0, 'center', '', '', '', '', 7, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (3336, 806, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3337, '', '', '', '', '', '');
INSERT INTO `cd_field` VALUES (3337, 806, '会员ID', 'member_id', 20, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 8, '', NULL, '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3338, 18, '会员ID', 'member_id', 20, 1, 1, 0, '', 1, 1, 'center', '', '', 'unique', '', 8, '', '', '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3339, 805, '登记点二维码', 'regpointqrcode', 8, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3339, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3340, 804, '登记点二维码', 'regpointqrcode', 8, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3320, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3344, 803, '需绑手机', 'mobile_check', 23, 1, 0, 0, '是|1|primary,否|0|info', 1, 1, 'center', '', 'mobile_check', '', '', 3345, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3341, 802, '登记点ID', 'regpoint_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3341, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3342, 797, '登记点ID', 'regpoint_id', 20, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3342, '', NULL, '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3343, 802, '登记点', 'regpointname', 1, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3343, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3345, 803, '申请钥匙', 'applyauth', 23, 1, 0, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3346, '', '', '0', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3346, 803, '审核钥匙', 'applyauth_check', 23, 1, 0, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3347, '', '', '0', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3348, 803, '类型', 'lock_type', 2, 0, 0, 0, 'WiFi版|1|success,插卡版(2G)|2|primary,插卡版(4G)|3|primary,网线版|4|info', 1, 1, 'center', '', '', '', '', 3351, 'select locktype_id,locktype_name from cd_locktype', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3349, 803, '位置', 'location', 19, 0, 0, 0, '', 1, 1, 'center', '', '', 'notEmpty', '', 3354, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3354, 803, '二维码', 'lock_qrcode', 8, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3452, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3351, 803, '添加时间', 'create_time', 12, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3453, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3352, 807, '编号', 'locktype_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3353, 807, '名称', 'locktype_name', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3353, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3355, 41, '微门禁appid', 'wmjappid', 1, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3355, '', '门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3356, 41, '微门禁appsecret', 'wmjappsecret', 1, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3356, '', '门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3357, 803, '在线状态', 'online', 3, 1, 1, 0, '在线|1|primary,离线|0|warning', 1, 1, 'center', '', '', '', '', 3357, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3460, 818, '编号', 'locktimes_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3358, 41, '微门禁aeskey', 'wmjaeskey', 1, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3358, '', '门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3359, 809, '编号', 'lockauth_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3360, 809, '锁ID', 'lock_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3360, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3361, 809, '会员ID', 'member_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3362, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3362, 809, '分享人ID', 'auth_member_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3367, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3363, 809, '有效期结束', 'auth_endtime', 7, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3432, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3364, 809, '分享权限', 'auth_shareability', 23, 1, 0, 0, '开启|1,关闭|0', 1, 1, 'center', '', '', '', '', 3447, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3497, 803, '点击开门广告', 'hitshowminiad', 23, 0, 0, 0, '开启|0,关闭|1', 1, 1, 'center', '', '', '', '', 3498, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3365, 809, '备注', 'remark', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3451, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3366, 809, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3471, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3367, 809, '有效期起始', 'auth_starttime', 7, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3431, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3475, 819, '编号', 'locktimes_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3408, 813, '二维码', 'lock_qrcode', 8, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3426, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3407, 813, '添加时间', 'create_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3357, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3406, 813, '位置', 'location', 19, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3354, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3405, 813, '类型', 'lock_type', 2, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3351, 'select locktype_id,locktype_name from cd_locktype', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3404, 813, '开关', 'status', 23, 1, 1, 0, '启用|1|success,禁用|0|danger', 1, 0, 'center', '', '', '', '', 3349, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3403, 813, '审核钥匙', 'applyauth_check', 23, 1, 1, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3347, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3402, 813, '申请钥匙', 'applyauth', 23, 1, 1, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3346, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3401, 813, '绑定手机', 'mobile_check', 23, 1, 1, 0, '是|1|primary,否|0|info', 1, 0, 'center', '', 'mobile_check', '', '', 3345, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3397, 813, '编号', 'lock_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3398, 813, '用户ID', 'user_id', 15, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3313, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3399, 813, '锁名称', 'lock_name', 1, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3314, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3400, 813, '序列号', 'lock_sn', 1, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty,unique', '', 3344, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3412, 814, '会员ID', 'member_id', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3361, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3411, 814, '锁ID', 'lock_id', 20, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3360, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3410, 814, '编号', 'lockauth_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3409, 813, '状态', 'online', 3, 1, 1, 0, '在线|1|primary,离线|0|warning', 1, 0, 'center', '', '', '', '', 3454, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3390, 812, '编号', 'locklog_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3391, 812, '会员ID', 'member_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3391, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3392, 812, '锁ID', 'lock_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3393, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3393, 812, '状态', 'status', 3, 1, 0, 0, '成功|1|primary,失败|0|danger', 1, 1, 'center', '', '', '', '', 3456, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3394, 812, '类型', 'type', 3, 1, 0, 0, '扫码开门|1|primary,点击开门|2|info,后台开门|3|success', 1, 1, 'center', '', '', '', '', 3457, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3395, 812, '开门时间', 'create_time', 12, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3586, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3396, 812, '管理员ID', 'user_id', 15, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3392, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3413, 814, '分享人会员ID', 'auth_member_id', 20, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3363, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3414, 814, '有效期结束时间', 'auth_endtime', 7, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3367, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3415, 814, '有效期起始时间', 'auth_starttime', 7, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3366, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3416, 814, '分享权限', 'auth_shareability', 23, 1, 0, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3428, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3417, 814, '备注', 'remark', 1, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3446, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3418, 814, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3449, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3419, 815, '编号', 'locklog_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3420, 815, '会员ID', 'member_id', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3391, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3421, 815, '管理员ID', 'user_id', 15, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3392, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3422, 815, '锁ID', 'lock_id', 20, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3393, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3423, 815, '状态', 'status', 3, 1, 0, 0, '成功|1|primary,失败|0|danger', 1, 0, 'center', '', '', '', '', 3394, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3424, 815, '类型', 'type', 3, 1, 0, 0, '扫码开门|1|success,点击开门|2|info', 1, 0, 'center', '', '', '', '', 3395, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3425, 815, '开门时间', 'create_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3396, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3426, 813, '会员id', 'member_id', 20, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3312, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3427, 814, '可分享钥匙数', 'auth_sharelimit', 20, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3364, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3428, 814, '开门限制次数', 'auth_openlimit', 20, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3365, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3429, 814, '是否管理员', 'auth_isadmin', 3, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3427, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3430, 809, '可分享数', 'auth_sharelimit', 20, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3430, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3431, 809, '可开次数', 'auth_openlimit', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3473, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3432, 809, '是否管理员', 'auth_isadmin', 3, 0, 0, 0, '是|1|success,否|0|info', 1, 0, 'center', '', '', '', '', 3495, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3433, 812, '备注', 'remark', 1, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3459, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3434, 815, '备注', 'remark', 1, NULL, 0, 0, '', 1, 0, NULL, NULL, '', '', '', 3434, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3435, 816, '站点名称', 'site_title', 1, 0, 0, NULL, '', 1, 0, 'center', '', '', 'notEmpty', '', 194, '', '基本设置', '', '', '', '');
INSERT INTO `cd_field` VALUES (3436, 816, '站点LOGO', 'site_logo', 8, 0, 0, NULL, '', 1, 0, 'center', '', '', '', '', 195, '', '基本设置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3437, 816, '关键词站点', 'keyword', 28, 0, 0, NULL, '', 1, 0, 'center', '', '', '', '', 196, '', '基本设置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3438, 816, '站点描述', 'description', 6, 0, 0, NULL, '', 1, 0, 'center', '', '', '', '', 197, '', '基本设置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3439, 816, '上传文件大小', 'file_size', 1, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 200, '', '上传配置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3440, 816, '文件类型', 'file_type', 6, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 488, '', '上传配置', NULL, NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3441, 816, '绑定域名', 'domain', 1, 0, 0, 0, '', 1, 0, 'center', '上传目录绑定域名访问，请解析域名到 /public/upload目录  前面带上http://  非必填项', '', '', '', 700, '', '上传配置', '', '', '', '');
INSERT INTO `cd_field` VALUES (3442, 816, '站点版权', 'copyright', 1, NULL, 0, NULL, '', 1, 0, 'center', '', '', '', '', 1462, NULL, '基本设置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3443, 816, '微门禁appid', 'wmjappid', 1, NULL, NULL, NULL, '', 1, 0, 'center', '', '', '', '', 3355, '', '微门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3444, 816, '微门禁appsecret', 'wmjappsecret', 1, NULL, NULL, NULL, '', 1, 0, 'center', '', '', '', '', 3356, '', '微门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3445, 816, '微门禁aeskey', 'wmjaeskey', 1, NULL, NULL, NULL, '', 1, 0, 'center', '', '', '', '', 3358, '', '微门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3446, 814, '审核状态', 'auth_status', 3, NULL, 1, 0, '已审核|1,未审核|0', 1, 1, NULL, NULL, '', '', '', 3450, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3447, 809, '钥匙状态', 'auth_status', 23, 1, 1, 0, '启用|1|primary,禁用|0|warning', 1, 0, 'center', '', '', '', '', 3448, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3448, 809, '管理员ID', 'user_id', 15, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3496, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3449, 814, '管理员ID', 'user_id', 20, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3472, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3450, 814, '姓名', 'realname', 1, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3362, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3451, 809, '姓名', 'realname', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3365, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3452, 803, '成功提示图片', 'successimg', 8, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3488, '', '', '/uploads/admin/202007/5f1c6367d68fd.jpg', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3453, 803, '成功广告', 'successadimg', 8, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3497, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3454, 813, '开门成功图片', 'successimg', 8, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3455, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3455, 813, '成功广告', 'successadimg', 8, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3487, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3456, 812, '头像', 'headimgurl', 8, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3395, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3457, 812, '呢称', 'nickname', 1, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3396, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3458, 812, '手机号', 'mobile', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3433, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3459, 812, '锁名称', 'lock_name', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3394, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3461, 818, '管理员ID', 'user_id', 15, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3462, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3462, 818, '锁ID', 'lock_id', 14, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3463, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3463, 818, '周开始', 'startweek', 2, 1, 0, 0, '周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周日|7', 1, 1, 'center', '', '', '', '', 3465, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3464, 818, '小时开始', 'starthour', 2, 1, 0, 0, '0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23', 1, 1, 'center', '', '', '', '', 3466, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3465, 818, '分钟开始', 'startminute', 2, 1, 0, 0, '0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59', 1, 1, 'center', '', '', '', '', 3467, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3466, 818, '周结束', 'endweek', 2, 1, 0, 0, '周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周日|7', 1, 1, 'center', '', '', '', '', 3468, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3467, 818, '小时结束', 'endhour', 2, 1, 0, 0, '0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23', 1, 1, 'center', '', '', '', '', 3469, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3468, 818, '分钟结束', 'endminute', 2, 1, 0, 0, '0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59', 1, 1, 'center', '', '', '', '', 3470, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3469, 818, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3542, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3470, 818, '时段名称', 'locktimesname', 1, 1, 1, 0, '', 1, 1, 'center', '', '', 'notEmpty', '', 3461, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3471, 809, '可开时段', 'auth_opentimes', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3494, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3518, 824, '编号', 'lockcard_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3472, 814, '可开时段', 'auth_opentimes', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3429, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3473, 809, '领取标志', 'auth_tmp', 3, 0, 0, 0, '已领取|1|success,未领取|0|warning', 1, 1, 'center', '', '', '', '', 3517, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3474, 814, '领取标志', 'auth_tmp', 3, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3474, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3476, 819, '时段名称', 'locktimesname', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3461, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3477, 819, '管理员ID', 'user_id', 15, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3462, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3478, 819, '锁ID', 'lock_id', 14, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3463, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3479, 819, '周开始', 'startweek', 2, 1, 0, 0, '周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周七|7', 1, 0, 'center', '', '', '', '', 3464, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3480, 819, '小时开始', 'starthour', 2, 1, 0, 0, '0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23', 1, 0, 'center', '', '', '', '', 3465, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3481, 819, '分钟开始', 'startminute', 2, 1, 0, 0, '0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59', 1, 0, 'center', '', '', '', '', 3466, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3482, 819, '周结束', 'endweek', 2, 1, 0, 0, '周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周七|7', 1, 0, 'center', '', '', '', '', 3467, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3483, 819, '小时结束', 'endhour', 2, 1, 0, 0, '0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23', 1, 0, 'center', '', '', '', '', 3468, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3484, 819, '分钟结束', 'endminute', 2, 1, 0, 0, '0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59', 1, 0, 'center', '', '', '', '', 3469, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3485, 819, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3470, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3486, 803, '开门距离(米)', 'location_check', 3, 1, 1, 0, '不限制|0,20米内|20,50米内|50,100米内|100,200米内|200,300米内|300,500米内|500,1000米内|1000,10K米内|10000', 1, 1, 'center', '', '', '', '', 3348, '', '', '0', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3487, 813, '开门距离', 'location_check', 20, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3348, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3517, 809, '已开次数', 'auth_openused', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3493, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3488, 803, '会员id', 'member_id', 20, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3312, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3489, 794, '支付宝用户id', 'ali_user_id', 1, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3217, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3490, 793, '支付宝id', 'ali_user_id', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3217, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3491, 793, '会员类型', 'member_type', 3, 1, 1, 0, '微信用户|1|primary,支付宝用户|2|success', 1, 1, 'center', '', '', '', '', 3491, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3492, 794, '会员类型', 'member_type', 3, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3492, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3493, 809, '锁名称', 'lock_name', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3361, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3494, 809, '手机号', 'mobile', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3366, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3495, 809, '头像', 'headimgurl', 8, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3363, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3496, 809, '昵称', 'nickname', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3364, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3498, 803, '扫码开门广告', 'qrshowminiad', 23, 0, 0, 0, '开启|0,关闭|1', 1, 1, 'center', '', '', '', '', 3543, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3499, 41, '隐私政策', 'privacypolicy', 16, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3499, '', '隐私政策', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3500, 41, '服务协议', 'serviceagreement', 16, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3500, '', '服务协议', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3525, 824, '发卡时间', 'lockcard_createtime', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3526, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3524, 824, '备注', 'lockcard_remark', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3525, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3523, 824, '持有人', 'lockcard_username', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3523, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3522, 824, '过期时间', 'lockcard_endtime', 7, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3522, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3521, 824, '卡序列号', 'lockcard_sn', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3521, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3519, 824, '锁ID', 'lock_id', 14, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3519, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3520, 824, '管理员ID', 'user_id', 15, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3520, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3516, 794, '同意政策和协议', 'member_ps', 3, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3516, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3515, 816, '服务协议', 'serviceagreement', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3515, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3514, 816, '隐私政策', 'privacypolicy', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3514, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3527, 804, '门ID', 'lock_id', 20, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3527, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3528, 825, '编号', 'lockcard_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3529, 825, '锁ID', 'lock_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3519, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3530, 825, '管理员ID', 'user_id', 15, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3521, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3531, 825, '卡号', 'lockcard_sn', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3522, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3532, 825, '过期时间', 'lockcard_endtime', 7, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3523, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3533, 825, '持有人', 'lockcard_username', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3525, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3534, 825, '备注', 'lockcard_remark', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3526, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3535, 825, '发卡时间', 'lockcard_createtime', 12, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3536, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3536, 825, '钥匙ID', 'lockauth_id', 20, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3520, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3537, 813, '音量', 'volume', 20, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3537, '', NULL, '1', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3538, 813, '语音内容', 'openttscontent', 1, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3538, '', NULL, '门已打开', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3539, 813, '进出发卡模式', 'addcardmode', 20, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3539, '', NULL, '2', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3540, 803, '开门成功外链', 'openadurl', 1, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3567, '', '', 'https://mp.weixin.qq.com/s/UtKqS8FN73aai2PJTeHRig', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3541, 813, '开门广告外链', 'openadurl', 1, NULL, 0, 0, '', 0, 0, NULL, NULL, '', '', '', 3541, '', NULL, 'https://mp.weixin.qq.com/s/UtKqS8FN73aai2PJTeHRig', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3542, 818, '类型', 'type', 3, 1, 0, 0, '锁可用时段|1,钥匙可用时段|2', 1, 1, 'center', '', '', '', '', 3464, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3543, 803, '成功弹层方式', 'adnum', 3, 0, 0, 0, '两图弹层|1,一张图带链接|2', 1, 1, 'center', '', '', '', '', 3486, '', '', '2', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3544, 826, '编号', 'umember_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3545, 826, '用户ID', 'member_id', 20, 1, 0, 0, '', 0, 1, 'center', '', '', '', '', 3550, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3546, 826, '管理员ID', 'user_id', 15, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3549, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3547, 826, '状态', 'status', 3, 1, 0, 0, '正常|1|success,禁用|0|danger', 1, 1, 'center', '', '', '', '', 3548, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3548, 826, '注册时间', 'ucreate_time', 12, 1, 0, 0, '', 0, 1, 'center', '', '', '', '', 3551, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3549, 826, '呢称', 'nickname', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3546, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3550, 826, '头像', 'headimgurl', 8, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3545, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3551, 826, '手机号', 'mobile', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3547, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3552, 827, '编号', 'wservice_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3553, 827, '类型', 'wservice_type', 3, 1, 1, 0, '内部小程序|1,外部小程序|2,网页|3', 1, 1, 'center', '', '', 'notEmpty', '', 3553, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3554, 827, '名称', 'wservice_name', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3554, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3555, 827, 'appid', 'wservice_appid', 1, 1, 1, 1, '', 1, 1, 'center', '小程序或公众号appid,如:wx51f303bf1367a448', '', '', '', 3556, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3556, 827, 'url', 'wservice_url', 1, 1, 1, 0, '', 1, 1, 'center', '小程序页面路径或公众号页面链接,如:pages/index/index', '', '', '', 3557, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3557, 827, '图标', 'wservice_icon', 8, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3555, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3558, 828, '编号', 'wservice_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3559, 828, '类型', 'wservice_type', 3, 1, 1, 0, '内部小程序|1,外部小程序|2,外部页面|3', 1, 0, 'center', '', '', 'notEmpty', '', 3553, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3560, 828, '名称', 'wservice_name', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3554, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3561, 828, '图标', 'wservice_icon', 8, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3555, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3562, 828, 'appid', 'wservice_appid', 1, 1, 1, 1, '', 1, 0, 'center', '小程序或公众号appid,如:wx51f303bf1367a448', '', '', '', 3556, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3563, 828, 'url', 'wservice_url', 1, 1, 1, 0, '', 1, 0, 'center', '小程序页面路径或公众号页面链接,如:pages/index/index', '', '', '', 3557, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3564, 828, '排序', 'wservice_sort', 20, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3564, '', NULL, '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3565, 827, '排序', 'wservice_sort', 20, 1, 0, 0, '', 1, 0, 'center', '排序', '', '', '', 3565, '', '', '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3566, 827, '状态', 'wservice_status', 23, 1, 0, 0, '开启|1,关闭|0', 1, 1, 'center', '开启后在小程序端显示', '', '', '', 3566, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3567, 803, '开门按钮', 'openbtn', 23, 1, 0, 0, '开启|1,关闭|0', 1, 1, 'center', ' 小程序端开门按钮是否启用', '', '', '', 3540, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3568, 824, '发卡状态', 'batchstatus', 3, 1, 1, 0, '待发|1|primary,已发|2|info,读出|0|success', 1, 1, 'center', '修改过期时间后，只有状态设置为待发系统才会将时间更新到设备上去', '', '', '', 3568, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3569, 793, 'unionid', 'unionid', 1, 1, 0, 0, '', 0, 1, 'center', '', '', '', '', 3569, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3570, 803, '开门通知', 'opsucnt', 23, 1, 0, 0, '开启|1,关闭|0', 1, 1, 'center', '需要关注微门禁公众号,在公众号服务菜单点击订阅通知后才有效', '', '', '', 3570, '', '', '0', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3571, 830, '编号', 'doorstatus_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3572, 830, '序列号', 'doorstatus_sn', 1, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3572, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3573, 830, '状态', 'doorstatus_action', 3, 1, 1, 0, '打开|1|success,关闭|0|primary', 1, 1, 'center', '', '', '', '', 3574, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3574, 830, '管理用户', 'user_id', 15, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3575, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3575, 830, '时间', 'doorstatus_time', 12, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3581, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3576, 831, '编号', 'doorstatus_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3577, 831, '序列号', 'doorstatus_sn', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3572, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3578, 831, '状态', 'doorstatus_action', 3, 1, 1, 0, '打开|1|success,关闭|0|primary', 1, 0, 'center', '', '', '', '', 3573, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3579, 831, '管理用户', 'user_id', 15, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3574, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3580, 831, '时间', 'doorstatus_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3575, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3581, 830, '名称', 'lock_name', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3573, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3582, 793, '姓名', 'realname', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3582, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3583, 793, '备注', 'remark', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3583, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3584, 826, '姓名', 'realname', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3584, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3585, 826, '备注', 'remark', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3585, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3586, 812, '姓名', 'realname', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3458, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3587, 832, '编号', 'doorstatus_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3588, 832, '序列号', 'doorstatus_sn', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3572, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3589, 832, '名称', 'lock_name', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3573, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3590, 832, '状态', 'doorstatus_action', 3, 1, 1, 0, '打开|1|success,关闭|0|primary', 1, 0, 'center', '', '', '', '', 3574, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3591, 832, '管理用户', 'user_id', 15, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3575, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3592, 832, '时间', 'doorstatus_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3581, '', '', '', 'int', '11', '');

-- ----------------------------
-- Table structure for cd_file
-- ----------------------------
DROP TABLE IF EXISTS `cd_file`;
CREATE TABLE `cd_file`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片路径',
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件hash值',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 86 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_file
-- ----------------------------

-- ----------------------------
-- Table structure for cd_finger
-- ----------------------------
DROP TABLE IF EXISTS `cd_finger`;
CREATE TABLE `cd_finger`  (
  `finger_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fp_id` int(8) NULL DEFAULT NULL COMMENT '指纹id',
  `finger_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '指纹名称',
  `created_at` bigint(255) NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`finger_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_finger
-- ----------------------------

-- ----------------------------
-- Table structure for cd_group
-- ----------------------------
DROP TABLE IF EXISTS `cd_group`;
CREATE TABLE `cd_group`  (
  `group_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分组名称',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '状态 10正常 0禁用',
  `role` tinyint(4) NULL DEFAULT NULL COMMENT '角色类别 1超级管理员 2普通管理员',
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_group
-- ----------------------------
INSERT INTO `cd_group` VALUES (1, '超级管理员', 10, 1);
INSERT INTO `cd_group` VALUES (3, '客服人员', 10, 2);
INSERT INTO `cd_group` VALUES (7, '用户管理员', 10, 2);
INSERT INTO `cd_group` VALUES (8, '开发管理员', 10, 1);

-- ----------------------------
-- Table structure for cd_health
-- ----------------------------
DROP TABLE IF EXISTS `cd_health`;
CREATE TABLE `cd_health`  (
  `health_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `first_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '居住地址',
  `second_address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '第二居住地址',
  `job` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '工作或学习单位',
  `yiqu` smallint(6) NULL DEFAULT NULL COMMENT '是否来自疫区',
  `register_type` smallint(6) NULL DEFAULT NULL COMMENT '登记类型',
  `health` smallint(6) NULL DEFAULT NULL COMMENT '健康状况',
  `manyou` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '证明图片',
  `ctime` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `position` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '定位地址',
  `lat` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经度',
  `lng` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '纬度',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属用户',
  `openid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'openid',
  `regpoint_id` int(11) NULL DEFAULT NULL COMMENT '登记点ID',
  PRIMARY KEY (`health_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 707 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_health
-- ----------------------------

-- ----------------------------
-- Table structure for cd_lock
-- ----------------------------
DROP TABLE IF EXISTS `cd_lock`;
CREATE TABLE `cd_lock`  (
  `lock_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lock_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '锁名称',
  `lock_sn` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户ID',
  `mobile_check` tinyint(4) NULL DEFAULT NULL COMMENT '需绑手机',
  `applyauth` tinyint(4) NULL DEFAULT NULL COMMENT '领取钥匙',
  `applyauth_check` tinyint(4) NULL DEFAULT NULL COMMENT '审核钥匙',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '启用/禁用',
  `lock_type` smallint(6) NULL DEFAULT NULL COMMENT '类型',
  `location` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '位置',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `lock_qrcode` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '二维码',
  `online` smallint(6) NULL DEFAULT NULL COMMENT '在线状态',
  `member_id` int(11) NULL DEFAULT NULL COMMENT '会员id',
  `successimg` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '成功提示图片',
  `successadimg` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '成功广告',
  `location_check` int(11) NULL DEFAULT NULL COMMENT '开门距离(米)',
  `hitshowminiad` tinyint(1) NULL DEFAULT NULL COMMENT '点击开门广告',
  `qrshowminiad` tinyint(1) NULL DEFAULT NULL COMMENT '扫码开门广告',
  `volume` int(11) NULL DEFAULT NULL COMMENT '音量',
  `openttscontent` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '语音内容',
  `addcardmode` int(11) NULL DEFAULT 2 COMMENT '进出发卡模式',
  `openadurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开门成功外链',
  `adnum` smallint(6) NULL DEFAULT NULL COMMENT '成功弹层方式',
  `openbtn` tinyint(4) NULL DEFAULT 1 COMMENT '开门按钮',
  `opsucnt` tinyint(4) NULL DEFAULT NULL COMMENT '开门通知',
  `device_cid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '设备cid',
  `admin_pwd` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '激活的管理密码',
  `hw_ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sw_ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `wifi_rssi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `on_line_time` int(11) NULL DEFAULT NULL,
  `model_number` varchar(101) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `hardware_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `firmware_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `iccid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `imei` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `batterypower` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`lock_id`) USING BTREE,
  UNIQUE INDEX `lock_id`(`lock_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_lock
-- ----------------------------

-- ----------------------------
-- Table structure for cd_lockauth
-- ----------------------------
DROP TABLE IF EXISTS `cd_lockauth`;
CREATE TABLE `cd_lockauth`  (
  `lockauth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '锁ID',
  `member_id` int(11) NULL DEFAULT NULL COMMENT '会员ID',
  `auth_member_id` int(11) NULL DEFAULT NULL COMMENT '分享人ID',
  `auth_endtime` int(11) NULL DEFAULT NULL COMMENT '有效期结束时间',
  `auth_shareability` tinyint(4) NULL DEFAULT NULL COMMENT '分享权限',
  `aremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `auth_starttime` int(11) NULL DEFAULT NULL COMMENT '有效期起始时间',
  `auth_sharelimit` int(11) NULL DEFAULT NULL COMMENT '可分享钥匙数',
  `auth_openlimit` int(11) NULL DEFAULT NULL COMMENT '可开次数',
  `auth_isadmin` smallint(6) NULL DEFAULT 0 COMMENT '是否管理员',
  `auth_status` smallint(6) NULL DEFAULT NULL COMMENT '审核状态',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `arealname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `auth_opentimes` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '可开时段',
  `auth_tmp` smallint(6) NULL DEFAULT NULL COMMENT '领取标志',
  `auth_openused` int(11) NULL DEFAULT NULL COMMENT '已开次数',
  PRIMARY KEY (`lockauth_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_lockauth
-- ----------------------------

-- ----------------------------
-- Table structure for cd_lockcard
-- ----------------------------
DROP TABLE IF EXISTS `cd_lockcard`;
CREATE TABLE `cd_lockcard`  (
  `lockcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '锁ID',
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `lockcard_sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '卡序列号',
  `lockcard_endtime` int(11) NULL DEFAULT NULL COMMENT '过期时间',
  `lockcard_username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '持有人',
  `lockcard_remark` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `lockcard_createtime` int(11) NULL DEFAULT NULL COMMENT '发卡时间',
  `lockauth_id` int(11) NULL DEFAULT NULL COMMENT '钥匙ID',
  `batchstatus` smallint(6) NULL DEFAULT NULL COMMENT '发卡状态',
  PRIMARY KEY (`lockcard_id`) USING BTREE,
  INDEX `lkcdsn`(`lockcard_sn`) USING BTREE,
  INDEX `lockcard_sn`(`lockcard_sn`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_lockcard
-- ----------------------------

-- ----------------------------
-- Table structure for cd_locklog
-- ----------------------------
DROP TABLE IF EXISTS `cd_locklog`;
CREATE TABLE `cd_locklog`  (
  `locklog_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NULL DEFAULT NULL COMMENT '会员ID',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '锁ID',
  `status` smallint(6) NULL DEFAULT NULL COMMENT '状态',
  `type` smallint(6) NULL DEFAULT NULL COMMENT '类型',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '开门时间',
  `user_id` bigint(10) NULL DEFAULT NULL COMMENT '管理员ID',
  `lremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `cardsn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作人',
  PRIMARY KEY (`locklog_id`) USING BTREE,
  INDEX `cdsn`(`cardsn`) USING BTREE,
  UNIQUE INDEX `idx_locklog_id`(`locklog_id`) USING BTREE,
  INDEX `lock_id`(`lock_id`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_locklog
-- ----------------------------

-- ----------------------------
-- Table structure for cd_locktimes
-- ----------------------------
DROP TABLE IF EXISTS `cd_locktimes`;
CREATE TABLE `cd_locktimes`  (
  `locktimes_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `lock_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '锁ID',
  `startweek` smallint(6) NULL DEFAULT NULL COMMENT '周开始',
  `starthour` smallint(6) NULL DEFAULT NULL COMMENT '小时开始',
  `startminute` smallint(6) NULL DEFAULT NULL COMMENT '分钟开始',
  `endweek` smallint(6) NULL DEFAULT NULL COMMENT '周结束',
  `endhour` smallint(6) NULL DEFAULT NULL COMMENT '小时结束',
  `endminute` smallint(6) NULL DEFAULT NULL COMMENT '分钟结束',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `locktimesname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '时段名称',
  `type` smallint(6) NULL DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`locktimes_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_locktimes
-- ----------------------------

-- ----------------------------
-- Table structure for cd_locktype
-- ----------------------------
DROP TABLE IF EXISTS `cd_locktype`;
CREATE TABLE `cd_locktype`  (
  `locktype_id` int(11) NOT NULL AUTO_INCREMENT,
  `locktype_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`locktype_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_locktype
-- ----------------------------
INSERT INTO `cd_locktype` VALUES (1, 'WiFi版');
INSERT INTO `cd_locktype` VALUES (2, '插卡版(2G)');
INSERT INTO `cd_locktype` VALUES (3, '插卡版(4G)');
INSERT INTO `cd_locktype` VALUES (4, '网线版');
INSERT INTO `cd_locktype` VALUES (5, '插卡版本2G+刷卡');
INSERT INTO `cd_locktype` VALUES (6, '插卡版4G+刷卡');
INSERT INTO `cd_locktype` VALUES (7, '蓝牙锁');

-- ----------------------------
-- Table structure for cd_log
-- ----------------------------
DROP TABLE IF EXISTS `cd_log`;
CREATE TABLE `cd_log`  (
  `log_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL COMMENT '用户ID',
  `username` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `event` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4530 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_log
-- ----------------------------
INSERT INTO `cd_log` VALUES (6, 1, 'admin', '用户登录', '117.188.22.44', 1582019134);
INSERT INTO `cd_log` VALUES (7, 1, 'admin', '用户登录', '111.121.11.208', 1582036027);
INSERT INTO `cd_log` VALUES (8, 1, 'admin', '用户登录', '111.121.11.208', 1582036171);
INSERT INTO `cd_log` VALUES (9, 1, 'admin', '用户登录', '123.118.144.85', 1582036362);
INSERT INTO `cd_log` VALUES (10, 1, 'admin', '用户登录', '111.121.11.208', 1582045385);
INSERT INTO `cd_log` VALUES (11, 1, 'admin', '用户登录', '123.118.144.85', 1582078853);
INSERT INTO `cd_log` VALUES (12, 1, 'admin', '用户登录', '111.121.11.149', 1582087224);
INSERT INTO `cd_log` VALUES (13, 1, 'admin', '用户登录', '111.121.11.149', 1582126513);
INSERT INTO `cd_log` VALUES (14, 1, 'admin', '用户登录', '111.121.11.149', 1582133895);
INSERT INTO `cd_log` VALUES (15, 1, 'admin', '用户登录', '123.118.144.85', 1582169651);
INSERT INTO `cd_log` VALUES (16, 1, 'admin', '用户登录', '123.118.144.85', 1582181561);
INSERT INTO `cd_log` VALUES (17, 1, 'admin', '用户登录', '111.121.11.149', 1582189111);
INSERT INTO `cd_log` VALUES (18, 1, 'admin', '用户登录', '111.121.11.149', 1582196702);
INSERT INTO `cd_log` VALUES (19, 1, 'admin', '用户登录', '111.121.11.149', 1582204038);
INSERT INTO `cd_log` VALUES (20, 1, 'admin', '用户登录', '123.118.144.85', 1582256248);
INSERT INTO `cd_log` VALUES (21, 1, 'admin', '用户登录', '111.121.45.28', 1582256430);
INSERT INTO `cd_log` VALUES (22, 1, 'admin', '用户登录', '111.121.45.28', 1582270070);
INSERT INTO `cd_log` VALUES (23, 1, 'admin', '用户登录', '111.121.45.28', 1582296371);
INSERT INTO `cd_log` VALUES (24, 1, 'admin', '用户登录', '111.121.45.28', 1582300478);
INSERT INTO `cd_log` VALUES (25, 11, 'test01', '用户登录', '111.121.45.28', 1582300553);
INSERT INTO `cd_log` VALUES (26, 1, 'admin', '用户登录', '111.121.45.28', 1582300578);
INSERT INTO `cd_log` VALUES (27, 11, 'test01', '用户登录', '111.121.45.28', 1582300609);
INSERT INTO `cd_log` VALUES (28, 1, 'admin', '用户登录', '111.121.45.28', 1582300665);
INSERT INTO `cd_log` VALUES (29, 11, 'test01', '用户登录', '111.121.45.28', 1582300859);
INSERT INTO `cd_log` VALUES (30, 1, 'admin', '用户登录', '111.121.45.28', 1582300885);
INSERT INTO `cd_log` VALUES (31, 1, 'admin', '用户登录', '111.121.45.28', 1582301100);
INSERT INTO `cd_log` VALUES (32, 1, 'admin', '用户登录', '111.121.45.28', 1582335428);
INSERT INTO `cd_log` VALUES (33, 1, 'admin', '用户登录', '111.121.45.28', 1582340695);
INSERT INTO `cd_log` VALUES (34, 1, 'admin', '用户登录', '111.121.45.28', 1582352963);
INSERT INTO `cd_log` VALUES (35, 1, 'admin', '用户登录', '111.121.45.28', 1582358815);
INSERT INTO `cd_log` VALUES (36, 1, 'admin', '用户登录', '111.121.45.28', 1582382076);
INSERT INTO `cd_log` VALUES (37, 1, 'admin', '用户登录', '111.121.45.28', 1582387886);
INSERT INTO `cd_log` VALUES (38, 1, 'admin', '用户登录', '111.121.45.28', 1582421648);
INSERT INTO `cd_log` VALUES (39, 1, 'admin', '用户登录', '111.121.45.60', 1582428731);
INSERT INTO `cd_log` VALUES (40, 1, 'admin', '用户登录', '111.121.45.60', 1582436583);
INSERT INTO `cd_log` VALUES (41, 19, 'lisi', '用户登录', '111.121.45.60', 1582436685);
INSERT INTO `cd_log` VALUES (42, 1, 'admin', '用户登录', '111.121.45.60', 1582449157);
INSERT INTO `cd_log` VALUES (43, 1, 'admin', '用户登录', '111.121.45.60', 1582466770);
INSERT INTO `cd_log` VALUES (44, 1, 'admin', '用户登录', '111.121.45.60', 1582475799);
INSERT INTO `cd_log` VALUES (45, 26, 'duanxy', '用户登录', '111.121.45.60', 1582478849);
INSERT INTO `cd_log` VALUES (46, 1, 'admin', '用户登录', '111.121.45.60', 1582478982);
INSERT INTO `cd_log` VALUES (47, 26, 'duanxy', '用户登录', '111.121.45.60', 1582481885);
INSERT INTO `cd_log` VALUES (48, 1, 'admin', '用户登录', '111.121.45.60', 1582522552);
INSERT INTO `cd_log` VALUES (49, 1, 'admin', '用户登录', '111.121.45.60', 1582532520);
INSERT INTO `cd_log` VALUES (50, 32, 'jikeshifu', '用户登录', '111.121.45.60', 1582539279);
INSERT INTO `cd_log` VALUES (51, 1, 'admin', '用户登录', '111.121.45.60', 1582540801);
INSERT INTO `cd_log` VALUES (52, 1, 'admin', '用户登录', '111.121.45.60', 1582544902);
INSERT INTO `cd_log` VALUES (53, 1, 'admin', '用户登录', '111.121.45.60', 1582552709);
INSERT INTO `cd_log` VALUES (54, 1, 'admin', '用户登录', '111.121.45.60', 1582559089);
INSERT INTO `cd_log` VALUES (55, 1, 'admin', '用户登录', '111.121.9.43', 1582606727);
INSERT INTO `cd_log` VALUES (56, 1, 'admin', '用户登录', '111.121.9.43', 1582615960);
INSERT INTO `cd_log` VALUES (57, 1, 'admin', '用户登录', '111.121.9.43', 1582625167);
INSERT INTO `cd_log` VALUES (58, 1, 'admin', '用户登录', '111.121.9.43', 1582639170);
INSERT INTO `cd_log` VALUES (59, 1, 'admin', '用户登录', '111.121.9.43', 1582647028);
INSERT INTO `cd_log` VALUES (60, 32, 'jikeshifu', '用户登录', '111.121.9.43', 1582704446);
INSERT INTO `cd_log` VALUES (61, 1, 'admin', '用户登录', '111.121.9.43', 1582705064);
INSERT INTO `cd_log` VALUES (62, 32, 'jikeshifu', '用户登录', '111.121.9.43', 1582705410);
INSERT INTO `cd_log` VALUES (63, 1, 'admin', '用户登录', '111.121.9.43', 1582708372);
INSERT INTO `cd_log` VALUES (64, 1, 'admin', '用户登录', '111.121.9.43', 1582730052);
INSERT INTO `cd_log` VALUES (65, 1, 'admin', '用户登录', '111.121.9.146', 1582779889);
INSERT INTO `cd_log` VALUES (66, 32, 'jikeshifu', '用户登录', '111.121.9.146', 1582780030);
INSERT INTO `cd_log` VALUES (67, 1, 'admin', '用户登录', '111.121.9.146', 1582782271);
INSERT INTO `cd_log` VALUES (68, 1, 'admin', '用户登录', '111.121.9.146', 1582787094);
INSERT INTO `cd_log` VALUES (69, 35, 'XY', '用户登录', '111.121.78.184', 1582787177);
INSERT INTO `cd_log` VALUES (70, 35, 'XY', '用户登录', '111.121.78.184', 1582787775);
INSERT INTO `cd_log` VALUES (71, 1, 'admin', '用户登录', '111.121.9.146', 1582798456);
INSERT INTO `cd_log` VALUES (72, 1, 'admin', '用户登录', '111.121.9.146', 1582814261);
INSERT INTO `cd_log` VALUES (73, 1, 'admin', '用户登录', '111.121.9.146', 1582848256);
INSERT INTO `cd_log` VALUES (74, 1, 'admin', '用户登录', '111.121.9.146', 1582848464);
INSERT INTO `cd_log` VALUES (75, 1, 'admin', '用户登录', '111.121.9.146', 1582849669);
INSERT INTO `cd_log` VALUES (76, 1, 'admin', '用户登录', '111.121.9.146', 1582858007);
INSERT INTO `cd_log` VALUES (77, 35, 'xy', '用户登录', '111.121.74.26', 1582860029);
INSERT INTO `cd_log` VALUES (78, 35, 'xy', '用户登录', '111.121.74.26', 1582868595);
INSERT INTO `cd_log` VALUES (79, 1, 'admin', '用户登录', '58.42.250.116', 1582873508);
INSERT INTO `cd_log` VALUES (80, 32, 'jikeshifu', '用户登录', '58.42.250.116', 1582873601);
INSERT INTO `cd_log` VALUES (81, 1, 'admin', '用户登录', '58.42.250.116', 1582873657);
INSERT INTO `cd_log` VALUES (82, 32, 'jikeshifu', '用户登录', '58.42.250.116', 1582873705);
INSERT INTO `cd_log` VALUES (83, 1, 'admin', '用户登录', '111.121.9.146', 1582891798);
INSERT INTO `cd_log` VALUES (84, 1, 'admin', '用户登录', '111.121.9.146', 1582904078);
INSERT INTO `cd_log` VALUES (85, 1, 'admin', '用户登录', '117.188.19.181', 1582951010);
INSERT INTO `cd_log` VALUES (86, 1, 'admin', '用户登录', '111.121.43.2', 1582994712);
INSERT INTO `cd_log` VALUES (87, 1, 'admin', '用户登录', '111.121.43.2', 1582999998);
INSERT INTO `cd_log` VALUES (88, 1, 'admin', '用户登录', '111.121.43.2', 1583000090);
INSERT INTO `cd_log` VALUES (89, 1, 'admin', '用户登录', '111.121.43.2', 1583058825);
INSERT INTO `cd_log` VALUES (90, 1, 'admin', '用户登录', '47.75.89.236', 1583086204);
INSERT INTO `cd_log` VALUES (91, 1, 'admin', '用户登录', '111.121.11.31', 1583160386);
INSERT INTO `cd_log` VALUES (92, 39, 'jacankzhu', '用户登录', '1.83.234.24', 1583723238);
INSERT INTO `cd_log` VALUES (93, 39, 'jacankzhu', '用户登录', '1.83.234.24', 1583723556);
INSERT INTO `cd_log` VALUES (94, 39, 'jacankzhu', '用户登录', '1.83.234.24', 1583745112);
INSERT INTO `cd_log` VALUES (95, 1, 'admin', '用户登录', '117.188.28.142', 1583985003);
INSERT INTO `cd_log` VALUES (96, 32, 'jikeshifu', '用户登录', '117.188.28.142', 1583985147);
INSERT INTO `cd_log` VALUES (97, 1, 'admin', '用户登录', '111.121.41.208', 1584195373);
INSERT INTO `cd_log` VALUES (98, 1, 'admin', '用户登录', '111.121.41.208', 1584208024);
INSERT INTO `cd_log` VALUES (99, 1, 'admin', '用户登录', '111.121.41.208', 1584209460);
INSERT INTO `cd_log` VALUES (100, 1, 'admin', '用户登录', '111.121.41.208', 1584249279);
INSERT INTO `cd_log` VALUES (101, 1, 'admin', '用户登录', '111.121.41.208', 1584267177);
INSERT INTO `cd_log` VALUES (102, 1, 'admin', '用户登录', '111.121.41.208', 1584275716);
INSERT INTO `cd_log` VALUES (103, 1, 'admin', '用户登录', '111.121.41.208', 1584283684);
INSERT INTO `cd_log` VALUES (104, 1, 'admin', '用户登录', '111.121.41.208', 1584290913);
INSERT INTO `cd_log` VALUES (105, 1, 'admin', '用户登录', '111.121.41.208', 1584294015);
INSERT INTO `cd_log` VALUES (106, 1, 'admin', '用户登录', '111.121.41.208', 1584294053);
INSERT INTO `cd_log` VALUES (107, 32, 'jikeshifu', '用户登录', '117.188.23.110', 1584334725);
INSERT INTO `cd_log` VALUES (108, 1, 'admin', '用户登录', '117.188.23.110', 1584334848);
INSERT INTO `cd_log` VALUES (109, 32, 'jikeshifu', '用户登录', '117.188.23.110', 1584341741);
INSERT INTO `cd_log` VALUES (110, 32, 'jikeshifu', '用户登录', '117.188.23.110', 1584342513);
INSERT INTO `cd_log` VALUES (111, 32, 'jikeshifu', '用户登录', '117.188.23.110', 1584343900);
INSERT INTO `cd_log` VALUES (112, 1, 'admin', '用户登录', '111.121.11.230', 1584371631);
INSERT INTO `cd_log` VALUES (113, 32, 'jikeshifu', '用户登录', '117.188.23.110', 1584530957);
INSERT INTO `cd_log` VALUES (114, 1, 'admin', '用户登录', '117.188.23.110', 1584530972);
INSERT INTO `cd_log` VALUES (115, 1, 'admin', '用户登录', '111.121.8.120', 1584545160);
INSERT INTO `cd_log` VALUES (116, 1, 'admin', '用户登录', '111.121.8.120', 1584587362);
INSERT INTO `cd_log` VALUES (117, 1, 'admin', '用户登录', '117.188.23.110', 1584627032);
INSERT INTO `cd_log` VALUES (118, 1, 'admin', '用户登录', '111.121.8.120', 1584630984);
INSERT INTO `cd_log` VALUES (119, 32, 'jikeshifu', '用户登录', '111.121.8.120', 1584635874);
INSERT INTO `cd_log` VALUES (120, 1, 'admin', '用户登录', '111.121.8.120', 1584635917);
INSERT INTO `cd_log` VALUES (121, 32, 'jikeshifu', '用户登录', '111.121.8.120', 1584636579);
INSERT INTO `cd_log` VALUES (122, 1, 'admin', '用户登录', '111.121.8.120', 1584636769);
INSERT INTO `cd_log` VALUES (123, 32, 'jikeshifu', '用户登录', '111.121.8.120', 1584637564);
INSERT INTO `cd_log` VALUES (124, 1, 'admin', '用户登录', '111.121.8.120', 1584637654);
INSERT INTO `cd_log` VALUES (125, 1, 'admin', '用户登录', '111.121.8.120', 1584637729);
INSERT INTO `cd_log` VALUES (126, 32, 'jikeshifu', '用户登录', '111.121.8.120', 1584637815);
INSERT INTO `cd_log` VALUES (127, 1, 'admin', '用户登录', '117.188.23.110', 1584692583);
INSERT INTO `cd_log` VALUES (128, 32, 'jikeshifu', '用户登录', '117.188.23.110', 1584692699);
INSERT INTO `cd_log` VALUES (129, 1, 'admin', '用户登录', '111.121.11.5', 1584714994);
INSERT INTO `cd_log` VALUES (130, 1, 'admin', '用户登录', '47.75.89.236', 1584757554);
INSERT INTO `cd_log` VALUES (131, 1, 'admin', '用户登录', '111.121.11.5', 1584803879);
INSERT INTO `cd_log` VALUES (132, 41, 'duanxy', '用户登录', '111.121.11.5', 1584810758);
INSERT INTO `cd_log` VALUES (133, 1, 'admin', '用户登录', '111.121.11.5', 1584811235);
INSERT INTO `cd_log` VALUES (134, 1, 'admin', '用户登录', '111.121.11.5', 1584814228);
INSERT INTO `cd_log` VALUES (135, 1, 'admin', '用户登录', '111.121.11.5', 1584841427);
INSERT INTO `cd_log` VALUES (136, 1, 'admin', '用户登录', '111.121.11.5', 1584844583);
INSERT INTO `cd_log` VALUES (137, 1, 'admin', '用户登录', '111.121.11.5', 1584844668);
INSERT INTO `cd_log` VALUES (138, 38, '13698784490', '用户登录', '116.249.142.59', 1584849392);
INSERT INTO `cd_log` VALUES (139, 43, 'lyn', '用户登录', '116.249.142.59', 1584851524);
INSERT INTO `cd_log` VALUES (140, 44, 'Maokes', '用户登录', '117.143.118.253', 1584861881);
INSERT INTO `cd_log` VALUES (141, 1, 'admin', '用户登录', '111.121.10.158', 1584869106);
INSERT INTO `cd_log` VALUES (142, 45, '18058149996', '用户登录', '121.207.214.188', 1584874751);
INSERT INTO `cd_log` VALUES (143, 46, '蓝盾安防', '用户登录', '120.228.184.92', 1584880635);
INSERT INTO `cd_log` VALUES (144, 46, '蓝盾安防', '用户登录', '120.228.184.92', 1584880791);
INSERT INTO `cd_log` VALUES (145, 46, '蓝盾安防', '用户登录', '120.228.184.92', 1584880913);
INSERT INTO `cd_log` VALUES (146, 1, 'admin', '用户登录', '111.121.10.158', 1584888240);
INSERT INTO `cd_log` VALUES (147, 47, 'szhfwy', '用户登录', '113.90.33.171', 1584892032);
INSERT INTO `cd_log` VALUES (148, 1, 'admin', '用户登录', '111.121.10.158', 1584899472);
INSERT INTO `cd_log` VALUES (149, 1, 'admin', '用户登录', '111.121.10.158', 1584933637);
INSERT INTO `cd_log` VALUES (150, 1, 'admin', '用户登录', '111.121.10.158', 1584944361);
INSERT INTO `cd_log` VALUES (151, 1, 'admin', '用户登录', '117.188.13.252', 1584950778);
INSERT INTO `cd_log` VALUES (152, 1, 'admin', '用户登录', '111.121.10.158', 1584981895);
INSERT INTO `cd_log` VALUES (153, 47, 'szhfwy', '用户登录', '113.92.196.41', 1585015776);
INSERT INTO `cd_log` VALUES (154, 1, 'admin', '用户登录', '111.121.10.158', 1585018904);
INSERT INTO `cd_log` VALUES (155, 1, 'admin', '用户登录', '111.121.8.69', 1585030854);
INSERT INTO `cd_log` VALUES (156, 48, '神猫', '用户登录', '101.41.164.247', 1585033425);
INSERT INTO `cd_log` VALUES (157, 47, 'szhfwy', '用户登录', '113.90.32.85', 1585051696);
INSERT INTO `cd_log` VALUES (158, 1, 'admin', '用户登录', '47.75.89.236', 1585113289);
INSERT INTO `cd_log` VALUES (159, 1, 'admin', '用户登录', '117.188.13.252', 1585120515);
INSERT INTO `cd_log` VALUES (160, 1, 'admin', '用户登录', '117.188.13.252', 1585126325);
INSERT INTO `cd_log` VALUES (161, 49, '融道科技', '用户登录', '110.18.96.95', 1585129878);
INSERT INTO `cd_log` VALUES (162, 47, 'szhfwy', '用户登录', '113.90.32.85', 1585150712);
INSERT INTO `cd_log` VALUES (163, 47, 'szhfwy', '用户登录', '113.92.196.170', 1585198578);
INSERT INTO `cd_log` VALUES (164, 1, 'admin', '用户登录', '117.188.13.252', 1585207585);
INSERT INTO `cd_log` VALUES (165, 47, 'szhfwy', '用户登录', '113.92.196.170', 1585211013);
INSERT INTO `cd_log` VALUES (166, 1, 'admin', '用户登录', '111.121.43.8', 1585233622);
INSERT INTO `cd_log` VALUES (167, 1, 'admin', '用户登录', '117.188.13.252', 1585300599);
INSERT INTO `cd_log` VALUES (168, 1, 'admin', '用户登录', '111.121.42.220', 1585372461);
INSERT INTO `cd_log` VALUES (169, 1, 'admin', '用户登录', '111.121.42.220', 1585451861);
INSERT INTO `cd_log` VALUES (170, 1, 'admin', '用户登录', '111.121.42.220', 1585464024);
INSERT INTO `cd_log` VALUES (171, 1, 'admin', '用户登录', '111.121.42.220', 1585496929);
INSERT INTO `cd_log` VALUES (172, 1, 'admin', '用户登录', '117.188.13.252', 1585561736);
INSERT INTO `cd_log` VALUES (173, 1, 'admin', '用户登录', '111.121.41.7', 1585580557);
INSERT INTO `cd_log` VALUES (174, 1, 'admin', '用户登录', '111.121.41.7', 1585586328);
INSERT INTO `cd_log` VALUES (175, 1, 'admin', '用户登录', '111.121.41.7', 1585587818);
INSERT INTO `cd_log` VALUES (176, 1, 'admin', '用户登录', '111.121.41.7', 1585628900);
INSERT INTO `cd_log` VALUES (177, 50, 'lwang', '用户登录', '117.188.19.38', 1585641097);
INSERT INTO `cd_log` VALUES (178, 51, '增小贩无人超市', '用户登录', '117.188.19.38', 1585646459);
INSERT INTO `cd_log` VALUES (179, 1, 'admin', '用户登录', '117.188.19.38', 1585646629);
INSERT INTO `cd_log` VALUES (180, 1, 'admin', '用户登录', '111.121.41.7', 1585665092);
INSERT INTO `cd_log` VALUES (181, 1, 'admin', '用户登录', '111.121.41.76', 1585708125);
INSERT INTO `cd_log` VALUES (182, 1, 'admin', '用户登录', '111.121.41.76', 1585718745);
INSERT INTO `cd_log` VALUES (183, 1, 'admin', '用户登录', '111.121.41.76', 1585724562);
INSERT INTO `cd_log` VALUES (184, 1, 'admin', '用户登录', '117.188.19.38', 1585738913);
INSERT INTO `cd_log` VALUES (185, 1, 'admin', '用户登录', '111.121.41.76', 1585756151);
INSERT INTO `cd_log` VALUES (186, 1, 'admin', '用户登录', '117.188.19.38', 1585817882);
INSERT INTO `cd_log` VALUES (187, 54, 'wang', '用户登录', '112.233.80.155', 1585819379);
INSERT INTO `cd_log` VALUES (188, 54, 'wang', '用户登录', '112.233.80.155', 1585819626);
INSERT INTO `cd_log` VALUES (189, 54, 'wang', '用户登录', '124.130.118.69', 1585819656);
INSERT INTO `cd_log` VALUES (190, 1, 'admin', '用户登录', '111.121.41.76', 1585838930);
INSERT INTO `cd_log` VALUES (191, 1, 'admin', '用户登录', '111.121.41.76', 1585839538);
INSERT INTO `cd_log` VALUES (192, 1, 'admin', '用户登录', '111.121.41.49', 1585852038);
INSERT INTO `cd_log` VALUES (193, 1, 'admin', '用户登录', '117.188.19.38', 1585890748);
INSERT INTO `cd_log` VALUES (194, 1, 'admin', '用户登录', '117.188.19.38', 1585897487);
INSERT INTO `cd_log` VALUES (195, 1, 'admin', '用户登录', '117.188.19.38', 1585897998);
INSERT INTO `cd_log` VALUES (196, 55, '恒盾自动门', '用户登录', '117.136.107.166', 1585915601);
INSERT INTO `cd_log` VALUES (197, 55, '恒盾自动门', '用户登录', '117.136.107.166', 1585915669);
INSERT INTO `cd_log` VALUES (198, 55, '恒盾自动门', '用户登录', '120.216.250.240', 1585953660);
INSERT INTO `cd_log` VALUES (199, 1, 'admin', '用户登录', '111.121.41.49', 1585959910);
INSERT INTO `cd_log` VALUES (200, 56, '丰莱门禁', '用户登录', '171.9.160.210', 1585966637);
INSERT INTO `cd_log` VALUES (201, 56, '丰莱门禁', '用户登录', '171.9.160.210', 1585966873);
INSERT INTO `cd_log` VALUES (202, 56, '丰莱门禁', '用户登录', '171.9.160.210', 1585967047);
INSERT INTO `cd_log` VALUES (203, 56, '丰莱门禁', '用户登录', '171.9.160.210', 1585967121);
INSERT INTO `cd_log` VALUES (204, 56, '丰莱门禁', '用户登录', '171.14.165.30', 1585967627);
INSERT INTO `cd_log` VALUES (205, 1, 'admin', '用户登录', '222.87.75.43', 1586006369);
INSERT INTO `cd_log` VALUES (206, 1, 'admin', '用户登录', '222.87.75.43', 1586011682);
INSERT INTO `cd_log` VALUES (207, 1, 'admin', '用户登录', '222.87.75.43', 1586018941);
INSERT INTO `cd_log` VALUES (208, 1, 'admin', '用户登录', '222.87.75.43', 1586048682);
INSERT INTO `cd_log` VALUES (209, 58, 'lemesan', '用户登录', '220.163.57.9', 1586056749);
INSERT INTO `cd_log` VALUES (210, 1, 'admin', '用户登录', '111.121.41.128', 1586073502);
INSERT INTO `cd_log` VALUES (211, 1, 'admin', '用户登录', '111.121.41.128', 1586083448);
INSERT INTO `cd_log` VALUES (212, 1, 'admin', '用户登录', '111.121.41.128', 1586088708);
INSERT INTO `cd_log` VALUES (213, 1, 'admin', '用户登录', '111.121.41.128', 1586096198);
INSERT INTO `cd_log` VALUES (214, 1, 'admin', '用户登录', '111.121.41.128', 1586114090);
INSERT INTO `cd_log` VALUES (215, 1, 'admin', '用户登录', '111.121.41.128', 1586146975);
INSERT INTO `cd_log` VALUES (216, 1, 'admin', '用户登录', '111.121.41.128', 1586161887);
INSERT INTO `cd_log` VALUES (217, 1, 'admin', '用户登录', '111.121.43.155', 1586193843);
INSERT INTO `cd_log` VALUES (218, 1, 'admin', '用户登录', '111.121.43.155', 1586245414);
INSERT INTO `cd_log` VALUES (219, 1, 'admin', '用户登录', '111.121.43.155', 1586332461);
INSERT INTO `cd_log` VALUES (220, 1, 'admin', '用户登录', '111.121.43.155', 1586336632);
INSERT INTO `cd_log` VALUES (221, 1, 'admin', '用户登录', '111.121.43.155', 1586343666);
INSERT INTO `cd_log` VALUES (222, 1, 'admin', '用户登录', '111.121.43.155', 1586357511);
INSERT INTO `cd_log` VALUES (223, 59, '13299581110', '用户登录', '117.188.30.94', 1586398735);
INSERT INTO `cd_log` VALUES (224, 1, 'admin', '用户登录', '223.104.96.120', 1586400653);
INSERT INTO `cd_log` VALUES (225, 59, '13299581110', '用户登录', '203.93.166.243', 1586401748);
INSERT INTO `cd_log` VALUES (226, 1, 'admin', '用户登录', '111.121.41.32', 1586407562);
INSERT INTO `cd_log` VALUES (227, 59, '13299581110', '用户登录', '14.134.0.195', 1586425283);
INSERT INTO `cd_log` VALUES (228, 1, 'admin', '用户登录', '111.121.41.32', 1586449273);
INSERT INTO `cd_log` VALUES (229, 59, '13299581110', '用户登录', '111.121.41.32', 1586449558);
INSERT INTO `cd_log` VALUES (230, 1, 'admin', '用户登录', '111.121.41.32', 1586449666);
INSERT INTO `cd_log` VALUES (231, 59, '13299581110', '用户登录', '111.121.41.32', 1586449984);
INSERT INTO `cd_log` VALUES (232, 1, 'admin', '用户登录', '111.121.41.32', 1586495562);
INSERT INTO `cd_log` VALUES (233, 1, 'admin', '用户登录', '111.121.41.32', 1586511910);
INSERT INTO `cd_log` VALUES (234, 1, 'admin', '用户登录', '111.121.42.16', 1586563556);
INSERT INTO `cd_log` VALUES (235, 60, 'zxc', '用户登录', '115.214.141.79', 1586576246);
INSERT INTO `cd_log` VALUES (236, 61, 'demo', '用户登录', '111.121.42.16', 1586578785);
INSERT INTO `cd_log` VALUES (237, 1, 'admin', '用户登录', '111.121.42.16', 1586589631);
INSERT INTO `cd_log` VALUES (238, 63, '劉睿兄弟', '用户登录', '39.181.237.228', 1586592763);
INSERT INTO `cd_log` VALUES (239, 60, 'zxc', '用户登录', '183.135.105.135', 1586605589);
INSERT INTO `cd_log` VALUES (240, 60, 'zxc', '用户登录', '183.135.105.135', 1586605674);
INSERT INTO `cd_log` VALUES (241, 1, 'admin', '用户登录', '111.121.42.16', 1586659125);
INSERT INTO `cd_log` VALUES (242, 1, 'admin', '用户登录', '117.188.30.94', 1586674314);
INSERT INTO `cd_log` VALUES (243, 1, 'admin', '用户登录', '111.121.14.117', 1586685656);
INSERT INTO `cd_log` VALUES (244, 66, '13799773988', '用户登录', '211.162.236.69', 1586769773);
INSERT INTO `cd_log` VALUES (245, 66, '13799773988', '用户登录', '211.162.236.69', 1586770163);
INSERT INTO `cd_log` VALUES (246, 1, 'admin', '用户登录', '111.121.14.117', 1586770280);
INSERT INTO `cd_log` VALUES (247, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.79', 1586770372);
INSERT INTO `cd_log` VALUES (248, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.79', 1586770448);
INSERT INTO `cd_log` VALUES (249, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586775352);
INSERT INTO `cd_log` VALUES (250, 32, 'jikeshifu', '用户登录', '111.121.14.117', 1586775827);
INSERT INTO `cd_log` VALUES (251, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586780818);
INSERT INTO `cd_log` VALUES (252, 1, 'admin', '用户登录', '111.121.14.117', 1586834558);
INSERT INTO `cd_log` VALUES (253, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586847450);
INSERT INTO `cd_log` VALUES (254, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586851532);
INSERT INTO `cd_log` VALUES (255, 70, 'czqm', '用户登录', '114.228.210.127', 1586858094);
INSERT INTO `cd_log` VALUES (256, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586858830);
INSERT INTO `cd_log` VALUES (257, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586858901);
INSERT INTO `cd_log` VALUES (258, 71, 'Rory', '用户登录', '110.185.4.107', 1586859494);
INSERT INTO `cd_log` VALUES (259, 67, '巴帝洛克尚东店', '用户登录', '111.121.42.60', 1586860067);
INSERT INTO `cd_log` VALUES (260, 72, '18631448962', '用户登录', '110.254.236.70', 1586860344);
INSERT INTO `cd_log` VALUES (261, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586860575);
INSERT INTO `cd_log` VALUES (262, 73, '13727193790', '用户登录', '113.74.204.41', 1586861900);
INSERT INTO `cd_log` VALUES (263, 63, '劉睿兄弟', '用户登录', '39.181.237.228', 1586862266);
INSERT INTO `cd_log` VALUES (264, 63, '劉睿兄弟', '用户登录', '39.181.237.228', 1586863120);
INSERT INTO `cd_log` VALUES (265, 1, 'admin', '用户登录', '111.121.42.60', 1586864926);
INSERT INTO `cd_log` VALUES (266, 75, 'charongyue', '用户登录', '182.240.90.36', 1586865287);
INSERT INTO `cd_log` VALUES (267, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586865381);
INSERT INTO `cd_log` VALUES (268, 73, '13727193790', '用户登录', '113.74.204.41', 1586866452);
INSERT INTO `cd_log` VALUES (269, 63, '劉睿兄弟', '用户登录', '39.181.238.138', 1586867188);
INSERT INTO `cd_log` VALUES (270, 63, '劉睿兄弟', '用户登录', '39.181.238.138', 1586867329);
INSERT INTO `cd_log` VALUES (271, 1, 'admin', '用户登录', '111.121.42.60', 1586887481);
INSERT INTO `cd_log` VALUES (272, 1, 'admin', '用户登录', '111.121.42.60', 1586918802);
INSERT INTO `cd_log` VALUES (273, 63, '劉睿兄弟', '用户登录', '101.69.63.43', 1586918814);
INSERT INTO `cd_log` VALUES (274, 1, 'admin', '用户登录', '111.121.42.60', 1586923677);
INSERT INTO `cd_log` VALUES (275, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586930923);
INSERT INTO `cd_log` VALUES (276, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586931144);
INSERT INTO `cd_log` VALUES (277, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586932379);
INSERT INTO `cd_log` VALUES (278, 1, 'admin', '用户登录', '117.188.30.94', 1586936079);
INSERT INTO `cd_log` VALUES (279, 80, 'ycaf', '用户登录', '115.214.142.240', 1586940070);
INSERT INTO `cd_log` VALUES (280, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1586941869);
INSERT INTO `cd_log` VALUES (281, 1, 'admin', '用户登录', '111.121.42.60', 1586942999);
INSERT INTO `cd_log` VALUES (282, 63, '劉睿兄弟', '用户登录', '39.184.67.193', 1586953526);
INSERT INTO `cd_log` VALUES (283, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1586958008);
INSERT INTO `cd_log` VALUES (284, 1, 'admin', '用户登录', '111.121.42.60', 1586979370);
INSERT INTO `cd_log` VALUES (285, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1586996967);
INSERT INTO `cd_log` VALUES (286, 1, 'admin', '用户登录', '111.121.42.60', 1587000728);
INSERT INTO `cd_log` VALUES (287, 81, 'bf', '用户登录', '111.121.42.60', 1587004351);
INSERT INTO `cd_log` VALUES (288, 1, 'admin', '用户登录', '111.121.42.60', 1587004456);
INSERT INTO `cd_log` VALUES (289, 83, '01', '用户登录', '42.48.113.242', 1587017290);
INSERT INTO `cd_log` VALUES (290, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.72', 1587017409);
INSERT INTO `cd_log` VALUES (291, 83, '01', '用户登录', '42.48.113.242', 1587017729);
INSERT INTO `cd_log` VALUES (292, 84, 'xinjun', '用户登录', '112.115.237.171', 1587023299);
INSERT INTO `cd_log` VALUES (293, 49, '融道科技', '用户登录', '110.18.99.205', 1587026830);
INSERT INTO `cd_log` VALUES (294, 85, '13985125158', '用户登录', '117.188.30.94', 1587027343);
INSERT INTO `cd_log` VALUES (295, 1, 'admin', '用户登录', '117.188.30.94', 1587030202);
INSERT INTO `cd_log` VALUES (296, 86, 'gameqx', '用户登录', '39.128.42.106', 1587033538);
INSERT INTO `cd_log` VALUES (297, 63, '劉睿兄弟', '用户登录', '124.160.214.240', 1587038647);
INSERT INTO `cd_log` VALUES (298, 63, '劉睿兄弟', '用户登录', '124.160.214.240', 1587039753);
INSERT INTO `cd_log` VALUES (299, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587045105);
INSERT INTO `cd_log` VALUES (300, 1, 'admin', '用户登录', '111.121.40.180', 1587048760);
INSERT INTO `cd_log` VALUES (301, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587075415);
INSERT INTO `cd_log` VALUES (302, 1, 'admin', '用户登录', '111.121.40.180', 1587090856);
INSERT INTO `cd_log` VALUES (303, 64, 'cszsul', '用户登录', '119.142.210.250', 1587105432);
INSERT INTO `cd_log` VALUES (304, 1, 'admin', '用户登录', '117.188.30.94', 1587109209);
INSERT INTO `cd_log` VALUES (305, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.233', 1587111414);
INSERT INTO `cd_log` VALUES (306, 1, 'admin', '用户登录', '117.188.2.13', 1587121628);
INSERT INTO `cd_log` VALUES (307, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587122108);
INSERT INTO `cd_log` VALUES (308, 87, '13906796767', '用户登录', '112.17.245.89', 1587124116);
INSERT INTO `cd_log` VALUES (309, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587130200);
INSERT INTO `cd_log` VALUES (310, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587133424);
INSERT INTO `cd_log` VALUES (311, 1, 'admin', '用户登录', '111.121.40.180', 1587142860);
INSERT INTO `cd_log` VALUES (312, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587167162);
INSERT INTO `cd_log` VALUES (313, 60, 'zxc', '用户登录', '115.214.142.240', 1587174942);
INSERT INTO `cd_log` VALUES (314, 60, 'zxc', '用户登录', '115.214.142.240', 1587175085);
INSERT INTO `cd_log` VALUES (315, 80, 'ycaf', '用户登录', '115.214.142.240', 1587175447);
INSERT INTO `cd_log` VALUES (316, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.233', 1587187836);
INSERT INTO `cd_log` VALUES (317, 63, '劉睿兄弟', '用户登录', '101.70.10.64', 1587195252);
INSERT INTO `cd_log` VALUES (318, 1, 'admin', '用户登录', '114.138.60.179', 1587195410);
INSERT INTO `cd_log` VALUES (319, 51, '增小贩无人超市', '用户登录', '117.188.2.13', 1587195556);
INSERT INTO `cd_log` VALUES (320, 90, 'sntozjc', '用户登录', '117.136.24.174', 1587196995);
INSERT INTO `cd_log` VALUES (321, 90, 'sntozjc', '用户登录', '42.48.113.242', 1587197296);
INSERT INTO `cd_log` VALUES (322, 83, '01', '用户登录', '117.136.24.160', 1587197725);
INSERT INTO `cd_log` VALUES (323, 83, '01', '用户登录', '42.48.113.242', 1587197736);
INSERT INTO `cd_log` VALUES (324, 50, 'lwang', '用户登录', '117.188.2.13', 1587204357);
INSERT INTO `cd_log` VALUES (325, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587208940);
INSERT INTO `cd_log` VALUES (326, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587211811);
INSERT INTO `cd_log` VALUES (327, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587214296);
INSERT INTO `cd_log` VALUES (328, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587253507);
INSERT INTO `cd_log` VALUES (329, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587255990);
INSERT INTO `cd_log` VALUES (330, 63, '劉睿兄弟', '用户登录', '124.160.213.229', 1587259398);
INSERT INTO `cd_log` VALUES (331, 51, '增小贩无人超市', '用户登录', '111.85.55.195', 1587271609);
INSERT INTO `cd_log` VALUES (332, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587274509);
INSERT INTO `cd_log` VALUES (333, 91, '13410458590', '用户登录', '223.104.66.116', 1587281076);
INSERT INTO `cd_log` VALUES (334, 91, '13410458590', '用户登录', '163.125.145.149', 1587281313);
INSERT INTO `cd_log` VALUES (335, 48, '神猫', '用户登录', '14.131.18.53', 1587282908);
INSERT INTO `cd_log` VALUES (336, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.233', 1587284761);
INSERT INTO `cd_log` VALUES (337, 1, 'admin', '用户登录', '111.121.10.181', 1587293825);
INSERT INTO `cd_log` VALUES (338, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587301127);
INSERT INTO `cd_log` VALUES (339, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587336380);
INSERT INTO `cd_log` VALUES (340, 63, '劉睿兄弟', '用户登录', '101.70.10.64', 1587347023);
INSERT INTO `cd_log` VALUES (341, 1, 'admin', '用户登录', '111.121.46.183', 1587366770);
INSERT INTO `cd_log` VALUES (342, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.39', 1587368930);
INSERT INTO `cd_log` VALUES (343, 1, 'admin', '用户登录', '111.121.46.183', 1587376703);
INSERT INTO `cd_log` VALUES (344, 1, 'admin', '用户登录', '111.121.46.183', 1587379497);
INSERT INTO `cd_log` VALUES (345, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587383472);
INSERT INTO `cd_log` VALUES (346, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587385557);
INSERT INTO `cd_log` VALUES (347, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587392375);
INSERT INTO `cd_log` VALUES (348, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587423695);
INSERT INTO `cd_log` VALUES (349, 50, 'lwang', '用户登录', '117.188.21.103', 1587434469);
INSERT INTO `cd_log` VALUES (350, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.39', 1587454617);
INSERT INTO `cd_log` VALUES (351, 1, 'admin', '用户登录', '117.188.21.103', 1587454718);
INSERT INTO `cd_log` VALUES (352, 50, 'lwang', '用户登录', '123.172.181.232', 1587455670);
INSERT INTO `cd_log` VALUES (353, 50, 'lwang', '用户登录', '123.172.181.232', 1587457925);
INSERT INTO `cd_log` VALUES (354, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.39', 1587463587);
INSERT INTO `cd_log` VALUES (355, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587478399);
INSERT INTO `cd_log` VALUES (356, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587515761);
INSERT INTO `cd_log` VALUES (357, 67, '巴帝洛克尚东店', '用户登录', '39.179.26.39', 1587533569);
INSERT INTO `cd_log` VALUES (358, 50, 'lwang', '用户登录', '123.172.181.232', 1587538755);
INSERT INTO `cd_log` VALUES (359, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587556048);
INSERT INTO `cd_log` VALUES (360, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587565300);
INSERT INTO `cd_log` VALUES (361, 1, 'admin', '用户登录', '111.121.10.79', 1587570729);
INSERT INTO `cd_log` VALUES (362, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587595461);
INSERT INTO `cd_log` VALUES (363, 50, 'lwang', '用户登录', '117.188.21.103', 1587614824);
INSERT INTO `cd_log` VALUES (364, 1, 'admin', '用户登录', '111.121.10.79', 1587627287);
INSERT INTO `cd_log` VALUES (365, 94, '82218221', '用户登录', '117.188.21.103', 1587627353);
INSERT INTO `cd_log` VALUES (366, 50, 'lwang', '用户登录', '117.188.21.103', 1587627453);
INSERT INTO `cd_log` VALUES (367, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.87', 1587629496);
INSERT INTO `cd_log` VALUES (368, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.87', 1587637176);
INSERT INTO `cd_log` VALUES (369, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587640863);
INSERT INTO `cd_log` VALUES (370, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587642155);
INSERT INTO `cd_log` VALUES (371, 1, 'admin', '用户登录', '111.121.10.79', 1587642183);
INSERT INTO `cd_log` VALUES (372, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587649179);
INSERT INTO `cd_log` VALUES (373, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587657046);
INSERT INTO `cd_log` VALUES (374, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587690679);
INSERT INTO `cd_log` VALUES (375, 50, 'lwang', '用户登录', '117.188.21.103', 1587701892);
INSERT INTO `cd_log` VALUES (376, 1, 'admin', '用户登录', '117.188.21.103', 1587703030);
INSERT INTO `cd_log` VALUES (377, 96, 'ytk', '用户登录', '222.186.101.241', 1587703226);
INSERT INTO `cd_log` VALUES (378, 96, 'ytk', '用户登录', '222.186.101.241', 1587703365);
INSERT INTO `cd_log` VALUES (379, 96, 'ytk', '用户登录', '222.186.101.241', 1587704329);
INSERT INTO `cd_log` VALUES (380, 50, 'lwang', '用户登录', '117.188.10.55', 1587705310);
INSERT INTO `cd_log` VALUES (381, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.87', 1587708983);
INSERT INTO `cd_log` VALUES (382, 96, 'ytk', '用户登录', '222.186.101.241', 1587714807);
INSERT INTO `cd_log` VALUES (383, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.87', 1587729781);
INSERT INTO `cd_log` VALUES (384, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587735099);
INSERT INTO `cd_log` VALUES (385, 50, 'lwang', '用户登录', '123.172.181.232', 1587735693);
INSERT INTO `cd_log` VALUES (386, 50, 'lwang', '用户登录', '123.172.181.232', 1587735759);
INSERT INTO `cd_log` VALUES (387, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587737294);
INSERT INTO `cd_log` VALUES (388, 1, 'admin', '用户登录', '111.121.11.83', 1587740100);
INSERT INTO `cd_log` VALUES (389, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.87', 1587793427);
INSERT INTO `cd_log` VALUES (390, 1, 'admin', '用户登录', '111.121.11.83', 1587801337);
INSERT INTO `cd_log` VALUES (391, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587816242);
INSERT INTO `cd_log` VALUES (392, 63, '劉睿兄弟', '用户登录', '124.160.216.226', 1587820104);
INSERT INTO `cd_log` VALUES (393, 50, 'lwang', '用户登录', '123.172.181.232', 1587825502);
INSERT INTO `cd_log` VALUES (394, 63, '劉睿兄弟', '用户登录', '124.160.216.115', 1587859456);
INSERT INTO `cd_log` VALUES (395, 1, 'admin', '用户登录', '117.188.21.103', 1587870535);
INSERT INTO `cd_log` VALUES (396, 93, 'fzx', '用户登录', '123.172.181.232', 1587875133);
INSERT INTO `cd_log` VALUES (397, 93, 'fzx', '用户登录', '123.172.181.232', 1587875736);
INSERT INTO `cd_log` VALUES (398, 93, 'fzx', '用户登录', '123.172.181.232', 1587875851);
INSERT INTO `cd_log` VALUES (399, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.198', 1587879419);
INSERT INTO `cd_log` VALUES (400, 63, '劉睿兄弟', '用户登录', '124.160.216.115', 1587899908);
INSERT INTO `cd_log` VALUES (401, 1, 'admin', '用户登录', '117.188.21.103', 1587902283);
INSERT INTO `cd_log` VALUES (402, 63, '劉睿兄弟', '用户登录', '39.181.255.201', 1587905749);
INSERT INTO `cd_log` VALUES (403, 1, 'admin', '用户登录', '111.121.14.242', 1587911378);
INSERT INTO `cd_log` VALUES (404, 63, '劉睿兄弟', '用户登录', '124.160.216.115', 1587941093);
INSERT INTO `cd_log` VALUES (405, 63, '劉睿兄弟', '用户登录', '123.153.83.86', 1587947626);
INSERT INTO `cd_log` VALUES (406, 48, '神猫', '用户登录', '14.131.18.53', 1587953409);
INSERT INTO `cd_log` VALUES (407, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.198', 1587967193);
INSERT INTO `cd_log` VALUES (408, 50, 'lwang', '用户登录', '117.188.21.103', 1587969258);
INSERT INTO `cd_log` VALUES (409, 96, 'ytk', '用户登录', '222.186.101.241', 1587974951);
INSERT INTO `cd_log` VALUES (410, 96, 'ytk', '用户登录', '222.186.101.241', 1587978644);
INSERT INTO `cd_log` VALUES (411, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.198', 1587984482);
INSERT INTO `cd_log` VALUES (412, 63, '劉睿兄弟', '用户登录', '124.160.216.115', 1587989466);
INSERT INTO `cd_log` VALUES (413, 1, 'admin', '用户登录', '111.121.14.242', 1587997987);
INSERT INTO `cd_log` VALUES (414, 98, 'Kenneth', '用户登录', '182.86.163.218', 1588038421);
INSERT INTO `cd_log` VALUES (415, 99, 'zybc', '用户登录', '113.111.46.86', 1588050477);
INSERT INTO `cd_log` VALUES (416, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.198', 1588052958);
INSERT INTO `cd_log` VALUES (417, 99, 'zybc', '用户登录', '113.111.46.86', 1588053293);
INSERT INTO `cd_log` VALUES (418, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.216', 1588069790);
INSERT INTO `cd_log` VALUES (419, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.216', 1588073081);
INSERT INTO `cd_log` VALUES (420, 1, 'admin', '用户登录', '111.121.9.15', 1588087370);
INSERT INTO `cd_log` VALUES (421, 63, '劉睿兄弟', '用户登录', '124.160.216.41', 1588088157);
INSERT INTO `cd_log` VALUES (422, 50, 'lwang', '用户登录', '117.188.21.103', 1588127857);
INSERT INTO `cd_log` VALUES (423, 1, 'admin', '用户登录', '111.121.9.15', 1588136801);
INSERT INTO `cd_log` VALUES (424, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.216', 1588139509);
INSERT INTO `cd_log` VALUES (425, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.216', 1588143328);
INSERT INTO `cd_log` VALUES (426, 63, '劉睿兄弟', '用户登录', '124.160.216.41', 1588147855);
INSERT INTO `cd_log` VALUES (427, 63, '劉睿兄弟', '用户登录', '124.160.216.41', 1588155631);
INSERT INTO `cd_log` VALUES (428, 1, 'admin', '用户登录', '111.121.9.15', 1588213207);
INSERT INTO `cd_log` VALUES (429, 101, 'cxserv', '用户登录', '119.165.183.77', 1588217103);
INSERT INTO `cd_log` VALUES (430, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.216', 1588224994);
INSERT INTO `cd_log` VALUES (431, 1, 'admin', '用户登录', '117.188.8.192', 1588231023);
INSERT INTO `cd_log` VALUES (432, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.216', 1588243112);
INSERT INTO `cd_log` VALUES (433, 1, 'admin', '用户登录', '111.121.44.152', 1588254246);
INSERT INTO `cd_log` VALUES (434, 1, 'admin', '用户登录', '111.121.44.152', 1588269918);
INSERT INTO `cd_log` VALUES (435, 1, 'admin', '用户登录', '111.121.44.152', 1588322629);
INSERT INTO `cd_log` VALUES (436, 41, 'duanxy', '用户登录', '117.188.8.192', 1588396317);
INSERT INTO `cd_log` VALUES (437, 1, 'admin', '用户登录', '117.188.8.192', 1588396347);
INSERT INTO `cd_log` VALUES (438, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.128', 1588396939);
INSERT INTO `cd_log` VALUES (439, 1, 'admin', '用户登录', '111.121.13.105', 1588409808);
INSERT INTO `cd_log` VALUES (440, 63, '劉睿兄弟', '用户登录', '124.160.219.117', 1588423681);
INSERT INTO `cd_log` VALUES (441, 96, 'ytk', '用户登录', '222.186.101.241', 1588485080);
INSERT INTO `cd_log` VALUES (442, 102, '13145201141', '用户登录', '182.148.88.208', 1588494763);
INSERT INTO `cd_log` VALUES (443, 102, '13145201141', '用户登录', '182.148.88.208', 1588495020);
INSERT INTO `cd_log` VALUES (444, 1, 'admin', '用户登录', '111.121.13.105', 1588514372);
INSERT INTO `cd_log` VALUES (445, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.128', 1588572198);
INSERT INTO `cd_log` VALUES (446, 1, 'admin', '用户登录', '111.121.45.36', 1588604401);
INSERT INTO `cd_log` VALUES (447, 96, 'Ytk', '用户登录', '218.3.39.237', 1588645047);
INSERT INTO `cd_log` VALUES (448, 96, 'ytk', '用户登录', '218.3.39.237', 1588645163);
INSERT INTO `cd_log` VALUES (449, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588655900);
INSERT INTO `cd_log` VALUES (450, 104, 'rhcs8888', '用户登录', '36.23.62.64', 1588664689);
INSERT INTO `cd_log` VALUES (451, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588667150);
INSERT INTO `cd_log` VALUES (452, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588667210);
INSERT INTO `cd_log` VALUES (453, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1588721989);
INSERT INTO `cd_log` VALUES (454, 63, '劉睿兄弟', '用户登录', '124.160.214.227', 1588723038);
INSERT INTO `cd_log` VALUES (455, 104, 'rhcs8888', '用户登录', '117.188.8.192', 1588727698);
INSERT INTO `cd_log` VALUES (456, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1588728952);
INSERT INTO `cd_log` VALUES (457, 50, 'lwang', '用户登录', '117.188.8.192', 1588729845);
INSERT INTO `cd_log` VALUES (458, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1588730007);
INSERT INTO `cd_log` VALUES (459, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1588730119);
INSERT INTO `cd_log` VALUES (460, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1588731359);
INSERT INTO `cd_log` VALUES (461, 102, '13145201141', '用户登录', '182.148.88.28', 1588734045);
INSERT INTO `cd_log` VALUES (462, 104, 'rhcs8888', '用户登录', '223.104.246.145', 1588734112);
INSERT INTO `cd_log` VALUES (463, 102, '13145201141', '用户登录', '101.206.166.99', 1588734816);
INSERT INTO `cd_log` VALUES (464, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588742660);
INSERT INTO `cd_log` VALUES (465, 41, 'duanxy', '用户登录', '117.188.8.192', 1588753439);
INSERT INTO `cd_log` VALUES (466, 1, 'admin', '用户登录', '117.188.8.192', 1588753475);
INSERT INTO `cd_log` VALUES (467, 104, 'rhcs8888', '用户登录', '183.142.213.169', 1588755027);
INSERT INTO `cd_log` VALUES (468, 1, 'admin', '用户登录', '111.121.11.3', 1588769339);
INSERT INTO `cd_log` VALUES (469, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588829091);
INSERT INTO `cd_log` VALUES (470, 50, 'lwang', '用户登录', '117.188.8.192', 1588831718);
INSERT INTO `cd_log` VALUES (471, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588839570);
INSERT INTO `cd_log` VALUES (472, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588840748);
INSERT INTO `cd_log` VALUES (473, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588841500);
INSERT INTO `cd_log` VALUES (474, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588845388);
INSERT INTO `cd_log` VALUES (475, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1588845880);
INSERT INTO `cd_log` VALUES (476, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1588852642);
INSERT INTO `cd_log` VALUES (477, 1, 'admin', '用户登录', '111.121.11.3', 1588866929);
INSERT INTO `cd_log` VALUES (478, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588906635);
INSERT INTO `cd_log` VALUES (479, 1, 'admin', '用户登录', '111.121.11.3', 1588909870);
INSERT INTO `cd_log` VALUES (480, 96, 'ytk', '用户登录', '222.186.101.241', 1588915423);
INSERT INTO `cd_log` VALUES (481, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1588917373);
INSERT INTO `cd_log` VALUES (482, 50, 'lwang', '用户登录', '117.188.8.192', 1588917722);
INSERT INTO `cd_log` VALUES (483, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588926533);
INSERT INTO `cd_log` VALUES (484, 41, 'duanxy', '用户登录', '117.188.8.192', 1588929383);
INSERT INTO `cd_log` VALUES (485, 1, 'admin', '用户登录', '117.188.8.192', 1588929448);
INSERT INTO `cd_log` VALUES (486, 107, '123456s', '用户登录', '117.68.154.82', 1588929468);
INSERT INTO `cd_log` VALUES (487, 107, '123456s', '用户登录', '117.68.154.82', 1588938460);
INSERT INTO `cd_log` VALUES (488, 108, 'cl', '用户登录', '117.68.154.82', 1588939075);
INSERT INTO `cd_log` VALUES (489, 109, '中能物业', '用户登录', '112.11.154.77', 1588939842);
INSERT INTO `cd_log` VALUES (490, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588990721);
INSERT INTO `cd_log` VALUES (491, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1588994579);
INSERT INTO `cd_log` VALUES (492, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1589002012);
INSERT INTO `cd_log` VALUES (493, 1, 'admin', '用户登录', '111.121.8.54', 1589033109);
INSERT INTO `cd_log` VALUES (494, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1589088636);
INSERT INTO `cd_log` VALUES (495, 1, 'admin', '用户登录', '111.121.46.192', 1589092578);
INSERT INTO `cd_log` VALUES (496, 102, '13145201141', '用户登录', '182.148.90.25', 1589115508);
INSERT INTO `cd_log` VALUES (497, 102, '13145201141', '用户登录', '101.206.168.221', 1589116037);
INSERT INTO `cd_log` VALUES (498, 102, '13145201141', '用户登录', '125.69.6.128', 1589118682);
INSERT INTO `cd_log` VALUES (499, 1, 'admin', '用户登录', '111.121.46.192', 1589121068);
INSERT INTO `cd_log` VALUES (500, 107, '123456s', '用户登录', '114.107.20.10', 1589167921);
INSERT INTO `cd_log` VALUES (501, 108, 'cl', '用户登录', '114.107.20.10', 1589168345);
INSERT INTO `cd_log` VALUES (502, 1, 'admin', '用户登录', '111.121.46.192', 1589173692);
INSERT INTO `cd_log` VALUES (503, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589176158);
INSERT INTO `cd_log` VALUES (504, 102, '13145201141', '用户登录', '220.166.237.195', 1589181540);
INSERT INTO `cd_log` VALUES (505, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589192588);
INSERT INTO `cd_log` VALUES (506, 102, '13145201141', '用户登录', '182.148.89.167', 1589204152);
INSERT INTO `cd_log` VALUES (507, 96, 'ytk', '用户登录', '218.3.39.237', 1589246474);
INSERT INTO `cd_log` VALUES (508, 96, 'ytk', '用户登录', '218.3.39.237', 1589248013);
INSERT INTO `cd_log` VALUES (509, 96, 'ytk', '用户登录', '117.136.67.240', 1589248155);
INSERT INTO `cd_log` VALUES (510, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589264506);
INSERT INTO `cd_log` VALUES (511, 102, '13145201141', '用户登录', '101.206.167.123', 1589264790);
INSERT INTO `cd_log` VALUES (512, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589278356);
INSERT INTO `cd_log` VALUES (513, 1, 'admin', '用户登录', '111.121.10.59', 1589296876);
INSERT INTO `cd_log` VALUES (514, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1589330133);
INSERT INTO `cd_log` VALUES (515, 111, '网吧管理员', '用户登录', '110.180.19.117', 1589336255);
INSERT INTO `cd_log` VALUES (516, 111, '网吧管理员', '用户登录', '110.180.19.117', 1589336429);
INSERT INTO `cd_log` VALUES (517, 1, 'admin', '用户登录', '111.121.10.59', 1589336839);
INSERT INTO `cd_log` VALUES (518, 111, '网吧管理员', '用户登录', '110.180.19.117', 1589337210);
INSERT INTO `cd_log` VALUES (519, 88, '15518738585', '用户登录', '111.121.10.59', 1589337376);
INSERT INTO `cd_log` VALUES (520, 111, '网吧管理员', '用户登录', '124.166.240.141', 1589338074);
INSERT INTO `cd_log` VALUES (521, 111, '网吧管理员', '用户登录', '124.166.240.141', 1589339844);
INSERT INTO `cd_log` VALUES (522, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589351374);
INSERT INTO `cd_log` VALUES (523, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589351759);
INSERT INTO `cd_log` VALUES (524, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.220', 1589351947);
INSERT INTO `cd_log` VALUES (525, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.142', 1589354749);
INSERT INTO `cd_log` VALUES (526, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.142', 1589357482);
INSERT INTO `cd_log` VALUES (527, 63, '劉睿兄弟', '用户登录', '124.160.219.211', 1589370797);
INSERT INTO `cd_log` VALUES (528, 111, '网吧管理员', '用户登录', '124.166.240.141', 1589374990);
INSERT INTO `cd_log` VALUES (529, 96, 'ytk', '用户登录', '222.186.101.241', 1589413989);
INSERT INTO `cd_log` VALUES (530, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.191', 1589429307);
INSERT INTO `cd_log` VALUES (531, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.142', 1589433726);
INSERT INTO `cd_log` VALUES (532, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.191', 1589441118);
INSERT INTO `cd_log` VALUES (533, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.142', 1589508290);
INSERT INTO `cd_log` VALUES (534, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.191', 1589519964);
INSERT INTO `cd_log` VALUES (535, 1, 'admin', '用户登录', '117.188.7.83', 1589524039);
INSERT INTO `cd_log` VALUES (536, 111, '网吧管理员', '用户登录', '110.180.19.117', 1589525515);
INSERT INTO `cd_log` VALUES (537, 1, 'admin', '用户登录', '111.121.41.53', 1589593922);
INSERT INTO `cd_log` VALUES (538, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.34', 1589594093);
INSERT INTO `cd_log` VALUES (539, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.191', 1589606538);
INSERT INTO `cd_log` VALUES (540, 1, 'admin', '用户登录', '117.188.7.83', 1589619604);
INSERT INTO `cd_log` VALUES (541, 104, 'rhcs8888', '用户登录', '124.160.214.162', 1589623844);
INSERT INTO `cd_log` VALUES (542, 113, 'yrq', '用户登录', '223.11.194.218', 1589640731);
INSERT INTO `cd_log` VALUES (543, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.34', 1589681006);
INSERT INTO `cd_log` VALUES (544, 63, '劉睿兄弟', '用户登录', '123.153.82.62', 1589681383);
INSERT INTO `cd_log` VALUES (545, 1, 'admin', '用户登录', '111.121.46.250', 1589689593);
INSERT INTO `cd_log` VALUES (546, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.226', 1589693114);
INSERT INTO `cd_log` VALUES (547, 104, 'rhcs8888', '用户登录', '101.69.69.7', 1589717132);
INSERT INTO `cd_log` VALUES (548, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.34', 1589767983);
INSERT INTO `cd_log` VALUES (549, 114, 'snto', '用户登录', '117.136.24.70', 1589772388);
INSERT INTO `cd_log` VALUES (550, 114, 'snto', '用户登录', '117.136.24.70', 1589772525);
INSERT INTO `cd_log` VALUES (551, 114, 'snto', '用户登录', '117.136.24.70', 1589772569);
INSERT INTO `cd_log` VALUES (552, 114, 'snto', '用户登录', '117.136.24.79', 1589772652);
INSERT INTO `cd_log` VALUES (553, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1589772747);
INSERT INTO `cd_log` VALUES (554, 104, 'rhcs8888', '用户登录', '120.199.130.138', 1589772972);
INSERT INTO `cd_log` VALUES (555, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.226', 1589782434);
INSERT INTO `cd_log` VALUES (556, 114, 'snto', '用户登录', '42.48.113.242', 1589784825);
INSERT INTO `cd_log` VALUES (557, 115, 'dafei110', '用户登录', '223.89.20.44', 1589785073);
INSERT INTO `cd_log` VALUES (558, 1, 'admin', '用户登录', '111.121.42.228', 1589786681);
INSERT INTO `cd_log` VALUES (559, 83, '01', '用户登录', '111.121.42.228', 1589786969);
INSERT INTO `cd_log` VALUES (560, 83, '01', '用户登录', '42.48.113.242', 1589788453);
INSERT INTO `cd_log` VALUES (561, 83, '01', '用户登录', '42.48.113.242', 1589788947);
INSERT INTO `cd_log` VALUES (562, 1, 'admin', '用户登录', '117.188.10.148', 1589790183);
INSERT INTO `cd_log` VALUES (563, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.34', 1589791007);
INSERT INTO `cd_log` VALUES (564, 83, '01', '用户登录', '42.48.113.242', 1589791161);
INSERT INTO `cd_log` VALUES (565, 83, '01', '用户登录', '117.136.24.79', 1589792285);
INSERT INTO `cd_log` VALUES (566, 83, '01', '用户登录', '42.48.113.242', 1589793440);
INSERT INTO `cd_log` VALUES (567, 83, '01', '用户登录', '42.48.113.242', 1589793584);
INSERT INTO `cd_log` VALUES (568, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.226', 1589795267);
INSERT INTO `cd_log` VALUES (569, 83, '01', '用户登录', '42.48.113.242', 1589795822);
INSERT INTO `cd_log` VALUES (570, 116, 'dmg', '用户登录', '223.21.241.47', 1589811845);
INSERT INTO `cd_log` VALUES (571, 116, 'dmg', '用户登录', '223.21.241.47', 1589812436);
INSERT INTO `cd_log` VALUES (572, 116, 'dmg', '用户登录', '223.21.241.47', 1589816779);
INSERT INTO `cd_log` VALUES (573, 83, '01', '用户登录', '42.48.113.242', 1589848799);
INSERT INTO `cd_log` VALUES (574, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.226', 1589861549);
INSERT INTO `cd_log` VALUES (575, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.150', 1589865739);
INSERT INTO `cd_log` VALUES (576, 83, '01', '用户登录', '42.48.113.242', 1589869489);
INSERT INTO `cd_log` VALUES (577, 1, 'admin', '用户登录', '111.121.42.228', 1589901187);
INSERT INTO `cd_log` VALUES (578, 1, 'admin', '用户登录', '111.121.42.228', 1589908634);
INSERT INTO `cd_log` VALUES (579, 83, '01', '用户登录', '42.48.113.242', 1589946512);
INSERT INTO `cd_log` VALUES (580, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.7', 1589952668);
INSERT INTO `cd_log` VALUES (581, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.150', 1589957545);
INSERT INTO `cd_log` VALUES (582, 83, '01', '用户登录', '42.48.113.242', 1590021937);
INSERT INTO `cd_log` VALUES (583, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.150', 1590030256);
INSERT INTO `cd_log` VALUES (584, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.7', 1590038756);
INSERT INTO `cd_log` VALUES (585, 1, 'admin', '用户登录', '111.121.13.175', 1590045999);
INSERT INTO `cd_log` VALUES (586, 118, '18600590406', '用户登录', '115.171.199.198', 1590046139);
INSERT INTO `cd_log` VALUES (587, 118, '18600590406', '用户登录', '115.171.199.198', 1590047601);
INSERT INTO `cd_log` VALUES (588, 118, '18600590406', '用户登录', '115.171.199.198', 1590047755);
INSERT INTO `cd_log` VALUES (589, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.7', 1590050379);
INSERT INTO `cd_log` VALUES (590, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.7', 1590059709);
INSERT INTO `cd_log` VALUES (591, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.7', 1590063742);
INSERT INTO `cd_log` VALUES (592, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.244', 1590070905);
INSERT INTO `cd_log` VALUES (593, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.7', 1590124982);
INSERT INTO `cd_log` VALUES (594, 1, 'admin', '用户登录', '117.188.10.148', 1590125294);
INSERT INTO `cd_log` VALUES (595, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.244', 1590126215);
INSERT INTO `cd_log` VALUES (596, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.244', 1590139915);
INSERT INTO `cd_log` VALUES (597, 83, '01', '用户登录', '42.48.113.242', 1590145945);
INSERT INTO `cd_log` VALUES (598, 1, 'admin', '用户登录', '111.121.44.142', 1590160125);
INSERT INTO `cd_log` VALUES (599, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1590191441);
INSERT INTO `cd_log` VALUES (600, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.244', 1590209959);
INSERT INTO `cd_log` VALUES (601, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.31', 1590217676);
INSERT INTO `cd_log` VALUES (602, 120, 'tianwen', '用户登录', '60.6.217.200', 1590223207);
INSERT INTO `cd_log` VALUES (603, 50, 'lwang', '用户登录', '117.188.10.148', 1590223872);
INSERT INTO `cd_log` VALUES (604, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.31', 1590283240);
INSERT INTO `cd_log` VALUES (605, 1, 'admin', '用户登录', '111.121.44.142', 1590283895);
INSERT INTO `cd_log` VALUES (606, 121, 'yanglingyun001', '用户登录', '39.64.100.184', 1590290114);
INSERT INTO `cd_log` VALUES (607, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.244', 1590305116);
INSERT INTO `cd_log` VALUES (608, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.31', 1590317170);
INSERT INTO `cd_log` VALUES (609, 83, '01', '用户登录', '42.48.113.242', 1590321304);
INSERT INTO `cd_log` VALUES (610, 83, '01', '用户登录', '42.48.113.242', 1590366929);
INSERT INTO `cd_log` VALUES (611, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.50', 1590376418);
INSERT INTO `cd_log` VALUES (612, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1590392282);
INSERT INTO `cd_log` VALUES (613, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1590392299);
INSERT INTO `cd_log` VALUES (614, 121, 'yanglingyun001', '用户登录', '39.91.109.15', 1590453208);
INSERT INTO `cd_log` VALUES (615, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.50', 1590462647);
INSERT INTO `cd_log` VALUES (616, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.202', 1590471032);
INSERT INTO `cd_log` VALUES (617, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590480677);
INSERT INTO `cd_log` VALUES (618, 96, 'ytk', '用户登录', '222.186.101.241', 1590482731);
INSERT INTO `cd_log` VALUES (619, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590483257);
INSERT INTO `cd_log` VALUES (620, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590494713);
INSERT INTO `cd_log` VALUES (621, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590542550);
INSERT INTO `cd_log` VALUES (622, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590553850);
INSERT INTO `cd_log` VALUES (623, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590554815);
INSERT INTO `cd_log` VALUES (624, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.50', 1590555520);
INSERT INTO `cd_log` VALUES (625, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590556386);
INSERT INTO `cd_log` VALUES (626, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.3', 1590558348);
INSERT INTO `cd_log` VALUES (627, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.202', 1590558390);
INSERT INTO `cd_log` VALUES (628, 50, 'lwang', '用户登录', '117.188.23.34', 1590561243);
INSERT INTO `cd_log` VALUES (629, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.202', 1590562723);
INSERT INTO `cd_log` VALUES (630, 1, 'admin', '用户登录', '117.188.23.34', 1590568035);
INSERT INTO `cd_log` VALUES (631, 83, '01', '用户登录', '42.48.113.242', 1590628898);
INSERT INTO `cd_log` VALUES (632, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.174', 1590639687);
INSERT INTO `cd_log` VALUES (633, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.127', 1590643106);
INSERT INTO `cd_log` VALUES (634, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.202', 1590647074);
INSERT INTO `cd_log` VALUES (635, 1, 'admin', '用户登录', '117.188.23.34', 1590649226);
INSERT INTO `cd_log` VALUES (636, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.174', 1590665782);
INSERT INTO `cd_log` VALUES (637, 116, 'dmg', '用户登录', '117.100.115.205', 1590679147);
INSERT INTO `cd_log` VALUES (638, 116, 'dmg', '用户登录', '117.100.115.205', 1590679244);
INSERT INTO `cd_log` VALUES (639, 1, 'admin', '用户登录', '111.121.47.109', 1590681370);
INSERT INTO `cd_log` VALUES (640, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.165', 1590715624);
INSERT INTO `cd_log` VALUES (641, 125, '18910830057', '用户登录', '61.135.39.195', 1590722092);
INSERT INTO `cd_log` VALUES (642, 116, 'dmg', '用户登录', '61.135.39.195', 1590722503);
INSERT INTO `cd_log` VALUES (643, 125, '18910830057', '用户登录', '61.135.39.195', 1590722599);
INSERT INTO `cd_log` VALUES (644, 125, '18910830057', '用户登录', '61.135.39.195', 1590723952);
INSERT INTO `cd_log` VALUES (645, 125, '18910830057', '用户登录', '61.135.39.195', 1590724662);
INSERT INTO `cd_log` VALUES (646, 125, '18910830057', '用户登录', '61.135.39.195', 1590725365);
INSERT INTO `cd_log` VALUES (647, 125, '18910830057', '用户登录', '61.135.39.195', 1590728647);
INSERT INTO `cd_log` VALUES (648, 125, '18910830057', '用户登录', '61.135.39.195', 1590730217);
INSERT INTO `cd_log` VALUES (649, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.194', 1590730231);
INSERT INTO `cd_log` VALUES (650, 50, 'lwang', '用户登录', '117.188.23.34', 1590734184);
INSERT INTO `cd_log` VALUES (651, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.194', 1590734521);
INSERT INTO `cd_log` VALUES (652, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.220', 1590735892);
INSERT INTO `cd_log` VALUES (653, 124, 'lzf', '用户登录', '49.92.43.189', 1590743138);
INSERT INTO `cd_log` VALUES (654, 1, 'admin', '用户登录', '117.188.23.34', 1590743494);
INSERT INTO `cd_log` VALUES (655, 126, 'Jiaxuesong', '用户登录', '117.188.23.34', 1590743531);
INSERT INTO `cd_log` VALUES (656, 124, 'lzf', '用户登录', '49.92.43.189', 1590743912);
INSERT INTO `cd_log` VALUES (657, 124, 'lzf', '用户登录', '49.71.196.153', 1590754205);
INSERT INTO `cd_log` VALUES (658, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.220', 1590759368);
INSERT INTO `cd_log` VALUES (659, 1, 'admin', '用户登录', '111.121.47.109', 1590763396);
INSERT INTO `cd_log` VALUES (660, 1, 'admin', '用户登录', '111.121.47.109', 1590768073);
INSERT INTO `cd_log` VALUES (661, 118, '18600590406', '用户登录', '125.34.81.247', 1590801219);
INSERT INTO `cd_log` VALUES (662, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.64', 1590815923);
INSERT INTO `cd_log` VALUES (663, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.165', 1590817172);
INSERT INTO `cd_log` VALUES (664, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.220', 1590825002);
INSERT INTO `cd_log` VALUES (665, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.165', 1590829601);
INSERT INTO `cd_log` VALUES (666, 128, 'weijf125', '用户登录', '180.140.162.11', 1590851202);
INSERT INTO `cd_log` VALUES (667, 129, 'hjoke', '用户登录', '117.80.160.71', 1590860357);
INSERT INTO `cd_log` VALUES (668, 129, 'hjoke', '用户登录', '117.80.160.71', 1590860478);
INSERT INTO `cd_log` VALUES (669, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.220', 1590889894);
INSERT INTO `cd_log` VALUES (670, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.64', 1590901143);
INSERT INTO `cd_log` VALUES (671, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.165', 1590902525);
INSERT INTO `cd_log` VALUES (672, 83, '01', '用户登录', '42.48.113.242', 1590925835);
INSERT INTO `cd_log` VALUES (673, 130, 'liuxiao', '用户登录', '61.148.245.143', 1590930336);
INSERT INTO `cd_log` VALUES (674, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1590932619);
INSERT INTO `cd_log` VALUES (675, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.64', 1590974965);
INSERT INTO `cd_log` VALUES (676, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1590989341);
INSERT INTO `cd_log` VALUES (677, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.225', 1590989479);
INSERT INTO `cd_log` VALUES (678, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.64', 1591004624);
INSERT INTO `cd_log` VALUES (679, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1591014428);
INSERT INTO `cd_log` VALUES (680, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.214', 1591061884);
INSERT INTO `cd_log` VALUES (681, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1591075231);
INSERT INTO `cd_log` VALUES (682, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.225', 1591086279);
INSERT INTO `cd_log` VALUES (683, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.214', 1591148439);
INSERT INTO `cd_log` VALUES (684, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.46', 1591165393);
INSERT INTO `cd_log` VALUES (685, 83, '01', '用户登录', '42.48.113.242', 1591172522);
INSERT INTO `cd_log` VALUES (686, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.221', 1591177649);
INSERT INTO `cd_log` VALUES (687, 132, 'liuruyi0426', '用户登录', '113.87.47.21', 1591197522);
INSERT INTO `cd_log` VALUES (688, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.214', 1591237047);
INSERT INTO `cd_log` VALUES (689, 83, '01', '用户登录', '42.48.113.242', 1591245739);
INSERT INTO `cd_log` VALUES (690, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.236', 1591248203);
INSERT INTO `cd_log` VALUES (691, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.221', 1591250710);
INSERT INTO `cd_log` VALUES (692, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.2', 1591254909);
INSERT INTO `cd_log` VALUES (693, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.2', 1591255004);
INSERT INTO `cd_log` VALUES (694, 1, 'admin', '用户登录', '117.188.23.34', 1591255043);
INSERT INTO `cd_log` VALUES (695, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.2', 1591259009);
INSERT INTO `cd_log` VALUES (696, 1, 'admin', '用户登录', '117.188.23.34', 1591269081);
INSERT INTO `cd_log` VALUES (697, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.2', 1591269120);
INSERT INTO `cd_log` VALUES (698, 1, 'admin', '用户登录', '111.121.15.254', 1591288804);
INSERT INTO `cd_log` VALUES (699, 1, 'admin', '用户登录', '111.121.15.254', 1591319940);
INSERT INTO `cd_log` VALUES (700, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.56', 1591320051);
INSERT INTO `cd_log` VALUES (701, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.236', 1591320445);
INSERT INTO `cd_log` VALUES (702, 135, '至酷智能无人超市', '用户登录', '58.255.134.177', 1591330089);
INSERT INTO `cd_log` VALUES (703, 135, '至酷智能无人超市', '用户登录', '58.255.134.177', 1591330338);
INSERT INTO `cd_log` VALUES (704, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.221', 1591353527);
INSERT INTO `cd_log` VALUES (705, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.236', 1591360700);
INSERT INTO `cd_log` VALUES (706, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.236', 1591406829);
INSERT INTO `cd_log` VALUES (707, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.221', 1591408179);
INSERT INTO `cd_log` VALUES (708, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.56', 1591410752);
INSERT INTO `cd_log` VALUES (709, 1, 'admin', '用户登录', '117.188.5.187', 1591428613);
INSERT INTO `cd_log` VALUES (710, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.56', 1591437185);
INSERT INTO `cd_log` VALUES (711, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.37', 1591440056);
INSERT INTO `cd_log` VALUES (712, 1, 'admin', '用户登录', '111.121.45.227', 1591462938);
INSERT INTO `cd_log` VALUES (713, 50, 'lwang', '用户登录', '117.188.5.187', 1591491093);
INSERT INTO `cd_log` VALUES (714, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.56', 1591493263);
INSERT INTO `cd_log` VALUES (715, 1, 'admin', '用户登录', '220.197.205.58', 1591501160);
INSERT INTO `cd_log` VALUES (716, 137, 'fhszy666', '用户登录', '1.204.61.236', 1591501621);
INSERT INTO `cd_log` VALUES (717, 50, 'lwang', '用户登录', '1.204.61.236', 1591501726);
INSERT INTO `cd_log` VALUES (718, 50, 'lwang', '用户登录', '1.204.61.236', 1591502415);
INSERT INTO `cd_log` VALUES (719, 137, 'fhszy666', '用户登录', '1.204.61.236', 1591504759);
INSERT INTO `cd_log` VALUES (720, 137, 'fhszy666', '用户登录', '1.204.61.236', 1591507564);
INSERT INTO `cd_log` VALUES (721, 137, 'fhszy666', '用户登录', '1.204.61.236', 1591507635);
INSERT INTO `cd_log` VALUES (722, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.37', 1591507678);
INSERT INTO `cd_log` VALUES (723, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.218', 1591507727);
INSERT INTO `cd_log` VALUES (724, 96, 'ytk', '用户登录', '222.186.101.241', 1591510176);
INSERT INTO `cd_log` VALUES (725, 1, 'admin', '用户登录', '111.121.44.177', 1591510641);
INSERT INTO `cd_log` VALUES (726, 138, 'duanxy', '用户登录', '111.121.44.177', 1591510722);
INSERT INTO `cd_log` VALUES (727, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.56', 1591510763);
INSERT INTO `cd_log` VALUES (728, 1, 'admin', '用户登录', '111.121.44.177', 1591511210);
INSERT INTO `cd_log` VALUES (729, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.37', 1591518767);
INSERT INTO `cd_log` VALUES (730, 1, 'admin', '用户登录', '111.121.44.177', 1591537705);
INSERT INTO `cd_log` VALUES (731, 137, 'fhszy666', '用户登录', '1.204.61.236', 1591577465);
INSERT INTO `cd_log` VALUES (732, 50, 'lwang', '用户登录', '117.188.5.187', 1591583197);
INSERT INTO `cd_log` VALUES (733, 50, 'lwang', '用户登录', '117.188.5.187', 1591586197);
INSERT INTO `cd_log` VALUES (734, 133, '至酷智能商店', '用户登录', '14.126.231.230', 1591589828);
INSERT INTO `cd_log` VALUES (735, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.189', 1591594055);
INSERT INTO `cd_log` VALUES (736, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.37', 1591594061);
INSERT INTO `cd_log` VALUES (737, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.218', 1591595597);
INSERT INTO `cd_log` VALUES (738, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.189', 1591596527);
INSERT INTO `cd_log` VALUES (739, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.189', 1591613853);
INSERT INTO `cd_log` VALUES (740, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.37', 1591622866);
INSERT INTO `cd_log` VALUES (741, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.37', 1591668201);
INSERT INTO `cd_log` VALUES (742, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.189', 1591669278);
INSERT INTO `cd_log` VALUES (743, 137, 'fhszy666', '用户登录', '1.204.56.209', 1591682782);
INSERT INTO `cd_log` VALUES (744, 137, 'fhszy666', '用户登录', '1.204.56.209', 1591683152);
INSERT INTO `cd_log` VALUES (745, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.189', 1591696208);
INSERT INTO `cd_log` VALUES (746, 50, 'lwang', '用户登录', '117.188.5.187', 1591700578);
INSERT INTO `cd_log` VALUES (747, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.189', 1591757676);
INSERT INTO `cd_log` VALUES (748, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.143', 1591767089);
INSERT INTO `cd_log` VALUES (749, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.241', 1591770884);
INSERT INTO `cd_log` VALUES (750, 83, '01', '用户登录', '42.48.113.242', 1591776787);
INSERT INTO `cd_log` VALUES (751, 1, 'admin', '用户登录', '111.121.40.29', 1591789249);
INSERT INTO `cd_log` VALUES (752, 1, 'admin', '用户登录', '111.121.40.29', 1591809476);
INSERT INTO `cd_log` VALUES (753, 1, 'admin', '用户登录', '111.121.40.29', 1591810583);
INSERT INTO `cd_log` VALUES (754, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.189', 1591840664);
INSERT INTO `cd_log` VALUES (755, 1, 'admin', '用户登录', '117.188.5.187', 1591841855);
INSERT INTO `cd_log` VALUES (756, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.29', 1591852558);
INSERT INTO `cd_log` VALUES (757, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.241', 1591857330);
INSERT INTO `cd_log` VALUES (758, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.189', 1591864338);
INSERT INTO `cd_log` VALUES (759, 1, 'admin', '用户登录', '111.121.40.156', 1591888729);
INSERT INTO `cd_log` VALUES (760, 1, 'admin', '用户登录', '117.188.5.187', 1591931767);
INSERT INTO `cd_log` VALUES (761, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.29', 1591940495);
INSERT INTO `cd_log` VALUES (762, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.228', 1591941696);
INSERT INTO `cd_log` VALUES (763, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.29', 1591947010);
INSERT INTO `cd_log` VALUES (764, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.189', 1591952470);
INSERT INTO `cd_log` VALUES (765, 1, 'admin', '用户登录', '111.121.40.156', 1591973785);
INSERT INTO `cd_log` VALUES (766, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.228', 1592014774);
INSERT INTO `cd_log` VALUES (767, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.25', 1592015882);
INSERT INTO `cd_log` VALUES (768, 1, 'admin', '用户登录', '220.197.205.58', 1592019522);
INSERT INTO `cd_log` VALUES (769, 1, 'admin', '用户登录', '111.121.45.45', 1592024595);
INSERT INTO `cd_log` VALUES (770, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.29', 1592026013);
INSERT INTO `cd_log` VALUES (771, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.25', 1592026323);
INSERT INTO `cd_log` VALUES (772, 1, 'admin', '用户登录', '111.121.45.45', 1592057922);
INSERT INTO `cd_log` VALUES (773, 138, 'duanxy', '用户登录', '111.121.45.45', 1592070071);
INSERT INTO `cd_log` VALUES (774, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.82', 1592112762);
INSERT INTO `cd_log` VALUES (775, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.244', 1592113713);
INSERT INTO `cd_log` VALUES (776, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.244', 1592116481);
INSERT INTO `cd_log` VALUES (777, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.240', 1592126728);
INSERT INTO `cd_log` VALUES (778, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.82', 1592197079);
INSERT INTO `cd_log` VALUES (779, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.104', 1592201046);
INSERT INTO `cd_log` VALUES (780, 124, 'lzf', '用户登录', '114.233.222.110', 1592209862);
INSERT INTO `cd_log` VALUES (781, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.82', 1592213761);
INSERT INTO `cd_log` VALUES (782, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.240', 1592214339);
INSERT INTO `cd_log` VALUES (783, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.74', 1592224990);
INSERT INTO `cd_log` VALUES (784, 83, '01', '用户登录', '42.48.113.242', 1592267470);
INSERT INTO `cd_log` VALUES (785, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.74', 1592285395);
INSERT INTO `cd_log` VALUES (786, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.104', 1592290711);
INSERT INTO `cd_log` VALUES (787, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.82', 1592293609);
INSERT INTO `cd_log` VALUES (788, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.104', 1592298300);
INSERT INTO `cd_log` VALUES (789, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.104', 1592359852);
INSERT INTO `cd_log` VALUES (790, 1, 'admin', '用户登录', '111.121.47.154', 1592363222);
INSERT INTO `cd_log` VALUES (791, 83, '01', '用户登录', '42.48.113.242', 1592365031);
INSERT INTO `cd_log` VALUES (792, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.104', 1592370658);
INSERT INTO `cd_log` VALUES (793, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.162', 1592371602);
INSERT INTO `cd_log` VALUES (794, 67, '巴帝洛克尚东店', '用户登录', '117.178.60.140', 1592380650);
INSERT INTO `cd_log` VALUES (795, 1, 'admin', '用户登录', '117.188.1.120', 1592381469);
INSERT INTO `cd_log` VALUES (796, 50, 'lwang', '用户登录', '117.188.1.120', 1592387729);
INSERT INTO `cd_log` VALUES (797, 67, '巴帝洛克尚东店', '用户登录', '117.178.60.140', 1592390390);
INSERT INTO `cd_log` VALUES (798, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.162', 1592390913);
INSERT INTO `cd_log` VALUES (799, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.162', 1592394874);
INSERT INTO `cd_log` VALUES (800, 1, 'admin', '用户登录', '111.121.15.41', 1592404089);
INSERT INTO `cd_log` VALUES (801, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.162', 1592458103);
INSERT INTO `cd_log` VALUES (802, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.99', 1592463924);
INSERT INTO `cd_log` VALUES (803, 96, 'ytk', '用户登录', '222.186.101.241', 1592466556);
INSERT INTO `cd_log` VALUES (804, 67, '巴帝洛克尚东店', '用户登录', '117.178.60.140', 1592467827);
INSERT INTO `cd_log` VALUES (805, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.99', 1592484651);
INSERT INTO `cd_log` VALUES (806, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.162', 1592485006);
INSERT INTO `cd_log` VALUES (807, 1, 'admin', '用户登录', '111.121.15.41', 1592489127);
INSERT INTO `cd_log` VALUES (808, 1, 'admin', '用户登录', '111.121.15.41', 1592531528);
INSERT INTO `cd_log` VALUES (809, 67, '巴帝洛克尚东店', '用户登录', '117.178.60.140', 1592542337);
INSERT INTO `cd_log` VALUES (810, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.162', 1592544514);
INSERT INTO `cd_log` VALUES (811, 1, 'admin', '用户登录', '117.188.1.120', 1592545591);
INSERT INTO `cd_log` VALUES (812, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.157', 1592545635);
INSERT INTO `cd_log` VALUES (813, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.157', 1592567676);
INSERT INTO `cd_log` VALUES (814, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.157', 1592573884);
INSERT INTO `cd_log` VALUES (815, 1, 'admin', '用户登录', '111.121.41.158', 1592576216);
INSERT INTO `cd_log` VALUES (816, 1, 'admin', '用户登录', '111.121.41.158', 1592618938);
INSERT INTO `cd_log` VALUES (817, 1, 'admin', '用户登录', '117.188.1.120', 1592631544);
INSERT INTO `cd_log` VALUES (818, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.157', 1592632106);
INSERT INTO `cd_log` VALUES (819, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592638168);
INSERT INTO `cd_log` VALUES (820, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592659840);
INSERT INTO `cd_log` VALUES (821, 1, 'admin', '用户登录', '111.121.41.158', 1592669653);
INSERT INTO `cd_log` VALUES (822, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.157', 1592719057);
INSERT INTO `cd_log` VALUES (823, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592719585);
INSERT INTO `cd_log` VALUES (824, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592721908);
INSERT INTO `cd_log` VALUES (825, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592730279);
INSERT INTO `cd_log` VALUES (826, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.22', 1592737824);
INSERT INTO `cd_log` VALUES (827, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592741057);
INSERT INTO `cd_log` VALUES (828, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.85', 1592789479);
INSERT INTO `cd_log` VALUES (829, 1, 'admin', '用户登录', '117.188.1.120', 1592800881);
INSERT INTO `cd_log` VALUES (830, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.22', 1592809998);
INSERT INTO `cd_log` VALUES (831, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.30', 1592816111);
INSERT INTO `cd_log` VALUES (832, 132, 'liuruyi0426', '用户登录', '14.30.35.87', 1592837934);
INSERT INTO `cd_log` VALUES (833, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.85', 1592878815);
INSERT INTO `cd_log` VALUES (834, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.85', 1592883237);
INSERT INTO `cd_log` VALUES (835, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.20', 1592891023);
INSERT INTO `cd_log` VALUES (836, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.105', 1592901087);
INSERT INTO `cd_log` VALUES (837, 1, 'admin', '用户登录', '111.121.43.180', 1592902639);
INSERT INTO `cd_log` VALUES (838, 1, 'admin', '用户登录', '111.121.43.180', 1592904272);
INSERT INTO `cd_log` VALUES (839, 79, '13775902899', '用户登录', '58.218.36.206', 1592904988);
INSERT INTO `cd_log` VALUES (840, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.85', 1592910898);
INSERT INTO `cd_log` VALUES (841, 148, 'cxf123412', '用户登录', '103.123.91.95', 1592916907);
INSERT INTO `cd_log` VALUES (842, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.85', 1592920114);
INSERT INTO `cd_log` VALUES (843, 1, 'admin', '用户登录', '111.121.43.180', 1592922895);
INSERT INTO `cd_log` VALUES (844, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.20', 1592976391);
INSERT INTO `cd_log` VALUES (845, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.85', 1592977202);
INSERT INTO `cd_log` VALUES (846, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.105', 1592986440);
INSERT INTO `cd_log` VALUES (847, 1, 'admin', '用户登录', '111.121.43.107', 1593086292);
INSERT INTO `cd_log` VALUES (848, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.105', 1593087820);
INSERT INTO `cd_log` VALUES (849, 50, 'lwang', '用户登录', '39.144.42.139', 1593093699);
INSERT INTO `cd_log` VALUES (850, 150, 'xiaowang', '用户登录', '39.144.42.139', 1593093746);
INSERT INTO `cd_log` VALUES (851, 50, 'lwang', '用户登录', '39.144.42.139', 1593093886);
INSERT INTO `cd_log` VALUES (852, 1, 'admin', '用户登录', '111.121.43.107', 1593127081);
INSERT INTO `cd_log` VALUES (853, 100, 'lIwang', '用户登录', '39.144.42.139', 1593131917);
INSERT INTO `cd_log` VALUES (854, 50, 'lwang', '用户登录', '39.144.42.139', 1593132063);
INSERT INTO `cd_log` VALUES (855, 100, 'liwang', '用户登录', '39.144.42.139', 1593132102);
INSERT INTO `cd_log` VALUES (856, 151, 'iwang', '用户登录', '39.144.42.139', 1593132293);
INSERT INTO `cd_log` VALUES (857, 151, 'iwang', '用户登录', '39.144.42.139', 1593132557);
INSERT INTO `cd_log` VALUES (858, 1, 'admin', '用户登录', '111.121.43.107', 1593132586);
INSERT INTO `cd_log` VALUES (859, 100, 'liwang', '用户登录', '39.144.42.139', 1593132864);
INSERT INTO `cd_log` VALUES (860, 140, '24h至酷智能无人超市', '用户登录', '39.144.42.139', 1593133927);
INSERT INTO `cd_log` VALUES (861, 140, '24h至酷智能无人超市', '用户登录', '111.121.43.107', 1593133958);
INSERT INTO `cd_log` VALUES (862, 1, 'admin', '用户登录', '111.121.43.107', 1593151614);
INSERT INTO `cd_log` VALUES (863, 140, '24h至酷智能无人超市', '用户登录', '27.41.7.50', 1593151830);
INSERT INTO `cd_log` VALUES (864, 32, 'jikeshifu', '用户登录', '111.121.43.107', 1593151974);
INSERT INTO `cd_log` VALUES (865, 85, '13985125158', '用户登录', '111.121.43.107', 1593152122);
INSERT INTO `cd_log` VALUES (866, 140, '24h至酷智能无人超市', '用户登录', '27.41.7.50', 1593152349);
INSERT INTO `cd_log` VALUES (867, 140, '24h至酷智能无人超市', '用户登录', '27.41.7.50', 1593152742);
INSERT INTO `cd_log` VALUES (868, 140, '24h至酷智能无人超市', '用户登录', '27.41.7.50', 1593153693);
INSERT INTO `cd_log` VALUES (869, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.127', 1593166001);
INSERT INTO `cd_log` VALUES (870, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.127', 1593243496);
INSERT INTO `cd_log` VALUES (871, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.57', 1593263720);
INSERT INTO `cd_log` VALUES (872, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.234', 1593309837);
INSERT INTO `cd_log` VALUES (873, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.127', 1593323311);
INSERT INTO `cd_log` VALUES (874, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.57', 1593323590);
INSERT INTO `cd_log` VALUES (875, 152, '13332997042', '用户登录', '14.28.32.144', 1593331242);
INSERT INTO `cd_log` VALUES (876, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.234', 1593340369);
INSERT INTO `cd_log` VALUES (877, 140, '24h至酷智能无人超市', '用户登录', '116.27.200.109', 1593341192);
INSERT INTO `cd_log` VALUES (878, 140, '24h至酷智能无人超市', '用户登录', '117.188.30.173', 1593342393);
INSERT INTO `cd_log` VALUES (879, 1, 'admin', '用户登录', '111.121.42.55', 1593342949);
INSERT INTO `cd_log` VALUES (880, 133, '至酷智能商店', '用户登录', '117.188.30.173', 1593343084);
INSERT INTO `cd_log` VALUES (881, 152, '13332997042', '用户登录', '183.14.90.245', 1593344709);
INSERT INTO `cd_log` VALUES (882, 133, '至酷智能商店', '用户登录', '116.27.200.109', 1593344839);
INSERT INTO `cd_log` VALUES (883, 112, '巴帝洛克新厂店', '用户登录', '117.178.62.234', 1593346574);
INSERT INTO `cd_log` VALUES (884, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.234', 1593346623);
INSERT INTO `cd_log` VALUES (885, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.127', 1593346653);
INSERT INTO `cd_log` VALUES (886, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.127', 1593347067);
INSERT INTO `cd_log` VALUES (887, 133, '至酷智能商店', '用户登录', '116.27.200.109', 1593350950);
INSERT INTO `cd_log` VALUES (888, 50, 'lwang', '用户登录', '117.188.29.228', 1593392593);
INSERT INTO `cd_log` VALUES (889, 50, 'lwang', '用户登录', '117.188.29.228', 1593393696);
INSERT INTO `cd_log` VALUES (890, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.251', 1593394166);
INSERT INTO `cd_log` VALUES (891, 50, 'lwang', '用户登录', '117.188.29.228', 1593394189);
INSERT INTO `cd_log` VALUES (892, 133, '至酷智能商店', '用户登录', '27.41.5.158', 1593396715);
INSERT INTO `cd_log` VALUES (893, 133, '至酷智能商店', '用户登录', '27.41.5.158', 1593396902);
INSERT INTO `cd_log` VALUES (894, 133, '至酷智能商店', '用户登录', '27.41.5.158', 1593397081);
INSERT INTO `cd_log` VALUES (895, 133, '至酷智能商店', '用户登录', '27.41.5.158', 1593397888);
INSERT INTO `cd_log` VALUES (896, 133, '至酷智能商店', '用户登录', '27.41.5.158', 1593400385);
INSERT INTO `cd_log` VALUES (897, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.170', 1593400955);
INSERT INTO `cd_log` VALUES (898, 137, 'fhszy666', '用户登录', '117.188.29.228', 1593403082);
INSERT INTO `cd_log` VALUES (899, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.57', 1593412201);
INSERT INTO `cd_log` VALUES (900, 140, '24h至酷智能无人超市', '用户登录', '27.41.7.239', 1593424891);
INSERT INTO `cd_log` VALUES (901, 133, '至酷智能商店', '用户登录', '27.41.7.239', 1593425007);
INSERT INTO `cd_log` VALUES (902, 152, '13332997042', '用户登录', '113.88.102.77', 1593427475);
INSERT INTO `cd_log` VALUES (903, 152, '13332997042', '用户登录', '113.88.102.77', 1593428147);
INSERT INTO `cd_log` VALUES (904, 133, '至酷智能商店', '用户登录', '27.41.7.239', 1593429644);
INSERT INTO `cd_log` VALUES (905, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593432869);
INSERT INTO `cd_log` VALUES (906, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.57', 1593437863);
INSERT INTO `cd_log` VALUES (907, 1, 'admin', '用户登录', '111.121.8.7', 1593445164);
INSERT INTO `cd_log` VALUES (908, 83, '01', '用户登录', '42.48.113.242', 1593479604);
INSERT INTO `cd_log` VALUES (909, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593484294);
INSERT INTO `cd_log` VALUES (910, 83, '01', '用户登录', '42.48.113.242', 1593484770);
INSERT INTO `cd_log` VALUES (911, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.170', 1593484866);
INSERT INTO `cd_log` VALUES (912, 153, '20030511', '用户登录', '183.160.51.47', 1593487155);
INSERT INTO `cd_log` VALUES (913, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.57', 1593488720);
INSERT INTO `cd_log` VALUES (914, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593495604);
INSERT INTO `cd_log` VALUES (915, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593510261);
INSERT INTO `cd_log` VALUES (916, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593566380);
INSERT INTO `cd_log` VALUES (917, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593567194);
INSERT INTO `cd_log` VALUES (918, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593573121);
INSERT INTO `cd_log` VALUES (919, 83, '01', '用户登录', '42.48.113.242', 1593589050);
INSERT INTO `cd_log` VALUES (920, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.170', 1593589211);
INSERT INTO `cd_log` VALUES (921, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.170', 1593603976);
INSERT INTO `cd_log` VALUES (922, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593661936);
INSERT INTO `cd_log` VALUES (923, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.188', 1593665594);
INSERT INTO `cd_log` VALUES (924, 133, '至酷智能商店', '用户登录', '27.41.39.23', 1593674888);
INSERT INTO `cd_log` VALUES (925, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.201', 1593674895);
INSERT INTO `cd_log` VALUES (926, 133, '至酷智能商店', '用户登录', '27.41.39.23', 1593674932);
INSERT INTO `cd_log` VALUES (927, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593676119);
INSERT INTO `cd_log` VALUES (928, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.227', 1593691682);
INSERT INTO `cd_log` VALUES (929, 133, '至酷智能商店', '用户登录', '27.41.39.23', 1593697665);
INSERT INTO `cd_log` VALUES (930, 1, 'admin', '用户登录', '111.121.42.148', 1593705551);
INSERT INTO `cd_log` VALUES (931, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.201', 1593753373);
INSERT INTO `cd_log` VALUES (932, 117, 'liuruyi122', '用户登录', '14.30.179.82', 1593754731);
INSERT INTO `cd_log` VALUES (933, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.227', 1593754942);
INSERT INTO `cd_log` VALUES (934, 1, 'admin', '用户登录', '117.188.15.68', 1593755983);
INSERT INTO `cd_log` VALUES (935, 117, 'liuruyi122', '用户登录', '117.188.15.68', 1593756384);
INSERT INTO `cd_log` VALUES (936, 1, 'admin', '用户登录', '117.188.15.68', 1593756624);
INSERT INTO `cd_log` VALUES (937, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593759512);
INSERT INTO `cd_log` VALUES (938, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593759572);
INSERT INTO `cd_log` VALUES (939, 117, 'liuruyi122', '用户登录', '117.188.15.68', 1593759699);
INSERT INTO `cd_log` VALUES (940, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593759710);
INSERT INTO `cd_log` VALUES (941, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593760793);
INSERT INTO `cd_log` VALUES (942, 1, 'admin', '用户登录', '117.188.15.68', 1593761384);
INSERT INTO `cd_log` VALUES (943, 122, '巴帝洛克金鼎店', '用户登录', '59.63.45.50', 1593765349);
INSERT INTO `cd_log` VALUES (944, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.148', 1593765587);
INSERT INTO `cd_log` VALUES (945, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.251', 1593780887);
INSERT INTO `cd_log` VALUES (946, 1, 'admin', '用户登录', '111.121.9.211', 1593794929);
INSERT INTO `cd_log` VALUES (947, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.227', 1593837645);
INSERT INTO `cd_log` VALUES (948, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.251', 1593840394);
INSERT INTO `cd_log` VALUES (949, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.251', 1593841528);
INSERT INTO `cd_log` VALUES (950, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.201', 1593849753);
INSERT INTO `cd_log` VALUES (951, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.251', 1593914893);
INSERT INTO `cd_log` VALUES (952, 1, 'admin', '用户登录', '111.121.41.82', 1593927110);
INSERT INTO `cd_log` VALUES (953, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.138', 1593930641);
INSERT INTO `cd_log` VALUES (954, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.251', 1593943804);
INSERT INTO `cd_log` VALUES (955, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.227', 1593950202);
INSERT INTO `cd_log` VALUES (956, 83, '01', '用户登录', '42.48.113.242', 1594000176);
INSERT INTO `cd_log` VALUES (957, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.251', 1594003480);
INSERT INTO `cd_log` VALUES (958, 1, 'admin', '用户登录', '111.121.41.82', 1594005802);
INSERT INTO `cd_log` VALUES (959, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1594008937);
INSERT INTO `cd_log` VALUES (960, 63, '劉睿兄弟', '用户登录', '124.160.214.100', 1594013236);
INSERT INTO `cd_log` VALUES (961, 1, 'admin', '用户登录', '117.188.15.68', 1594016355);
INSERT INTO `cd_log` VALUES (962, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.138', 1594022906);
INSERT INTO `cd_log` VALUES (963, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.138', 1594027349);
INSERT INTO `cd_log` VALUES (964, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594033271);
INSERT INTO `cd_log` VALUES (965, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594086315);
INSERT INTO `cd_log` VALUES (966, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594087886);
INSERT INTO `cd_log` VALUES (967, 1, 'admin', '用户登录', '117.188.15.68', 1594092132);
INSERT INTO `cd_log` VALUES (968, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.138', 1594097749);
INSERT INTO `cd_log` VALUES (969, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1594104036);
INSERT INTO `cd_log` VALUES (970, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594105580);
INSERT INTO `cd_log` VALUES (971, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1594119306);
INSERT INTO `cd_log` VALUES (972, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1594128480);
INSERT INTO `cd_log` VALUES (973, 137, 'fhszy666', '用户登录', '1.204.68.60', 1594174676);
INSERT INTO `cd_log` VALUES (974, 137, 'fhszy666', '用户登录', '117.188.15.68', 1594175083);
INSERT INTO `cd_log` VALUES (975, 50, 'lwang', '用户登录', '117.188.15.68', 1594175850);
INSERT INTO `cd_log` VALUES (976, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.94', 1594176970);
INSERT INTO `cd_log` VALUES (977, 1, 'admin', '用户登录', '117.188.15.68', 1594178295);
INSERT INTO `cd_log` VALUES (978, 1, 'admin', '用户登录', '117.188.15.68', 1594178379);
INSERT INTO `cd_log` VALUES (979, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1594187568);
INSERT INTO `cd_log` VALUES (980, 1, 'admin', '用户登录', '117.132.196.101', 1594188063);
INSERT INTO `cd_log` VALUES (981, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594193431);
INSERT INTO `cd_log` VALUES (982, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594193639);
INSERT INTO `cd_log` VALUES (983, 63, '劉睿兄弟', '用户登录', '124.160.213.197', 1594194169);
INSERT INTO `cd_log` VALUES (984, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1594194698);
INSERT INTO `cd_log` VALUES (985, 1, 'admin', '用户登录', '117.132.196.101', 1594195464);
INSERT INTO `cd_log` VALUES (986, 138, 'duanxy', '用户登录', '117.132.196.101', 1594195488);
INSERT INTO `cd_log` VALUES (987, 1, 'admin', '用户登录', '117.132.196.101', 1594195686);
INSERT INTO `cd_log` VALUES (988, 157, 'cxh', '用户登录', '218.83.127.78', 1594195801);
INSERT INTO `cd_log` VALUES (989, 157, 'cxh', '用户登录', '218.83.127.78', 1594263406);
INSERT INTO `cd_log` VALUES (990, 157, 'cxh', '用户登录', '123.168.66.127', 1594263572);
INSERT INTO `cd_log` VALUES (991, 157, 'cxh', '用户登录', '218.83.127.78', 1594264918);
INSERT INTO `cd_log` VALUES (992, 1, 'admin', '用户登录', '117.188.15.68', 1594265166);
INSERT INTO `cd_log` VALUES (993, 157, 'cxh', '用户登录', '218.83.127.78', 1594265451);
INSERT INTO `cd_log` VALUES (994, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.13', 1594267920);
INSERT INTO `cd_log` VALUES (995, 51, '增小贩无人超市', '用户登录', '1.192.27.69', 1594273004);
INSERT INTO `cd_log` VALUES (996, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.94', 1594277918);
INSERT INTO `cd_log` VALUES (997, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594286187);
INSERT INTO `cd_log` VALUES (998, 1, 'admin', '用户登录', '111.121.15.215', 1594296099);
INSERT INTO `cd_log` VALUES (999, 152, '13332997042', '用户登录', '113.116.15.64', 1594303494);
INSERT INTO `cd_log` VALUES (1000, 1, 'admin', '用户登录', '111.121.15.215', 1594315807);
INSERT INTO `cd_log` VALUES (1001, 1, 'admin', '用户登录', '111.121.15.215', 1594343934);
INSERT INTO `cd_log` VALUES (1002, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594346222);
INSERT INTO `cd_log` VALUES (1003, 137, 'fhszy666', '用户登录', '117.188.12.224', 1594347854);
INSERT INTO `cd_log` VALUES (1004, 1, 'admin', '用户登录', '111.121.15.215', 1594348175);
INSERT INTO `cd_log` VALUES (1005, 1, 'admin', '用户登录', '117.188.12.224', 1594357426);
INSERT INTO `cd_log` VALUES (1006, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.201', 1594358801);
INSERT INTO `cd_log` VALUES (1007, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.94', 1594367908);
INSERT INTO `cd_log` VALUES (1008, 83, '01', '用户登录', '42.48.113.242', 1594375419);
INSERT INTO `cd_log` VALUES (1009, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.201', 1594431616);
INSERT INTO `cd_log` VALUES (1010, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594436387);
INSERT INTO `cd_log` VALUES (1011, 160, 'wcq112233', '用户登录', '111.85.190.23', 1594441463);
INSERT INTO `cd_log` VALUES (1012, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.53', 1594443217);
INSERT INTO `cd_log` VALUES (1013, 160, 'wcq112233', '用户登录', '1.204.22.98', 1594443468);
INSERT INTO `cd_log` VALUES (1014, 48, '神猫', '用户登录', '101.41.131.123', 1594454497);
INSERT INTO `cd_log` VALUES (1015, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594455194);
INSERT INTO `cd_log` VALUES (1016, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594455255);
INSERT INTO `cd_log` VALUES (1017, 160, 'wcq112233', '用户登录', '1.204.202.19', 1594459251);
INSERT INTO `cd_log` VALUES (1018, 160, 'wcq112233', '用户登录', '1.204.202.19', 1594459701);
INSERT INTO `cd_log` VALUES (1019, 160, 'wcq112233', '用户登录', '1.204.202.19', 1594459787);
INSERT INTO `cd_log` VALUES (1020, 160, 'wcq112233', '用户登录', '1.204.202.19', 1594459900);
INSERT INTO `cd_log` VALUES (1021, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594462179);
INSERT INTO `cd_log` VALUES (1022, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.114', 1594473373);
INSERT INTO `cd_log` VALUES (1023, 1, 'admin', '用户登录', '111.121.44.23', 1594484918);
INSERT INTO `cd_log` VALUES (1024, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.53', 1594531573);
INSERT INTO `cd_log` VALUES (1025, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.201', 1594534107);
INSERT INTO `cd_log` VALUES (1026, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.201', 1594540323);
INSERT INTO `cd_log` VALUES (1027, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.154', 1594544379);
INSERT INTO `cd_log` VALUES (1028, 1, 'admin', '用户登录', '111.121.44.23', 1594571043);
INSERT INTO `cd_log` VALUES (1029, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.242', 1594602649);
INSERT INTO `cd_log` VALUES (1030, 83, '01', '用户登录', '42.48.113.242', 1594611299);
INSERT INTO `cd_log` VALUES (1031, 157, 'cxh', '用户登录', '218.83.127.78', 1594613973);
INSERT INTO `cd_log` VALUES (1032, 1, 'admin', '用户登录', '117.188.12.224', 1594616585);
INSERT INTO `cd_log` VALUES (1033, 63, '劉睿兄弟', '用户登录', '124.160.212.94', 1594620982);
INSERT INTO `cd_log` VALUES (1034, 157, 'cxh', '用户登录', '218.83.127.78', 1594622356);
INSERT INTO `cd_log` VALUES (1035, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.53', 1594622986);
INSERT INTO `cd_log` VALUES (1036, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.154', 1594625068);
INSERT INTO `cd_log` VALUES (1037, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.53', 1594627326);
INSERT INTO `cd_log` VALUES (1038, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.242', 1594643434);
INSERT INTO `cd_log` VALUES (1039, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.242', 1594690934);
INSERT INTO `cd_log` VALUES (1040, 157, 'cxh', '用户登录', '218.83.127.78', 1594694736);
INSERT INTO `cd_log` VALUES (1041, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.76', 1594698586);
INSERT INTO `cd_log` VALUES (1042, 1, 'admin', '用户登录', '223.104.24.99', 1594699285);
INSERT INTO `cd_log` VALUES (1043, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.154', 1594710138);
INSERT INTO `cd_log` VALUES (1044, 157, 'cxh', '用户登录', '218.83.127.78', 1594718619);
INSERT INTO `cd_log` VALUES (1045, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.242', 1594781683);
INSERT INTO `cd_log` VALUES (1046, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.186', 1594791908);
INSERT INTO `cd_log` VALUES (1047, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.76', 1594795601);
INSERT INTO `cd_log` VALUES (1048, 152, '13332997042', '用户登录', '113.116.227.248', 1594807318);
INSERT INTO `cd_log` VALUES (1049, 1, 'admin', '用户登录', '111.121.42.162', 1594823061);
INSERT INTO `cd_log` VALUES (1050, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.121', 1594862141);
INSERT INTO `cd_log` VALUES (1051, 1, 'admin', '用户登录', '117.188.12.224', 1594867192);
INSERT INTO `cd_log` VALUES (1052, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.121', 1594876648);
INSERT INTO `cd_log` VALUES (1053, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.76', 1594877302);
INSERT INTO `cd_log` VALUES (1054, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.76', 1594879481);
INSERT INTO `cd_log` VALUES (1055, 1, 'admin', '用户登录', '111.121.42.162', 1594900933);
INSERT INTO `cd_log` VALUES (1056, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.186', 1594901016);
INSERT INTO `cd_log` VALUES (1057, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.121', 1594903008);
INSERT INTO `cd_log` VALUES (1058, 1, 'admin', '用户登录', '111.121.42.162', 1594905296);
INSERT INTO `cd_log` VALUES (1059, 162, '人城', '用户登录', '183.206.170.238', 1594907577);
INSERT INTO `cd_log` VALUES (1060, 163, 'oovov', '用户登录', '183.69.213.227', 1594923207);
INSERT INTO `cd_log` VALUES (1061, 107, '123456s', '用户登录', '117.67.136.58', 1594946257);
INSERT INTO `cd_log` VALUES (1062, 1, 'admin', '用户登录', '111.121.42.162', 1594949433);
INSERT INTO `cd_log` VALUES (1063, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.121', 1594951638);
INSERT INTO `cd_log` VALUES (1064, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.94', 1594967405);
INSERT INTO `cd_log` VALUES (1065, 1, 'admin', '用户登录', '111.121.45.129', 1594974742);
INSERT INTO `cd_log` VALUES (1066, 1, 'admin', '用户登录', '111.121.45.129', 1594976509);
INSERT INTO `cd_log` VALUES (1067, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.186', 1594983049);
INSERT INTO `cd_log` VALUES (1068, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.186', 1594983171);
INSERT INTO `cd_log` VALUES (1069, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.94', 1595037787);
INSERT INTO `cd_log` VALUES (1070, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.213', 1595043977);
INSERT INTO `cd_log` VALUES (1071, 104, 'rhcs8888', '用户登录', '122.230.71.21', 1595045559);
INSERT INTO `cd_log` VALUES (1072, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.213', 1595051727);
INSERT INTO `cd_log` VALUES (1073, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.213', 1595059191);
INSERT INTO `cd_log` VALUES (1074, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.121', 1595061384);
INSERT INTO `cd_log` VALUES (1075, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.213', 1595063387);
INSERT INTO `cd_log` VALUES (1076, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.94', 1595136592);
INSERT INTO `cd_log` VALUES (1077, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.8', 1595139139);
INSERT INTO `cd_log` VALUES (1078, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.213', 1595144283);
INSERT INTO `cd_log` VALUES (1079, 1, 'admin', '用户登录', '111.121.14.97', 1595168873);
INSERT INTO `cd_log` VALUES (1080, 1, 'admin', '用户登录', '117.188.6.217', 1595215592);
INSERT INTO `cd_log` VALUES (1081, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.8', 1595226168);
INSERT INTO `cd_log` VALUES (1082, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.122', 1595239276);
INSERT INTO `cd_log` VALUES (1083, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.122', 1595242138);
INSERT INTO `cd_log` VALUES (1084, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.8', 1595294971);
INSERT INTO `cd_log` VALUES (1085, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.8', 1595298223);
INSERT INTO `cd_log` VALUES (1086, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.122', 1595316019);
INSERT INTO `cd_log` VALUES (1087, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.236', 1595324787);
INSERT INTO `cd_log` VALUES (1088, 83, '01', '用户登录', '42.48.113.242', 1595378424);
INSERT INTO `cd_log` VALUES (1089, 83, '01', '用户登录', '42.48.113.242', 1595379676);
INSERT INTO `cd_log` VALUES (1090, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.69', 1595387779);
INSERT INTO `cd_log` VALUES (1091, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.236', 1595394656);
INSERT INTO `cd_log` VALUES (1092, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.122', 1595397210);
INSERT INTO `cd_log` VALUES (1093, 1, 'admin', '用户登录', '111.121.42.93', 1595406846);
INSERT INTO `cd_log` VALUES (1094, 1, 'admin', '用户登录', '111.121.42.93', 1595410231);
INSERT INTO `cd_log` VALUES (1095, 1, 'admin', '用户登录', '111.121.42.93', 1595418346);
INSERT INTO `cd_log` VALUES (1096, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.69', 1595483733);
INSERT INTO `cd_log` VALUES (1097, 83, '01', '用户登录', '42.48.113.242', 1595486982);
INSERT INTO `cd_log` VALUES (1098, 50, 'lwang', '用户登录', '117.188.6.217', 1595488531);
INSERT INTO `cd_log` VALUES (1099, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.132', 1595496279);
INSERT INTO `cd_log` VALUES (1100, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.132', 1595496458);
INSERT INTO `cd_log` VALUES (1101, 1, 'admin', '用户登录', '111.121.42.93', 1595515078);
INSERT INTO `cd_log` VALUES (1102, 1, 'admin', '用户登录', '111.121.42.93', 1595519854);
INSERT INTO `cd_log` VALUES (1103, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.69', 1595554575);
INSERT INTO `cd_log` VALUES (1104, 83, '01', '用户登录', '42.48.113.242', 1595562401);
INSERT INTO `cd_log` VALUES (1105, 1, 'admin', '用户登录', '111.121.14.26', 1595563651);
INSERT INTO `cd_log` VALUES (1106, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.132', 1595567659);
INSERT INTO `cd_log` VALUES (1107, 83, '01', '用户登录', '42.48.113.242', 1595580629);
INSERT INTO `cd_log` VALUES (1108, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.113', 1595590539);
INSERT INTO `cd_log` VALUES (1109, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.115', 1595640519);
INSERT INTO `cd_log` VALUES (1110, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.132', 1595654846);
INSERT INTO `cd_log` VALUES (1111, 112, '巴帝洛克新厂店', '用户登录', '182.86.161.113', 1595658699);
INSERT INTO `cd_log` VALUES (1112, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.132', 1595671062);
INSERT INTO `cd_log` VALUES (1113, 1, 'admin', '用户登录', '111.121.14.26', 1595690681);
INSERT INTO `cd_log` VALUES (1114, 1, 'admin', '用户登录', '111.121.14.26', 1595694088);
INSERT INTO `cd_log` VALUES (1115, 167, 'lssh8888', '用户登录', '171.223.83.51', 1595727104);
INSERT INTO `cd_log` VALUES (1116, 167, 'lssh8888', '用户登录', '171.223.83.51', 1595734494);
INSERT INTO `cd_log` VALUES (1117, 1, 'admin', '用户登录', '111.121.10.206', 1595736651);
INSERT INTO `cd_log` VALUES (1118, 165, '一', '用户登录', '118.255.63.165', 1595744915);
INSERT INTO `cd_log` VALUES (1119, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.115', 1595746027);
INSERT INTO `cd_log` VALUES (1120, 167, 'lssh8888', '用户登录', '171.223.83.51', 1595746147);
INSERT INTO `cd_log` VALUES (1121, 165, '一', '用户登录', '118.255.63.165', 1595746780);
INSERT INTO `cd_log` VALUES (1122, 165, '一', '用户登录', '118.255.63.165', 1595748031);
INSERT INTO `cd_log` VALUES (1123, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.14', 1595748581);
INSERT INTO `cd_log` VALUES (1124, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.138', 1595751151);
INSERT INTO `cd_log` VALUES (1125, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.14', 1595755143);
INSERT INTO `cd_log` VALUES (1126, 1, 'admin', '用户登录', '111.121.10.206', 1595775064);
INSERT INTO `cd_log` VALUES (1127, 83, '01', '用户登录', '42.48.113.242', 1595813854);
INSERT INTO `cd_log` VALUES (1128, 167, 'lssh8888', '用户登录', '218.88.90.254', 1595814101);
INSERT INTO `cd_log` VALUES (1129, 83, '01', '用户登录', '42.48.113.242', 1595814299);
INSERT INTO `cd_log` VALUES (1130, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.115', 1595817703);
INSERT INTO `cd_log` VALUES (1131, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.138', 1595835644);
INSERT INTO `cd_log` VALUES (1132, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.14', 1595841685);
INSERT INTO `cd_log` VALUES (1133, 144, 'zngdai', '用户登录', '223.74.196.132', 1595842323);
INSERT INTO `cd_log` VALUES (1134, 144, 'zngdai', '用户登录', '223.74.196.132', 1595842450);
INSERT INTO `cd_log` VALUES (1135, 1, 'admin', '用户登录', '111.121.10.206', 1595842763);
INSERT INTO `cd_log` VALUES (1136, 168, '熙熙盐蒸', '用户登录', '120.235.89.113', 1595898146);
INSERT INTO `cd_log` VALUES (1137, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.138', 1595918150);
INSERT INTO `cd_log` VALUES (1138, 169, 'kun568939299', '用户登录', '110.184.68.185', 1595923150);
INSERT INTO `cd_log` VALUES (1139, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.14', 1595924630);
INSERT INTO `cd_log` VALUES (1140, 170, '易能森智能', '用户登录', '61.154.119.130', 1595930610);
INSERT INTO `cd_log` VALUES (1141, 170, '易能森智能', '用户登录', '61.154.119.130', 1595930881);
INSERT INTO `cd_log` VALUES (1142, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.152', 1595931327);
INSERT INTO `cd_log` VALUES (1143, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.14', 1595934043);
INSERT INTO `cd_log` VALUES (1144, 146, 'matai112', '用户登录', '223.104.3.62', 1595946118);
INSERT INTO `cd_log` VALUES (1145, 50, 'lwang', '用户登录', '117.188.14.1', 1595986726);
INSERT INTO `cd_log` VALUES (1146, 169, 'kun568939299', '用户登录', '110.184.64.187', 1595987950);
INSERT INTO `cd_log` VALUES (1147, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.152', 1595993690);
INSERT INTO `cd_log` VALUES (1148, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.230', 1595997746);
INSERT INTO `cd_log` VALUES (1149, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.230', 1596016581);
INSERT INTO `cd_log` VALUES (1150, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596018612);
INSERT INTO `cd_log` VALUES (1151, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596018664);
INSERT INTO `cd_log` VALUES (1152, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.230', 1596019760);
INSERT INTO `cd_log` VALUES (1153, 168, '熙熙盐蒸', '用户登录', '103.27.25.91', 1596022691);
INSERT INTO `cd_log` VALUES (1154, 50, 'lwang', '用户登录', '117.188.14.1', 1596074714);
INSERT INTO `cd_log` VALUES (1155, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.230', 1596074823);
INSERT INTO `cd_log` VALUES (1156, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.82', 1596079008);
INSERT INTO `cd_log` VALUES (1157, 83, '01', '用户登录', '42.48.113.242', 1596090051);
INSERT INTO `cd_log` VALUES (1158, 50, 'lwang', '用户登录', '117.188.14.1', 1596095786);
INSERT INTO `cd_log` VALUES (1159, 50, 'lwang', '用户登录', '117.188.14.1', 1596095979);
INSERT INTO `cd_log` VALUES (1160, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596101575);
INSERT INTO `cd_log` VALUES (1161, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.82', 1596114963);
INSERT INTO `cd_log` VALUES (1162, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.82', 1596159349);
INSERT INTO `cd_log` VALUES (1163, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596180625);
INSERT INTO `cd_log` VALUES (1164, 112, '巴帝洛克新厂店', '用户登录', '182.86.166.230', 1596182742);
INSERT INTO `cd_log` VALUES (1165, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596247653);
INSERT INTO `cd_log` VALUES (1166, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.82', 1596249215);
INSERT INTO `cd_log` VALUES (1167, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.248', 1596260819);
INSERT INTO `cd_log` VALUES (1168, 1, 'admin', '用户登录', '111.121.11.46', 1596264260);
INSERT INTO `cd_log` VALUES (1169, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596278902);
INSERT INTO `cd_log` VALUES (1170, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.82', 1596288212);
INSERT INTO `cd_log` VALUES (1171, 146, 'matai112', '用户登录', '117.136.0.232', 1596291630);
INSERT INTO `cd_log` VALUES (1172, 1, 'admin', '用户登录', '111.121.11.46', 1596304630);
INSERT INTO `cd_log` VALUES (1173, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.248', 1596332339);
INSERT INTO `cd_log` VALUES (1174, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.248', 1596332578);
INSERT INTO `cd_log` VALUES (1175, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596347541);
INSERT INTO `cd_log` VALUES (1176, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.158', 1596347879);
INSERT INTO `cd_log` VALUES (1177, 1, 'admin', '用户登录', '111.121.11.46', 1596353695);
INSERT INTO `cd_log` VALUES (1178, 172, '17505919990', '用户登录', '175.42.34.124', 1596363120);
INSERT INTO `cd_log` VALUES (1179, 172, '17505919990', '用户登录', '175.42.34.124', 1596363160);
INSERT INTO `cd_log` VALUES (1180, 172, '17505919990', '用户登录', '220.249.162.10', 1596363335);
INSERT INTO `cd_log` VALUES (1181, 172, '17505919990', '用户登录', '220.249.162.10', 1596363554);
INSERT INTO `cd_log` VALUES (1182, 172, '17505919990', '用户登录', '220.249.162.10', 1596363772);
INSERT INTO `cd_log` VALUES (1183, 140, '24h至酷智能无人超市', '用户登录', '116.27.203.194', 1596374582);
INSERT INTO `cd_log` VALUES (1184, 133, '至酷智能商店', '用户登录', '116.27.203.194', 1596374668);
INSERT INTO `cd_log` VALUES (1185, 96, 'ytk', '用户登录', '222.186.101.241', 1596378690);
INSERT INTO `cd_log` VALUES (1186, 172, '17505919990', '用户登录', '218.85.42.83', 1596389393);
INSERT INTO `cd_log` VALUES (1187, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596429666);
INSERT INTO `cd_log` VALUES (1188, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596438450);
INSERT INTO `cd_log` VALUES (1189, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.158', 1596438698);
INSERT INTO `cd_log` VALUES (1190, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.248', 1596439337);
INSERT INTO `cd_log` VALUES (1191, 172, '17505919990', '用户登录', '36.251.97.137', 1596446797);
INSERT INTO `cd_log` VALUES (1192, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596449800);
INSERT INTO `cd_log` VALUES (1193, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596455288);
INSERT INTO `cd_log` VALUES (1194, 172, '17505919990', '用户登录', '61.241.205.115', 1596455358);
INSERT INTO `cd_log` VALUES (1195, 1, 'admin', '用户登录', '111.121.44.171', 1596464889);
INSERT INTO `cd_log` VALUES (1196, 172, '17505919990', '用户登录', '61.241.205.115', 1596477046);
INSERT INTO `cd_log` VALUES (1197, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.158', 1596502547);
INSERT INTO `cd_log` VALUES (1198, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596512869);
INSERT INTO `cd_log` VALUES (1199, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.217', 1596522211);
INSERT INTO `cd_log` VALUES (1200, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.173', 1596522236);
INSERT INTO `cd_log` VALUES (1201, 1, 'admin', '用户登录', '111.121.44.171', 1596553522);
INSERT INTO `cd_log` VALUES (1202, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.217', 1596593716);
INSERT INTO `cd_log` VALUES (1203, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596595855);
INSERT INTO `cd_log` VALUES (1204, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596598052);
INSERT INTO `cd_log` VALUES (1205, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596616773);
INSERT INTO `cd_log` VALUES (1206, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596616932);
INSERT INTO `cd_log` VALUES (1207, 50, 'lwang', '用户登录', '117.188.14.1', 1596620172);
INSERT INTO `cd_log` VALUES (1208, 1, 'admin', '用户登录', '111.121.44.187', 1596636982);
INSERT INTO `cd_log` VALUES (1209, 1, 'admin', '用户登录', '111.121.44.187', 1596638571);
INSERT INTO `cd_log` VALUES (1210, 172, '17505919990', '用户登录', '61.241.205.115', 1596641489);
INSERT INTO `cd_log` VALUES (1211, 112, '巴帝洛克新厂店', '用户登录', '182.86.164.217', 1596680435);
INSERT INTO `cd_log` VALUES (1212, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596680816);
INSERT INTO `cd_log` VALUES (1213, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.250', 1596686163);
INSERT INTO `cd_log` VALUES (1214, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596698705);
INSERT INTO `cd_log` VALUES (1215, 1, 'admin', '用户登录', '111.121.44.187', 1596762201);
INSERT INTO `cd_log` VALUES (1216, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596783644);
INSERT INTO `cd_log` VALUES (1217, 1, 'admin', '用户登录', '117.188.26.3', 1596786750);
INSERT INTO `cd_log` VALUES (1218, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.92', 1596787794);
INSERT INTO `cd_log` VALUES (1219, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.92', 1596806832);
INSERT INTO `cd_log` VALUES (1220, 1, 'admin', '用户登录', '111.121.41.185', 1596812436);
INSERT INTO `cd_log` VALUES (1221, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596851875);
INSERT INTO `cd_log` VALUES (1222, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.92', 1596855429);
INSERT INTO `cd_log` VALUES (1223, 58, 'lemesan', '用户登录', '106.61.81.136', 1596862600);
INSERT INTO `cd_log` VALUES (1224, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.92', 1596865289);
INSERT INTO `cd_log` VALUES (1225, 172, '17505919990', '用户登录', '117.29.136.146', 1596865297);
INSERT INTO `cd_log` VALUES (1226, 172, '17505919990', '用户登录', '117.29.136.146', 1596865600);
INSERT INTO `cd_log` VALUES (1227, 172, '17505919990', '用户登录', '117.29.136.146', 1596865675);
INSERT INTO `cd_log` VALUES (1228, 1, 'admin', '用户登录', '117.188.26.3', 1596878609);
INSERT INTO `cd_log` VALUES (1229, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.134', 1596884270);
INSERT INTO `cd_log` VALUES (1230, 1, 'admin', '用户登录', '111.121.41.185', 1596936319);
INSERT INTO `cd_log` VALUES (1231, 173, 'yixiang', '用户登录', '36.170.34.218', 1596936774);
INSERT INTO `cd_log` VALUES (1232, 173, 'yixiang', '用户登录', '36.170.34.218', 1596937200);
INSERT INTO `cd_log` VALUES (1233, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596937260);
INSERT INTO `cd_log` VALUES (1234, 173, 'yixiang', '用户登录', '36.170.34.218', 1596939938);
INSERT INTO `cd_log` VALUES (1235, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.92', 1596954001);
INSERT INTO `cd_log` VALUES (1236, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.92', 1596954072);
INSERT INTO `cd_log` VALUES (1237, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.134', 1596956555);
INSERT INTO `cd_log` VALUES (1238, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.139', 1596963657);
INSERT INTO `cd_log` VALUES (1239, 1, 'admin', '用户登录', '111.121.10.6', 1596983742);
INSERT INTO `cd_log` VALUES (1240, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.134', 1597025083);
INSERT INTO `cd_log` VALUES (1241, 1, 'admin', '用户登录', '117.188.26.3', 1597034676);
INSERT INTO `cd_log` VALUES (1242, 1, 'admin', '用户登录', '117.188.26.3', 1597035184);
INSERT INTO `cd_log` VALUES (1243, 83, '01', '用户登录', '42.48.113.242', 1597042176);
INSERT INTO `cd_log` VALUES (1244, 176, '郭晓宁', '用户登录', '112.96.167.187', 1597044935);
INSERT INTO `cd_log` VALUES (1245, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.10', 1597047934);
INSERT INTO `cd_log` VALUES (1246, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597059725);
INSERT INTO `cd_log` VALUES (1247, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597059900);
INSERT INTO `cd_log` VALUES (1248, 172, '17505919990', '用户登录', '112.51.18.194', 1597063622);
INSERT INTO `cd_log` VALUES (1249, 176, '郭晓宁', '用户登录', '112.96.165.222', 1597103617);
INSERT INTO `cd_log` VALUES (1250, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597112966);
INSERT INTO `cd_log` VALUES (1251, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597126570);
INSERT INTO `cd_log` VALUES (1252, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.10', 1597128282);
INSERT INTO `cd_log` VALUES (1253, 1, 'admin', '用户登录', '117.188.26.3', 1597132443);
INSERT INTO `cd_log` VALUES (1254, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597136064);
INSERT INTO `cd_log` VALUES (1255, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.10', 1597143273);
INSERT INTO `cd_log` VALUES (1256, 71, 'Rory', '用户登录', '110.185.5.68', 1597143567);
INSERT INTO `cd_log` VALUES (1257, 83, '01', '用户登录', '42.48.113.242', 1597145256);
INSERT INTO `cd_log` VALUES (1258, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597146666);
INSERT INTO `cd_log` VALUES (1259, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597212058);
INSERT INTO `cd_log` VALUES (1260, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597213970);
INSERT INTO `cd_log` VALUES (1261, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597219909);
INSERT INTO `cd_log` VALUES (1262, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.10', 1597223986);
INSERT INTO `cd_log` VALUES (1263, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597235704);
INSERT INTO `cd_log` VALUES (1264, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597241551);
INSERT INTO `cd_log` VALUES (1265, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.36', 1597280911);
INSERT INTO `cd_log` VALUES (1266, 63, '劉睿兄弟', '用户登录', '124.160.214.187', 1597282555);
INSERT INTO `cd_log` VALUES (1267, 1, 'admin', '用户登录', '117.188.26.3', 1597288157);
INSERT INTO `cd_log` VALUES (1268, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597300489);
INSERT INTO `cd_log` VALUES (1269, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.35', 1597301597);
INSERT INTO `cd_log` VALUES (1270, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.75', 1597312464);
INSERT INTO `cd_log` VALUES (1271, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.83', 1597370556);
INSERT INTO `cd_log` VALUES (1272, 83, '01', '用户登录', '42.48.113.242', 1597378822);
INSERT INTO `cd_log` VALUES (1273, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.117', 1597383179);
INSERT INTO `cd_log` VALUES (1274, 1, 'admin', '用户登录', '117.188.26.3', 1597383977);
INSERT INTO `cd_log` VALUES (1275, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.117', 1597386898);
INSERT INTO `cd_log` VALUES (1276, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.117', 1597393211);
INSERT INTO `cd_log` VALUES (1277, 172, '17505919990', '用户登录', '220.249.162.151', 1597446692);
INSERT INTO `cd_log` VALUES (1278, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.83', 1597456386);
INSERT INTO `cd_log` VALUES (1279, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.75', 1597468868);
INSERT INTO `cd_log` VALUES (1280, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.117', 1597469565);
INSERT INTO `cd_log` VALUES (1281, 1, 'admin', '用户登录', '111.121.45.33', 1597478760);
INSERT INTO `cd_log` VALUES (1282, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.75', 1597479833);
INSERT INTO `cd_log` VALUES (1283, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.117', 1597541074);
INSERT INTO `cd_log` VALUES (1284, 106, '郏县卫生健康委', '用户登录', '120.194.150.89', 1597545533);
INSERT INTO `cd_log` VALUES (1285, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.226', 1597555454);
INSERT INTO `cd_log` VALUES (1286, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.83', 1597562396);
INSERT INTO `cd_log` VALUES (1287, 1, 'admin', '用户登录', '111.121.45.33', 1597579461);
INSERT INTO `cd_log` VALUES (1288, 88, '15518738585', '用户登录', '122.194.1.227', 1597579489);
INSERT INTO `cd_log` VALUES (1289, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.182', 1597631290);
INSERT INTO `cd_log` VALUES (1290, 1, 'admin', '用户登录', '117.188.2.153', 1597634441);
INSERT INTO `cd_log` VALUES (1291, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.226', 1597642395);
INSERT INTO `cd_log` VALUES (1292, 172, '17505919990', '用户登录', '112.51.23.219', 1597645778);
INSERT INTO `cd_log` VALUES (1293, 1, 'admin', '用户登录', '117.188.2.153', 1597655264);
INSERT INTO `cd_log` VALUES (1294, 181, '薛', '用户登录', '113.200.160.161', 1597655730);
INSERT INTO `cd_log` VALUES (1295, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.163', 1597660870);
INSERT INTO `cd_log` VALUES (1296, 172, '17505919990', '用户登录', '112.51.23.156', 1597716954);
INSERT INTO `cd_log` VALUES (1297, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.182', 1597720385);
INSERT INTO `cd_log` VALUES (1298, 63, '劉睿兄弟', '用户登录', '124.160.214.159', 1597720496);
INSERT INTO `cd_log` VALUES (1299, 1, 'admin', '用户登录', '117.188.2.153', 1597734144);
INSERT INTO `cd_log` VALUES (1300, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.163', 1597738303);
INSERT INTO `cd_log` VALUES (1301, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.163', 1597738428);
INSERT INTO `cd_log` VALUES (1302, 112, '巴帝洛克新厂店', '用户登录', '182.86.131.226', 1597738517);
INSERT INTO `cd_log` VALUES (1303, 172, '17505919990', '用户登录', '112.51.23.156', 1597740155);
INSERT INTO `cd_log` VALUES (1304, 172, '17505919990', '用户登录', '61.241.205.115', 1597742547);
INSERT INTO `cd_log` VALUES (1305, 179, 'TP-LINK_ksnd', '用户登录', '183.208.210.72', 1597744176);
INSERT INTO `cd_log` VALUES (1306, 172, '17505919990', '用户登录', '61.241.205.115', 1597744659);
INSERT INTO `cd_log` VALUES (1307, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.182', 1597813281);
INSERT INTO `cd_log` VALUES (1308, 1, 'admin', '用户登录', '117.188.2.153', 1597815093);
INSERT INTO `cd_log` VALUES (1309, 181, '薛', '用户登录', '113.200.160.161', 1597817737);
INSERT INTO `cd_log` VALUES (1310, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.226', 1597823394);
INSERT INTO `cd_log` VALUES (1311, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.226', 1597842927);
INSERT INTO `cd_log` VALUES (1312, 178, '名都花园港城驿站', '用户登录', '117.82.72.243', 1597844755);
INSERT INTO `cd_log` VALUES (1313, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.174', 1597887277);
INSERT INTO `cd_log` VALUES (1314, 181, '薛', '用户登录', '113.200.160.161', 1597888225);
INSERT INTO `cd_log` VALUES (1315, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.126', 1597903267);
INSERT INTO `cd_log` VALUES (1316, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.226', 1597906833);
INSERT INTO `cd_log` VALUES (1317, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.226', 1597915802);
INSERT INTO `cd_log` VALUES (1318, 1, 'admin', '用户登录', '111.121.41.140', 1597934485);
INSERT INTO `cd_log` VALUES (1319, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.126', 1597976478);
INSERT INTO `cd_log` VALUES (1320, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.226', 1597987700);
INSERT INTO `cd_log` VALUES (1321, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.174', 1597990818);
INSERT INTO `cd_log` VALUES (1322, 149, 'wfs', '用户登录', '223.104.191.116', 1597995319);
INSERT INTO `cd_log` VALUES (1323, 181, '薛', '用户登录', '113.200.160.161', 1597999407);
INSERT INTO `cd_log` VALUES (1324, 140, '24h至酷智能无人超市', '用户登录', '116.27.203.70', 1598001510);
INSERT INTO `cd_log` VALUES (1325, 133, '至酷智能商店', '用户登录', '116.27.203.70', 1598001641);
INSERT INTO `cd_log` VALUES (1326, 1, 'admin', '用户登录', '111.121.10.231', 1598002246);
INSERT INTO `cd_log` VALUES (1327, 149, 'wfs', '用户登录', '223.104.191.116', 1598002796);
INSERT INTO `cd_log` VALUES (1328, 178, '名都花园港城驿站', '用户登录', '117.82.72.243', 1598017308);
INSERT INTO `cd_log` VALUES (1329, 83, '01', '用户登录', '42.48.113.242', 1598068732);
INSERT INTO `cd_log` VALUES (1330, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.226', 1598078430);
INSERT INTO `cd_log` VALUES (1331, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.174', 1598086445);
INSERT INTO `cd_log` VALUES (1332, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.111', 1598092914);
INSERT INTO `cd_log` VALUES (1333, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.174', 1598094486);
INSERT INTO `cd_log` VALUES (1334, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.174', 1598096260);
INSERT INTO `cd_log` VALUES (1335, 1, 'admin', '用户登录', '111.121.10.231', 1598106072);
INSERT INTO `cd_log` VALUES (1336, 1, 'admin', '用户登录', '111.121.10.231', 1598115498);
INSERT INTO `cd_log` VALUES (1337, 1, 'admin', '用户登录', '111.121.10.231', 1598117955);
INSERT INTO `cd_log` VALUES (1338, 138, 'duanxy', '用户登录', '111.121.10.231', 1598118166);
INSERT INTO `cd_log` VALUES (1339, 1, 'admin', '用户登录', '111.121.10.231', 1598118220);
INSERT INTO `cd_log` VALUES (1340, 133, '至酷智能商店', '用户登录', '117.188.20.168', 1598152942);
INSERT INTO `cd_log` VALUES (1341, 100, 'liwang', '用户登录', '117.188.20.168', 1598153028);
INSERT INTO `cd_log` VALUES (1342, 149, 'wfs', '用户登录', '223.104.192.50', 1598161257);
INSERT INTO `cd_log` VALUES (1343, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.174', 1598162520);
INSERT INTO `cd_log` VALUES (1344, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.111', 1598171335);
INSERT INTO `cd_log` VALUES (1345, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.137', 1598172580);
INSERT INTO `cd_log` VALUES (1346, 149, 'wfs', '用户登录', '117.136.93.226', 1598174746);
INSERT INTO `cd_log` VALUES (1347, 1, 'admin', '用户登录', '111.121.9.250', 1598191667);
INSERT INTO `cd_log` VALUES (1348, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.174', 1598236421);
INSERT INTO `cd_log` VALUES (1349, 149, 'wfs', '用户登录', '117.136.93.226', 1598243568);
INSERT INTO `cd_log` VALUES (1350, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.137', 1598254048);
INSERT INTO `cd_log` VALUES (1351, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.111', 1598260531);
INSERT INTO `cd_log` VALUES (1352, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.174', 1598267885);
INSERT INTO `cd_log` VALUES (1353, 148, 'cxf123412', '用户登录', '113.88.4.197', 1598272979);
INSERT INTO `cd_log` VALUES (1354, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.174', 1598275358);
INSERT INTO `cd_log` VALUES (1355, 184, 'jxs', '用户登录', '117.173.227.116', 1598291276);
INSERT INTO `cd_log` VALUES (1356, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.137', 1598320370);
INSERT INTO `cd_log` VALUES (1357, 83, '01', '用户登录', '42.48.113.242', 1598321302);
INSERT INTO `cd_log` VALUES (1358, 1, 'admin', '用户登录', '117.188.2.153', 1598324680);
INSERT INTO `cd_log` VALUES (1359, 125, '18910830057', '用户登录', '61.135.39.195', 1598325127);
INSERT INTO `cd_log` VALUES (1360, 181, '薛', '用户登录', '123.139.156.2', 1598326912);
INSERT INTO `cd_log` VALUES (1361, 176, '郭晓宁', '用户登录', '112.96.179.144', 1598329342);
INSERT INTO `cd_log` VALUES (1362, 96, 'ytk', '用户登录', '222.186.101.241', 1598331564);
INSERT INTO `cd_log` VALUES (1363, 133, '至酷智能商店', '用户登录', '14.126.228.16', 1598346231);
INSERT INTO `cd_log` VALUES (1364, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.82', 1598350639);
INSERT INTO `cd_log` VALUES (1365, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.232', 1598356795);
INSERT INTO `cd_log` VALUES (1366, 1, 'admin', '用户登录', '111.121.41.50', 1598403351);
INSERT INTO `cd_log` VALUES (1367, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.82', 1598407712);
INSERT INTO `cd_log` VALUES (1368, 172, '17505919990', '用户登录', '112.51.17.101', 1598408700);
INSERT INTO `cd_log` VALUES (1369, 172, '17505919990', '用户登录', '112.51.17.101', 1598408753);
INSERT INTO `cd_log` VALUES (1370, 172, '17505919990', '用户登录', '112.51.17.101', 1598408847);
INSERT INTO `cd_log` VALUES (1371, 50, 'lwang', '用户登录', '117.188.7.52', 1598423185);
INSERT INTO `cd_log` VALUES (1372, 133, '至酷智能商店', '用户登录', '117.188.7.52', 1598424696);
INSERT INTO `cd_log` VALUES (1373, 1, 'admin', '用户登录', '117.188.7.52', 1598424872);
INSERT INTO `cd_log` VALUES (1374, 133, '至酷智能商店', '用户登录', '117.188.7.52', 1598425258);
INSERT INTO `cd_log` VALUES (1375, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.232', 1598426623);
INSERT INTO `cd_log` VALUES (1376, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.72', 1598427385);
INSERT INTO `cd_log` VALUES (1377, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.72', 1598454874);
INSERT INTO `cd_log` VALUES (1378, 1, 'admin', '用户登录', '111.121.41.50', 1598456043);
INSERT INTO `cd_log` VALUES (1379, 172, '17505919990', '用户登录', '61.241.204.32', 1598458110);
INSERT INTO `cd_log` VALUES (1380, 185, 'fenglyshop', '用户登录', '117.91.98.131', 1598494666);
INSERT INTO `cd_log` VALUES (1381, 185, 'fenglyshop', '用户登录', '112.3.144.48', 1598496446);
INSERT INTO `cd_log` VALUES (1382, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.232', 1598509423);
INSERT INTO `cd_log` VALUES (1383, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.82', 1598516361);
INSERT INTO `cd_log` VALUES (1384, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.72', 1598521203);
INSERT INTO `cd_log` VALUES (1385, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.82', 1598521644);
INSERT INTO `cd_log` VALUES (1386, 181, '薛', '用户登录', '36.40.235.141', 1598587007);
INSERT INTO `cd_log` VALUES (1387, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.232', 1598592834);
INSERT INTO `cd_log` VALUES (1388, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.41', 1598593086);
INSERT INTO `cd_log` VALUES (1389, 133, '至酷智能商店', '用户登录', '116.27.200.82', 1598596149);
INSERT INTO `cd_log` VALUES (1390, 187, '746997', '用户登录', '113.139.121.126', 1598599894);
INSERT INTO `cd_log` VALUES (1391, 172, '17505919990', '用户登录', '112.51.17.101', 1598600939);
INSERT INTO `cd_log` VALUES (1392, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.72', 1598606508);
INSERT INTO `cd_log` VALUES (1393, 188, 'fsq0311', '用户登录', '106.113.7.115', 1598628846);
INSERT INTO `cd_log` VALUES (1394, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.41', 1598669944);
INSERT INTO `cd_log` VALUES (1395, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.215', 1598672835);
INSERT INTO `cd_log` VALUES (1396, 1, 'admin', '用户登录', '117.188.7.52', 1598678967);
INSERT INTO `cd_log` VALUES (1397, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.215', 1598681222);
INSERT INTO `cd_log` VALUES (1398, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.232', 1598685251);
INSERT INTO `cd_log` VALUES (1399, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.41', 1598691115);
INSERT INTO `cd_log` VALUES (1400, 188, 'fsq0311', '用户登录', '106.113.7.115', 1598706460);
INSERT INTO `cd_log` VALUES (1401, 172, '17505919990', '用户登录', '112.51.16.67', 1598706820);
INSERT INTO `cd_log` VALUES (1402, 172, '17505919990', '用户登录', '61.241.204.32', 1598726763);
INSERT INTO `cd_log` VALUES (1403, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.41', 1598758562);
INSERT INTO `cd_log` VALUES (1404, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.215', 1598777181);
INSERT INTO `cd_log` VALUES (1405, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.230', 1598777190);
INSERT INTO `cd_log` VALUES (1406, 188, 'fsq0311', '用户登录', '106.113.7.115', 1598790762);
INSERT INTO `cd_log` VALUES (1407, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.215', 1598841852);
INSERT INTO `cd_log` VALUES (1408, 172, '17505919990', '用户登录', '112.51.16.67', 1598842456);
INSERT INTO `cd_log` VALUES (1409, 1, 'admin', '用户登录', '117.188.7.52', 1598847476);
INSERT INTO `cd_log` VALUES (1410, 112, '巴帝洛克新厂店', '用户登录', '182.86.165.13', 1598849071);
INSERT INTO `cd_log` VALUES (1411, 133, '至酷智能商店', '用户登录', '117.188.7.52', 1598858806);
INSERT INTO `cd_log` VALUES (1412, 100, 'liwang', '用户登录', '117.188.7.52', 1598858859);
INSERT INTO `cd_log` VALUES (1413, 50, 'lwang', '用户登录', '117.188.7.52', 1598858894);
INSERT INTO `cd_log` VALUES (1414, 181, '薛', '用户登录', '36.40.234.0', 1598865005);
INSERT INTO `cd_log` VALUES (1415, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.230', 1598867098);
INSERT INTO `cd_log` VALUES (1416, 112, '巴帝洛克新厂店', '用户登录', '182.86.165.13', 1598937956);
INSERT INTO `cd_log` VALUES (1417, 149, 'wfs', '用户登录', '123.196.12.74', 1598940248);
INSERT INTO `cd_log` VALUES (1418, 172, '17505919990', '用户登录', '112.51.16.67', 1598945558);
INSERT INTO `cd_log` VALUES (1419, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.230', 1598945629);
INSERT INTO `cd_log` VALUES (1420, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.150', 1598945855);
INSERT INTO `cd_log` VALUES (1421, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.230', 1598959908);
INSERT INTO `cd_log` VALUES (1422, 192, '14491255', '用户登录', '120.239.162.20', 1598963048);
INSERT INTO `cd_log` VALUES (1423, 50, 'lwang', '用户登录', '117.188.8.65', 1599015960);
INSERT INTO `cd_log` VALUES (1424, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.173', 1599027616);
INSERT INTO `cd_log` VALUES (1425, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.150', 1599027781);
INSERT INTO `cd_log` VALUES (1426, 112, '巴帝洛克新厂店', '用户登录', '182.86.165.13', 1599027853);
INSERT INTO `cd_log` VALUES (1427, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.173', 1599029671);
INSERT INTO `cd_log` VALUES (1428, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.173', 1599039291);
INSERT INTO `cd_log` VALUES (1429, 120, 'tianwen', '用户登录', '60.6.217.200', 1599099799);
INSERT INTO `cd_log` VALUES (1430, 120, 'tianwen', '用户登录', '60.6.217.200', 1599099936);
INSERT INTO `cd_log` VALUES (1431, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.150', 1599111015);
INSERT INTO `cd_log` VALUES (1432, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.122', 1599111362);
INSERT INTO `cd_log` VALUES (1433, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.173', 1599111467);
INSERT INTO `cd_log` VALUES (1434, 172, '17505919990', '用户登录', '112.51.16.67', 1599116763);
INSERT INTO `cd_log` VALUES (1435, 1, 'admin', '用户登录', '111.121.45.166', 1599133984);
INSERT INTO `cd_log` VALUES (1436, 120, 'tianwen', '用户登录', '60.6.217.200', 1599141732);
INSERT INTO `cd_log` VALUES (1437, 1, 'admin', '用户登录', '111.121.45.166', 1599142509);
INSERT INTO `cd_log` VALUES (1438, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.122', 1599200342);
INSERT INTO `cd_log` VALUES (1439, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.122', 1599201022);
INSERT INTO `cd_log` VALUES (1440, 1, 'admin', '用户登录', '117.188.8.65', 1599214947);
INSERT INTO `cd_log` VALUES (1441, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.130', 1599215271);
INSERT INTO `cd_log` VALUES (1442, 133, '至酷智能商店', '用户登录', '116.27.202.251', 1599217628);
INSERT INTO `cd_log` VALUES (1443, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.173', 1599218786);
INSERT INTO `cd_log` VALUES (1444, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.122', 1599219118);
INSERT INTO `cd_log` VALUES (1445, 1, 'admin', '用户登录', '111.121.13.190', 1599232014);
INSERT INTO `cd_log` VALUES (1446, 195, '18083822472', '用户登录', '106.57.122.185', 1599275619);
INSERT INTO `cd_log` VALUES (1447, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.130', 1599283942);
INSERT INTO `cd_log` VALUES (1448, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.236', 1599297044);
INSERT INTO `cd_log` VALUES (1449, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.28', 1599300968);
INSERT INTO `cd_log` VALUES (1450, 172, '17505919990', '用户登录', '61.241.204.32', 1599315346);
INSERT INTO `cd_log` VALUES (1451, 120, 'tianwen', '用户登录', '120.14.196.230', 1599349351);
INSERT INTO `cd_log` VALUES (1452, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.236', 1599369691);
INSERT INTO `cd_log` VALUES (1453, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.130', 1599370208);
INSERT INTO `cd_log` VALUES (1454, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.28', 1599371141);
INSERT INTO `cd_log` VALUES (1455, 63, '劉睿兄弟', '用户登录', '124.160.215.246', 1599371964);
INSERT INTO `cd_log` VALUES (1456, 181, '薛', '用户登录', '123.139.156.2', 1599444142);
INSERT INTO `cd_log` VALUES (1457, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.156', 1599446774);
INSERT INTO `cd_log` VALUES (1458, 172, '17505919990', '用户登录', '112.51.16.128', 1599449185);
INSERT INTO `cd_log` VALUES (1459, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.236', 1599456531);
INSERT INTO `cd_log` VALUES (1460, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.156', 1599457075);
INSERT INTO `cd_log` VALUES (1461, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.28', 1599462632);
INSERT INTO `cd_log` VALUES (1462, 149, 'wfs', '用户登录', '123.196.12.25', 1599463281);
INSERT INTO `cd_log` VALUES (1463, 1, 'admin', '用户登录', '117.188.8.65', 1599473679);
INSERT INTO `cd_log` VALUES (1464, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.236', 1599532858);
INSERT INTO `cd_log` VALUES (1465, 149, 'wfs', '用户登录', '123.196.12.25', 1599539912);
INSERT INTO `cd_log` VALUES (1466, 149, 'wfs', '用户登录', '123.196.12.25', 1599547300);
INSERT INTO `cd_log` VALUES (1467, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.122', 1599549272);
INSERT INTO `cd_log` VALUES (1468, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.156', 1599551186);
INSERT INTO `cd_log` VALUES (1469, 133, '至酷智能商店', '用户登录', '14.126.230.201', 1599563109);
INSERT INTO `cd_log` VALUES (1470, 178, '名都花园港城驿站', '用户登录', '180.106.94.130', 1599566803);
INSERT INTO `cd_log` VALUES (1471, 63, '劉睿兄弟', '用户登录', '39.184.60.109', 1599570103);
INSERT INTO `cd_log` VALUES (1472, 1, 'admin', '用户登录', '111.121.8.60', 1599611736);
INSERT INTO `cd_log` VALUES (1473, 146, 'matai112', '用户登录', '106.121.4.207', 1599617125);
INSERT INTO `cd_log` VALUES (1474, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.122', 1599619418);
INSERT INTO `cd_log` VALUES (1475, 120, 'tianwen', '用户登录', '223.104.102.59', 1599620946);
INSERT INTO `cd_log` VALUES (1476, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.7', 1599621828);
INSERT INTO `cd_log` VALUES (1477, 172, '17505919990', '用户登录', '112.51.16.128', 1599629472);
INSERT INTO `cd_log` VALUES (1478, 172, '17505919990', '用户登录', '112.51.16.128', 1599629966);
INSERT INTO `cd_log` VALUES (1479, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.156', 1599633867);
INSERT INTO `cd_log` VALUES (1480, 133, '至酷智能商店', '用户登录', '116.27.200.56', 1599655437);
INSERT INTO `cd_log` VALUES (1481, 198, 'pengzq_168', '用户登录', '223.72.96.145', 1599661993);
INSERT INTO `cd_log` VALUES (1482, 122, '巴帝洛克金鼎店', '用户登录', '111.73.169.252', 1599718794);
INSERT INTO `cd_log` VALUES (1483, 199, 'weixin123456', '用户登录', '103.216.43.182', 1599719026);
INSERT INTO `cd_log` VALUES (1484, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.7', 1599723177);
INSERT INTO `cd_log` VALUES (1485, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.122', 1599728708);
INSERT INTO `cd_log` VALUES (1486, 1, 'admin', '用户登录', '111.121.42.137', 1599785102);
INSERT INTO `cd_log` VALUES (1487, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.7', 1599789940);
INSERT INTO `cd_log` VALUES (1488, 149, 'wfs', '用户登录', '123.196.12.25', 1599794623);
INSERT INTO `cd_log` VALUES (1489, 172, '17505919990', '用户登录', '112.51.23.206', 1599795306);
INSERT INTO `cd_log` VALUES (1490, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.151', 1599803259);
INSERT INTO `cd_log` VALUES (1491, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.22', 1599805837);
INSERT INTO `cd_log` VALUES (1492, 1, 'admin', '用户登录', '117.188.12.68', 1599808525);
INSERT INTO `cd_log` VALUES (1493, 50, 'lwang', '用户登录', '117.188.12.68', 1599816061);
INSERT INTO `cd_log` VALUES (1494, 100, 'liwang', '用户登录', '117.188.12.68', 1599816229);
INSERT INTO `cd_log` VALUES (1495, 50, 'lwang', '用户登录', '117.188.12.68', 1599816298);
INSERT INTO `cd_log` VALUES (1496, 50, 'lwang', '用户登录', '117.188.12.68', 1599816334);
INSERT INTO `cd_log` VALUES (1497, 198, 'pengzq_168', '用户登录', '123.113.248.247', 1599875278);
INSERT INTO `cd_log` VALUES (1498, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.253', 1599875958);
INSERT INTO `cd_log` VALUES (1499, 1, 'admin', '用户登录', '220.197.205.58', 1599883875);
INSERT INTO `cd_log` VALUES (1500, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.22', 1599895868);
INSERT INTO `cd_log` VALUES (1501, 133, '至酷智能商店', '用户登录', '14.126.229.13', 1599911540);
INSERT INTO `cd_log` VALUES (1502, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.151', 1599912504);
INSERT INTO `cd_log` VALUES (1503, 172, '17505919990', '用户登录', '112.51.23.206', 1599920332);
INSERT INTO `cd_log` VALUES (1504, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.253', 1599963209);
INSERT INTO `cd_log` VALUES (1505, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.151', 1599979304);
INSERT INTO `cd_log` VALUES (1506, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.22', 1599979741);
INSERT INTO `cd_log` VALUES (1507, 133, '至酷智能商店', '用户登录', '116.27.200.168', 1599989302);
INSERT INTO `cd_log` VALUES (1508, 193, '影子烘焙', '用户登录', '119.120.170.244', 1599990571);
INSERT INTO `cd_log` VALUES (1509, 50, 'lwang', '用户登录', '117.188.12.68', 1599996840);
INSERT INTO `cd_log` VALUES (1510, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.173', 1599999774);
INSERT INTO `cd_log` VALUES (1511, 1, 'admin', '用户登录', '111.121.15.123', 1600005362);
INSERT INTO `cd_log` VALUES (1512, 173, 'yixiang', '用户登录', '222.210.145.149', 1600006901);
INSERT INTO `cd_log` VALUES (1513, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.173', 1600055462);
INSERT INTO `cd_log` VALUES (1514, 133, '至酷智能商店', '用户登录', '14.126.228.61', 1600063327);
INSERT INTO `cd_log` VALUES (1515, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.80', 1600064696);
INSERT INTO `cd_log` VALUES (1516, 198, 'pengzq_168', '用户登录', '223.104.3.47', 1600068237);
INSERT INTO `cd_log` VALUES (1517, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.8', 1600068383);
INSERT INTO `cd_log` VALUES (1518, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.173', 1600080077);
INSERT INTO `cd_log` VALUES (1519, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.173', 1600090087);
INSERT INTO `cd_log` VALUES (1520, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.80', 1600135475);
INSERT INTO `cd_log` VALUES (1521, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.173', 1600156861);
INSERT INTO `cd_log` VALUES (1522, 202, 'silencelam', '用户登录', '183.6.26.146', 1600158724);
INSERT INTO `cd_log` VALUES (1523, 202, 'silencelam', '用户登录', '183.6.26.146', 1600158812);
INSERT INTO `cd_log` VALUES (1524, 202, 'silencelam', '用户登录', '183.6.26.146', 1600159104);
INSERT INTO `cd_log` VALUES (1525, 202, 'silencelam', '用户登录', '113.111.44.13', 1600159370);
INSERT INTO `cd_log` VALUES (1526, 194, '123', '用户登录', '116.1.76.188', 1600162221);
INSERT INTO `cd_log` VALUES (1527, 178, '名都花园港城驿站', '用户登录', '180.106.95.182', 1600165311);
INSERT INTO `cd_log` VALUES (1528, 50, 'lwang', '用户登录', '117.188.12.68', 1600166771);
INSERT INTO `cd_log` VALUES (1529, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.8', 1600168131);
INSERT INTO `cd_log` VALUES (1530, 1, 'admin', '用户登录', '223.104.96.40', 1600227494);
INSERT INTO `cd_log` VALUES (1531, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.173', 1600234205);
INSERT INTO `cd_log` VALUES (1532, 1, 'admin', '用户登录', '58.42.250.116', 1600240085);
INSERT INTO `cd_log` VALUES (1533, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.8', 1600240279);
INSERT INTO `cd_log` VALUES (1534, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.80', 1600244487);
INSERT INTO `cd_log` VALUES (1535, 204, 'jinxch', '用户登录', '112.25.205.194', 1600249398);
INSERT INTO `cd_log` VALUES (1536, 204, 'jinxch', '用户登录', '112.25.205.194', 1600249985);
INSERT INTO `cd_log` VALUES (1537, 204, 'jinxch', '用户登录', '112.25.205.194', 1600250996);
INSERT INTO `cd_log` VALUES (1538, 204, 'jinxch', '用户登录', '223.104.147.6', 1600254552);
INSERT INTO `cd_log` VALUES (1539, 122, '巴帝洛克金鼎店', '用户登录', '111.73.171.116', 1600262171);
INSERT INTO `cd_log` VALUES (1540, 193, '影子烘焙', '用户登录', '14.114.208.44', 1600316449);
INSERT INTO `cd_log` VALUES (1541, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.8', 1600320728);
INSERT INTO `cd_log` VALUES (1542, 204, 'jinxch', '用户登录', '112.25.205.194', 1600321544);
INSERT INTO `cd_log` VALUES (1543, 122, '巴帝洛克金鼎店', '用户登录', '111.73.171.116', 1600335377);
INSERT INTO `cd_log` VALUES (1544, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.118', 1600338096);
INSERT INTO `cd_log` VALUES (1545, 206, '小马驹', '用户登录', '125.70.178.208', 1600339180);
INSERT INTO `cd_log` VALUES (1546, 206, '小马驹', '用户登录', '222.211.237.166', 1600355506);
INSERT INTO `cd_log` VALUES (1547, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.31', 1600406387);
INSERT INTO `cd_log` VALUES (1548, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.118', 1600407543);
INSERT INTO `cd_log` VALUES (1549, 122, '巴帝洛克金鼎店', '用户登录', '111.73.171.116', 1600415636);
INSERT INTO `cd_log` VALUES (1550, 1, 'admin', '用户登录', '111.121.46.252', 1600435200);
INSERT INTO `cd_log` VALUES (1551, 1, 'admin', '用户登录', '111.121.46.252', 1600439832);
INSERT INTO `cd_log` VALUES (1552, 206, '小马驹', '用户登录', '182.148.57.86', 1600493886);
INSERT INTO `cd_log` VALUES (1553, 207, 'susu', '用户登录', '27.38.12.22', 1600496016);
INSERT INTO `cd_log` VALUES (1554, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.31', 1600501738);
INSERT INTO `cd_log` VALUES (1555, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.182', 1600502869);
INSERT INTO `cd_log` VALUES (1556, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.118', 1600502936);
INSERT INTO `cd_log` VALUES (1557, 133, '至酷智能商店', '用户登录', '116.27.203.117', 1600513426);
INSERT INTO `cd_log` VALUES (1558, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.31', 1600567751);
INSERT INTO `cd_log` VALUES (1559, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.182', 1600579428);
INSERT INTO `cd_log` VALUES (1560, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.182', 1600593952);
INSERT INTO `cd_log` VALUES (1561, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.4', 1600601960);
INSERT INTO `cd_log` VALUES (1562, 194, '123', '用户登录', '117.140.72.103', 1600604262);
INSERT INTO `cd_log` VALUES (1563, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.182', 1600604547);
INSERT INTO `cd_log` VALUES (1564, 207, 'susu', '用户登录', '27.38.12.22', 1600652574);
INSERT INTO `cd_log` VALUES (1565, 204, 'jinxch', '用户登录', '117.136.19.85', 1600658253);
INSERT INTO `cd_log` VALUES (1566, 1, 'admin', '用户登录', '117.188.26.206', 1600663047);
INSERT INTO `cd_log` VALUES (1567, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.182', 1600667547);
INSERT INTO `cd_log` VALUES (1568, 149, 'wfs', '用户登录', '123.196.12.25', 1600671124);
INSERT INTO `cd_log` VALUES (1569, 208, '阿贝尼', '用户登录', '117.186.143.166', 1600679179);
INSERT INTO `cd_log` VALUES (1570, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.26', 1600680586);
INSERT INTO `cd_log` VALUES (1571, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.4', 1600688321);
INSERT INTO `cd_log` VALUES (1572, 112, '巴帝洛克新厂店', '用户登录', '182.86.163.26', 1600695480);
INSERT INTO `cd_log` VALUES (1573, 51, '增小贩无人超市', '用户登录', '221.15.120.182', 1600748816);
INSERT INTO `cd_log` VALUES (1574, 51, '增小贩无人超市', '用户登录', '221.15.120.182', 1600749431);
INSERT INTO `cd_log` VALUES (1575, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.4', 1600753569);
INSERT INTO `cd_log` VALUES (1576, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.182', 1600753601);
INSERT INTO `cd_log` VALUES (1577, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.114', 1600753842);
INSERT INTO `cd_log` VALUES (1578, 194, '123', '用户登录', '180.140.212.96', 1600772263);
INSERT INTO `cd_log` VALUES (1579, 209, 'fjc6036', '用户登录', '116.20.236.182', 1600785359);
INSERT INTO `cd_log` VALUES (1580, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.114', 1600826680);
INSERT INTO `cd_log` VALUES (1581, 209, 'fjc6036', '用户登录', '120.87.121.66', 1600833798);
INSERT INTO `cd_log` VALUES (1582, 210, 'wshwye', '用户登录', '220.195.65.243', 1600834620);
INSERT INTO `cd_log` VALUES (1583, 210, 'wshwye', '用户登录', '220.195.65.243', 1600835254);
INSERT INTO `cd_log` VALUES (1584, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.73', 1600839112);
INSERT INTO `cd_log` VALUES (1585, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.33', 1600840776);
INSERT INTO `cd_log` VALUES (1586, 210, 'wshwye', '用户登录', '139.214.244.135', 1600843570);
INSERT INTO `cd_log` VALUES (1587, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.73', 1600846305);
INSERT INTO `cd_log` VALUES (1588, 112, '巴帝洛克新厂店', '用户登录', '182.86.130.114', 1600912749);
INSERT INTO `cd_log` VALUES (1589, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.73', 1600933842);
INSERT INTO `cd_log` VALUES (1590, 50, 'lwang', '用户登录', '117.188.26.206', 1600936897);
INSERT INTO `cd_log` VALUES (1591, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.33', 1600941060);
INSERT INTO `cd_log` VALUES (1592, 83, '01', '用户登录', '42.48.113.242', 1600943257);
INSERT INTO `cd_log` VALUES (1593, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.73', 1600997584);
INSERT INTO `cd_log` VALUES (1594, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.198', 1600999162);
INSERT INTO `cd_log` VALUES (1595, 51, '增小贩无人超市', '用户登录', '61.158.146.138', 1601003801);
INSERT INTO `cd_log` VALUES (1596, 1, 'admin', '用户登录', '117.188.26.206', 1601013007);
INSERT INTO `cd_log` VALUES (1597, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.91', 1601019850);
INSERT INTO `cd_log` VALUES (1598, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.73', 1601022205);
INSERT INTO `cd_log` VALUES (1599, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.198', 1601025724);
INSERT INTO `cd_log` VALUES (1600, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.73', 1601026767);
INSERT INTO `cd_log` VALUES (1601, 1, 'admin', '用户登录', '111.121.40.59', 1601082883);
INSERT INTO `cd_log` VALUES (1602, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.198', 1601085837);
INSERT INTO `cd_log` VALUES (1603, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.91', 1601104878);
INSERT INTO `cd_log` VALUES (1604, 1, 'admin', '用户登录', '117.188.19.26', 1601105678);
INSERT INTO `cd_log` VALUES (1605, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.42', 1601106658);
INSERT INTO `cd_log` VALUES (1606, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.91', 1601111657);
INSERT INTO `cd_log` VALUES (1607, 206, '小马驹', '用户登录', '125.70.194.220', 1601128862);
INSERT INTO `cd_log` VALUES (1608, 1, 'admin', '用户登录', '111.121.9.129', 1601136172);
INSERT INTO `cd_log` VALUES (1609, 211, 'xiaoxia', '用户登录', '27.156.190.182', 1601168236);
INSERT INTO `cd_log` VALUES (1610, 112, '巴帝洛克新厂店', '用户登录', '182.86.162.198', 1601172337);
INSERT INTO `cd_log` VALUES (1611, 51, '增小贩无人超市', '用户登录', '61.158.147.129', 1601174160);
INSERT INTO `cd_log` VALUES (1612, 206, '小马驹', '用户登录', '125.70.194.220', 1601179776);
INSERT INTO `cd_log` VALUES (1613, 206, '小马驹', '用户登录', '125.70.194.220', 1601181320);
INSERT INTO `cd_log` VALUES (1614, 212, 'dd', '用户登录', '115.214.105.241', 1601184984);
INSERT INTO `cd_log` VALUES (1615, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.91', 1601186288);
INSERT INTO `cd_log` VALUES (1616, 149, 'wfs', '用户登录', '123.196.12.25', 1601193651);
INSERT INTO `cd_log` VALUES (1617, 1, 'admin', '用户登录', '117.188.19.26', 1601195821);
INSERT INTO `cd_log` VALUES (1618, 172, '17505919990', '用户登录', '112.51.16.156', 1601199249);
INSERT INTO `cd_log` VALUES (1619, 206, '小马驹', '用户登录', '125.70.78.44', 1601202099);
INSERT INTO `cd_log` VALUES (1620, 172, '17505919990', '用户登录', '112.51.16.156', 1601208218);
INSERT INTO `cd_log` VALUES (1621, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.191', 1601211571);
INSERT INTO `cd_log` VALUES (1622, 1, 'admin', '用户登录', '111.121.9.129', 1601217295);
INSERT INTO `cd_log` VALUES (1623, 172, '17505919990', '用户登录', '61.241.204.132', 1601227947);
INSERT INTO `cd_log` VALUES (1624, 172, '17505919990', '用户登录', '61.241.204.132', 1601228152);
INSERT INTO `cd_log` VALUES (1625, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.70', 1601258948);
INSERT INTO `cd_log` VALUES (1626, 1, 'admin', '用户登录', '117.188.29.38', 1601261195);
INSERT INTO `cd_log` VALUES (1627, 206, '小马驹', '用户登录', '125.70.194.220', 1601261334);
INSERT INTO `cd_log` VALUES (1628, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.91', 1601265706);
INSERT INTO `cd_log` VALUES (1629, 206, '小马驹', '用户登录', '125.70.194.220', 1601267595);
INSERT INTO `cd_log` VALUES (1630, 149, 'wfs', '用户登录', '123.196.12.25', 1601272387);
INSERT INTO `cd_log` VALUES (1631, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.191', 1601274922);
INSERT INTO `cd_log` VALUES (1632, 206, '小马驹', '用户登录', '182.150.112.119', 1601278100);
INSERT INTO `cd_log` VALUES (1633, 1, 'admin', '用户登录', '117.188.29.38', 1601346913);
INSERT INTO `cd_log` VALUES (1634, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.34', 1601352461);
INSERT INTO `cd_log` VALUES (1635, 172, '17505919990', '用户登录', '112.51.23.106', 1601355939);
INSERT INTO `cd_log` VALUES (1636, 112, '巴帝洛克新厂店', '用户登录', '111.73.177.70', 1601357509);
INSERT INTO `cd_log` VALUES (1637, 149, 'wfs', '用户登录', '123.196.12.25', 1601367458);
INSERT INTO `cd_log` VALUES (1638, 172, '17505919990', '用户登录', '112.51.23.106', 1601372174);
INSERT INTO `cd_log` VALUES (1639, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.191', 1601375515);
INSERT INTO `cd_log` VALUES (1640, 1, 'admin', '用户登录', '111.121.8.206', 1601385853);
INSERT INTO `cd_log` VALUES (1641, 51, '增小贩无人超市', '用户登录', '61.158.146.229', 1601435218);
INSERT INTO `cd_log` VALUES (1642, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.34', 1601443406);
INSERT INTO `cd_log` VALUES (1643, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.191', 1601445917);
INSERT INTO `cd_log` VALUES (1644, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.244', 1601468382);
INSERT INTO `cd_log` VALUES (1645, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.244', 1601471314);
INSERT INTO `cd_log` VALUES (1646, 178, '名都花园港城驿站', '用户登录', '180.106.92.72', 1601555091);
INSERT INTO `cd_log` VALUES (1647, 96, 'ytk', '用户登录', '222.186.101.241', 1601560665);
INSERT INTO `cd_log` VALUES (1648, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.45', 1601777045);
INSERT INTO `cd_log` VALUES (1649, 149, 'wfs', '用户登录', '123.196.12.216', 1601802150);
INSERT INTO `cd_log` VALUES (1650, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.112', 1601811650);
INSERT INTO `cd_log` VALUES (1651, 1, 'admin', '用户登录', '111.121.44.16', 1601814005);
INSERT INTO `cd_log` VALUES (1652, 213, 'kent', '用户登录', '39.144.4.43', 1601818250);
INSERT INTO `cd_log` VALUES (1653, 1, 'admin', '用户登录', '111.121.44.16', 1601866455);
INSERT INTO `cd_log` VALUES (1654, 83, '01', '用户登录', '42.48.113.242', 1601869310);
INSERT INTO `cd_log` VALUES (1655, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.45', 1601869341);
INSERT INTO `cd_log` VALUES (1656, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.112', 1601873612);
INSERT INTO `cd_log` VALUES (1657, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.45', 1601947956);
INSERT INTO `cd_log` VALUES (1658, 112, '巴帝洛克新厂店', '用户登录', '182.86.167.152', 1601949818);
INSERT INTO `cd_log` VALUES (1659, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.112', 1601965234);
INSERT INTO `cd_log` VALUES (1660, 216, 'chen', '用户登录', '115.214.104.22', 1601987417);
INSERT INTO `cd_log` VALUES (1661, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.153', 1602037885);
INSERT INTO `cd_log` VALUES (1662, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.30', 1602048545);
INSERT INTO `cd_log` VALUES (1663, 216, 'chen', '用户登录', '115.214.104.22', 1602051942);
INSERT INTO `cd_log` VALUES (1664, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.30', 1602068136);
INSERT INTO `cd_log` VALUES (1665, 172, '17505919990', '用户登录', '61.241.204.134', 1602100667);
INSERT INTO `cd_log` VALUES (1666, 213, 'kent', '用户登录', '39.144.4.43', 1602128889);
INSERT INTO `cd_log` VALUES (1667, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.30', 1602140420);
INSERT INTO `cd_log` VALUES (1668, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.153', 1602142583);
INSERT INTO `cd_log` VALUES (1669, 149, 'wfs', '用户登录', '223.104.191.9', 1602148045);
INSERT INTO `cd_log` VALUES (1670, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.119', 1602155734);
INSERT INTO `cd_log` VALUES (1671, 172, '17505919990', '用户登录', '112.51.16.93', 1602158849);
INSERT INTO `cd_log` VALUES (1672, 83, '01', '用户登录', '42.48.113.242', 1602203750);
INSERT INTO `cd_log` VALUES (1673, 1, 'admin', '用户登录', '1.49.60.97', 1602211968);
INSERT INTO `cd_log` VALUES (1674, 83, '01', '用户登录', '42.48.113.242', 1602216316);
INSERT INTO `cd_log` VALUES (1675, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.15', 1602223604);
INSERT INTO `cd_log` VALUES (1676, 149, 'wfs', '用户登录', '153.118.11.52', 1602224057);
INSERT INTO `cd_log` VALUES (1677, 1, 'admin', '用户登录', '117.188.5.88', 1602225299);
INSERT INTO `cd_log` VALUES (1678, 215, 'zhahg', '用户登录', '218.86.14.130', 1602226597);
INSERT INTO `cd_log` VALUES (1679, 215, 'zhahg', '用户登录', '218.86.14.130', 1602226945);
INSERT INTO `cd_log` VALUES (1680, 212, 'dd', '用户登录', '115.214.104.22', 1602227158);
INSERT INTO `cd_log` VALUES (1681, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.153', 1602230668);
INSERT INTO `cd_log` VALUES (1682, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.119', 1602235907);
INSERT INTO `cd_log` VALUES (1683, 218, 'Xuyu', '用户登录', '183.252.97.192', 1602244669);
INSERT INTO `cd_log` VALUES (1684, 1, 'admin', '用户登录', '39.144.42.139', 1602246416);
INSERT INTO `cd_log` VALUES (1685, 1, 'admin', '用户登录', '39.144.42.139', 1602246695);
INSERT INTO `cd_log` VALUES (1686, 218, 'xuyu', '用户登录', '183.252.97.192', 1602247834);
INSERT INTO `cd_log` VALUES (1687, 218, 'xuyu', '用户登录', '183.252.97.192', 1602248319);
INSERT INTO `cd_log` VALUES (1688, 218, 'xuyu', '用户登录', '183.252.97.192', 1602255593);
INSERT INTO `cd_log` VALUES (1689, 218, 'xuyu', '用户登录', '183.252.97.192', 1602256063);
INSERT INTO `cd_log` VALUES (1690, 218, 'xuyu', '用户登录', '223.104.48.66', 1602257542);
INSERT INTO `cd_log` VALUES (1691, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.208', 1602301613);
INSERT INTO `cd_log` VALUES (1692, 83, '01', '用户登录', '42.48.113.242', 1602302056);
INSERT INTO `cd_log` VALUES (1693, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.69', 1602309138);
INSERT INTO `cd_log` VALUES (1694, 83, '01', '用户登录', '42.48.113.242', 1602312263);
INSERT INTO `cd_log` VALUES (1695, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.15', 1602312467);
INSERT INTO `cd_log` VALUES (1696, 83, '01', '用户登录', '42.48.113.242', 1602312665);
INSERT INTO `cd_log` VALUES (1697, 149, 'wfs', '用户登录', '223.104.192.194', 1602315901);
INSERT INTO `cd_log` VALUES (1698, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.69', 1602317864);
INSERT INTO `cd_log` VALUES (1699, 216, 'chen', '用户登录', '115.214.104.22', 1602318881);
INSERT INTO `cd_log` VALUES (1700, 202, 'silencelam', '用户登录', '113.111.47.114', 1602321964);
INSERT INTO `cd_log` VALUES (1701, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.15', 1602332346);
INSERT INTO `cd_log` VALUES (1702, 206, '小马驹', '用户登录', '125.70.195.84', 1602337540);
INSERT INTO `cd_log` VALUES (1703, 218, 'xuyu', '用户登录', '218.86.14.130', 1602374293);
INSERT INTO `cd_log` VALUES (1704, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.208', 1602382622);
INSERT INTO `cd_log` VALUES (1705, 149, 'wfs', '用户登录', '223.104.191.82', 1602384829);
INSERT INTO `cd_log` VALUES (1706, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.15', 1602396027);
INSERT INTO `cd_log` VALUES (1707, 51, '增小贩无人超市', '用户登录', '42.239.6.145', 1602398406);
INSERT INTO `cd_log` VALUES (1708, 193, '影子烘焙', '用户登录', '116.7.157.104', 1602400473);
INSERT INTO `cd_log` VALUES (1709, 218, 'xuyu', '用户登录', '223.104.48.35', 1602402302);
INSERT INTO `cd_log` VALUES (1710, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.208', 1602416792);
INSERT INTO `cd_log` VALUES (1711, 96, 'ytk', '用户登录', '222.186.101.241', 1602426742);
INSERT INTO `cd_log` VALUES (1712, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.15', 1602471756);
INSERT INTO `cd_log` VALUES (1713, 149, 'wfs', '用户登录', '223.104.191.82', 1602482178);
INSERT INTO `cd_log` VALUES (1714, 112, '巴帝洛克新厂店', '用户登录', '182.86.160.208', 1602489200);
INSERT INTO `cd_log` VALUES (1715, 216, 'chen', '用户登录', '115.215.41.97', 1602490639);
INSERT INTO `cd_log` VALUES (1716, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.62', 1602493504);
INSERT INTO `cd_log` VALUES (1717, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.69', 1602499868);
INSERT INTO `cd_log` VALUES (1718, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602504471);
INSERT INTO `cd_log` VALUES (1719, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602504781);
INSERT INTO `cd_log` VALUES (1720, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602505206);
INSERT INTO `cd_log` VALUES (1721, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602505621);
INSERT INTO `cd_log` VALUES (1722, 112, '巴帝洛克新厂店', '用户登录', '111.73.176.138', 1602521267);
INSERT INTO `cd_log` VALUES (1723, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.62', 1602554298);
INSERT INTO `cd_log` VALUES (1724, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602572287);
INSERT INTO `cd_log` VALUES (1725, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.62', 1602638906);
INSERT INTO `cd_log` VALUES (1726, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.62', 1602654320);
INSERT INTO `cd_log` VALUES (1727, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602654421);
INSERT INTO `cd_log` VALUES (1728, 149, 'wfs', '用户登录', '113.127.7.198', 1602660002);
INSERT INTO `cd_log` VALUES (1729, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602673257);
INSERT INTO `cd_log` VALUES (1730, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.237', 1602742965);
INSERT INTO `cd_log` VALUES (1731, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.58', 1602743516);
INSERT INTO `cd_log` VALUES (1732, 202, 'silencelam', '用户登录', '113.111.46.154', 1602745668);
INSERT INTO `cd_log` VALUES (1733, 209, 'fjc6036', '用户登录', '27.45.214.74', 1602811176);
INSERT INTO `cd_log` VALUES (1734, 209, 'fjc6036', '用户登录', '116.29.108.140', 1602820138);
INSERT INTO `cd_log` VALUES (1735, 209, 'fjc6036', '用户登录', '113.115.29.207', 1602820353);
INSERT INTO `cd_log` VALUES (1736, 209, 'fjc6036', '用户登录', '116.29.108.140', 1602820953);
INSERT INTO `cd_log` VALUES (1737, 209, 'fjc6036', '用户登录', '116.29.108.140', 1602821070);
INSERT INTO `cd_log` VALUES (1738, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.237', 1602831162);
INSERT INTO `cd_log` VALUES (1739, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.86', 1602832065);
INSERT INTO `cd_log` VALUES (1740, 209, 'fjc6036', '用户登录', '223.104.65.122', 1602834046);
INSERT INTO `cd_log` VALUES (1741, 218, 'xuyu', '用户登录', '112.51.101.56', 1602846721);
INSERT INTO `cd_log` VALUES (1742, 218, 'xuyu', '用户登录', '112.51.101.56', 1602847026);
INSERT INTO `cd_log` VALUES (1743, 210, 'wshwye', '用户登录', '110.6.45.167', 1602853742);
INSERT INTO `cd_log` VALUES (1744, 206, '小马驹', '用户登录', '125.70.195.0', 1602905162);
INSERT INTO `cd_log` VALUES (1745, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.86', 1602925091);
INSERT INTO `cd_log` VALUES (1746, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.237', 1602925184);
INSERT INTO `cd_log` VALUES (1747, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.237', 1602935755);
INSERT INTO `cd_log` VALUES (1748, 223, '哦哦哦', '用户登录', '183.197.19.197', 1602949805);
INSERT INTO `cd_log` VALUES (1749, 223, '哦哦哦', '用户登录', '183.197.23.149', 1602950237);
INSERT INTO `cd_log` VALUES (1750, 83, '01', '用户登录', '42.48.113.242', 1602988607);
INSERT INTO `cd_log` VALUES (1751, 83, '01', '用户登录', '42.48.113.242', 1602989619);
INSERT INTO `cd_log` VALUES (1752, 210, 'wshwye', '用户登录', '220.195.65.25', 1602991677);
INSERT INTO `cd_log` VALUES (1753, 210, 'wshwye', '用户登录', '39.155.44.54', 1602993595);
INSERT INTO `cd_log` VALUES (1754, 209, 'fjc6036', '用户登录', '113.101.238.172', 1602995722);
INSERT INTO `cd_log` VALUES (1755, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.86', 1603000703);
INSERT INTO `cd_log` VALUES (1756, 1, 'admin', '用户登录', '111.121.9.42', 1603007819);
INSERT INTO `cd_log` VALUES (1757, 225, 'maidou', '用户登录', '183.198.1.3', 1603029994);
INSERT INTO `cd_log` VALUES (1758, 225, 'maidou', '用户登录', '183.198.1.3', 1603030881);
INSERT INTO `cd_log` VALUES (1759, 225, 'maidou', '用户登录', '183.198.1.3', 1603030939);
INSERT INTO `cd_log` VALUES (1760, 210, 'wshwye', '用户登录', '39.155.44.54', 1603067161);
INSERT INTO `cd_log` VALUES (1761, 210, 'wshwye', '用户登录', '39.155.44.54', 1603071729);
INSERT INTO `cd_log` VALUES (1762, 96, 'ytk', '用户登录', '222.186.101.241', 1603086388);
INSERT INTO `cd_log` VALUES (1763, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.191', 1603086397);
INSERT INTO `cd_log` VALUES (1764, 1, 'admin', '用户登录', '111.121.9.42', 1603121637);
INSERT INTO `cd_log` VALUES (1765, 210, 'wshwye', '用户登录', '39.155.44.54', 1603154228);
INSERT INTO `cd_log` VALUES (1766, 83, '01', '用户登录', '42.48.113.242', 1603164343);
INSERT INTO `cd_log` VALUES (1767, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.191', 1603186640);
INSERT INTO `cd_log` VALUES (1768, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.236', 1603192455);
INSERT INTO `cd_log` VALUES (1769, 210, 'wshwye', '用户登录', '223.104.178.254', 1603251665);
INSERT INTO `cd_log` VALUES (1770, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.18', 1603263033);
INSERT INTO `cd_log` VALUES (1771, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.236', 1603263335);
INSERT INTO `cd_log` VALUES (1772, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.18', 1603275021);
INSERT INTO `cd_log` VALUES (1773, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.18', 1603285412);
INSERT INTO `cd_log` VALUES (1774, 1, 'admin', '用户登录', '111.121.11.19', 1603297264);
INSERT INTO `cd_log` VALUES (1775, 209, 'fjc6036', '用户登录', '113.101.237.80', 1603302472);
INSERT INTO `cd_log` VALUES (1776, 209, 'fjc6036', '用户登录', '113.101.237.80', 1603302773);
INSERT INTO `cd_log` VALUES (1777, 209, 'fjc6036', '用户登录', '113.101.237.80', 1603302964);
INSERT INTO `cd_log` VALUES (1778, 209, 'fjc6036', '用户登录', '113.101.237.80', 1603303481);
INSERT INTO `cd_log` VALUES (1779, 209, 'fjc6036', '用户登录', '113.101.237.80', 1603303728);
INSERT INTO `cd_log` VALUES (1780, 50, 'lwang', '用户登录', '117.189.25.57', 1603331115);
INSERT INTO `cd_log` VALUES (1781, 83, '01', '用户登录', '42.48.113.242', 1603332736);
INSERT INTO `cd_log` VALUES (1782, 83, '01', '用户登录', '42.48.113.242', 1603336187);
INSERT INTO `cd_log` VALUES (1783, 83, '01', '用户登录', '42.48.113.242', 1603337161);
INSERT INTO `cd_log` VALUES (1784, 83, '01', '用户登录', '42.48.113.242', 1603338929);
INSERT INTO `cd_log` VALUES (1785, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.18', 1603350949);
INSERT INTO `cd_log` VALUES (1786, 83, '01', '用户登录', '42.48.113.242', 1603356448);
INSERT INTO `cd_log` VALUES (1787, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.236', 1603360657);
INSERT INTO `cd_log` VALUES (1788, 227, '绝食小肥', '用户登录', '106.122.96.165', 1603362960);
INSERT INTO `cd_log` VALUES (1789, 1, 'admin', '用户登录', '111.121.14.135', 1603364279);
INSERT INTO `cd_log` VALUES (1790, 83, '01', '用户登录', '220.202.207.178', 1603367903);
INSERT INTO `cd_log` VALUES (1791, 83, '01', '用户登录', '220.202.207.178', 1603368004);
INSERT INTO `cd_log` VALUES (1792, 83, '01', '用户登录', '42.48.113.242', 1603412088);
INSERT INTO `cd_log` VALUES (1793, 83, '01', '用户登录', '42.48.113.242', 1603419567);
INSERT INTO `cd_log` VALUES (1794, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.18', 1603432695);
INSERT INTO `cd_log` VALUES (1795, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.22', 1603443860);
INSERT INTO `cd_log` VALUES (1796, 170, '易能森智能', '用户登录', '61.154.119.130', 1603507312);
INSERT INTO `cd_log` VALUES (1797, 209, 'fjc6036', '用户登录', '116.29.108.108', 1603509387);
INSERT INTO `cd_log` VALUES (1798, 209, 'fjc6036', '用户登录', '116.29.108.108', 1603509672);
INSERT INTO `cd_log` VALUES (1799, 209, 'fjc6036', '用户登录', '116.29.108.108', 1603509753);
INSERT INTO `cd_log` VALUES (1800, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.22', 1603531430);
INSERT INTO `cd_log` VALUES (1801, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.15', 1603532325);
INSERT INTO `cd_log` VALUES (1802, 210, 'wshwye', '用户登录', '110.6.45.47', 1603548634);
INSERT INTO `cd_log` VALUES (1803, 149, 'wfs', '用户登录', '123.196.12.216', 1603601100);
INSERT INTO `cd_log` VALUES (1804, 83, '01', '用户登录', '42.48.113.242', 1603603818);
INSERT INTO `cd_log` VALUES (1805, 210, 'wshwye', '用户登录', '117.136.3.141', 1603605530);
INSERT INTO `cd_log` VALUES (1806, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.15', 1603605687);
INSERT INTO `cd_log` VALUES (1807, 210, 'wshwye', '用户登录', '39.155.44.54', 1603613049);
INSERT INTO `cd_log` VALUES (1808, 206, '小马驹', '用户登录', '125.70.79.161', 1603619901);
INSERT INTO `cd_log` VALUES (1809, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.22', 1603629427);
INSERT INTO `cd_log` VALUES (1810, 229, 'a1234567', '用户登录', '111.85.32.119', 1603636730);
INSERT INTO `cd_log` VALUES (1811, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.249', 1603690990);
INSERT INTO `cd_log` VALUES (1812, 83, '01', '用户登录', '42.48.113.242', 1603692047);
INSERT INTO `cd_log` VALUES (1813, 170, '易能森智能', '用户登录', '61.154.119.130', 1603698999);
INSERT INTO `cd_log` VALUES (1814, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.15', 1603702893);
INSERT INTO `cd_log` VALUES (1815, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.15', 1603709025);
INSERT INTO `cd_log` VALUES (1816, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.15', 1603713595);
INSERT INTO `cd_log` VALUES (1817, 210, 'wshwye', '用户登录', '39.155.44.54', 1603767397);
INSERT INTO `cd_log` VALUES (1818, 149, 'wfs', '用户登录', '123.196.12.216', 1603771315);
INSERT INTO `cd_log` VALUES (1819, 229, 'a1234567', '用户登录', '220.197.208.59', 1603777705);
INSERT INTO `cd_log` VALUES (1820, 229, 'a1234567', '用户登录', '220.197.208.59', 1603777833);
INSERT INTO `cd_log` VALUES (1821, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.15', 1603778409);
INSERT INTO `cd_log` VALUES (1822, 83, '01', '用户登录', '42.48.113.242', 1603790559);
INSERT INTO `cd_log` VALUES (1823, 233, 'linyuanyao', '用户登录', '115.216.48.22', 1603792929);
INSERT INTO `cd_log` VALUES (1824, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.28', 1603794213);
INSERT INTO `cd_log` VALUES (1825, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.249', 1603796430);
INSERT INTO `cd_log` VALUES (1826, 229, 'a1234567', '用户登录', '111.85.32.55', 1603809492);
INSERT INTO `cd_log` VALUES (1827, 172, '17505919990', '用户登录', '61.241.205.150', 1603824377);
INSERT INTO `cd_log` VALUES (1828, 50, 'lwang', '用户登录', '117.189.27.80', 1603854780);
INSERT INTO `cd_log` VALUES (1829, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.249', 1603867823);
INSERT INTO `cd_log` VALUES (1830, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.28', 1603869012);
INSERT INTO `cd_log` VALUES (1831, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.249', 1603870439);
INSERT INTO `cd_log` VALUES (1832, 210, 'wshwye', '用户登录', '220.195.70.253', 1603874456);
INSERT INTO `cd_log` VALUES (1833, 210, 'wshwye', '用户登录', '220.195.70.253', 1603874602);
INSERT INTO `cd_log` VALUES (1834, 209, 'fjc6036', '用户登录', '113.101.239.28', 1603885931);
INSERT INTO `cd_log` VALUES (1835, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.28', 1603951733);
INSERT INTO `cd_log` VALUES (1836, 1, 'admin', '用户登录', '117.189.27.80', 1603955152);
INSERT INTO `cd_log` VALUES (1837, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.158', 1603958639);
INSERT INTO `cd_log` VALUES (1838, 1, 'admin', '用户登录', '111.121.41.186', 1603983323);
INSERT INTO `cd_log` VALUES (1839, 210, 'wshwye', '用户登录', '39.155.44.8', 1604024447);
INSERT INTO `cd_log` VALUES (1840, 210, 'wshwye', '用户登录', '39.155.44.8', 1604025222);
INSERT INTO `cd_log` VALUES (1841, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.28', 1604039436);
INSERT INTO `cd_log` VALUES (1842, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.177', 1604040225);
INSERT INTO `cd_log` VALUES (1843, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.236', 1604052044);
INSERT INTO `cd_log` VALUES (1844, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.236', 1604054027);
INSERT INTO `cd_log` VALUES (1845, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.177', 1604055871);
INSERT INTO `cd_log` VALUES (1846, 1, 'admin', '用户登录', '111.121.10.108', 1604067858);
INSERT INTO `cd_log` VALUES (1847, 83, '01', '用户登录', '42.48.113.242', 1604114197);
INSERT INTO `cd_log` VALUES (1848, 83, '01', '用户登录', '42.48.113.242', 1604114776);
INSERT INTO `cd_log` VALUES (1849, 83, '01', '用户登录', '42.48.113.242', 1604114937);
INSERT INTO `cd_log` VALUES (1850, 83, '01', '用户登录', '42.48.113.242', 1604115090);
INSERT INTO `cd_log` VALUES (1851, 83, '01', '用户登录', '42.48.113.242', 1604115578);
INSERT INTO `cd_log` VALUES (1852, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.177', 1604121835);
INSERT INTO `cd_log` VALUES (1853, 210, 'wshwye', '用户登录', '110.6.45.207', 1604128060);
INSERT INTO `cd_log` VALUES (1854, 210, 'wshwye', '用户登录', '110.6.45.207', 1604133097);
INSERT INTO `cd_log` VALUES (1855, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.236', 1604133420);
INSERT INTO `cd_log` VALUES (1856, 83, '01', '用户登录', '42.48.113.242', 1604136521);
INSERT INTO `cd_log` VALUES (1857, 172, '17505919990', '用户登录', '125.210.59.221', 1604193168);
INSERT INTO `cd_log` VALUES (1858, 172, '17505919990', '用户登录', '125.210.59.221', 1604193406);
INSERT INTO `cd_log` VALUES (1859, 172, '17505919990', '用户登录', '125.210.59.221', 1604193449);
INSERT INTO `cd_log` VALUES (1860, 210, 'wshwye', '用户登录', '39.155.44.8', 1604193468);
INSERT INTO `cd_log` VALUES (1861, 210, 'wshwye', '用户登录', '39.155.44.8', 1604193526);
INSERT INTO `cd_log` VALUES (1862, 210, 'wshwye', '用户登录', '39.155.44.8', 1604193667);
INSERT INTO `cd_log` VALUES (1863, 209, 'fjc6036', '用户登录', '113.101.236.173', 1604194539);
INSERT INTO `cd_log` VALUES (1864, 210, 'wshwye', '用户登录', '39.155.44.8', 1604198200);
INSERT INTO `cd_log` VALUES (1865, 237, '山丹', '用户登录', '121.57.13.231', 1604199443);
INSERT INTO `cd_log` VALUES (1866, 237, '山丹', '用户登录', '121.57.13.231', 1604204647);
INSERT INTO `cd_log` VALUES (1867, 210, 'wshwye', '用户登录', '39.155.44.8', 1604205007);
INSERT INTO `cd_log` VALUES (1868, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.177', 1604208666);
INSERT INTO `cd_log` VALUES (1869, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.236', 1604235298);
INSERT INTO `cd_log` VALUES (1870, 170, '易能森智能', '用户登录', '61.154.119.130', 1604244633);
INSERT INTO `cd_log` VALUES (1871, 170, '易能森智能', '用户登录', '61.154.119.130', 1604287931);
INSERT INTO `cd_log` VALUES (1872, 83, '01', '用户登录', '42.48.113.242', 1604289425);
INSERT INTO `cd_log` VALUES (1873, 210, 'wshwye', '用户登录', '39.155.44.8', 1604290517);
INSERT INTO `cd_log` VALUES (1874, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.119', 1604299473);
INSERT INTO `cd_log` VALUES (1875, 83, '01', '用户登录', '42.48.113.242', 1604301118);
INSERT INTO `cd_log` VALUES (1876, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.236', 1604306065);
INSERT INTO `cd_log` VALUES (1877, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.186', 1604316245);
INSERT INTO `cd_log` VALUES (1878, 231, 'Nighter00', '用户登录', '123.124.246.82', 1604321944);
INSERT INTO `cd_log` VALUES (1879, 224, '韩颖', '用户登录', '123.124.246.82', 1604322357);
INSERT INTO `cd_log` VALUES (1880, 209, 'fjc6036', '用户登录', '14.25.15.91', 1604337130);
INSERT INTO `cd_log` VALUES (1881, 83, '01', '用户登录', '42.48.113.242', 1604370053);
INSERT INTO `cd_log` VALUES (1882, 202, 'silencelam', '用户登录', '218.19.103.187', 1604378112);
INSERT INTO `cd_log` VALUES (1883, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.186', 1604382902);
INSERT INTO `cd_log` VALUES (1884, 241, '111', '用户登录', '123.124.246.23', 1604384738);
INSERT INTO `cd_log` VALUES (1885, 224, '韩颖', '用户登录', '123.124.246.23', 1604384869);
INSERT INTO `cd_log` VALUES (1886, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.102', 1604386232);
INSERT INTO `cd_log` VALUES (1887, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.102', 1604389473);
INSERT INTO `cd_log` VALUES (1888, 209, 'fjc6036', '用户登录', '113.101.236.236', 1604406923);
INSERT INTO `cd_log` VALUES (1889, 233, 'linyuanyao', '用户登录', '115.192.168.39', 1604461975);
INSERT INTO `cd_log` VALUES (1890, 233, 'linyuanyao', '用户登录', '115.192.168.39', 1604467763);
INSERT INTO `cd_log` VALUES (1891, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.102', 1604469788);
INSERT INTO `cd_log` VALUES (1892, 233, 'linyuanyao', '用户登录', '115.192.168.39', 1604470434);
INSERT INTO `cd_log` VALUES (1893, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.186', 1604471040);
INSERT INTO `cd_log` VALUES (1894, 213, 'kent', '用户登录', '223.73.226.114', 1604481345);
INSERT INTO `cd_log` VALUES (1895, 233, 'linyuanyao', '用户登录', '115.192.168.39', 1604537927);
INSERT INTO `cd_log` VALUES (1896, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.186', 1604557979);
INSERT INTO `cd_log` VALUES (1897, 233, 'linyuanyao', '用户登录', '115.192.168.39', 1604562372);
INSERT INTO `cd_log` VALUES (1898, 210, 'wshwye', '用户登录', '110.6.46.125', 1604571056);
INSERT INTO `cd_log` VALUES (1899, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.102', 1604571560);
INSERT INTO `cd_log` VALUES (1900, 224, '韩颖', '用户登录', '123.124.246.83', 1604575848);
INSERT INTO `cd_log` VALUES (1901, 210, 'wshwye', '用户登录', '39.155.44.8', 1604630713);
INSERT INTO `cd_log` VALUES (1902, 233, 'linyuanyao', '用户登录', '115.192.168.39', 1604631047);
INSERT INTO `cd_log` VALUES (1903, 237, '山丹', '用户登录', '123.179.7.109', 1604636505);
INSERT INTO `cd_log` VALUES (1904, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.218', 1604637613);
INSERT INTO `cd_log` VALUES (1905, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.57', 1604641403);
INSERT INTO `cd_log` VALUES (1906, 233, 'linyuanyao', '用户登录', '115.193.216.113', 1604652709);
INSERT INTO `cd_log` VALUES (1907, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.57', 1604731186);
INSERT INTO `cd_log` VALUES (1908, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.218', 1604731449);
INSERT INTO `cd_log` VALUES (1909, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.218', 1604755184);
INSERT INTO `cd_log` VALUES (1910, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.218', 1604755491);
INSERT INTO `cd_log` VALUES (1911, 83, '01', '用户登录', '42.48.113.242', 1604805882);
INSERT INTO `cd_log` VALUES (1912, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.57', 1604813633);
INSERT INTO `cd_log` VALUES (1913, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.242', 1604829063);
INSERT INTO `cd_log` VALUES (1914, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.217', 1604900388);
INSERT INTO `cd_log` VALUES (1915, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.242', 1604901991);
INSERT INTO `cd_log` VALUES (1916, 1, 'admin', '用户登录', '117.188.12.187', 1604901995);
INSERT INTO `cd_log` VALUES (1917, 233, 'linyuanyao', '用户登录', '115.193.216.113', 1604906230);
INSERT INTO `cd_log` VALUES (1918, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.242', 1604988512);
INSERT INTO `cd_log` VALUES (1919, 63, '劉睿兄弟', '用户登录', '124.160.215.29', 1605003822);
INSERT INTO `cd_log` VALUES (1920, 63, '劉睿兄弟', '用户登录', '124.160.215.29', 1605004022);
INSERT INTO `cd_log` VALUES (1921, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.217', 1605004180);
INSERT INTO `cd_log` VALUES (1922, 176, '郭晓宁', '用户登录', '112.96.167.201', 1605052227);
INSERT INTO `cd_log` VALUES (1923, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.242', 1605073698);
INSERT INTO `cd_log` VALUES (1924, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.217', 1605079442);
INSERT INTO `cd_log` VALUES (1925, 233, 'linyuanyao', '用户登录', '115.198.244.106', 1605080014);
INSERT INTO `cd_log` VALUES (1926, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.242', 1605080586);
INSERT INTO `cd_log` VALUES (1927, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.35', 1605159779);
INSERT INTO `cd_log` VALUES (1928, 176, '郭晓宁', '用户登录', '59.41.167.2', 1605163044);
INSERT INTO `cd_log` VALUES (1929, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.35', 1605174366);
INSERT INTO `cd_log` VALUES (1930, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.35', 1605179282);
INSERT INTO `cd_log` VALUES (1931, 210, 'wshwye', '用户登录', '39.155.44.59', 1605227623);
INSERT INTO `cd_log` VALUES (1932, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.35', 1605245996);
INSERT INTO `cd_log` VALUES (1933, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.150', 1605260491);
INSERT INTO `cd_log` VALUES (1934, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.222', 1605273265);
INSERT INTO `cd_log` VALUES (1935, 210, 'wshwye', '用户登录', '39.155.44.59', 1605316729);
INSERT INTO `cd_log` VALUES (1936, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.222', 1605333914);
INSERT INTO `cd_log` VALUES (1937, 233, 'linyuanyao', '用户登录', '115.198.244.208', 1605343554);
INSERT INTO `cd_log` VALUES (1938, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.32', 1605348046);
INSERT INTO `cd_log` VALUES (1939, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.32', 1605360826);
INSERT INTO `cd_log` VALUES (1940, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.32', 1605360884);
INSERT INTO `cd_log` VALUES (1941, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.32', 1605418560);
INSERT INTO `cd_log` VALUES (1942, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.242', 1605421464);
INSERT INTO `cd_log` VALUES (1943, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.149', 1605505482);
INSERT INTO `cd_log` VALUES (1944, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.242', 1605510437);
INSERT INTO `cd_log` VALUES (1945, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.242', 1605593619);
INSERT INTO `cd_log` VALUES (1946, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.149', 1605595556);
INSERT INTO `cd_log` VALUES (1947, 100, 'liwang', '用户登录', '39.144.42.244', 1605631594);
INSERT INTO `cd_log` VALUES (1948, 246, 'FANTA', '用户登录', '122.96.137.188', 1605633187);
INSERT INTO `cd_log` VALUES (1949, 83, '01', '用户登录', '42.48.113.242', 1605667070);
INSERT INTO `cd_log` VALUES (1950, 233, 'linyuanyao', '用户登录', '115.192.171.211', 1605678489);
INSERT INTO `cd_log` VALUES (1951, 122, '巴帝洛克金鼎店', '用户登录', '182.86.200.149', 1605682819);
INSERT INTO `cd_log` VALUES (1952, 149, 'wfs', '用户登录', '42.199.137.77', 1605684369);
INSERT INTO `cd_log` VALUES (1953, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.85', 1605687314);
INSERT INTO `cd_log` VALUES (1954, 246, 'fanta', '用户登录', '180.110.244.238', 1605688154);
INSERT INTO `cd_log` VALUES (1955, 209, 'fjc6036', '用户登录', '119.138.192.174', 1605748646);
INSERT INTO `cd_log` VALUES (1956, 50, 'lwang', '用户登录', '117.189.30.75', 1605750501);
INSERT INTO `cd_log` VALUES (1957, 233, 'linyuanyao', '用户登录', '122.234.125.75', 1605761860);
INSERT INTO `cd_log` VALUES (1958, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.21', 1605763093);
INSERT INTO `cd_log` VALUES (1959, 1, 'admin', '用户登录', '117.189.30.75', 1605764841);
INSERT INTO `cd_log` VALUES (1960, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.85', 1605769250);
INSERT INTO `cd_log` VALUES (1961, 51, '增小贩无人超市', '用户登录', '171.10.164.180', 1605784323);
INSERT INTO `cd_log` VALUES (1962, 96, 'ytk', '用户登录', '222.186.101.241', 1605832720);
INSERT INTO `cd_log` VALUES (1963, 209, 'fjc6036', '用户登录', '119.138.192.223', 1605834920);
INSERT INTO `cd_log` VALUES (1964, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.85', 1605851647);
INSERT INTO `cd_log` VALUES (1965, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.21', 1605856992);
INSERT INTO `cd_log` VALUES (1966, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.21', 1605878782);
INSERT INTO `cd_log` VALUES (1967, 1, 'admin', '用户登录', '111.121.14.251', 1605884429);
INSERT INTO `cd_log` VALUES (1968, 210, 'wshwye', '用户登录', '39.155.44.44', 1605926095);
INSERT INTO `cd_log` VALUES (1969, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.99', 1605936566);
INSERT INTO `cd_log` VALUES (1970, 248, 'wdc991', '用户登录', '113.104.129.89', 1605938559);
INSERT INTO `cd_log` VALUES (1971, 216, 'chen', '用户登录', '115.214.104.85', 1605949749);
INSERT INTO `cd_log` VALUES (1972, 1, 'admin', '用户登录', '111.121.45.182', 1606016399);
INSERT INTO `cd_log` VALUES (1973, 83, '01', '用户登录', '42.48.113.242', 1606027334);
INSERT INTO `cd_log` VALUES (1974, 250, '13920050922', '用户登录', '117.11.121.38', 1606027501);
INSERT INTO `cd_log` VALUES (1975, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.99', 1606033394);
INSERT INTO `cd_log` VALUES (1976, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.201', 1606034744);
INSERT INTO `cd_log` VALUES (1977, 149, 'wfs', '用户登录', '42.199.137.77', 1606035288);
INSERT INTO `cd_log` VALUES (1978, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.63', 1606094865);
INSERT INTO `cd_log` VALUES (1979, 210, 'wshwye', '用户登录', '39.155.44.36', 1606100543);
INSERT INTO `cd_log` VALUES (1980, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.63', 1606111264);
INSERT INTO `cd_log` VALUES (1981, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.99', 1606114258);
INSERT INTO `cd_log` VALUES (1982, 206, '小马驹', '用户登录', '182.150.112.119', 1606130458);
INSERT INTO `cd_log` VALUES (1983, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.63', 1606138306);
INSERT INTO `cd_log` VALUES (1984, 209, 'fjc6036', '用户登录', '113.101.239.129', 1606179011);
INSERT INTO `cd_log` VALUES (1985, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.140', 1606196384);
INSERT INTO `cd_log` VALUES (1986, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.201', 1606197206);
INSERT INTO `cd_log` VALUES (1987, 172, '17505919990', '用户登录', '220.249.162.109', 1606201625);
INSERT INTO `cd_log` VALUES (1988, 50, 'lwang', '用户登录', '117.188.30.114', 1606212316);
INSERT INTO `cd_log` VALUES (1989, 209, 'fjc6036', '用户登录', '116.29.108.171', 1606274204);
INSERT INTO `cd_log` VALUES (1990, 172, '17505919990', '用户登录', '125.210.62.65', 1606279725);
INSERT INTO `cd_log` VALUES (1991, 172, '17505919990', '用户登录', '125.210.61.121', 1606280972);
INSERT INTO `cd_log` VALUES (1992, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.201', 1606282596);
INSERT INTO `cd_log` VALUES (1993, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.140', 1606284843);
INSERT INTO `cd_log` VALUES (1994, 176, '郭晓宁', '用户登录', '112.96.194.13', 1606292804);
INSERT INTO `cd_log` VALUES (1995, 209, 'fjc6036', '用户登录', '14.25.147.44', 1606303148);
INSERT INTO `cd_log` VALUES (1996, 1, 'admin', '用户登录', '111.121.44.80', 1606318265);
INSERT INTO `cd_log` VALUES (1997, 209, 'fjc6036', '用户登录', '14.27.50.95', 1606318969);
INSERT INTO `cd_log` VALUES (1998, 209, 'fjc6036', '用户登录', '116.29.108.44', 1606321224);
INSERT INTO `cd_log` VALUES (1999, 209, 'fjc6036', '用户登录', '14.27.50.95', 1606332712);
INSERT INTO `cd_log` VALUES (2000, 83, '01', '用户登录', '42.48.113.242', 1606357699);
INSERT INTO `cd_log` VALUES (2001, 233, 'linyuanyao', '用户登录', '122.233.163.112', 1606361030);
INSERT INTO `cd_log` VALUES (2002, 233, 'linyuanyao', '用户登录', '122.233.163.112', 1606365122);
INSERT INTO `cd_log` VALUES (2003, 1, 'admin', '用户登录', '117.188.30.114', 1606367322);
INSERT INTO `cd_log` VALUES (2004, 233, 'linyuanyao', '用户登录', '122.233.163.112', 1606372907);
INSERT INTO `cd_log` VALUES (2005, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.140', 1606378771);
INSERT INTO `cd_log` VALUES (2006, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.72', 1606380003);
INSERT INTO `cd_log` VALUES (2007, 176, '郭晓宁', '用户登录', '112.96.100.70', 1606381871);
INSERT INTO `cd_log` VALUES (2008, 172, '17505919990', '用户登录', '211.97.114.48', 1606410500);
INSERT INTO `cd_log` VALUES (2009, 209, 'fjc6036', '用户登录', '14.27.19.61', 1606413572);
INSERT INTO `cd_log` VALUES (2010, 172, '17505919990', '用户登录', '125.210.61.121', 1606443481);
INSERT INTO `cd_log` VALUES (2011, 48, '神猫', '用户登录', '101.41.191.242', 1606443858);
INSERT INTO `cd_log` VALUES (2012, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606453633);
INSERT INTO `cd_log` VALUES (2013, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.190', 1606457713);
INSERT INTO `cd_log` VALUES (2014, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.72', 1606463380);
INSERT INTO `cd_log` VALUES (2015, 209, 'fjc6036', '用户登录', '113.101.239.7', 1606503316);
INSERT INTO `cd_log` VALUES (2016, 209, 'fjc6036', '用户登录', '14.25.153.224', 1606525123);
INSERT INTO `cd_log` VALUES (2017, 209, 'fjc6036', '用户登录', '14.25.153.224', 1606528602);
INSERT INTO `cd_log` VALUES (2018, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.190', 1606538828);
INSERT INTO `cd_log` VALUES (2019, 209, 'fjc6036', '用户登录', '119.138.192.163', 1606567040);
INSERT INTO `cd_log` VALUES (2020, 209, 'fjc6036', '用户登录', '183.39.159.44', 1606573611);
INSERT INTO `cd_log` VALUES (2021, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606578267);
INSERT INTO `cd_log` VALUES (2022, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606584219);
INSERT INTO `cd_log` VALUES (2023, 209, 'fjc6036', '用户登录', '113.101.238.177', 1606589841);
INSERT INTO `cd_log` VALUES (2024, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606591968);
INSERT INTO `cd_log` VALUES (2025, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606596355);
INSERT INTO `cd_log` VALUES (2026, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606596605);
INSERT INTO `cd_log` VALUES (2027, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606598416);
INSERT INTO `cd_log` VALUES (2028, 209, 'fjc6036', '用户登录', '119.138.193.97', 1606598807);
INSERT INTO `cd_log` VALUES (2029, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.190', 1606631552);
INSERT INTO `cd_log` VALUES (2030, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606632169);
INSERT INTO `cd_log` VALUES (2031, 209, 'fjc6036', '用户登录', '14.28.145.1', 1606657675);
INSERT INTO `cd_log` VALUES (2032, 209, 'fjc6036', '用户登录', '14.28.145.1', 1606660235);
INSERT INTO `cd_log` VALUES (2033, 209, 'fjc6036', '用户登录', '113.101.239.240', 1606663649);
INSERT INTO `cd_log` VALUES (2034, 209, 'fjc6036', '用户登录', '113.101.239.240', 1606664270);
INSERT INTO `cd_log` VALUES (2035, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606702053);
INSERT INTO `cd_log` VALUES (2036, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606704155);
INSERT INTO `cd_log` VALUES (2037, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606704237);
INSERT INTO `cd_log` VALUES (2038, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606704582);
INSERT INTO `cd_log` VALUES (2039, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606720383);
INSERT INTO `cd_log` VALUES (2040, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606723143);
INSERT INTO `cd_log` VALUES (2041, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606733863);
INSERT INTO `cd_log` VALUES (2042, 209, 'fjc6036', '用户登录', '113.101.238.48', 1606735381);
INSERT INTO `cd_log` VALUES (2043, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606745888);
INSERT INTO `cd_log` VALUES (2044, 209, 'fjc6036', '用户登录', '113.101.239.240', 1606751524);
INSERT INTO `cd_log` VALUES (2045, 210, 'wshwye', '用户登录', '39.155.44.36', 1606788285);
INSERT INTO `cd_log` VALUES (2046, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606800712);
INSERT INTO `cd_log` VALUES (2047, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606804786);
INSERT INTO `cd_log` VALUES (2048, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606812257);
INSERT INTO `cd_log` VALUES (2049, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.99', 1606823142);
INSERT INTO `cd_log` VALUES (2050, 209, 'fjc6036', '用户登录', '14.27.0.187', 1606827413);
INSERT INTO `cd_log` VALUES (2051, 209, 'fjc6036', '用户登录', '14.27.0.187', 1606829440);
INSERT INTO `cd_log` VALUES (2052, 209, 'fjc6036', '用户登录', '14.27.0.187', 1606829728);
INSERT INTO `cd_log` VALUES (2053, 209, 'fjc6036', '用户登录', '116.29.109.67', 1606834886);
INSERT INTO `cd_log` VALUES (2054, 209, 'fjc6036', '用户登录', '113.101.236.208', 1606852264);
INSERT INTO `cd_log` VALUES (2055, 209, 'fjc6036', '用户登录', '113.101.236.208', 1606857161);
INSERT INTO `cd_log` VALUES (2056, 50, 'lwang', '用户登录', '117.189.22.43', 1606879732);
INSERT INTO `cd_log` VALUES (2057, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.173', 1606886836);
INSERT INTO `cd_log` VALUES (2058, 206, '小马驹', '用户登录', '182.150.112.119', 1606892025);
INSERT INTO `cd_log` VALUES (2059, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606893609);
INSERT INTO `cd_log` VALUES (2060, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.173', 1606915734);
INSERT INTO `cd_log` VALUES (2061, 209, 'fjc6036', '用户登录', '14.25.167.102', 1606918590);
INSERT INTO `cd_log` VALUES (2062, 209, 'fjc6036', '用户登录', '14.25.167.102', 1606918875);
INSERT INTO `cd_log` VALUES (2063, 209, 'fjc6036', '用户登录', '116.29.108.68', 1606919414);
INSERT INTO `cd_log` VALUES (2064, 50, 'lwang', '用户登录', '117.189.22.43', 1606961116);
INSERT INTO `cd_log` VALUES (2065, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.173', 1606961846);
INSERT INTO `cd_log` VALUES (2066, 259, '余朝永', '用户登录', '112.96.73.45', 1606962097);
INSERT INTO `cd_log` VALUES (2067, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.173', 1606973250);
INSERT INTO `cd_log` VALUES (2068, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606981114);
INSERT INTO `cd_log` VALUES (2069, 209, 'fjc6036', '用户登录', '113.101.236.147', 1606985003);
INSERT INTO `cd_log` VALUES (2070, 209, 'fjc6036', '用户登录', '14.28.153.218', 1606990077);
INSERT INTO `cd_log` VALUES (2071, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1606990944);
INSERT INTO `cd_log` VALUES (2072, 63, '劉睿兄弟', '用户登录', '124.160.218.206', 1607009101);
INSERT INTO `cd_log` VALUES (2073, 233, 'linyuanyao', '用户登录', '125.122.14.254', 1607046640);
INSERT INTO `cd_log` VALUES (2074, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1607049561);
INSERT INTO `cd_log` VALUES (2075, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.173', 1607075991);
INSERT INTO `cd_log` VALUES (2076, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1607078046);
INSERT INTO `cd_log` VALUES (2077, 206, '小马驹', '用户登录', '182.150.112.119', 1607081545);
INSERT INTO `cd_log` VALUES (2078, 209, 'fjc6036', '用户登录', '183.39.138.16', 1607090818);
INSERT INTO `cd_log` VALUES (2079, 209, 'fjc6036', '用户登录', '183.39.138.16', 1607090907);
INSERT INTO `cd_log` VALUES (2080, 209, 'fjc6036', '用户登录', '116.29.109.158', 1607095477);
INSERT INTO `cd_log` VALUES (2081, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1607146052);
INSERT INTO `cd_log` VALUES (2082, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.45', 1607166217);
INSERT INTO `cd_log` VALUES (2083, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.113', 1607167056);
INSERT INTO `cd_log` VALUES (2084, 209, 'fjc6036', '用户登录', '119.138.193.79', 1607171230);
INSERT INTO `cd_log` VALUES (2085, 209, 'fjc6036', '用户登录', '119.138.192.28', 1607185671);
INSERT INTO `cd_log` VALUES (2086, 1, 'admin', '用户登录', '111.121.42.96', 1607186692);
INSERT INTO `cd_log` VALUES (2087, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.45', 1607232982);
INSERT INTO `cd_log` VALUES (2088, 248, 'wdc991', '用户登录', '203.168.29.75', 1607240989);
INSERT INTO `cd_log` VALUES (2089, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607248809);
INSERT INTO `cd_log` VALUES (2090, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607254293);
INSERT INTO `cd_log` VALUES (2091, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607256741);
INSERT INTO `cd_log` VALUES (2092, 209, 'fjc6036', '用户登录', '119.138.192.28', 1607271546);
INSERT INTO `cd_log` VALUES (2093, 233, 'linyuanyao', '用户登录', '125.122.244.32', 1607310583);
INSERT INTO `cd_log` VALUES (2094, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607324696);
INSERT INTO `cd_log` VALUES (2095, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.45', 1607328188);
INSERT INTO `cd_log` VALUES (2096, 83, '01', '用户登录', '42.48.113.242', 1607330859);
INSERT INTO `cd_log` VALUES (2097, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607339545);
INSERT INTO `cd_log` VALUES (2098, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607346970);
INSERT INTO `cd_log` VALUES (2099, 209, 'fjc6036', '用户登录', '116.29.109.78', 1607353628);
INSERT INTO `cd_log` VALUES (2100, 261, '576722855@qq.com', '用户登录', '223.13.14.41', 1607388363);
INSERT INTO `cd_log` VALUES (2101, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.110', 1607405731);
INSERT INTO `cd_log` VALUES (2102, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607414742);
INSERT INTO `cd_log` VALUES (2103, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607422168);
INSERT INTO `cd_log` VALUES (2104, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607428879);
INSERT INTO `cd_log` VALUES (2105, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.91', 1607432488);
INSERT INTO `cd_log` VALUES (2106, 209, 'fjc6036', '用户登录', '116.29.109.78', 1607444583);
INSERT INTO `cd_log` VALUES (2107, 1, 'admin', '用户登录', '106.109.40.182', 1607476610);
INSERT INTO `cd_log` VALUES (2108, 233, 'linyuanyao', '用户登录', '115.205.221.77', 1607482924);
INSERT INTO `cd_log` VALUES (2109, 233, 'linyuanyao', '用户登录', '115.205.221.77', 1607487556);
INSERT INTO `cd_log` VALUES (2110, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.110', 1607493312);
INSERT INTO `cd_log` VALUES (2111, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607494682);
INSERT INTO `cd_log` VALUES (2112, 210, 'wshwye', '用户登录', '39.155.44.36', 1607499443);
INSERT INTO `cd_log` VALUES (2113, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607500129);
INSERT INTO `cd_log` VALUES (2114, 263, 'jxd0454', '用户登录', '223.104.212.63', 1607501575);
INSERT INTO `cd_log` VALUES (2115, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607512341);
INSERT INTO `cd_log` VALUES (2116, 209, 'fjc6036', '用户登录', '116.29.109.211', 1607522880);
INSERT INTO `cd_log` VALUES (2117, 209, 'fjc6036', '用户登录', '116.29.109.211', 1607531866);
INSERT INTO `cd_log` VALUES (2118, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607566874);
INSERT INTO `cd_log` VALUES (2119, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607573869);
INSERT INTO `cd_log` VALUES (2120, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607579856);
INSERT INTO `cd_log` VALUES (2121, 263, 'JXD0454', '用户登录', '117.136.40.178', 1607595134);
INSERT INTO `cd_log` VALUES (2122, 263, 'JXD0454', '用户登录', '117.136.40.178', 1607595285);
INSERT INTO `cd_log` VALUES (2123, 263, 'JXD0454', '用户登录', '117.136.40.178', 1607595343);
INSERT INTO `cd_log` VALUES (2124, 263, 'JXD0454', '用户登录', '117.136.40.178', 1607595499);
INSERT INTO `cd_log` VALUES (2125, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.252', 1607604133);
INSERT INTO `cd_log` VALUES (2126, 263, 'JXD0454', '用户登录', '113.78.238.236', 1607608128);
INSERT INTO `cd_log` VALUES (2127, 209, 'fjc6036', '用户登录', '116.29.109.211', 1607609609);
INSERT INTO `cd_log` VALUES (2128, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607669633);
INSERT INTO `cd_log` VALUES (2129, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607670556);
INSERT INTO `cd_log` VALUES (2130, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607675946);
INSERT INTO `cd_log` VALUES (2131, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.119', 1607684080);
INSERT INTO `cd_log` VALUES (2132, 209, 'fjc6036', '用户登录', '14.27.51.103', 1607699114);
INSERT INTO `cd_log` VALUES (2133, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607758920);
INSERT INTO `cd_log` VALUES (2134, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.252', 1607777175);
INSERT INTO `cd_log` VALUES (2135, 209, 'fjc6036', '用户登录', '119.138.193.108', 1607790335);
INSERT INTO `cd_log` VALUES (2136, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607839048);
INSERT INTO `cd_log` VALUES (2137, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607839923);
INSERT INTO `cd_log` VALUES (2138, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607846782);
INSERT INTO `cd_log` VALUES (2139, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607854797);
INSERT INTO `cd_log` VALUES (2140, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607854833);
INSERT INTO `cd_log` VALUES (2141, 1, 'admin', '用户登录', '111.121.8.200', 1607857786);
INSERT INTO `cd_log` VALUES (2142, 209, 'fjc6036', '用户登录', '113.101.237.146', 1607876243);
INSERT INTO `cd_log` VALUES (2143, 233, 'linyuanyao', '用户登录', '223.104.247.116', 1607926279);
INSERT INTO `cd_log` VALUES (2144, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.187', 1607928015);
INSERT INTO `cd_log` VALUES (2145, 233, 'linyuanyao', '用户登录', '115.205.217.167', 1607933693);
INSERT INTO `cd_log` VALUES (2146, 233, 'linyuanyao', '用户登录', '115.205.217.167', 1607935277);
INSERT INTO `cd_log` VALUES (2147, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607938868);
INSERT INTO `cd_log` VALUES (2148, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.27', 1607939374);
INSERT INTO `cd_log` VALUES (2149, 209, 'fjc6036', '用户登录', '113.101.237.146', 1607952935);
INSERT INTO `cd_log` VALUES (2150, 209, 'fjc6036', '用户登录', '113.101.237.146', 1607967762);
INSERT INTO `cd_log` VALUES (2151, 266, 'hepeng', '用户登录', '61.148.243.168', 1607984235);
INSERT INTO `cd_log` VALUES (2152, 266, 'hepeng', '用户登录', '121.101.212.146', 1607993669);
INSERT INTO `cd_log` VALUES (2153, 233, 'linyuanyao', '用户登录', '115.205.217.167', 1607998244);
INSERT INTO `cd_log` VALUES (2154, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.68', 1608016443);
INSERT INTO `cd_log` VALUES (2155, 233, 'linyuanyao', '用户登录', '115.205.217.167', 1608024332);
INSERT INTO `cd_log` VALUES (2156, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.68', 1608029256);
INSERT INTO `cd_log` VALUES (2157, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.187', 1608030010);
INSERT INTO `cd_log` VALUES (2158, 172, '17505919990', '用户登录', '61.241.205.72', 1608030181);
INSERT INTO `cd_log` VALUES (2159, 209, 'fjc6036', '用户登录', '116.29.108.32', 1608041614);
INSERT INTO `cd_log` VALUES (2160, 209, 'fjc6036', '用户登录', '116.29.108.32', 1608052379);
INSERT INTO `cd_log` VALUES (2161, 233, 'linyuanyao', '用户登录', '115.205.217.167', 1608085666);
INSERT INTO `cd_log` VALUES (2162, 206, '小马驹', '用户登录', '171.92.94.188', 1608104496);
INSERT INTO `cd_log` VALUES (2163, 206, '小马驹', '用户登录', '182.150.116.69', 1608106204);
INSERT INTO `cd_log` VALUES (2164, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.68', 1608110745);
INSERT INTO `cd_log` VALUES (2165, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.50', 1608114623);
INSERT INTO `cd_log` VALUES (2166, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.68', 1608117437);
INSERT INTO `cd_log` VALUES (2167, 209, 'fjc6036', '用户登录', '116.29.108.32', 1608131355);
INSERT INTO `cd_log` VALUES (2168, 233, 'linyuanyao', '用户登录', '115.205.217.167', 1608181777);
INSERT INTO `cd_log` VALUES (2169, 209, 'fjc6036', '用户登录', '113.101.237.179', 1608182132);
INSERT INTO `cd_log` VALUES (2170, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.68', 1608184227);
INSERT INTO `cd_log` VALUES (2171, 209, 'fjc6036', '用户登录', '113.101.237.179', 1608212441);
INSERT INTO `cd_log` VALUES (2172, 210, 'wshwye', '用户登录', '110.6.45.145', 1608221924);
INSERT INTO `cd_log` VALUES (2173, 209, 'fjc6036', '用户登录', '113.101.237.179', 1608222562);
INSERT INTO `cd_log` VALUES (2174, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.215', 1608258255);
INSERT INTO `cd_log` VALUES (2175, 1, 'admin', '用户登录', '111.121.42.181', 1608264150);
INSERT INTO `cd_log` VALUES (2176, 1, 'admin', '用户登录', '111.121.42.181', 1608273554);
INSERT INTO `cd_log` VALUES (2177, 176, '郭晓宁', '用户登录', '113.109.48.161', 1608274932);
INSERT INTO `cd_log` VALUES (2178, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.50', 1608286173);
INSERT INTO `cd_log` VALUES (2179, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.215', 1608288475);
INSERT INTO `cd_log` VALUES (2180, 209, 'fjc6036', '用户登录', '113.101.237.179', 1608299728);
INSERT INTO `cd_log` VALUES (2181, 209, 'fjc6036', '用户登录', '113.101.237.179', 1608314387);
INSERT INTO `cd_log` VALUES (2182, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.215', 1608356256);
INSERT INTO `cd_log` VALUES (2183, 209, 'fjc6036', '用户登录', '116.29.108.222', 1608379114);
INSERT INTO `cd_log` VALUES (2184, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.148', 1608380433);
INSERT INTO `cd_log` VALUES (2185, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.215', 1608383742);
INSERT INTO `cd_log` VALUES (2186, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.148', 1608450007);
INSERT INTO `cd_log` VALUES (2187, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.148', 1608450293);
INSERT INTO `cd_log` VALUES (2188, 209, 'fjc6036', '用户登录', '116.29.109.170', 1608469926);
INSERT INTO `cd_log` VALUES (2189, 209, 'fjc6036', '用户登录', '116.29.109.170', 1608481770);
INSERT INTO `cd_log` VALUES (2190, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.215', 1608528920);
INSERT INTO `cd_log` VALUES (2191, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.148', 1608546989);
INSERT INTO `cd_log` VALUES (2192, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.215', 1608547885);
INSERT INTO `cd_log` VALUES (2193, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.215', 1608549803);
INSERT INTO `cd_log` VALUES (2194, 209, 'fjc6036', '用户登录', '119.138.192.1', 1608561219);
INSERT INTO `cd_log` VALUES (2195, 209, 'fjc6036', '用户登录', '119.138.192.1', 1608567739);
INSERT INTO `cd_log` VALUES (2196, 209, 'fjc6036', '用户登录', '119.138.192.1', 1608595812);
INSERT INTO `cd_log` VALUES (2197, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.215', 1608620327);
INSERT INTO `cd_log` VALUES (2198, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.185', 1608626152);
INSERT INTO `cd_log` VALUES (2199, 209, 'fjc6036', '用户登录', '14.27.29.129', 1608632500);
INSERT INTO `cd_log` VALUES (2200, 209, 'fjc6036', '用户登录', '119.138.192.1', 1608656221);
INSERT INTO `cd_log` VALUES (2201, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.185', 1608700411);
INSERT INTO `cd_log` VALUES (2202, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.215', 1608701136);
INSERT INTO `cd_log` VALUES (2203, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.215', 1608729816);
INSERT INTO `cd_log` VALUES (2204, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.89', 1608787271);
INSERT INTO `cd_log` VALUES (2205, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.185', 1608792926);
INSERT INTO `cd_log` VALUES (2206, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.185', 1608802298);
INSERT INTO `cd_log` VALUES (2207, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.30', 1608877862);
INSERT INTO `cd_log` VALUES (2208, 1, 'admin', '用户登录', '117.188.1.159', 1608949930);
INSERT INTO `cd_log` VALUES (2209, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.89', 1608972349);
INSERT INTO `cd_log` VALUES (2210, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.89', 1608973212);
INSERT INTO `cd_log` VALUES (2211, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.30', 1608984752);
INSERT INTO `cd_log` VALUES (2212, 209, 'fjc6036', '用户登录', '119.138.193.193', 1609026919);
INSERT INTO `cd_log` VALUES (2213, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.30', 1609032617);
INSERT INTO `cd_log` VALUES (2214, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.30', 1609033084);
INSERT INTO `cd_log` VALUES (2215, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.170', 1609047622);
INSERT INTO `cd_log` VALUES (2216, 273, 'daiyunbiao', '用户登录', '125.71.215.148', 1609119678);
INSERT INTO `cd_log` VALUES (2217, 1, 'admin', '用户登录', '117.188.1.159', 1609126862);
INSERT INTO `cd_log` VALUES (2218, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.170', 1609133093);
INSERT INTO `cd_log` VALUES (2219, 50, 'lwang', '用户登录', '117.188.1.159', 1609150118);
INSERT INTO `cd_log` VALUES (2220, 209, 'fjc6036', '用户登录', '113.101.239.254', 1609174017);
INSERT INTO `cd_log` VALUES (2221, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.189', 1609210534);
INSERT INTO `cd_log` VALUES (2222, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.170', 1609219161);
INSERT INTO `cd_log` VALUES (2223, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.189', 1609220900);
INSERT INTO `cd_log` VALUES (2224, 51, '增小贩无人超市', '用户登录', '1.192.25.26', 1609304296);
INSERT INTO `cd_log` VALUES (2225, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.65', 1609312814);
INSERT INTO `cd_log` VALUES (2226, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.156', 1609313082);
INSERT INTO `cd_log` VALUES (2227, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.156', 1609330919);
INSERT INTO `cd_log` VALUES (2228, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.156', 1609378909);
INSERT INTO `cd_log` VALUES (2229, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.156', 1609397009);
INSERT INTO `cd_log` VALUES (2230, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.156', 1609412373);
INSERT INTO `cd_log` VALUES (2231, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.101', 1609572576);
INSERT INTO `cd_log` VALUES (2232, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.239', 1609577411);
INSERT INTO `cd_log` VALUES (2233, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.239', 1609656775);
INSERT INTO `cd_log` VALUES (2234, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.239', 1609659160);
INSERT INTO `cd_log` VALUES (2235, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.239', 1609670548);
INSERT INTO `cd_log` VALUES (2236, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.239', 1609733507);
INSERT INTO `cd_log` VALUES (2237, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.101', 1609740712);
INSERT INTO `cd_log` VALUES (2238, 210, 'wshwye', '用户登录', '110.6.46.226', 1609802265);
INSERT INTO `cd_log` VALUES (2239, 210, 'wshwye', '用户登录', '110.6.46.226', 1609809225);
INSERT INTO `cd_log` VALUES (2240, 210, 'wshwye', '用户登录', '110.6.46.226', 1609812508);
INSERT INTO `cd_log` VALUES (2241, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.255', 1609827188);
INSERT INTO `cd_log` VALUES (2242, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1609827791);
INSERT INTO `cd_log` VALUES (2243, 210, 'wshwye', '用户登录', '39.155.44.31', 1609834020);
INSERT INTO `cd_log` VALUES (2244, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.255', 1609852612);
INSERT INTO `cd_log` VALUES (2245, 1, 'admin', '用户登录', '111.121.9.161', 1609862731);
INSERT INTO `cd_log` VALUES (2246, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.255', 1609910685);
INSERT INTO `cd_log` VALUES (2247, 34, 'kingsyi', '用户登录', '182.242.186.136', 1609917426);
INSERT INTO `cd_log` VALUES (2248, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1609921398);
INSERT INTO `cd_log` VALUES (2249, 210, 'wshwye', '用户登录', '39.155.44.31', 1609921969);
INSERT INTO `cd_log` VALUES (2250, 210, 'wshwye', '用户登录', '39.155.44.31', 1609922062);
INSERT INTO `cd_log` VALUES (2251, 1, 'admin', '用户登录', '111.121.9.161', 1609986242);
INSERT INTO `cd_log` VALUES (2252, 290, 'wangw312', '用户登录', '222.139.212.90', 1609986746);
INSERT INTO `cd_log` VALUES (2253, 149, 'wfs', '用户登录', '123.196.12.2', 1609987687);
INSERT INTO `cd_log` VALUES (2254, 290, 'wangw312', '用户登录', '222.139.212.90', 1609987858);
INSERT INTO `cd_log` VALUES (2255, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.255', 1610005386);
INSERT INTO `cd_log` VALUES (2256, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1610006103);
INSERT INTO `cd_log` VALUES (2257, 1, 'admin', '用户登录', '111.121.42.216', 1610029107);
INSERT INTO `cd_log` VALUES (2258, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.94', 1610089601);
INSERT INTO `cd_log` VALUES (2259, 1, 'admin', '用户登录', '117.188.25.199', 1610090155);
INSERT INTO `cd_log` VALUES (2260, 215, 'zhahg', '用户登录', '202.109.239.24', 1610093866);
INSERT INTO `cd_log` VALUES (2261, 215, 'zhahg', '用户登录', '202.109.239.24', 1610094401);
INSERT INTO `cd_log` VALUES (2262, 233, 'linyuanyao', '用户登录', '115.193.148.16', 1610094513);
INSERT INTO `cd_log` VALUES (2263, 215, 'zhahg', '用户登录', '59.59.64.104', 1610096504);
INSERT INTO `cd_log` VALUES (2264, 206, '小马驹', '用户登录', '125.70.177.36', 1610096905);
INSERT INTO `cd_log` VALUES (2265, 1, 'admin', '用户登录', '117.188.25.199', 1610097106);
INSERT INTO `cd_log` VALUES (2266, 233, 'linyuanyao', '用户登录', '115.193.148.16', 1610099879);
INSERT INTO `cd_log` VALUES (2267, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.73', 1610106553);
INSERT INTO `cd_log` VALUES (2268, 218, 'Xuyu', '用户登录', '183.252.79.46', 1610114586);
INSERT INTO `cd_log` VALUES (2269, 218, 'Xuyu', '用户登录', '183.252.79.46', 1610114873);
INSERT INTO `cd_log` VALUES (2270, 1, 'admin', '用户登录', '111.121.42.216', 1610154596);
INSERT INTO `cd_log` VALUES (2271, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.94', 1610174153);
INSERT INTO `cd_log` VALUES (2272, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.73', 1610175199);
INSERT INTO `cd_log` VALUES (2273, 1, 'admin', '用户登录', '111.121.45.254', 1610208159);
INSERT INTO `cd_log` VALUES (2274, 1, 'admin', '用户登录', '111.121.45.254', 1610241821);
INSERT INTO `cd_log` VALUES (2275, 218, 'Xuyu', '用户登录', '111.121.45.254', 1610241916);
INSERT INTO `cd_log` VALUES (2276, 218, 'Xuyu', '用户登录', '183.252.79.46', 1610248739);
INSERT INTO `cd_log` VALUES (2277, 218, 'Xuyu', '用户登录', '183.252.79.46', 1610249006);
INSERT INTO `cd_log` VALUES (2278, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.73', 1610259205);
INSERT INTO `cd_log` VALUES (2279, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.94', 1610264201);
INSERT INTO `cd_log` VALUES (2280, 210, 'wshwye', '用户登录', '222.133.105.116', 1610289902);
INSERT INTO `cd_log` VALUES (2281, 233, 'linyuanyao', '用户登录', '115.204.140.106', 1610330464);
INSERT INTO `cd_log` VALUES (2282, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.156', 1610352296);
INSERT INTO `cd_log` VALUES (2283, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.14', 1610352695);
INSERT INTO `cd_log` VALUES (2284, 1, 'admin', '用户登录', '117.188.25.199', 1610354521);
INSERT INTO `cd_log` VALUES (2285, 1, 'admin', '用户登录', '111.121.44.172', 1610377913);
INSERT INTO `cd_log` VALUES (2286, 218, 'Xuyu', '用户登录', '121.206.48.125', 1610405998);
INSERT INTO `cd_log` VALUES (2287, 218, 'Xuyu', '用户登录', '121.206.48.125', 1610407921);
INSERT INTO `cd_log` VALUES (2288, 1, 'admin', '用户登录', '111.121.44.172', 1610408894);
INSERT INTO `cd_log` VALUES (2289, 295, 'James_Mai', '用户登录', '183.26.0.105', 1610420870);
INSERT INTO `cd_log` VALUES (2290, 1, 'admin', '用户登录', '117.188.3.77', 1610428192);
INSERT INTO `cd_log` VALUES (2291, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.14', 1610431271);
INSERT INTO `cd_log` VALUES (2292, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.107', 1610440386);
INSERT INTO `cd_log` VALUES (2293, 1, 'admin', '用户登录', '111.121.44.172', 1610449932);
INSERT INTO `cd_log` VALUES (2294, 233, 'linyuanyao', '用户登录', '115.204.140.106', 1610517980);
INSERT INTO `cd_log` VALUES (2295, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.14', 1610519340);
INSERT INTO `cd_log` VALUES (2296, 96, 'ytk', '用户登录', '222.186.101.241', 1610526711);
INSERT INTO `cd_log` VALUES (2297, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.107', 1610526966);
INSERT INTO `cd_log` VALUES (2298, 296, 'kangdonghuang', '用户登录', '49.74.119.14', 1610536311);
INSERT INTO `cd_log` VALUES (2299, 209, 'fjc6036', '用户登录', '183.39.162.22', 1610587430);
INSERT INTO `cd_log` VALUES (2300, 173, 'yixiang', '用户登录', '125.69.118.83', 1610587443);
INSERT INTO `cd_log` VALUES (2301, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.107', 1610609814);
INSERT INTO `cd_log` VALUES (2302, 287, 'jiangguodong', '用户登录', '220.249.162.161', 1610620409);
INSERT INTO `cd_log` VALUES (2303, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.233', 1610627970);
INSERT INTO `cd_log` VALUES (2304, 1, 'admin', '用户登录', '111.121.10.178', 1610637107);
INSERT INTO `cd_log` VALUES (2305, 263, 'jxd0454', '用户登录', '114.85.184.218', 1610682528);
INSERT INTO `cd_log` VALUES (2306, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.233', 1610689474);
INSERT INTO `cd_log` VALUES (2307, 1, 'admin', '用户登录', '117.188.3.77', 1610692971);
INSERT INTO `cd_log` VALUES (2308, 233, 'linyuanyao', '用户登录', '115.192.173.185', 1610693378);
INSERT INTO `cd_log` VALUES (2309, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.92', 1610695538);
INSERT INTO `cd_log` VALUES (2310, 233, 'linyuanyao', '用户登录', '115.192.173.185', 1610701018);
INSERT INTO `cd_log` VALUES (2311, 209, 'fjc6036', '用户登录', '113.101.237.203', 1610728557);
INSERT INTO `cd_log` VALUES (2312, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.36', 1610777379);
INSERT INTO `cd_log` VALUES (2313, 1, 'admin', '用户登录', '111.121.10.178', 1610779669);
INSERT INTO `cd_log` VALUES (2314, 298, '15916412818', '用户登录', '120.229.154.16', 1610781390);
INSERT INTO `cd_log` VALUES (2315, 298, '15916412818', '用户登录', '120.229.154.16', 1610783215);
INSERT INTO `cd_log` VALUES (2316, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.36', 1610790517);
INSERT INTO `cd_log` VALUES (2317, 298, '15916412818', '用户登录', '27.40.123.93', 1610810194);
INSERT INTO `cd_log` VALUES (2318, 1, 'admin', '用户登录', '111.121.42.173', 1610810866);
INSERT INTO `cd_log` VALUES (2319, 298, '15916412818', '用户登录', '27.40.123.93', 1610834432);
INSERT INTO `cd_log` VALUES (2320, 290, 'wangw312', '用户登录', '222.139.212.90', 1610843013);
INSERT INTO `cd_log` VALUES (2321, 1, 'admin', '用户登录', '39.144.42.159', 1610867220);
INSERT INTO `cd_log` VALUES (2322, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.36', 1610873425);
INSERT INTO `cd_log` VALUES (2323, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.92', 1610873782);
INSERT INTO `cd_log` VALUES (2324, 298, '15916412818', '用户登录', '120.229.154.52', 1610926753);
INSERT INTO `cd_log` VALUES (2325, 298, '15916412818', '用户登录', '120.229.154.52', 1610928748);
INSERT INTO `cd_log` VALUES (2326, 233, 'linyuanyao', '用户登录', '115.192.173.185', 1610936672);
INSERT INTO `cd_log` VALUES (2327, 233, 'linyuanyao', '用户登录', '115.192.173.185', 1610937136);
INSERT INTO `cd_log` VALUES (2328, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.81', 1610955028);
INSERT INTO `cd_log` VALUES (2329, 206, '小马驹', '用户登录', '182.150.116.69', 1610964740);
INSERT INTO `cd_log` VALUES (2330, 1, 'admin', '用户登录', '111.121.40.245', 1610991741);
INSERT INTO `cd_log` VALUES (2331, 1, 'admin', '用户登录', '111.121.40.245', 1611017719);
INSERT INTO `cd_log` VALUES (2332, 298, '15916412818', '用户登录', '120.229.154.52', 1611021249);
INSERT INTO `cd_log` VALUES (2333, 210, 'wshwye', '用户登录', '39.155.44.220', 1611021838);
INSERT INTO `cd_log` VALUES (2334, 1, 'admin', '用户登录', '117.132.195.137', 1611027583);
INSERT INTO `cd_log` VALUES (2335, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.210', 1611036845);
INSERT INTO `cd_log` VALUES (2336, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.1', 1611040029);
INSERT INTO `cd_log` VALUES (2337, 210, 'wshwye', '用户登录', '39.155.44.222', 1611106484);
INSERT INTO `cd_log` VALUES (2338, 210, 'wshwye', '用户登录', '39.155.44.222', 1611119366);
INSERT INTO `cd_log` VALUES (2339, 206, '小马驹', '用户登录', '182.150.116.69', 1611121044);
INSERT INTO `cd_log` VALUES (2340, 149, 'wfs', '用户登录', '123.196.12.2', 1611127558);
INSERT INTO `cd_log` VALUES (2341, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.210', 1611128508);
INSERT INTO `cd_log` VALUES (2342, 1, 'admin', '用户登录', '117.188.23.126', 1611129725);
INSERT INTO `cd_log` VALUES (2343, 59, '13299581110', '用户登录', '106.34.69.218', 1611136285);
INSERT INTO `cd_log` VALUES (2344, 59, '13299581110', '用户登录', '106.34.69.218', 1611136348);
INSERT INTO `cd_log` VALUES (2345, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.1', 1611139060);
INSERT INTO `cd_log` VALUES (2346, 1, 'admin', '用户登录', '111.121.42.91', 1611193550);
INSERT INTO `cd_log` VALUES (2347, 1, 'admin', '用户登录', '117.188.23.126', 1611210923);
INSERT INTO `cd_log` VALUES (2348, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.21', 1611217952);
INSERT INTO `cd_log` VALUES (2349, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.1', 1611220488);
INSERT INTO `cd_log` VALUES (2350, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.21', 1611228627);
INSERT INTO `cd_log` VALUES (2351, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.21', 1611293470);
INSERT INTO `cd_log` VALUES (2352, 233, 'linyuanyao', '用户登录', '60.177.236.31', 1611302593);
INSERT INTO `cd_log` VALUES (2353, 206, '小马驹', '用户登录', '182.150.116.69', 1611304986);
INSERT INTO `cd_log` VALUES (2354, 233, 'linyuanyao', '用户登录', '60.177.236.31', 1611382423);
INSERT INTO `cd_log` VALUES (2355, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.21', 1611382440);
INSERT INTO `cd_log` VALUES (2356, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.76', 1611397694);
INSERT INTO `cd_log` VALUES (2357, 210, 'wshwye', '用户登录', '39.155.44.222', 1611403049);
INSERT INTO `cd_log` VALUES (2358, 1, 'admin', '用户登录', '111.121.43.25', 1611414036);
INSERT INTO `cd_log` VALUES (2359, 209, 'fjc6036', '用户登录', '116.29.109.175', 1611452786);
INSERT INTO `cd_log` VALUES (2360, 209, 'fjc6036', '用户登录', '14.28.142.68', 1611456142);
INSERT INTO `cd_log` VALUES (2361, 209, 'fjc6036', '用户登录', '14.28.164.241', 1611463844);
INSERT INTO `cd_log` VALUES (2362, 209, 'fjc6036', '用户登录', '14.28.164.241', 1611466351);
INSERT INTO `cd_log` VALUES (2363, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.76', 1611469618);
INSERT INTO `cd_log` VALUES (2364, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.243', 1611471271);
INSERT INTO `cd_log` VALUES (2365, 233, 'linyuanyao', '用户登录', '115.192.49.208', 1611474014);
INSERT INTO `cd_log` VALUES (2366, 298, '15916412818', '用户登录', '124.240.37.233', 1611493105);
INSERT INTO `cd_log` VALUES (2367, 298, '15916412818', '用户登录', '124.240.37.233', 1611495869);
INSERT INTO `cd_log` VALUES (2368, 298, '15916412818', '用户登录', '124.240.37.233', 1611497714);
INSERT INTO `cd_log` VALUES (2369, 209, 'fjc6036', '用户登录', '116.29.109.175', 1611504190);
INSERT INTO `cd_log` VALUES (2370, 233, 'linyuanyao', '用户登录', '60.177.236.31', 1611546291);
INSERT INTO `cd_log` VALUES (2371, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.50', 1611552946);
INSERT INTO `cd_log` VALUES (2372, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.243', 1611553143);
INSERT INTO `cd_log` VALUES (2373, 149, 'wfs', '用户登录', '123.196.12.2', 1611556610);
INSERT INTO `cd_log` VALUES (2374, 1, 'admin', '用户登录', '111.121.42.27', 1611574429);
INSERT INTO `cd_log` VALUES (2375, 209, 'fjc6036', '用户登录', '116.29.109.126', 1611594113);
INSERT INTO `cd_log` VALUES (2376, 336, 'cctv9595', '用户登录', '113.99.217.69', 1611600919);
INSERT INTO `cd_log` VALUES (2377, 233, 'linyuanyao', '用户登录', '60.177.236.31', 1611632741);
INSERT INTO `cd_log` VALUES (2378, 233, 'linyuanyao', '用户登录', '60.177.236.31', 1611635769);
INSERT INTO `cd_log` VALUES (2379, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.243', 1611647188);
INSERT INTO `cd_log` VALUES (2380, 233, 'linyuanyao', '用户登录', '115.216.12.39', 1611654273);
INSERT INTO `cd_log` VALUES (2381, 1, 'admin', '用户登录', '111.121.42.27', 1611661296);
INSERT INTO `cd_log` VALUES (2382, 209, 'fjc6036', '用户登录', '116.29.109.126', 1611682213);
INSERT INTO `cd_log` VALUES (2383, 209, 'fjc6036', '用户登录', '116.29.109.126', 1611682296);
INSERT INTO `cd_log` VALUES (2384, 298, '15916412818', '用户登录', '27.40.103.125', 1611708144);
INSERT INTO `cd_log` VALUES (2385, 122, '巴帝洛克金鼎店', '用户登录', '182.86.202.155', 1611711504);
INSERT INTO `cd_log` VALUES (2386, 1, 'admin', '用户登录', '117.189.26.123', 1611728503);
INSERT INTO `cd_log` VALUES (2387, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.231', 1611747643);
INSERT INTO `cd_log` VALUES (2388, 1, 'admin', '用户登录', '111.121.43.84', 1611782788);
INSERT INTO `cd_log` VALUES (2389, 233, 'linyuanyao', '用户登录', '115.216.12.39', 1611805001);
INSERT INTO `cd_log` VALUES (2390, 263, 'jxd0454', '用户登录', '223.104.213.41', 1611805529);
INSERT INTO `cd_log` VALUES (2391, 263, 'jxd0454', '用户登录', '223.104.213.41', 1611805585);
INSERT INTO `cd_log` VALUES (2392, 263, 'jxd0454', '用户登录', '223.104.213.41', 1611805864);
INSERT INTO `cd_log` VALUES (2393, 263, 'jxd0454', '用户登录', '223.104.213.41', 1611807126);
INSERT INTO `cd_log` VALUES (2394, 1, 'admin', '用户登录', '117.189.26.123', 1611807862);
INSERT INTO `cd_log` VALUES (2395, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.175', 1611823655);
INSERT INTO `cd_log` VALUES (2396, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.175', 1611829571);
INSERT INTO `cd_log` VALUES (2397, 336, 'cctv9595', '用户登录', '113.99.217.69', 1611844464);
INSERT INTO `cd_log` VALUES (2398, 209, 'fjc6036', '用户登录', '183.39.150.149', 1611846276);
INSERT INTO `cd_log` VALUES (2399, 263, 'jxd0454', '用户登录', '223.104.213.41', 1611893900);
INSERT INTO `cd_log` VALUES (2400, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.231', 1611900064);
INSERT INTO `cd_log` VALUES (2401, 209, 'fjc6036', '用户登录', '119.138.192.106', 1611930982);
INSERT INTO `cd_log` VALUES (2402, 209, 'fjc6036', '用户登录', '113.101.236.244', 1611953872);
INSERT INTO `cd_log` VALUES (2403, 210, 'wshwye', '用户登录', '39.155.44.215', 1611972140);
INSERT INTO `cd_log` VALUES (2404, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.104', 1611984358);
INSERT INTO `cd_log` VALUES (2405, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.104', 1611994193);
INSERT INTO `cd_log` VALUES (2406, 122, '巴帝洛克金鼎店', '用户登录', '118.212.207.190', 1611994583);
INSERT INTO `cd_log` VALUES (2407, 122, '巴帝洛克金鼎店', '用户登录', '118.212.207.190', 1611994611);
INSERT INTO `cd_log` VALUES (2408, 122, '巴帝洛克金鼎店', '用户登录', '118.212.207.190', 1611994762);
INSERT INTO `cd_log` VALUES (2409, 209, 'fjc6036', '用户登录', '113.101.236.244', 1612010336);
INSERT INTO `cd_log` VALUES (2410, 210, 'wshwye', '用户登录', '110.6.46.155', 1612049982);
INSERT INTO `cd_log` VALUES (2411, 1, 'admin', '用户登录', '111.121.10.252', 1612054484);
INSERT INTO `cd_log` VALUES (2412, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.104', 1612071218);
INSERT INTO `cd_log` VALUES (2413, 209, 'fjc6036', '用户登录', '183.39.168.251', 1612098302);
INSERT INTO `cd_log` VALUES (2414, 298, '15916412818', '用户登录', '124.240.45.203', 1612110440);
INSERT INTO `cd_log` VALUES (2415, 298, '15916412818', '用户登录', '124.240.45.203', 1612110599);
INSERT INTO `cd_log` VALUES (2416, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.104', 1612166744);
INSERT INTO `cd_log` VALUES (2417, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1612167191);
INSERT INTO `cd_log` VALUES (2418, 263, 'jxd0454', '用户登录', '121.231.4.59', 1612173844);
INSERT INTO `cd_log` VALUES (2419, 209, 'fjc6036', '用户登录', '14.30.144.111', 1612189790);
INSERT INTO `cd_log` VALUES (2420, 209, 'fjc6036', '用户登录', '113.101.238.169', 1612194178);
INSERT INTO `cd_log` VALUES (2421, 209, 'fjc6036', '用户登录', '113.101.238.169', 1612226844);
INSERT INTO `cd_log` VALUES (2422, 263, 'jxd0454', '用户登录', '121.231.4.59', 1612232003);
INSERT INTO `cd_log` VALUES (2423, 276, 'jerry', '用户登录', '121.231.4.59', 1612232178);
INSERT INTO `cd_log` VALUES (2424, 276, 'jerry', '用户登录', '121.231.4.59', 1612235127);
INSERT INTO `cd_log` VALUES (2425, 1, 'admin', '用户登录', '117.189.26.123', 1612236927);
INSERT INTO `cd_log` VALUES (2426, 1, 'admin', '用户登录', '117.189.26.123', 1612237952);
INSERT INTO `cd_log` VALUES (2427, 276, 'jerry', '用户登录', '121.231.4.59', 1612240032);
INSERT INTO `cd_log` VALUES (2428, 276, 'jerry', '用户登录', '117.136.39.224', 1612249677);
INSERT INTO `cd_log` VALUES (2429, 276, 'jerry', '用户登录', '121.231.4.59', 1612250708);
INSERT INTO `cd_log` VALUES (2430, 1, 'admin', '用户登录', '117.189.26.123', 1612250853);
INSERT INTO `cd_log` VALUES (2431, 209, 'fjc6036', '用户登录', '113.101.237.36', 1612260794);
INSERT INTO `cd_log` VALUES (2432, 209, 'fjc6036', '用户登录', '113.101.237.36', 1612262191);
INSERT INTO `cd_log` VALUES (2433, 1, 'admin', '用户登录', '111.121.11.221', 1612262563);
INSERT INTO `cd_log` VALUES (2434, 209, 'fjc6036', '用户登录', '183.39.149.82', 1612273685);
INSERT INTO `cd_log` VALUES (2435, 329, 'JACY', '用户登录', '121.236.28.151', 1612278816);
INSERT INTO `cd_log` VALUES (2436, 336, 'cctv9595', '用户登录', '113.99.217.69', 1612289097);
INSERT INTO `cd_log` VALUES (2437, 96, 'ytk', '用户登录', '222.186.101.241', 1612313389);
INSERT INTO `cd_log` VALUES (2438, 276, 'jerry', '用户登录', '120.197.165.126', 1612314968);
INSERT INTO `cd_log` VALUES (2439, 276, 'jerry', '用户登录', '121.231.4.59', 1612315535);
INSERT INTO `cd_log` VALUES (2440, 276, 'jerry', '用户登录', '121.231.4.59', 1612316762);
INSERT INTO `cd_log` VALUES (2441, 233, 'linyuanyao', '用户登录', '115.206.8.236', 1612325891);
INSERT INTO `cd_log` VALUES (2442, 329, 'JACY', '用户登录', '121.236.28.151', 1612330778);
INSERT INTO `cd_log` VALUES (2443, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.94', 1612331438);
INSERT INTO `cd_log` VALUES (2444, 209, 'fjc6036', '用户登录', '113.101.239.3', 1612347839);
INSERT INTO `cd_log` VALUES (2445, 209, 'fjc6036', '用户登录', '116.29.108.159', 1612358159);
INSERT INTO `cd_log` VALUES (2446, 276, 'jerry', '用户登录', '120.197.165.126', 1612408171);
INSERT INTO `cd_log` VALUES (2447, 263, 'jxd0454', '用户登录', '121.231.4.59', 1612411540);
INSERT INTO `cd_log` VALUES (2448, 276, 'jerry', '用户登录', '121.231.4.59', 1612411887);
INSERT INTO `cd_log` VALUES (2449, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.94', 1612426561);
INSERT INTO `cd_log` VALUES (2450, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.94', 1612434570);
INSERT INTO `cd_log` VALUES (2451, 122, '巴帝洛克金鼎店', '用户登录', '111.73.173.94', 1612440933);
INSERT INTO `cd_log` VALUES (2452, 209, 'fjc6036', '用户登录', '116.29.108.159', 1612445026);
INSERT INTO `cd_log` VALUES (2453, 276, 'jerry', '用户登录', '121.231.4.59', 1612494540);
INSERT INTO `cd_log` VALUES (2454, 276, 'jerry', '用户登录', '121.231.4.59', 1612497364);
INSERT INTO `cd_log` VALUES (2455, 209, 'fjc6036', '用户登录', '183.39.156.73', 1612530691);
INSERT INTO `cd_log` VALUES (2456, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.67', 1612609097);
INSERT INTO `cd_log` VALUES (2457, 209, 'fjc6036', '用户登录', '183.39.148.12', 1612617167);
INSERT INTO `cd_log` VALUES (2458, 209, 'fjc6036', '用户登录', '119.138.192.116', 1612634649);
INSERT INTO `cd_log` VALUES (2459, 209, 'fjc6036', '用户登录', '183.39.148.12', 1612634905);
INSERT INTO `cd_log` VALUES (2460, 209, 'fjc6036', '用户登录', '183.39.148.12', 1612634947);
INSERT INTO `cd_log` VALUES (2461, 233, 'linyuanyao', '用户登录', '115.206.8.236', 1612673086);
INSERT INTO `cd_log` VALUES (2462, 233, 'linyuanyao', '用户登录', '115.206.8.236', 1612673193);
INSERT INTO `cd_log` VALUES (2463, 149, 'wfs', '用户登录', '123.196.12.131', 1612675169);
INSERT INTO `cd_log` VALUES (2464, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.67', 1612699109);
INSERT INTO `cd_log` VALUES (2465, 209, 'fjc6036', '用户登录', '14.28.159.69', 1612702382);
INSERT INTO `cd_log` VALUES (2466, 209, 'fjc6036', '用户登录', '183.39.138.56', 1612711320);
INSERT INTO `cd_log` VALUES (2467, 209, 'fjc6036', '用户登录', '183.39.138.56', 1612728322);
INSERT INTO `cd_log` VALUES (2468, 277, '007', '用户登录', '120.197.165.123', 1612746784);
INSERT INTO `cd_log` VALUES (2469, 263, 'jxd0454', '用户登录', '121.231.4.59', 1612747383);
INSERT INTO `cd_log` VALUES (2470, 233, 'linyuanyao', '用户登录', '115.198.242.242', 1612761933);
INSERT INTO `cd_log` VALUES (2471, 233, 'linyuanyao', '用户登录', '115.198.242.242', 1612762780);
INSERT INTO `cd_log` VALUES (2472, 233, 'linyuanyao', '用户登录', '115.198.242.242', 1612763143);
INSERT INTO `cd_log` VALUES (2473, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.88', 1612763226);
INSERT INTO `cd_log` VALUES (2474, 1, 'admin', '用户登录', '117.188.14.99', 1612769951);
INSERT INTO `cd_log` VALUES (2475, 277, '007', '用户登录', '121.231.4.59', 1612772432);
INSERT INTO `cd_log` VALUES (2476, 209, 'fjc6036', '用户登录', '14.28.128.191', 1612801344);
INSERT INTO `cd_log` VALUES (2477, 122, '巴帝洛克金鼎店', '用户登录', '111.73.172.107', 1612862052);
INSERT INTO `cd_log` VALUES (2478, 206, '小马驹', '用户登录', '125.70.179.46', 1612865820);
INSERT INTO `cd_log` VALUES (2479, 336, 'cctv9595', '用户登录', '223.74.20.93', 1612882938);
INSERT INTO `cd_log` VALUES (2480, 233, 'linyuanyao', '用户登录', '218.72.122.5', 1612940766);
INSERT INTO `cd_log` VALUES (2481, 233, 'linyuanyao', '用户登录', '218.72.122.5', 1613006623);
INSERT INTO `cd_log` VALUES (2482, 361, 'lanshicai', '用户登录', '117.136.41.62', 1613030384);
INSERT INTO `cd_log` VALUES (2483, 233, 'linyuanyao', '用户登录', '125.119.204.134', 1613177636);
INSERT INTO `cd_log` VALUES (2484, 298, '15916412818', '用户登录', '14.21.175.20', 1613184528);
INSERT INTO `cd_log` VALUES (2485, 209, 'fjc6036', '用户登录', '183.39.153.59', 1613403512);
INSERT INTO `cd_log` VALUES (2486, 209, 'fjc6036', '用户登录', '14.28.130.60', 1613485779);
INSERT INTO `cd_log` VALUES (2487, 336, 'cctv9595', '用户登录', '223.74.20.39', 1613569236);
INSERT INTO `cd_log` VALUES (2488, 209, 'fjc6036', '用户登录', '116.29.109.136', 1613574456);
INSERT INTO `cd_log` VALUES (2489, 290, 'wangw312', '用户登录', '222.139.212.90', 1613637933);
INSERT INTO `cd_log` VALUES (2490, 298, '15916412818', '用户登录', '124.240.40.133', 1613646132);
INSERT INTO `cd_log` VALUES (2491, 198, 'pengzq_168', '用户登录', '123.113.248.222', 1613646617);
INSERT INTO `cd_log` VALUES (2492, 209, 'fjc6036', '用户登录', '116.29.109.136', 1613660539);
INSERT INTO `cd_log` VALUES (2493, 209, 'fjc6036', '用户登录', '116.29.109.136', 1613666602);
INSERT INTO `cd_log` VALUES (2494, 209, 'fjc6036', '用户登录', '116.29.109.136', 1613666660);
INSERT INTO `cd_log` VALUES (2495, 209, 'fjc6036', '用户登录', '116.29.109.158', 1613669531);
INSERT INTO `cd_log` VALUES (2496, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.53', 1613703196);
INSERT INTO `cd_log` VALUES (2497, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.53', 1613721367);
INSERT INTO `cd_log` VALUES (2498, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.53', 1613722017);
INSERT INTO `cd_log` VALUES (2499, 100, 'liwang', '用户登录', '106.108.45.225', 1613726951);
INSERT INTO `cd_log` VALUES (2500, 172, '17505919990', '用户登录', '61.241.205.51', 1613728619);
INSERT INTO `cd_log` VALUES (2501, 172, '17505919990', '用户登录', '61.241.205.51', 1613729373);
INSERT INTO `cd_log` VALUES (2502, 172, '17505919990', '用户登录', '61.241.205.51', 1613729503);
INSERT INTO `cd_log` VALUES (2503, 209, 'fjc6036', '用户登录', '14.30.148.88', 1613741854);
INSERT INTO `cd_log` VALUES (2504, 209, 'fjc6036', '用户登录', '116.29.109.158', 1613763546);
INSERT INTO `cd_log` VALUES (2505, 172, '17505919990', '用户登录', '36.251.99.149', 1613793736);
INSERT INTO `cd_log` VALUES (2506, 172, '17505919990', '用户登录', '61.241.205.51', 1613796626);
INSERT INTO `cd_log` VALUES (2507, 172, '17505919990', '用户登录', '61.241.205.51', 1613796896);
INSERT INTO `cd_log` VALUES (2508, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.53', 1613804989);
INSERT INTO `cd_log` VALUES (2509, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.181', 1613810070);
INSERT INTO `cd_log` VALUES (2510, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.53', 1613820393);
INSERT INTO `cd_log` VALUES (2511, 122, '巴帝洛克金鼎店', '用户登录', '182.86.201.53', 1613890355);
INSERT INTO `cd_log` VALUES (2512, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1613891283);
INSERT INTO `cd_log` VALUES (2513, 209, 'fjc6036', '用户登录', '14.30.167.190', 1613901532);
INSERT INTO `cd_log` VALUES (2514, 122, '巴帝洛克金鼎店', '用户登录', '118.212.201.165', 1613904660);
INSERT INTO `cd_log` VALUES (2515, 209, 'fjc6036', '用户登录', '14.30.167.190', 1613920601);
INSERT INTO `cd_log` VALUES (2516, 146, 'matai112', '用户登录', '106.121.158.223', 1613970192);
INSERT INTO `cd_log` VALUES (2517, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.57', 1613971194);
INSERT INTO `cd_log` VALUES (2518, 1, 'admin', '用户登录', '117.189.27.115', 1613974655);
INSERT INTO `cd_log` VALUES (2519, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1613975033);
INSERT INTO `cd_log` VALUES (2520, 206, '小马驹', '用户登录', '110.185.219.162', 1613982473);
INSERT INTO `cd_log` VALUES (2521, 206, '小马驹', '用户登录', '110.185.219.162', 1613982632);
INSERT INTO `cd_log` VALUES (2522, 149, 'wfs', '用户登录', '123.196.12.131', 1613983207);
INSERT INTO `cd_log` VALUES (2523, 1, 'admin', '用户登录', '117.189.27.115', 1613986776);
INSERT INTO `cd_log` VALUES (2524, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1613987278);
INSERT INTO `cd_log` VALUES (2525, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1613994355);
INSERT INTO `cd_log` VALUES (2526, 209, 'fjc6036', '用户登录', '183.39.165.207', 1614003570);
INSERT INTO `cd_log` VALUES (2527, 1, 'admin', '用户登录', '111.121.40.39', 1614004432);
INSERT INTO `cd_log` VALUES (2528, 233, 'linyuanyao', '用户登录', '115.216.48.236', 1614043713);
INSERT INTO `cd_log` VALUES (2529, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.166', 1614046292);
INSERT INTO `cd_log` VALUES (2530, 149, 'wfs', '用户登录', '123.196.12.28', 1614056461);
INSERT INTO `cd_log` VALUES (2531, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1614058572);
INSERT INTO `cd_log` VALUES (2532, 233, 'linyuanyao', '用户登录', '115.216.48.236', 1614061083);
INSERT INTO `cd_log` VALUES (2533, 233, 'linyuanyao', '用户登录', '112.17.240.237', 1614063398);
INSERT INTO `cd_log` VALUES (2534, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1614066933);
INSERT INTO `cd_log` VALUES (2535, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1614075751);
INSERT INTO `cd_log` VALUES (2536, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1614083081);
INSERT INTO `cd_log` VALUES (2537, 209, 'fjc6036', '用户登录', '14.28.133.19', 1614091445);
INSERT INTO `cd_log` VALUES (2538, 233, 'linyuanyao', '用户登录', '36.24.233.159', 1614139425);
INSERT INTO `cd_log` VALUES (2539, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.131', 1614144990);
INSERT INTO `cd_log` VALUES (2540, 1, 'admin', '用户登录', '111.121.40.112', 1614146156);
INSERT INTO `cd_log` VALUES (2541, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1614147111);
INSERT INTO `cd_log` VALUES (2542, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.56', 1614147556);
INSERT INTO `cd_log` VALUES (2543, 1, 'admin', '用户登录', '117.189.27.115', 1614165457);
INSERT INTO `cd_log` VALUES (2544, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614167219);
INSERT INTO `cd_log` VALUES (2545, 209, 'fjc6036', '用户登录', '183.39.151.171', 1614178663);
INSERT INTO `cd_log` VALUES (2546, 206, '小马驹', '用户登录', '110.185.219.162', 1614222830);
INSERT INTO `cd_log` VALUES (2547, 50, 'lwang', '用户登录', '117.189.27.115', 1614233546);
INSERT INTO `cd_log` VALUES (2548, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614238938);
INSERT INTO `cd_log` VALUES (2549, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614239249);
INSERT INTO `cd_log` VALUES (2550, 209, 'fjc6036', '用户登录', '14.27.50.65', 1614265855);
INSERT INTO `cd_log` VALUES (2551, 336, 'cctv9595', '用户登录', '121.9.140.114', 1614286935);
INSERT INTO `cd_log` VALUES (2552, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.131', 1614323759);
INSERT INTO `cd_log` VALUES (2553, 209, 'fjc6036', '用户登录', '14.28.167.3', 1614352498);
INSERT INTO `cd_log` VALUES (2554, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614406452);
INSERT INTO `cd_log` VALUES (2555, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614412750);
INSERT INTO `cd_log` VALUES (2556, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.147', 1614413108);
INSERT INTO `cd_log` VALUES (2557, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614415024);
INSERT INTO `cd_log` VALUES (2558, 122, '巴帝洛克金鼎店', '用户登录', '182.86.206.172', 1614415593);
INSERT INTO `cd_log` VALUES (2559, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614430259);
INSERT INTO `cd_log` VALUES (2560, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614430389);
INSERT INTO `cd_log` VALUES (2561, 209, 'fjc6036', '用户登录', '113.101.239.130', 1614435615);
INSERT INTO `cd_log` VALUES (2562, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614493231);
INSERT INTO `cd_log` VALUES (2563, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614513889);
INSERT INTO `cd_log` VALUES (2564, 209, 'fjc6036', '用户登录', '14.28.128.123', 1614527805);
INSERT INTO `cd_log` VALUES (2565, 233, 'linyuanyao', '用户登录', '122.235.203.69', 1614569254);
INSERT INTO `cd_log` VALUES (2566, 233, 'linyuanyao', '用户登录', '122.235.203.69', 1614573957);
INSERT INTO `cd_log` VALUES (2567, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614579991);
INSERT INTO `cd_log` VALUES (2568, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.129', 1614584420);
INSERT INTO `cd_log` VALUES (2569, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614595325);
INSERT INTO `cd_log` VALUES (2570, 209, 'fjc6036', '用户登录', '14.25.158.243', 1614612095);
INSERT INTO `cd_log` VALUES (2571, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.129', 1614652780);
INSERT INTO `cd_log` VALUES (2572, 277, '007', '用户登录', '114.228.34.62', 1614653753);
INSERT INTO `cd_log` VALUES (2573, 277, '007', '用户登录', '114.228.34.62', 1614653806);
INSERT INTO `cd_log` VALUES (2574, 277, '007', '用户登录', '114.228.34.62', 1614654648);
INSERT INTO `cd_log` VALUES (2575, 277, '007', '用户登录', '114.228.34.62', 1614655017);
INSERT INTO `cd_log` VALUES (2576, 1, 'admin', '用户登录', '117.189.27.115', 1614664793);
INSERT INTO `cd_log` VALUES (2577, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.98', 1614668323);
INSERT INTO `cd_log` VALUES (2578, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.111', 1614677410);
INSERT INTO `cd_log` VALUES (2579, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.111', 1614679180);
INSERT INTO `cd_log` VALUES (2580, 209, 'fjc6036', '用户登录', '113.101.236.30', 1614697163);
INSERT INTO `cd_log` VALUES (2581, 393, 'yiming', '用户登录', '113.118.87.96', 1614736479);
INSERT INTO `cd_log` VALUES (2582, 233, 'linyuanyao', '用户登录', '115.193.220.137', 1614759977);
INSERT INTO `cd_log` VALUES (2583, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.129', 1614763828);
INSERT INTO `cd_log` VALUES (2584, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.111', 1614770784);
INSERT INTO `cd_log` VALUES (2585, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.111', 1614775459);
INSERT INTO `cd_log` VALUES (2586, 209, 'fjc6036', '用户登录', '116.29.108.41', 1614783248);
INSERT INTO `cd_log` VALUES (2587, 210, 'wshwye', '用户登录', '39.155.44.25', 1614843451);
INSERT INTO `cd_log` VALUES (2588, 329, 'JACY', '用户登录', '114.217.211.192', 1614843550);
INSERT INTO `cd_log` VALUES (2589, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.167', 1614924969);
INSERT INTO `cd_log` VALUES (2590, 1, 'admin', '用户登录', '117.188.8.80', 1614934605);
INSERT INTO `cd_log` VALUES (2591, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1614943629);
INSERT INTO `cd_log` VALUES (2592, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1614950930);
INSERT INTO `cd_log` VALUES (2593, 209, 'fjc6036', '用户登录', '14.27.40.221', 1614955838);
INSERT INTO `cd_log` VALUES (2594, 336, 'cctv9595', '用户登录', '113.99.217.205', 1615012159);
INSERT INTO `cd_log` VALUES (2595, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1615014060);
INSERT INTO `cd_log` VALUES (2596, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.167', 1615015361);
INSERT INTO `cd_log` VALUES (2597, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1615033495);
INSERT INTO `cd_log` VALUES (2598, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1615034386);
INSERT INTO `cd_log` VALUES (2599, 209, 'fjc6036', '用户登录', '14.27.43.156', 1615043709);
INSERT INTO `cd_log` VALUES (2600, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.170', 1615100670);
INSERT INTO `cd_log` VALUES (2601, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1615119767);
INSERT INTO `cd_log` VALUES (2602, 209, 'fjc6036', '用户登录', '14.25.150.118', 1615134703);
INSERT INTO `cd_log` VALUES (2603, 1, 'admin', '用户登录', '111.121.47.142', 1615166539);
INSERT INTO `cd_log` VALUES (2604, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.170', 1615186225);
INSERT INTO `cd_log` VALUES (2605, 122, '巴帝洛克金鼎店', '用户登录', '182.86.207.52', 1615193475);
INSERT INTO `cd_log` VALUES (2606, 404, 'VISIONS001', '用户登录', '119.123.207.5', 1615203100);
INSERT INTO `cd_log` VALUES (2607, 336, 'cctv9595', '用户登录', '113.99.217.205', 1615212389);
INSERT INTO `cd_log` VALUES (2608, 393, 'yiming', '用户登录', '113.118.84.32', 1615218375);
INSERT INTO `cd_log` VALUES (2609, 1, 'admin', '用户登录', '117.188.8.80', 1615270832);
INSERT INTO `cd_log` VALUES (2610, 406, 'wqwdtech', '用户登录', '115.171.244.165', 1615275583);
INSERT INTO `cd_log` VALUES (2611, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.170', 1615277414);
INSERT INTO `cd_log` VALUES (2612, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.152', 1615287374);
INSERT INTO `cd_log` VALUES (2613, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.245', 1615355847);
INSERT INTO `cd_log` VALUES (2614, 1, 'admin', '用户登录', '117.188.8.80', 1615362955);
INSERT INTO `cd_log` VALUES (2615, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.152', 1615372929);
INSERT INTO `cd_log` VALUES (2616, 122, '巴帝洛克金鼎店', '用户登录', '111.73.174.152', 1615442807);
INSERT INTO `cd_log` VALUES (2617, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.245', 1615444936);
INSERT INTO `cd_log` VALUES (2618, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.231', 1615461847);
INSERT INTO `cd_log` VALUES (2619, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.17', 1615541710);
INSERT INTO `cd_log` VALUES (2620, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.231', 1615544588);
INSERT INTO `cd_log` VALUES (2621, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.231', 1615553331);
INSERT INTO `cd_log` VALUES (2622, 122, '巴帝洛克金鼎店', '用户登录', '182.86.204.231', 1615553875);
INSERT INTO `cd_log` VALUES (2623, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.109', 1615604244);
INSERT INTO `cd_log` VALUES (2624, 415, 'zaozao198412', '用户登录', '39.170.29.94', 1615615265);
INSERT INTO `cd_log` VALUES (2625, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.17', 1615624058);
INSERT INTO `cd_log` VALUES (2626, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.109', 1615636588);
INSERT INTO `cd_log` VALUES (2627, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.109', 1615712688);
INSERT INTO `cd_log` VALUES (2628, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.17', 1615725195);
INSERT INTO `cd_log` VALUES (2629, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.164', 1615787016);
INSERT INTO `cd_log` VALUES (2630, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.109', 1615790875);
INSERT INTO `cd_log` VALUES (2631, 122, '巴帝洛克金鼎店', '用户登录', '111.73.175.109', 1615808853);
INSERT INTO `cd_log` VALUES (2632, 122, '巴帝洛克金鼎店', '用户登录', '182.86.203.18', 1615880457);
INSERT INTO `cd_log` VALUES (2633, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.164', 1615884207);
INSERT INTO `cd_log` VALUES (2634, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.64', 1615891192);
INSERT INTO `cd_log` VALUES (2635, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.64', 1615897942);
INSERT INTO `cd_log` VALUES (2636, 209, 'fjc6036', '用户登录', '14.30.171.180', 1615937185);
INSERT INTO `cd_log` VALUES (2637, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.164', 1615959894);
INSERT INTO `cd_log` VALUES (2638, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.64', 1615968331);
INSERT INTO `cd_log` VALUES (2639, 406, 'wqwdtech', '用户登录', '61.50.122.182', 1615970927);
INSERT INTO `cd_log` VALUES (2640, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.64', 1615981949);
INSERT INTO `cd_log` VALUES (2641, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1616044933);
INSERT INTO `cd_log` VALUES (2642, 122, '巴帝洛克金鼎店', '用户登录', '111.73.168.64', 1616062608);
INSERT INTO `cd_log` VALUES (2643, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1616134942);
INSERT INTO `cd_log` VALUES (2644, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.24', 1616142324);
INSERT INTO `cd_log` VALUES (2645, 436, '1314young', '用户登录', '223.74.194.166', 1616217208);
INSERT INTO `cd_log` VALUES (2646, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1616238793);
INSERT INTO `cd_log` VALUES (2647, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.24', 1616241804);
INSERT INTO `cd_log` VALUES (2648, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1616308178);
INSERT INTO `cd_log` VALUES (2649, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.24', 1616321506);
INSERT INTO `cd_log` VALUES (2650, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.24', 1616321673);
INSERT INTO `cd_log` VALUES (2651, 170, '易能森智能', '用户登录', '61.154.119.130', 1616327139);
INSERT INTO `cd_log` VALUES (2652, 170, '易能森智能', '用户登录', '61.154.119.130', 1616327315);
INSERT INTO `cd_log` VALUES (2653, 170, '易能森智能', '用户登录', '61.154.119.130', 1616327457);
INSERT INTO `cd_log` VALUES (2654, 170, '易能森智能', '用户登录', '61.154.119.130', 1616329081);
INSERT INTO `cd_log` VALUES (2655, 122, '巴帝洛克金鼎店', '用户登录', '111.73.170.24', 1616329443);
INSERT INTO `cd_log` VALUES (2656, 216, 'chen', '用户登录', '115.214.105.245', 1616376571);
INSERT INTO `cd_log` VALUES (2657, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.196', 1616393557);
INSERT INTO `cd_log` VALUES (2658, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616417397);
INSERT INTO `cd_log` VALUES (2659, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616480265);
INSERT INTO `cd_log` VALUES (2660, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616480330);
INSERT INTO `cd_log` VALUES (2661, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616480396);
INSERT INTO `cd_log` VALUES (2662, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616481045);
INSERT INTO `cd_log` VALUES (2663, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616481232);
INSERT INTO `cd_log` VALUES (2664, 446, 'BDRK2018', '用户登录', '182.86.205.42', 1616481687);
INSERT INTO `cd_log` VALUES (2665, 176, '郭晓宁', '用户登录', '112.96.68.254', 1616486357);
INSERT INTO `cd_log` VALUES (2666, 206, '小马驹', '用户登录', '222.220.10.250', 1616507700);
INSERT INTO `cd_log` VALUES (2667, 170, '易能森智能', '用户登录', '61.154.119.130', 1616552862);
INSERT INTO `cd_log` VALUES (2668, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.191', 1616563960);
INSERT INTO `cd_log` VALUES (2669, 206, '小马驹', '用户登录', '182.241.222.226', 1616576570);
INSERT INTO `cd_log` VALUES (2670, 122, '巴帝洛克金鼎店', '用户登录', '182.86.205.42', 1616580563);
INSERT INTO `cd_log` VALUES (2671, 446, 'BDRK2018', '用户登录', '182.86.205.42', 1616580745);
INSERT INTO `cd_log` VALUES (2672, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.191', 1616650331);
INSERT INTO `cd_log` VALUES (2673, 202, 'silencelam', '用户登录', '113.111.44.175', 1616663215);
INSERT INTO `cd_log` VALUES (2674, 202, 'silencelam', '用户登录', '113.111.44.175', 1616663308);
INSERT INTO `cd_log` VALUES (2675, 446, 'BDRK2018', '用户登录', '182.86.207.234', 1616667690);
INSERT INTO `cd_log` VALUES (2676, 446, 'BDRK2018', '用户登录', '182.86.207.234', 1616670480);
INSERT INTO `cd_log` VALUES (2677, 1, 'admin', '用户登录', '117.189.26.114', 1616725579);
INSERT INTO `cd_log` VALUES (2678, 446, 'BDRK2018', '用户登录', '182.86.207.234', 1616738792);
INSERT INTO `cd_log` VALUES (2679, 50, 'lwang', '用户登录', '117.189.26.114', 1616747084);
INSERT INTO `cd_log` VALUES (2680, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1616753218);
INSERT INTO `cd_log` VALUES (2681, 50, 'lwang', '用户登录', '117.189.26.114', 1616753687);
INSERT INTO `cd_log` VALUES (2682, 329, 'JACY', '用户登录', '222.93.110.105', 1616775964);
INSERT INTO `cd_log` VALUES (2683, 209, 'fjc6036', '用户登录', '14.27.0.204', 1616819385);
INSERT INTO `cd_log` VALUES (2684, 176, '郭晓宁', '用户登录', '112.96.67.54', 1616896863);
INSERT INTO `cd_log` VALUES (2685, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1616912715);
INSERT INTO `cd_log` VALUES (2686, 446, 'BDRK2018', '用户登录', '182.86.205.236', 1616994786);
INSERT INTO `cd_log` VALUES (2687, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1617000219);
INSERT INTO `cd_log` VALUES (2688, 1, 'admin', '用户登录', '117.189.26.114', 1617000343);
INSERT INTO `cd_log` VALUES (2689, 176, '郭晓宁', '用户登录', '112.96.102.5', 1617071317);
INSERT INTO `cd_log` VALUES (2690, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1617082617);
INSERT INTO `cd_log` VALUES (2691, 446, 'BDRK2018', '用户登录', '182.86.205.236', 1617082980);
INSERT INTO `cd_log` VALUES (2692, 446, 'BDRK2018', '用户登录', '182.86.205.236', 1617109242);
INSERT INTO `cd_log` VALUES (2693, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1617169236);
INSERT INTO `cd_log` VALUES (2694, 473, 'relx01696', '用户登录', '58.212.19.114', 1617170620);
INSERT INTO `cd_log` VALUES (2695, 446, 'BDRK2018', '用户登录', '182.86.205.236', 1617176001);
INSERT INTO `cd_log` VALUES (2696, 446, 'BDRK2018', '用户登录', '182.86.203.42', 1617190476);
INSERT INTO `cd_log` VALUES (2697, 446, 'BDRK2018', '用户登录', '182.86.203.42', 1617190687);
INSERT INTO `cd_log` VALUES (2698, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1617258321);
INSERT INTO `cd_log` VALUES (2699, 50, 'lwang', '用户登录', '117.188.19.228', 1617260406);
INSERT INTO `cd_log` VALUES (2700, 209, 'fjc6036', '用户登录', '113.101.237.33', 1617263067);
INSERT INTO `cd_log` VALUES (2701, 446, 'BDRK2018', '用户登录', '182.86.203.42', 1617279659);
INSERT INTO `cd_log` VALUES (2702, 209, 'fjc6036', '用户登录', '113.101.236.209', 1617342802);
INSERT INTO `cd_log` VALUES (2703, 446, 'BDRK2018', '用户登录', '182.86.200.77', 1617347987);
INSERT INTO `cd_log` VALUES (2704, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.164', 1617350303);
INSERT INTO `cd_log` VALUES (2705, 213, 'kent', '用户登录', '223.73.226.147', 1617438962);
INSERT INTO `cd_log` VALUES (2706, 446, 'BDRK2018', '用户登录', '59.63.20.109', 1617444847);
INSERT INTO `cd_log` VALUES (2707, 100, 'liwang', '用户登录', '103.242.215.224', 1617585819);
INSERT INTO `cd_log` VALUES (2708, 475, 'nca000', '用户登录', '118.73.158.140', 1617590638);
INSERT INTO `cd_log` VALUES (2709, 475, 'nca000', '用户登录', '118.73.158.140', 1617596075);
INSERT INTO `cd_log` VALUES (2710, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1617625992);
INSERT INTO `cd_log` VALUES (2711, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1617683625);
INSERT INTO `cd_log` VALUES (2712, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1617688135);
INSERT INTO `cd_log` VALUES (2713, 213, 'kent', '用户登录', '223.73.226.90', 1617688255);
INSERT INTO `cd_log` VALUES (2714, 446, 'BDRK2018', '用户登录', '111.73.173.182', 1617695089);
INSERT INTO `cd_log` VALUES (2715, 329, 'JACY', '用户登录', '222.93.110.105', 1617711485);
INSERT INTO `cd_log` VALUES (2716, 176, '郭晓宁', '用户登录', '112.96.70.247', 1617765048);
INSERT INTO `cd_log` VALUES (2717, 446, 'BDRK2018', '用户登录', '111.73.173.182', 1617779304);
INSERT INTO `cd_log` VALUES (2718, 202, 'silencelam', '用户登录', '218.19.102.222', 1617779568);
INSERT INTO `cd_log` VALUES (2719, 301, 'demo', '用户登录', '117.188.25.248', 1617779697);
INSERT INTO `cd_log` VALUES (2720, 446, 'BDRK2018', '用户登录', '111.73.173.182', 1617782682);
INSERT INTO `cd_log` VALUES (2721, 50, 'lwang', '用户登录', '117.188.25.248', 1617786594);
INSERT INTO `cd_log` VALUES (2722, 329, 'JACY', '用户登录', '222.93.110.105', 1617789814);
INSERT INTO `cd_log` VALUES (2723, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1617792203);
INSERT INTO `cd_log` VALUES (2724, 206, '小马驹', '用户登录', '182.241.224.176', 1617795976);
INSERT INTO `cd_log` VALUES (2725, 213, 'kent', '用户登录', '223.73.226.209', 1617805923);
INSERT INTO `cd_log` VALUES (2726, 213, 'kent', '用户登录', '223.73.226.209', 1617806746);
INSERT INTO `cd_log` VALUES (2727, 202, 'silencelam', '用户登录', '218.19.102.222', 1617845464);
INSERT INTO `cd_log` VALUES (2728, 50, 'lwang', '用户登录', '117.188.25.248', 1617850602);
INSERT INTO `cd_log` VALUES (2729, 496, 'ceshi', '用户登录', '117.136.104.182', 1617851273);
INSERT INTO `cd_log` VALUES (2730, 213, 'kent', '用户登录', '116.20.60.180', 1617853819);
INSERT INTO `cd_log` VALUES (2731, 446, 'BDRK2018', '用户登录', '111.73.171.26', 1617872932);
INSERT INTO `cd_log` VALUES (2732, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1617875425);
INSERT INTO `cd_log` VALUES (2733, 206, '小马驹', '用户登录', '182.241.224.176', 1617878728);
INSERT INTO `cd_log` VALUES (2734, 446, 'BDRK2018', '用户登录', '111.73.171.26', 1617964241);
INSERT INTO `cd_log` VALUES (2735, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1617965477);
INSERT INTO `cd_log` VALUES (2736, 176, '郭晓宁', '用户登录', '112.96.66.111', 1618020813);
INSERT INTO `cd_log` VALUES (2737, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1618051340);
INSERT INTO `cd_log` VALUES (2738, 176, '郭晓宁', '用户登录', '61.144.109.77', 1618069955);
INSERT INTO `cd_log` VALUES (2739, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1618109915);
INSERT INTO `cd_log` VALUES (2740, 209, 'fjc6036', '用户登录', '14.27.21.68', 1618159159);
INSERT INTO `cd_log` VALUES (2741, 446, 'BDRK2018', '用户登录', '182.86.205.46', 1618208735);
INSERT INTO `cd_log` VALUES (2742, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1618216803);
INSERT INTO `cd_log` VALUES (2743, 446, 'BDRK2018', '用户登录', '182.86.205.46', 1618224039);
INSERT INTO `cd_log` VALUES (2744, 1, 'admin', '用户登录', '117.188.25.248', 1618283694);
INSERT INTO `cd_log` VALUES (2745, 520, 'qindongle123', '用户登录', '125.73.83.15', 1618283836);
INSERT INTO `cd_log` VALUES (2746, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1618290068);
INSERT INTO `cd_log` VALUES (2747, 446, 'BDRK2018', '用户登录', '182.86.205.46', 1618291939);
INSERT INTO `cd_log` VALUES (2748, 50, 'lwang', '用户登录', '117.188.25.248', 1618297972);
INSERT INTO `cd_log` VALUES (2749, 329, 'JACY', '用户登录', '114.217.210.190', 1618298997);
INSERT INTO `cd_log` VALUES (2750, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1618381954);
INSERT INTO `cd_log` VALUES (2751, 295, 'James_Mai', '用户登录', '125.95.62.15', 1618384667);
INSERT INTO `cd_log` VALUES (2752, 446, 'BDRK2018', '用户登录', '182.86.201.175', 1618388716);
INSERT INTO `cd_log` VALUES (2753, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.106', 1618394566);
INSERT INTO `cd_log` VALUES (2754, 233, 'linyuanyao', '用户登录', '218.74.25.114', 1618404348);
INSERT INTO `cd_log` VALUES (2755, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618450378);
INSERT INTO `cd_log` VALUES (2756, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1618452996);
INSERT INTO `cd_log` VALUES (2757, 520, 'qindongle123', '用户登录', '222.217.142.121', 1618459144);
INSERT INTO `cd_log` VALUES (2758, 528, '张健', '用户登录', '113.88.5.208', 1618471154);
INSERT INTO `cd_log` VALUES (2759, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1618474506);
INSERT INTO `cd_log` VALUES (2760, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618477862);
INSERT INTO `cd_log` VALUES (2761, 446, 'BDRK2018', '用户登录', '182.86.201.175', 1618483171);
INSERT INTO `cd_log` VALUES (2762, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618489123);
INSERT INTO `cd_log` VALUES (2763, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618490848);
INSERT INTO `cd_log` VALUES (2764, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618490871);
INSERT INTO `cd_log` VALUES (2765, 446, 'BDRK2018', '用户登录', '182.86.201.175', 1618496441);
INSERT INTO `cd_log` VALUES (2766, 528, '张健', '用户登录', '183.17.127.124', 1618543653);
INSERT INTO `cd_log` VALUES (2767, 446, 'BDRK2018', '用户登录', '182.86.201.175', 1618552554);
INSERT INTO `cd_log` VALUES (2768, 530, 'lfbyan', '用户登录', '27.10.188.68', 1618558755);
INSERT INTO `cd_log` VALUES (2769, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618563961);
INSERT INTO `cd_log` VALUES (2770, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1618569802);
INSERT INTO `cd_log` VALUES (2771, 176, '郭晓宁', '用户登录', '112.96.194.133', 1618637896);
INSERT INTO `cd_log` VALUES (2772, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1618639011);
INSERT INTO `cd_log` VALUES (2773, 514, 'testtest', '用户登录', '101.204.175.230', 1618649779);
INSERT INTO `cd_log` VALUES (2774, 329, 'JACY', '用户登录', '222.93.110.105', 1618651145);
INSERT INTO `cd_log` VALUES (2775, 446, 'BDRK2018', '用户登录', '182.86.207.209', 1618653466);
INSERT INTO `cd_log` VALUES (2776, 514, 'testtest', '用户登录', '101.204.175.230', 1618655116);
INSERT INTO `cd_log` VALUES (2777, 514, 'testtest', '用户登录', '101.204.175.230', 1618655716);
INSERT INTO `cd_log` VALUES (2778, 1, 'admin', '用户登录', '111.121.8.95', 1618660068);
INSERT INTO `cd_log` VALUES (2779, 514, 'testtest', '用户登录', '101.204.175.230', 1618661938);
INSERT INTO `cd_log` VALUES (2780, 514, 'testtest', '用户登录', '101.204.175.230', 1618712749);
INSERT INTO `cd_log` VALUES (2781, 233, 'linyuanyao', '用户登录', '60.177.237.175', 1618731458);
INSERT INTO `cd_log` VALUES (2782, 514, 'testtest', '用户登录', '101.204.175.230', 1618733917);
INSERT INTO `cd_log` VALUES (2783, 514, 'testtest', '用户登录', '101.204.175.230', 1618753047);
INSERT INTO `cd_log` VALUES (2784, 336, 'cctv9595', '用户登录', '14.157.5.40', 1618769439);
INSERT INTO `cd_log` VALUES (2785, 526, 'jjxfl', '用户登录', '120.43.210.177', 1618804026);
INSERT INTO `cd_log` VALUES (2786, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1618812604);
INSERT INTO `cd_log` VALUES (2787, 446, 'BDRK2018', '用户登录', '182.86.207.209', 1618834976);
INSERT INTO `cd_log` VALUES (2788, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1618891453);
INSERT INTO `cd_log` VALUES (2789, 446, 'BDRK2018', '用户登录', '111.73.172.132', 1618897598);
INSERT INTO `cd_log` VALUES (2790, 446, 'BDRK2018', '用户登录', '111.73.172.132', 1618897986);
INSERT INTO `cd_log` VALUES (2791, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1618913577);
INSERT INTO `cd_log` VALUES (2792, 535, 'yz123456', '用户登录', '115.200.234.118', 1618934955);
INSERT INTO `cd_log` VALUES (2793, 524, 'liuk05', '用户登录', '115.200.234.118', 1618935006);
INSERT INTO `cd_log` VALUES (2794, 209, 'fjc6036', '用户登录', '113.101.236.75', 1618964516);
INSERT INTO `cd_log` VALUES (2795, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1618992347);
INSERT INTO `cd_log` VALUES (2796, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1618995850);
INSERT INTO `cd_log` VALUES (2797, 209, 'fjc6036', '用户登录', '14.28.168.110', 1619017519);
INSERT INTO `cd_log` VALUES (2798, 1, 'admin', '用户登录', '111.121.9.175', 1619038548);
INSERT INTO `cd_log` VALUES (2799, 543, 'xsfx123', '用户登录', '61.132.87.130', 1619060591);
INSERT INTO `cd_log` VALUES (2800, 233, 'linyuanyao', '用户登录', '115.200.240.103', 1619068002);
INSERT INTO `cd_log` VALUES (2801, 526, 'jjxfl', '用户登录', '120.43.210.177', 1619068520);
INSERT INTO `cd_log` VALUES (2802, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1619071011);
INSERT INTO `cd_log` VALUES (2803, 446, 'BDRK2018', '用户登录', '111.73.172.132', 1619072075);
INSERT INTO `cd_log` VALUES (2804, 546, 'wyk', '用户登录', '27.115.13.154', 1619075330);
INSERT INTO `cd_log` VALUES (2805, 67, '巴帝洛克尚东店', '用户登录', '183.217.234.182', 1619162394);
INSERT INTO `cd_log` VALUES (2806, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1619162871);
INSERT INTO `cd_log` VALUES (2807, 446, 'BDRK2018', '用户登录', '111.73.173.190', 1619168423);
INSERT INTO `cd_log` VALUES (2808, 329, 'JACY', '用户登录', '222.93.110.105', 1619196971);
INSERT INTO `cd_log` VALUES (2809, 213, 'kent', '用户登录', '112.96.226.14', 1619222214);
INSERT INTO `cd_log` VALUES (2810, 50, 'lwang', '用户登录', '117.188.6.57', 1619321497);
INSERT INTO `cd_log` VALUES (2811, 1, 'admin', '用户登录', '111.121.9.218', 1619333542);
INSERT INTO `cd_log` VALUES (2812, 67, '巴帝洛克尚东店', '用户登录', '183.217.235.138', 1619338734);
INSERT INTO `cd_log` VALUES (2813, 446, 'BDRK2018', '用户登录', '111.73.173.190', 1619350974);
INSERT INTO `cd_log` VALUES (2814, 170, '易能森智能', '用户登录', '61.154.119.130', 1619407142);
INSERT INTO `cd_log` VALUES (2815, 67, '巴帝洛克尚东店', '用户登录', '183.217.233.144', 1619420757);
INSERT INTO `cd_log` VALUES (2816, 446, 'BDRK2018', '用户登录', '111.73.172.69', 1619423381);
INSERT INTO `cd_log` VALUES (2817, 172, '17505919990', '用户登录', '112.51.22.54', 1619440102);
INSERT INTO `cd_log` VALUES (2818, 172, '17505919990', '用户登录', '220.249.162.164', 1619440555);
INSERT INTO `cd_log` VALUES (2819, 380, 'wk5779151', '用户登录', '112.51.22.54', 1619440738);
INSERT INTO `cd_log` VALUES (2820, 380, 'wk5779151', '用户登录', '112.51.22.54', 1619461133);
INSERT INTO `cd_log` VALUES (2821, 380, 'wk5779151', '用户登录', '218.85.58.13', 1619524852);
INSERT INTO `cd_log` VALUES (2822, 67, '巴帝洛克尚东店', '用户登录', '183.217.233.144', 1619601949);
INSERT INTO `cd_log` VALUES (2823, 525, 'jia93chuan02', '用户登录', '125.106.211.68', 1619670204);
INSERT INTO `cd_log` VALUES (2824, 172, '17505919990', '用户登录', '58.22.114.32', 1619673416);
INSERT INTO `cd_log` VALUES (2825, 172, '17505919990', '用户登录', '58.22.114.32', 1619674551);
INSERT INTO `cd_log` VALUES (2826, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1619674942);
INSERT INTO `cd_log` VALUES (2827, 67, '巴帝洛克尚东店', '用户登录', '183.217.233.144', 1619677009);
INSERT INTO `cd_log` VALUES (2828, 446, 'BDRK2018', '用户登录', '111.73.168.26', 1619678128);
INSERT INTO `cd_log` VALUES (2829, 172, '17505919990', '用户登录', '58.22.114.32', 1619680985);
INSERT INTO `cd_log` VALUES (2830, 446, 'BDRK2018', '用户登录', '111.73.168.26', 1619682117);
INSERT INTO `cd_log` VALUES (2831, 50, 'lwang', '用户登录', '117.188.6.57', 1619683000);
INSERT INTO `cd_log` VALUES (2832, 562, 'muyi168', '用户登录', '116.232.103.51', 1619683836);
INSERT INTO `cd_log` VALUES (2833, 562, 'muyi168', '用户登录', '114.86.230.237', 1619684459);
INSERT INTO `cd_log` VALUES (2834, 50, 'lwang', '用户登录', '117.188.6.57', 1619768395);
INSERT INTO `cd_log` VALUES (2835, 565, 'st293736', '用户登录', '39.67.146.121', 1619768538);
INSERT INTO `cd_log` VALUES (2836, 446, 'BDRK2018', '用户登录', '111.73.168.26', 1619769131);
INSERT INTO `cd_log` VALUES (2837, 446, 'BDRK2018', '用户登录', '111.73.168.26', 1619778834);
INSERT INTO `cd_log` VALUES (2838, 446, 'BDRK2018', '用户登录', '111.73.168.26', 1619780476);
INSERT INTO `cd_log` VALUES (2839, 67, '巴帝洛克尚东店', '用户登录', '183.217.233.144', 1619781653);
INSERT INTO `cd_log` VALUES (2840, 526, 'jjxfl', '用户登录', '120.43.210.177', 1619831374);
INSERT INTO `cd_log` VALUES (2841, 535, 'yz123456', '用户登录', '125.120.232.213', 1619854519);
INSERT INTO `cd_log` VALUES (2842, 1, 'admin', '用户登录', '111.121.46.238', 1619940195);
INSERT INTO `cd_log` VALUES (2843, 502, '521', '用户登录', '111.121.46.238', 1619940937);
INSERT INTO `cd_log` VALUES (2844, 502, '521', '用户登录', '1.24.24.132', 1619941444);
INSERT INTO `cd_log` VALUES (2845, 502, '521', '用户登录', '1.24.24.132', 1619943898);
INSERT INTO `cd_log` VALUES (2846, 111, '网吧管理员', '用户登录', '124.166.240.141', 1620057970);
INSERT INTO `cd_log` VALUES (2847, 111, '网吧管理员', '用户登录', '124.166.240.141', 1620058790);
INSERT INTO `cd_log` VALUES (2848, 111, '网吧管理员', '用户登录', '110.180.21.32', 1620059439);
INSERT INTO `cd_log` VALUES (2849, 111, '网吧管理员', '用户登录', '110.180.21.32', 1620059772);
INSERT INTO `cd_log` VALUES (2850, 111, '网吧管理员', '用户登录', '110.180.21.32', 1620060119);
INSERT INTO `cd_log` VALUES (2851, 111, '网吧管理员', '用户登录', '124.166.240.141', 1620060472);
INSERT INTO `cd_log` VALUES (2852, 209, 'fjc6036', '用户登录', '113.101.237.59', 1620088374);
INSERT INTO `cd_log` VALUES (2853, 209, 'fjc6036', '用户登录', '113.101.237.59', 1620088430);
INSERT INTO `cd_log` VALUES (2854, 446, 'BDRK2018', '用户登录', '111.73.172.12', 1620191623);
INSERT INTO `cd_log` VALUES (2855, 209, 'fjc6036', '用户登录', '113.101.236.108', 1620211884);
INSERT INTO `cd_log` VALUES (2856, 446, 'BDRK2018', '用户登录', '111.73.172.12', 1620218562);
INSERT INTO `cd_log` VALUES (2857, 446, 'BDRK2018', '用户登录', '111.73.172.12', 1620219150);
INSERT INTO `cd_log` VALUES (2858, 446, 'BDRK2018', '用户登录', '111.73.172.12', 1620220754);
INSERT INTO `cd_log` VALUES (2859, 446, 'BDRK2018', '用户登录', '111.73.172.12', 1620220941);
INSERT INTO `cd_log` VALUES (2860, 111, '网吧管理员', '用户登录', '110.180.21.32', 1620230380);
INSERT INTO `cd_log` VALUES (2861, 209, 'fjc6036', '用户登录', '14.30.168.23', 1620232660);
INSERT INTO `cd_log` VALUES (2862, 578, '791836203', '用户登录', '219.144.136.156', 1620273991);
INSERT INTO `cd_log` VALUES (2863, 446, 'BDRK2018', '用户登录', '111.73.174.204', 1620282479);
INSERT INTO `cd_log` VALUES (2864, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620284434);
INSERT INTO `cd_log` VALUES (2865, 579, 'sysz', '用户登录', '114.216.114.250', 1620288157);
INSERT INTO `cd_log` VALUES (2866, 446, 'BDRK2018', '用户登录', '111.73.174.204', 1620292599);
INSERT INTO `cd_log` VALUES (2867, 446, 'BDRK2018', '用户登录', '111.73.174.204', 1620304042);
INSERT INTO `cd_log` VALUES (2868, 102, '13145201141', '用户登录', '220.166.237.40', 1620317224);
INSERT INTO `cd_log` VALUES (2869, 209, 'fjc6036', '用户登录', '183.39.158.38', 1620318159);
INSERT INTO `cd_log` VALUES (2870, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620370447);
INSERT INTO `cd_log` VALUES (2871, 565, 'st293736', '用户登录', '112.228.225.154', 1620378425);
INSERT INTO `cd_log` VALUES (2872, 446, 'BDRK2018', '用户登录', '111.73.174.204', 1620390571);
INSERT INTO `cd_log` VALUES (2873, 446, 'BDRK2018', '用户登录', '111.73.174.204', 1620456948);
INSERT INTO `cd_log` VALUES (2874, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620462778);
INSERT INTO `cd_log` VALUES (2875, 446, 'BDRK2018', '用户登录', '111.73.174.204', 1620477265);
INSERT INTO `cd_log` VALUES (2876, 446, 'BDRK2018', '用户登录', '182.86.201.129', 1620541657);
INSERT INTO `cd_log` VALUES (2877, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620552687);
INSERT INTO `cd_log` VALUES (2878, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620625975);
INSERT INTO `cd_log` VALUES (2879, 195, '18083822472', '用户登录', '112.115.189.145', 1620631705);
INSERT INTO `cd_log` VALUES (2880, 514, 'testtest', '用户登录', '182.150.153.134', 1620632318);
INSERT INTO `cd_log` VALUES (2881, 102, '13145201141', '用户登录', '182.151.188.95', 1620701434);
INSERT INTO `cd_log` VALUES (2882, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620716666);
INSERT INTO `cd_log` VALUES (2883, 597, 'a18291970135', '用户登录', '222.91.199.239', 1620716693);
INSERT INTO `cd_log` VALUES (2884, 514, 'testtest', '用户登录', '182.150.154.233', 1620720991);
INSERT INTO `cd_log` VALUES (2885, 528, '张健', '用户登录', '183.17.124.14', 1620722359);
INSERT INTO `cd_log` VALUES (2886, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1620799787);
INSERT INTO `cd_log` VALUES (2887, 446, 'BDRK2018', '用户登录', '111.73.171.211', 1620816192);
INSERT INTO `cd_log` VALUES (2888, 111, '网吧管理员', '用户登录', '110.180.21.62', 1620877533);
INSERT INTO `cd_log` VALUES (2889, 597, 'a18291970135', '用户登录', '1.80.38.1', 1620879284);
INSERT INTO `cd_log` VALUES (2890, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620888864);
INSERT INTO `cd_log` VALUES (2891, 50, 'lwang', '用户登录', '117.188.27.164', 1620890935);
INSERT INTO `cd_log` VALUES (2892, 446, 'BDRK2018', '用户登录', '111.73.171.211', 1620903810);
INSERT INTO `cd_log` VALUES (2893, 50, 'lwang', '用户登录', '117.188.27.164', 1620960593);
INSERT INTO `cd_log` VALUES (2894, 210, 'wshwye', '用户登录', '220.195.70.89', 1620962668);
INSERT INTO `cd_log` VALUES (2895, 210, 'wshwye', '用户登录', '39.155.44.17', 1620964478);
INSERT INTO `cd_log` VALUES (2896, 594, '18100883189', '用户登录', '183.225.15.241', 1620965919);
INSERT INTO `cd_log` VALUES (2897, 514, 'testtest', '用户登录', '182.150.159.171', 1620978178);
INSERT INTO `cd_log` VALUES (2898, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1620981296);
INSERT INTO `cd_log` VALUES (2899, 446, 'BDRK2018', '用户登录', '182.86.200.205', 1620995962);
INSERT INTO `cd_log` VALUES (2900, 446, 'BDRK2018', '用户登录', '182.86.200.205', 1620999378);
INSERT INTO `cd_log` VALUES (2901, 514, 'testtest', '用户登录', '182.150.159.171', 1621044660);
INSERT INTO `cd_log` VALUES (2902, 210, 'wshwye', '用户登录', '39.155.44.17', 1621048908);
INSERT INTO `cd_log` VALUES (2903, 514, 'testtest', '用户登录', '182.150.159.171', 1621055330);
INSERT INTO `cd_log` VALUES (2904, 514, 'testtest', '用户登录', '182.150.159.171', 1621074778);
INSERT INTO `cd_log` VALUES (2905, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.68', 1621077139);
INSERT INTO `cd_log` VALUES (2906, 210, 'wshwye', '用户登录', '110.6.45.234', 1621097413);
INSERT INTO `cd_log` VALUES (2907, 210, 'wshwye', '用户登录', '110.6.45.234', 1621112433);
INSERT INTO `cd_log` VALUES (2908, 514, 'testtest', '用户登录', '182.150.159.171', 1621133621);
INSERT INTO `cd_log` VALUES (2909, 210, 'wshwye', '用户登录', '120.228.104.58', 1621139293);
INSERT INTO `cd_log` VALUES (2910, 514, 'testtest', '用户登录', '182.150.159.171', 1621160374);
INSERT INTO `cd_log` VALUES (2911, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.143', 1621161488);
INSERT INTO `cd_log` VALUES (2912, 50, 'lwang', '用户登录', '117.188.27.164', 1621220687);
INSERT INTO `cd_log` VALUES (2913, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.143', 1621236947);
INSERT INTO `cd_log` VALUES (2914, 616, 'lywlocker', '用户登录', '222.223.43.10', 1621246078);
INSERT INTO `cd_log` VALUES (2915, 446, 'BDRK2018', '用户登录', '111.73.171.214', 1621257918);
INSERT INTO `cd_log` VALUES (2916, 102, '13145201141', '用户登录', '222.211.120.23', 1621312837);
INSERT INTO `cd_log` VALUES (2917, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.143', 1621317437);
INSERT INTO `cd_log` VALUES (2918, 446, 'BDRK2018', '用户登录', '111.73.171.214', 1621332538);
INSERT INTO `cd_log` VALUES (2919, 209, 'fjc6036', '用户登录', '14.25.175.177', 1621353733);
INSERT INTO `cd_log` VALUES (2920, 209, 'fjc6036', '用户登录', '14.25.175.177', 1621353917);
INSERT INTO `cd_log` VALUES (2921, 50, 'lwang', '用户登录', '117.188.27.164', 1621405882);
INSERT INTO `cd_log` VALUES (2922, 50, 'lwang', '用户登录', '117.188.27.164', 1621410923);
INSERT INTO `cd_log` VALUES (2923, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.143', 1621417893);
INSERT INTO `cd_log` VALUES (2924, 514, 'testtest', '用户登录', '182.150.154.73', 1621428016);
INSERT INTO `cd_log` VALUES (2925, 1, 'admin', '用户登录', '117.188.27.164', 1621489090);
INSERT INTO `cd_log` VALUES (2926, 594, '18100883189', '用户登录', '39.128.5.58', 1621489491);
INSERT INTO `cd_log` VALUES (2927, 446, 'BDRK2018', '用户登录', '111.73.171.214', 1621491391);
INSERT INTO `cd_log` VALUES (2928, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1621502928);
INSERT INTO `cd_log` VALUES (2929, 446, 'BDRK2018', '用户登录', '182.86.201.104', 1621511921);
INSERT INTO `cd_log` VALUES (2930, 102, '13145201141', '用户登录', '222.211.120.134', 1621565457);
INSERT INTO `cd_log` VALUES (2931, 514, 'testtest', '用户登录', '182.150.154.73', 1621575708);
INSERT INTO `cd_log` VALUES (2932, 446, 'BDRK2018', '用户登录', '182.86.201.104', 1621581512);
INSERT INTO `cd_log` VALUES (2933, 514, 'testtest', '用户登录', '182.150.154.73', 1621582971);
INSERT INTO `cd_log` VALUES (2934, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1621583625);
INSERT INTO `cd_log` VALUES (2935, 446, 'BDRK2018', '用户登录', '182.86.201.104', 1621601616);
INSERT INTO `cd_log` VALUES (2936, 446, 'BDRK2018', '用户登录', '182.86.201.104', 1621664458);
INSERT INTO `cd_log` VALUES (2937, 1, 'admin', '用户登录', '43.129.26.26', 1621684636);
INSERT INTO `cd_log` VALUES (2938, 111, '网吧管理员', '用户登录', '124.166.240.141', 1621744806);
INSERT INTO `cd_log` VALUES (2939, 597, 'a18291970135', '用户登录', '113.140.160.153', 1621747478);
INSERT INTO `cd_log` VALUES (2940, 640, 'Eumenides', '用户登录', '113.140.160.153', 1621749294);
INSERT INTO `cd_log` VALUES (2941, 640, 'Eumenides', '用户登录', '113.140.160.153', 1621749609);
INSERT INTO `cd_log` VALUES (2942, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1621751412);
INSERT INTO `cd_log` VALUES (2943, 111, '网吧管理员', '用户登录', '124.166.240.141', 1621751480);
INSERT INTO `cd_log` VALUES (2944, 643, '小黄豆', '用户登录', '180.103.216.213', 1621761224);
INSERT INTO `cd_log` VALUES (2945, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1621838410);
INSERT INTO `cd_log` VALUES (2946, 446, 'BDRK2018', '用户登录', '111.73.171.141', 1621856014);
INSERT INTO `cd_log` VALUES (2947, 597, 'a18291970135', '用户登录', '117.136.86.87', 1621856702);
INSERT INTO `cd_log` VALUES (2948, 172, '17505919990', '用户登录', '59.56.133.109', 1621876076);
INSERT INTO `cd_log` VALUES (2949, 380, 'wk5779151', '用户登录', '59.56.133.109', 1621876190);
INSERT INTO `cd_log` VALUES (2950, 514, 'testtest', '用户登录', '182.150.155.207', 1621924582);
INSERT INTO `cd_log` VALUES (2951, 446, 'BDRK2018', '用户登录', '111.73.171.141', 1621928377);
INSERT INTO `cd_log` VALUES (2952, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1621942077);
INSERT INTO `cd_log` VALUES (2953, 102, '13145201141', '用户登录', '125.69.7.197', 1621954470);
INSERT INTO `cd_log` VALUES (2954, 514, 'testtest', '用户登录', '182.150.155.207', 1622000506);
INSERT INTO `cd_log` VALUES (2955, 514, 'testtest', '用户登录', '182.150.155.207', 1622001321);
INSERT INTO `cd_log` VALUES (2956, 446, 'BDRK2018', '用户登录', '111.73.171.141', 1622010976);
INSERT INTO `cd_log` VALUES (2957, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1622025059);
INSERT INTO `cd_log` VALUES (2958, 102, '13145201141', '用户登录', '125.69.7.197', 1622034946);
INSERT INTO `cd_log` VALUES (2959, 59, '13299581110', '用户登录', '1.50.101.231', 1622078936);
INSERT INTO `cd_log` VALUES (2960, 59, '13299581110', '用户登录', '1.50.101.231', 1622079006);
INSERT INTO `cd_log` VALUES (2961, 446, 'BDRK2018', '用户登录', '182.86.203.143', 1622099326);
INSERT INTO `cd_log` VALUES (2962, 149, 'wfs', '用户登录', '223.79.36.201', 1622102014);
INSERT INTO `cd_log` VALUES (2963, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1622119451);
INSERT INTO `cd_log` VALUES (2964, 514, 'testtest', '用户登录', '182.150.155.207', 1622173361);
INSERT INTO `cd_log` VALUES (2965, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1622179701);
INSERT INTO `cd_log` VALUES (2966, 514, 'testtest', '用户登录', '182.150.155.207', 1622189904);
INSERT INTO `cd_log` VALUES (2967, 50, 'lwang', '用户登录', '117.188.28.17', 1622192015);
INSERT INTO `cd_log` VALUES (2968, 446, 'BDRK2018', '用户登录', '182.86.203.143', 1622204728);
INSERT INTO `cd_log` VALUES (2969, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.249', 1622279478);
INSERT INTO `cd_log` VALUES (2970, 415, 'zaozao198412', '用户登录', '183.159.124.135', 1622346543);
INSERT INTO `cd_log` VALUES (2971, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.23', 1622373197);
INSERT INTO `cd_log` VALUES (2972, 446, 'BDRK2018', '用户登录', '183.219.172.17', 1622383895);
INSERT INTO `cd_log` VALUES (2973, 446, 'BDRK2018', '用户登录', '183.219.172.17', 1622383998);
INSERT INTO `cd_log` VALUES (2974, 102, '13145201141', '用户登录', '125.69.7.197', 1622433633);
INSERT INTO `cd_log` VALUES (2975, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.23', 1622456761);
INSERT INTO `cd_log` VALUES (2976, 446, 'BDRK2018', '用户登录', '182.86.203.195', 1622463911);
INSERT INTO `cd_log` VALUES (2977, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1622464906);
INSERT INTO `cd_log` VALUES (2978, 514, 'testtest', '用户登录', '182.150.158.211', 1622526957);
INSERT INTO `cd_log` VALUES (2979, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.23', 1622534965);
INSERT INTO `cd_log` VALUES (2980, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1622541375);
INSERT INTO `cd_log` VALUES (2981, 514, 'testtest', '用户登录', '182.150.158.211', 1622542207);
INSERT INTO `cd_log` VALUES (2982, 446, 'BDRK2018', '用户登录', '182.86.205.151', 1622546167);
INSERT INTO `cd_log` VALUES (2983, 514, 'testtest', '用户登录', '182.150.158.211', 1622604305);
INSERT INTO `cd_log` VALUES (2984, 446, 'BDRK2018', '用户登录', '118.212.213.90', 1622623854);
INSERT INTO `cd_log` VALUES (2985, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1622624519);
INSERT INTO `cd_log` VALUES (2986, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1622631251);
INSERT INTO `cd_log` VALUES (2987, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.23', 1622632220);
INSERT INTO `cd_log` VALUES (2988, 446, 'BDRK2018', '用户登录', '182.86.205.151', 1622632395);
INSERT INTO `cd_log` VALUES (2989, 111, '网吧管理员', '用户登录', '124.166.240.141', 1622633576);
INSERT INTO `cd_log` VALUES (2990, 336, 'cctv9595', '用户登录', '14.157.7.49', 1622653673);
INSERT INTO `cd_log` VALUES (2991, 514, 'testtest', '用户登录', '182.150.158.211', 1622684105);
INSERT INTO `cd_log` VALUES (2992, 67, '巴帝洛克尚东店', '用户登录', '117.178.62.23', 1622700449);
INSERT INTO `cd_log` VALUES (2993, 446, 'BDRK2018', '用户登录', '182.86.205.151', 1622722011);
INSERT INTO `cd_log` VALUES (2994, 514, 'testtest', '用户登录', '182.150.158.211', 1622767989);
INSERT INTO `cd_log` VALUES (2995, 514, 'testtest', '用户登录', '182.150.158.211', 1622768055);
INSERT INTO `cd_log` VALUES (2996, 671, 'zfw', '用户登录', '121.224.109.30', 1622770020);
INSERT INTO `cd_log` VALUES (2997, 50, 'lwang', '用户登录', '117.189.29.174', 1622777180);
INSERT INTO `cd_log` VALUES (2998, 233, 'linyuanyao', '用户登录', '60.191.117.2', 1622791518);
INSERT INTO `cd_log` VALUES (2999, 149, 'wfs', '用户登录', '223.104.189.40', 1622862712);
INSERT INTO `cd_log` VALUES (3000, 149, 'wfs', '用户登录', '223.104.189.40', 1622863300);
INSERT INTO `cd_log` VALUES (3001, 514, 'testtest', '用户登录', '182.150.155.132', 1622961170);
INSERT INTO `cd_log` VALUES (3002, 446, 'BDRK2018', '用户登录', '111.73.174.229', 1622973390);
INSERT INTO `cd_log` VALUES (3003, 446, 'BDRK2018', '用户登录', '111.73.174.229', 1623068753);
INSERT INTO `cd_log` VALUES (3004, 50, 'lwang', '用户登录', '117.188.31.245', 1623208381);
INSERT INTO `cd_log` VALUES (3005, 67, '巴帝洛克尚东店', '用户登录', '117.178.63.237', 1623219031);
INSERT INTO `cd_log` VALUES (4006, 263, 'jxd0454', '用户登录', '114.228.41.104', 1639787265);
INSERT INTO `cd_log` VALUES (4007, 209, 'fjc6036', '用户登录', '116.29.109.27', 1639788392);
INSERT INTO `cd_log` VALUES (4008, 263, 'jxd0454', '用户登录', '114.228.35.170', 1639807162);
INSERT INTO `cd_log` VALUES (4009, 1229, 'EKIOT', '用户登录', '116.30.7.200', 1639809010);
INSERT INTO `cd_log` VALUES (4010, 209, 'fjc6036', '用户登录', '113.101.236.251', 1639949300);
INSERT INTO `cd_log` VALUES (4011, 209, 'fjc6036', '用户登录', '14.27.51.20', 1639952452);
INSERT INTO `cd_log` VALUES (4012, 209, 'fjc6036', '用户登录', '14.27.51.20', 1639956728);
INSERT INTO `cd_log` VALUES (4013, 1235, 'guoxiqiang', '用户登录', '219.154.106.79', 1639974685);
INSERT INTO `cd_log` VALUES (4014, 643, '小黄豆', '用户登录', '49.64.97.98', 1639974900);
INSERT INTO `cd_log` VALUES (4015, 209, 'fjc6036', '用户登录', '14.27.51.20', 1639983291);
INSERT INTO `cd_log` VALUES (4016, 415, 'zaozao198412', '用户登录', '125.118.250.26', 1639999330);
INSERT INTO `cd_log` VALUES (4017, 209, 'fjc6036', '用户登录', '116.29.109.119', 1640004343);
INSERT INTO `cd_log` VALUES (4018, 209, 'fjc6036', '用户登录', '116.29.109.119', 1640045874);
INSERT INTO `cd_log` VALUES (4019, 50, 'lwang', '用户登录', '117.189.21.27', 1640066077);
INSERT INTO `cd_log` VALUES (4020, 100, 'liwang', '用户登录', '117.189.21.27', 1640066308);
INSERT INTO `cd_log` VALUES (4021, 50, 'lwang', '用户登录', '117.189.21.27', 1640066339);
INSERT INTO `cd_log` VALUES (4022, 209, 'fjc6036', '用户登录', '116.29.109.119', 1640074378);
INSERT INTO `cd_log` VALUES (4023, 209, 'fjc6036', '用户登录', '116.29.109.119', 1640094461);
INSERT INTO `cd_log` VALUES (4024, 209, 'fjc6036', '用户登录', '113.101.239.216', 1640134178);
INSERT INTO `cd_log` VALUES (4025, 263, 'Jxd0454', '用户登录', '180.116.62.49', 1640163645);
INSERT INTO `cd_log` VALUES (4026, 209, 'fjc6036', '用户登录', '113.101.239.216', 1640180705);
INSERT INTO `cd_log` VALUES (4027, 209, 'fjc6036', '用户登录', '113.101.239.216', 1640218571);
INSERT INTO `cd_log` VALUES (4028, 209, 'fjc6036', '用户登录', '113.101.239.216', 1640218658);
INSERT INTO `cd_log` VALUES (4029, 514, 'testtest', '用户登录', '182.150.158.14', 1640222313);
INSERT INTO `cd_log` VALUES (4030, 852, 'cat便利', '用户登录', '111.32.79.155', 1640260847);
INSERT INTO `cd_log` VALUES (4031, 209, 'fjc6036', '用户登录', '14.27.45.189', 1640269037);
INSERT INTO `cd_log` VALUES (4032, 209, 'fjc6036', '用户登录', '113.101.238.32', 1640305450);
INSERT INTO `cd_log` VALUES (4033, 209, 'fjc6036', '用户登录', '113.101.238.32', 1640309790);
INSERT INTO `cd_log` VALUES (4034, 1241, 'adair', '用户登录', '125.123.82.195', 1640315567);
INSERT INTO `cd_log` VALUES (4035, 643, '小黄豆', '用户登录', '49.64.97.98', 1640316510);
INSERT INTO `cd_log` VALUES (4036, 50, 'lwang', '用户登录', '111.85.55.29', 1640346528);
INSERT INTO `cd_log` VALUES (4037, 209, 'fjc6036', '用户登录', '113.101.238.32', 1640353721);
INSERT INTO `cd_log` VALUES (4038, 209, 'fjc6036', '用户登录', '113.101.238.32', 1640391502);
INSERT INTO `cd_log` VALUES (4039, 209, 'fjc6036', '用户登录', '113.101.238.32', 1640445152);
INSERT INTO `cd_log` VALUES (4040, 209, 'fjc6036', '用户登录', '116.29.109.48', 1640479581);
INSERT INTO `cd_log` VALUES (4041, 210, 'wshwye', '用户登录', '39.155.44.26', 1640486742);
INSERT INTO `cd_log` VALUES (4042, 213, 'kent', '用户登录', '223.73.226.35', 1640490289);
INSERT INTO `cd_log` VALUES (4043, 643, '小黄豆', '用户登录', '49.64.97.98', 1640514315);
INSERT INTO `cd_log` VALUES (4044, 209, 'fjc6036', '用户登录', '116.29.109.48', 1640524057);
INSERT INTO `cd_log` VALUES (4045, 209, 'fjc6036', '用户登录', '116.29.109.48', 1640565595);
INSERT INTO `cd_log` VALUES (4046, 149, 'wfs', '用户登录', '144.12.116.175', 1640573449);
INSERT INTO `cd_log` VALUES (4047, 149, 'wfs', '用户登录', '144.12.116.175', 1640575369);
INSERT INTO `cd_log` VALUES (4048, 852, 'cat便利', '用户登录', '117.10.155.25', 1640599569);
INSERT INTO `cd_log` VALUES (4049, 209, 'fjc6036', '用户登录', '14.30.151.75', 1640612524);
INSERT INTO `cd_log` VALUES (4050, 209, 'fjc6036', '用户登录', '113.101.239.178', 1640652141);
INSERT INTO `cd_log` VALUES (4051, 209, 'fjc6036', '用户登录', '113.101.239.178', 1640698486);
INSERT INTO `cd_log` VALUES (4052, 1, 'admin', '用户登录', '111.121.14.193', 1640706065);
INSERT INTO `cd_log` VALUES (4053, 209, 'fjc6036', '用户登录', '113.101.239.178', 1640738187);
INSERT INTO `cd_log` VALUES (4054, 380, 'wk5779151', '用户登录', '112.51.19.163', 1640764777);
INSERT INTO `cd_log` VALUES (4055, 380, 'wk5779151', '用户登录', '112.51.19.163', 1640765125);
INSERT INTO `cd_log` VALUES (4056, 209, 'fjc6036', '用户登录', '14.28.129.81', 1640785775);
INSERT INTO `cd_log` VALUES (4057, 526, 'jjxfl', '用户登录', '120.43.210.177', 1640788531);
INSERT INTO `cd_log` VALUES (4058, 852, 'cat便利', '用户登录', '111.32.79.87', 1640793264);
INSERT INTO `cd_log` VALUES (4059, 209, 'fjc6036', '用户登录', '116.29.109.241', 1640824775);
INSERT INTO `cd_log` VALUES (4060, 146, 'matai112', '用户登录', '106.121.135.6', 1640849043);
INSERT INTO `cd_log` VALUES (4061, 50, 'lwang', '用户登录', '117.189.21.116', 1640850191);
INSERT INTO `cd_log` VALUES (4062, 213, 'kent', '用户登录', '112.96.225.43', 1640854612);
INSERT INTO `cd_log` VALUES (4063, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640858696);
INSERT INTO `cd_log` VALUES (4064, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640858879);
INSERT INTO `cd_log` VALUES (4065, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640859069);
INSERT INTO `cd_log` VALUES (4066, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640859952);
INSERT INTO `cd_log` VALUES (4067, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640860110);
INSERT INTO `cd_log` VALUES (4068, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640861245);
INSERT INTO `cd_log` VALUES (4069, 1252, 'YH11017', '用户登录', '117.174.113.16', 1640862438);
INSERT INTO `cd_log` VALUES (4070, 852, 'cat便利', '用户登录', '117.10.155.25', 1640862667);
INSERT INTO `cd_log` VALUES (4071, 1253, 'junguiduan', '用户登录', '117.174.113.16', 1640866273);
INSERT INTO `cd_log` VALUES (4072, 1253, 'junguiduan', '用户登录', '118.113.243.163', 1640871968);
INSERT INTO `cd_log` VALUES (4073, 209, 'fjc6036', '用户登录', '116.29.109.241', 1640873948);
INSERT INTO `cd_log` VALUES (4074, 852, 'cat便利', '用户登录', '117.10.155.25', 1640910793);
INSERT INTO `cd_log` VALUES (4075, 643, '小黄豆', '用户登录', '114.217.179.38', 1640926828);
INSERT INTO `cd_log` VALUES (4076, 209, 'fjc6036', '用户登录', '14.28.153.96', 1640960631);
INSERT INTO `cd_log` VALUES (4077, 209, 'fjc6036', '用户登录', '119.138.193.123', 1641005327);
INSERT INTO `cd_log` VALUES (4078, 852, 'cat便利', '用户登录', '117.10.155.25', 1641014232);
INSERT INTO `cd_log` VALUES (4079, 671, 'zfw', '用户登录', '180.106.249.139', 1641026083);
INSERT INTO `cd_log` VALUES (4080, 643, '小黄豆', '用户登录', '180.107.194.120', 1641029982);
INSERT INTO `cd_log` VALUES (4081, 526, 'jjxfl', '用户登录', '120.43.210.177', 1641042320);
INSERT INTO `cd_log` VALUES (4082, 209, 'fjc6036', '用户登录', '119.138.193.123', 1641045122);
INSERT INTO `cd_log` VALUES (4083, 209, 'fjc6036', '用户登录', '119.138.193.123', 1641084330);
INSERT INTO `cd_log` VALUES (4084, 209, 'fjc6036', '用户登录', '119.138.193.123', 1641134948);
INSERT INTO `cd_log` VALUES (4085, 209, 'fjc6036', '用户登录', '113.101.239.2', 1641170019);
INSERT INTO `cd_log` VALUES (4086, 1258, '小朱', '用户登录', '122.238.3.207', 1641187524);
INSERT INTO `cd_log` VALUES (4087, 209, 'fjc6036', '用户登录', '113.101.239.2', 1641216507);
INSERT INTO `cd_log` VALUES (4088, 209, 'fjc6036', '用户登录', '113.101.239.2', 1641255950);
INSERT INTO `cd_log` VALUES (4089, 209, 'fjc6036', '用户登录', '113.101.239.2', 1641305198);
INSERT INTO `cd_log` VALUES (4090, 209, 'fjc6036', '用户登录', '116.29.109.8', 1641342931);
INSERT INTO `cd_log` VALUES (4091, 1, 'admin', '用户登录', '111.121.14.193', 1641367401);
INSERT INTO `cd_log` VALUES (4092, 209, 'fjc6036', '用户登录', '116.29.109.8', 1641391747);
INSERT INTO `cd_log` VALUES (4093, 209, 'fjc6036', '用户登录', '116.29.109.8', 1641428719);
INSERT INTO `cd_log` VALUES (4094, 526, 'jjxfl', '用户登录', '120.43.210.177', 1641435581);
INSERT INTO `cd_log` VALUES (4095, 643, '小黄豆', '用户登录', '180.107.194.120', 1641457703);
INSERT INTO `cd_log` VALUES (4096, 263, 'jxd0454', '用户登录', '114.228.39.249', 1641467200);
INSERT INTO `cd_log` VALUES (4097, 276, 'jerry', '用户登录', '114.228.39.249', 1641468135);
INSERT INTO `cd_log` VALUES (4098, 277, '007', '用户登录', '114.228.39.249', 1641468670);
INSERT INTO `cd_log` VALUES (4099, 277, '007', '用户登录', '49.93.137.191', 1641469519);
INSERT INTO `cd_log` VALUES (4100, 209, 'fjc6036', '用户登录', '116.29.109.8', 1641477435);
INSERT INTO `cd_log` VALUES (4101, 209, 'fjc6036', '用户登录', '113.101.239.211', 1641515372);
INSERT INTO `cd_log` VALUES (4102, 209, 'fjc6036', '用户登录', '14.27.29.242', 1641524181);
INSERT INTO `cd_log` VALUES (4103, 209, 'fjc6036', '用户登录', '14.27.29.242', 1641542398);
INSERT INTO `cd_log` VALUES (4104, 852, 'cat便利', '用户登录', '221.197.234.3', 1641543654);
INSERT INTO `cd_log` VALUES (4105, 643, '小黄豆', '用户登录', '180.107.194.120', 1641556877);
INSERT INTO `cd_log` VALUES (4106, 277, '007', '用户登录', '49.93.34.165', 1641557543);
INSERT INTO `cd_log` VALUES (4107, 277, '007', '用户登录', '49.93.34.165', 1641557625);
INSERT INTO `cd_log` VALUES (4108, 277, '007', '用户登录', '49.93.34.165', 1641557692);
INSERT INTO `cd_log` VALUES (4109, 209, 'fjc6036', '用户登录', '113.101.239.211', 1641565161);
INSERT INTO `cd_log` VALUES (4110, 852, 'cat便利', '用户登录', '221.197.234.3', 1641566605);
INSERT INTO `cd_log` VALUES (4111, 209, 'fjc6036', '用户登录', '113.101.239.211', 1641601754);
INSERT INTO `cd_log` VALUES (4112, 213, 'kent', '用户登录', '223.73.226.140', 1641602201);
INSERT INTO `cd_log` VALUES (4113, 643, '小黄豆', '用户登录', '180.107.194.120', 1641640334);
INSERT INTO `cd_log` VALUES (4114, 852, 'cat便利', '用户登录', '221.197.234.3', 1641647911);
INSERT INTO `cd_log` VALUES (4115, 852, 'cat便利', '用户登录', '221.197.234.3', 1641648537);
INSERT INTO `cd_log` VALUES (4116, 209, 'fjc6036', '用户登录', '113.101.239.211', 1641649023);
INSERT INTO `cd_log` VALUES (4117, 526, 'jjxfl', '用户登录', '120.43.210.177', 1641664015);
INSERT INTO `cd_log` VALUES (4118, 209, 'fjc6036', '用户登录', '113.101.238.13', 1641688214);
INSERT INTO `cd_log` VALUES (4119, 643, '小黄豆', '用户登录', '180.107.194.120', 1641693097);
INSERT INTO `cd_log` VALUES (4120, 213, 'kent', '用户登录', '223.73.226.140', 1641735581);
INSERT INTO `cd_log` VALUES (4121, 209, 'fjc6036', '用户登录', '113.101.238.13', 1641736225);
INSERT INTO `cd_log` VALUES (4122, 209, 'fjc6036', '用户登录', '113.101.238.13', 1641774248);
INSERT INTO `cd_log` VALUES (4123, 276, 'jerry', '用户登录', '120.197.165.128', 1641780475);
INSERT INTO `cd_log` VALUES (4124, 643, '小黄豆', '用户登录', '180.107.194.120', 1641780679);
INSERT INTO `cd_log` VALUES (4125, 277, '007', '用户登录', '121.231.6.127', 1641782621);
INSERT INTO `cd_log` VALUES (4126, 276, 'jerry', '用户登录', '121.231.6.127', 1641782966);
INSERT INTO `cd_log` VALUES (4127, 277, '007', '用户登录', '223.104.61.1', 1641783968);
INSERT INTO `cd_log` VALUES (4128, 276, 'jerry', '用户登录', '121.231.6.127', 1641785879);
INSERT INTO `cd_log` VALUES (4129, 263, 'jxd0454', '用户登录', '121.231.6.127', 1641789223);
INSERT INTO `cd_log` VALUES (4130, 276, 'jerry', '用户登录', '121.231.6.127', 1641790649);
INSERT INTO `cd_log` VALUES (4131, 263, 'jxd0454', '用户登录', '121.231.6.127', 1641791931);
INSERT INTO `cd_log` VALUES (4132, 1, 'admin', '用户登录', '117.189.21.120', 1641792285);
INSERT INTO `cd_log` VALUES (4133, 263, 'jxd0454', '用户登录', '121.231.6.127', 1641792634);
INSERT INTO `cd_log` VALUES (4134, 526, 'jjxfl', '用户登录', '120.43.210.177', 1641810781);
INSERT INTO `cd_log` VALUES (4135, 209, 'fjc6036', '用户登录', '113.101.238.13', 1641818878);
INSERT INTO `cd_log` VALUES (4136, 209, 'fjc6036', '用户登录', '116.29.108.68', 1641861113);
INSERT INTO `cd_log` VALUES (4137, 50, 'lwang', '用户登录', '117.189.21.120', 1641867669);
INSERT INTO `cd_log` VALUES (4138, 209, 'fjc6036', '用户登录', '14.28.153.2', 1641911087);
INSERT INTO `cd_log` VALUES (4139, 276, 'jerry', '用户登录', '101.82.64.28', 1641993260);
INSERT INTO `cd_log` VALUES (4140, 276, 'jerry', '用户登录', '101.82.64.28', 1641994074);
INSERT INTO `cd_log` VALUES (4141, 276, 'jerry', '用户登录', '101.82.64.28', 1641994171);
INSERT INTO `cd_log` VALUES (4142, 209, 'fjc6036', '用户登录', '116.29.108.68', 1641997987);
INSERT INTO `cd_log` VALUES (4143, 209, 'fjc6036', '用户登录', '116.29.108.25', 1642034411);
INSERT INTO `cd_log` VALUES (4144, 209, 'fjc6036', '用户登录', '116.29.108.25', 1642082006);
INSERT INTO `cd_log` VALUES (4145, 209, 'fjc6036', '用户登录', '116.29.108.25', 1642121194);
INSERT INTO `cd_log` VALUES (4146, 380, 'wk5779151', '用户登录', '112.51.21.253', 1642139476);
INSERT INTO `cd_log` VALUES (4147, 209, 'fjc6036', '用户登录', '119.138.192.32', 1642145729);
INSERT INTO `cd_log` VALUES (4148, 209, 'fjc6036', '用户登录', '14.25.170.90', 1642167245);
INSERT INTO `cd_log` VALUES (4149, 209, 'fjc6036', '用户登录', '119.138.192.231', 1642207529);
INSERT INTO `cd_log` VALUES (4150, 671, 'zfw', '用户登录', '49.73.95.35', 1642213548);
INSERT INTO `cd_log` VALUES (4151, 209, 'fjc6036', '用户登录', '119.138.192.231', 1642252015);
INSERT INTO `cd_log` VALUES (4152, 276, 'jerry', '用户登录', '101.82.173.166', 1642257953);
INSERT INTO `cd_log` VALUES (4153, 209, 'fjc6036', '用户登录', '119.138.192.231', 1642293970);
INSERT INTO `cd_log` VALUES (4154, 209, 'fjc6036', '用户登录', '14.28.162.29', 1642342525);
INSERT INTO `cd_log` VALUES (4155, 852, 'cat便利', '用户登录', '111.32.78.159', 1642342646);
INSERT INTO `cd_log` VALUES (4156, 209, 'fjc6036', '用户登录', '119.138.193.84', 1642380607);
INSERT INTO `cd_log` VALUES (4157, 276, 'jerry', '用户登录', '120.197.165.128', 1642386624);
INSERT INTO `cd_log` VALUES (4158, 213, 'kent', '用户登录', '223.73.226.197', 1642397545);
INSERT INTO `cd_log` VALUES (4159, 209, 'fjc6036', '用户登录', '119.138.192.171', 1642426334);
INSERT INTO `cd_log` VALUES (4160, 526, 'jjxfl', '用户登录', '120.43.210.177', 1642429911);
INSERT INTO `cd_log` VALUES (4161, 209, 'fjc6036', '用户登录', '180.136.118.184', 1642467261);
INSERT INTO `cd_log` VALUES (4162, 1290, 'zhou1234', '用户登录', '101.39.76.225', 1642514127);
INSERT INTO `cd_log` VALUES (4163, 209, 'fjc6036', '用户登录', '180.140.221.156', 1642551156);
INSERT INTO `cd_log` VALUES (4164, 102, '13145201141', '用户登录', '222.211.121.107', 1642579360);
INSERT INTO `cd_log` VALUES (4165, 102, '13145201141', '用户登录', '222.211.121.107', 1642581490);
INSERT INTO `cd_log` VALUES (4166, 1292, '九江优品尚城菜鸟驿站', '用户登录', '183.219.112.209', 1642598646);
INSERT INTO `cd_log` VALUES (4167, 209, 'fjc6036', '用户登录', '180.140.221.156', 1642612516);
INSERT INTO `cd_log` VALUES (4168, 209, 'fjc6036', '用户登录', '180.140.221.156', 1642636781);
INSERT INTO `cd_log` VALUES (4169, 209, 'fjc6036', '用户登录', '106.108.36.58', 1642702348);
INSERT INTO `cd_log` VALUES (4170, 1290, 'zhou1234', '用户登录', '101.39.76.225', 1642745199);
INSERT INTO `cd_log` VALUES (4171, 1290, 'zhou1234', '用户登录', '101.39.76.225', 1642745414);
INSERT INTO `cd_log` VALUES (4172, 1290, 'zhou1234', '用户登录', '101.39.76.225', 1642747936);
INSERT INTO `cd_log` VALUES (4173, 1290, 'zhou1234', '用户登录', '101.39.76.225', 1642749286);
INSERT INTO `cd_log` VALUES (4174, 1292, '九江优品尚城菜鸟驿站', '用户登录', '183.219.112.209', 1642774038);
INSERT INTO `cd_log` VALUES (4175, 209, 'fjc6036', '用户登录', '106.108.36.58', 1642811111);
INSERT INTO `cd_log` VALUES (4176, 1290, 'zhou1234', '用户登录', '101.39.76.225', 1642819441);
INSERT INTO `cd_log` VALUES (4177, 1292, '九江优品尚城菜鸟驿站', '用户登录', '183.219.112.209', 1642829985);
INSERT INTO `cd_log` VALUES (4178, 209, 'fjc6036', '用户登录', '106.108.66.55', 1642861893);
INSERT INTO `cd_log` VALUES (4179, 209, 'fjc6036', '用户登录', '106.108.66.55', 1642897951);
INSERT INTO `cd_log` VALUES (4180, 209, 'fjc6036', '用户登录', '106.108.66.55', 1642898002);
INSERT INTO `cd_log` VALUES (4181, 525, 'jia93chuan02', '用户登录', '171.8.221.173', 1642917996);
INSERT INTO `cd_log` VALUES (4182, 209, 'fjc6036', '用户登录', '106.108.45.42', 1642947083);
INSERT INTO `cd_log` VALUES (4183, 209, 'fjc6036', '用户登录', '106.108.45.42', 1642985426);
INSERT INTO `cd_log` VALUES (4184, 209, 'fjc6036', '用户登录', '106.108.84.18', 1643034120);
INSERT INTO `cd_log` VALUES (4185, 209, 'fjc6036', '用户登录', '114.135.248.55', 1643073009);
INSERT INTO `cd_log` VALUES (4186, 209, 'fjc6036', '用户登录', '117.188.56.92', 1643119916);
INSERT INTO `cd_log` VALUES (4187, 209, 'fjc6036', '用户登录', '117.188.56.92', 1643120831);
INSERT INTO `cd_log` VALUES (4188, 198, 'pengzq_168', '用户登录', '120.245.92.95', 1643175462);
INSERT INTO `cd_log` VALUES (4189, 1299, '15563460001', '用户登录', '140.250.237.195', 1643187178);
INSERT INTO `cd_log` VALUES (4190, 1299, '15563460001', '用户登录', '140.250.237.195', 1643204562);
INSERT INTO `cd_log` VALUES (4191, 1299, '15563460001', '用户登录', '140.250.237.195', 1643204866);
INSERT INTO `cd_log` VALUES (4192, 852, 'cat便利', '用户登录', '221.197.235.107', 1643221155);
INSERT INTO `cd_log` VALUES (4193, 852, 'cat便利', '用户登录', '221.197.235.107', 1643223040);
INSERT INTO `cd_log` VALUES (4194, 852, 'cat便利', '用户登录', '221.197.235.107', 1643223066);
INSERT INTO `cd_log` VALUES (4195, 852, 'cat便利', '用户登录', '221.197.235.107', 1643224597);
INSERT INTO `cd_log` VALUES (4196, 209, 'fjc6036', '用户登录', '106.108.5.96', 1643243867);
INSERT INTO `cd_log` VALUES (4197, 1300, 'Asher', '用户登录', '1.182.206.107', 1643248822);
INSERT INTO `cd_log` VALUES (4198, 209, 'fjc6036', '用户登录', '106.108.83.245', 1643294250);
INSERT INTO `cd_log` VALUES (4199, 209, 'fjc6036', '用户登录', '114.138.45.70', 1643330666);
INSERT INTO `cd_log` VALUES (4200, 209, 'fjc6036', '用户登录', '106.109.49.28', 1643341779);
INSERT INTO `cd_log` VALUES (4201, 209, 'fjc6036', '用户登录', '106.109.66.129', 1643383057);
INSERT INTO `cd_log` VALUES (4202, 852, 'cat便利', '用户登录', '103.3.98.155', 1643415472);
INSERT INTO `cd_log` VALUES (4203, 209, 'fjc6036', '用户登录', '114.135.221.71', 1643416076);
INSERT INTO `cd_log` VALUES (4204, 173, 'yixiang', '用户登录', '182.136.134.76', 1643416820);
INSERT INTO `cd_log` VALUES (4205, 852, 'cat便利', '用户登录', '103.3.98.155', 1643418028);
INSERT INTO `cd_log` VALUES (4206, 173, 'yixiang', '用户登录', '182.136.134.76', 1643419368);
INSERT INTO `cd_log` VALUES (4207, 102, '13145201141', '用户登录', '222.209.39.44', 1643431832);
INSERT INTO `cd_log` VALUES (4208, 102, '13145201141', '用户登录', '222.209.39.44', 1643439422);
INSERT INTO `cd_log` VALUES (4209, 209, 'fjc6036', '用户登录', '117.188.45.95', 1643479403);
INSERT INTO `cd_log` VALUES (4210, 209, 'fjc6036', '用户登录', '106.109.49.192', 1643505818);
INSERT INTO `cd_log` VALUES (4211, 102, '13145201141', '用户登录', '182.148.89.50', 1643545908);
INSERT INTO `cd_log` VALUES (4212, 209, 'fjc6036', '用户登录', '106.109.49.192', 1643553478);
INSERT INTO `cd_log` VALUES (4213, 209, 'fjc6036', '用户登录', '106.109.49.192', 1643587742);
INSERT INTO `cd_log` VALUES (4214, 102, '13145201141', '用户登录', '61.188.94.171', 1643620263);
INSERT INTO `cd_log` VALUES (4215, 209, 'fjc6036', '用户登录', '114.138.24.247', 1643646144);
INSERT INTO `cd_log` VALUES (4216, 209, 'fjc6036', '用户登录', '114.138.24.247', 1643675162);
INSERT INTO `cd_log` VALUES (4217, 852, 'cat便利', '用户登录', '103.3.98.155', 1643730074);
INSERT INTO `cd_log` VALUES (4218, 209, 'fjc6036', '用户登录', '106.109.83.162', 1643767166);
INSERT INTO `cd_log` VALUES (4219, 209, 'fjc6036', '用户登录', '106.43.204.186', 1643818307);
INSERT INTO `cd_log` VALUES (4220, 209, 'fjc6036', '用户登录', '106.43.204.186', 1643847591);
INSERT INTO `cd_log` VALUES (4221, 209, 'fjc6036', '用户登录', '106.108.35.208', 1643899076);
INSERT INTO `cd_log` VALUES (4222, 209, 'fjc6036', '用户登录', '106.109.18.22', 1643933067);
INSERT INTO `cd_log` VALUES (4223, 852, 'cat便利', '用户登录', '60.27.30.109', 1643983282);
INSERT INTO `cd_log` VALUES (4224, 209, 'fjc6036', '用户登录', '117.188.45.95', 1644000139);
INSERT INTO `cd_log` VALUES (4225, 852, 'cat便利', '用户登录', '211.94.208.124', 1644045555);
INSERT INTO `cd_log` VALUES (4226, 209, 'fjc6036', '用户登录', '106.43.197.23', 1644108582);
INSERT INTO `cd_log` VALUES (4227, 462, '胡可良', '用户登录', '1.198.48.96', 1644119714);
INSERT INTO `cd_log` VALUES (4228, 209, 'fjc6036', '用户登录', '114.138.5.180', 1644152167);
INSERT INTO `cd_log` VALUES (4229, 852, 'cat便利', '用户登录', '111.32.78.41', 1644181193);
INSERT INTO `cd_log` VALUES (4230, 209, 'fjc6036', '用户登录', '114.138.5.180', 1644191043);
INSERT INTO `cd_log` VALUES (4231, 852, 'cat便利', '用户登录', '211.94.246.137', 1644307870);
INSERT INTO `cd_log` VALUES (4232, 209, 'fjc6036', '用户登录', '106.109.37.139', 1644343383);
INSERT INTO `cd_log` VALUES (4233, 1321, '15318812384', '用户登录', '119.86.178.82', 1644399494);
INSERT INTO `cd_log` VALUES (4234, 102, '13145201141', '用户登录', '222.212.7.189', 1644410602);
INSERT INTO `cd_log` VALUES (4235, 213, 'kent', '用户登录', '223.73.226.208', 1644414634);
INSERT INTO `cd_log` VALUES (4236, 209, 'fjc6036', '用户登录', '117.188.52.65', 1644421695);
INSERT INTO `cd_log` VALUES (4237, 852, 'cat便利', '用户登录', '211.94.246.137', 1644441856);
INSERT INTO `cd_log` VALUES (4238, 209, 'fjc6036', '用户登录', '114.135.220.59', 1644456337);
INSERT INTO `cd_log` VALUES (4239, 50, 'lwang', '用户登录', '117.189.21.143', 1644465220);
INSERT INTO `cd_log` VALUES (4240, 1220, 'lihaitao002', '用户登录', '219.136.237.107', 1644471771);
INSERT INTO `cd_log` VALUES (4241, 852, 'cat便利', '用户登录', '117.14.9.235', 1644473290);
INSERT INTO `cd_log` VALUES (4242, 1321, '15318812384', '用户登录', '119.86.120.150', 1644476284);
INSERT INTO `cd_log` VALUES (4243, 1321, '15318812384', '用户登录', '119.86.120.150', 1644478274);
INSERT INTO `cd_log` VALUES (4244, 50, 'lwang', '用户登录', '117.189.21.143', 1644478822);
INSERT INTO `cd_log` VALUES (4245, 1321, '15318812384', '用户登录', '183.228.0.196', 1644491616);
INSERT INTO `cd_log` VALUES (4246, 1220, 'lihaitao002', '用户登录', '219.136.237.107', 1644567019);
INSERT INTO `cd_log` VALUES (4247, 643, '小黄豆', '用户登录', '49.64.222.19', 1644577807);
INSERT INTO `cd_log` VALUES (4248, 643, '小黄豆', '用户登录', '114.217.139.17', 1644583437);
INSERT INTO `cd_log` VALUES (4249, 462, '胡可良', '用户登录', '171.12.63.39', 1644589076);
INSERT INTO `cd_log` VALUES (4250, 462, '胡可良', '用户登录', '171.12.62.14', 1644629777);
INSERT INTO `cd_log` VALUES (4251, 643, '小黄豆', '用户登录', '114.217.139.17', 1644632695);
INSERT INTO `cd_log` VALUES (4252, 209, 'fjc6036', '用户登录', '116.29.108.5', 1644674750);
INSERT INTO `cd_log` VALUES (4253, 671, 'zfw', '用户登录', '180.108.197.117', 1644713801);
INSERT INTO `cd_log` VALUES (4254, 209, 'fjc6036', '用户登录', '113.101.237.54', 1644716342);
INSERT INTO `cd_log` VALUES (4255, 671, 'zfw', '用户登录', '180.108.197.117', 1644726955);
INSERT INTO `cd_log` VALUES (4256, 329, 'JACY', '用户登录', '114.217.209.189', 1644752507);
INSERT INTO `cd_log` VALUES (4257, 671, 'zfw', '用户登录', '49.64.94.213', 1644756003);
INSERT INTO `cd_log` VALUES (4258, 213, 'kent', '用户登录', '223.73.226.245', 1644760635);
INSERT INTO `cd_log` VALUES (4259, 526, 'jjxfl', '用户登录', '120.43.210.177', 1644847679);
INSERT INTO `cd_log` VALUES (4260, 671, 'zfw', '用户登录', '49.84.151.112', 1644900754);
INSERT INTO `cd_log` VALUES (4261, 1108, 'zcdz', '用户登录', '49.84.151.112', 1644900810);
INSERT INTO `cd_log` VALUES (4262, 671, 'zfw', '用户登录', '49.84.151.112', 1644902384);
INSERT INTO `cd_log` VALUES (4263, 1290, 'zhou1234', '用户登录', '101.39.69.21', 1644916747);
INSERT INTO `cd_log` VALUES (4264, 1108, 'zcdz', '用户登录', '49.84.151.112', 1644931817);
INSERT INTO `cd_log` VALUES (4265, 1108, 'zcdz', '用户登录', '140.114.214.60', 1644933239);
INSERT INTO `cd_log` VALUES (4266, 336, 'cctv9595', '用户登录', '14.157.4.51', 1644996273);
INSERT INTO `cd_log` VALUES (4267, 526, 'jjxfl', '用户登录', '120.43.210.177', 1645000160);
INSERT INTO `cd_log` VALUES (4268, 643, '小黄豆', '用户登录', '49.64.222.19', 1645066189);
INSERT INTO `cd_log` VALUES (4269, 852, 'cat便利', '用户登录', '117.12.128.234', 1645067706);
INSERT INTO `cd_log` VALUES (4270, 643, '小黄豆', '用户登录', '49.64.222.19', 1645164222);
INSERT INTO `cd_log` VALUES (4271, 336, 'cctv9595', '用户登录', '14.157.5.71', 1645367724);
INSERT INTO `cd_log` VALUES (4272, 1, 'admin', '用户登录', '117.189.23.177', 1645424222);
INSERT INTO `cd_log` VALUES (4273, 643, '小黄豆', '用户登录', '49.64.222.19', 1645434119);
INSERT INTO `cd_log` VALUES (4274, 852, 'cat便利', '用户登录', '221.197.234.191', 1645434273);
INSERT INTO `cd_log` VALUES (4275, 514, 'testtest', '用户登录', '182.150.156.140', 1645509867);
INSERT INTO `cd_log` VALUES (4276, 1321, '15318812384', '用户登录', '119.86.122.27', 1645516440);
INSERT INTO `cd_log` VALUES (4277, 643, '小黄豆', '用户登录', '121.227.234.238', 1645527850);
INSERT INTO `cd_log` VALUES (4278, 1321, '15318812384', '用户登录', '183.228.0.109', 1645581906);
INSERT INTO `cd_log` VALUES (4279, 1, 'admin', '用户登录', '117.189.23.86', 1645584878);
INSERT INTO `cd_log` VALUES (4280, 1, 'admin', '用户登录', '117.189.23.86', 1645589475);
INSERT INTO `cd_log` VALUES (4281, 643, '小黄豆', '用户登录', '121.227.234.238', 1645600196);
INSERT INTO `cd_log` VALUES (4282, 643, '小黄豆', '用户登录', '114.220.235.89', 1645601308);
INSERT INTO `cd_log` VALUES (4283, 336, 'cctv9595', '用户登录', '14.157.5.149', 1645603562);
INSERT INTO `cd_log` VALUES (4284, 852, 'cat便利', '用户登录', '221.197.235.212', 1645607435);
INSERT INTO `cd_log` VALUES (4285, 643, '小黄豆', '用户登录', '114.220.235.89', 1645666773);
INSERT INTO `cd_log` VALUES (4286, 514, 'testtest', '用户登录', '182.150.153.35', 1645676848);
INSERT INTO `cd_log` VALUES (4287, 336, 'cctv9595', '用户登录', '14.157.4.246', 1645688996);
INSERT INTO `cd_log` VALUES (4288, 514, 'testtest', '用户登录', '182.150.153.35', 1645697593);
INSERT INTO `cd_log` VALUES (4289, 213, 'kent', '用户登录', '223.73.226.214', 1645707679);
INSERT INTO `cd_log` VALUES (4290, 852, 'cat便利', '用户登录', '111.32.79.44', 1645710501);
INSERT INTO `cd_log` VALUES (4291, 1321, '15318812384', '用户登录', '14.108.205.201', 1645750627);
INSERT INTO `cd_log` VALUES (4292, 233, 'linyuanyao', '用户登录', '39.182.58.231', 1645751465);
INSERT INTO `cd_log` VALUES (4293, 1350, 'zbh', '用户登录', '115.230.13.252', 1645756631);
INSERT INTO `cd_log` VALUES (4294, 1352, '3d', '用户登录', '110.230.135.27', 1645758120);
INSERT INTO `cd_log` VALUES (4295, 1350, 'zbh', '用户登录', '115.230.13.252', 1645758311);
INSERT INTO `cd_log` VALUES (4296, 1352, '3D', '用户登录', '110.230.135.27', 1645775801);
INSERT INTO `cd_log` VALUES (4297, 1321, '15318812384', '用户登录', '14.108.200.146', 1645794945);
INSERT INTO `cd_log` VALUES (4298, 380, 'wk5779151', '用户登录', '112.51.19.16', 1645833421);
INSERT INTO `cd_log` VALUES (4299, 514, 'testtest', '用户登录', '182.150.156.100', 1645869655);
INSERT INTO `cd_log` VALUES (4300, 1350, 'zbh', '用户登录', '115.209.211.81', 1645964585);
INSERT INTO `cd_log` VALUES (4301, 1350, 'zbh', '用户登录', '115.209.211.81', 1645964948);
INSERT INTO `cd_log` VALUES (4302, 1350, 'zbh', '用户登录', '115.209.211.81', 1645966504);
INSERT INTO `cd_log` VALUES (4303, 1, 'admin', '用户登录', '111.121.10.55', 1645966549);
INSERT INTO `cd_log` VALUES (4304, 1350, 'zbh', '用户登录', '115.209.211.81', 1645970591);
INSERT INTO `cd_log` VALUES (4305, 1350, 'zbh', '用户登录', '115.209.211.81', 1645970964);
INSERT INTO `cd_log` VALUES (4306, 1350, 'zbh', '用户登录', '115.209.211.81', 1645972092);
INSERT INTO `cd_log` VALUES (4307, 1, 'admin', '用户登录', '111.121.10.55', 1645973186);
INSERT INTO `cd_log` VALUES (4308, 1350, 'zbh', '用户登录', '115.209.211.81', 1645973439);
INSERT INTO `cd_log` VALUES (4309, 1350, 'zbh', '用户登录', '115.209.211.81', 1645973940);
INSERT INTO `cd_log` VALUES (4310, 1350, 'zbh', '用户登录', '115.230.9.215', 1646011293);
INSERT INTO `cd_log` VALUES (4311, 1350, 'zbh', '用户登录', '115.230.9.215', 1646012529);
INSERT INTO `cd_log` VALUES (4312, 1321, '15318812384', '用户登录', '14.108.51.37', 1646013640);
INSERT INTO `cd_log` VALUES (4313, 213, 'kent', '用户登录', '223.73.226.29', 1646015190);
INSERT INTO `cd_log` VALUES (4314, 1350, 'zbh', '用户登录', '115.230.9.215', 1646017157);
INSERT INTO `cd_log` VALUES (4315, 1350, 'zbh', '用户登录', '112.17.247.181', 1646017528);
INSERT INTO `cd_log` VALUES (4316, 1350, 'zbh', '用户登录', '112.17.247.181', 1646017623);
INSERT INTO `cd_log` VALUES (4317, 1350, 'zbh', '用户登录', '115.230.9.215', 1646036969);
INSERT INTO `cd_log` VALUES (4318, 1321, '15318812384', '用户登录', '183.228.0.14', 1646100542);
INSERT INTO `cd_log` VALUES (4319, 1350, 'zbh', '用户登录', '115.230.9.215', 1646103369);
INSERT INTO `cd_log` VALUES (4320, 1350, 'zbh', '用户登录', '115.230.9.215', 1646103774);
INSERT INTO `cd_log` VALUES (4321, 1350, 'zbh', '用户登录', '115.230.9.215', 1646105530);
INSERT INTO `cd_log` VALUES (4322, 514, 'testtest', '用户登录', '182.150.156.100', 1646122121);
INSERT INTO `cd_log` VALUES (4323, 1350, 'zbh', '用户登录', '115.230.9.215', 1646123715);
INSERT INTO `cd_log` VALUES (4324, 1, 'admin', '用户登录', '43.134.32.6', 1646126001);
INSERT INTO `cd_log` VALUES (4325, 1350, 'zbh', '用户登录', '43.134.32.6', 1646127090);
INSERT INTO `cd_log` VALUES (4326, 852, 'cat便利', '用户登录', '60.27.158.8', 1646150447);
INSERT INTO `cd_log` VALUES (4327, 1321, '15318812384', '用户登录', '14.108.60.48', 1646185697);
INSERT INTO `cd_log` VALUES (4328, 1, 'admin', '用户登录', '117.189.23.86', 1646191968);
INSERT INTO `cd_log` VALUES (4329, 1350, 'zbh', '用户登录', '115.230.9.215', 1646192029);
INSERT INTO `cd_log` VALUES (4330, 1350, 'zbh', '用户登录', '220.191.255.80', 1646192615);
INSERT INTO `cd_log` VALUES (4331, 1350, 'zbh', '用户登录', '117.189.23.86', 1646195726);
INSERT INTO `cd_log` VALUES (4332, 1, 'admin', '用户登录', '117.189.23.86', 1646195865);
INSERT INTO `cd_log` VALUES (4333, 514, 'testtest', '用户登录', '182.150.156.100', 1646196452);
INSERT INTO `cd_log` VALUES (4334, 1350, 'zbh', '用户登录', '117.189.23.86', 1646197566);
INSERT INTO `cd_log` VALUES (4335, 1, 'admin', '用户登录', '117.189.23.86', 1646197703);
INSERT INTO `cd_log` VALUES (4336, 1350, 'zbh', '用户登录', '117.189.23.86', 1646198533);
INSERT INTO `cd_log` VALUES (4337, 1350, 'zbh', '用户登录', '220.191.255.80', 1646206476);
INSERT INTO `cd_log` VALUES (4338, 1321, '15318812384', '用户登录', '183.228.0.14', 1646207516);
INSERT INTO `cd_log` VALUES (4339, 146, 'matai112', '用户登录', '106.121.184.79', 1646209149);
INSERT INTO `cd_log` VALUES (4340, 671, 'zfw', '用户登录', '121.224.109.159', 1646222088);
INSERT INTO `cd_log` VALUES (4341, 1350, 'zbh', '用户登录', '39.172.184.69', 1646225756);
INSERT INTO `cd_log` VALUES (4342, 462, '胡可良', '用户登录', '171.12.63.90', 1646260399);
INSERT INTO `cd_log` VALUES (4343, 462, '胡可良', '用户登录', '171.12.62.219', 1646285832);
INSERT INTO `cd_log` VALUES (4344, 1350, 'zbh', '用户登录', '220.191.255.80', 1646292730);
INSERT INTO `cd_log` VALUES (4345, 1350, 'zbh', '用户登录', '115.230.9.215', 1646293331);
INSERT INTO `cd_log` VALUES (4346, 1, 'admin', '用户登录', '117.189.23.86', 1646293363);
INSERT INTO `cd_log` VALUES (4347, 1350, 'zbh', '用户登录', '115.230.9.215', 1646296933);
INSERT INTO `cd_log` VALUES (4348, 276, 'jerry', '用户登录', '114.228.32.124', 1646297606);
INSERT INTO `cd_log` VALUES (4349, 276, 'jerry', '用户登录', '114.228.32.124', 1646297694);
INSERT INTO `cd_log` VALUES (4350, 1, 'admin', '用户登录', '111.121.14.238', 1646309570);
INSERT INTO `cd_log` VALUES (4351, 462, '胡可良', '用户登录', '171.12.62.219', 1646310047);
INSERT INTO `cd_log` VALUES (4352, 1321, '15318812384', '用户登录', '183.70.106.219', 1646357775);
INSERT INTO `cd_log` VALUES (4353, 1108, 'zcdz', '用户登录', '114.217.198.22', 1646358437);
INSERT INTO `cd_log` VALUES (4354, 671, 'zfw', '用户登录', '114.217.198.22', 1646360768);
INSERT INTO `cd_log` VALUES (4355, 1350, 'zbh', '用户登录', '115.230.9.215', 1646361919);
INSERT INTO `cd_log` VALUES (4356, 1350, 'zbh', '用户登录', '220.191.255.80', 1646362718);
INSERT INTO `cd_log` VALUES (4357, 1350, 'zbh', '用户登录', '220.191.255.80', 1646375173);
INSERT INTO `cd_log` VALUES (4358, 1362, 'qyxzgh', '用户登录', '220.191.255.80', 1646380817);
INSERT INTO `cd_log` VALUES (4359, 1, 'admin', '用户登录', '111.121.14.238', 1646382588);
INSERT INTO `cd_log` VALUES (4360, 1362, 'qyxzgh', '用户登录', '111.121.14.238', 1646383937);
INSERT INTO `cd_log` VALUES (4361, 1, 'admin', '用户登录', '111.121.14.238', 1646383980);
INSERT INTO `cd_log` VALUES (4362, 1362, 'qyxzgh', '用户登录', '111.121.14.238', 1646384254);
INSERT INTO `cd_log` VALUES (4363, 1362, 'qyxzgh', '用户登录', '220.191.255.80', 1646384612);
INSERT INTO `cd_log` VALUES (4364, 643, '小黄豆', '用户登录', '121.227.234.238', 1646391675);
INSERT INTO `cd_log` VALUES (4365, 1362, 'qyxzgh', '用户登录', '39.172.184.34', 1646392460);
INSERT INTO `cd_log` VALUES (4366, 1362, 'qyxzgh', '用户登录', '39.172.184.34', 1646397453);
INSERT INTO `cd_log` VALUES (4367, 1362, 'qyxzgh', '用户登录', '39.172.184.34', 1646397653);
INSERT INTO `cd_log` VALUES (4368, 1362, 'qyxzgh', '用户登录', '39.172.184.34', 1646401738);
INSERT INTO `cd_log` VALUES (4369, 1362, 'qyxzgh', '用户登录', '39.172.184.34', 1646403245);
INSERT INTO `cd_log` VALUES (4370, 1321, '15318812384', '用户登录', '119.86.101.141', 1646405582);
INSERT INTO `cd_log` VALUES (4371, 1321, '15318812384', '用户登录', '119.86.101.141', 1646406657);
INSERT INTO `cd_log` VALUES (4372, 1321, '15318812384', '用户登录', '183.228.0.14', 1646409098);
INSERT INTO `cd_log` VALUES (4373, 1321, '15318812384', '用户登录', '183.228.0.14', 1646411380);
INSERT INTO `cd_log` VALUES (4374, 1, 'admin', '用户登录', '111.121.44.40', 1646452796);
INSERT INTO `cd_log` VALUES (4375, 1362, 'qyxzgh', '用户登录', '43.134.32.6', 1646460241);
INSERT INTO `cd_log` VALUES (4376, 514, 'testtest', '用户登录', '182.150.155.155', 1646460627);
INSERT INTO `cd_log` VALUES (4377, 1321, '15318812384', '用户登录', '183.228.0.18', 1646462751);
INSERT INTO `cd_log` VALUES (4378, 1362, 'qyxzgh', '用户登录', '39.172.183.158', 1646476436);
INSERT INTO `cd_log` VALUES (4379, 1367, '李泓庆', '用户登录', '124.119.60.62', 1646483862);
INSERT INTO `cd_log` VALUES (4380, 671, 'zfw', '用户登录', '121.228.100.155', 1646485305);
INSERT INTO `cd_log` VALUES (4381, 462, '胡可良', '用户登录', '1.197.132.152', 1646485628);
INSERT INTO `cd_log` VALUES (4382, 462, '胡可良', '用户登录', '171.12.63.90', 1646488242);
INSERT INTO `cd_log` VALUES (4383, 1362, 'qyxzgh', '用户登录', '111.121.14.238', 1646493979);
INSERT INTO `cd_log` VALUES (4384, 1321, '15318812384', '用户登录', '183.228.0.18', 1646496914);
INSERT INTO `cd_log` VALUES (4385, 1321, '15318812384', '用户登录', '183.228.0.18', 1646529639);
INSERT INTO `cd_log` VALUES (4386, 1362, 'qyxzgh', '用户登录', '39.172.185.248', 1646529945);
INSERT INTO `cd_log` VALUES (4387, 1362, 'qyxzgh', '用户登录', '111.121.14.238', 1646532137);
INSERT INTO `cd_log` VALUES (4388, 1372, 'Wozhidaol', '用户登录', '122.156.85.220', 1646533001);
INSERT INTO `cd_log` VALUES (4389, 1321, '15318812384', '用户登录', '183.70.100.59', 1646536639);
INSERT INTO `cd_log` VALUES (4390, 1362, 'qyxzgh', '用户登录', '39.172.185.248', 1646553675);
INSERT INTO `cd_log` VALUES (4391, 1362, 'qyxzgh', '用户登录', '39.172.185.248', 1646554739);
INSERT INTO `cd_log` VALUES (4392, 643, '小黄豆', '用户登录', '121.227.234.238', 1646554903);
INSERT INTO `cd_log` VALUES (4393, 1321, '15318812384', '用户登录', '14.108.162.131', 1646571705);
INSERT INTO `cd_log` VALUES (4394, 1, 'admin', '用户登录', '111.121.11.213', 1677381319);
INSERT INTO `cd_log` VALUES (4395, 1, 'admin', '用户登录', '223.102.33.96', 1677547197);
INSERT INTO `cd_log` VALUES (4396, 1, 'admin', '用户登录', '113.205.31.5', 1677643506);
INSERT INTO `cd_log` VALUES (4397, 1, 'admin', '用户登录', '116.171.62.166', 1677679162);
INSERT INTO `cd_log` VALUES (4398, 1, 'admin', '用户登录', '113.132.40.116', 1677744149);
INSERT INTO `cd_log` VALUES (4399, 1, 'admin', '用户登录', '113.205.31.5', 1677823140);
INSERT INTO `cd_log` VALUES (4400, 1, 'admin', '用户登录', '117.176.186.161', 1677894494);
INSERT INTO `cd_log` VALUES (4401, 1, 'admin', '用户登录', '171.95.101.133', 1678013005);
INSERT INTO `cd_log` VALUES (4402, 1, 'admin', '用户登录', '116.21.29.224', 1678072467);
INSERT INTO `cd_log` VALUES (4403, 1, 'admin', '用户登录', '115.60.191.113', 1678241234);
INSERT INTO `cd_log` VALUES (4404, 1, 'admin', '用户登录', '121.33.191.194', 1678254606);
INSERT INTO `cd_log` VALUES (4405, 1, 'admin', '用户登录', '49.82.136.75', 1678265222);
INSERT INTO `cd_log` VALUES (4406, 1, 'admin', '用户登录', '175.162.126.56', 1678514820);
INSERT INTO `cd_log` VALUES (4407, 1, 'admin', '用户登录', '113.246.94.173', 1678693804);
INSERT INTO `cd_log` VALUES (4408, 1, 'admin', '用户登录', '49.67.60.102', 1678751632);
INSERT INTO `cd_log` VALUES (4409, 1, 'admin', '用户登录', '110.184.34.40', 1679043159);
INSERT INTO `cd_log` VALUES (4410, 1, 'admin', '用户登录', '182.136.145.29', 1679284478);
INSERT INTO `cd_log` VALUES (4411, 1, 'admin', '用户登录', '120.219.64.172', 1679406617);
INSERT INTO `cd_log` VALUES (4412, 1, 'admin', '用户登录', '27.17.240.17', 1679575088);
INSERT INTO `cd_log` VALUES (4413, 1, 'admin', '用户登录', '112.66.83.190', 1679646138);
INSERT INTO `cd_log` VALUES (4414, 1, 'admin', '用户登录', '112.66.83.190', 1679646891);
INSERT INTO `cd_log` VALUES (4415, 1, 'admin', '用户登录', '112.5.205.69', 1679677102);
INSERT INTO `cd_log` VALUES (4416, 1, 'admin', '用户登录', '121.32.180.71', 1679759743);
INSERT INTO `cd_log` VALUES (4417, 1, 'admin', '用户登录', '220.198.204.119', 1679811383);
INSERT INTO `cd_log` VALUES (4418, 1, 'admin', '用户登录', '180.108.224.112', 1679841698);
INSERT INTO `cd_log` VALUES (4419, 1, 'admin', '用户登录', '117.171.195.10', 1679908063);
INSERT INTO `cd_log` VALUES (4420, 1, 'admin', '用户登录', '119.131.2.195', 1680012213);
INSERT INTO `cd_log` VALUES (4421, 1, 'admin', '用户登录', '120.245.20.44', 1680061207);
INSERT INTO `cd_log` VALUES (4422, 1, 'admin', '用户登录', '119.39.65.154', 1680088592);
INSERT INTO `cd_log` VALUES (4423, 1, 'admin', '用户登录', '223.106.24.33', 1680095453);
INSERT INTO `cd_log` VALUES (4424, 1, 'admin', '用户登录', '113.108.136.90', 1680144323);
INSERT INTO `cd_log` VALUES (4425, 1, 'admin', '用户登录', '60.174.231.230', 1680168301);
INSERT INTO `cd_log` VALUES (4426, 1, 'admin', '用户登录', '116.6.54.118', 1680225282);
INSERT INTO `cd_log` VALUES (4427, 1, 'admin', '用户登录', '39.128.50.240', 1680330687);
INSERT INTO `cd_log` VALUES (4428, 1, 'admin', '用户登录', '39.89.45.36', 1680587184);
INSERT INTO `cd_log` VALUES (4429, 1, 'admin', '用户登录', '180.175.106.163', 1680769988);
INSERT INTO `cd_log` VALUES (4430, 1, 'admin', '用户登录', '183.161.129.207', 1681385851);
INSERT INTO `cd_log` VALUES (4431, 1, 'admin', '用户登录', '180.108.132.40', 1681657054);
INSERT INTO `cd_log` VALUES (4432, 1, 'admin', '用户登录', '122.191.254.30', 1681875443);
INSERT INTO `cd_log` VALUES (4433, 1, 'admin', '用户登录', '219.136.11.182', 1681913471);
INSERT INTO `cd_log` VALUES (4434, 1, 'admin', '用户登录', '39.173.58.46', 1681993938);
INSERT INTO `cd_log` VALUES (4435, 1, 'admin', '用户登录', '110.187.213.77', 1681997793);
INSERT INTO `cd_log` VALUES (4436, 1, 'admin', '用户登录', '58.49.25.222', 1682169340);
INSERT INTO `cd_log` VALUES (4437, 1, 'admin', '用户登录', '60.166.152.47', 1682243212);
INSERT INTO `cd_log` VALUES (4438, 1, 'admin', '用户登录', '124.113.248.101', 1682243286);
INSERT INTO `cd_log` VALUES (4439, 1, 'admin', '用户登录', '183.165.175.51', 1682300290);
INSERT INTO `cd_log` VALUES (4440, 1, 'admin', '用户登录', '14.23.92.186', 1682307605);
INSERT INTO `cd_log` VALUES (4441, 1, 'admin', '用户登录', '14.120.112.13', 1682309274);
INSERT INTO `cd_log` VALUES (4442, 1, 'admin', '用户登录', '60.180.125.61', 1682404522);
INSERT INTO `cd_log` VALUES (4443, 1, 'admin', '用户登录', '183.67.22.29', 1682494315);
INSERT INTO `cd_log` VALUES (4444, 1, 'admin', '用户登录', '124.93.50.37', 1682986355);
INSERT INTO `cd_log` VALUES (4445, 1, 'admin', '用户登录', '36.5.11.79', 1683100633);
INSERT INTO `cd_log` VALUES (4446, 1, 'admin', '用户登录', '222.215.22.222', 1683271242);
INSERT INTO `cd_log` VALUES (4447, 1, 'admin', '用户登录', '113.128.54.10', 1683271706);
INSERT INTO `cd_log` VALUES (4448, 1, 'admin', '用户登录', '113.128.54.10', 1683273178);
INSERT INTO `cd_log` VALUES (4449, 1, 'admin', '用户登录', '113.128.54.10', 1683273510);
INSERT INTO `cd_log` VALUES (4450, 1, 'admin', '用户登录', '113.128.54.10', 1683352128);
INSERT INTO `cd_log` VALUES (4451, 1, 'admin', '用户登录', '222.94.217.29', 1683539302);
INSERT INTO `cd_log` VALUES (4452, 1, 'admin', '用户登录', '221.11.56.98', 1683625291);
INSERT INTO `cd_log` VALUES (4453, 1, 'admin', '用户登录', '36.143.104.236', 1683642721);
INSERT INTO `cd_log` VALUES (4454, 1, 'admin', '用户登录', '222.212.85.162', 1683707958);
INSERT INTO `cd_log` VALUES (4455, 1, 'admin', '用户登录', '36.104.209.53', 1683708671);
INSERT INTO `cd_log` VALUES (4456, 1, 'admin', '用户登录', '123.185.182.92', 1683774003);
INSERT INTO `cd_log` VALUES (4457, 1, 'admin', '用户登录', '218.79.124.199', 1683799478);
INSERT INTO `cd_log` VALUES (4458, 1, 'admin', '用户登录', '106.119.53.99', 1683861360);
INSERT INTO `cd_log` VALUES (4459, 1, 'admin', '用户登录', '106.119.53.99', 1683861501);
INSERT INTO `cd_log` VALUES (4460, 1, 'admin', '用户登录', '222.95.82.171', 1683867490);
INSERT INTO `cd_log` VALUES (4461, 1, 'admin', '用户登录', '39.144.168.12', 1683996914);
INSERT INTO `cd_log` VALUES (4462, 1, 'admin', '用户登录', '218.104.225.73', 1684287728);
INSERT INTO `cd_log` VALUES (4463, 1, 'admin', '用户登录', '219.144.240.66', 1684317926);
INSERT INTO `cd_log` VALUES (4464, 1, 'admin', '用户登录', '116.22.54.140', 1684373879);
INSERT INTO `cd_log` VALUES (4465, 1, 'admin', '用户登录', '42.88.104.33', 1684515258);
INSERT INTO `cd_log` VALUES (4466, 1, 'admin', '用户登录', '60.176.114.136', 1684831795);
INSERT INTO `cd_log` VALUES (4467, 1, 'admin', '用户登录', '27.18.161.253', 1684838192);
INSERT INTO `cd_log` VALUES (4468, 1, 'admin', '用户登录', '124.133.213.182', 1684922591);
INSERT INTO `cd_log` VALUES (4469, 1, 'admin', '用户登录', '112.229.105.207', 1684928865);
INSERT INTO `cd_log` VALUES (4470, 1, 'admin', '用户登录', '61.154.14.157', 1684976285);
INSERT INTO `cd_log` VALUES (4471, 1, 'admin', '用户登录', '115.199.117.132', 1685030406);
INSERT INTO `cd_log` VALUES (4472, 1, 'admin', '用户登录', '113.218.147.241', 1685081096);
INSERT INTO `cd_log` VALUES (4473, 1, 'admin', '用户登录', '223.104.132.70', 1685081831);
INSERT INTO `cd_log` VALUES (4474, 1, 'admin', '用户登录', '112.47.202.55', 1685116729);
INSERT INTO `cd_log` VALUES (4475, 1, 'admin', '用户登录', '112.47.202.55', 1685116785);
INSERT INTO `cd_log` VALUES (4476, 1, 'admin', '用户登录', '112.47.202.55', 1685116866);
INSERT INTO `cd_log` VALUES (4477, 1, 'admin', '用户登录', '117.155.110.137', 1685192564);
INSERT INTO `cd_log` VALUES (4478, 1, 'admin', '用户登录', '183.157.1.77', 1685250789);
INSERT INTO `cd_log` VALUES (4479, 1, 'admin', '用户登录', '112.47.202.55', 1685283324);
INSERT INTO `cd_log` VALUES (4480, 1, 'admin', '用户登录', '36.101.214.77', 1685370858);
INSERT INTO `cd_log` VALUES (4481, 1, 'admin', '用户登录', '220.200.8.123', 1685435958);
INSERT INTO `cd_log` VALUES (4482, 1, 'admin', '用户登录', '180.121.86.69', 1685547919);
INSERT INTO `cd_log` VALUES (4483, 1, 'admin', '用户登录', '223.82.6.134', 1685579550);
INSERT INTO `cd_log` VALUES (4484, 1, 'admin', '用户登录', '112.65.62.90', 1686066188);
INSERT INTO `cd_log` VALUES (4485, 1, 'admin', '用户登录', '116.6.78.10', 1686117984);
INSERT INTO `cd_log` VALUES (4486, 1, 'admin', '用户登录', '120.236.233.123', 1686205583);
INSERT INTO `cd_log` VALUES (4487, 1, 'admin', '用户登录', '58.62.84.214', 1686214132);
INSERT INTO `cd_log` VALUES (4488, 1, 'admin', '用户登录', '120.85.91.15', 1686216031);
INSERT INTO `cd_log` VALUES (4489, 1, 'admin', '用户登录', '117.24.122.67', 1686229107);
INSERT INTO `cd_log` VALUES (4490, 1, 'admin', '用户登录', '183.92.222.228', 1686279619);
INSERT INTO `cd_log` VALUES (4491, 1, 'admin', '用户登录', '223.74.23.14', 1686281909);
INSERT INTO `cd_log` VALUES (4492, 1, 'admin', '用户登录', '1.195.24.11', 1686301934);
INSERT INTO `cd_log` VALUES (4493, 1, 'admin', '用户登录', '117.171.195.25', 1686575453);
INSERT INTO `cd_log` VALUES (4494, 1, 'admin', '用户登录', '117.169.186.250', 1686622997);
INSERT INTO `cd_log` VALUES (4495, 1, 'admin', '用户登录', '111.124.31.23', 1686639057);
INSERT INTO `cd_log` VALUES (4496, 1, 'admin', '用户登录', '113.128.54.235', 1686708659);
INSERT INTO `cd_log` VALUES (4497, 1, 'admin', '用户登录', '113.128.54.235', 1686710191);
INSERT INTO `cd_log` VALUES (4498, 1, 'admin', '用户登录', '111.121.11.220', 1686757063);
INSERT INTO `cd_log` VALUES (4499, 1, 'admin', '用户登录', '42.48.1.126', 1686789025);
INSERT INTO `cd_log` VALUES (4500, 1, 'admin', '用户登录', '219.232.72.11', 1686931341);
INSERT INTO `cd_log` VALUES (4501, 1, 'admin', '用户登录', '112.97.80.180', 1687013278);
INSERT INTO `cd_log` VALUES (4502, 1, 'admin', '用户登录', '123.163.78.214', 1687155371);
INSERT INTO `cd_log` VALUES (4503, 1, 'admin', '用户登录', '113.128.54.235', 1687167388);
INSERT INTO `cd_log` VALUES (4504, 1, 'admin', '用户登录', '61.136.106.174', 1687245730);
INSERT INTO `cd_log` VALUES (4505, 1, 'admin', '用户登录', '220.184.121.5', 1687270283);
INSERT INTO `cd_log` VALUES (4506, 1, 'admin', '用户登录', '111.14.153.42', 1687310907);
INSERT INTO `cd_log` VALUES (4507, 1, 'admin', '用户登录', '113.128.54.235', 1687312404);
INSERT INTO `cd_log` VALUES (4508, 1, 'admin', '用户登录', '27.157.39.89', 1687314475);
INSERT INTO `cd_log` VALUES (4509, 1, 'admin', '用户登录', '183.194.169.76', 1687314570);
INSERT INTO `cd_log` VALUES (4510, 1, 'admin', '用户登录', '175.15.139.147', 1687658536);
INSERT INTO `cd_log` VALUES (4511, 1, 'admin', '用户登录', '113.116.189.223', 1687658668);
INSERT INTO `cd_log` VALUES (4512, 1, 'admin', '用户登录', '117.139.198.223', 1687695647);
INSERT INTO `cd_log` VALUES (4513, 1, 'admin', '用户登录', '125.70.196.94', 1687699485);
INSERT INTO `cd_log` VALUES (4514, 1, 'admin', '用户登录', '180.111.187.201', 1687783100);
INSERT INTO `cd_log` VALUES (4515, 1, 'admin', '用户登录', '58.213.241.247', 1687783250);
INSERT INTO `cd_log` VALUES (4516, 1, 'admin', '用户登录', '120.196.89.186', 1687783405);
INSERT INTO `cd_log` VALUES (4517, 1, 'admin', '用户登录', '180.111.187.201', 1687783891);
INSERT INTO `cd_log` VALUES (4518, 1, 'admin', '用户登录', '14.112.230.197', 1687827389);
INSERT INTO `cd_log` VALUES (4519, 1, 'admin', '用户登录', '14.112.230.197', 1687828606);
INSERT INTO `cd_log` VALUES (4520, 1, 'admin', '用户登录', '14.112.230.197', 1687828681);
INSERT INTO `cd_log` VALUES (4521, 1, 'admin', '用户登录', '14.112.230.197', 1687829238);
INSERT INTO `cd_log` VALUES (4522, 1, 'admin', '用户登录', '112.80.40.183', 1687916528);
INSERT INTO `cd_log` VALUES (4523, 1, 'admin', '用户登录', '121.33.81.194', 1688001181);
INSERT INTO `cd_log` VALUES (4524, 1, 'admin', '用户登录', '14.127.189.203', 1688009751);
INSERT INTO `cd_log` VALUES (4525, 1, 'admin', '用户登录', '61.136.106.174', 1688085159);
INSERT INTO `cd_log` VALUES (4526, 1, 'admin', '用户登录', '183.209.102.251', 1688113591);
INSERT INTO `cd_log` VALUES (4527, 1, 'admin', '用户登录', '101.66.37.235', 1688193251);
INSERT INTO `cd_log` VALUES (4528, 1, 'admin', '用户登录', '117.188.31.237', 1688207360);
INSERT INTO `cd_log` VALUES (4529, 1, 'admin', '用户登录', '117.188.31.237', 1688207564);

-- ----------------------------
-- Table structure for cd_log_ts
-- ----------------------------
DROP TABLE IF EXISTS `cd_log_ts`;
CREATE TABLE `cd_log_ts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_log_ts
-- ----------------------------

-- ----------------------------
-- Table structure for cd_member
-- ----------------------------
DROP TABLE IF EXISTS `cd_member`;
CREATE TABLE `cd_member`  (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '呢称',
  `headimgurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '头像',
  `openid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'openid',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机号',
  `username` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '密码',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '注册时间',
  `sex` smallint(6) NULL DEFAULT 0 COMMENT '性别',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '状态',
  `user_id` int(10) NULL DEFAULT NULL COMMENT '所属用户',
  `ali_user_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝用户id',
  `member_type` smallint(6) NULL DEFAULT NULL COMMENT '会员类型',
  `member_ps` smallint(6) NULL DEFAULT NULL COMMENT '同意政策和协议',
  `unionid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'unionid',
  `realname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `remark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sCertificateNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸faceid',
  PRIMARY KEY (`member_id`) USING BTREE,
  INDEX `idx_unionid`(`unionid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 149489 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_member
-- ----------------------------

-- ----------------------------
-- Table structure for cd_menu
-- ----------------------------
DROP TABLE IF EXISTS `cd_menu`;
CREATE TABLE `cd_menu`  (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) NULL DEFAULT 0 COMMENT '父级id',
  `controller_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块名称',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块标题',
  `pk_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主键名',
  `table_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块数据库表',
  `is_create` tinyint(4) NULL DEFAULT NULL COMMENT '是否允许生成模块',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '0隐藏 10显示',
  `sortid` mediumint(9) NULL DEFAULT 0 COMMENT '排序号',
  `table_status` tinyint(4) NULL DEFAULT NULL COMMENT '是否生成数据库表',
  `is_url` tinyint(4) NULL DEFAULT NULL COMMENT '是否只是url链接',
  `url` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `menu_icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'icon字体图标',
  `tab_menu` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'tab选项卡菜单配置',
  `app_id` int(11) NULL DEFAULT NULL COMMENT '所属模块',
  `is_submit` tinyint(4) NULL DEFAULT NULL COMMENT '是否允许投稿',
  PRIMARY KEY (`menu_id`) USING BTREE,
  INDEX `controller_name`(`controller_name`) USING BTREE,
  INDEX `module_id`(`app_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 833 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_menu
-- ----------------------------
INSERT INTO `cd_menu` VALUES (12, 0, 'Sys', '系统管理', '', '', 1, 1, 7, 0, 0, '', 'fa fa-gears', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (17, 12, '', '后台首页', '', '', 1, 1, 2, 0, 1, '/admin/Index/main.html', 'fa fa-home', '', 1, 0);
INSERT INTO `cd_menu` VALUES (18, 12, 'User', '用户管理', 'user_id', 'user', 1, 1, 4, 1, 0, '', 'fa fa-user-secret', '', 1, 0);
INSERT INTO `cd_menu` VALUES (19, 12, 'Group', '分组管理', 'group_id', 'group', 1, 1, 5, 1, 0, '', 'fa fa-user', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (21, 12, '', '菜单管理', '', '', 1, 0, 3, 0, 1, '/admin/Menu/index?app_id=1', '', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (41, 12, 'Config', '系统配置', '', '', 1, 1, 7, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|门禁配置|隐私政策|服务协议', 1, 0);
INSERT INTO `cd_menu` VALUES (52, 12, 'Log', '登录日志', 'log_id', 'log', 1, 1, 6, 1, 0, '', 'glyphicon glyphicon-log-in', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (80, 12, 'Application', '应用管理', '', '', 1, 1, 1, 0, 0, '', '', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (524, 12, '', '修改密码', '', '', 0, 1, 8, 0, NULL, '/admin/Base/password', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (525, 12, '', '数据备份', '', '', 0, 1, 9, 0, NULL, '/admin/Backup/index', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (793, 0, 'Member', '会员管理', 'member_id', 'member', 1, 1, 793, 1, NULL, '', 'fa fa-users', '', 1, 0);
INSERT INTO `cd_menu` VALUES (794, 0, 'Member', '会员管理', 'member_id', 'member', 1, 1, 797, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (797, 0, 'Health', '健康登记', 'health_id', 'health', 1, NULL, 798, 1, NULL, NULL, NULL, NULL, 179, NULL);
INSERT INTO `cd_menu` VALUES (803, 808, 'Lock', '门锁列表', 'lock_id', 'lock', 1, 1, 803, 1, NULL, '', 'fa fa-list', '', 1, 0);
INSERT INTO `cd_menu` VALUES (802, 817, 'Health', '健康登记', 'health_id', 'health', 1, 1, 798, 0, NULL, '', 'fa fa-file-text', '', 1, 0);
INSERT INTO `cd_menu` VALUES (804, 817, 'Regpoint', '登记点管理', 'regpoint_id', 'regpoint', 1, 1, 804, 1, NULL, '', 'fa fa-dot-circle-o', '', 1, 0);
INSERT INTO `cd_menu` VALUES (805, 0, 'Regpoint', '登记点管理', 'regpoint_id', 'regpoint', 1, 1, 804, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (806, 0, 'User', '用户管理', 'user_id', 'user', 1, 1, 4, 0, 0, '', 'fa fa-user-secret', '', 179, 0);
INSERT INTO `cd_menu` VALUES (807, 808, 'LockType', '门锁类型', 'locktype_id', 'locktype', 1, 1, 812, 1, NULL, '', 'fa fa-wrench', '', 1, 0);
INSERT INTO `cd_menu` VALUES (808, 0, '', '门锁管理', '', '', 0, 1, 809, 1, NULL, '', 'fa fa-unlock', '', 1, 0);
INSERT INTO `cd_menu` VALUES (809, 808, 'LockAuth', '钥匙管理', 'lockauth_id', 'lockauth', 1, 1, 807, 1, NULL, '', 'fa fa-key', '', 1, 0);
INSERT INTO `cd_menu` VALUES (813, 0, 'Lock', '门锁列表', 'lock_id', 'lock', 1, 1, 803, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (814, 0, 'LockAuth', '钥匙管理', 'lockauth_id', 'lockauth', 1, 1, 807, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (812, 808, 'LockLog', '开门记录', 'locklog_id', 'locklog', 1, 1, 809, 1, NULL, '', 'fa fa-list-alt', '', 1, 0);
INSERT INTO `cd_menu` VALUES (815, 0, 'LockLog', '日志管理', 'locklog_id', 'locklog', 1, 1, 817, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (816, 0, 'Config', '系统配置', '', '', 1, 1, 793, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|微门禁配置', 179, 0);
INSERT INTO `cd_menu` VALUES (817, 0, '', '健康登记', '', '', 1, 1, 818, 0, NULL, '', 'fa fa-heartbeat', '', 1, 0);
INSERT INTO `cd_menu` VALUES (818, 808, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 818, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (819, 0, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 824, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (824, 808, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 824, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (825, 0, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 826, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (826, 0, 'Umember', '用户管理', 'umember_id', 'umember', 1, 1, 808, 1, NULL, '', 'fa fa-user', '', 1, 0);
INSERT INTO `cd_menu` VALUES (827, 0, 'Wservice', '服务管理', 'wservice_id', 'wservice', 1, 1, 827, 1, NULL, '', 'fa fa-share-alt', '', 1, 0);
INSERT INTO `cd_menu` VALUES (828, 0, 'Wservice', '服务管理', 'wservice_id', 'wservice', 1, 1, 827, 0, NULL, '', 'fa fa-share-alt', '', 179, 0);
INSERT INTO `cd_menu` VALUES (829, 0, '', '状态数据', '', '', 0, 1, 829, 0, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (830, 829, 'DoorStatus', '门状态数据', 'doorstatus_id', 'doorstatus', 1, 1, 830, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (831, 0, 'DoorStatus', '门状态数据', 'doorstatus_id', 'doorstatus', 1, 1, 830, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (832, 0, 'DoorStatus', '门状态数据', 'doorstatus_id', 'doorstatus', 1, 1, 830, 0, NULL, '', '', '', 181, 0);

-- ----------------------------
-- Table structure for cd_on_line_record
-- ----------------------------
DROP TABLE IF EXISTS `cd_on_line_record`;
CREATE TABLE `cd_on_line_record`  (
  `on_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `on_line_time` bigint(20) NULL DEFAULT NULL,
  `device_sn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`on_line_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_on_line_record
-- ----------------------------

-- ----------------------------
-- Table structure for cd_pwd
-- ----------------------------
DROP TABLE IF EXISTS `cd_pwd`;
CREATE TABLE `cd_pwd`  (
  `pwd_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pwd` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `pwd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码名称',
  `created_at` int(255) NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`pwd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_pwd
-- ----------------------------

-- ----------------------------
-- Table structure for cd_regpoint
-- ----------------------------
DROP TABLE IF EXISTS `cd_regpoint`;
CREATE TABLE `cd_regpoint`  (
  `regpoint_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `member_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员ID',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户ID',
  `regpointname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `regpointurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册点url',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `regpointqrcode` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登记点二维码',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '门ID',
  PRIMARY KEY (`regpoint_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 135 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_regpoint
-- ----------------------------

-- ----------------------------
-- Table structure for cd_umember
-- ----------------------------
DROP TABLE IF EXISTS `cd_umember`;
CREATE TABLE `cd_umember`  (
  `umember_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NULL DEFAULT NULL COMMENT '用户ID',
  `user_id` bigint(10) NULL DEFAULT NULL COMMENT '管理员ID',
  `status` smallint(6) NULL DEFAULT NULL COMMENT '状态',
  `ucreate_time` int(11) NULL DEFAULT NULL COMMENT '注册时间',
  `urealname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `authlocks` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权锁',
  `uremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`umember_id`) USING BTREE,
  INDEX `idx_member_id_user_id`(`member_id`, `user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 108797 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_umember
-- ----------------------------

-- ----------------------------
-- Table structure for cd_user
-- ----------------------------
DROP TABLE IF EXISTS `cd_user`;
CREATE TABLE `cd_user`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `user` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录用户名',
  `pwd` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录密码',
  `group_id` tinyint(4) NULL DEFAULT NULL COMMENT '所属分组ID',
  `type` tinyint(4) NULL DEFAULT NULL COMMENT '账户类型 1超级管理员 2普通管理员',
  `note` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '10正常 0禁用',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '添加时间',
  `member_id` int(11) NULL DEFAULT NULL COMMENT '会员ID',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1374 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_user
-- ----------------------------
INSERT INTO `cd_user` VALUES (1, '极客师傅', 'admin', '305afeb46a6aa7bca43880dcb29d634d', 1, 1, '超级管理员', 1, 1548558919, 35);

-- ----------------------------
-- Table structure for cd_wservice
-- ----------------------------
DROP TABLE IF EXISTS `cd_wservice`;
CREATE TABLE `cd_wservice`  (
  `wservice_id` int(11) NOT NULL AUTO_INCREMENT,
  `wservice_type` smallint(6) NULL DEFAULT NULL COMMENT '类型',
  `wservice_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `wservice_appid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'appid',
  `wservice_url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'url',
  `wservice_icon` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `wservice_sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `wservice_status` tinyint(4) NULL DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`wservice_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_wservice
-- ----------------------------
INSERT INTO `cd_wservice` VALUES (1, 2, '社区商店', 'wx51f303bf1367a448', '/pages/index/index', 'https://wxapp.wmj.com.cn/uploads/admin/202101/5ff9590cbd766.png', 5, 0);
INSERT INTO `cd_wservice` VALUES (2, 1, '开门记录', '', '/pages/logs/logs', 'https://wxapp.wmj.com.cn/uploads/admin/202101/5ff95acbeeecb.png', 4, 0);
INSERT INTO `cd_wservice` VALUES (3, 3, '使用帮助', '', 'https://doc.wmj.com.cn/1/page/39', 'https://wxapp.wmj.com.cn/uploads/admin/202101/600323a441bb6.png', 1, 1);
INSERT INTO `cd_wservice` VALUES (4, 2, '社区维修', 'wx51f303bf1367a448', 'pages/index/index', 'https://wxapp.wmj.com.cn/uploads/admin/202101/5ff965f300000.png', 2, 0);
INSERT INTO `cd_wservice` VALUES (5, 2, '共享会议室', '', '', 'https://wxapp.wmj.com.cn/uploads/admin/202101/5ff9662b85802.png', 3, 0);

SET FOREIGN_KEY_CHECKS = 1;
