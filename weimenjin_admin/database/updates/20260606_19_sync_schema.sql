SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Fix long TTS content for cloud speaker broadcasts.
ALTER TABLE `cd_lock` MODIFY COLUMN `openttscontent` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

-- Sync cd_cam_remote_control
CREATE TABLE IF NOT EXISTS `cd_cam_remote_control`  (
  `control_id` int NOT NULL AUTO_INCREMENT,
  `device_sn` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_id` int NULL DEFAULT NULL,
  `open` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `close` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `stop` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `customize` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` int NULL DEFAULT NULL,
  `deleted_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`control_id`) USING BTREE,
  INDEX `device_sn`(`device_sn`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- Sync cd_horn_broadcast_history
CREATE TABLE IF NOT EXISTS `cd_horn_broadcast_history` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lock_id` INT(11) NOT NULL,
  `member_id` INT(11) DEFAULT NULL,
  `content` TEXT NOT NULL,
  `volume` INT(3) DEFAULT 5,
  `speed` INT(3) DEFAULT 5,
  `tone` INT(3) DEFAULT 5,
  `loop_enabled` TINYINT(1) DEFAULT 0,
  `loop_interval` INT(11) DEFAULT 0,
  `created_at` INT(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_lock_id` (`lock_id`) USING BTREE,
  INDEX `idx_created_at` (`created_at`) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sync cd_areas
CREATE TABLE IF NOT EXISTS `cd_areas` (
  `area_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `area_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `area_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `district` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `manager_id` int(11) NULL DEFAULT NULL,
  `contact_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `deleted_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`area_id`) USING BTREE,
  UNIQUE INDEX `uk_area_code`(`area_code`) USING BTREE,
  INDEX `idx_manager_id`(`manager_id`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- Sync cd_buildings
CREATE TABLE IF NOT EXISTS `cd_buildings` (
  `building_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `area_id` int(11) NOT NULL,
  `building_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `building_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `floors` int(11) NULL DEFAULT NULL,
  `unit_count` int(11) NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `deleted_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`building_id`) USING BTREE,
  UNIQUE INDEX `uk_area_building`(`area_id`, `building_code`) USING BTREE,
  INDEX `idx_area_id`(`area_id`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- Sync cd_units
CREATE TABLE IF NOT EXISTS `cd_units` (
  `unit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `building_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `unit_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unit_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `floors` int(11) NULL DEFAULT NULL,
  `room_count` int(11) NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `deleted_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`unit_id`) USING BTREE,
  UNIQUE INDEX `uk_building_unit`(`building_id`, `unit_code`) USING BTREE,
  INDEX `idx_building_id`(`building_id`) USING BTREE,
  INDEX `idx_area_id`(`area_id`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- Sync cd_rooms
CREATE TABLE IF NOT EXISTS `cd_rooms` (
  `room_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `room_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `floor` int(11) NULL DEFAULT NULL,
  `room_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'residential',
  `area_size` decimal(10, 2) NULL DEFAULT NULL,
  `owner_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `owner_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `deleted_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`room_id`) USING BTREE,
  UNIQUE INDEX `uk_unit_room`(`unit_id`, `room_number`) USING BTREE,
  INDEX `idx_unit_id`(`unit_id`) USING BTREE,
  INDEX `idx_building_id`(`building_id`) USING BTREE,
  INDEX `idx_area_id`(`area_id`) USING BTREE,
  INDEX `idx_floor`(`floor`) USING BTREE,
  INDEX `idx_status`(`status`) USING BTREE,
  INDEX `idx_deleted_at`(`deleted_at`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- Sync cd_member_rooms
CREATE TABLE IF NOT EXISTS `cd_member_rooms` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `area_id` INT(11) NOT NULL,
  `building_id` INT(11) NOT NULL,
  `unit_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `relation_type` VARCHAR(20) DEFAULT 'owner',
  `is_primary` TINYINT(1) DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `create_time` INT(11) NOT NULL,
  `update_time` INT(11) DEFAULT NULL,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE,
  INDEX `idx_user_id` (`user_id`) USING BTREE,
  INDEX `idx_room_id` (`room_id`) USING BTREE,
  INDEX `idx_unit_id` (`unit_id`) USING BTREE,
  INDEX `idx_area_id` (`area_id`) USING BTREE,
  INDEX `idx_deleted_at` (`deleted_at`) USING BTREE,
  INDEX `idx_status` (`status`) USING BTREE,
  INDEX `idx_member_room` (`member_id`, `room_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sync cd_member_room_applications
CREATE TABLE IF NOT EXISTS `cd_member_room_applications` (
  `application_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `area_id` INT(11) NOT NULL,
  `building_id` INT(11) NOT NULL,
  `unit_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `room_number` VARCHAR(50) NOT NULL,
  `relation_type` VARCHAR(20) DEFAULT 'owner',
  `applicant_name` VARCHAR(50) NOT NULL,
  `applicant_phone` VARCHAR(20) NOT NULL,
  `status` TINYINT(1) DEFAULT 0,
  `audit_time` INT(11) DEFAULT NULL,
  `audit_user_id` INT(11) DEFAULT NULL,
  `audit_remark` VARCHAR(255) DEFAULT NULL,
  `create_time` INT(11) NOT NULL,
  `update_time` INT(11) DEFAULT NULL,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`application_id`) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE,
  INDEX `idx_user_id` (`user_id`) USING BTREE,
  INDEX `idx_room_id` (`room_id`) USING BTREE,
  INDEX `idx_status` (`status`) USING BTREE,
  INDEX `idx_create_time` (`create_time`) USING BTREE,
  INDEX `idx_deleted_at` (`deleted_at`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sync cd_member_push_tokens
CREATE TABLE IF NOT EXISTS `cd_member_push_tokens` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` INT(11) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `platform` VARCHAR(20) DEFAULT 'wechat',
  `device_id` VARCHAR(100) DEFAULT NULL,
  `status` TINYINT(1) DEFAULT 1,
  `create_time` INT(11) NOT NULL,
  `update_time` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_member_platform_token` (`member_id`, `platform`, `token`(150)) USING BTREE,
  INDEX `idx_member_id` (`member_id`) USING BTREE,
  INDEX `idx_status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;

UPDATE `cd_appconfig`
SET `value` = '["/admin/Login/Verify","/admin/Login/indexQrCode","/admin/Login/index","/admin/Index/index","/admin/Index/main","/admin/Login/out","/admin/Upload/editorUpload","/admin/Upload/uploadImages","/admin/Upload/uploadUeditor","/admin/Login/captcha","/admin/SystemUpdate/index","/admin/SystemUpdate/check","/admin/SystemUpdate/install","/admin/SystemUpdate/logs","/admin/SystemUpdate/databaseCheck","/admin/SystemUpdate/databaseRepair"]'
WHERE `module` = 'base'
  AND `name` = 'nocheck';
