SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `miniprogram`.`cd_lock` ADD COLUMN `openbtn` tinyint(4) NULL DEFAULT 1 COMMENT '开门按钮' AFTER `adnum`;

CREATE TABLE `miniprogram`.`cd_wservice`  (
  `wservice_id` int(11) NOT NULL AUTO_INCREMENT,
  `wservice_type` smallint(6) NULL DEFAULT NULL COMMENT '类型',
  `wservice_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `wservice_appid` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'appid',
  `wservice_url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'url',
  `wservice_icon` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `wservice_sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `wservice_status` tinyint(4) NULL DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`wservice_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS=1;