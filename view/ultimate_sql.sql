/*
SQLyog Ultimate v8.55 
MySQL - 5.5.5-10.4.32-MariaDB : Database - pam
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `assets` */

DROP TABLE IF EXISTS `assets`;

CREATE TABLE `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `price` decimal(10,2) NOT NULL,
  `condition_status` enum('New','Good','Needs Repair','Damaged') DEFAULT 'New',
  `status` enum('Available','Assigned','Under Maintenance','Disposed','Fixed') DEFAULT 'Available',
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `variety` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `size` varchar(128) DEFAULT NULL,
  `brand` varchar(128) DEFAULT NULL,
  `unit` varchar(128) DEFAULT NULL,
  `paper_type` varchar(128) DEFAULT NULL,
  `thickness` varchar(128) DEFAULT NULL,
  `specification` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_code` (`asset_code`),
  KEY `category_id` (`category_id`),
  KEY `subcategory_id` (`subcategory_id`),
  KEY `assets_ibfk_3` (`office_id`),
  CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `assets_ibfk_3` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `assets` */

insert  into `assets`(`id`,`asset_code`,`name`,`category_id`,`subcategory_id`,`office_id`,`purchase_date`,`price`,`condition_status`,`status`,`image`,`description`,`variety`,`size`,`brand`,`unit`,`paper_type`,`thickness`,`specification`) values (126,'000001','pencil',3,37,12,'2025-04-26 13:13:09','12.00','Damaged','Available','Assets_67ecaf21806be.webp','cfnfcfch','{\"name\":\"brand\",\"values\":[\"mongol 1\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(127,'000002','scissor',3,37,12,'2025-04-26 15:26:57','30.00','Needs Repair','Fixed','Assets_67ecb00b3b26a.jpg','aawd','{\"name\":\"color\",\"values\":[\"red\",\"green\",\"blue\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(128,'000003','eraser',3,37,12,'2025-04-03 19:46:15','30.00','New','Available','Assets_67ecb25354a75.jpg','pambura','{\"name\":\"shape\",\"values\":[\"triangle\",\"square\",\"circle\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(129,'000004','laptop',2,31,15,'2025-04-06 11:36:56','500.00','Good','Available','Assets_67ed4fbbd3c45.webp','','{\"name\":\"brand\",\"values\":[\"hp\",\"lenovo\",\"samsung\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(130,'000005','printer',2,33,15,'2025-04-26 15:26:16','150.00','New','Assigned','Assets_67ee710235f19.jpg','','{\"name\":\"brand\",\"values\":[\"epson\",\"cannon\",\"hp\",\"brother\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(143,'000006','Lenovo',1,26,12,'2025-04-19 13:44:09','20000.00','Good','Available','Assets_680338290e3c6.png','Sample','{\"name\":\"Sample\",\"values\":[\"value\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(144,'000007','Sample',1,27,18,'2025-04-19 13:44:44','900.00','Needs Repair','Under Maintenance','Assets_6803384cccf6b.png','Hehe','{\"name\":\"Sample\",\"values\":[\"Sample Value\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(145,'000008','Stapler',2,32,15,'2025-04-19 13:45:53','900.00','New','Available','Assets_68033891cde41.png','Sample Desc','{\"name\":\"Sample Variety\",\"values\":[\"Sample\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(146,'232324','asf',1,26,13,'2025-04-19 15:37:26','2000.00','Good','Assigned','Assets_680352b677763.png','adf','{\"name\":\"123123\",\"values\":[\"123\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(147,'123123123','asdfa',3,36,20,'2025-04-19 15:46:04','234234.00','New','Available','Assets_680354bca4588.png','sdfasfdasf','{\"name\":\"333\",\"values\":[\"3333\"]}','Short',NULL,NULL,NULL,NULL,NULL),(148,'324234','asdfas',3,36,15,'2025-04-19 15:48:23','34333.00','Good','Available','Assets_680355478f2d2.png','dfasdf','{\"name\":\"asdfa\",\"values\":[\"fasdfasdf\"]}','Long','Hardcopy','Ream','Multipurpose','70gsm',NULL),(149,'00123123','Ballpen',3,37,15,'2025-04-19 20:52:55','2000.00','New','Available','Assets_68039ca79b582.jpg','Sample','{\"name\":\"variety\",\"values\":[\"variety\"]}','','','','','',NULL),(150,'23424324','hat',2,28,13,'2025-04-20 21:44:03','200.00','Needs Repair','Under Maintenance','Assets_6804fa2347168.png','asdf','{\"name\":\"saf\",\"values\":[\"adsf\"]}','','','','','',NULL),(151,'324','sadfsadfasdfsadf',1,26,13,'2025-04-26 12:53:31','0.00','Needs Repair','Under Maintenance','Assets_680c66cb1b6ce.png','sdf','{\"name\":\"asdf\",\"values\":[\"asdf\"]}','','','','','',NULL),(152,'3242432432','sssssssss',1,26,20,'2025-04-26 15:56:38','0.00','New','Available',NULL,'sssssss','{\"name\":\"Hahaha\",\"values\":[\"Hehehe\",\"Hihihih\"]}','','','','','',NULL),(153,'AST00647','24',1,26,20,'2025-04-26 15:56:41','0.00','New','Available',NULL,'234afd','{\"name\":\"Hahaha\",\"values\":[\"Hehehe\",\"Hihihih\"]}','','','','','',NULL),(154,'AST00722','Save',1,26,14,'2025-04-26 15:56:44','0.00','New','Available',NULL,'Assets','{\"name\":\"Hahaha\",\"values\":[\"Hehehe\",\"Hihihih\"]}','','','','','',NULL),(155,'AST00992','sss',2,32,12,'2025-04-26 15:56:49','0.00','New','Available',NULL,'Office Supplies','{\"name\":\"Hahaha\",\"values\":[\"Hehehe\",\"Hihihih\"]}','','','','','',NULL),(156,'AST00037','Darren',1,27,12,'2025-04-26 15:56:53','0.00','Needs Repair','Available',NULL,'Assets','{\"name\":\"Hahaha\",\"values\":[\"Hehehe\",\"Hihihih\"]}','','','','','',NULL),(157,'OFF00619','34232',2,32,13,'2025-04-26 15:43:17','0.00','Needs Repair','Assigned',NULL,'Office Supplies','{\"name\":\"Hahaha\",\"values\":[\"Hehehe\",\"Hihihih\"]}','','','','','',NULL),(158,'OFF00604','sfasdf',2,31,12,'2025-04-26 16:57:49','0.00','New','Available',NULL,'Office Supplies','{\"name\":\"3434\",\"values\":[\"23423423424234\"]}','','','','','',NULL),(159,'AST00005','Upuan',1,26,13,'2025-04-26 22:26:16','0.00','New','Available',NULL,'Assets','{\"name\":\"Mahaba\",\"values\":[\"Maiksi\",\"Color blue\",\"COlor green\"]}','','','','','',NULL);

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `type` varchar(128) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`category_name`,`type`) values (1,'Furniture','Assets'),(2,'IT Equipment','Office Supplies'),(3,'Office Supplies','Office Supplies'),(4,'Appliances','Assets'),(5,'Others','Office Supplies');

/*Table structure for table `maintenance_table` */

DROP TABLE IF EXISTS `maintenance_table`;

CREATE TABLE `maintenance_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '',
  `is_closed` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `maintenance_table` */

insert  into `maintenance_table`(`id`,`name`,`is_closed`) values (1,'Procurements',0),(2,'Purchase Order',0),(4,'Report Generation',0),(5,'Account Settings',0),(6,'Assets',0),(8,'Inventory',0),(9,'Receive Logs',0),(10,'Requisition',0);

/*Table structure for table `maintenance_table_user` */

DROP TABLE IF EXISTS `maintenance_table_user`;

CREATE TABLE `maintenance_table_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `name` varchar(128) DEFAULT '',
  `is_closed` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `maintenance_table_user` */

insert  into `maintenance_table_user`(`id`,`user_id`,`name`,`is_closed`) values (1,80138,'Procurements',0),(2,80138,'Purchase Order',0),(3,80138,'Report Generation',0),(4,80138,'Account Settings',0),(5,80138,'Assets',0),(6,80138,'Inventory',0),(7,80138,'Receive Logs',0),(8,80138,'Requisition',1),(9,80140,'Procurements',0),(10,80140,'Purchase Order',0),(11,80140,'Report Generation',0),(12,80140,'Account Settings',0),(13,80140,'Assets',0),(14,80140,'Inventory',0),(15,80140,'Receive Logs',0),(16,80140,'Requisition',0);

/*Table structure for table `offices` */

DROP TABLE IF EXISTS `offices`;

CREATE TABLE `offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `office_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `offices` */

insert  into `offices`(`id`,`office_name`) values (12,'Administration Office'),(13,'Finance Department'),(14,'Human Resources'),(15,'IT Department'),(16,'Procurement Office'),(17,'Logistics and Supply'),(18,'Facilities Management'),(19,'Legal Affairs'),(20,'Marketing and Communications'),(21,'Research and Development'),(22,'Customer Service');

/*Table structure for table `recieved_logs` */

DROP TABLE IF EXISTS `recieved_logs`;

CREATE TABLE `recieved_logs` (
  `recieved_id` int(11) NOT NULL AUTO_INCREMENT,
  `recieved_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `recieved_supplier_name` varchar(60) NOT NULL,
  `recieved_supplier_company` varchar(60) NOT NULL,
  `recieved_assets_name` varchar(60) NOT NULL,
  `recieved_description` text NOT NULL,
  `recieved_assets_qty` int(11) NOT NULL,
  `recieved_user_id` int(11) NOT NULL,
  PRIMARY KEY (`recieved_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `recieved_logs` */

insert  into `recieved_logs`(`recieved_id`,`recieved_date`,`recieved_supplier_name`,`recieved_supplier_company`,`recieved_assets_name`,`recieved_description`,`recieved_assets_qty`,`recieved_user_id`) values (1,'2025-04-03 16:32:42','j supplies','j company','Scissors','pang gupit',30,1);

/*Table structure for table `request` */

DROP TABLE IF EXISTS `request`;

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_role` varchar(128) DEFAULT '',
  `request_invoice` varchar(60) NOT NULL,
  `request_user_id` int(11) NOT NULL,
  `request_supplier_name` varchar(60) NOT NULL,
  `request_supplier_company` varchar(60) NOT NULL,
  `request_designation` varchar(60) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `request_status` varchar(60) NOT NULL DEFAULT 'pending',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=archive,1=exist',
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `request` */

insert  into `request`(`request_id`,`request_role`,`request_invoice`,`request_user_id`,`request_supplier_name`,`request_supplier_company`,`request_designation`,`request_date`,`request_status`,`status`) values (16,'','REQ-17435944699126',1,'j supply','j company','Library','2025-04-06 12:22:00','Approve',0),(17,'','REQ-17436060249325',80141,'j supply','jcom','Computer Lab','2025-04-06 12:22:22','Delivered',0),(18,'','REQ-17436721805447',80141,'j supply','j com','HRDO','2025-04-06 12:23:09','Approve',0),(19,'','REQ-17436722272526',80141,'j supply','j com','VPAA','2025-04-06 11:03:23','Approve',1),(20,'','REQ-17436723338441',80141,'j supply','j com','VPAA','2025-04-06 11:03:19','Approve',1),(21,'','REQ-17436724223866',80141,'j supply','j com','VPAA','2025-04-05 23:58:37','Approve',1),(22,'','REQ-17438732504587',80139,'j supply','j company','Library','2025-04-06 11:03:16','Approve',1),(23,'','REQ-17438733178276',80139,'j supply','j company','VPAA','2025-04-06 11:03:04','Approve',1),(24,'','REQ-17439087663656',1,'j supply','j company','Library','2025-04-06 12:23:47','Delivered',0),(25,'','REQ-17450411667295',1,'Supplier','Sample Compnay','HRDO','2025-04-20 11:54:58','pending',0),(26,'','REQ-17450562522435',80140,'Supplier Name','Company','HRDO','2025-04-19 17:52:29','Approve',1),(27,'','REQ-17450564992705',80148,'Sample','Sample Company','Library','2025-04-20 12:23:18','pending',1),(28,'','REQ-17450679788388',80148,'asfkj','asdfasdf','WASTFI','2025-04-20 12:31:15','Approve',1),(29,'','REQ-17451174896760',1,'ad','dfs','HRDO','2025-04-20 10:51:29','pending',1),(30,'','REQ-17451188354118',1,'','','','2025-04-20 11:13:55','pending',1),(31,'','REQ-17451205843600',80149,'','','','2025-04-20 12:21:31','pending',1),(32,'','REQ-17451269722033',80149,'','','','2025-04-22 09:04:26','Ongoing',1),(33,'','REQ-17456376826067',1,'','','','2025-04-26 11:21:22','pending',1),(34,'','REQ-17456446568782',80149,'','','','2025-04-26 13:17:36','pending',1),(35,'Library','REQ-17456450416110',80149,'','','','2025-04-26 13:37:39','pending',1),(36,'Library','REQ-17456455564177',80149,'','','','2025-04-26 13:37:36','pending',1),(37,'Library','REQ-17456457646624',80149,'','','','2025-04-26 13:36:04','pending',1),(38,'Library','REQ-17456459818565',80149,'','','','2025-04-26 13:39:41','pending',1),(39,'Administrator','REQ-17456543879177',1,'','','','2025-04-26 15:59:47','pending',1),(40,'Administrator','REQ-17456546815746',1,'','','','2025-04-26 16:04:41','pending',1),(41,'Administrator','REQ-17456548917419',1,'','','','2025-04-26 16:08:11','pending',1),(42,'Administrator','REQ-17456549659049',1,'','','','2025-04-26 16:09:25','pending',1),(43,'Administrator','REQ-17456550002531',1,'','','','2025-04-26 16:10:00','pending',1),(44,'Administrator','REQ-17456553554165',1,'','','','2025-04-26 16:15:55','pending',1),(45,'Administrator','REQ-17456553866354',1,'','','','2025-04-26 16:16:26','pending',1),(46,'Administrator','REQ-17456553943762',1,'','','','2025-04-26 16:16:34','pending',1),(47,'Administrator','REQ-17456553997576',1,'','','','2025-04-26 16:16:39','pending',1),(48,'Administrator','REQ-17456554023784',1,'','','','2025-04-26 16:16:42','pending',1),(49,'Administrator','REQ-17456554315334',1,'','','','2025-04-26 16:17:11','pending',1),(50,'Administrator','REQ-17456555118417',1,'','','','2025-04-26 16:18:31','pending',1),(51,'Administrator','REQ-17456555378619',1,'','','','2025-04-26 16:18:57','pending',1),(52,'Administrator','REQ-17456558068227',1,'','','','2025-04-26 16:23:26','pending',1),(53,'Administrator','REQ-17456560077543',1,'','','','2025-04-26 16:26:47','pending',1),(54,'Administrator','REQ-17456561108335',1,'','','','2025-04-26 16:28:30','pending',1),(55,'Administrator','REQ-17456561254646',1,'','','','2025-04-26 16:28:45','pending',1),(56,'Administrator','REQ-17456823453665',1,'','','','2025-04-26 23:45:45','pending',1),(57,'Administrator','REQ-17456830837104',1,'','','','2025-04-26 23:58:03','pending',1),(58,'Administrator','REQ-17456831214761',1,'','','','2025-04-26 23:58:41','pending',1),(59,'Administrator','REQ-17456831592889',1,'','','','2025-04-26 23:59:19','pending',1),(60,'Administrator','REQ-17456831927739',1,'','','','2025-04-26 23:59:52','pending',1),(61,'Administrator','REQ-17456837391417',1,'','','','2025-04-27 00:08:59','pending',1);

/*Table structure for table `request_cart` */

DROP TABLE IF EXISTS `request_cart`;

CREATE TABLE `request_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_user_id` int(11) NOT NULL,
  `cart_asset_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_variety` varchar(60) NOT NULL,
  `specification` varchar(256) DEFAULT '',
  `specification_array` longtext DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `request_cart` */

/*Table structure for table `request_item` */

DROP TABLE IF EXISTS `request_item`;

CREATE TABLE `request_item` (
  `r_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_request_id` int(11) NOT NULL,
  `r_item_asset_id` int(11) NOT NULL,
  `r_item_qty` int(11) NOT NULL,
  `r_item_variety` varchar(60) NOT NULL,
  `r_item_price` decimal(10,2) NOT NULL,
  `r_finance_price` decimal(10,2) DEFAULT NULL,
  `r_specification` varchar(256) DEFAULT NULL,
  `r_specification_array` longtext DEFAULT NULL,
  PRIMARY KEY (`r_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `request_item` */

insert  into `request_item`(`r_item_id`,`r_request_id`,`r_item_asset_id`,`r_item_qty`,`r_item_variety`,`r_item_price`,`r_finance_price`,`r_specification`,`r_specification_array`) values (3,16,126,13,'Mongol 1','12.00',NULL,NULL,NULL),(4,16,127,1,'Green','30.00',NULL,NULL,NULL),(5,17,127,2,'Green','30.00',NULL,NULL,NULL),(6,17,129,1,'Samsung','500.00',NULL,NULL,NULL),(7,18,126,10,'Mongol 1','12.00',NULL,NULL,NULL),(8,18,128,3,'Circle','30.00',NULL,NULL,NULL),(9,18,128,6,'Square','30.00',NULL,NULL,NULL),(10,18,128,1,'Triangle','30.00',NULL,NULL,NULL),(11,19,127,1,'Green','30.00','200.00',NULL,NULL),(12,20,128,1,'Square','30.00',NULL,NULL,NULL),(13,20,127,3,'Green','30.00','20.00',NULL,NULL),(14,20,129,1,'Lenovo','500.00','20.00',NULL,NULL),(15,21,127,5,'Green','30.00',NULL,NULL,NULL),(16,21,128,1,'Square','30.00',NULL,NULL,NULL),(17,22,126,1,'Mongol 1','12.00','200.00',NULL,NULL),(18,23,130,3,'Cannon','150.00','2000.00',NULL,NULL),(19,24,128,3,'Square','30.00',NULL,NULL,NULL),(20,24,128,2,'Circle','30.00',NULL,NULL,NULL),(21,25,126,3,'Mongol 1','12.00',NULL,NULL,NULL),(22,25,127,22,'Green','30.00',NULL,NULL,NULL),(23,25,128,4,'Square','30.00',NULL,NULL,NULL),(24,25,129,4,'Lenovo','500.00',NULL,NULL,NULL),(25,25,130,2,'Hp','150.00',NULL,NULL,NULL),(26,25,130,22,'Cannon','150.00',NULL,NULL,NULL),(27,25,128,2,'Triangle','30.00',NULL,NULL,NULL),(28,26,126,2,'Mongol 1','12.00',NULL,NULL,NULL),(29,27,126,100,'Mongol 1','12.00','500.00',NULL,NULL),(30,28,126,2,'Mongol 1','12.00',NULL,NULL,NULL),(31,29,126,2,'Mongol 1','12.00',NULL,NULL,NULL),(32,30,126,2,'Mongol 1','12.00','200.00',NULL,NULL),(33,31,126,3,'Mongol 1','12.00',NULL,NULL,NULL),(34,32,127,10,'Green','30.00','30.00',NULL,NULL),(35,33,126,32,'Mongol 1','12.00','324.00',NULL,NULL),(36,34,143,2,'Value','20000.00',NULL,NULL,NULL),(37,35,147,3,'3333','234234.00',NULL,NULL,NULL),(38,36,128,3,'Triangle','30.00',NULL,NULL,NULL),(39,37,145,2,'Sample','900.00',NULL,NULL,NULL),(40,38,128,2,'Square','30.00',NULL,NULL,NULL),(41,39,128,2,'Square','30.00',NULL,NULL,NULL),(42,40,145,2,'Sample','900.00',NULL,NULL,NULL),(43,41,128,2,'Triangle','30.00',NULL,NULL,NULL),(44,41,149,222,'Variety','2000.00',NULL,NULL,NULL),(45,43,147,3,'3333','234234.00',NULL,'234234.00',NULL),(46,43,147,2,'3333','234234.00',NULL,'234234.00',NULL),(47,44,128,2,'Square','30.00',NULL,NULL,NULL),(48,49,128,3,'Square','30.00',NULL,NULL,NULL),(49,49,129,3,'Lenovo','500.00',NULL,NULL,NULL),(50,50,148,4,'Fasdfasdf','34333.00',NULL,NULL,NULL),(51,51,148,0,'Fasdfasdf','34333.00',NULL,'148',NULL),(52,52,149,3,'Variety','2000.00',NULL,NULL,NULL),(53,53,145,3,'Sample','900.00',NULL,NULL,NULL),(54,54,128,4,'Square','30.00',NULL,'444',NULL),(55,55,128,3,'Square','30.00',NULL,'heheheh',NULL),(56,56,159,2,'Color blue','0.00',NULL,'blank',NULL),(57,56,128,3,'Triangle','30.00',NULL,'',NULL),(58,60,128,3,'Triangle','30.00',NULL,'','{\"name\":\"darren\",\"values\":[\"Celzo\",\"Sample\"]}'),(59,60,128,2,'Square','30.00',NULL,'','{\"name\":\"sample\",\"values\":[\"darren\",\"asdfasdf\"]}'),(60,61,145,2,'Sample','900.00',NULL,'','');

/*Table structure for table `subcategories` */

DROP TABLE IF EXISTS `subcategories`;

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `subcategories` */

insert  into `subcategories`(`id`,`category_id`,`subcategory_name`) values (26,1,'Office Chairs'),(27,1,'Desks'),(28,1,'Conference Tables'),(29,1,'Sofas'),(30,1,'Cabinets'),(31,2,'Laptops'),(32,2,'Desktop Computers'),(33,2,'Printers'),(34,2,'Monitors'),(35,2,'Networking Equipment'),(36,3,'Paper'),(37,3,'Pens and Markers'),(38,3,'Notebooks'),(39,3,'Envelopes'),(40,3,'Folders'),(41,4,'Refrigerators'),(42,4,'Microwave Ovens'),(43,4,'Air Conditioners'),(44,4,'Water Dispensers'),(45,4,'Electric Fans'),(46,5,'Miscellaneous Items'),(47,5,'Promotional Materials'),(48,5,'Event Supplies'),(49,5,'Tools and Equipment'),(50,5,'Uncategorized');

/*Table structure for table `system_maintenance` */

DROP TABLE IF EXISTS `system_maintenance`;

CREATE TABLE `system_maintenance` (
  `system_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(60) NOT NULL,
  `system_image` varchar(255) NOT NULL,
  PRIMARY KEY (`system_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `system_maintenance` */

insert  into `system_maintenance`(`system_id`,`system_name`,`system_image`) values (1,'PAM','Assets_67de5e3f36f55.jpg');

/*Table structure for table `tblforgot_otp` */

DROP TABLE IF EXISTS `tblforgot_otp`;

CREATE TABLE `tblforgot_otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expiry` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblforgot_otp` */

insert  into `tblforgot_otp`(`id`,`accountid`,`email`,`token`,`expiry`) values (6,80150,'dacuna@qmdsi.com','3aac162cb616b3085e8d596df9a6585bf1693b72b84aef0cc2ea051a48a9d2cc','2025-04-26 19:29:43'),(10,1,'darrencelzo77@gmail.com','6a417900eed77939ced268a8a0f6520d5190f6da6655ea52fb36095581278422','2025-04-26 19:36:42');

/*Table structure for table `type_table` */

DROP TABLE IF EXISTS `type_table`;

CREATE TABLE `type_table` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(128) DEFAULT '',
  PRIMARY KEY (`typeid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `type_table` */

insert  into `type_table`(`typeid`,`type`) values (1,'Assets'),(2,'Office Supplies');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `email_official` varchar(128) DEFAULT '',
  `password` varchar(255) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `nickname` varchar(60) DEFAULT NULL,
  `role` varchar(60) NOT NULL,
  `designation` varchar(60) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=exist',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`user_id`,`email`,`email_official`,`password`,`fullname`,`nickname`,`role`,`designation`,`profile_picture`,`created_at`,`status`) values (1,'85623','admin','darrencelzo77@gmail.com','admin','admin ako','nicknameadmin','Administrator','Computer Lab','Profile_67dd240ef2143.jpeg','2025-04-27 01:33:12',1),(80138,'000001','darrencelzo77@gmail.com','','admin','joshua padilla','andy','Finance','Registrar\'s Office','Profile_67ebdf948c3c2.webp','2025-04-27 01:28:56',1),(80139,'8888888','juan@gmail.com','','admin','juan','juan','Finance','VPAA','Profile_67ebe1e2b2142.jpeg','2025-04-27 01:28:57',1),(80140,'99999','alucard@gmail.com','','admin','alucard','calu','Office Heads','Registrar\'s Office',NULL,'2025-04-27 01:28:59',1),(80141,'56454564','layla@gmail.com','','admin','layla','layla','Finance','Registrar\'s Office',NULL,'2025-04-27 01:28:58',1),(80145,'13123','Head Finance','','Head Finance','Head Finance','Head Finance','Head Finance','Registrar\'s Office',NULL,'2025-04-27 01:29:01',1),(80146,'234234','Head Maintenance','','Head Maintenance','Head Maintenance','Head Maintenance','Head Maintenance','Maintenance',NULL,'2025-04-27 01:29:02',1),(80147,'00004','Finance','','Finance','Finance','Finance','Finance','VPAA','Profile_680339bcaed69.png','2025-04-27 01:29:03',1),(80148,'232123','angelo','','admin','angelo','angelo','Library','VPAA','Profile_680372a70bcb6.jpg','2025-04-27 01:29:04',1),(80149,'3223423432','Normal Library','','Normal Library','Normal Library','Normal Library','Library','Library',NULL,'2025-04-27 01:29:06',1),(80150,'23423423','Head Library','dacuna@qmdsi.com','Head Library','Head Library','Head Library','Head Library','Library',NULL,'2025-04-26 17:06:24',1),(80151,'Darrenstar','Darrenstar','neust.darrencelzo.acuna@gmail.com','darren','Darrenstar','Darrenstar','Administrator','Registrar\'s Office','Profile_680ca35974bc9.png','2025-04-26 17:11:53',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
