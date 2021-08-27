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

 Date: 27/08/2021 09:59:34
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
) ENGINE = MyISAM AUTO_INCREMENT = 2798 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `cd_access` VALUES (2792, '/admin/Health/add', 7);
INSERT INTO `cd_access` VALUES (2793, '/admin/Regpoint', 7);
INSERT INTO `cd_access` VALUES (2794, '/admin/Regpoint/index', 7);
INSERT INTO `cd_access` VALUES (2795, '/admin/Regpoint/updateExt', 7);
INSERT INTO `cd_access` VALUES (2796, '/admin/Regpoint/delete', 7);
INSERT INTO `cd_access` VALUES (2797, '/admin/Regpoint/view', 7);
INSERT INTO `cd_access` VALUES (2791, '/admin/Health/update', 7);
INSERT INTO `cd_access` VALUES (2790, '/admin/Health/delete', 7);
INSERT INTO `cd_access` VALUES (2789, '/admin/Health/view', 7);
INSERT INTO `cd_access` VALUES (2788, '/admin/Health/dumpData', 7);
INSERT INTO `cd_access` VALUES (2787, '/admin/Health/index', 7);
INSERT INTO `cd_access` VALUES (2786, '/admin/Health', 7);
INSERT INTO `cd_access` VALUES (2785, '/admin/', 7);
INSERT INTO `cd_access` VALUES (2784, '/admin/LockCard/dumpData', 7);
INSERT INTO `cd_access` VALUES (2783, '/admin/LockCard/view', 7);
INSERT INTO `cd_access` VALUES (2782, '/admin/LockCard/delete', 7);
INSERT INTO `cd_access` VALUES (2781, '/admin/LockCard/update', 7);
INSERT INTO `cd_access` VALUES (2780, '/admin/LockCard/add', 7);
INSERT INTO `cd_access` VALUES (2779, '/admin/LockCard/updateExt', 7);
INSERT INTO `cd_access` VALUES (2778, '/admin/LockCard/index', 7);
INSERT INTO `cd_access` VALUES (2777, '/admin/LockCard', 7);
INSERT INTO `cd_access` VALUES (2776, '/admin/Locktimes/view', 7);
INSERT INTO `cd_access` VALUES (2775, '/admin/Locktimes/delete', 7);
INSERT INTO `cd_access` VALUES (2774, '/admin/Locktimes/update', 7);
INSERT INTO `cd_access` VALUES (2773, '/admin/Locktimes/add', 7);
INSERT INTO `cd_access` VALUES (2772, '/admin/Locktimes/updateExt', 7);
INSERT INTO `cd_access` VALUES (2771, '/admin/Locktimes/index', 7);
INSERT INTO `cd_access` VALUES (2770, '/admin/Locktimes', 7);
INSERT INTO `cd_access` VALUES (2769, '/admin/LockLog/dumpData', 7);
INSERT INTO `cd_access` VALUES (2768, '/admin/LockLog/view', 7);
INSERT INTO `cd_access` VALUES (2767, '/admin/LockLog/delete', 7);
INSERT INTO `cd_access` VALUES (2766, '/admin/LockLog/add', 7);
INSERT INTO `cd_access` VALUES (2765, '/admin/LockLog/updateExt', 7);
INSERT INTO `cd_access` VALUES (2764, '/admin/LockLog/index', 7);
INSERT INTO `cd_access` VALUES (2763, '/admin/LockLog', 7);
INSERT INTO `cd_access` VALUES (2762, '/admin/LockAuth/view', 7);
INSERT INTO `cd_access` VALUES (2761, '/admin/LockAuth/delete', 7);
INSERT INTO `cd_access` VALUES (2760, '/admin/LockAuth/update', 7);
INSERT INTO `cd_access` VALUES (2759, '/admin/LockAuth/add', 7);
INSERT INTO `cd_access` VALUES (2758, '/admin/LockAuth/updateExt', 7);
INSERT INTO `cd_access` VALUES (2757, '/admin/LockAuth/index', 7);
INSERT INTO `cd_access` VALUES (2756, '/admin/LockAuth', 7);
INSERT INTO `cd_access` VALUES (2755, '/admin/LockCard/index', 7);
INSERT INTO `cd_access` VALUES (2754, '/admin/Locktimes/index', 7);
INSERT INTO `cd_access` VALUES (2753, '/admin/Lock/opendoor', 7);
INSERT INTO `cd_access` VALUES (2752, '/admin/Lock/dumpData', 7);
INSERT INTO `cd_access` VALUES (2751, '/admin/Lock/view', 7);
INSERT INTO `cd_access` VALUES (2750, '/admin/Lock/delete', 7);
INSERT INTO `cd_access` VALUES (2749, '/admin/Lock/update', 7);
INSERT INTO `cd_access` VALUES (2748, '/admin/Lock/add', 7);
INSERT INTO `cd_access` VALUES (2747, '/admin/Lock/index', 7);
INSERT INTO `cd_access` VALUES (2746, '/admin/Lock/updateExt', 7);
INSERT INTO `cd_access` VALUES (2740, '/admin/Umember', 7);
INSERT INTO `cd_access` VALUES (2741, '/admin/Umember/index', 7);
INSERT INTO `cd_access` VALUES (2742, '/admin/Umember/updateExt', 7);
INSERT INTO `cd_access` VALUES (2743, '/admin/Umember/update', 7);
INSERT INTO `cd_access` VALUES (2744, '/admin/', 7);
INSERT INTO `cd_access` VALUES (2745, '/admin/Lock', 7);

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
) ENGINE = MyISAM AUTO_INCREMENT = 2897 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `cd_action` VALUES (2769, 803, '首页数据列表', 'index', 1, NULL, '20', 0, 0, '', '门锁管理', '', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,online,lock_qrcode,create_time,successimg,successadimg', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
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
INSERT INTO `cd_action` VALUES (2794, 803, '添加', 'add', 3, NULL, '20', 1, 0, '', '添加', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,successimg,successadimg,hitshowminiad,qrshowminiad,openadurl,adnum', NULL, 'primary', '', '', '', 'fa fa-plus', 2794, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2779, 805, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'success', '', '', '', 'fa fa-pencil', 2774, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2780, 805, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2775, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2781, 805, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '', 'member_id,user_id,regpointname,regpointurl,create_time', NULL, 'info', '', '', '', 'fa fa-plus', 2776, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2789, 806, '查询管理员', 'view', 15, NULL, '', 0, NULL, '', '', '', '', NULL, NULL, '', '', '', NULL, 2789, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2795, 803, '修改', 'update', 4, NULL, '20', 1, 1, '', '修改', '800px|100%', 'lock_name,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,lock_qrcode,successimg,successadimg,hitshowminiad,qrshowminiad,openadurl,adnum', NULL, 'success', '', '', '', 'fa fa-pencil', 2795, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2784, 806, '修改', 'update', 4, '', '', 1, 1, '', '修改账户', '', 'name,user,group_id,type,note,status,member_id,create_time', '', 'success', '', '', '', 'fa fa-edit', 4, '', '', '', '', 1, 1, 1, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2785, 806, '修改密码', 'updatePassword', 9, '', '', 1, 0, '', '修改密码', '', 'pwd', '', 'warning', '', '', '', '', 6, '', '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2793, 794, '查询管理员ID', 'viewuserid', 15, NULL, '', 0, NULL, '', '查询管理员ID', '', '', NULL, NULL, 'user', 'member_id', 'a.member_id,b.*', NULL, 2793, NULL, '', '', NULL, 1, 1, NULL, 0, 1, 1, 0, 'post', 0, NULL);
INSERT INTO `cd_action` VALUES (2796, 803, '删除', 'delete', 5, NULL, '20', 1, 1, '', '删除', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time', NULL, 'danger', '', '', '', 'fa fa-trash', 2796, NULL, '', '', '', 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2797, 803, '查看数据', 'view', 15, NULL, '20', 1, 0, '', '查看数据', '800px|100%', 'user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,lock_qrcode,create_time,successimg,successadimg,openadurl,adnum', NULL, 'info', '', '', '', 'fa fa-plus', 2797, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
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
INSERT INTO `cd_action` VALUES (2824, 812, '首页数据列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id', '日志管理', '', '', NULL, 'primary', '', '', '', 'fa fa-bars', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
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
INSERT INTO `cd_action` VALUES (2890, 826, '首页数据列表', 'index', 1, NULL, '20', 0, 0, 'select a.*,b.headimgurl,b.nickname,b.mobile from cd_umember as a inner join cd_member as b  where a.member_id=b.member_id', '用户管理', '', '', NULL, 'primary', '', '', '', '', 1, NULL, '', '', '', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO `cd_action` VALUES (2891, 826, '修改排序开关按钮操作', 'updateExt', 16, NULL, '20', 0, NULL, NULL, '修改排序、开关按钮操作 如果没有此类操作 可以删除该方法', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2892, 826, '添加', 'add', 3, NULL, '20', 1, 0, NULL, '添加', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'primary', NULL, NULL, NULL, 'fa fa-plus', 2892, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2893, 826, '修改', 'update', 4, NULL, '20', 1, 1, NULL, '修改', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'success', NULL, NULL, NULL, 'fa fa-pencil', 2893, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2894, 826, '删除', 'delete', 5, NULL, '20', 1, 1, NULL, '删除', '', 'member_id,user_id,status,ucreate_time', NULL, 'danger', NULL, NULL, NULL, 'fa fa-trash', 2894, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2895, 826, '查看数据', 'view', 15, NULL, '20', 1, 0, NULL, '查看数据', '800px|400px', 'member_id,user_id,status,ucreate_time', NULL, 'info', NULL, NULL, NULL, 'fa fa-plus', 2895, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `cd_action` VALUES (2896, 826, '导出', 'dumpData', 12, NULL, '20', 1, 0, NULL, '导出', '', 'member_id,user_id,status,ucreate_time', NULL, 'warning', NULL, NULL, NULL, 'fa fa-download', 2896, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
INSERT INTO `cd_config` VALUES ('description', '门禁小程序管理平台');
INSERT INTO `cd_config` VALUES ('domain', '');
INSERT INTO `cd_config` VALUES ('file_size', '100');
INSERT INTO `cd_config` VALUES ('file_type', 'gif,png,jpg,jpeg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt,mp4,flv');
INSERT INTO `cd_config` VALUES ('images_size', '10M');
INSERT INTO `cd_config` VALUES ('keyword', '');
INSERT INTO `cd_config` VALUES ('privacypolicy', '&lt;p&gt;&amp;lt;p&amp;gt;&amp;amp;lt;p&amp;amp;gt;隐私政策&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;贵州智云信通科技有限公司（以下简称&amp;amp;amp;quot;本公司&amp;amp;amp;quot;，产品“微门禁”）在此郑重承诺，尊重和保护您的个人隐私，在使用微门禁相关产品前，请务必仔细阅读并理解本政策，在同意的情况下使用相关产品或服务。您一旦访问本公司旗下产品微门禁公众号及小程序等应用平台，则表明您已同意本《隐私政策》的内容。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;一、个人信息定义&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;个人信息是指您的任何标识性信息，包括：姓名、性别、身份证件号码、地址、健康状况、定位信息、电话号码、工作单位等。通常情况下，您无须提供您的个人信息即可，访问本网站。但为了提高服务质量，本公司可能需要您提供一些个人信息，以使本公司更好地了解您的需求来为您服务，同时，本公司有权采取措施验证您提供的个人信息的真实性。如果您提供了有关他人的个人信息，则表明您已取得了他人的正式许可。本公司承诺，除非出于您自己的意愿，本公司不会将您的个人信息提供给本公司之外的任何第三方。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;二、个人信息的收集目的&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;微门禁需要您提供个人信息的目的是确保您有权开启所需要的门禁系统，门禁所属单位对您进行验证审核并开放使用权限，提供安全便捷的开门服务，我们会征求您的同意，以便根据您的请求向您提供服务或执行事务，包括：接收有关本公司的产品和服务的信息、注册参加活、购买或注册本公司的产品、客户满意度调查、法律强制性规定等。另外，为抗击新冠肺炎疫情需要，我们提供的健康登记系统，将采集您的健康相关信息，为抗击疫情提供基础信息技术服务。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;3、 个人信息的使用&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;您提供的个人信息将仅在本公司内部使用，使用您的个人信息只是为了更好地了解您的需要并为您提供更好的服务或执行事务，同时本公司可能会使用您的个人信息与您联系以便向您提供服务。为抗击新冠肺炎疫情需要，我们开发了健康登记系统平台，健康相关信息由相应申请使用单位掌握，请知悉。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;4、 个人信息的安全&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;本公司承诺，保护您个人信息的安全性，同时，本公司已采取现有的可靠的安全措施保护您的个人信息免于未经授权的访问、使用或泄露。这些安全措施包括向云服务提供商备份数据和对用户密码加密。尽管有这些安全措施，但本公司不保证这些信息的绝对安全。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;5、 未成年人保护&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;未满十八岁的未成年人可在父母或监护人指导使用我们的服务。我们建议未成年人的父母或监护人阅读本《隐私政策》，并建议未成年人在提交的个人信息之前寻求父母或监护人的同意和指导。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;6、 关于Cookie&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;当您访问微门禁微信公众号、微信小程序、支付宝小程序及Web管理站点时，本公司可能会以&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;的形式将某些信息存入您的手机或计算机，&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;是网页服务器放置在您的计算机上的一个小的文本文件，&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;不能用于运行程序，也不会将病毒传播到您的计算机上。使用&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;的目的是为您提供一项节省时间的简便功能，但并不表示本公司可自动获悉有关您的任何个人信息。本网站可能还会使用session技术或其他技术以便能更好地调整本网站，从而提供优质服务。您可以选择接受或拒绝&amp;amp;amp;quot;Cookie&amp;amp;amp;quot;。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;7、 其他站点的链接&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;微门禁各平台及网站可能包含与其他站点的链接，但都是只读服务。本公司不对其他站点内容突变造成的《隐私政策》或内容负责。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;8、 法律性公开&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;根据法律强制性规定，安防法规条款等约束，微门禁应用平台及网站可能需要公开您的个人信息而无须获得您的预先同意并对此不负任何责任。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;9、 本《隐私政策》的修改&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;本《隐私政策》的修改权和解释权属于本公司。本公司可能适时修订本《隐私政策》的条款并予以公布，修订的内容自公布之日起生效，若您继续使用我们的服务，即表示同意受经修订的本《隐私政策》的约束。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;10、 纠纷解决&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;本《隐私政策》或有关使用微门禁应用平台及网站的任何行为受中华人民共和国法律管辖，如双方发生争议先协商解决，协商不成的，则交由本公司法定地址所在地的人民法院作出裁决。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;11、 联系方式&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;如果您有任何疑问和建议，可以通过微门禁应用平台及网站上的联系方式与本公司联系，本公司将尽最大的努力去解决。&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;&amp;amp;lt;br/&amp;amp;gt;&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;贵州智云信通科技有限公司&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;二零二零年三月&amp;amp;lt;/p&amp;amp;gt;&amp;amp;lt;p&amp;amp;gt;&amp;amp;lt;br/&amp;amp;gt;&amp;amp;lt;/p&amp;amp;gt;&amp;lt;/p&amp;gt;&lt;/p&gt;');
INSERT INTO `cd_config` VALUES ('serviceagreement', '&lt;p&gt;&amp;lt;p&amp;gt;微门禁用户服务协议&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;一、服务条款&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;您在使用微门禁服务前，应当仔细阅读《微门禁用户服务协议》（以下简称&amp;amp;quot;本协议&amp;amp;quot;或&amp;amp;quot;用户协议&amp;amp;quot;）的全部内容，您在用户注册页面点击&amp;amp;quot;同意以下协议并注册&amp;amp;quot;按钮后，即视为您已阅读、理解并同意本协议的全部内容。敬请注意，一旦您注册（登录）成功，本协议即在您与微门禁之间产生法律效力，成为对双方均具有约束力的法律文件。您应遵守以下协议的各项条款。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;二、目的&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;本协议是约定您使用微门禁提供的服务时，微门禁与您的权利、义务、服务条款等基本事宜为目的。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;三、遵守法律及法律效力&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;在您完成在线注册成功后，您就已与微门禁缔结了本协议，且本协议自您注册（登录）成功之日起产生法律效力。 您同意遵守《中华人民共和国保密法》、《计算机信息系统国际联网保密管理规定》、《中华人民共和国计算机信息系统安全保护条例》、《计算机信息网络国际联网安全保护管理办法》、《中华人民共和国计算机信息网络国际联网管理暂行规定》及其实施办法等相关法律法规的任何及所有的规定，并对您以任何方式使用服务的任何行为及其结果承担全部责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;在任何情况下，如果微门禁合理地认为您的任何行为，包括但不限于您的任何言论和其他违反或可能违反上述法律法规规定的任何行为，微门禁可在不经任何事先通知的情况下终止向您提供服务。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁有权利修改更新本协议的有关条款，一旦条款内容发生变动，微门禁将会在相关的页面提示修改内容。在更改此用户服务协议时，微门禁将说明更改内容的执行日期，变更理由等。且应同现行的使用服务协议一起，在更改内容发生效力前7日内向您公告。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;请仔细阅读用户协议更改内容，如因个人原因未能获知变更内容所带来的损害，微门禁一概不予负责。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如果不同意微门禁对服务条款所做的修改，用户有权停止使用网络服务。如果用户继续使用网络服务，则视为用户接受变更后的用户协议。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;四、服务内容&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁服务的具体内容由微门禁根据实际情况提供，微门禁保留随时变更、中断或终止部分或全部微门禁服务的权利。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;五、您的义务&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户在申请使用微门禁服务时，必须向微门禁提供准确的个人资料，如个人资料有任何变动，必须及时更新。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户注册成功后，微门禁将给予每个用户一个用户帐号及相应的密码，该用户帐号和密码由用户负责保管；用户应当对以其用户帐号进行的所有活动和事件负法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户在使用微门禁网络服务过程中，必须遵循以下原则：&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;遵守中国有关的法律和法规；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得为任何非法目的而使用网络服务系统；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;遵守所有与网络服务有关的网络协议、规定和程序&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统传输任何危害社会，侵蚀道德风尚，宣传不法宗教组织等内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统进行任何可能对互联网的正常运转造成不利影响的行为；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统上传、传输任何非法、有害、胁迫、滥用、骚扰、侵害、中伤、粗俗、猥亵、诽谤、侵害他人隐私、辱骂性的、恐吓性的、庸俗淫秽的及有害或种族歧视的或道德上令人不快的包括其他任何非法的信息资料；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;不得利用微门禁服务系统进行任何不利于微门禁的行为；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如发现任何非法使用用户帐号或帐号出现安全漏洞的情况，应立即通知微门禁。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;六、微门禁的权利及义务&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁除特殊情况外（例如：协助公安等相关部门调查破案等），致力于努力保护您的个人资料不被外漏，且不得在未经本人的同意下向第三者提供您的个人资料。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁根据提供服务的过程，经营上的变化，有权变更所提供服务的内容。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁在提供服务过程中，应及时解决您提出的不满事宜，如在解决过程中确有难处，可以采取公开通知方式或向您发送电子邮件寻求解决办法。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁在下列情况下有权未经通知，直接删除您上载的内容：&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;有损于微门禁，您或第三者名誉的内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;利用微门禁服务系统上载、张贴或传送任何非法、有害、胁迫、滥用、骚扰、侵害、中伤、粗俗、猥亵、诽谤、侵害他人隐私、辱骂性的、恐吓性的、庸俗淫秽的及有害或种族歧视的或道德上令人不快的包括其他任何非法的内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;侵害微门禁或第三者的版权，著作权等内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;存在与微门禁提供的服务无关的内容；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;无故盗用他人的ID(固有用户名)，姓名上传、传播任何内容及恶意更改，伪造他人上载内容。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;七、知识产权声明&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁所有的产品、技术、程序、页面（包括但不限于页面设计及内容）以及资料内容（包括但不限于本站所刊载的图片、视频）均属于知识产权，仅供用户交流、学习、研究和欣赏，未经授权，任何人不得擅自使用，否则，将依法追究法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁用户上传的资料内容（包括但不限于图片、视频、点评等），应保证为原创或已得到充分授权，并具有准确性、真实性、正当性、合法性，且不含任何侵犯第三人权益的内容，因抄袭、转载、侵权等行为所产生的纠纷由用户自行解决，微门禁不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;八、免责声明&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;任何人因使用微门禁而可能遭致的意外及其造成的损失（包括因使用微门禁可能链接的第三方网站内容而感染电脑病毒），我们对此概不负责，亦不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;微门禁禁止制作、复制、发布、传播等具有反动、色情、暴力、淫秽等内容的信息，一经发现，立即删除。若您因此触犯法律，我们对此不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;您自行上传或通过网络收集的资源，我们仅提供一个展示、交流的平台，不对其内容的准确性、真实性、正当性、合法性负责，也不承担任何法律责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;任何单位或个人认为通过微门禁展示的内容可能涉嫌侵犯其著作权，应该及时向我们提出书面权利通知，并提供身份证明、权属证明及详细侵权情况证明。我们收到上述法律文件后，将会依法尽快处理。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;九、服务变更、中断或终止&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如因系统维护或升级的需要而需暂停微门禁服务，微门禁将尽可能事先进行通告。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;如发生下列任何一种情形，微门禁有权随时中断或终止向用户提供本协议项下的微门禁服务而无需通知用户：&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户提供的个人资料不真实；&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;用户违反本用户协议中规定的使用规则。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;在用户违反本协议时，微门禁同时保留在不事先通知用户的情况下随时中断或终止部分或全部微门禁服务的权利，对于所有服务的中断或终止而造成的任何损失，微门禁无需对用户或任何第三方承担任何责任。&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;2020.03&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;（以下无正文）&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&lt;/p&gt;');
INSERT INTO `cd_config` VALUES ('site_logo', '/uploads/admin/202004/5e90014472f46.jpg');
INSERT INTO `cd_config` VALUES ('site_title', '门禁小程序');
INSERT INTO `cd_config` VALUES ('wmjaeskey', '');
INSERT INTO `cd_config` VALUES ('wmjappid', 'wmj_r3cdriDGrPK');
INSERT INTO `cd_config` VALUES ('wmjappsecret', '8urP5giJS10S3MCxmua7RcG7rB2f2K2q');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_doorstatus
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
) ENGINE = MyISAM AUTO_INCREMENT = 3552 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `cd_field` VALUES (3213, 793, '编号', 'member_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
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
INSERT INTO `cd_field` VALUES (3395, 812, '开门时间', 'create_time', 12, 1, 1, 0, '', 1, 1, 'center', '', '', '', '', 3459, '', '', '', 'int', '11', '');
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
INSERT INTO `cd_field` VALUES (3433, 812, '备注', 'remark', 1, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3458, '', '', '', 'varchar', '250', '');
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
INSERT INTO `cd_field` VALUES (3498, 803, '扫码开门广告', 'qrshowminiad', 23, 0, 0, 0, '开启|0,关闭|1', 1, 1, 'center', '', '', '', '', 3540, '', '', '1', 'tinyint', '4', '');
INSERT INTO `cd_field` VALUES (3499, 41, '隐私政策', 'privacypolicy', 16, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3499, '', '隐私政策', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3500, 41, '服务协议', 'serviceagreement', 16, NULL, NULL, NULL, '', 1, NULL, 'center', '', '', '', '', 3500, '', '服务协议', '', NULL, NULL, NULL);
INSERT INTO `cd_field` VALUES (3516, 794, '同意政策和协议', 'member_ps', 3, NULL, 0, 0, '', 1, 1, NULL, NULL, '', '', '', 3516, '', NULL, '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3515, 816, '服务协议', 'serviceagreement', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3515, '', NULL, '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3514, 816, '隐私政策', 'privacypolicy', 1, NULL, 1, 0, '', 1, 0, NULL, NULL, '', '', '', 3514, '', NULL, '', 'varchar', '250', '');
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
INSERT INTO `cd_field` VALUES (3540, 803, '开门成功外链', 'openadurl', 1, 0, 0, 0, '', 1, 1, 'center', '', '', '', '', 3543, '', '', 'https://mp.weixin.qq.com/s/UtKqS8FN73aai2PJTeHRig', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3541, 813, '开门广告外链', 'openadurl', 1, NULL, 0, 0, '', 0, 0, NULL, NULL, '', '', '', 3541, '', NULL, 'https://mp.weixin.qq.com/s/UtKqS8FN73aai2PJTeHRig', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3542, 818, '类型', 'type', 3, 1, 0, 0, '锁可用时段|1,钥匙可用时段|2', 1, 1, 'center', '', '', '', '', 3464, '', '', '1', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3543, 803, '成功弹层方式', 'adnum', 3, 0, 0, 0, '两图弹层|1,一张图带链接|2', 1, 1, 'center', '', '', '', '', 3486, '', '', '2', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3544, 826, '编号', 'umember_id', 1, 1, 0, NULL, NULL, 0, 1, 'center', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'int', '11', NULL);
INSERT INTO `cd_field` VALUES (3545, 826, '用户ID', 'member_id', 20, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3550, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3546, 826, '管理员ID', 'user_id', 15, 0, 1, 0, '', 1, 1, 'center', '', '', '', '', 3549, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3547, 826, '状态', 'status', 3, 1, 0, 0, '正常|1|success,禁用|0|danger', 1, 1, 'center', '', '', '', '', 3548, '', '', '', 'smallint', '6', '');
INSERT INTO `cd_field` VALUES (3548, 826, '注册时间', 'ucreate_time', 12, 1, 0, 0, '', 1, 1, 'center', '', '', '', '', 3551, '', '', '', 'int', '11', '');
INSERT INTO `cd_field` VALUES (3549, 826, '呢称', 'nickname', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3546, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3550, 826, '头像', 'headimgurl', 8, 1, 0, 0, '', 0, 0, 'center', '', '', '', '', 3545, '', '', '', 'varchar', '250', '');
INSERT INTO `cd_field` VALUES (3551, 826, '手机号', 'mobile', 1, 1, 1, 0, '', 0, 0, 'center', '', '', '', '', 3547, '', '', '', 'varchar', '250', '');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  PRIMARY KEY (`lock_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  `remark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `auth_starttime` int(11) NULL DEFAULT NULL COMMENT '有效期起始时间',
  `auth_sharelimit` int(11) NULL DEFAULT NULL COMMENT '可分享钥匙数',
  `auth_openlimit` int(11) NULL DEFAULT NULL COMMENT '可开次数',
  `auth_isadmin` smallint(6) NULL DEFAULT 0 COMMENT '是否管理员',
  `auth_status` smallint(6) NULL DEFAULT NULL COMMENT '审核状态',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `realname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `auth_opentimes` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '可开时段',
  `auth_tmp` smallint(6) NULL DEFAULT NULL COMMENT '领取标志',
  `auth_openused` int(11) NULL DEFAULT NULL COMMENT '已开次数',
  PRIMARY KEY (`lockauth_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  INDEX `lkcdsn`(`lockcard_sn`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `remark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `cardsn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`locklog_id`) USING BTREE,
  INDEX `cdsn`(`cardsn`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_locklog
-- ----------------------------
INSERT INTO `cd_locklog` VALUES (1, NULL, 1, 0, 3, 1593921537, '1', '失败,设备信号差', '');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_locktype
-- ----------------------------
INSERT INTO `cd_locktype` VALUES (1, 'WiFi版');
INSERT INTO `cd_locktype` VALUES (2, '插卡版(2G)');
INSERT INTO `cd_locktype` VALUES (3, '插卡版(4G)');
INSERT INTO `cd_locktype` VALUES (4, '网线版');
INSERT INTO `cd_locktype` VALUES (5, '插卡版本2G+刷卡');
INSERT INTO `cd_locktype` VALUES (9, '5G版本');
INSERT INTO `cd_locktype` VALUES (10, '22');

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
) ENGINE = InnoDB AUTO_INCREMENT = 300 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_log
-- ----------------------------
INSERT INTO `cd_log` VALUES (1, 1, 'admin', '用户登录', '58.62.202.26', 1593007582);
INSERT INTO `cd_log` VALUES (2, 1, 'admin', '用户登录', '111.59.18.58', 1593178668);
INSERT INTO `cd_log` VALUES (3, 1, 'admin', '用户登录', '113.56.203.26', 1593266613);
INSERT INTO `cd_log` VALUES (4, 1, 'admin', '用户登录', '111.121.42.55', 1593358799);
INSERT INTO `cd_log` VALUES (5, 1, 'admin', '用户登录', '111.121.42.55', 1593358891);
INSERT INTO `cd_log` VALUES (6, 1, 'admin', '用户登录', '122.226.178.186', 1593400054);
INSERT INTO `cd_log` VALUES (7, 1, 'admin', '用户登录', '112.96.97.180', 1593440751);
INSERT INTO `cd_log` VALUES (8, 1, 'admin', '用户登录', '183.219.175.227', 1593488663);
INSERT INTO `cd_log` VALUES (9, 1, 'admin', '用户登录', '120.229.78.33', 1593532168);
INSERT INTO `cd_log` VALUES (10, 1, 'admin', '用户登录', '183.11.203.85', 1593574768);
INSERT INTO `cd_log` VALUES (11, 1, 'admin', '用户登录', '218.207.204.245', 1593678660);
INSERT INTO `cd_log` VALUES (12, 1, 'admin', '用户登录', '114.138.28.187', 1593918929);
INSERT INTO `cd_log` VALUES (13, 1, 'admin', '用户登录', '106.57.168.18', 1593918993);
INSERT INTO `cd_log` VALUES (14, 1, 'admin', '用户登录', '106.57.168.18', 1593920604);
INSERT INTO `cd_log` VALUES (15, 1, 'admin', '用户登录', '180.119.128.51', 1593955933);
INSERT INTO `cd_log` VALUES (16, 1, 'admin', '用户登录', '223.104.57.218', 1594090357);
INSERT INTO `cd_log` VALUES (17, 1, 'admin', '用户登录', '124.127.99.32', 1594286508);
INSERT INTO `cd_log` VALUES (18, 1, 'admin', '用户登录', '112.94.117.120', 1594368528);
INSERT INTO `cd_log` VALUES (19, 1, 'admin', '用户登录', '111.21.206.66', 1594377427);
INSERT INTO `cd_log` VALUES (20, 1, 'admin', '用户登录', '113.57.218.176', 1595244847);
INSERT INTO `cd_log` VALUES (21, 1, 'admin', '用户登录', '223.72.67.248', 1595916815);
INSERT INTO `cd_log` VALUES (22, 1, 'admin', '用户登录', '113.106.2.255', 1596096685);
INSERT INTO `cd_log` VALUES (23, 1, 'admin', '用户登录', '115.216.12.122', 1596166798);
INSERT INTO `cd_log` VALUES (24, 1, 'admin', '用户登录', '116.21.231.247', 1596419553);
INSERT INTO `cd_log` VALUES (25, 1, 'admin', '用户登录', '116.21.231.247', 1596441785);
INSERT INTO `cd_log` VALUES (26, 1, 'admin', '用户登录', '116.21.231.247', 1596444499);
INSERT INTO `cd_log` VALUES (27, 1, 'admin', '用户登录', '113.111.6.233', 1596506940);
INSERT INTO `cd_log` VALUES (28, 1, 'admin', '用户登录', '113.111.6.233', 1596602620);
INSERT INTO `cd_log` VALUES (29, 1, 'admin', '用户登录', '27.191.234.81', 1596607461);
INSERT INTO `cd_log` VALUES (30, 1, 'admin', '用户登录', '171.221.57.195', 1596694836);
INSERT INTO `cd_log` VALUES (31, 1, 'admin', '用户登录', '106.117.85.84', 1596861764);
INSERT INTO `cd_log` VALUES (32, 1, 'admin', '用户登录', '111.173.139.171', 1597047373);
INSERT INTO `cd_log` VALUES (33, 1, 'admin', '用户登录', '110.86.15.182', 1597287183);
INSERT INTO `cd_log` VALUES (34, 1, 'admin', '用户登录', '202.120.7.24', 1597401228);
INSERT INTO `cd_log` VALUES (35, 1, 'admin', '用户登录', '115.205.218.140', 1597466510);
INSERT INTO `cd_log` VALUES (36, 1, 'admin', '用户登录', '112.10.80.205', 1597680592);
INSERT INTO `cd_log` VALUES (37, 1, 'admin', '用户登录', '61.158.152.195', 1597972858);
INSERT INTO `cd_log` VALUES (38, 1, 'admin', '用户登录', '27.210.213.207', 1597990512);
INSERT INTO `cd_log` VALUES (39, 1, 'admin', '用户登录', '58.20.133.79', 1598175706);
INSERT INTO `cd_log` VALUES (40, 1, 'admin', '用户登录', '118.79.222.24', 1598627307);
INSERT INTO `cd_log` VALUES (41, 1, 'admin', '用户登录', '221.209.26.103', 1598759798);
INSERT INTO `cd_log` VALUES (42, 1, 'admin', '用户登录', '120.239.162.20', 1598960882);
INSERT INTO `cd_log` VALUES (43, 1, 'admin', '用户登录', '182.240.92.222', 1599212410);
INSERT INTO `cd_log` VALUES (44, 1, 'admin', '用户登录', '27.38.12.20', 1599544300);
INSERT INTO `cd_log` VALUES (45, 1, 'admin', '用户登录', '27.38.12.20', 1599544889);
INSERT INTO `cd_log` VALUES (46, 98, 'admin', '用户登录', '117.189.25.57', 1603434408);
INSERT INTO `cd_log` VALUES (47, 98, 'admin', '用户登录', '117.189.25.57', 1603434465);
INSERT INTO `cd_log` VALUES (48, 98, 'admin', '用户登录', '1.86.241.61', 1603434492);
INSERT INTO `cd_log` VALUES (49, 98, 'admin', '用户登录', '1.80.136.67', 1603552361);
INSERT INTO `cd_log` VALUES (50, 98, 'admin', '用户登录', '113.233.18.129', 1603760214);
INSERT INTO `cd_log` VALUES (51, 98, 'admin', '用户登录', '58.247.178.18', 1603876599);
INSERT INTO `cd_log` VALUES (52, 98, 'admin', '用户登录', '117.150.7.32', 1603938974);
INSERT INTO `cd_log` VALUES (53, 98, 'admin', '用户登录', '113.64.97.243', 1604277212);
INSERT INTO `cd_log` VALUES (54, 98, 'admin', '用户登录', '117.136.70.48', 1604288617);
INSERT INTO `cd_log` VALUES (55, 98, 'admin', '用户登录', '123.124.246.82', 1604329338);
INSERT INTO `cd_log` VALUES (56, 98, 'admin', '用户登录', '221.192.178.46', 1604830224);
INSERT INTO `cd_log` VALUES (57, 98, 'admin', '用户登录', '113.64.82.226', 1604893983);
INSERT INTO `cd_log` VALUES (58, 98, 'admin', '用户登录', '39.189.53.187', 1605037654);
INSERT INTO `cd_log` VALUES (59, 98, 'admin', '用户登录', '124.92.93.255', 1605044815);
INSERT INTO `cd_log` VALUES (60, 98, 'admin', '用户登录', '60.253.193.202', 1605082490);
INSERT INTO `cd_log` VALUES (61, 98, 'admin', '用户登录', '183.134.40.236', 1605535824);
INSERT INTO `cd_log` VALUES (62, 98, 'admin', '用户登录', '60.253.193.202', 1605584799);
INSERT INTO `cd_log` VALUES (63, 98, 'admin', '用户登录', '61.143.203.29', 1605660241);
INSERT INTO `cd_log` VALUES (64, 98, 'admin', '用户登录', '183.14.132.208', 1605757368);
INSERT INTO `cd_log` VALUES (65, 98, 'admin', '用户登录', '183.14.132.208', 1605757516);
INSERT INTO `cd_log` VALUES (66, 98, 'admin', '用户登录', '183.14.132.208', 1605785985);
INSERT INTO `cd_log` VALUES (67, 98, 'admin', '用户登录', '117.176.219.203', 1606063376);
INSERT INTO `cd_log` VALUES (68, 98, 'admin', '用户登录', '183.14.28.204', 1606359811);
INSERT INTO `cd_log` VALUES (69, 98, 'admin', '用户登录', '113.16.249.109', 1606360865);
INSERT INTO `cd_log` VALUES (70, 98, 'admin', '用户登录', '123.161.200.9', 1606563243);
INSERT INTO `cd_log` VALUES (71, 98, 'admin', '用户登录', '113.64.99.215', 1606717914);
INSERT INTO `cd_log` VALUES (72, 98, 'admin', '用户登录', '210.21.223.180', 1606728654);
INSERT INTO `cd_log` VALUES (73, 98, 'admin', '用户登录', '183.14.30.185', 1606785994);
INSERT INTO `cd_log` VALUES (74, 98, 'admin', '用户登录', '1.199.128.80', 1606788343);
INSERT INTO `cd_log` VALUES (75, 98, 'admin', '用户登录', '113.58.212.205', 1606835245);
INSERT INTO `cd_log` VALUES (76, 98, 'admin', '用户登录', '112.10.185.129', 1606889439);
INSERT INTO `cd_log` VALUES (77, 98, 'admin', '用户登录', '125.122.14.254', 1607068462);
INSERT INTO `cd_log` VALUES (78, 98, 'admin', '用户登录', '110.191.179.201', 1607141847);
INSERT INTO `cd_log` VALUES (79, 98, 'admin', '用户登录', '117.140.106.151', 1607252870);
INSERT INTO `cd_log` VALUES (80, 98, 'admin', '用户登录', '113.12.195.162', 1607300315);
INSERT INTO `cd_log` VALUES (81, 98, 'admin', '用户登录', '115.206.15.200', 1607304968);
INSERT INTO `cd_log` VALUES (82, 98, 'admin', '用户登录', '115.206.15.200', 1607414337);
INSERT INTO `cd_log` VALUES (83, 98, 'admin', '用户登录', '115.206.15.200', 1607422242);
INSERT INTO `cd_log` VALUES (84, 98, 'admin', '用户登录', '115.206.15.200', 1607422261);
INSERT INTO `cd_log` VALUES (85, 98, 'admin', '用户登录', '117.157.99.93', 1607578728);
INSERT INTO `cd_log` VALUES (86, 98, 'admin', '用户登录', '180.110.163.179', 1607590755);
INSERT INTO `cd_log` VALUES (87, 98, 'admin', '用户登录', '113.118.199.126', 1607651361);
INSERT INTO `cd_log` VALUES (88, 98, 'admin', '用户登录', '113.88.107.199', 1607657963);
INSERT INTO `cd_log` VALUES (89, 98, 'admin', '用户登录', '118.112.120.136', 1607665735);
INSERT INTO `cd_log` VALUES (90, 98, 'admin', '用户登录', '210.21.214.205', 1607668777);
INSERT INTO `cd_log` VALUES (91, 98, 'admin', '用户登录', '116.139.60.236', 1607672657);
INSERT INTO `cd_log` VALUES (92, 98, 'admin', '用户登录', '111.121.8.200', 1607861122);
INSERT INTO `cd_log` VALUES (93, 98, 'admin', '用户登录', '111.121.8.200', 1607861667);
INSERT INTO `cd_log` VALUES (94, 98, 'admin', '用户登录', '113.118.87.252', 1607916299);
INSERT INTO `cd_log` VALUES (95, 98, 'admin', '用户登录', '183.14.30.169', 1607997522);
INSERT INTO `cd_log` VALUES (96, 98, 'admin', '用户登录', '113.46.9.177', 1608398857);
INSERT INTO `cd_log` VALUES (97, 98, 'admin', '用户登录', '113.248.155.202', 1608622219);
INSERT INTO `cd_log` VALUES (98, 98, 'admin', '用户登录', '113.116.5.139', 1608716796);
INSERT INTO `cd_log` VALUES (99, 98, 'admin', '用户登录', '112.246.75.236', 1608867454);
INSERT INTO `cd_log` VALUES (100, 98, 'admin', '用户登录', '183.221.16.149', 1609172500);
INSERT INTO `cd_log` VALUES (101, 98, 'admin', '用户登录', '112.65.1.123', 1609253967);
INSERT INTO `cd_log` VALUES (102, 98, 'admin', '用户登录', '120.231.95.129', 1609258278);
INSERT INTO `cd_log` VALUES (103, 98, 'admin', '用户登录', '14.104.201.88', 1609379925);
INSERT INTO `cd_log` VALUES (105, 98, 'admin', '用户登录', '1.86.56.177', 1609646465);
INSERT INTO `cd_log` VALUES (106, 98, 'admin', '用户登录', '120.235.32.132', 1609653967);
INSERT INTO `cd_log` VALUES (107, 98, 'admin', '用户登录', '113.118.199.14', 1609726795);
INSERT INTO `cd_log` VALUES (108, 98, 'admin', '用户登录', '106.84.16.150', 1609810655);
INSERT INTO `cd_log` VALUES (109, 98, 'admin', '用户登录', '113.118.199.14', 1609811033);
INSERT INTO `cd_log` VALUES (110, 98, 'admin', '用户登录', '14.221.99.45', 1609826190);
INSERT INTO `cd_log` VALUES (111, 98, 'admin', '用户登录', '120.231.95.144', 1609861123);
INSERT INTO `cd_log` VALUES (112, 98, 'admin', '用户登录', '113.200.57.42', 1609898007);
INSERT INTO `cd_log` VALUES (113, 98, 'admin', '用户登录', '111.19.41.112', 1610069155);
INSERT INTO `cd_log` VALUES (114, 98, 'admin', '用户登录', '183.250.89.190', 1610069492);
INSERT INTO `cd_log` VALUES (115, 98, 'admin', '用户登录', '111.19.41.112', 1610069566);
INSERT INTO `cd_log` VALUES (116, 98, 'admin', '用户登录', '220.166.97.47', 1610078277);
INSERT INTO `cd_log` VALUES (117, 98, 'admin', '用户登录', '49.69.112.186', 1610148862);
INSERT INTO `cd_log` VALUES (118, 98, 'admin', '用户登录', '116.2.92.222', 1610259975);
INSERT INTO `cd_log` VALUES (119, 98, 'admin', '用户登录', '223.104.247.203', 1610336836);
INSERT INTO `cd_log` VALUES (120, 98, 'admin', '用户登录', '60.253.255.234', 1610931781);
INSERT INTO `cd_log` VALUES (121, 98, 'admin', '用户登录', '115.220.204.149', 1610935817);
INSERT INTO `cd_log` VALUES (122, 98, 'admin', '用户登录', '60.216.87.190', 1611036720);
INSERT INTO `cd_log` VALUES (123, 98, 'admin', '用户登录', '61.141.255.53', 1611200666);
INSERT INTO `cd_log` VALUES (124, 98, 'admin', '用户登录', '117.114.138.106', 1611213846);
INSERT INTO `cd_log` VALUES (125, 98, 'admin', '用户登录', '124.240.9.228', 1611223013);
INSERT INTO `cd_log` VALUES (126, 98, 'admin', '用户登录', '113.73.33.62', 1611238976);
INSERT INTO `cd_log` VALUES (127, 98, 'admin', '用户登录', '111.18.37.88', 1611547318);
INSERT INTO `cd_log` VALUES (128, 98, 'admin', '用户登录', '60.1.147.236', 1611729548);
INSERT INTO `cd_log` VALUES (129, 98, 'admin', '用户登录', '210.21.223.178', 1612148649);
INSERT INTO `cd_log` VALUES (130, 98, 'admin', '用户登录', '117.61.10.8', 1612283059);
INSERT INTO `cd_log` VALUES (131, 98, 'admin', '用户登录', '182.246.145.209', 1612319364);
INSERT INTO `cd_log` VALUES (132, 98, 'admin', '用户登录', '1.85.217.229', 1612422123);
INSERT INTO `cd_log` VALUES (133, 98, 'admin', '用户登录', '117.136.0.209', 1612681989);
INSERT INTO `cd_log` VALUES (134, 98, 'admin', '用户登录', '120.230.107.200', 1612786296);
INSERT INTO `cd_log` VALUES (135, 98, 'admin', '用户登录', '117.136.41.62', 1613030124);
INSERT INTO `cd_log` VALUES (136, 98, 'admin', '用户登录', '36.47.140.50', 1613317118);
INSERT INTO `cd_log` VALUES (137, 98, 'admin', '用户登录', '120.230.126.171', 1613390289);
INSERT INTO `cd_log` VALUES (138, 98, 'admin', '用户登录', '120.230.126.171', 1613390672);
INSERT INTO `cd_log` VALUES (139, 98, 'admin', '用户登录', '125.95.61.33', 1613457444);
INSERT INTO `cd_log` VALUES (140, 98, 'admin', '用户登录', '221.225.72.39', 1613464278);
INSERT INTO `cd_log` VALUES (141, 98, 'admin', '用户登录', '223.73.56.19', 1613603876);
INSERT INTO `cd_log` VALUES (142, 98, 'admin', '用户登录', '117.136.32.59', 1613607021);
INSERT INTO `cd_log` VALUES (143, 98, 'admin', '用户登录', '1.193.37.3', 1613637961);
INSERT INTO `cd_log` VALUES (144, 98, 'admin', '用户登录', '112.115.183.10', 1613701946);
INSERT INTO `cd_log` VALUES (145, 98, 'admin', '用户登录', '119.123.103.114', 1614046268);
INSERT INTO `cd_log` VALUES (146, 98, 'admin', '用户登录', '121.32.12.201', 1614065745);
INSERT INTO `cd_log` VALUES (147, 98, 'admin', '用户登录', '58.247.31.2', 1614139370);
INSERT INTO `cd_log` VALUES (148, 98, 'admin', '用户登录', '120.230.135.74', 1614159057);
INSERT INTO `cd_log` VALUES (149, 98, 'admin', '用户登录', '111.30.201.79', 1614343226);
INSERT INTO `cd_log` VALUES (150, 98, 'admin', '用户登录', '113.90.238.150', 1614565550);
INSERT INTO `cd_log` VALUES (151, 98, 'admin', '用户登录', '113.90.238.150', 1614571378);
INSERT INTO `cd_log` VALUES (152, 98, 'admin', '用户登录', '113.90.238.150', 1614579539);
INSERT INTO `cd_log` VALUES (153, 98, 'admin', '用户登录', '113.90.238.150', 1614648262);
INSERT INTO `cd_log` VALUES (154, 98, 'admin', '用户登录', '58.211.48.234', 1614655005);
INSERT INTO `cd_log` VALUES (155, 98, 'admin', '用户登录', '36.112.117.138', 1614680285);
INSERT INTO `cd_log` VALUES (156, 98, 'admin', '用户登录', '113.118.87.96', 1614737872);
INSERT INTO `cd_log` VALUES (157, 98, 'admin', '用户登录', '163.125.255.14', 1614744625);
INSERT INTO `cd_log` VALUES (158, 98, 'admin', '用户登录', '119.4.121.86', 1614762929);
INSERT INTO `cd_log` VALUES (159, 98, 'admin', '用户登录', '182.119.131.210', 1614824782);
INSERT INTO `cd_log` VALUES (160, 98, 'admin', '用户登录', '144.0.143.46', 1614867724);
INSERT INTO `cd_log` VALUES (161, 98, 'admin', '用户登录', '182.32.178.213', 1614937675);
INSERT INTO `cd_log` VALUES (162, 98, 'admin', '用户登录', '175.152.3.14', 1615009896);
INSERT INTO `cd_log` VALUES (163, 98, 'admin', '用户登录', '117.24.25.65', 1615046762);
INSERT INTO `cd_log` VALUES (164, 98, 'admin', '用户登录', '115.204.140.200', 1615357646);
INSERT INTO `cd_log` VALUES (165, 98, 'admin', '用户登录', '60.233.1.100', 1615365413);
INSERT INTO `cd_log` VALUES (166, 98, 'admin', '用户登录', '113.90.238.150', 1615448942);
INSERT INTO `cd_log` VALUES (167, 98, 'admin', '用户登录', '113.90.238.150', 1615542309);
INSERT INTO `cd_log` VALUES (168, 98, 'admin', '用户登录', '113.88.104.221', 1615606170);
INSERT INTO `cd_log` VALUES (169, 98, 'admin', '用户登录', '218.68.145.113', 1615886905);
INSERT INTO `cd_log` VALUES (170, 98, 'admin', '用户登录', '27.18.128.6', 1615938920);
INSERT INTO `cd_log` VALUES (171, 98, 'admin', '用户登录', '112.32.93.227', 1615997444);
INSERT INTO `cd_log` VALUES (172, 98, 'admin', '用户登录', '112.31.208.45', 1616030227);
INSERT INTO `cd_log` VALUES (173, 98, 'admin', '用户登录', '113.116.5.248', 1616035524);
INSERT INTO `cd_log` VALUES (174, 98, 'admin', '用户登录', '111.75.163.254', 1616120388);
INSERT INTO `cd_log` VALUES (175, 98, 'admin', '用户登录', '111.18.140.128', 1616124677);
INSERT INTO `cd_log` VALUES (176, 98, 'admin', '用户登录', '185.209.179.203', 1616125996);
INSERT INTO `cd_log` VALUES (177, 98, 'admin', '用户登录', '39.189.35.47', 1616320146);
INSERT INTO `cd_log` VALUES (178, 98, 'admin', '用户登录', '119.136.115.79', 1616391490);
INSERT INTO `cd_log` VALUES (179, 98, 'admin', '用户登录', '36.170.32.76', 1616416811);
INSERT INTO `cd_log` VALUES (180, 98, 'admin', '用户登录', '223.104.204.17', 1616417767);
INSERT INTO `cd_log` VALUES (181, 98, 'admin', '用户登录', '120.84.186.210', 1616490831);
INSERT INTO `cd_log` VALUES (182, 98, 'admin', '用户登录', '119.123.74.105', 1616491309);
INSERT INTO `cd_log` VALUES (183, 98, 'admin', '用户登录', '112.49.96.214', 1616500635);
INSERT INTO `cd_log` VALUES (184, 98, 'admin', '用户登录', '171.221.101.62', 1616756989);
INSERT INTO `cd_log` VALUES (185, 98, 'admin', '用户登录', '114.222.179.31', 1617073482);
INSERT INTO `cd_log` VALUES (186, 98, 'admin', '用户登录', '36.48.110.172', 1617263667);
INSERT INTO `cd_log` VALUES (187, 98, 'admin', '用户登录', '113.88.144.65', 1617274089);
INSERT INTO `cd_log` VALUES (188, 98, 'admin', '用户登录', '124.134.61.13', 1617460116);
INSERT INTO `cd_log` VALUES (189, 98, 'admin', '用户登录', '202.107.31.83', 1617758131);
INSERT INTO `cd_log` VALUES (190, 98, 'admin', '用户登录', '120.224.236.211', 1617848008);
INSERT INTO `cd_log` VALUES (191, 98, 'admin', '用户登录', '117.136.104.182', 1617853987);
INSERT INTO `cd_log` VALUES (192, 98, 'admin', '用户登录', '117.28.131.117', 1617871522);
INSERT INTO `cd_log` VALUES (193, 98, 'admin', '用户登录', '121.35.100.164', 1617930941);
INSERT INTO `cd_log` VALUES (194, 98, 'admin', '用户登录', '27.38.9.81', 1618064569);
INSERT INTO `cd_log` VALUES (195, 98, 'admin', '用户登录', '183.192.238.130', 1618143798);
INSERT INTO `cd_log` VALUES (196, 98, 'admin', '用户登录', '183.128.228.67', 1618195443);
INSERT INTO `cd_log` VALUES (197, 98, 'admin', '用户登录', '117.181.138.94', 1618282200);
INSERT INTO `cd_log` VALUES (198, 98, 'admin', '用户登录', '183.14.29.232', 1618286179);
INSERT INTO `cd_log` VALUES (199, 98, 'admin', '用户登录', '49.74.17.122', 1618292811);
INSERT INTO `cd_log` VALUES (200, 98, 'admin', '用户登录', '36.17.81.21', 1618361250);
INSERT INTO `cd_log` VALUES (201, 98, 'admin', '用户登录', '59.49.106.119', 1618371465);
INSERT INTO `cd_log` VALUES (202, 98, 'admin', '用户登录', '119.137.55.73', 1618383694);
INSERT INTO `cd_log` VALUES (203, 98, 'admin', '用户登录', '125.95.62.15', 1618455129);
INSERT INTO `cd_log` VALUES (204, 98, 'admin', '用户登录', '39.79.106.132', 1618471495);
INSERT INTO `cd_log` VALUES (205, 98, 'admin', '用户登录', '125.95.62.15', 1618538979);
INSERT INTO `cd_log` VALUES (206, 98, 'admin', '用户登录', '125.70.229.109', 1618556748);
INSERT INTO `cd_log` VALUES (207, 98, 'admin', '用户登录', '112.18.215.66', 1618567129);
INSERT INTO `cd_log` VALUES (208, 98, 'admin', '用户登录', '101.204.175.230', 1618579750);
INSERT INTO `cd_log` VALUES (209, 98, 'admin', '用户登录', '119.136.152.232', 1618896882);
INSERT INTO `cd_log` VALUES (210, 98, 'admin', '用户登录', '58.22.113.107', 1618907341);
INSERT INTO `cd_log` VALUES (211, 98, 'admin', '用户登录', '119.136.152.251', 1618986707);
INSERT INTO `cd_log` VALUES (212, 98, 'admin', '用户登录', '124.129.11.56', 1618993451);
INSERT INTO `cd_log` VALUES (213, 98, 'admin', '用户登录', '36.48.113.92', 1619060532);
INSERT INTO `cd_log` VALUES (214, 98, 'admin', '用户登录', '119.136.152.251', 1619062184);
INSERT INTO `cd_log` VALUES (215, 98, 'admin', '用户登录', '119.136.152.251', 1619147762);
INSERT INTO `cd_log` VALUES (216, 98, 'admin', '用户登录', '119.187.252.54', 1619157511);
INSERT INTO `cd_log` VALUES (217, 98, 'admin', '用户登录', '49.118.179.145', 1619162807);
INSERT INTO `cd_log` VALUES (218, 98, 'admin', '用户登录', '119.136.154.161', 1619336235);
INSERT INTO `cd_log` VALUES (219, 98, 'admin', '用户登录', '223.157.169.61', 1619627981);
INSERT INTO `cd_log` VALUES (220, 98, 'admin', '用户登录', '113.122.232.186', 1620179210);
INSERT INTO `cd_log` VALUES (221, 98, 'admin', '用户登录', '111.19.32.215', 1620220469);
INSERT INTO `cd_log` VALUES (222, 98, 'admin', '用户登录', '114.216.114.250', 1620291247);
INSERT INTO `cd_log` VALUES (223, 98, 'admin', '用户登录', '111.85.93.99', 1620311868);
INSERT INTO `cd_log` VALUES (224, 98, 'admin', '用户登录', '113.87.46.27', 1620638731);
INSERT INTO `cd_log` VALUES (225, 98, 'admin', '用户登录', '222.91.199.239', 1620718223);
INSERT INTO `cd_log` VALUES (226, 98, 'admin', '用户登录', '58.34.133.162', 1620723487);
INSERT INTO `cd_log` VALUES (227, 98, 'admin', '用户登录', '58.34.133.162', 1620782810);
INSERT INTO `cd_log` VALUES (228, 98, 'admin', '用户登录', '120.245.102.242', 1620787486);
INSERT INTO `cd_log` VALUES (229, 98, 'admin', '用户登录', '123.161.201.237', 1620830526);
INSERT INTO `cd_log` VALUES (230, 98, 'admin', '用户登录', '1.80.38.1', 1620879190);
INSERT INTO `cd_log` VALUES (231, 98, 'admin', '用户登录', '1.85.49.37', 1620884507);
INSERT INTO `cd_log` VALUES (232, 98, 'admin', '用户登录', '115.217.198.233', 1620884639);
INSERT INTO `cd_log` VALUES (233, 98, 'admin', '用户登录', '218.69.156.153', 1620891936);
INSERT INTO `cd_log` VALUES (234, 98, 'admin', '用户登录', '58.34.133.162', 1620954873);
INSERT INTO `cd_log` VALUES (235, 98, 'admin', '用户登录', '1.181.213.194', 1620975265);
INSERT INTO `cd_log` VALUES (236, 98, 'admin', '用户登录', '1.181.213.194', 1620979358);
INSERT INTO `cd_log` VALUES (237, 98, 'admin', '用户登录', '1.181.213.194', 1620983062);
INSERT INTO `cd_log` VALUES (238, 98, 'admin', '用户登录', '120.231.95.121', 1621013051);
INSERT INTO `cd_log` VALUES (239, 98, 'admin', '用户登录', '49.73.108.85', 1621239447);
INSERT INTO `cd_log` VALUES (240, 98, 'admin', '用户登录', '49.67.60.108', 1621300786);
INSERT INTO `cd_log` VALUES (241, 98, 'admin', '用户登录', '219.138.203.90', 1621325525);
INSERT INTO `cd_log` VALUES (242, 98, 'admin', '用户登录', '115.205.1.129', 1621491685);
INSERT INTO `cd_log` VALUES (243, 98, 'admin', '用户登录', '58.34.133.162', 1621493479);
INSERT INTO `cd_log` VALUES (244, 98, 'admin', '用户登录', '218.19.205.138', 1621506849);
INSERT INTO `cd_log` VALUES (245, 98, 'admin', '用户登录', '113.140.160.153', 1621746141);
INSERT INTO `cd_log` VALUES (246, 98, 'admin', '用户登录', '116.22.149.12', 1622684795);
INSERT INTO `cd_log` VALUES (247, 98, 'admin', '用户登录', '101.232.41.212', 1622689802);
INSERT INTO `cd_log` VALUES (248, 98, 'admin', '用户登录', '120.231.182.107', 1622714453);
INSERT INTO `cd_log` VALUES (249, 98, 'admin', '用户登录', '183.67.61.127', 1622772703);
INSERT INTO `cd_log` VALUES (250, 98, 'admin', '用户登录', '122.238.3.137', 1622949633);
INSERT INTO `cd_log` VALUES (251, 98, 'admin', '用户登录', '113.88.167.185', 1623034064);
INSERT INTO `cd_log` VALUES (252, 98, 'admin', '用户登录', '58.49.98.26', 1623740335);
INSERT INTO `cd_log` VALUES (253, 98, 'admin', '用户登录', '114.86.93.11', 1623813101);
INSERT INTO `cd_log` VALUES (254, 98, 'admin', '用户登录', '219.142.144.30', 1624002746);
INSERT INTO `cd_log` VALUES (255, 98, 'admin', '用户登录', '118.113.16.200', 1624003708);
INSERT INTO `cd_log` VALUES (256, 98, 'admin', '用户登录', '223.72.12.78', 1624047247);
INSERT INTO `cd_log` VALUES (257, 98, 'admin', '用户登录', '223.72.12.78', 1624047300);
INSERT INTO `cd_log` VALUES (258, 98, 'admin', '用户登录', '59.58.164.59', 1624267195);
INSERT INTO `cd_log` VALUES (259, 98, 'admin', '用户登录', '101.85.0.102', 1624311639);
INSERT INTO `cd_log` VALUES (260, 98, 'admin', '用户登录', '59.58.164.59', 1624346622);
INSERT INTO `cd_log` VALUES (261, 98, 'admin', '用户登录', '223.104.212.59', 1624348590);
INSERT INTO `cd_log` VALUES (262, 100, 'spr_77', '用户登录', '223.104.212.59', 1624348773);
INSERT INTO `cd_log` VALUES (263, 98, 'admin', '用户登录', '59.58.164.59', 1624429693);
INSERT INTO `cd_log` VALUES (264, 98, 'admin', '用户登录', '115.213.84.149', 1624500589);
INSERT INTO `cd_log` VALUES (265, 98, 'admin', '用户登录', '125.94.201.150', 1624622013);
INSERT INTO `cd_log` VALUES (266, 98, 'admin', '用户登录', '106.18.137.196', 1624852552);
INSERT INTO `cd_log` VALUES (267, 98, 'admin', '用户登录', '222.129.36.186', 1624934211);
INSERT INTO `cd_log` VALUES (268, 98, 'admin', '用户登录', '60.173.201.28', 1624936691);
INSERT INTO `cd_log` VALUES (269, 98, 'admin', '用户登录', '113.110.220.43', 1624950239);
INSERT INTO `cd_log` VALUES (270, 101, '测试1', '用户登录', '113.110.220.43', 1624951056);
INSERT INTO `cd_log` VALUES (271, 98, 'admin', '用户登录', '113.110.220.43', 1624951233);
INSERT INTO `cd_log` VALUES (272, 98, 'admin', '用户登录', '123.161.201.237', 1625104198);
INSERT INTO `cd_log` VALUES (273, 98, 'admin', '用户登录', '171.118.148.108', 1625453446);
INSERT INTO `cd_log` VALUES (274, 98, 'admin', '用户登录', '180.164.37.122', 1625624451);
INSERT INTO `cd_log` VALUES (275, 98, 'admin', '用户登录', '122.232.87.82', 1625747258);
INSERT INTO `cd_log` VALUES (276, 98, 'admin', '用户登录', '116.232.76.150', 1626067159);
INSERT INTO `cd_log` VALUES (277, 98, 'admin', '用户登录', '59.57.167.99', 1626076369);
INSERT INTO `cd_log` VALUES (278, 98, 'admin', '用户登录', '182.102.184.167', 1626507650);
INSERT INTO `cd_log` VALUES (279, 98, 'admin', '用户登录', '183.194.173.110', 1626831276);
INSERT INTO `cd_log` VALUES (280, 98, 'admin', '用户登录', '182.129.2.141', 1626957297);
INSERT INTO `cd_log` VALUES (281, 98, 'admin', '用户登录', '113.116.30.246', 1627212539);
INSERT INTO `cd_log` VALUES (282, 98, 'admin', '用户登录', '183.206.168.146', 1627403671);
INSERT INTO `cd_log` VALUES (283, 98, 'admin', '用户登录', '27.211.18.190', 1627456221);
INSERT INTO `cd_log` VALUES (284, 98, 'admin', '用户登录', '111.162.129.37', 1627546556);
INSERT INTO `cd_log` VALUES (285, 98, 'admin', '用户登录', '218.13.32.86', 1627784973);
INSERT INTO `cd_log` VALUES (286, 98, 'admin', '用户登录', '115.199.255.212', 1627972423);
INSERT INTO `cd_log` VALUES (287, 98, 'admin', '用户登录', '118.116.89.229', 1628093482);
INSERT INTO `cd_log` VALUES (288, 98, 'admin', '用户登录', '110.184.35.98', 1628131216);
INSERT INTO `cd_log` VALUES (289, 98, 'admin', '用户登录', '171.218.85.110', 1628229589);
INSERT INTO `cd_log` VALUES (290, 98, 'admin', '用户登录', '111.19.78.98', 1628303352);
INSERT INTO `cd_log` VALUES (291, 98, 'admin', '用户登录', '222.247.153.185', 1628523023);
INSERT INTO `cd_log` VALUES (292, 98, 'admin', '用户登录', '125.95.21.105', 1628564010);
INSERT INTO `cd_log` VALUES (293, 98, 'admin', '用户登录', '113.200.54.82', 1628659510);
INSERT INTO `cd_log` VALUES (294, 98, 'admin', '用户登录', '221.217.239.171', 1628730704);
INSERT INTO `cd_log` VALUES (295, 98, 'admin', '用户登录', '119.103.22.101', 1628925658);
INSERT INTO `cd_log` VALUES (296, 98, 'admin', '用户登录', '219.232.72.50', 1629558617);
INSERT INTO `cd_log` VALUES (297, 98, 'admin', '用户登录', '112.10.127.212', 1629615070);
INSERT INTO `cd_log` VALUES (298, 98, 'admin', '用户登录', '113.72.10.161', 1629704991);
INSERT INTO `cd_log` VALUES (299, 98, 'admin', '用户登录', '125.120.47.176', 1629874002);

-- ----------------------------
-- Table structure for cd_member
-- ----------------------------
DROP TABLE IF EXISTS `cd_member`;
CREATE TABLE `cd_member`  (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '呢称',
  `headimgurl` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '头像',
  `openid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'openid',
  `mobile` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机号',
  `username` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '密码',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '注册时间',
  `sex` smallint(6) NULL DEFAULT 0 COMMENT '性别',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '状态',
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属用户',
  `ali_user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝用户id',
  `member_type` smallint(6) NULL DEFAULT NULL COMMENT '会员类型',
  `member_ps` smallint(6) NULL DEFAULT NULL COMMENT '同意政策和协议',
  `unionid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'unionid',
  PRIMARY KEY (`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cd_member
-- ----------------------------
INSERT INTO `cd_member` VALUES (5, '', '', '', '', '', 'd36fe307706ee96649b4030001e4dba9', 1616391716, 1, 1, NULL, NULL, NULL, NULL, '0');
INSERT INTO `cd_member` VALUES (7, '', '', '', '', '', 'd36fe307706ee96649b4030001e4dba9', 1621493677, 1, 0, NULL, NULL, NULL, NULL, '0');

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
) ENGINE = MyISAM AUTO_INCREMENT = 827 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_menu
-- ----------------------------
INSERT INTO `cd_menu` VALUES (12, 0, 'Sys', '系统管理', '', '', 0, 1, 793, 0, 0, '', 'fa fa-gears', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (17, 12, '', '后台首页', '', '', 0, 1, 2, 0, 1, '/admin/Index/main.html', 'fa fa-home', '', 1, 0);
INSERT INTO `cd_menu` VALUES (18, 12, 'User', '用户管理', 'user_id', 'user', 1, 1, 4, 1, 0, '', 'fa fa-user-secret', '', 1, 0);
INSERT INTO `cd_menu` VALUES (19, 12, 'Group', '分组管理', 'group_id', 'group', 1, 1, 5, 1, 0, '', 'fa fa-user', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (21, 12, '', '菜单管理', '', '', 0, 0, 3, 0, 1, '/admin/Menu/index?app_id=1', '', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (41, 12, 'Config', '系统配置', '', '', 1, 1, 7, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|门禁配置|隐私政策|服务协议', 1, 0);
INSERT INTO `cd_menu` VALUES (52, 12, 'Log', '登录日志', 'log_id', 'log', 1, 1, 6, 1, 0, '', 'glyphicon glyphicon-log-in', '', 1, NULL);
INSERT INTO `cd_menu` VALUES (80, 12, 'Application', '应用管理', '', '', 0, 0, 1, 0, 0, '', '', '', 1, NULL);
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
INSERT INTO `cd_menu` VALUES (816, 0, 'Config', '系统配置', '', '', 1, 1, 7, 0, 0, '', 'glyphicon glyphicon-cog', '基本设置|上传配置|微门禁配置', 179, 0);
INSERT INTO `cd_menu` VALUES (817, 0, '', '健康登记', '', '', 0, 1, 818, 0, NULL, '', 'fa fa-heartbeat', '', 1, 0);
INSERT INTO `cd_menu` VALUES (818, 808, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 818, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (819, 0, 'Locktimes', '开门时段', 'locktimes_id', 'locktimes', 1, 0, 824, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (824, 808, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 824, 1, NULL, '', '', '', 1, 0);
INSERT INTO `cd_menu` VALUES (825, 0, 'LockCard', '卡管理', 'lockcard_id', 'lockcard', 1, 0, 826, 0, NULL, '', '', '', 179, 0);
INSERT INTO `cd_menu` VALUES (826, 0, 'Umember', '用户管理', 'umember_id', 'umember', 1, 1, 808, 1, NULL, '', 'fa fa-user', '', 1, 0);

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  `user_id` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员ID',
  `status` smallint(6) NULL DEFAULT NULL COMMENT '状态',
  `ucreate_time` int(11) NULL DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`umember_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
) ENGINE = MyISAM AUTO_INCREMENT = 102 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cd_user
-- ----------------------------
INSERT INTO `cd_user` VALUES (100, 'AJ', 'spr_77', 'e821032e0f2bee0db5f4770fbc7f76d0', 1, 1, '', 1, 1624348735, NULL);
INSERT INTO `cd_user` VALUES (98, '管理员', 'admin', '305afeb46a6aa7bca43880dcb29d634d', 1, 1, '', 1, 1599545031, NULL);
INSERT INTO `cd_user` VALUES (101, '测试1', '测试1', 'b96f037ce426b1f0c987164be5305cd3', 7, 2, '', 1, 1624951027, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of cd_wservice
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
