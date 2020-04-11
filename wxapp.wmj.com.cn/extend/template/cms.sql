/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : cmsext

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-08-24 15:45:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cd_catagory`
-- ----------------------------
CREATE TABLE `cd_catagory` (
  `class_id` int(10) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(250) DEFAULT NULL,
  `subtitle` varchar(250) DEFAULT NULL COMMENT '副标题',
  `type` tinyint(4) DEFAULT NULL,
  `list_tpl` varchar(250) DEFAULT NULL,
  `detail_tpl` varchar(250) DEFAULT NULL,
  `pic` varchar(250) DEFAULT NULL,
  `keyword` varchar(250) DEFAULT NULL,
  `description` text,
  `jumpurl` varchar(250) DEFAULT NULL,
  `sortid` int(9) DEFAULT NULL,
  `pid` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(32) DEFAULT NULL COMMENT '生成文件名',
  `module_id` smallint(5) DEFAULT NULL,
  `upload_config_id` int(9) DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `class_id` (`class_id`),
  KEY `class_name` (`class_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cd_catagory
-- ----------------------------

-- ----------------------------
-- Table structure for `cd_content`
-- ----------------------------
CREATE TABLE `cd_content` (
  `content_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `class_id` tinyint(4) DEFAULT NULL,
  `pic` varchar(250) DEFAULT NULL,
  `detail` text,
  `status` tinyint(4) DEFAULT NULL,
  `position` varchar(250) DEFAULT NULL,
  `jumpurl` varchar(250) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL,
  `keyword` varchar(250) DEFAULT NULL,
  `description` text,
  `views` varchar(250) DEFAULT '1',
  `sortid` varchar(250) DEFAULT NULL,
  `author` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`content_id`),
  KEY `title` (`title`),
  KEY `class_id` (`class_id`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cd_content
-- ----------------------------

-- ----------------------------
-- Table structure for `cd_frament`
-- ----------------------------
CREATE TABLE `cd_frament` (
  `frament_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `pic` varchar(250) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`frament_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cd_frament
-- ----------------------------

-- ----------------------------
-- Table structure for `cd_position`
-- ----------------------------
CREATE TABLE `cd_position` (
  `position_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `sortid` int(10) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cd_position
-- ----------------------------
