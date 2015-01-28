-- MySQL dump 10.13  Distrib 5.6.21, for osx10.8 (x86_64)
--
-- Host: localhost    Database: yifelegal
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_cat_lvl_1`
--

DROP TABLE IF EXISTS `tbl_cat_lvl_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cat_lvl_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `tbl_cat_lvl_1col` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cat_lvl_1`
--

LOCK TABLES `tbl_cat_lvl_1` WRITE;
/*!40000 ALTER TABLE `tbl_cat_lvl_1` DISABLE KEYS */;
INSERT INTO `tbl_cat_lvl_1` VALUES (1,'Baby Items',NULL,1),(2,'Books',NULL,1),(3,'Business & Industrial',NULL,1),(4,'Cameras & Imaging',NULL,1),(5,'Clothing & Accessories',NULL,1),(6,'Collectibles',NULL,1),(7,'Computers & Networking',NULL,1),(8,'DVDs & Movies',NULL,1),(9,'Electronics',NULL,1),(10,'Furniture, Home & Garden',NULL,1),(11,'Gaming',NULL,1),(12,'Home Appliances',NULL,1),(13,'Jewelry & Watches',NULL,1),(14,'Misc',NULL,1),(15,'Mobile Phones & PDAs',NULL,1),(16,'Music',NULL,1),(17,'Musical Instruments',NULL,1),(18,'Pets',NULL,1),(19,'Sports Equipment',NULL,1),(20,'Stuff Wanted',NULL,1),(21,'Tickets & Vouchers',NULL,1),(22,'Toys',NULL,1);
/*!40000 ALTER TABLE `tbl_cat_lvl_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cat_lvl_2`
--

DROP TABLE IF EXISTS `tbl_cat_lvl_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cat_lvl_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_lvl_1_id` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `classlevelone` (`cat_lvl_1_id`),
  CONSTRAINT `classlevelone` FOREIGN KEY (`cat_lvl_1_id`) REFERENCES `tbl_cat_lvl_1` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cat_lvl_2`
--

