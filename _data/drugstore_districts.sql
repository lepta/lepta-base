/*
SQLyog Community v9.63 
MySQL - 5.0.51b-community-nt : Database - leptaden
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`leptaden` /*!40100 DEFAULT CHARACTER SET utf8 */;

/*Table structure for table `drugstores` */

DROP TABLE IF EXISTS `drugstores`;

CREATE TABLE `drugstores` (
  `id` smallint(6) NOT NULL auto_increment,
  `brand_id` smallint(6) NOT NULL,
  `city_id` smallint(6) NOT NULL,
  `district_id` int(11) default NULL,
  `address` varchar(100) default NULL,
  `add_address1` varchar(100) default NULL,
  `add_address2` varchar(100) default NULL,
  `add_address3` varchar(100) default NULL,
  `phone1` varchar(30) default NULL,
  `phone2` varchar(30) default NULL,
  `phone3` varchar(30) default NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `brand_id` (`brand_id`),
  KEY `districts` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores` */

insert  into `drugstores`(`id`,`brand_id`,`city_id`,`district_id`,`address`,`add_address1`,`add_address2`,`add_address3`,`phone1`,`phone2`,`phone3`) values (6,1,1,NULL,'ул. Харьковское шоссе, 29',NULL,NULL,NULL,'576-43-92',NULL,NULL),(7,1,1,NULL,'ул. Кошица, 10/21',NULL,NULL,NULL,'565-18-93',NULL,NULL),(8,1,1,NULL,'пр. Бажана, 8','ТЦ \"Novus\"',NULL,NULL,'364-71-68',NULL,NULL),(9,2,1,NULL,'ул. Драгоманова, 31Б (круглосуточная аптека)',NULL,NULL,NULL,'572-31-48',NULL,NULL),(10,2,2,NULL,'Харьковское шоссе, 152',NULL,NULL,NULL,'576-04-42',NULL,NULL),(11,2,1,8,'Харьковское шоссе, 53 (круглосуточная аптека)',NULL,NULL,NULL,'576-05-23',NULL,NULL),(12,4,1,NULL,'ул. Урловская 11/44 ','фыв','йцу','ясч','575-94-41','575-94-42','575-94-43'),(13,5,3,11,'ул. Закревского, 75/2',NULL,NULL,NULL,'503-63-02',NULL,NULL),(14,6,1,2,'ул. А. Бучмы, 2',NULL,NULL,NULL,'553-95-38',NULL,NULL);

/*Table structure for table `drugstores_districts` */

DROP TABLE IF EXISTS `drugstores_districts`;

CREATE TABLE `drugstores_districts` (
  `id` int(11) NOT NULL auto_increment,
  `city_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores_districts` */

insert  into `drugstores_districts`(`id`,`city_id`,`title`) values (1,1,'Голосеевский р-н'),(2,1,'Дарницкий р-н'),(3,1,'Деснянский р-н'),(4,1,'Днепровский р-н'),(5,1,'Оболонский р-н'),(6,1,'Печерский р-н'),(7,1,'Подольский р-н'),(8,1,'Святошинский р-н'),(9,1,'Соломенский р-н'),(10,1,'Шевченковский р-н'),(11,3,'Одесский р-н');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
