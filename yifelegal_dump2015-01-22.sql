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
INSERT INTO `tbl_cat_lvl_1` VALUES (1,'Baby Items',NULL,0),(2,'Books',NULL,1),(3,'Business & Industrial',NULL,1),(4,'Cameras & Imaging',NULL,1),(5,'Clothing & Accessories',NULL,1),(6,'Collectibles',NULL,1),(7,'Computers & Networking',NULL,1),(8,'DVDs & Movies',NULL,1),(9,'Electronics',NULL,1),(10,'Furniture, Home & Garden',NULL,1),(11,'Gaming',NULL,1),(12,'Home Appliances',NULL,1),(13,'Jewelry & Watches',NULL,1),(14,'Misc',NULL,1),(15,'Mobile Phones & PDAs',NULL,1),(16,'Music',NULL,1),(17,'Musical Instruments',NULL,1),(18,'Pets',NULL,1),(19,'Sports Equipment',NULL,1),(20,'Stuff Wanted',NULL,1),(21,'Tickets & Vouchers',NULL,1),(22,'Toys',NULL,1);
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
  CONSTRAINT `classlevelone` FOREIGN KEY (`cat_lvl_1_id`) REFERENCES `tbl_cat_lvl_1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cat_lvl_2`
--

LOCK TABLES `tbl_cat_lvl_2` WRITE;
/*!40000 ALTER TABLE `tbl_cat_lvl_2` DISABLE KEYS */;
INSERT INTO `tbl_cat_lvl_2` VALUES (1,'Fiction',2,1),(2,'Hardware',7,0);
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
  CONSTRAINT `classlevelthree_fk_to_level1` FOREIGN KEY (`cat_lvl_1_id`) REFERENCES `tbl_cat_lvl_1` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `classlevelthree_fk_to_level2` FOREIGN KEY (`cat_lvl_2_id`) REFERENCES `tbl_cat_lvl_2` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cat_lvl_3`
--

LOCK TABLES `tbl_cat_lvl_3` WRITE;
/*!40000 ALTER TABLE `tbl_cat_lvl_3` DISABLE KEYS */;
INSERT INTO `tbl_cat_lvl_3` VALUES (1,'Craphics Card',7,2,0),(2,'romance',2,1,0),(3,'fantasy sci fi',2,1,0),(4,'fantasy sci fi',2,1,0),(5,'fantasy sci fi',2,1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_classified`
--

LOCK TABLES `tbl_classified` WRITE;
/*!40000 ALTER TABLE `tbl_classified` DISABLE KEYS */;
INSERT INTO `tbl_classified` VALUES (1,'fikir eske mekabir',NULL,NULL,NULL,30,'569337295',0,0,NULL,NULL,NULL,2,1,NULL);
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
  `variable` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_classifiedimage`
--

LOCK TABLES `tbl_classifiedimage` WRITE;
/*!40000 ALTER TABLE `tbl_classifiedimage` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_classifiedsprofile`
--

LOCK TABLES `tbl_classifiedsprofile` WRITE;
/*!40000 ALTER TABLE `tbl_classifiedsprofile` DISABLE KEYS */;
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

-- Dump completed on 2015-01-22 17:26:58
