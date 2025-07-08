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
-- Dumping data for table `booking_details`
--

LOCK TABLES `booking_details` WRITE;
/*!40000 ALTER TABLE `booking_details` DISABLE KEYS */;
INSERT INTO `booking_details` VALUES (91,'QV4RSTKS02',43,2,39),(92,'QV4RSTKS02',44,1,39),(93,'C592B3W3ZA',43,2,39),(94,'C592B3W3ZA',44,2,39),(95,'CFVUHSEML6',44,1,39),(96,'L3SYPUF7G7',43,1,39);
/*!40000 ALTER TABLE `booking_details` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `booking_table`
--

LOCK TABLES `booking_table` WRITE;
/*!40000 ALTER TABLE `booking_table` DISABLE KEYS */;
INSERT INTO `booking_table` VALUES (35,'C592B3W3ZA','67',0,'','3','2025-02-23 19:34:19',39,1),(36,'CFVUHSEML6','68',0,'','3','2025-03-01 13:26:05',39,1),(37,'L3SYPUF7G7','69',0,'','0','2025-03-05 16:04:05',39,1);
/*!40000 ALTER TABLE `booking_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `booking_userinfo`
--

LOCK TABLES `booking_userinfo` WRITE;
/*!40000 ALTER TABLE `booking_userinfo` DISABLE KEYS */;
INSERT INTO `booking_userinfo` VALUES (65,'QV4RSTKS02','testing','testing','testing','[{\"id\":\"43\",\"quantity\":2,\"baseprice\":1800,\"surcharge\":80},{\"id\":\"44\",\"quantity\":1,\"baseprice\":2500,\"surcharge\":75}]','Philippines','testing','1231212121212','panoterominton@gmail.com','1231212121212','[{\"cabin_id\":\"43\",\"name\":\"akrapovbic diaz\",\"email\":\"akrapovbic diaz\",\"solo_accommodation\":true},{\"cabin_id\":\"43\",\"name\":\"akrapovbic diaz\",\"email\":\"akrapovbic diaz\",\"solo_accommodation\":true},{\"cabin_id\":\"44\",\"name\":\"akrapovbic diaz\",\"email\":\"akrapovbic diaz\",\"solo_accommodation\":true}]'),(66,'H123TEDT12','testing','testing','testing','[{\"id\":\"43\",\"quantity\":2,\"baseprice\":1800,\"surcharge\":80},{\"id\":\"44\",\"quantity\":1,\"baseprice\":2500,\"surcharge\":75}]','Philippines','testing','1231212121212','panoterominton@gmail.com','1231212121212','[{\"cabin_id\":\"43\",\"name\":\"akrapovbic diaz\",\"email\":\"akrapovbic diaz\",\"solo_accommodation\":true},{\"cabin_id\":\"43\",\"name\":\"akrapovbic diaz\",\"email\":\"akrapovbic diaz\",\"solo_accommodation\":true},{\"cabin_id\":\"44\",\"name\":\"akrapovbic diaz\",\"email\":\"akrapovbic diaz\",\"solo_accommodation\":true}]'),(67,'C592B3W3ZA','sample','sample','sample','[{\"id\":\"43\",\"quantity\":2,\"baseprice\":1800,\"surcharge\":80},{\"id\":\"44\",\"quantity\":2,\"baseprice\":2500,\"surcharge\":75}]','sample','sample','09123456789','minton.diaz005@gmail.com','sample','[{\"cabin_id\":\"43\",\"name\":\"sample1\",\"email\":\"sample1@email.com\",\"solo_accommodation\":false},{\"cabin_id\":\"43\",\"name\":\"sample2\",\"email\":\"sample1@email.com\",\"solo_accommodation\":false},{\"cabin_id\":\"44\",\"name\":\"sample3\",\"email\":\"sample1@email.com\",\"solo_accommodation\":true},{\"cabin_id\":\"44\",\"name\":\"sample4\",\"email\":\"sample1@email.com\",\"solo_accommodation\":true}]'),(68,'CFVUHSEML6','testing','testing','testing','[{\"id\":\"43\",\"quantity\":0,\"baseprice\":1800,\"surcharge\":80},{\"id\":\"44\",\"quantity\":1,\"baseprice\":2500,\"surcharge\":75}]','Philippines','testing','123145123','panoterominton@gmail.com','1231212121212','[{\"cabin_id\":\"44\",\"name\":\"sdfdfsdfs\",\"email\":\"dfsdf\",\"solo_accommodation\":false}]'),(69,'L3SYPUF7G7','testing','testing','testing','[{\"id\":\"43\",\"quantity\":1,\"baseprice\":1800,\"surcharge\":80},{\"id\":\"44\",\"quantity\":0,\"baseprice\":2500,\"surcharge\":75}]','Philippines','testing','123123','panoterominton@gmail.com','1231212121212','[{\"cabin_id\":\"43\",\"name\":\"asd\",\"email\":\"asdasd\",\"solo_accommodation\":true}]');
/*!40000 ALTER TABLE `booking_userinfo` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `cabin_details`
--

LOCK TABLES `cabin_details` WRITE;
/*!40000 ALTER TABLE `cabin_details` DISABLE KEYS */;
INSERT INTO `cabin_details` VALUES (101,'Twin Berth','TwinBerth is a cozy bedroom cabin for 2. ','uploads/1/cabin/img/twinberth4.JPG','uploads/1/cabin/img/twinberth1.JPG;uploads/1/cabin/img/twinberth2.JPG;uploads/1/cabin/img/twinberth3','2','2',6,51,1),(102,'Queen Suite','A Single bed suite for most of couples.','uploads/1/cabin/img/queensuite6.JPG','uploads/1/cabin/img/queensuite1.JPG;uploads/1/cabin/img/queensuite2.JPG;uploads/1/cabin/img/queensui','2','1',6,51,1),(103,'sea view cabin 1','sghjdvfsvdfsukdfuhbsfgd','uploads/1/cabin/img/451061413_1394867038571348_4107861059371907136_n.png','uploads/1/cabin/img/450573311_8400800083266003_6305016626685628921_n.png;uploads/1/cabin/img/4510614','2','2',10,52,1);
/*!40000 ALTER TABLE `cabin_details` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `cabin_table`
--

LOCK TABLES `cabin_table` WRITE;
/*!40000 ALTER TABLE `cabin_table` DISABLE KEYS */;
INSERT INTO `cabin_table` VALUES (43,'101','1800',51,0,0,1,80),(44,'102','2500',51,0,0,1,75),(45,'103','3200',52,0,0,1,60);
/*!40000 ALTER TABLE `cabin_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `destination_table`
--

LOCK TABLES `destination_table` WRITE;
/*!40000 ALTER TABLE `destination_table` DISABLE KEYS */;
INSERT INTO `destination_table` VALUES (26,'Tubbataha','Philippines','0','51',1,'uploads/1/destinations/img/Tubbataha-Reef-01.jpg;uploads/1/destinations/img/Yvette-Lee-DSC_1858-scaled.jpg;uploads/1/destinations/img/tubbataha-reef-national-marine-park-in-philippines.jpg;uploads/1/destinations/img/AerialviewofNorthAtollinTubbataha_TommySchultz.jpg','uploads/1/destinations/img/AerialviewofNorthAtollinTubbataha_TommySchultz.jpg',''),(27,'Visayas','Philippines','0','51',1,'uploads/1/destinations/img/Tubbataha-Reef-01.jpg;uploads/1/destinations/img/Yvette-Lee-DSC_1858-scaled.jpg;uploads/1/destinations/img/tubbataha-reef-national-marine-park-in-philippines.jpg;uploads/1/destinations/img/AerialviewofNorthAtollinTubbataha_TommySchultz.jpg','uploads/1/destinations/img/Tubbataha-Reef-01.jpg','');
/*!40000 ALTER TABLE `destination_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `newtable`
--

LOCK TABLES `newtable` WRITE;
/*!40000 ALTER TABLE `newtable` DISABLE KEYS */;
/*!40000 ALTER TABLE `newtable` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `partner_payout_info_table`
--

LOCK TABLES `partner_payout_info_table` WRITE;
/*!40000 ALTER TABLE `partner_payout_info_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `partner_payout_info_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `partners_table`
--

LOCK TABLES `partners_table` WRITE;
/*!40000 ALTER TABLE `partners_table` DISABLE KEYS */;
INSERT INTO `partners_table` VALUES (1,'MY Palau Sport','Philippines',0,40,30,'123 Sample Street Cebu City','+639123456789');
/*!40000 ALTER TABLE `partners_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `payout_table`
--

LOCK TABLES `payout_table` WRITE;
/*!40000 ALTER TABLE `payout_table` DISABLE KEYS */;
INSERT INTO `payout_table` VALUES (23,'[\"C592B3W3ZA\"]',0,'2025-02-23 19:43:54','INV-0012025-02-23TQ55O','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740311034.pdf',2223,1,1,NULL,'2025-02-23 19:43:54'),(25,'[\"C592B3W3ZA\"]',0,'2025-02-23 20:09:32','INV-0012025-02-23VMMQT','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740312572.pdf',5187,1,1,NULL,'2025-02-23 20:09:32'),(26,'[\"C592B3W3ZA\"]',0,'2025-02-26 22:35:13','INV-0012025-02-26M9C5V','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740580513.pdf',7410,0,1,NULL,'2025-02-26 22:35:13'),(27,'[\"C592B3W3ZA\"]',0,'2025-02-26 22:35:26','INV-0012025-02-26MCKA2','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740580526.pdf',7410,0,1,NULL,'2025-02-26 22:35:26'),(28,'[\"C592B3W3ZA\"]',0,'2025-02-26 22:35:39','INV-0012025-02-264R81T','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740580539.pdf',7410,0,1,NULL,'2025-02-26 22:35:39'),(29,'[\"C592B3W3ZA\"]',0,'2025-02-26 22:35:51','INV-0012025-02-26XWMMU','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740580551.pdf',7410,0,1,NULL,'2025-02-26 22:35:51'),(30,'[\"CFVUHSEML6\"]',0,'2025-03-01 13:29:44','INV-0012025-03-01O3MX9','http://localhost/liveaboardtrips/assets/pdf/invoices/1/invoice_11740806984.pdf',1500,1,1,NULL,'2025-03-01 13:29:44');
/*!40000 ALTER TABLE `payout_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (39,'Tubbataha','2025-05-01','2025-05-07',51,'zsdasdaczcasdaszxc',26,1,0),(40,'Visayas','2025-06-25','2025-06-30',51,'asdsdfsdfsgsfsdfs',27,1,0),(41,'Tubbataha','2025-05-08','2025-05-14',51,'zsdasdaczcasdaszxc',26,1,0),(42,'Tubbataha','2025-05-15','2025-05-21',51,'zsdasdaczcasdaszxc',26,1,0),(43,'Tubbataha','2025-05-22','2025-05-28',51,'zsdasdaczcasdaszxc',26,1,0);
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `settings_booking_status`
--

LOCK TABLES `settings_booking_status` WRITE;
/*!40000 ALTER TABLE `settings_booking_status` DISABLE KEYS */;
INSERT INTO `settings_booking_status` VALUES (0,'New'),(1,'Confirmed'),(2,'Payment Under Verification'),(3,'Paid'),(4,'Declined'),(5,'Cancelled');
/*!40000 ALTER TABLE `settings_booking_status` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `settings_payment_status`
--

LOCK TABLES `settings_payment_status` WRITE;
/*!40000 ALTER TABLE `settings_payment_status` DISABLE KEYS */;
INSERT INTO `settings_payment_status` VALUES (0,'New'),(1,'Approved'),(2,'Declined'),(3,'Pending Review');
/*!40000 ALTER TABLE `settings_payment_status` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `settings_role_type`
--

LOCK TABLES `settings_role_type` WRITE;
/*!40000 ALTER TABLE `settings_role_type` DISABLE KEYS */;
INSERT INTO `settings_role_type` VALUES (1,'Superadmin',0),(2,'Admin',0),(3,'Agent',0),(4,'Partner',0);
/*!40000 ALTER TABLE `settings_role_type` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `transaction_table`
--

LOCK TABLES `transaction_table` WRITE;
/*!40000 ALTER TABLE `transaction_table` DISABLE KEYS */;
INSERT INTO `transaction_table` VALUES (29,'2025-02-23 19:38:17',12350,4940,'1','uploads/transaction/proof_of_payment/1/pexels-karolina-grabowska-4386367.jpg','C592B3W3ZA',2,NULL,2,40),(30,'2025-03-01 13:28:35',2500,1000,'1','uploads/transaction/proof_of_payment/1/cardplaceholder.jpg','CFVUHSEML6',2,NULL,2,40);
/*!40000 ALTER TABLE `transaction_table` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `user_admin`
--

LOCK TABLES `user_admin` WRITE;
/*!40000 ALTER TABLE `user_admin` DISABLE KEYS */;
INSERT INTO `user_admin` VALUES (1,'admin@liveaboardtrips.com','admin','$2a$12$j46ZlohBCyaJuPgoRwTtiOx1UdDbHh7p/vgKcKMtbcs1FEEToQoY6',0,1,'super','admin',0,1),(8,'panoterominton@gmail.com','admin.palausport','$2y$10$ht192.m0.HCagxOoKfzLZeNEWQQmRsvo2oxtpSErG/AwNbb9uk.LG',1,4,'Palau','Sport',0,1),(24,'minton.diaz005@gmail.com','agent','$2a$10$kTqJKu/sg3rC3dIZVfnwIOWjuy0XfhFQKZewcTGvMp.zf/ZAzR8yW',0,3,'agent','liveaboard',0,1);
/*!40000 ALTER TABLE `user_admin` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `vessel_cabin`
--

LOCK TABLES `vessel_cabin` WRITE;
/*!40000 ALTER TABLE `vessel_cabin` DISABLE KEYS */;
/*!40000 ALTER TABLE `vessel_cabin` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `vessel_features`
--

LOCK TABLES `vessel_features` WRITE;
/*!40000 ALTER TABLE `vessel_features` DISABLE KEYS */;
INSERT INTO `vessel_features` VALUES (22,'food','Library'),(22,'food','Outdoor dining'),(22,'food','Sun Deck'),(23,'food','Daily Housekeeping'),(23,'food','En-suite Bathrooms'),(23,'network','Paid Internet/Wifi'),(23,'food','Seaview Cabins'),(23,'food','Hot/Cold Shower facility'),(23,'food','Purified/Distilled drinking water'),(23,'food','Fresh water maker'),(23,'diving','DIN Adapters'),(23,'diving','Dive Deck'),(23,'diving','Shaded Dive Deck'),(23,'diving','Nitrox available'),(23,'diving','Chase boats'),(23,'food','Alfresco Area with Bar'),(23,'food','Liesure deck'),(23,'food','Library'),(23,'food','Outdoor dining'),(23,'food','Sun Deck'),(24,'food','Daily Housekeeping'),(24,'food','En-suite Bathrooms'),(24,'network','Paid Internet/Wifi'),(24,'food','Seaview Cabins'),(24,'food','Hot/Cold Shower facility'),(24,'food','Purified/Distilled drinking water'),(24,'food','Fresh water maker'),(24,'diving','DIN Adapters'),(24,'diving','Dive Deck'),(24,'diving','Shaded Dive Deck'),(24,'diving','Nitrox available'),(24,'diving','Chase boats'),(24,'food','Alfresco Area with Bar'),(24,'food','Liesure deck'),(24,'food','Library'),(24,'food','Outdoor dining'),(24,'food','Sun Deck'),(25,'food','Daily Housekeeping'),(25,'food','En-suite Bathrooms'),(25,'network','Paid Internet/Wifi'),(25,'food','Seaview Cabins'),(25,'food','Hot/Cold Shower facility'),(25,'food','Purified/Distilled drinking water'),(25,'food','Fresh water maker'),(25,'diving','DIN Adapters'),(25,'diving','Dive Deck'),(25,'diving','Shaded Dive Deck'),(25,'diving','Nitrox available'),(25,'diving','Chase boats'),(25,'food','Alfresco Area with Bar'),(25,'food','Liesure deck'),(25,'food','Library'),(25,'food','Outdoor dining'),(25,'food','Sun Deck'),(26,'food','Daily Housekeeping'),(26,'food','En-suite Bathrooms'),(26,'network','Paid Internet/Wifi'),(26,'food','Seaview Cabins'),(26,'food','Hot/Cold Shower facility'),(26,'food','Purified/Distilled drinking water'),(26,'food','Fresh water maker'),(26,'diving','DIN Adapters'),(26,'diving','Dive Deck'),(26,'diving','Shaded Dive Deck'),(26,'diving','Nitrox available'),(26,'diving','Chase boats'),(26,'food','Alfresco Area with Bar'),(26,'food','Liesure deck'),(26,'food','Library'),(26,'food','Outdoor dining'),(26,'food','Sun Deck'),(27,'food','Daily Housekeeping'),(27,'food','En-suite Bathrooms'),(27,'network','Paid Internet/Wifi'),(27,'food','Seaview Cabins'),(27,'food','Hot/Cold Shower facility'),(27,'food','Purified/Distilled drinking water'),(27,'food','Fresh water maker'),(27,'diving','DIN Adapters'),(27,'diving','Dive Deck'),(27,'diving','Shaded Dive Deck'),(27,'diving','Nitrox available'),(27,'diving','Chase boats'),(27,'food','Alfresco Area with Bar'),(27,'food','Liesure deck'),(27,'food','Library'),(27,'food','Outdoor dining'),(27,'food','Sun Deck'),(46,'food',''),(51,'asdasd','asdasdasdad'),(52,'Diving','Nitrox'),(52,'Food','Minibar'),(52,'Housekeeping','Laundry');
/*!40000 ALTER TABLE `vessel_features` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `vessel_specification`
--

LOCK TABLES `vessel_specification` WRITE;
/*!40000 ALTER TABLE `vessel_specification` DISABLE KEYS */;
INSERT INTO `vessel_specification` VALUES (51,123,123,'123',123,123,123,123,123,'123',123,123,'123',123),(52,123,123,'123',123,123,123,123,123,'123',123,123,'123',123);
/*!40000 ALTER TABLE `vessel_specification` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `vessel_table`
--

LOCK TABLES `vessel_table` WRITE;
/*!40000 ALTER TABLE `vessel_table` DISABLE KEYS */;
INSERT INTO `vessel_table` VALUES (51,1,'MY PALAU SPORT','uploads/1/vessel/img/091A9240.JPG','uploads/1/vessel/img/091A9355.JPG;uploads/1/vessel/img/091A9459.JPG;uploads/1/vessel/img/091A9582.JPG;uploads/1/vessel/img/091A9797.JPG;uploads/1/vessel/img/091A9900.JPG;uploads/1/vessel/img/091A9968.JPG;uploads/1/vessel/img/091A8829.JPG;uploads/1/vessel/img/091A8914.JPG;uploads/1/vessel/img/091A9169.JPG;uploads/1/vessel/img/091A9240.JPG',NULL),(52,1,'Blue Dolphin','uploads/1/vessel/img/liveaboardtripsLOGO.png','uploads/1/vessel/img/Untitled design (19).png;uploads/1/vessel/img/ocean.jpg;uploads/1/vessel/img/Untitled design (9).jpg',NULL);
/*!40000 ALTER TABLE `vessel_table` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2025-03-06  0:04:44
