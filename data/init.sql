# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.23)
# Database: BookSeller
# Generation Time: 2019-02-14 01:42:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bookinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bookinfo`;

CREATE TABLE `bookinfo` (
  `book_id` int(100) NOT NULL AUTO_INCREMENT,
  `book_creator` int(100) NOT NULL,
  `course_number` varchar(30) NOT NULL DEFAULT '',
  `book_name` varchar(30) NOT NULL,
  `book_author` varchar(30) NOT NULL,
  `book_price` int(11) NOT NULL,
  `is_available` varchar(30) NOT NULL DEFAULT '',
  `ISBN` int(25) DEFAULT NULL,
  UNIQUE KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bookinfo` WRITE;
/*!40000 ALTER TABLE `bookinfo` DISABLE KEYS */;

INSERT INTO `bookinfo` (`book_id`, `book_creator`, `course_number`, `book_name`, `book_author`, `book_price`, `is_available`, `ISBN`)
VALUES
	(1,2,'CIS 351','Basic Data Structures','John Smith',120,'Available',1223),
	(2,10,'MAT 300','Essential Calculus I','James Stewart',155,'Available',56765),
	(3,10,'MAT 255','Essential Calculus II','James Stewart',199,'Available',9897),
	(4,1,'CIS 477','Operating Systems','Jae Oh',105,'Shipped',8676),
	(5,1,'MAT 322','Essential Calculus III','James Stewart',201,'Available',5865),
	(6,10,'MAT 644','Statistics 101','John Doe',25,'Shipped',754765),
	(7,3,'CIS 400','Algorithms','John Doe',250,'Available',98776),
	(8,3,'SOR 233','Game of Thrones','George RR. Martin',25,'Available',98765),
	(9,10,'SOR 355','Harry Potter','JK Rowling',100,'Shipped',68564),
	(10,4,'CIS 500','Web Design for Nubes','Brian Welsh',4,'Available',8796),
	(11,4,'gtbetyh','ythruytn','yth6uj',300,'Available',98676),
	(12,4,'MAT 200','intro to math','math wizard',7000,'Available',8676);

/*!40000 ALTER TABLE `bookinfo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_creator` int(11) NOT NULL,
  `report_title` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `report_status` varchar(10) NOT NULL,
  `comments` varchar(500) NOT NULL,
  UNIQUE KEY `report_id` (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;

INSERT INTO `reports` (`report_id`, `report_creator`, `report_title`, `description`, `report_status`, `comments`)
VALUES
	(1,2,'Shipping error','Product not shipped','Open','Right on that'),
	(2,3,'Mispelling on Buy Page','Page header had Youre instead of Your','Closed','Updated. Thank you for your input'),
	(3,4,'Profanity','One of the book names has a swear word','Closed','Textbook Deleted. Thank you for your input.');

/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `user_type` varchar(6) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;

INSERT INTO `user_info` (`user_id`, `user_name`, `user_type`, `user_email`, `user_password`)
VALUES
	(1,'Rafi Rafsan','Seller','rafirrr@gmail.com','password1'),
	(2,'Brian Welsh','Seller','brianw@syr.edu','Password2'),
	(3,'Beibei Zhang','Buyer','beibeiz@syr.edu','password3'),
	(4,'Zhijan Chen','Seller','zchen@syr.edu','password4'),
	(5,'Jiaqi Feng','Buyer','jfeng@syr.edu','password4'),
	(6,'Michael Scott','Buyer','mscott@gmail.com','dundermifflin'),
	(7,'Bruce Wayne','Seller','bwayne@syr.edu','Batman'),
	(8,'admin','Admin','admin@syr.edu','admin'),
	(9,'buyer','Buyer','buyer@syr.edu','buyer'),
	(10,'seller','Seller','seller@syr.edu','seller');

/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
