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
  `qty` varchar(128) DEFAULT '',
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `assets` */

insert  into `assets`(`id`,`qty`,`asset_code`,`name`,`category_id`,`subcategory_id`,`office_id`,`purchase_date`,`price`,`condition_status`,`status`,`image`,`description`,`variety`,`size`,`brand`,`unit`,`paper_type`,`thickness`,`specification`) values (1,'','AST00358','save',1,26,13,'2025-04-27 15:02:42','0.00','Good','Available',NULL,'Assets','{\"name\":\"asdfas\",\"values\":[\"asfasf\"]}','','','','','',NULL),(2,'','AST00974','darren',4,42,13,'2025-04-27 15:02:59','0.00','Needs Repair','Available',NULL,'Assets','{\"name\":\"dd\",\"values\":[\"asdfasdf\"]}','','','','','',NULL),(3,'','OFF00744','darreb',2,31,13,'2025-04-27 15:03:15','0.00','New','Available',NULL,'Office Supplies','{\"name\":\"fasfasdf\",\"values\":[\"da\"]}','','','','','',NULL),(4,'','OFF00551','Darren',3,37,14,'2025-04-27 15:03:50','0.00','New','Available',NULL,'Office Supplies',NULL,'','','','','',NULL),(6,'12','AST00208','sdfasdf',1,28,13,'2025-05-09 15:05:24','0.00','Good','Available',NULL,'Assets',NULL,'','','','','',NULL),(7,'7','AST00223','hju',4,42,13,'2025-05-09 15:14:56','0.00','Needs Repair','Available',NULL,'Assets','{\"name\":\"nnnnnnnnn\",\"values\":[\"jjjjjjjjjjjj\",\"jjjjjjjjjj\"]}','','','','','',NULL),(8,'10','AST0008','Sample Asset',1,26,15,'2025-05-12 09:51:03','0.00','New','Available',NULL,'Assets','{\"name\":\"Sample Spe\",\"values\":[\"Samwerer\"]}','','','','','',NULL),(9,'2','OFF0009','Darren',3,38,13,'2025-05-12 12:02:12','0.00','Good','Assigned','Assets_682172c4e9172.jpg','Office Supplies','{\"name\":\"3\",\"values\":[\"234\"]}','','','','','',NULL),(10,'2','AST0010','tae',1,26,14,'2025-05-12 12:06:30','0.00','New','Available','Assets_682173c660bb6.jpg','Assets',NULL,'','','','','',NULL),(11,'2','AST0011','kele',1,26,21,'2025-05-12 12:16:04','0.00','New','Available','Assets_682176040d72d.jpg','Assets','{\"name\":\"sadf\",\"values\":[\"asdfasdfasdf\"]}','Folio','Brand1','Ream','Copier','70gsm',NULL),(12,'3','OFF0012','dddddddddddddd',2,32,15,'2025-05-12 12:23:37','0.00','New','Available',NULL,'Office Supplies','{\"name\":\"sadf\",\"values\":[\"asfdasdfasdfasdf\"]}','Large','Brand1','PC','','',NULL),(13,'2','AST0013','3da',1,27,20,'2025-05-12 12:25:03','0.00','New','Available','Assets_6821781f6b57a.jpg','Assets','{\"name\":\"dare\",\"values\":[\"asdfewr\",\"are\"]}','Extra Large','','','','',NULL),(14,'4','AST0014','xxx',1,26,12,'2025-05-12 12:32:12','0.00','Good','Available','Assets_682179cc0e5d0.jpg','Assets','{\"name\":\"dddd\",\"values\":[\"\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(15,'2','AST0015','sex',1,26,12,'2025-05-12 12:34:45','0.00','Good','Available',NULL,'Assets','{\"name\":\"asdfasdfasdf\",\"values\":[\"\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(16,'2','AST0016','meme',1,26,12,'2025-05-12 12:35:17','0.00','Good','Assigned',NULL,'Assets','{\"name\":\"asdfsadf\",\"values\":[\"asdfasdf\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(17,'2','AST0017','Tangeks',1,26,13,'2025-05-12 14:19:14','0.00','Good','Assigned','Assets_682192e2c8e92.jpg','Assets','{\"name\":\"variety\",\"values\":[\"asdfasdfasdf\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(18,'1','AST0018','Todoroki',1,26,12,'2025-05-12 14:39:25','0.00','Good','Assigned',NULL,'Assets',NULL,'Short','Hardcopy','PC','Copier','70gsm',NULL),(19,'1','AST0019','hibki',1,26,12,'2025-05-12 14:39:47','0.00','Good','Assigned',NULL,'Assets','{\"name\":\"asdf\",\"values\":[\"asdf\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(20,'1','AST0020','hibki',1,26,12,'2025-05-12 14:39:47','0.00','Good','Assigned',NULL,'Assets','{\"name\":\"asdf\",\"values\":[\"asdf\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL);

/*Table structure for table `assets_item` */

DROP TABLE IF EXISTS `assets_item`;

CREATE TABLE `assets_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` varchar(128) DEFAULT '',
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
  KEY `assets_ibfk_3` (`office_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `assets_item` */

insert  into `assets_item`(`id`,`qty`,`asset_code`,`name`,`category_id`,`subcategory_id`,`office_id`,`purchase_date`,`price`,`condition_status`,`status`,`image`,`description`,`variety`,`size`,`brand`,`unit`,`paper_type`,`thickness`,`specification`) values (1,'3','AST0014','Darren',1,27,21,'2025-05-12 12:26:22','0.00','New','Available','Assets_6821786df3d89.jpg','Assets','{\"name\":\"darbadf\",\"values\":[\"adsfafgdafgsf\"]}','A4','Brand1','PC','Multipurpose','90gsm',NULL),(2,'3','OFF0014','da',3,37,21,'2025-05-12 12:29:55','0.00','New','Available','Assets_68217943e9a92.jpg','Office Supplies','{\"name\":\"sd\",\"values\":[\"asfsd\"]}','','','','','',NULL),(3,'33','AST0017','GAGA',4,43,21,'2025-05-12 12:35:55','0.00','Good','Assigned','Assets_68217aab79f83.jpg','Assets','{\"name\":\"sadf\",\"values\":[\"ssssssssssss\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(4,'3','OFF0017','allen',2,31,12,'2025-05-12 14:08:00','0.00','Good','Assigned',NULL,'Office Supplies','{\"name\":\"asdfa\",\"values\":[\"\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(5,'3','AST0005','allen llllll',1,26,12,'2025-05-12 14:11:23','0.00','Good','Assigned','Assets_6821910bd6b26.jpg','Assets','{\"name\":\"asdfasdf\",\"values\":[\"asdf\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(6,'4','AST0006','DEDEDE',1,26,12,'2025-05-12 14:12:50','0.00','Good','Assigned','Assets_6821916207d73.jpg','Assets','{\"name\":\"asdfsdfasdfasdfasdfasdf\",\"values\":[\"3dd\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(7,'2','OFF0007','gegegege',3,37,12,'2025-05-12 14:15:44','0.00','New','Available','Assets_68219210e84c1.jpg','Office Supplies','{\"name\":\"ddddddddddd\",\"values\":[\"dddddddddddddddddddddddd\"]}','Extra Large','Hardcopy','','','',NULL),(8,'5','AST0008','ALLLLLENNNN',4,41,12,'2025-05-12 14:16:27','0.00','Good','Assigned',NULL,'Assets','{\"name\":\"asdfsdf\",\"values\":[\"\"]}','Long','Hardcopy','PC','Copier','70gsm',NULL),(9,'1','AST0009','derek ramsey',1,26,12,'2025-05-12 14:20:20','0.00','Good','Assigned','Assets_68219324d1ac5.jpg','Assets','{\"name\":\"variety\",\"values\":[\"\"]}','Short','Hardcopy','PC','Copier','70gsm',NULL),(10,'1','AST0010','SAMPLEEEEE',1,27,15,'2025-05-12 14:21:25','0.00','New','Available',NULL,'Assets','{\"name\":\"ddd\",\"values\":[\"ddd\"]}','Tabloid','Hardcopy','','','',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `maintenance_table_user` */

insert  into `maintenance_table_user`(`id`,`user_id`,`name`,`is_closed`) values (1,1,'Procurements',0),(2,1,'Purchase Order',0),(3,1,'Report Generation',0),(4,1,'Account Settings',0),(5,1,'Assets',0),(6,1,'Inventory',0),(7,1,'Receive Logs',0),(8,1,'Requisition',0),(9,0,'Procurements',0),(10,0,'Purchase Order',0),(11,0,'Report Generation',0),(12,0,'Account Settings',0),(13,0,'Assets',0),(14,0,'Inventory',0),(15,0,'Receive Logs',0),(16,0,'Requisition',0),(17,2,'Procurements',0),(18,2,'Purchase Order',0),(19,2,'Report Generation',0),(20,2,'Account Settings',0),(21,2,'Assets',0),(22,2,'Inventory',0),(23,2,'Receive Logs',0),(24,2,'Requisition',0);

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
  `recieved_number` varchar(128) DEFAULT NULL,
  `recieved_supplier_name` varchar(60) NOT NULL,
  `recieved_supplier_company` varchar(60) NOT NULL,
  `recieved_assets_name` varchar(60) NOT NULL,
  `recieved_description` text NOT NULL,
  `recieved_assets_qty` int(11) NOT NULL,
  `recieved_user_id` int(11) NOT NULL,
  PRIMARY KEY (`recieved_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `recieved_logs` */

insert  into `recieved_logs`(`recieved_id`,`recieved_date`,`recieved_number`,`recieved_supplier_name`,`recieved_supplier_company`,`recieved_assets_name`,`recieved_description`,`recieved_assets_qty`,`recieved_user_id`) values (1,'2025-04-03 16:32:42',NULL,'j supplies','j company','Scissors','pang gupit',30,1),(2,'2025-05-12 10:49:54',NULL,'','','','',0,1),(3,'2025-05-12 11:16:22',NULL,'','','','',0,1),(4,'2025-05-12 11:17:47',NULL,'','','Sample','12',20,1),(5,'2025-05-12 11:19:13','REQ-17470184951287','','','asdfasf','asdf12',23,1),(6,'2025-05-12 12:57:07','asdf','','','asf','32',2,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `request` */

insert  into `request`(`request_id`,`request_role`,`request_invoice`,`request_user_id`,`request_supplier_name`,`request_supplier_company`,`request_designation`,`request_date`,`request_status`,`status`) values (1,'Administrator','REQ-17457376783100',1,'','','','2025-05-12 09:16:51','Ongoing',1),(2,'Administrator','REQ-17470184951287',1,'','','','2025-05-12 10:54:55','pending',1),(3,'Administrator','REQ-17470280184058',1,'','','','2025-05-12 13:33:38','pending',1),(4,'Administrator','REQ-17470280222800',1,'','','','2025-05-12 13:33:42','pending',1),(5,'Administrator','REQ-17470280366568',1,'','','','2025-05-12 13:33:56','pending',1),(6,'Administrator','REQ-17470283135641',1,'','','','2025-05-12 13:38:33','pending',1),(7,'Administrator','REQ-17470283306357',1,'','','','2025-05-12 13:38:50','pending',1),(8,'Administrator','REQ-17470283414565',1,'','','','2025-05-12 13:39:01','pending',1),(9,'Administrator','REQ-17470286252112',1,'','','','2025-05-12 13:43:45','pending',1),(10,'Administrator','REQ-17470288465156',1,'','','','2025-05-12 13:47:26','pending',1),(11,'Administrator','REQ-17470289565494',1,'','','','2025-05-12 13:49:16','pending',1),(12,'Finance','REQ-17470297281886',80153,'','','','2025-05-12 14:02:45','Approve',1),(13,'Finance','REQ-17470327493017',80153,'','','','2025-05-12 14:52:29','pending',1);

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
  `specification_array_` longtext DEFAULT NULL,
  `size` varchar(128) DEFAULT NULL,
  `brand` varchar(128) DEFAULT NULL,
  `unit` varchar(128) DEFAULT NULL,
  `paper_type` varchar(128) DEFAULT NULL,
  `thickness` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `r_specification_array_` longtext DEFAULT NULL,
  `r_size` varchar(128) DEFAULT NULL,
  `r_brand` varchar(128) DEFAULT NULL,
  `r_unit` varchar(128) DEFAULT NULL,
  `r_paper_type` varchar(128) DEFAULT NULL,
  `r_thickness` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`r_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `request_item` */

insert  into `request_item`(`r_item_id`,`r_request_id`,`r_item_asset_id`,`r_item_qty`,`r_item_variety`,`r_item_price`,`r_finance_price`,`r_specification`,`r_specification_array`,`r_specification_array_`,`r_size`,`r_brand`,`r_unit`,`r_paper_type`,`r_thickness`) values (1,1,1,2,'Asfasf','0.00','200.00','','{\"name\":\"222\",\"values\":[\"22\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(2,2,1,2,'Asfasf','0.00','0.00','','{\"name\":\"222\",\"values\":[\"222\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(3,5,3,2,'Da','0.00',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL),(4,6,1,1,'Asfasf','0.00',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL),(5,6,1,2,'Asfasf','0.00',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL),(6,7,1,2,'Asfasf','0.00',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL),(7,8,1,2,'Asfasf','0.00',NULL,'','{\"name\":\"asdf\",\"values\":[\"\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(8,9,1,4,'Asfasf','0.00',NULL,'','{\"name\":\"asdfasdf\",\"values\":[\"\"]}',NULL,NULL,NULL,NULL,NULL,NULL),(9,10,6,3,'Option2','0.00',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL),(10,11,6,2,'Option2','0.00','3.00','','{\"name\":\"asdf\",\"values\":[\"sdfd\"]}',NULL,'Short','Hardcopy','PC','Copier','70gsm'),(11,12,1,2,'Asfasf','0.00',NULL,'','',NULL,'A4','Brand2','Box','Multipurpose','80gsm'),(12,13,1,2,'Adsfafgdafgsf','0.00',NULL,'','{\"name\":\"asdf\",\"values\":[\"asdfasdfsdf\"]}',NULL,'Short','Hardcopy','PC','Copier','70gsm');

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

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(128) DEFAULT NULL,
  `item_name` varchar(128) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `qty` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`supplier_name`,`item_name`,`price`,`qty`) values (1,'Darren','D',233,2),(2,'dsaf','333',3,33);

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
) ENGINE=InnoDB AUTO_INCREMENT=80154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`user_id`,`email`,`email_official`,`password`,`fullname`,`nickname`,`role`,`designation`,`profile_picture`,`created_at`,`status`) values (1,'85623','admin','admin@gmail.com','admin','admin','admin','Administrator','Computer Lab','Profile_680dbc6aa80f0.jpg','2025-04-27 13:26:17',1),(2,'23424','Head Library','Head Library@gmail.com','Head Library','Head Library','Head Library','Head Library','Head Library',NULL,'2025-05-09 14:43:09',1),(80152,'2324234234324234','Head Finance','Head Finance@gmail.com','darren','Darren Davila','CobraKai','Head Finance','Finance\'s Office',NULL,'2025-05-12 11:00:08',1),(80153,'234234234','Finance','Finance@gmail.com','Finance','Finance','Finance','Finance','Registrar\'s Office',NULL,'2025-05-12 14:01:07',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
