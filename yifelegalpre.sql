/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50617
Source Host           : 127.1.1.1:3306
Source Database       : yifelegal

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2014-08-02 23:05:01
*/

SET FOREIGN_KEY_CHECKS=0;
drop database if exists `yifelegal`;
CREATE DATABASE yifelegal;
use yifelegal;
-- ----------------------------
-- Table structure for `tbl_classified`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_classified`;
CREATE TABLE `tbl_classified` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `classlevelone_id` int(11) DEFAULT NULL,
  `classleveltwo_id` int(11) DEFAULT NULL,
  `classlevelthree_id` int(11) DEFAULT NULL,
  `description` blob,
  `price` int(11) NOT NULL,
  `primary_image` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_classified
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_classifiedimages`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_classifiedimages`;
CREATE TABLE `tbl_classifiedimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `classifieds_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classifieds_image_fk` (`classifieds_id`),
  CONSTRAINT `classifieds_image_fk` FOREIGN KEY (`classifieds_id`) REFERENCES `tbl_classified` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_classifiedimages
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_classifiedsprofile`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_classifiedsprofile`;
CREATE TABLE `tbl_classifiedsprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classified_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `condition` tinyint(4) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `negotiable` tinyint(4) DEFAULT NULL,
  `broker` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classifieds_fk` (`classified_id`),
  CONSTRAINT `classifieds_fk` FOREIGN KEY (`classified_id`) REFERENCES `tbl_classified` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_classifiedsprofile
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_classlevelone`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_classlevelone`;
CREATE TABLE `tbl_classlevelone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_classlevelone
-- ----------------------------
INSERT INTO `tbl_classlevelone` VALUES ('1', 'Baby products');
INSERT INTO `tbl_classlevelone` VALUES ('2', 'Books');
INSERT INTO `tbl_classlevelone` VALUES ('3', 'Computers and Tablets');
INSERT INTO `tbl_classlevelone` VALUES ('4', 'Cosmeics');
INSERT INTO `tbl_classlevelone` VALUES ('5', 'Electronics');
INSERT INTO `tbl_classlevelone` VALUES ('6', 'Entertainment');
INSERT INTO `tbl_classlevelone` VALUES ('7', 'Fashion');
INSERT INTO `tbl_classlevelone` VALUES ('8', 'Furniture');
INSERT INTO `tbl_classlevelone` VALUES ('9', 'Home appliances');
INSERT INTO `tbl_classlevelone` VALUES ('10', 'Musical instruments');
INSERT INTO `tbl_classlevelone` VALUES ('11', 'Other');
INSERT INTO `tbl_classlevelone` VALUES ('12', 'Services');
INSERT INTO `tbl_classlevelone` VALUES ('13', 'Sports equipments and supplies');
INSERT INTO `tbl_classlevelone` VALUES ('14', 'Toys');

-- ----------------------------
-- Table structure for `tbl_classlevelthree`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_classlevelthree`;
CREATE TABLE `tbl_classlevelthree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `class_level_one_id` int(11) DEFAULT NULL,
  `class_level_two_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classlevelone` (`class_level_one_id`) USING BTREE,
  KEY `classlevelthree_fk_to_level2` (`class_level_two_id`),
  CONSTRAINT `classlevelthree_fk_to_level1` FOREIGN KEY (`class_level_one_id`) REFERENCES `tbl_classlevelone` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `classlevelthree_fk_to_level2` FOREIGN KEY (`class_level_two_id`) REFERENCES `tbl_classleveltwo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_classlevelthree
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_classleveltwo`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_classleveltwo`;
CREATE TABLE `tbl_classleveltwo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `class_level_one_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classlevelone` (`class_level_one_id`),
  CONSTRAINT `classlevelone` FOREIGN KEY (`class_level_one_id`) REFERENCES `tbl_classlevelone` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_classleveltwo
-- ----------------------------
INSERT INTO `tbl_classleveltwo` VALUES ('1', 'Tablet', '3');
INSERT INTO `tbl_classleveltwo` VALUES ('2', 'Fiction', '2');

-- ----------------------------
-- Table structure for `tbl_queue`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_queue`;
CREATE TABLE `tbl_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `variables` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_queue
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_systemlog`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_systemlog`;
CREATE TABLE `tbl_systemlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remoteip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_url` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci,
  `crud_flag` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_attr` varchar(128) COLLATE utf8_unicode_ci DEFAULT '',
  `model_id` int(11) DEFAULT NULL,
  `dataobject` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_systemlog
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `firstname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` tinyint(4) DEFAULT NULL,
  `confirmed` tinyint(4) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('25', null, null, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@biggilab.com', '0', '0', '2014-08-02 03:05:54');
