CREATE TABLE `yifelegal`.`tbl_classified` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(128) NOT NULL,
  `image` VARCHAR(255) NULL,
  `profile` INT NULL,
  `count` INT NULL,
  `price` DOUBLE NULL,
  `active` INT DEFAULT 0,
  `live` INT DEFAULT 0,
  `create_id` INT NULL,
  `create_date` DATETIME NULL,
  `update_date` DATETIME NULL,
  `cat_lvl_1` INT NULL,
  `cat_lvl_2` INT NULL,
  `cat_lvl_3` INT NULL ,

  PRIMARY KEY (`id`)
  );


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
) ;

CREATE TABLE `tbl_classifiedsprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classified_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `condition` tinyint(4) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `negotiable` tinyint(4) DEFAULT '0',
  `broker` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classifieds_fk` (`classified_id`),
  CONSTRAINT `classifieds_fk` FOREIGN KEY (`classified_id`) REFERENCES `tbl_classified` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `tbl_cat_lvl_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE `tbl_cat_lvl_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cat_lvl_1_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classlevelone` (`cat_lvl_1_id`),
  CONSTRAINT `classlevelone` FOREIGN KEY (`cat_lvl_1_id`) REFERENCES `tbl_cat_lvl_1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `tbl_cat_lvl_3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cat_lvl_1_id` int(11) DEFAULT NULL,
  `cat_lvl_2_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classlevelone` (`cat_lvl_1_id`) USING BTREE,
  KEY `classlevelthree_fk_to_level2` (`cat_lvl_2_id`),
  CONSTRAINT `classlevelthree_fk_to_level1` FOREIGN KEY (`cat_lvl_1_id`) REFERENCES `tbl_cat_lvl_1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `classlevelthree_fk_to_level2` FOREIGN KEY (`cat_lvl_2_id`) REFERENCES `tbl_cat_lvl_2` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ;

CREATE TABLE `yifelegal`.`tbl_classifiedimage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `classified_id` INT NULL,
  `variable` VARCHAR(255) NULL,
  `active` INT NULL DEFAULT 0,
  `create_date` DATETIME NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `yifelegal`.`tbl_viewcount` (
  `id` INT NOT NULL,
  `classified_id` INT NULL,
  `count` INT NULL,
  `variable` BLOB NULL,
  `update_date` DATETIME NULL,
  PRIMARY KEY (`id`));
