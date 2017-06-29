-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: mysql.registration.penguicon.org    Database: penguicon_2014_registration
-- ------------------------------------------------------
-- Server version	5.6.34-log

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
-- Current Database: `penguicon_2014_registration`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `penguicon_2014_registration` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `penguicon_2014_registration`;

--
-- Table structure for table `archive_items`
--

DROP TABLE IF EXISTS `archive_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_year` varchar(5) NOT NULL,
  `date` date NOT NULL,
  `qty` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `total_cost` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_year` varchar(5) NOT NULL,
  `order_number` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `badge_number` int(11) DEFAULT NULL,
  `badge_name` varchar(25) DEFAULT NULL,
  `extended_badgename` varchar(100) NOT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cost` decimal(5,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(5,2) DEFAULT NULL,
  `payment_id` int(11) NOT NULL,
  `email_reminder` varchar(25) DEFAULT NULL,
  `staff_confirmed_by` varchar(100) DEFAULT NULL,
  `has_panels` tinyint(4) NOT NULL,
  `panelist_name` varchar(40) NOT NULL,
  `panel_hours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=3740 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `current_badges`
--

DROP TABLE IF EXISTS `current_badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `current_badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_year` varchar(5) NOT NULL,
  `ordered_by` varchar(25) NOT NULL,
  `ordered_for` varchar(25) NOT NULL,
  `type` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `badge_number` int(11) NOT NULL,
  `badge_name` varchar(25) NOT NULL,
  `extended_badgename` varchar(100) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cost` decimal(5,2) NOT NULL,
  `email_reminder` varchar(5) NOT NULL,
  `staff_confirmed_by` varchar(50) NOT NULL,
  `locked` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `current_ribbons`
--

DROP TABLE IF EXISTS `current_ribbons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `current_ribbons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_year` varchar(5) NOT NULL,
  `ordered_by` varchar(25) NOT NULL,
  `ordered_for` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `ribbon_text` varchar(25) NOT NULL,
  `ribbon_text2` varchar(25) NOT NULL,
  `ribbon_color` varchar(25) NOT NULL,
  `ribbon_textcolor` varchar(25) NOT NULL,
  `email_reminder` varchar(5) NOT NULL,
  `ribbon_qty` int(11) NOT NULL,
  `cost` decimal(5,2) NOT NULL,
  `locked` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_orders`
--

DROP TABLE IF EXISTS `master_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(30) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `confirmation` varchar(10) DEFAULT NULL,
  `total_cost` decimal(7,2) DEFAULT NULL,
  `order_complete` varchar(10) DEFAULT NULL,
  `order_processed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2212 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(30) DEFAULT NULL,
  `item_type` varchar(15) DEFAULT NULL,
  `item_cost` decimal(5,2) DEFAULT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `lastname` varchar(25) DEFAULT NULL,
  `badgename` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `ribbon_text` varchar(25) DEFAULT NULL,
  `ribbon_text2` varchar(25) DEFAULT NULL,
  `ribbon_color` varchar(25) DEFAULT NULL,
  `ribbon_textcolor` varchar(25) DEFAULT NULL,
  `ribbon_image` varchar(25) DEFAULT NULL,
  `email_processed` varchar(25) DEFAULT NULL,
  `email_reminder` varchar(25) DEFAULT NULL,
  `ribbon_qty` int(11) DEFAULT NULL,
  `ribbon_font` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5170 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_details_archive`
--

DROP TABLE IF EXISTS `order_details_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(30) DEFAULT NULL,
  `item_type` varchar(15) DEFAULT NULL,
  `item_cost` decimal(5,2) DEFAULT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `lastname` varchar(25) DEFAULT NULL,
  `badgename` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `ribbon_text` varchar(25) DEFAULT NULL,
  `ribbon_text2` varchar(25) DEFAULT NULL,
  `ribbon_color` varchar(25) DEFAULT NULL,
  `ribbon_textcolor` varchar(25) DEFAULT NULL,
  `ribbon_image` varchar(25) DEFAULT NULL,
  `email_processed` varchar(25) DEFAULT NULL,
  `email_reminder` varchar(25) DEFAULT NULL,
  `ribbon_qty` int(11) DEFAULT NULL,
  `ribbon_font` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4397 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_errors`
--

DROP TABLE IF EXISTS `order_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(30) DEFAULT NULL,
  `error_type` varchar(10) DEFAULT NULL,
  `error_text` varchar(100) DEFAULT NULL,
  `error_field` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=618 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `other_charges`
--

DROP TABLE IF EXISTS `other_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `other_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(11) NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_year` varchar(5) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `payment_type` varchar(15) DEFAULT NULL,
  `transaction_id` varchar(25) NOT NULL,
  `payment_email` varchar(100) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amt` decimal(7,2) NOT NULL,
  `payment_note` varchar(50) NOT NULL,
  `payment_applied` decimal(7,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1993 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ribbons`
--

DROP TABLE IF EXISTS `ribbons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ribbons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_year` varchar(5) NOT NULL,
  `order_number` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `cost` decimal(5,2) DEFAULT NULL,
  `paid` decimal(5,2) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `ribbon_text` varchar(25) DEFAULT NULL,
  `ribbon_text2` varchar(25) DEFAULT NULL,
  `ribbon_color` varchar(25) DEFAULT NULL,
  `ribbon_textcolor` varchar(25) DEFAULT NULL,
  `ribbon_image` varchar(25) DEFAULT NULL,
  `email_processed` varchar(25) DEFAULT NULL,
  `email_reminder` varchar(25) DEFAULT NULL,
  `ribbon_qty` int(11) DEFAULT NULL,
  `vendor` varchar(50) NOT NULL,
  `ribbon_font` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=728 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_admin`
--

DROP TABLE IF EXISTS `users_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-25  8:48:00
