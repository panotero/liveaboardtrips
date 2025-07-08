-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: db_liveaboardtrips
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.24-MariaDB

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
-- Table structure for table `booking_details`
--

DROP TABLE IF EXISTS `booking_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_code` varchar(100) DEFAULT NULL,
  `cabin_id` int(11) NOT NULL,
  `guest_number` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `booking_table`
--

DROP TABLE IF EXISTS `booking_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_code` varchar(100) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `booking_details_id` int(11) NOT NULL,
  `trip_year` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL COMMENT '0 - New, 1 - Confired, 3 - Payment Verification, 4 - Paid',
  `booking_date` datetime NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `booking_userinfo`
--

DROP TABLE IF EXISTS `booking_userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_code` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` mediumtext NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` mediumtext DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `guest_list` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cabin_details`
--

DROP TABLE IF EXISTS `cabin_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabin_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cabin_name` varchar(100) NOT NULL,
  `cabin_description` varchar(100) NOT NULL,
  `cabin_thumbnail` varchar(100) DEFAULT NULL,
  `cabin_photos` varchar(100) DEFAULT NULL,
  `guest_capacity` varchar(100) NOT NULL,
  `bed_number` varchar(100) NOT NULL,
  `cabin_number` int(11) NOT NULL,
  `vessel_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cabin_table`
--

DROP TABLE IF EXISTS `cabin_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabin_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cabin_details_id` varchar(100) NOT NULL,
  `cabin_price` varchar(100) NOT NULL,
  `vessel_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `trip_year` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `surcharge_percentage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `destination_table`
--

DROP TABLE IF EXISTS `destination_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destination_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `destination_name` varchar(100) NOT NULL,
  `destination_country` varchar(100) NOT NULL,
  `destination_popularity_points` varchar(100) NOT NULL,
  `vessel_id_list` varchar(100) NOT NULL,
  `partner_id` int(10) NOT NULL,
  `destination_photos` varchar(10000) DEFAULT NULL,
  `destination_thumbnail` varchar(100) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newtable`
--

DROP TABLE IF EXISTS `newtable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newtable` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `destination_name` varchar(100) NOT NULL,
  `destination_thumbnail` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `destination_description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partner_payout_info_table`
--

DROP TABLE IF EXISTS `partner_payout_info_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_payout_info_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account_name` varchar(100) NOT NULL,
  `bank_account_number` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_country` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partners_table`
--

DROP TABLE IF EXISTS `partners_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `commission_percentage` int(11) NOT NULL DEFAULT 0,
  `partial_payment_percentage` int(11) NOT NULL DEFAULT 0,
  `partner_address` varchar(1000) NOT NULL,
  `partner_contact` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payout_table`
--

DROP TABLE IF EXISTS `payout_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payout_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_code_list` varchar(10000) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `invoice_file_dir` varchar(100) NOT NULL,
  `payout_total_amount` int(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `partner_id` int(11) NOT NULL,
  `date_generated` datetime DEFAULT NULL,
  `cutoff_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `schedule_title` varchar(100) NOT NULL,
  `schedule_from` date NOT NULL,
  `schedule_to` date NOT NULL,
  `vessel_id` int(10) NOT NULL,
  `itinerary` varchar(100) DEFAULT NULL,
  `destination_id` int(10) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings_booking_status`
--

DROP TABLE IF EXISTS `settings_booking_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_booking_status` (
  `id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings_payment_status`
--

DROP TABLE IF EXISTS `settings_payment_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_payment_status` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings_role_type`
--

DROP TABLE IF EXISTS `settings_role_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_role_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_type` varchar(100) NOT NULL,
  `role_scope` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transaction_table`
--

DROP TABLE IF EXISTS `transaction_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_date` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  `commission` int(11) NOT NULL DEFAULT 0,
  `status` varchar(100) NOT NULL COMMENT '0-under verification 1-payment approved',
  `proof_of_payment` varchar(1000) NOT NULL,
  `ref_code` varchar(100) NOT NULL,
  `payout_status` int(11) NOT NULL DEFAULT 0 COMMENT '0 - NEW, 1 - Under Review, 2 - Credited.',
  `transaction_ref_number` varchar(100) DEFAULT NULL,
  `initialpayment_status` int(11) NOT NULL DEFAULT 0,
  `effective_commission_percentage` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_admin`
--

DROP TABLE IF EXISTS `user_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `partner_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `email_notif` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vessel_cabin`
--

DROP TABLE IF EXISTS `vessel_cabin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vessel_cabin` (
  `vessel_id` int(10) NOT NULL,
  `cabin_title` varchar(100) NOT NULL,
  `cabin_description` varchar(100) NOT NULL,
  `cabin_max_guests` int(10) NOT NULL,
  `cabin_bed_number` int(10) NOT NULL,
  `cabin_base_price` int(10) NOT NULL,
  `cabin_availability` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vessel_features`
--

DROP TABLE IF EXISTS `vessel_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vessel_features` (
  `vessel_id` int(10) NOT NULL,
  `vessel_feature_type` varchar(100) NOT NULL,
  `vessel_feature_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vessel_specification`
--

DROP TABLE IF EXISTS `vessel_specification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vessel_specification` (
  `vessel_id` int(10) NOT NULL,
  `vessel_year_model` int(10) NOT NULL,
  `vessel_year_renovation` int(10) NOT NULL,
  `vessel_beam` varchar(100) NOT NULL,
  `vessel_fuel_capacity` int(10) NOT NULL,
  `vessel_cabin_capacity` int(10) NOT NULL,
  `vessel_bathroom_number` int(10) NOT NULL,
  `vessel_topspeed` int(10) NOT NULL,
  `vessel_cruisingspeed` int(10) NOT NULL,
  `vessel_engines` varchar(100) NOT NULL,
  `vessel_max_guest_capacity` int(10) NOT NULL,
  `vessel_freshwater_maker` int(10) NOT NULL,
  `vessel_tenders` varchar(100) NOT NULL,
  `vessel_water_capacity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vessel_table`
--

DROP TABLE IF EXISTS `vessel_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vessel_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `partner_id` int(10) NOT NULL,
  `vessel_name` varchar(100) NOT NULL,
  `vessel_thumbnail` varchar(1000) NOT NULL,
  `vessel_photos` varchar(10000) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'db_liveaboardtrips'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-05 23:56:35
