/*
 Navicat Premium Data Transfer

 Source Server         : demo_wmj_com_cn
 Source Server Type    : MySQL
 Source Server Version : 80036
 Source Host           : demo.wmj.com.cn:3306
 Source Schema         : demo_wmj_com_cn

 Target Server Type    : MySQL
 Target Server Version : 80036
 File Encoding         : 65001

 Date: 27/04/2025 11:16:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cd_access
-- ----------------------------
DROP TABLE IF EXISTS `cd_access`;
CREATE TABLE `cd_access`  (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `purviewval` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '分组对应权限值',
  `group_id` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3114 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_access
-- ----------------------------
INSERT INTO `cd_access` VALUES (2317, '/admin/Health', 3);
INSERT INTO `cd_access` VALUES (2318, '/admin/Health/import', 3);
INSERT INTO `cd_access` VALUES (2319, '/admin/Health/index', 3);
INSERT INTO `cd_access` VALUES (2320, '/admin/Health/dumpData', 3);
INSERT INTO `cd_access` VALUES (2321, '/admin/Health/view', 3);
INSERT INTO `cd_access` VALUES (2322, '/admin/Health/delete', 3);
INSERT INTO `cd_access` VALUES (2323, '/admin/Health/update', 3);
INSERT INTO `cd_access` VALUES (2324, '/admin/Health/add', 3);
INSERT INTO `cd_access` VALUES (2519, '/admin/Member', 8);
INSERT INTO `cd_access` VALUES (2520, '/admin/Member/index', 8);
INSERT INTO `cd_access` VALUES (2521, '/admin/Member/updateExt', 8);
INSERT INTO `cd_access` VALUES (2522, '/admin/Member/add', 8);
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
INSERT INTO `cd_access` VALUES (3015, '/admin/Locktimes', 7);
INSERT INTO `cd_access` VALUES (3014, '/admin/LockLog/dumpData', 7);
INSERT INTO `cd_access` VALUES (3013, '/admin/LockLog/view', 7);
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
INSERT INTO `cd_access` VALUES (3034, '/admin/Health/dumpData', 7);
INSERT INTO `cd_access` VALUES (3035, '/admin/Health/view', 7);
INSERT INTO `cd_access` VALUES (3036, '/admin/Health/delete', 7);
INSERT INTO `cd_access` VALUES (3037, '/admin/Health/update', 7);
INSERT INTO `cd_access` VALUES (3038, '/admin/Health/add', 7);
INSERT INTO `cd_access` VALUES (3039, '/admin/Regpoint', 7);
INSERT INTO `cd_access` VALUES (3040, '/admin/Regpoint/index', 7);
INSERT INTO `cd_access` VALUES (3041, '/admin/Regpoint/updateExt', 7);
INSERT INTO `cd_access` VALUES (3042, '/admin/Regpoint/delete', 7);
INSERT INTO `cd_access` VALUES (3043, '/admin/Regpoint/view', 7);
INSERT INTO `cd_access` VALUES (3044, '/admin/', 7);
INSERT INTO `cd_access` VALUES (3045, '/admin/DoorStatus', 7);
INSERT INTO `cd_access` VALUES (3046, '/admin/DoorStatus/index', 7);
INSERT INTO `cd_access` VALUES (3047, '/admin/DoorStatus/updateExt', 7);
INSERT INTO `cd_access` VALUES (3113, '/admin/Umember/authlocks', 7);

-- ----------------------------
-- Table structure for cd_action
-- ----------------------------
DROP TABLE IF EXISTS `cd_action`;
CREATE TABLE `cd_action`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL COMMENT '模块ID',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '动作名称',
  `action_name` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '动作名称',
  `type` tinyint NOT NULL,
  `icon` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'icon图标',
  `pagesize` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT '20' COMMENT '每页显示数据条数',
  `is_view` tinyint NULL DEFAULT 0 COMMENT '是否按钮',
  `button_status` tinyint NULL DEFAULT NULL COMMENT '按钮是否显示列表',
  `sql_query` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL COMMENT 'sql数据源',
  `block_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '注释',
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '打开页面尺寸',
  `fields` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL COMMENT '操作的字段',
  `note` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '备注',
  `lable_color` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '按钮背景色',
  `relate_table` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '关联表',
  `relate_field` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '关联字段',
  `list_field` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '查询的字段',
  `bs_icon` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '按钮图标',
  `sortid` mediumint NULL DEFAULT 0 COMMENT '排序',
  `orderby` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '配置排序',
  `default_orderby` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '默认排序',
  `tree_config` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `jump` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '按钮跳转地址',
  `is_controller_create` tinyint NULL DEFAULT 1 COMMENT '是否生成控制其方法',
  `is_service_create` tinyint NULL DEFAULT NULL COMMENT '是否生成服务层方法',
  `is_view_create` tinyint NULL DEFAULT NULL COMMENT '视图生成',
  `cache_time` mediumint NULL DEFAULT NULL COMMENT '缓存时间',
  `log_status` tinyint NULL DEFAULT NULL COMMENT '是否生成日志',
  `api_auth` tinyint NULL DEFAULT NULL COMMENT '接口是否鉴权',
  `sms_auth` tinyint NULL DEFAULT NULL COMMENT '短信验证',
  `request_type` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '请求类型 get 或者 post',
  `captcha_auth` tinyint NULL DEFAULT NULL COMMENT '图片验证码验证',
  `do_condition` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '操作条件',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2915 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `cd_action` VALUES (2075, 18, '启用', 'start', 6, NULL, '', 1, 0, '', '修改状态', '1', 'status', NULL, 'success', '', '', '', 'fa fa-pencil', 2075, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2076, 18, '禁用', 'forbidden', 6, NULL, '', 1, 0, '', '修改状态', '0', 'status', NULL, 'success', '', '', '', 'fa fa-pencil', 2076, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2726, 793, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '会员管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2727, 793, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2728, 793, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'nickname,headimgurl,openid,mobile,username,password,create_time,sex,status', NULL, 'primary', '', '', '', 'fa fa-plus', 2728, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2729, 793, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|600px', 'nickname,headimgurl,openid,mobile,username,create_time,sex,status', NULL, 'success', '', '', '', 'fa fa-pencil', 2729, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2730, 793, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '800px|600px', 'nickname,headimgurl,openid,mobile,username,create_time,sex,status', NULL, 'danger', '', '', '', 'fa fa-trash', 2730, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2731, 793, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|600px', 'nickname,headimgurl,openid,mobile,username,create_time,sex,status', NULL, 'info', '', '', '', 'fa fa-plus', 2731, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2734, 794, '更新用户信息', 'update', 4, NULL, '20', 1, 1, '', '编辑数据', '', 'nickname,headimgurl,openid,mobile,sex,member_ps', NULL, 'success', '', '', '', 'fa fa-pencil', 2746, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2736, 794, '查看用户信息', 'view', 15, NULL, '20', 1, 0, '', '查看用户信息', '', 'nickname,headimgurl,openid,mobile,username,password,sex,status,create_time,member_ps', NULL, 'info', '', '', '', 'fa fa-plus', 2747, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2740, 793, '重置密码', 'resetpassword', 9, NULL, '', 1, 0, '', '修改密码', '600px|350px', 'password', NULL, 'primary', '', '', '', 'fa fa-lock', 2740, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2741, 797, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id', NULL, 'primary', '', '', '', 'fa fa-plus', 2741, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2744, 797, '查看数据详情页', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'info', '', '', '', 'fa fa-plus', 2768, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2747, 794, '小程序登录', 'xcxlogin', 28, NULL, '', 0, NULL, '', '小程序登录', 'openid', 'nickname,headimgurl,openid,mobile,username,password,sex,status,create_time', NULL, NULL, 'user', 'member_id', 'a.*,b.user_id', NULL, 2728, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2761, 802, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'primary', '', '', '', 'fa fa-plus', 2761, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2762, 802, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'success', '', '', '', 'fa fa-pencil', 2762, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2763, 802, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'user_id,create_time,lat,lng,txz,manyou,register_type,yiqu,health,job,position,second_address,first_address,name,mobile', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2763, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2764, 802, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid', NULL, 'info', '', '', '', 'fa fa-plus', 2764, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2765, 802, '导出', 'dumpData', 12, NULL, '20', 1, 0, NULL, '导出', '', 'user_id,create_time,lat,lng,txz,manyou,register_type,yiqu,health,job,position,second_address,first_address,name,mobile', NULL, 'warning', NULL, NULL, NULL, 'fa fa-download', 2765, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2767, 802, '数据列表', 'index', 1, NULL, '', 1, 0, '', '', '', 'name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id', NULL, 'primary', '', '', '', '', 2767, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2768, 797, '查看数据列表', 'list', 1, NULL, '20', 0, NULL, '', '', '', '', NULL, NULL, '', '', '', NULL, 2744, NULL, 'health_id desc', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2769, 803, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '门锁管理', '', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,online,lock_qrcode,create_time,successimg,successadimg,opsucnt', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2770, 803, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2771, 804, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '登记点管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2772, 804, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2775, 804, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2775, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2776, 804, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|450px', 'member_id,user_id,regpointname,regpointqrcode,create_time', NULL, 'info', '', '', '', 'fa fa-plus', 2776, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2779, 805, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'success', '', '', '', 'fa fa-pencil', 2774, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2780, 805, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2775, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2781, 805, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'info', '', '', '', 'fa fa-plus', 2776, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2784, 806, '修改', 'update', 4, '', '', 1, 1, '', '修改账户', '', 'name,user,group_id,type,note,status,member_id,create_time', '', 'success', '', '', '', 'fa fa-edit', 4, '', '', '', '', 1, 1, 1, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2785, 806, '修改密码', 'updatePassword', 9, '', '', 1, 0, '', '修改密码', '', 'pwd', '', 'warning', '', '', '', '', 6, '', '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2789, 806, '查询管理员', 'view', 15, NULL, '', 0, NULL, '', '', '', '', NULL, NULL, '', '', '', NULL, 2789, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2793, 794, '查询管理员ID', 'viewuserid', 15, NULL, '', 0, NULL, '', '查询管理员ID', '', '', NULL, NULL, 'user', 'member_id', 'a.member_id,b.*', NULL, 2793, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2794, 803, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,adnum,successimg,successadimg,hitshowminiad,openbtn,qrshowminiad,openadurl,opsucnt', NULL, 'primary', '', '', '', 'fa fa-plus', 2794, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2795, 803, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|100%', 'lock_name,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,lock_qrcode,adnum,successimg,successadimg,hitshowminiad,openbtn,qrshowminiad,openadurl,opsucnt', NULL, 'success', '', '', '', 'fa fa-pencil', 2795, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
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
INSERT INTO `cd_action` VALUES (2809, 809, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '600px|450px', 'auth_starttime,auth_endtime,auth_openlimit', NULL, 'success', '', '', '', 'fa fa-pencil', 2809, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2810, 809, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '800px|100%', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin', NULL, 'danger', '', '', '', 'fa fa-trash', 2810, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2811, 809, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin', NULL, 'info', '', '', '', 'fa fa-plus', 2811, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2824, 812, '首页数据列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '日志管理', '', '', NULL, 'primary', '', '', '', 'fa fa-bars', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2825, 812, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2828, 812, '删除', 'delete', 5, NULL, '20', 0, 1, NULL, '删除', '', 'member_id,lock_id,status,type,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2828, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2829, 812, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|450px', 'member_id,lock_id,status,type,create_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2829, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2831, 813, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '', '', NULL, 'primary', '', '', '', 'fa fa-plus', 2794, NULL, '', '', '', 0, 1, 1, 0, 1, 0, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2832, 813, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '', 'lock_name,mobile_check,applyauth,applyauth_check,location_check,status', NULL, 'success', '', '', '', 'fa fa-pencil', 2795, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2833, 813, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'member_id,user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time,lock_qrcode,online', NULL, 'danger', '', '', '', 'fa fa-trash', 2796, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2834, 813, '查询锁信息', 'view', 15, NULL, '20', 1, 0, '', '根据lock_id查询锁信息', '', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,lock_qrcode,online,successimg,successadimg,volume,openttscontent,addcardmode', NULL, 'info', '', '', '', 'fa fa-plus', 2797, NULL, '', '', '', 1, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2836, 813, '开门', 'opendoor', 4, NULL, '', 1, 0, '', '编辑数据', '', '', NULL, 'primary', '', '', '', 'fa fa-edit', 2805, NULL, '', '', '', 0, 1, 1, 0, 1, 1, 0, 'post', 0, '');
INSERT INTO `cd_action` VALUES (2837, 814, '根据会员id查询钥匙列表', 'getauthlistbymemid', 1, NULL, '20', 0, NULL, '', '根据会员id查询钥匙', '', 'lock_id', NULL, NULL, 'lock', 'lock_id', '', NULL, 1, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2838, 814, '申请钥匙', 'applyauth', 3, NULL, '20', 1, 0, '', '申请钥匙', '', 'lock_id,member_id,realname,remark,create_time,auth_status,user_id', NULL, 'primary', '', '', '', 'fa fa-plus', 2808, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2839, 814, '审核钥匙', 'verifyauth', 4, NULL, '20', 1, 1, '', '审核钥匙', '', 'lock_id,member_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_isadmin,auth_shareability,remark,create_time,auth_status,user_id', NULL, 'success', '', '', '', 'fa fa-pencil', 2809, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2840, 814, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'lock_id,member_id,auth_member_id,auth_endtime,auth_starttime,auth_shareability,remark,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2810, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2841, 814, '查看数据', 'getauthdetailbyid', 15, NULL, '20', 1, 0, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_lockauth as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '查看数据', '', 'lock_id,member_id,realname,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_isadmin,auth_shareability,remark,create_time,auth_status', NULL, 'info', '', '', '', 'fa fa-plus', 2811, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2842, 815, '获取开门记录', 'getopenlog', 1, NULL, '20', 0, NULL, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '获取开门日志', '', 'member_id', NULL, NULL, '', '', '', NULL, 1, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2843, 815, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '', 'member_id,lock_id,status,type,create_time', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2826, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2844, 815, '修改', 'update', 4, NULL, '20', 1, 1, NULL, '修改', '', 'member_id,lock_id,status,type,create_time', NULL, 'success', NULL, NULL, NULL, 'fa fa-pencil', 2827, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2845, 815, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,lock_id,status,type,create_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2828, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2846, 815, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '', 'member_id,lock_id,status,type,create_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2829, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2847, 18, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|100%', 'name,user,pwd,group_id,type,note,status,create_time,member_id', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2847, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2848, 816, '修改配置', 'index', 4, '', '', 1, 0, '', '修改', '', '', '', 'primary', '', '', '', '', 127, '', '', '', '', 0, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2849, 816, '获取配置信息', 'getconfig', 15, NULL, '20', 1, 0, '', '查看数据', '', 'site_title,site_logo,keyword,description,file_size,file_type,domain,copyright,wmjappid,wmjappsecret,wmjaeskey', NULL, 'info', '', '', '', 'fa fa-plus', 2849, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
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
INSERT INTO `cd_action` VALUES (2867, 816, '获取隐私政策和服务协议', 'getps', 15, NULL, '20', 1, 0, '', '获取隐私政策和服务协议', '800px|100%', 'privacypolicy,serviceagreement', NULL, 'info', '', '', '', 'fa fa-plus', 2867, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 0, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2868, 812, '添加', 'add', 3, NULL, '20', 0, 0, NULL, '添加', '800px|550px', 'member_id,lock_id,status,type,create_time,user_id,remark', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2868, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2869, 814, '根据锁id查询钥匙', 'getauthlistbylockid', 1, NULL, '', 0, NULL, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_lockauth as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '', '', '', NULL, NULL, '', '', '', NULL, 2869, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2870, 815, '根据锁id查询开门记录(管理员)', 'getopenlogbylockid', 1, NULL, '', 0, NULL, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '', '', '', NULL, NULL, '', '', '', NULL, 2870, NULL, '', '', NULL, 0, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2871, 824, '首页数据列表', 'index', 1, NULL, '20', 0, NULL, NULL, '卡管理', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
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
INSERT INTO `cd_action` VALUES (2890, 826, '首页数据列表', 'index', 1, NULL, '20', 1, 0, 'select a.*,b.headimgurl,b.nickname,b.realname,b.remark,b.mobile from cd_umember as a inner join cd_member as b  where a.member_id=b.member_id', '用户管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2891, 826, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2892, 826, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2892, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2893, 826, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '600px|450px', 'status,realname,remark', NULL, 'success', '', '', '', 'fa fa-pencil', 2894, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2894, 826, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,user_id,status,ucreate_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2895, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2895, 826, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2896, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2896, 826, '导出', 'dumpData', 12, NULL, '20', 1, 0, NULL, '导出', '', 'member_id,user_id,status,ucreate_time', NULL, 'warning', NULL, NULL, NULL, 'fa fa-download', 2914, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
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
INSERT INTO `cd_action` VALUES (2914, 826, '授权', 'authlocks', 4, NULL, '', 0, 1, '', '编辑数据', '600px|450px', 'status,member_id,authlocks', NULL, 'primary', '', '', '', 'fa fa-edit', 2893, NULL, '', '', '', 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '');

-- ----------------------------
-- Table structure for cd_adlog
-- ----------------------------
DROP TABLE IF EXISTS `cd_adlog`;
CREATE TABLE `cd_adlog`  (
  `adlog_id` int NOT NULL AUTO_INCREMENT COMMENT '广告日志id',
  `member_id` int NULL DEFAULT NULL COMMENT '加载广告的用户id',
  `adlog_page` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '广告页面',
  `adlog_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '广告类型',
  `adlog_adtime` int NULL DEFAULT NULL COMMENT '广告时长',
  `adlog_result` tinyint NULL DEFAULT NULL COMMENT '广告观看结果',
  `adlog_msg` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '消息',
  `adlog_createtime` int NULL DEFAULT NULL COMMENT '创建时间',
  `adlog_points` int NULL DEFAULT 0 COMMENT '积分',
  PRIMARY KEY (`adlog_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 345993 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_adlog
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 131 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `cd_appconfig` VALUES (8, 'base', '基本参数', 'nocheck', '[\"/admin/Login/Verify\",\"/admin/Login/indexQrCode\",\"/admin/Login/index\",\"/admin/Index/index\",\"/admin/Index/main\",\"/admin/Login/out\",\"/admin/Upload/editorUpload\",\"/admin/Upload/uploadImages\",\"/admin/Upload/uploadUeditor\",\"/admin/Login/captcha\"]', 'array', '无需验证的权限URL', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (9, 'base', '基本参数', 'img_show_status', '1', 'boolean', '鼠标悬停时是否显示图片', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (10, 'base', '基本参数', 'export_per_num', '50', 'integer', 'excel每次导入数据量', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (11, 'base', '基本参数', 'import_type', 'csv', 'string', '导入文件类型', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (12, 'base', '基本参数', 'clear_cache_dir', '1', 'boolean', '是否清除缓存', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (13, 'base', '基本参数', 'password_secrect', 'weimenjin', 'string', '密码加密密钥', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (14, 'api', '基本参数', 'api_input_log', '1', 'boolean', '是否记录API输入日志', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (15, 'api', '基本参数', 'successCode', '200', 'string', '成功返回码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (16, 'api', '基本参数', 'errorCode', '201', 'string', '错误返回码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (17, 'api', '基本参数', 'jwtExpireCode', '101', 'string', 'JWT过期码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (18, 'api', '基本参数', 'jwtErrorCode', '102', 'string', 'JWT无效码', '2024-10-13 23:11:54', 0, 1, 0, 0);
INSERT INTO `cd_appconfig` VALUES (19, 'wmjsms', '短信接口', 'wmjsms_appid', 'wmjsms_Cdddddddddd', 'string', '微门禁短信AppID', '2024-10-13 23:11:54', 1, 0, 93, 1);
INSERT INTO `cd_appconfig` VALUES (20, 'wmjsms', '短信接口', 'wmjsms_appsecret', '7kkrz6iz1Pdddddddddddd', 'string', '微门禁短信AppSecret', '2024-10-13 23:11:54', 1, 0, 93, 2);
INSERT INTO `cd_appconfig` VALUES (21, 'wifilock', '联网锁激活秘钥', 'wifilock_key', '012345', 'string', '联网锁激活密码', '2024-10-13 23:11:54', 0, 0, 91, 1);
INSERT INTO `cd_appconfig` VALUES (22, 'wifilock', '联网锁激活秘钥', 'wifilock_devicecid', '88888888888888888888', 'string', '联网锁devicecid', '2024-10-13 23:11:54', 0, 0, 91, 2);
INSERT INTO `cd_appconfig` VALUES (35, 'jwt', 'JWT配置', 'jwt_expire_time', '2592000', 'integer', 'JWT过期时间（秒）', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (36, 'jwt', 'JWT配置', 'jwt_refresh_expire_time', '2592000', 'integer', 'JWT刷新过期时间（秒）', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (37, 'jwt', 'JWT配置', 'jwt_secret', 'XvM4kf92dLzCwhgJixOkMeCdM4yzBHO9dlZbEbgQiD0=', 'string', 'JWT签名密钥', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (38, 'jwt', 'JWT配置', 'jwt_iss', 'client.weimenjin', 'string', 'JWT发送端', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (39, 'jwt', 'JWT配置', 'jwt_aud', 'server.weimenjin', 'string', 'JWT接收端', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (40, 'wxmp', '微信小程序配置', 'wxmp_appid', 'wx8f5b26d6dddddddd', 'string', 'AppID(小程序ID)', '2024-10-13 23:11:54', 1, 0, 100, 1);
INSERT INTO `cd_appconfig` VALUES (41, 'wxmp', '微信小程序配置', 'wxmp_appsecret', 'ddddddddddddddddddddddddddddddd', 'string', 'AppSecret(小程序密钥)', '2024-10-13 23:11:54', 1, 0, 100, 2);
INSERT INTO `cd_appconfig` VALUES (42, 'email', '邮件配置', 'Host', 'ssl://smtp.qq.com', 'string', 'SMTP服务器地址', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (43, 'email', '邮件配置', 'Port', '465', 'integer', 'SMTP服务器端口', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (44, 'email', '邮件配置', 'From', '88888888@qq.com', 'string', '发送者邮箱', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (45, 'email', '邮件配置', 'FromName', 'weimenjin', 'string', '发送者昵称', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (46, 'email', '邮件配置', 'Username', '88888888@qq.com', 'string', '邮箱用户名', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (47, 'email', '邮件配置', 'Password', '8888888888', 'string', '邮箱授权码', '2024-10-13 23:11:54', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (74, 'api_upload', 'API上传配置', 'api_upload_domain', '', 'string', 'API 上传域名', '2024-10-13 23:32:26', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (75, 'api_upload', 'API上传配置', 'api_upload_ext', 'jpg,png,gif,mp4', 'string', '允许的上传文件类型', '2024-10-13 23:32:26', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (76, 'api_upload', 'API上传配置', 'api_upload_max', '209715200', 'integer', '上传文件最大大小', '2024-10-13 23:32:26', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (77, 'autodtauth', '演示钥匙', 'autodtkey', '1', 'boolean', '是否启用', '2024-10-13 23:32:26', 0, 0, 94, 1);
INSERT INTO `cd_appconfig` VALUES (78, 'autodtauth', '演示钥匙', 'autodtkeylockid', '1', 'integer', '演示钥匙lock_id', '2024-10-13 23:32:26', 0, 0, 94, 2);
INSERT INTO `cd_appconfig` VALUES (94, 'official_accounts', '微信公众号配置', 'app_id', 'wxa2c18a9aa664852', 'string', '公众号 AppID', '2024-10-13 23:33:09', 1, 0, 99, 1);
INSERT INTO `cd_appconfig` VALUES (95, 'official_accounts', '微信公众号配置', 'secret', '7deac0096af41f4cb08b489', 'string', '公众号 Secret', '2024-10-13 23:33:09', 1, 0, 99, 2);
INSERT INTO `cd_appconfig` VALUES (96, 'official_accounts', '微信公众号配置', 'token', 'dddddddddddddddddddddddddd', 'string', '公众号 Token', '2024-10-13 23:33:09', 1, 0, 99, 3);
INSERT INTO `cd_appconfig` VALUES (97, 'pay_display', '支付显示配置', 'pay_display', '1', 'integer', '支付方式显示配置', '2024-10-13 23:33:15', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (98, 'wechart_pay', '微信支付配置', 'mch_id', '1346545201', 'string', '微信支付商户号', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (99, 'wechart_pay', '微信支付配置', 'key', 'dddddddddddddddddddddddddddd', 'string', '微信支付秘钥', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (100, 'wechart_pay', '微信支付配置', 'cert_path', 'extend/utils/wechart/zcerts/apiclient_cert.pem', 'string', '证书路径', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (101, 'wechart_pay', '微信支付配置', 'key_path', 'extend/utils/wechart/zcerts/apiclient_key.pem', 'string', '证书路径', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (102, 'wechart_pay', '微信支付配置', 'rsa_public_key_path', 'extend/utils/wechart/zcerts/public.pem', 'string', 'RSA 公钥路径', '2024-10-13 23:33:20', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (103, 'wechart_template', '公众号发送消息配置', 'gzhtempleteid1', 'zhUOmOA49yBmdddddddddddddddddd', 'string', '开门通知', '2024-10-13 23:33:26', 1, 0, 98, 1);
INSERT INTO `cd_appconfig` VALUES (104, 'wechart_template', '公众号发送消息配置', 'gzhtempleteid2', 'n1Zfe9bqxX5_9PWbbbbbbbbbbbbbbbbb', 'string', '申请审核', '2024-10-13 23:33:26', 1, 0, 98, 2);
INSERT INTO `cd_appconfig` VALUES (105, 'alipay', '支付宝小程序配置', 'appId', 'ttddf2ab4f42c0840301', 'string', '支付宝小程序appid', '2024-10-13 23:33:32', 1, 0, 98, 1);
INSERT INTO `cd_appconfig` VALUES (106, 'alipay', '支付宝小程序配置', 'gatewayUrl', 'MIIEogIBAAKbbbbbbbbb', 'string', '支付宝小程序appsecret', '2024-10-13 23:33:32', 1, 0, 98, 2);
INSERT INTO `cd_appconfig` VALUES (107, 'alipay', '支付宝小程序配置', 'rsaPrivateKey', 'MIIEogIBAAKCAbbbbbb', 'string', '支付宝RSA私钥', '2024-10-13 23:33:32', 1, 0, 98, 4);
INSERT INTO `cd_appconfig` VALUES (108, 'alipay', '支付宝小程序配置', 'alipayrsaPublicKey', 'mKmm4uL6ylgr0tcZwyyosbbbbbbbbbbbbbbbbbb', 'string', '支付宝RSA公钥', '2024-10-13 23:33:32', 1, 0, 98, 3);
INSERT INTO `cd_appconfig` VALUES (109, 'alipay', '支付宝小程序配置', 'decryptKey', 'yGT5/DYbvJKwuVhv6rDihA==', 'string', '支付宝小程序解密秘钥', '2024-10-14 04:51:06', 1, 0, 98, 5);
INSERT INTO `cd_appconfig` VALUES (115, 'upload', '上传配置', 'upload_hash_status', '0', 'boolean', '检测是否存在已上传图片', '2024-10-13 23:33:43', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (116, 'upload', '上传配置', 'filed_name_status', '0', 'boolean', '是否自动读取拼音作为字段名', '2024-10-13 23:33:43', 0, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (117, 'comment', '评论配置', 'api_comment', '1', 'boolean', '是否生成 API 详细注释', '2024-10-13 23:33:51', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (118, 'comment', '评论配置', 'file_comment', '1', 'boolean', '是否生成文件头部注释', '2024-10-13 23:33:51', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (119, 'comment', '评论配置', 'author', 'jikeshifu', 'string', '作者', '2024-10-13 23:33:51', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (120, 'comment', '评论配置', 'contact', '13885111171', 'string', '联系方式', '2024-10-13 23:33:51', 1, 0, 0, 0);
INSERT INTO `cd_appconfig` VALUES (121, 'toutiao', '抖音小程序配置', 'toutiao_appid', 'ttddf2ab4f42c0840301', 'string', '抖音小程序appid', '2024-10-14 04:39:23', 1, 0, 97, 1);
INSERT INTO `cd_appconfig` VALUES (122, 'toutiao', '抖音小程序配置', 'toutiao_appsecret', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 'string', '抖音小程序appsecret', '2024-10-14 04:40:34', 1, 0, 97, 2);
INSERT INTO `cd_appconfig` VALUES (124, 'wmjv1', '微门禁V1接口', 'wmjv1_appid', 'wmj_WXrReredttg', 'string', '微门禁V1硬件appid', '2024-10-14 06:10:26', 1, 0, 96, 1);
INSERT INTO `cd_appconfig` VALUES (125, 'wmjv1', '微门禁V1接口', 'wmjv1_appsecret', 'eeerrttt1Flw9JANiaNbBeeeeeeeeeeee', 'string', '微门禁V1硬件appsecret', '2024-10-14 06:11:28', 1, 0, 96, 2);
INSERT INTO `cd_appconfig` VALUES (126, 'wmjv2', '微门禁V2接口', 'wmjv2_appid', 'a74550b0b9b96691ffdd2bbbbbbb', 'string', '微门禁V2硬件appid', '2024-10-14 06:10:26', 1, 0, 95, 1);
INSERT INTO `cd_appconfig` VALUES (127, 'wmjv2', '微门禁V2接口', 'wmjv2_appsecret', '506a88835c697c6bd8cccccccccccccccc', 'string', '微门禁V2硬件appsecret', '2024-10-14 06:11:28', 1, 0, 95, 2);
INSERT INTO `cd_appconfig` VALUES (128, 'wmjsms', '短信接口', 'wmjsms_lable', '【微门禁】', 'string', '短信签名', '2024-10-14 23:32:23', 1, 0, 93, 3);
INSERT INTO `cd_appconfig` VALUES (129, 'wechart_template', '公众号发送消息配置', 'gzhtempleteid3', 'n1Zfe9bqxX5_9PW-ojah4McNsjzT_bbbb', 'string', '审核通过', '2024-10-13 23:33:26', 1, 0, 98, 3);
INSERT INTO `cd_appconfig` VALUES (130, 'siteconfig', '站点链接', 'siteurl', 'https://demo.wmj.com.cn', 'string', '站点链接', '2024-11-25 13:40:13', 1, 0, 0, 0);

-- ----------------------------
-- Table structure for cd_application
-- ----------------------------
DROP TABLE IF EXISTS `cd_application`;
CREATE TABLE `cd_application`  (
  `app_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `app_dir` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `status` tinyint NULL DEFAULT NULL,
  `app_type` tinyint NULL DEFAULT NULL,
  `login_table` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `login_fields` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `domain` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `pk` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '登录表主键',
  PRIMARY KEY (`app_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 182 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

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
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `data` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_config
-- ----------------------------
INSERT INTO `cd_config` VALUES ('adminpw', '');
INSERT INTO `cd_config` VALUES ('autodtkeylockid', '');
INSERT INTO `cd_config` VALUES ('copyright', '黔ICP备12003086号-3');
INSERT INTO `cd_config` VALUES ('default_themes', '');
INSERT INTO `cd_config` VALUES ('description', '微门禁演示平台');
INSERT INTO `cd_config` VALUES ('devicecid', '');
INSERT INTO `cd_config` VALUES ('domain', '');
INSERT INTO `cd_config` VALUES ('file_size', '100');
INSERT INTO `cd_config` VALUES ('file_type', 'gif,png,jpg,jpeg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt,mp4,flv');
INSERT INTO `cd_config` VALUES ('gzhappid', '');
INSERT INTO `cd_config` VALUES ('gzhappsecret', '');
INSERT INTO `cd_config` VALUES ('gzhminiappid', '');
INSERT INTO `cd_config` VALUES ('gzhtempleteid1', '');
INSERT INTO `cd_config` VALUES ('gzhtempleteid2', '');
INSERT INTO `cd_config` VALUES ('gzhtempleteid3', '');
INSERT INTO `cd_config` VALUES ('images_size', '10M');
INSERT INTO `cd_config` VALUES ('keyword', '');
INSERT INTO `cd_config` VALUES ('privacypolicy', '&lt;p&gt;&amp;lt;p&amp;gt;&amp;amp;lt;p&amp;amp;gt;&amp;amp;amp;lt;p&amp;amp;amp;gt;&amp;amp;amp;amp;lt;p&amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;隐私政策&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;贵州智云信通科技有限公司（以下简称&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;本公司&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;，产品“微门禁”）在此郑重承诺，尊重和保护您的个人隐私，在使用微门禁相关产品前，请务必仔细阅读并理解本政策，在同意的情况下使用相关产品或服务。您一旦访问本公司旗下产品微门禁公众号及小程序等应用平台，则表明您已同意本《隐私政策》的内容。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;一、个人信息定义&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;个人信息是指您的任何标识性信息，包括：姓名、性别、身份证件号码、地址、健康状况、定位信息、电话号码、工作单位等。通常情况下，您无须提供您的个人信息即可，访问本网站。但为了提高服务质量，本公司可能需要您提供一些个人信息，以使本公司更好地了解您的需求来为您服务，同时，本公司有权采取措施验证您提供的个人信息的真实性。如果您提供了有关他人的个人信息，则表明您已取得了他人的正式许可。本公司承诺，除非出于您自己的意愿，本公司不会将您的个人信息提供给本公司之外的任何第三方。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;二、个人信息的收集目的&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;微门禁需要您提供个人信息的目的是确保您有权开启所需要的门禁系统，门禁所属单位对您进行验证审核并开放使用权限，提供安全便捷的开门服务，我们会征求您的同意，以便根据您的请求向您提供服务或执行事务，包括：接收有关本公司的产品和服务的信息、注册参加活、购买或注册本公司的产品、客户满意度调查、法律强制性规定等。另外，为抗击新冠肺炎疫情需要，我们提供的健康登记系统，将采集您的健康相关信息，为抗击疫情提供基础信息技术服务。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;3、 个人信息的使用&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;您提供的个人信息将仅在本公司内部使用，使用您的个人信息只是为了更好地了解您的需要并为您提供更好的服务或执行事务，同时本公司可能会使用您的个人信息与您联系以便向您提供服务。为抗击新冠肺炎疫情需要，我们开发了健康登记系统平台，健康相关信息由相应申请使用单位掌握，请知悉。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;4、 个人信息的安全&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;本公司承诺，保护您个人信息的安全性，同时，本公司已采取现有的可靠的安全措施保护您的个人信息免于未经授权的访问、使用或泄露。这些安全措施包括向云服务提供商备份数据和对用户密码加密。尽管有这些安全措施，但本公司不保证这些信息的绝对安全。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;5、 未成年人保护&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;未满十八岁的未成年人可在父母或监护人指导使用我们的服务。我们建议未成年人的父母或监护人阅读本《隐私政策》，并建议未成年人在提交的个人信息之前寻求父母或监护人的同意和指导。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;6、 关于Cookie&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;当您访问微门禁微信公众号、微信小程序、支付宝小程序及Web管理站点时，本公司可能会以&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;										&lt;/p&gt;');
INSERT INTO `cd_config` VALUES ('serviceagreement', '&lt;p&gt;&amp;lt;p&amp;gt;&amp;amp;lt;p&amp;amp;gt;&amp;amp;amp;lt;p&amp;amp;amp;gt;&amp;amp;amp;amp;lt;p&amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;微门禁用户服务协议&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;一、服务条款&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;您在使用微门禁服务前，应当仔细阅读《微门禁用户服务协议》（以下简称&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;本协议&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;或&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;用户协议&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;）的全部内容，您在用户注册页面点击&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;同意以下协议并注册&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;quot;按钮后，即视为您已阅读、理解并同意本协议的全部内容。敬请注意，一旦您注册（登录）成功，本协议即在您与微门禁之间产生法律效力，成为对双方均具有约束力的法律文件。您应遵守以下协议的各项条款。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;二、目的&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;本协议是约定您使用微门禁提供的服务时，微门禁与您的权利、义务、服务条款等基本事宜为目的。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;三、遵守法律及法律效力&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;在您完成在线注册成功后，您就已与微门禁缔结了本协议，且本协议自您注册（登录）成功之日起产生法律效力。 您同意遵守《中华人民共和国保密法》、《计算机信息系统国际联网保密管理规定》、《中华人民共和国计算机信息系统安全保护条例》、《计算机信息网络国际联网安全保护管理办法》、《中华人民共和国计算机信息网络国际联网管理暂行规定》及其实施办法等相关法律法规的任何及所有的规定，并对您以任何方式使用服务的任何行为及其结果承担全部责任。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;在任何情况下，如果微门禁合理地认为您的任何行为，包括但不限于您的任何言论和其他违反或可能违反上述法律法规规定的任何行为，微门禁可在不经任何事先通知的情况下终止向您提供服务。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;微门禁有权利修改更新本协议的有关条款，一旦条款内容发生变动，微门禁将会在相关的页面提示修改内容。在更改此用户服务协议时，微门禁将说明更改内容的执行日期，变更理由等。且应同现行的使用服务协议一起，在更改内容发生效力前7日内向您公告。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;请仔细阅读用户协议更改内容，如因个人原因未能获知变更内容所带来的损害，微门禁一概不予负责。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;如果不同意微门禁对服务条款所做的修改，用户有权停止使用网络服务。如果用户继续使用网络服务，则视为用户接受变更后的用户协议。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;四、服务内容&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;微门禁服务的具体内容由微门禁根据实际情况提供，微门禁保留随时变更、中断或终止部分或全部微门禁服务的权利。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;五、您的义务&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;gt;用户在申请使用微门禁服务时，必须向微门禁提供准确的个人资料，如个人资料有任何变动，必须及时更新。&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;lt;/p&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;am										&lt;/p&gt;');
INSERT INTO `cd_config` VALUES ('site_logo', '/static/img/wmjlogo.png');
INSERT INTO `cd_config` VALUES ('site_title', '微门禁演示平台');
INSERT INTO `cd_config` VALUES ('sms_appid', '');
INSERT INTO `cd_config` VALUES ('sms_appsecret', '');
INSERT INTO `cd_config` VALUES ('sms_lable', '');
INSERT INTO `cd_config` VALUES ('wmjappid', 'wmj_bbbbbbbbbbbb');
INSERT INTO `cd_config` VALUES ('wmjappsecret', 'mkM2Qk1Flwbbbbbbbbbbbbbbbbb');
INSERT INTO `cd_config` VALUES ('wxpaycert_path', '');
INSERT INTO `cd_config` VALUES ('wxpaykey', '');
INSERT INTO `cd_config` VALUES ('wxpaykey_path', '');
INSERT INTO `cd_config` VALUES ('wxpaymchid', '');
INSERT INTO `cd_config` VALUES ('yjy_appid', 'a74550b0bbbbbbbbbbbbbbbbbbbbbbbbb');
INSERT INTO `cd_config` VALUES ('yjy_appsecret', '506a88835bbbbbbbbbbbbbbbbbbbbbbbbb');

-- ----------------------------
-- Table structure for cd_device_group
-- ----------------------------
DROP TABLE IF EXISTS `cd_device_group`;
CREATE TABLE `cd_device_group`  (
  `device_group_id` bigint NOT NULL AUTO_INCREMENT COMMENT '设备分组·',
  `device_group_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '名称',
  `created_at` bigint NULL DEFAULT NULL,
  `updated_at` bigint NULL DEFAULT 0,
  `deleted_at` datetime NULL DEFAULT NULL,
  `member_id` bigint NULL DEFAULT NULL,
  `type` int NULL DEFAULT 0,
  PRIMARY KEY (`device_group_id`) USING BTREE,
  INDEX `idx_member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 94993 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_device_group
-- ----------------------------

-- ----------------------------
-- Table structure for cd_doorstatus
-- ----------------------------
DROP TABLE IF EXISTS `cd_doorstatus`;
CREATE TABLE `cd_doorstatus`  (
  `doorstatus_id` int NOT NULL AUTO_INCREMENT,
  `doorstatus_sn` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `doorstatus_action` smallint NULL DEFAULT NULL COMMENT '状态',
  `user_id` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '管理用户',
  `doorstatus_time` int NULL DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`doorstatus_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 223 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_doorstatus
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_electricity
-- ----------------------------

-- ----------------------------
-- Table structure for cd_ext_health
-- ----------------------------
DROP TABLE IF EXISTS `cd_ext_health`;
CREATE TABLE `cd_ext_health`  (
  `health_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `mobile` char(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `first_address` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT '第一居住地址',
  `second_address` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT '第二居住地址',
  `job` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT '工作或学习单位',
  `yiqu` tinyint UNSIGNED NOT NULL DEFAULT 2 COMMENT '30日内是否来自疫区:1是,默认2否',
  `register_type` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '登记类型:默认1村居,2乡镇社区,3区县,4交通运输',
  `health` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '健康状况默认1健康,2异常,3其他',
  `manyou` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '' COMMENT '通行证截图',
  `ctime` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `utime` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  PRIMARY KEY (`health_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_ext_health
-- ----------------------------

-- ----------------------------
-- Table structure for cd_face
-- ----------------------------
DROP TABLE IF EXISTS `cd_face`;
CREATE TABLE `cd_face`  (
  `face_id` bigint NOT NULL AUTO_INCREMENT,
  `face_name` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '人脸备注',
  `face_images` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '人脸图片地址',
  `created_at` int NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint NULL DEFAULT NULL,
  `member_id` bigint NULL DEFAULT NULL,
  `sCertificateNumber` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sync_status` tinyint NULL DEFAULT 1,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sync_time` bigint NULL DEFAULT 0,
  `face_feature` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  PRIMARY KEY (`face_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19231 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_face
-- ----------------------------

-- ----------------------------
-- Table structure for cd_field
-- ----------------------------
DROP TABLE IF EXISTS `cd_field`;
CREATE TABLE `cd_field`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL COMMENT '模块ID',
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT '字段名称',
  `field` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `type` tinyint NOT NULL COMMENT '表单类型1输入框 2下拉框 3单选框 4多选框 5上传图片 6编辑器 7时间',
  `list_show` tinyint NULL DEFAULT NULL COMMENT '列表显示',
  `search_show` tinyint NULL DEFAULT NULL COMMENT '搜索显示',
  `search_type` tinyint NULL DEFAULT NULL COMMENT '1精确匹配 2模糊搜索',
  `config` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '下拉框或者单选框配置',
  `is_post` tinyint NULL DEFAULT NULL COMMENT '是否前台录入',
  `is_field` tinyint NULL DEFAULT NULL,
  `align` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '表格显示位置',
  `note` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '提示信息',
  `message` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '错误提示',
  `validate` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '验证方式',
  `rule` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL COMMENT '验证规则',
  `sortid` mediumint NULL DEFAULT 0 COMMENT '排序号',
  `sql` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '字段配置数据源sql',
  `tab_menu_name` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '所属选项卡名称',
  `default_value` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `datatype` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '字段数据类型',
  `length` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '字段长度',
  `indexdata` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '索引',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3588 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `cd_field` VALUES (3258, 797, '姓名', 'name', 1, 1, 1, 0, '', 1, 0, 'center', NULL, '', 'notEmpty', '', 3225, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3259, 797, '当前位置', 'position', 1, 1, 1, 0, '', 1, 0, 'center', NULL, '', 'notEmpty', '', 3229, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3260, 797, '经度', 'lat', 1, 0, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 3260, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3261, 797, '纬度', 'lng', 1, 0, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 3261, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3262, 797, '所属用户', 'user_id', 15, 1, 0, 0, '', 1, 1, 'center', NULL, '', '', '', 3262, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3293, 802, '姓名', 'name', 1, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3225, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3294, 802, '手机号', 'mobile', 1, 1, 1, 0, '', 1, 0, 'center', '', '手机号不正确', '', '/^1[1-9]\\\\d{9}$/', 3226, '', '', '', 'varchar', '11', '');
INSERT INTO `cd_field` VALUES (3295, 802, '家庭地址', 'first_address', 1, 1, 0, 1, '', 1, 0, 'center', '', '请输入居住地址', 'notEmpty', '', 3227, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3296, 802, '第二居住地址', 'second_address', 1, 1, 0, 1, '', 1, 0, 'center', '', '', '', '', 3228, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3297, 802, '当前位置', 'position', 1, 1, 0, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3229, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3298, 802, '工作或学习单位', 'job', 1, 1, 0, 1, '', 1, 0, 'center', '', '', '', '', 3230, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3299, 802, '是否来自疫区', 'yiqu', 3, 1, 1, 0, '是|1,否|2', 1, 1, 'center', '', '', '', '', 3231, '', '', '2', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3300, 802, '登记类型', 'register_type', 3, 1, 1, 0, '村居(物业)|1,乡镇社区|2,区县|3,交通运输|4,其他|5', 1, 1, 'center', '', '登记类型错误', '', '/^[0-9]*$/', 3232, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3301, 802, '健康状况', 'health', 3, 1, 1, 0, '健康|1|primary,发热|2|danger,发热咳嗽|3|danger,头晕乏力|4|warning,腹泻|5|warning,其他|6|warning', 1, 1, 'center', '', '', 'notEmpty', '/^[0-9]*$/', 3233, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3302, 802, '漫游地截图', 'manyou', 8, 1, 0, 0, '漫游地截图', 1, 0, 'center', NULL, '', '', '', 3235, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3303, 802, '通行证截图', 'txz', 8, 0, 0, 0, '通行证截图', 1, 0, 'center', '', '', '', '', 3258, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3304, 802, '登记时间', 'create_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3259, '', '', '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3305, 802, '经度', 'lat', 1, 0, 0, 0, '', 1, 0, 'center', NULL, '', '', '', 3260, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3306, 802, '纬度', 'lng', 1, 0, 0, 0, '', 1, 0, 'center', NULL, '', '', '', 3261, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3307, 802, '所属用户', 'user_id', 15, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3262, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3308, 797, 'openid', 'openid', 1, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3308, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3309, 802, 'openid', 'openid', 1, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3309, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3310, 803, '编号', 'lock_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3311, 803, '锁名称', 'lock_name', 1, 1, 1, 1, '', 1, 1, 'center', '', '', 'notEmpty', '', 3314, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3312, 803, '序列号', 'lock_sn', 1, 1, 1, 0, '', 1, 1, 'center', '', '', 'notEmpty,unique', '', 3344, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3314, 803, '用户ID', 'user_id', 15, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3313, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3315, 804, '编号', 'regpoint_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
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
INSERT INTO `cd_field` VALUES (3341, 802, '登记点ID', 'regpoint_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3341, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3342, 797, '登记点ID', 'regpoint_id', 20, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3342, '', NULL, '0', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3343, 802, '登记点', 'regpointname', 1, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3343, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3344, 803, '需绑手机', 'mobile_check', 23, 1, 0, 0, '是|1|primary,否|0|info', 1, 1, 'center', '', 'mobile_check', '', '', 3345, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3345, 803, '申请钥匙', 'applyauth', 23, 1, 0, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3346, '', '', '0', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3346, 803, '审核钥匙', 'applyauth_check', 23, 1, 0, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3347, '', '', '0', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3347, 803, '启用/禁用', 'status', 23, 1, 1, 0, '启用|1|success,禁用|0|danger', 1, 1, 'center', '', '', '', '', 3349, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3348, 803, '类型', 'lock_type', 2, 0, 0, 0, 'WiFi版|1|success,插卡版(2G)|2|primary,插卡版(4G)|3|primary,网线版|4|info', 1, 1, 'center', '', '', '', '', 3351, 'select locktype_id,locktype_name from cd_locktype', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3349, 803, '位置', 'location', 19, 0, 0, 0, '', 1, 1, 'center', '', '', 'notEmpty', '', 3354, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3351, 803, '添加时间', 'create_time', 12, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3453, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3352, 807, '编号', 'locktype_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3353, 807, '名称', 'locktype_name', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3353, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3354, 803, '二维码', 'lock_qrcode', 8, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3452, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3355, 41, '微门禁appid', 'wmjappid', 1, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3355, '', '门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3356, 41, '微门禁appsecret', 'wmjappsecret', 1, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3356, '', '门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3357, 803, '在线状态', 'online', 3, 1, 1, 0, '在线|1|primary,离线|0|warning', 1, 1, 'center', '', '', '', '', 3357, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3358, 41, '微门禁aeskey', 'wmjaeskey', 1, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3358, '', '门禁配置', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3359, 809, '编号', 'lockauth_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3360, 809, '锁ID', 'lock_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3360, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3361, 809, '会员ID', 'member_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3362, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3362, 809, '分享人ID', 'auth_member_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3430, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3363, 809, '有效期结束', 'auth_endtime', 7, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3447, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3364, 809, '分享权限', 'auth_shareability', 23, 1, 0, 0, '开启|1,关闭|0', 1, 1, 'center', '', '', '', '', 3448, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3365, 809, '备注', 'remark', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3366, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3366, 809, '创建时间', 'create_time', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3471, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3367, 809, '有效期起始', 'auth_starttime', 7, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3432, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3390, 812, '编号', 'locklog_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3391, 812, '会员ID', 'member_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3391, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3392, 812, '锁ID', 'lock_id', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3393, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3393, 812, '状态', 'status', 3, 1, 0, 0, '成功|1|primary,失败|0|danger', 1, 1, 'center', '', '', '', '', 3458, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3394, 812, '类型', 'type', 3, 1, 0, 0, '扫码开门|1|primary,点击开门|2|info,后台开门|3|success', 1, 1, 'center', '', '', '', '', 3459, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3395, 812, '开门时间', 'create_time', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3586, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3396, 812, '管理员ID', 'user_id', 15, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3392, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3397, 813, '编号', 'lock_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3398, 813, '用户ID', 'user_id', 15, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3313, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3399, 813, '锁名称', 'lock_name', 1, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty', '', 3314, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3400, 813, '序列号', 'lock_sn', 1, 1, 1, 0, '', 1, 0, 'center', '', '', 'notEmpty,unique', '', 3344, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3401, 813, '绑定手机', 'mobile_check', 23, 1, 1, 0, '是|1|primary,否|0|info', 1, 0, 'center', '', 'mobile_check', '', '', 3345, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3402, 813, '申请钥匙', 'applyauth', 23, 1, 1, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3346, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3403, 813, '审核钥匙', 'applyauth_check', 23, 1, 1, 0, '开启|1,关闭|0', 1, 0, 'center', '', '', '', '', 3347, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3404, 813, '开关', 'status', 23, 1, 1, 0, '启用|1|success,禁用|0|danger', 1, 0, 'center', '', '', '', '', 3349, '', '', '', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3405, 813, '类型', 'lock_type', 2, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3351, 'select locktype_id,locktype_name from cd_locktype', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3406, 813, '位置', 'location', 19, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3354, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3407, 813, '添加时间', 'create_time', 12, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3357, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3408, 813, '二维码', 'lock_qrcode', 8, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3426, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3409, 813, '状态', 'online', 3, 1, 1, 0, '在线|1|primary,离线|0|warning', 1, 0, 'center', '', '', '', '', 3454, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3410, 814, '编号', 'lockauth_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3411, 814, '锁ID', 'lock_id', 20, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3360, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3412, 814, '会员ID', 'member_id', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3361, '', '', '', 'varchar', '250', '');
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
INSERT INTO `cd_field` VALUES (3430, 809, '可分享数', 'auth_sharelimit', 20, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3431, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3431, 809, '可开次数', 'auth_openlimit', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3473, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3432, 809, '是否管理员', 'auth_isadmin', 3, 0, 0, 0, '是|1|success,否|0|info', 1, 0, 'center', '', '', '', '', 3495, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3433, 812, '备注', 'remark', 1, 1, 0, 0, '', 1, 0, 'center', '', '', '', '', 3456, '', '', '', 'varchar', '250', '');
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
INSERT INTO `cd_field` VALUES (3447, 809, '钥匙状态', 'auth_status', 23, 1, 0, 0, '启用|1|primary,禁用|0|warning', 1, 0, 'center', '', '', '', '', 3451, '', '', '', 'tinyint', '4', '');
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
INSERT INTO `cd_field` VALUES (3458, 812, '手机号', 'mobile', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3457, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3459, 812, '锁名称', 'lock_name', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3394, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3460, 818, '编号', 'locktimes_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
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
INSERT INTO `cd_field` VALUES (3472, 814, '可开时段', 'auth_opentimes', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3429, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3473, 809, '领取标志', 'auth_tmp', 3, 0, 0, 0, '已领取|1|success,未领取|0|warning', 1, 1, 'center', '', '', '', '', 3517, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3474, 814, '领取标志', 'auth_tmp', 3, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3474, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3475, 819, '编号', 'locktimes_id', 1, 1, 0, NULL, NULL, 0, 0, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
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
INSERT INTO `cd_field` VALUES (3488, 803, '会员id', 'member_id', 20, 0, 0, 0, '', 1, 0, 'center', '', '', '', '', 3312, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3489, 794, '支付宝用户id', 'ali_user_id', 1, NULL, 1, 0, '', 1, 1, NULL, NULL, '', '', '', 3217, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3490, 793, '支付宝id', 'ali_user_id', 1, 1, 1, 0, '', 1, 0, 'center', '', '', '', '', 3217, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3491, 793, '会员类型', 'member_type', 3, 1, 1, 0, '微信用户|1|primary,支付宝用户|2|success', 1, 1, 'center', '', '', '', '', 3491, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3492, 794, '会员类型', 'member_type', 3, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3492, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3493, 809, '锁名称', 'lock_name', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3361, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3494, 809, '手机号', 'mobile', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3367, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3495, 809, '头像', 'headimgurl', 8, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3363, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3496, 809, '昵称', 'nickname', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3364, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3497, 803, '点击开门广告', 'hitshowminiad', 23, 0, 0, 0, '开启|0,关闭|1', 1, 1, 'center', '', '', '', '', 3498, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3498, 803, '扫码开门广告', 'qrshowminiad', 23, 0, 0, 0, '开启|0,关闭|1', 1, 1, 'center', '', '', '', '', 3543, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3499, 41, '隐私政策', 'privacypolicy', 16, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3499, '', '隐私政策', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3500, 41, '服务协议', 'serviceagreement', 16, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3500, '', '服务协议', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3514, 816, '隐私政策', 'privacypolicy', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3514, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3515, 816, '服务协议', 'serviceagreement', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3515, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3516, 794, '同意政策和协议', 'member_ps', 3, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3516, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3517, 809, '已开次数', 'auth_openused', 20, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3493, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3518, 824, '编号', 'lockcard_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3519, 824, '锁ID', 'lock_id', 14, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3519, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3520, 824, '管理员ID', 'user_id', 15, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3520, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3521, 824, '卡序列号', 'lockcard_sn', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3521, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3522, 824, '过期时间', 'lockcard_endtime', 7, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3522, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3523, 824, '持有人', 'lockcard_username', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3523, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3524, 824, '备注', 'lockcard_remark', 1, 1, 1, 1, '', 1, 1, 'center', '', '', '', '', 3525, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3525, 824, '发卡时间', 'lockcard_createtime', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3526, '', '', '', 'int', '11', '');
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
INSERT INTO `cd_field` VALUES (3544, 826, '编号', 'umember_id', 1, 1, 1, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3545, 826, '会员ID', 'member_id', 20, 2, 0, 0, '', 1, 0, 'center', '', '', '', '', 3550, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3546, 826, '管理员ID', 'user_id', 15, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3549, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3547, 826, '状态', 'status', 3, 1, 0, 0, '正常|1|success,黑名单|0|danger', 1, 1, 'center', '', '', '', '', 3548, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3548, 826, '注册时间', 'ucreate_time', 12, 1, 0, 0, '', 0, 1, 'center', '', '', '', '', 3551, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3549, 826, '呢称', 'nickname', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3546, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3550, 826, '头像', 'headimgurl', 8, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3545, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3551, 826, '手机号', 'mobile', 1, 1, 1, 1, '', 0, 0, 'center', '', '', '', '', 3547, '', '', '', 'varchar', '250', '');
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
INSERT INTO `cd_field` VALUES (3584, 826, '姓名', 'realname', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3584, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3585, 826, '备注', 'remark', 1, 1, 1, 1, '', 1, 0, 'center', '', '', '', '', 3585, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3586, 812, '姓名', 'realname', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3433, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3587, 826, '授权锁', 'authlocks', 4, 2, 0, 0, '', 1, 1, 'center', '', '', '', '', 3587, 'select lock_id,lock_name from cd_lock where user_id=843', '', '', 'varchar', '250', '');

-- ----------------------------
-- Table structure for cd_file
-- ----------------------------
DROP TABLE IF EXISTS `cd_file`;
CREATE TABLE `cd_file`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '图片路径',
  `hash` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '文件hash值',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_file
-- ----------------------------

-- ----------------------------
-- Table structure for cd_finger
-- ----------------------------
DROP TABLE IF EXISTS `cd_finger`;
CREATE TABLE `cd_finger`  (
  `finger_id` bigint NOT NULL AUTO_INCREMENT,
  `fp_id` int NULL DEFAULT NULL COMMENT '指纹id',
  `finger_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '指纹名称',
  `created_at` bigint NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`finger_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 136 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_finger
-- ----------------------------

-- ----------------------------
-- Table structure for cd_group
-- ----------------------------
DROP TABLE IF EXISTS `cd_group`;
CREATE TABLE `cd_group`  (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(36) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '分组名称',
  `status` tinyint NULL DEFAULT NULL COMMENT '状态 10正常 0禁用',
  `role` tinyint NULL DEFAULT NULL COMMENT '角色类别 1超级管理员 2普通管理员',
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_group
-- ----------------------------
INSERT INTO `cd_group` VALUES (1, '超级管理员', 10, 1);
INSERT INTO `cd_group` VALUES (3, '客服人员', 10, 2);
INSERT INTO `cd_group` VALUES (7, '用户管理员', 10, 2);
INSERT INTO `cd_group` VALUES (8, '开发管理员', 10, 1);

-- ----------------------------
-- Table structure for cd_gzh_member
-- ----------------------------
DROP TABLE IF EXISTS `cd_gzh_member`;
CREATE TABLE `cd_gzh_member`  (
  `gzh_member_id` int NOT NULL AUTO_INCREMENT,
  `openid` char(28) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `unionid` char(28) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`gzh_member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_gzh_member
-- ----------------------------

-- ----------------------------
-- Table structure for cd_health
-- ----------------------------
DROP TABLE IF EXISTS `cd_health`;
CREATE TABLE `cd_health`  (
  `health_id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `first_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '居住地址',
  `second_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '第二居住地址',
  `job` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '工作或学习单位',
  `yiqu` smallint NULL DEFAULT NULL COMMENT '是否来自疫区',
  `register_type` smallint NULL DEFAULT NULL COMMENT '登记类型',
  `health` smallint NULL DEFAULT NULL COMMENT '健康状况',
  `manyou` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '漫游地截图',
  `txz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '证明图片',
  `ctime` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `position` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '定位地址',
  `lat` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '经度',
  `lng` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '纬度',
  `user_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '所属用户',
  `openid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'openid',
  `regpoint_id` int NULL DEFAULT NULL COMMENT '登记点ID',
  PRIMARY KEY (`health_id`) USING BTREE,
  INDEX `idx_mobile`(`mobile`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_health
-- ----------------------------

-- ----------------------------
-- Table structure for cd_linkspeaker
-- ----------------------------
DROP TABLE IF EXISTS `cd_linkspeaker`;
CREATE TABLE `cd_linkspeaker`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `linkspeaker_sn` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `linkspeaker_tts` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  `linkspeaker_volume` int NULL DEFAULT NULL,
  `lock_id` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `linkspeaker_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_linkspeaker
-- ----------------------------

-- ----------------------------
-- Table structure for cd_linkswitch
-- ----------------------------
DROP TABLE IF EXISTS `cd_linkswitch`;
CREATE TABLE `cd_linkswitch`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `linkswitch_sn` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `lock_id` int NULL DEFAULT NULL,
  `linkswitch_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `open_action` int NULL DEFAULT 0,
  `close_delay` int NULL DEFAULT 0,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_linkswitch
-- ----------------------------

-- ----------------------------
-- Table structure for cd_lock
-- ----------------------------
DROP TABLE IF EXISTS `cd_lock`;
CREATE TABLE `cd_lock`  (
  `lock_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `lock_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '锁名称',
  `lock_sn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '序列号',
  `user_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户ID',
  `mobile_check` tinyint NULL DEFAULT NULL COMMENT '需绑手机',
  `applyauth` tinyint NULL DEFAULT NULL COMMENT '领取钥匙',
  `applyauth_check` tinyint NULL DEFAULT NULL COMMENT '审核钥匙',
  `status` tinyint NULL DEFAULT NULL COMMENT '启用/禁用',
  `lock_type` smallint NULL DEFAULT NULL COMMENT '类型',
  `location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '位置',
  `create_time` int NULL DEFAULT NULL COMMENT '添加时间',
  `lock_qrcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '二维码',
  `online` smallint NULL DEFAULT NULL COMMENT '在线状态',
  `member_id` int NULL DEFAULT NULL COMMENT '会员id',
  `successimg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '成功提示图片',
  `successadimg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '成功广告',
  `location_check` int NULL DEFAULT NULL COMMENT '开门距离(米)',
  `hitshowminiad` tinyint(1) NULL DEFAULT NULL COMMENT '点击开门广告',
  `qrshowminiad` tinyint(1) NULL DEFAULT NULL COMMENT '扫码开门广告',
  `volume` int NULL DEFAULT NULL COMMENT '音量',
  `openttscontent` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '语音内容',
  `addcardmode` int NULL DEFAULT 2 COMMENT '进出发卡模式',
  `openadurl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '开门成功外链',
  `adnum` smallint NULL DEFAULT NULL COMMENT '成功弹层方式',
  `openbtn` tinyint NULL DEFAULT 1 COMMENT '开门按钮',
  `opsucnt` tinyint NULL DEFAULT NULL COMMENT '开门通知',
  `device_cid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '设备cid',
  `admin_pwd` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '激活的管理密码',
  `hw_ver` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '硬件版本',
  `sw_ver` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '软件版本',
  `wifi_rssi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'WiFi信号强度',
  `on_line_time` int NULL DEFAULT NULL COMMENT '在线时间',
  `model_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '型号',
  `hardware_version` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '硬件版本',
  `firmware_version` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '固件版本',
  `iccid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'ICCID',
  `imei` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'IMEI',
  `batterypower` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '电池电量',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `rssi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '信号强度',
  `xcx_sound` tinyint(1) NULL DEFAULT 1 COMMENT '小程序声音',
  `switch_state` tinyint NULL DEFAULT 0 COMMENT '开关状态',
  PRIMARY KEY (`lock_id`) USING BTREE,
  UNIQUE INDEX `lock_id`(`lock_id`) USING BTREE,
  INDEX `idx_lock_name`(`lock_name`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE,
  CONSTRAINT `fk_lock_member` FOREIGN KEY (`member_id`) REFERENCES `cd_member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_lock
-- ----------------------------

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
  `aremark` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `auth_starttime` int NULL DEFAULT NULL COMMENT '有效期起始时间',
  `auth_sharelimit` int NULL DEFAULT NULL COMMENT '可分享钥匙数',
  `auth_openlimit` int NULL DEFAULT 0 COMMENT '可开次数',
  `auth_isadmin` smallint NULL DEFAULT 0 COMMENT '是否管理员',
  `auth_status` smallint NULL DEFAULT 0 COMMENT '审核状态',
  `user_id` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `arealname` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `auth_opentimes` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '可开时段',
  `auth_tmp` smallint NULL DEFAULT NULL COMMENT '领取标志',
  `auth_openused` int NULL DEFAULT NULL COMMENT '已开次数',
  `device_group_id` bigint NULL DEFAULT 0 COMMENT '分组id默认未分组',
  `deleted_at` datetime NULL DEFAULT NULL,
  `updated_at` bigint NULL DEFAULT NULL,
  `auth_sort` int NULL DEFAULT 0 COMMENT '钥匙排序',
  PRIMARY KEY (`lockauth_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19876 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_lockauth
-- ----------------------------

-- ----------------------------
-- Table structure for cd_lockcard
-- ----------------------------
DROP TABLE IF EXISTS `cd_lockcard`;
CREATE TABLE `cd_lockcard`  (
  `lockcard_id` int NOT NULL AUTO_INCREMENT,
  `lock_id` int NULL DEFAULT NULL COMMENT '锁ID',
  `user_id` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `lockcard_sn` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '卡序列号',
  `lockcard_endtime` int NULL DEFAULT NULL COMMENT '过期时间',
  `lockcard_username` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '持有人',
  `lockcard_remark` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '备注',
  `lockcard_createtime` int NULL DEFAULT NULL COMMENT '发卡时间',
  `lockauth_id` int NULL DEFAULT NULL COMMENT '钥匙ID',
  `batchstatus` smallint NULL DEFAULT NULL COMMENT '发卡状态',
  `deleted_at` datetime NULL DEFAULT NULL,
  `sync_status` tinyint(1) NULL DEFAULT 1,
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `sync_time` bigint NULL DEFAULT 0,
  PRIMARY KEY (`lockcard_id`) USING BTREE,
  INDEX `lkcdsn`(`lockcard_sn`) USING BTREE,
  INDEX `lockcard_sn`(`lockcard_sn`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 278 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_lockcard
-- ----------------------------

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
  `lremark` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '备注',
  `cardsn` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT '',
  `user_name` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '操作人',
  `mobile_bak` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `cpurl` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  PRIMARY KEY (`locklog_id`) USING BTREE,
  UNIQUE INDEX `locklog_id`(`locklog_id`) USING BTREE,
  INDEX `idx_cdsn`(`cardsn`) USING BTREE,
  INDEX `idx_lock_id`(`lock_id`) USING BTREE,
  INDEX `idx_member_id`(`member_id`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE,
  INDEX `creattime`(`create_time`) USING BTREE,
  INDEX `idx_member_lock`(`member_id`, `lock_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 247408 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_locklog
-- ----------------------------

-- ----------------------------
-- Table structure for cd_locktimes
-- ----------------------------
DROP TABLE IF EXISTS `cd_locktimes`;
CREATE TABLE `cd_locktimes`  (
  `locktimes_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `lock_id` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '锁ID',
  `startweek` smallint NULL DEFAULT NULL COMMENT '周开始',
  `starthour` smallint NULL DEFAULT NULL COMMENT '小时开始',
  `startminute` smallint NULL DEFAULT NULL COMMENT '分钟开始',
  `endweek` smallint NULL DEFAULT NULL COMMENT '周结束',
  `endhour` smallint NULL DEFAULT NULL COMMENT '小时结束',
  `endminute` smallint NULL DEFAULT NULL COMMENT '分钟结束',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `locktimesname` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '时段名称',
  `type` smallint NULL DEFAULT NULL COMMENT '类型',
  PRIMARY KEY (`locktimes_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_locktimes
-- ----------------------------

-- ----------------------------
-- Table structure for cd_locktype
-- ----------------------------
DROP TABLE IF EXISTS `cd_locktype`;
CREATE TABLE `cd_locktype`  (
  `locktype_id` int NOT NULL AUTO_INCREMENT,
  `locktype_name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`locktype_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_locktype
-- ----------------------------
INSERT INTO `cd_locktype` VALUES (1, 'W761');
INSERT INTO `cd_locktype` VALUES (2, 'W762');
INSERT INTO `cd_locktype` VALUES (3, 'W763');
INSERT INTO `cd_locktype` VALUES (4, 'W764');
INSERT INTO `cd_locktype` VALUES (5, 'W765');
INSERT INTO `cd_locktype` VALUES (6, 'W766');
INSERT INTO `cd_locktype` VALUES (7, 'W77');

-- ----------------------------
-- Table structure for cd_log
-- ----------------------------
DROP TABLE IF EXISTS `cd_log`;
CREATE TABLE `cd_log`  (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL COMMENT '用户ID',
  `username` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `event` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `ip` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `time` int NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 198 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_log
-- ----------------------------
INSERT INTO `cd_log` VALUES (198, 1, 'admin', '用户登录', '117.188.119.222', 1745720459);
INSERT INTO `cd_log` VALUES (199, 1, 'admin', '用户登录', '117.188.119.222', 1745721527);

-- ----------------------------
-- Table structure for cd_log_ts
-- ----------------------------
DROP TABLE IF EXISTS `cd_log_ts`;
CREATE TABLE `cd_log_ts`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `info` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_log_ts
-- ----------------------------

-- ----------------------------
-- Table structure for cd_member
-- ----------------------------
DROP TABLE IF EXISTS `cd_member`;
CREATE TABLE `cd_member`  (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '呢称',
  `headimgurl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '头像',
  `openid` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'openid',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '手机号',
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '密码',
  `create_time` int NULL DEFAULT NULL COMMENT '注册时间',
  `sex` smallint NULL DEFAULT 0 COMMENT '性别',
  `status` tinyint NULL DEFAULT NULL COMMENT '状态',
  `user_id` int NULL DEFAULT NULL COMMENT '所属用户',
  `ali_user_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付宝用户id',
  `member_type` smallint NULL DEFAULT NULL COMMENT '会员类型',
  `member_ps` smallint NULL DEFAULT NULL COMMENT '同意政策和协议',
  `unionid` char(28) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT 'unionid',
  `realname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '备注',
  `sCertificateNumber` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '人脸faceid',
  `level` tinyint NULL DEFAULT 0 COMMENT '级别',
  `wx_model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '设备型号',
  `wx_version` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '微信版本',
  `wx_platform` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '操作系统及版本',
  `wx_system` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '客户端平台',
  `SDKVersion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '客户端基础库版本',
  `bluetoothEnabled` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '蓝牙的系统开关',
  `locationEnabled` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '地理位置的系统开关',
  `tt_user_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '头条用户id',
  PRIMARY KEY (`member_id`) USING BTREE,
  UNIQUE INDEX `member_id`(`member_id`) USING BTREE,
  UNIQUE INDEX `openid`(`openid`) USING BTREE,
  INDEX `unionid`(`unionid`) USING BTREE,
  INDEX `mobile`(`mobile`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_member
-- ----------------------------

-- ----------------------------
-- Table structure for cd_menu
-- ----------------------------
DROP TABLE IF EXISTS `cd_menu`;
CREATE TABLE `cd_menu`  (
  `menu_id` int NOT NULL AUTO_INCREMENT,
  `pid` mediumint NULL DEFAULT 0 COMMENT '父级id',
  `controller_name` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '模块名称',
  `title` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '模块标题',
  `pk_id` varchar(36) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '主键名',
  `table_name` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '模块数据库表',
  `is_create` tinyint NULL DEFAULT NULL COMMENT '是否允许生成模块',
  `status` tinyint NULL DEFAULT NULL COMMENT '0隐藏 10显示',
  `sortid` mediumint NULL DEFAULT 0 COMMENT '排序号',
  `table_status` tinyint NULL DEFAULT NULL COMMENT '是否生成数据库表',
  `is_url` tinyint NULL DEFAULT NULL COMMENT '是否只是url链接',
  `url` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `menu_icon` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'icon字体图标',
  `tab_menu` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'tab选项卡菜单配置',
  `app_id` int NULL DEFAULT NULL COMMENT '所属模块',
  `is_submit` tinyint NULL DEFAULT NULL COMMENT '是否允许投稿',
  PRIMARY KEY (`menu_id`) USING BTREE,
  INDEX `controller_name`(`controller_name`) USING BTREE,
  INDEX `module_id`(`app_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 832 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_menu
-- ----------------------------
INSERT INTO `cd_menu` VALUES (12, 0, 'Sys', '系统管理', '', '', 0, 1, 793, 0, 0, '', 'fa fa-gears', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (17, 12, '', '后台首页', '', '', 0, 0, 2, 0, 1, '/admin/Index/main.html', 'fa fa-home', '', 1, 0);
INSERT INTO `cd_menu` VALUES (18, 12, 'User', '管理员', 'user_id', 'user', 1, 1, 4, 1, 0, '', 'fa fa-user-secret', '', 1, 0);
INSERT INTO `cd_menu` VALUES (19, 12, 'Group', '管理员组', 'group_id', 'group', 1, 1, 5, 1, 0, '', 'fa fa-user', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (21, 12, '', '菜单管理', '', '', 0, 0, 3, 0, 1, '/admin/Menu/index?app_id=1', '', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (41, 12, 'Config', '系统配置', '', '', 1, 1, 7, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|门禁配置|隐私政策|服务协议', 1, 0);
INSERT INTO `cd_menu` VALUES (52, 12, 'Log', '登录日志', 'log_id', 'log', 1, 1, 6, 1, 0, '', 'glyphicon glyphicon-log-in', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (80, 12, 'AppConfig', '应用配置', '', '', 0, 1, 1, 0, 0, '', 'glyphicon glyphicon-cog', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (524, 12, '', '修改密码', '', '', 0, 1, 8, 0, NULL, '/admin/Base/password', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (525, 12, '', '数据备份', '', '', 0, 0, 9, 0, NULL, '/admin/Backup/index', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (793, 0, 'Member', '会员管理', 'member_id', 'member', 1, 1, 793, 1, NULL, '', 'fa fa-users', '', 1, 0);
INSERT INTO `cd_menu` VALUES (794, 0, 'Member', '会员管理', 'member_id', 'member', 1, 1, 797, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (797, 0, 'Health', '健康登记', 'health_id', 'health', 1, NULL, 798, 1, NULL, NULL, NULL, NULL, 179, NULL);
INSERT INTO `cd_menu` VALUES (802, 817, 'Health', '健康登记', 'health_id', 'health', 1, 1, 798, 0, NULL, '', 'fa fa-file-text', '', 1, 0);
INSERT INTO `cd_menu` VALUES (803, 808, 'Lock', '设备列表', 'lock_id', 'lock', 1, 1, 803, 1, NULL, '', 'fa fa-list', '', 1, 0);
INSERT INTO `cd_menu` VALUES (804, 817, 'Regpoint', '登记点管理', 'regpoint_id', 'regpoint', 1, 1, 804, 1, NULL, '', 'fa fa-dot-circle-o', '', 1, 0);
INSERT INTO `cd_menu` VALUES (805, 0, 'Regpoint', '登记点管理', 'regpoint_id', 'regpoint', 1, 1, 804, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (806, 0, 'User', '用户管理', 'user_id', 'user', 1, 1, 4, 0, 0, '', 'fa fa-user-secret', '', 179, 0);
INSERT INTO `cd_menu` VALUES (807, 808, 'LockType', '设备类型', 'locktype_id', 'locktype', 1, 1, 812, 1, NULL, '', 'fa fa-wrench', '', 1, 0);
INSERT INTO `cd_menu` VALUES (808, 0, '', '设备管理', '', '', 0, 1, 809, 1, NULL, '', 'fa fa-unlock', '', 1, 0);
INSERT INTO `cd_menu` VALUES (809, 808, 'LockAuth', '权限管理', 'lockauth_id', 'lockauth', 1, 1, 807, 1, NULL, '', 'fa fa-key', '', 1, 0);
INSERT INTO `cd_menu` VALUES (812, 808, 'LockLog', '操作记录', 'locklog_id', 'locklog', 1, 1, 809, 1, NULL, '', 'fa fa-list-alt', '', 1, 0);
INSERT INTO `cd_menu` VALUES (813, 0, 'Lock', '设备列表', 'lock_id', 'lock', 1, 1, 803, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (814, 0, 'LockAuth', '权限管理', 'lockauth_id', 'lockauth', 1, 1, 807, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (815, 0, 'LockLog', '日志管理', 'locklog_id', 'locklog', 1, 1, 817, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (816, 0, 'Config', '系统配置', '', '', 1, 1, 7, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|微门禁配置', 179, 0);
INSERT INTO `cd_menu` VALUES (817, 0, '', '健康登记', '', '', 0, 0, 818, 0, NULL, '', 'fa fa-heartbeat', '', 1, 0);
INSERT INTO `cd_menu` VALUES (818, 808, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 818, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (819, 0, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 824, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (824, 808, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 824, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (825, 0, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 826, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (826, 0, 'Umember', '用户管理', 'umember_id', 'umember', 1, 1, 808, 1, NULL, '', 'fa fa-user', '', 1, 0);
INSERT INTO `cd_menu` VALUES (827, 0, 'Wservice', '服务管理', 'wservice_id', 'wservice', 1, 1, 827, 1, NULL, '', 'fa fa-share-alt', '', 1, 0);

-- ----------------------------
-- Table structure for cd_on_line_record
-- ----------------------------
DROP TABLE IF EXISTS `cd_on_line_record`;
CREATE TABLE `cd_on_line_record`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `on_line_time` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `cmd` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4838 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_on_line_record
-- ----------------------------

-- ----------------------------
-- Table structure for cd_order
-- ----------------------------
DROP TABLE IF EXISTS `cd_order`;
CREATE TABLE `cd_order`  (
  `order_id` bigint NOT NULL AUTO_INCREMENT,
  `order_sn` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `pay_time` datetime NULL DEFAULT NULL,
  `pay_status` int NULL DEFAULT 0,
  `pay_price` bigint NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `member_id` bigint NULL DEFAULT NULL,
  `sim_sn` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `order_status` tinyint NULL DEFAULT 0 COMMENT '0未续费1续费',
  `remark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_order
-- ----------------------------

-- ----------------------------
-- Table structure for cd_power
-- ----------------------------
DROP TABLE IF EXISTS `cd_power`;
CREATE TABLE `cd_power`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `batterypower` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  `created_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_power
-- ----------------------------

-- ----------------------------
-- Table structure for cd_pwd
-- ----------------------------
DROP TABLE IF EXISTS `cd_pwd`;
CREATE TABLE `cd_pwd`  (
  `pwd_id` bigint NOT NULL AUTO_INCREMENT,
  `pwd` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '密码',
  `pwd_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '密码名称',
  `created_at` int NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint NULL DEFAULT NULL,
  PRIMARY KEY (`pwd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_pwd
-- ----------------------------

-- ----------------------------
-- Table structure for cd_regpoint
-- ----------------------------
DROP TABLE IF EXISTS `cd_regpoint`;
CREATE TABLE `cd_regpoint`  (
  `regpoint_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `member_id` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '会员ID',
  `user_id` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '用户ID',
  `regpointname` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '名称',
  `regpointurl` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '注册点url',
  `create_time` int NULL DEFAULT NULL COMMENT '创建时间',
  `regpointqrcode` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '登记点二维码',
  `lock_id` int NULL DEFAULT NULL COMMENT '门ID',
  PRIMARY KEY (`regpoint_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_regpoint
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_switch_daily_report
-- ----------------------------

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
  `urealname` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `authlocks` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '授权锁',
  `uremark` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`umember_id`) USING BTREE,
  INDEX `idx_member_id_user_id`(`member_id`, `user_id`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5117 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_umember
-- ----------------------------

-- ----------------------------
-- Table structure for cd_user
-- ----------------------------
DROP TABLE IF EXISTS `cd_user`;
CREATE TABLE `cd_user`  (
  `user_id` int NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `user` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '登录用户名',
  `pwd` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '登录密码',
  `group_id` tinyint NULL DEFAULT NULL COMMENT '所属分组ID',
  `type` tinyint NULL DEFAULT NULL COMMENT '账户类型 1超级管理员 2普通管理员',
  `note` varchar(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '备注',
  `status` tinyint NULL DEFAULT NULL COMMENT '10正常 0禁用',
  `create_time` int NULL DEFAULT NULL COMMENT '添加时间',
  `member_id` int NULL DEFAULT NULL COMMENT '会员ID',
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 125 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cd_user
-- ----------------------------
INSERT INTO `cd_user` VALUES (1, '管理员', 'admin', '305afeb46a6aa7bca43880dcb29d634d', 1, 1, '超级管理员', 1, 1548558919, 1);

-- ----------------------------
-- Table structure for cd_wservice
-- ----------------------------
DROP TABLE IF EXISTS `cd_wservice`;
CREATE TABLE `cd_wservice`  (
  `wservice_id` int NOT NULL AUTO_INCREMENT,
  `wservice_type` smallint NULL DEFAULT NULL COMMENT '类型',
  `wservice_name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '名称',
  `wservice_appid` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'appid',
  `wservice_url` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT 'url',
  `wservice_icon` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL COMMENT '图标',
  `wservice_sort` int NULL DEFAULT NULL COMMENT '排序',
  `wservice_status` tinyint NULL DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`wservice_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_wservice
-- ----------------------------
INSERT INTO `cd_wservice` VALUES (1, 1, '门锁配网', '', '/pages/wifi/wifi', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c19ada76a05.png', 5, 1);
INSERT INTO `cd_wservice` VALUES (2, 1, '空开配网', '', '/pages/bluetooth/bluetooth', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c19a47e2c1c.png', 4, 1);
INSERT INTO `cd_wservice` VALUES (3, 3, '使用帮助', '', 'https://doc.wmj.com.cn/1/page/39', 'https://wxapp.wmj.com.cn/uploads/admin/202101/600323a441bb6.png', 1, 0);
INSERT INTO `cd_wservice` VALUES (4, 1, '喇叭配网', '', '/pages/bluetooth/bluetooth', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c199be21f9c.png', 2, 1);
INSERT INTO `cd_wservice` VALUES (5, 1, '流量续费', '', '/pages/sim/sim', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c199ff0017e.png', 14, 1);
INSERT INTO `cd_wservice` VALUES (6, 1, '开门演示', '', '/pages/open/open?user_id=1&amp;lock_id=2&amp;isscan=1', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c198ed5124f.png', 16, 1);
INSERT INTO `cd_wservice` VALUES (7, 1, '添加设备', '', '/pages/addEquipment/addEquipment', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c19b692174b.png', 0, 1);
INSERT INTO `cd_wservice` VALUES (8, 1, '热点配网', '', '/pages/hotspot/hotspot', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c19c311419c.png', 15, 1);
INSERT INTO `cd_wservice` VALUES (9, 3, '门禁配网', '', 'https://doc.wmj.com.cn/1/page/181', 'https://wxapp.wmj.com.cn/uploads/admin/202402/65c1a5a7908d8.png', 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