LOCK TABLES `tbl_cat_lvl_2` WRITE;
/*!40000 ALTER TABLE `tbl_cat_lvl_2` DISABLE KEYS */;
INSERT INTO `tbl_cat_lvl_2` VALUES (1,'Fiction',2,1),(20,'fadff',1,0);
/*!40000 ALTER TABLE `tbl_cat_lvl_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cat_lvl_3`
--

DROP TABLE IF EXISTS `tbl_cat_lvl_3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cat_lvl_3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_lvl_1_id` int(11) DEFAULT NULL,
  `cat_lvl_2_id` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `classlevelone` (`cat_lvl_1_id`) USING BTREE,
  KEY `classlevelthree_fk_to_level2` (`cat_lvl_2_id`),
  CONSTRAINT `classlevelthree_fk_to_level1` FOREIGN KEY (`cat_lvl_1_id`) REFERENCES `tbl_cat_lvl_1` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `classlevelthree_fk_to_level2` FOREIGN KEY (`cat_lvl_2_id`) REFERENCES `tbl_cat_lvl_2` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cat_lvl_3`
--

LOCK TABLES `tbl_cat_lvl_3` WRITE;
/*!40000 ALTER TABLE `tbl_cat_lvl_3` DISABLE KEYS */;
INSERT INTO `tbl_cat_lvl_3` VALUES (1,'Craphics Card',7,2,0),(2,'romance',2,1,0),(3,'fantasy sci fi',2,1,0),(44,'rew',2,1,0),(45,'fad',2,1,0),(46,'dasad',2,1,0);
/*!40000 ALTER TABLE `tbl_cat_lvl_3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_classified`
--

DROP TABLE IF EXISTS `tbl_classified`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_classified` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `profile` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `phone` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `live` int(11) DEFAULT '0',
  `create_id` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `cat_lvl_1` int(11) DEFAULT NULL,
  `cat_lvl_2` int(11) DEFAULT NULL,
  `cat_lvl_3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_classified`
--

LOCK TABLES `tbl_classified` WRITE;
/*!40000 ALTER TABLE `tbl_classified` DISABLE KEYS */;
INSERT INTO `tbl_classified` VALUES (1,'fikir eske mekabir',NULL,NULL,NULL,30,'569337295',0,0,NULL,NULL,NULL,2,1,NULL),(2,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,6),(3,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,7),(4,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,8),(5,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,9),(6,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,10),(7,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,11),(8,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,12),(9,'robocop',NULL,9,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,13),(10,'robocop',NULL,1,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,14),(11,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,15),(12,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,16),(13,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,17),(14,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,18),(15,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,19),(16,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,20),(17,'robocop',NULL,2,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,21),(18,'robocop',NULL,3,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,22),(19,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,23),(20,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,24),(21,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,25),(22,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,26),(23,'robocop',NULL,4,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,27),(24,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,28),(25,'robocop',NULL,5,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,29),(26,'robocop',NULL,6,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,30),(27,'robocop',NULL,7,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,31),(28,'robocop',NULL,8,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,32),(29,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,33),(30,'robocop',NULL,9,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,34),(31,'robocop',NULL,10,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,35),(32,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,36),(33,'robocop',NULL,11,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,37),(34,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,38),(35,'robocop',NULL,NULL,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,39),(36,'robocop',NULL,12,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,40),(37,'robocop',NULL,13,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,41),(38,'robocop',NULL,14,NULL,42342,'971569337295',0,0,NULL,NULL,NULL,2,1,42),(39,'dasd',NULL,15,NULL,456,'452353',0,0,NULL,NULL,NULL,1,3,NULL),(40,'dasd',NULL,16,NULL,456,'452353',0,0,NULL,NULL,NULL,1,4,NULL),(41,'asdf',NULL,18,NULL,4324,'234',0,0,NULL,NULL,NULL,1,5,NULL),(42,'fadds',NULL,19,NULL,34343,'343',0,0,NULL,NULL,NULL,2,6,NULL),(43,'dada',NULL,20,NULL,2443,'32444',0,0,NULL,NULL,NULL,7,7,NULL),(44,'dasdada',NULL,21,NULL,34234,'324',0,0,NULL,NULL,NULL,10,8,NULL),(45,'dasdada',NULL,22,NULL,34234,'324',0,0,NULL,NULL,NULL,10,9,NULL),(46,'da',NULL,23,NULL,321,'2311',0,0,NULL,NULL,NULL,3,10,NULL),(47,'wqeeqw',NULL,24,NULL,1312,'234',0,0,NULL,NULL,NULL,3,11,NULL),(48,'dasd',NULL,27,NULL,423,'2343424',0,0,NULL,NULL,NULL,4,12,NULL),(49,'rwerr',NULL,28,NULL,455,'454',0,0,NULL,NULL,NULL,3,13,NULL),(50,'afsd',NULL,29,NULL,54235,'432523',0,0,NULL,NULL,NULL,5,14,NULL),(51,'afsd',NULL,30,NULL,54235,'432523',0,0,NULL,NULL,NULL,5,15,NULL),(52,'adsd',NULL,31,NULL,432,'345',0,0,NULL,NULL,NULL,5,16,NULL),(53,'rewq',NULL,48,NULL,3423,'3241',0,0,NULL,NULL,NULL,2,1,44),(54,'fsadf',NULL,49,NULL,234,'52345245',0,0,NULL,NULL,NULL,1,20,NULL),(55,'dafsdf',NULL,50,NULL,432,'2431',0,0,NULL,NULL,NULL,2,1,45),(56,'dass',NULL,51,NULL,4242,'24343',0,0,NULL,NULL,NULL,2,1,46);
/*!40000 ALTER TABLE `tbl_classified` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_classifiedimage`
--

DROP TABLE IF EXISTS `tbl_classifiedimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_classifiedimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classified_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `variable` text COLLATE utf8_bin,
  `active` int(11) DEFAULT '0',
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_classifiedimage`
--

LOCK TABLES `tbl_classifiedimage` WRITE;
/*!40000 ALTER TABLE `tbl_classifiedimage` DISABLE KEYS */;
INSERT INTO `tbl_classifiedimage` VALUES (1,56,'7ad13539.jpg','O:3:\"Img\":16:{s:10:\"classLabel\";s:3:\"Img\";s:8:\"filepath\";s:61:\"/Library/WebServer/Documents/yifelegal/images/classifieds/56/\";s:8:\"filename\";s:12:\"7ad13539.jpg\";s:5:\"width\";i:2544;s:6:\"height\";i:1696;s:9:\"new_width\";N;s:10:\"new_height\";N;s:13:\"originalimage\";s:73:\"/Library/WebServer/Documents/yifelegal/images/classifieds/56/7ad13539.jpg\";s:5:\"error\";N;s:18:\"thumb_resize_width\";i:200;s:19:\"thumb_resize_height\";i:133;s:15:\"\0CModel\0_errors\";a:0:{}s:19:\"\0CModel\0_validators\";N;s:17:\"\0CModel\0_scenario\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}',0,NULL),(2,56,'c99a90bd.jpg','O:3:\"Img\":16:{s:10:\"classLabel\";s:3:\"Img\";s:8:\"filepath\";s:61:\"/Library/WebServer/Documents/yifelegal/images/classifieds/56/\";s:8:\"filename\";s:12:\"c99a90bd.jpg\";s:5:\"width\";i:2544;s:6:\"height\";i:1696;s:9:\"new_width\";N;s:10:\"new_height\";N;s:13:\"originalimage\";s:73:\"/Library/WebServer/Documents/yifelegal/images/classifieds/56/c99a90bd.jpg\";s:5:\"error\";N;s:18:\"thumb_resize_width\";i:200;s:19:\"thumb_resize_height\";i:133;s:15:\"\0CModel\0_errors\";a:0:{}s:19:\"\0CModel\0_validators\";N;s:17:\"\0CModel\0_scenario\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}',0,NULL);
/*!40000 ALTER TABLE `tbl_classifiedimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_classifiedsprofile`
--

DROP TABLE IF EXISTS `tbl_classifiedsprofile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_classifiedsprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classified_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `condition` tinyint(4) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `negotiable` tinyint(4) DEFAULT '0',
  `broker` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classifieds_fk` (`classified_id`),
  CONSTRAINT `classifieds_fk` FOREIGN KEY (`classified_id`) REFERENCES `tbl_classified` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_classifiedsprofile`
--

LOCK TABLES `tbl_classifiedsprofile` WRITE;
/*!40000 ALTER TABLE `tbl_classifiedsprofile` DISABLE KEYS */;
INSERT INTO `tbl_classifiedsprofile` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(2,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(3,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(4,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(5,NULL,NULL,'','',NULL,NULL,0,NULL),(6,NULL,NULL,'','',NULL,NULL,0,NULL),(7,27,NULL,'','',NULL,NULL,0,NULL),(8,28,NULL,'','',NULL,NULL,0,NULL),(9,30,NULL,'','',NULL,NULL,0,NULL),(10,31,'dasda','','',NULL,NULL,0,NULL),(11,33,'dasda','','',NULL,NULL,0,NULL),(12,36,'dasda','','',NULL,NULL,0,NULL),(13,37,'dasda','','',NULL,NULL,1,0),(14,38,'dasda','','',NULL,NULL,1,0),(15,39,'fsdsfa','','',NULL,NULL,0,0),(16,40,'fsdsfa','','',NULL,NULL,0,0),(17,NULL,'fsf','','',NULL,NULL,0,0),(18,41,'fsa','','',NULL,NULL,0,0),(19,42,'asd','','',NULL,NULL,0,0),(20,43,'wqewqewq','','',NULL,NULL,0,0),(21,44,'fdsff','','',NULL,NULL,0,0),(22,45,'fdsff','','',NULL,NULL,0,0),(23,46,'qweqe','','',NULL,NULL,0,0),(24,47,'asdsad','','',NULL,NULL,0,0),(25,NULL,'dasd','','',NULL,NULL,0,0),(26,NULL,'das','','',NULL,NULL,0,0),(27,48,'423423','','',NULL,NULL,0,0),(28,49,'werer','','',NULL,NULL,0,0),(29,50,'fasdf','','',NULL,NULL,0,0),(30,51,'fasdf','','',NULL,NULL,0,0),(31,52,'sadsd','','',NULL,NULL,0,0),(32,NULL,'','','',NULL,NULL,0,0),(33,NULL,'','','',NULL,NULL,0,0),(34,NULL,'','','',NULL,NULL,0,0),(35,NULL,'','','',NULL,NULL,0,0),(36,NULL,'','','',NULL,NULL,0,0),(37,NULL,'','','',NULL,NULL,0,0),(38,NULL,'','','',NULL,NULL,0,0),(39,NULL,'','','',NULL,NULL,0,0),(40,NULL,'','','',NULL,NULL,0,0),(41,NULL,'','','',NULL,NULL,0,0),(42,NULL,'','','',NULL,NULL,0,0),(43,NULL,'','','',NULL,NULL,0,0),(44,NULL,'','','',NULL,NULL,0,0),(45,NULL,'','','',NULL,NULL,0,0),(46,NULL,'','','',NULL,NULL,0,0),(47,NULL,'','','',NULL,NULL,0,0),(48,53,'41341fdsa','','',NULL,NULL,0,0),(49,54,'fasd','','',NULL,NULL,0,0),(50,55,'fafdfas','','',NULL,NULL,0,0),(51,56,'asda','','',NULL,NULL,0,0);
/*!40000 ALTER TABLE `tbl_classifiedsprofile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `firstname` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usertype` tinyint(4) DEFAULT NULL,
  `confirmed` tinyint(4) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_viewcount`
--

DROP TABLE IF EXISTS `tbl_viewcount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_viewcount` (
  `id` int(11) NOT NULL,
  `classified_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `variable` blob,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_viewcount`
--

LOCK TABLES `tbl_viewcount` WRITE;
/*!40000 ALTER TABLE `tbl_viewcount` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_viewcount` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-28 16:04:42
