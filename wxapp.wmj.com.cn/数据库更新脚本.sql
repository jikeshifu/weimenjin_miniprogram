SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `miniprogram`.`cd_electricity`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `electricity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` bigint(20) NULL DEFAULT NULL,
  `device_sn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

CREATE TABLE `miniprogram`.`cd_face`  (
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
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

CREATE TABLE `miniprogram`.`cd_finger`  (
  `finger_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fp_id` int(8) NULL DEFAULT NULL COMMENT '指纹id',
  `finger_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '指纹名称',
  `created_at` bigint(255) NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`finger_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `device_cid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '设备cid' AFTER `opsucnt`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `admin_pwd` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '激活的管理密码' AFTER `device_cid`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `hw_ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `admin_pwd`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `sw_ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `hw_ver`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `wifi_rssi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `sw_ver`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `on_line_time` int(11) NULL DEFAULT NULL AFTER `wifi_rssi`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `model_number` varchar(101) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `on_line_time`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `hardware_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `model_number`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `firmware_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `hardware_version`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `iccid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `firmware_version`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `imei` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `iccid`;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `batterypower` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `imei`;

ALTER TABLE `miniprogram`.`cd_lock` ADD UNIQUE INDEX `lock_id`(`lock_id`) USING BTREE;

ALTER TABLE `miniprogram`.`cd_lockauth` ADD COLUMN `aremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' AFTER `auth_shareability`;

ALTER TABLE `miniprogram`.`cd_lockauth` ADD COLUMN `arealname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名' AFTER `user_id`;

ALTER TABLE `miniprogram`.`cd_lockauth` DROP COLUMN `remark`;

ALTER TABLE `miniprogram`.`cd_lockauth` DROP COLUMN `realname`;

ALTER TABLE `miniprogram`.`cd_lockcard` ADD INDEX `lockcard_sn`(`lockcard_sn`) USING BTREE;

ALTER TABLE `miniprogram`.`cd_locklog` ADD COLUMN `lremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注' AFTER `user_id`;

ALTER TABLE `miniprogram`.`cd_locklog` ADD COLUMN `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作人' AFTER `cardsn`;

ALTER TABLE `miniprogram`.`cd_locklog` MODIFY COLUMN `user_id` bigint(10) NULL DEFAULT NULL COMMENT '管理员ID' AFTER `create_time`;

ALTER TABLE `miniprogram`.`cd_locklog` DROP COLUMN `remark`;

ALTER TABLE `miniprogram`.`cd_locklog` ADD UNIQUE INDEX `idx_locklog_id`(`locklog_id`) USING BTREE;

ALTER TABLE `miniprogram`.`cd_locklog` ADD INDEX `lock_id`(`lock_id`) USING BTREE;

ALTER TABLE `miniprogram`.`cd_locklog` ADD INDEX `member_id`(`member_id`) USING BTREE;

CREATE TABLE `miniprogram`.`cd_log_ts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

ALTER TABLE `miniprogram`.`cd_member` ADD COLUMN `sCertificateNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸faceid' AFTER `remark`;

ALTER TABLE `miniprogram`.`cd_member` MODIFY COLUMN `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '呢称' AFTER `member_id`;

ALTER TABLE `miniprogram`.`cd_member` MODIFY COLUMN `openid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'openid' AFTER `headimgurl`;

ALTER TABLE `miniprogram`.`cd_member` MODIFY COLUMN `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机号' AFTER `openid`;

ALTER TABLE `miniprogram`.`cd_member` MODIFY COLUMN `user_id` int(10) NULL DEFAULT NULL COMMENT '所属用户' AFTER `status`;

ALTER TABLE `miniprogram`.`cd_member` MODIFY COLUMN `ali_user_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝用户id' AFTER `user_id`;

ALTER TABLE `miniprogram`.`cd_member` MODIFY COLUMN `unionid` char(28) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'unionid' AFTER `member_ps`;

ALTER TABLE `miniprogram`.`cd_member` ADD INDEX `idx_unionid`(`unionid`) USING BTREE;

CREATE TABLE `miniprogram`.`cd_on_line_record`  (
  `on_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `on_line_time` bigint(20) NULL DEFAULT NULL,
  `device_sn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`on_line_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

CREATE TABLE `miniprogram`.`cd_pwd`  (
  `pwd_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pwd` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `pwd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码名称',
  `created_at` int(255) NULL DEFAULT NULL COMMENT '添加时间',
  `deleted_at` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `lock_id` int(11) NULL DEFAULT NULL COMMENT '所属设备',
  `end_time` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`pwd_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

ALTER TABLE `miniprogram`.`cd_umember` ADD COLUMN `urealname` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名' AFTER `ucreate_time`;

ALTER TABLE `miniprogram`.`cd_umember` ADD COLUMN `authlocks` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权锁' AFTER `urealname`;

ALTER TABLE `miniprogram`.`cd_umember` ADD COLUMN `uremark` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' AFTER `authlocks`;

ALTER TABLE `miniprogram`.`cd_umember` MODIFY COLUMN `user_id` bigint(10) NULL DEFAULT NULL COMMENT '管理员ID' AFTER `member_id`;

ALTER TABLE `miniprogram`.`cd_umember` DROP COLUMN `realname`;

ALTER TABLE `miniprogram`.`cd_umember` ADD INDEX `idx_member_id_user_id`(`member_id`, `user_id`) USING BTREE;

SET FOREIGN_KEY_CHECKS=1;