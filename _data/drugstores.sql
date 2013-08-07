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
  `district` enum('Дарницкий р-н','Деснянский р-н','Днепровский р-н','Голосеевский р-н','Оболонский р-н','Печерский р-н','Подольский р-н','Святошинский р-н','Соломенский р-н','Шевченковский р-н') default NULL,
  `address` varchar(100) default NULL,
  `phone` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores` */

insert  into `drugstores`(`id`,`brand_id`,`city_id`,`district`,`address`,`phone`) values (1,1,1,'Голосеевский р-н','Тестовый адрес','123'),(2,1,1,'Дарницкий р-н','Тестовый адрес 2','222'),(3,2,1,'Днепровский р-н','Тестовый адресс 3','222'),(4,1,1,'Голосеевский р-н','Тестовый адресс 4','544'),(5,3,2,'Соломенский р-н','Тестовый адресс 5','555');

/*Table structure for table `drugstores_brands` */

DROP TABLE IF EXISTS `drugstores_brands`;

CREATE TABLE `drugstores_brands` (
  `id` smallint(6) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `logo` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores_brands` */

insert  into `drugstores_brands`(`id`,`title`,`logo`) values (1,'Аптека доброго дня','123.jpg'),(2,'Фармак','111.jpg'),(3,'Тестовая аптека 1','124.jpg'),(4,'Тестовая аптека 2','125.jpg');

/*Table structure for table `drugstores_cities` */

DROP TABLE IF EXISTS `drugstores_cities`;

CREATE TABLE `drugstores_cities` (
  `id` smallint(6) NOT NULL auto_increment,
  `region_id` smallint(6) default NULL,
  `alias` varchar(50) default NULL,
  `title` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `alias` (`alias`),
  KEY `region_id` (`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores_cities` */

insert  into `drugstores_cities`(`id`,`region_id`,`alias`,`title`) values (1,1,'kiev','Киев'),(2,1,'boryspol','Борисполь'),(3,2,'odessa','Одесса');

/*Table structure for table `drugstores_regions` */

DROP TABLE IF EXISTS `drugstores_regions`;

CREATE TABLE `drugstores_regions` (
  `id` smallint(6) NOT NULL auto_increment,
  `alias` varchar(50) default NULL,
  `title` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores_regions` */

insert  into `drugstores_regions`(`id`,`alias`,`title`) values (1,'kiev-region','Киевская область'),(2,'odessa-region','Одесская область');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
