/*Table structure for table `drugstores` */

DROP TABLE IF EXISTS `drugstores`;

CREATE TABLE `drugstores` (
  `id` smallint(6) NOT NULL auto_increment,
  `brand_id` smallint(6) NOT NULL,
  `city_id` smallint(6) NOT NULL,
  `district` enum('Дарницкий р-н','Деснянский р-н','Днепровский р-н','Голосеевский р-н','Оболонский р-н','Печерский р-н','Подольский р-н','Святошинский р-н','Соломенский р-н','Шевченковский р-н') default NULL,
  `address` varchar(100) default NULL,
  `phone` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `brand_id` (`brand_id`),
  KEY `districts` (`district`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores` */

insert  into `drugstores`(`id`,`brand_id`,`city_id`,`district`,`address`,`phone`) values (6,1,1,'Дарницкий р-н','ул. Харьковское шоссе, 29','576-43-92'),(7,1,1,'Дарницкий р-н','ул. Кошица, 10/21','565-18-93'),(8,1,1,'Дарницкий р-н','пр. Бажана, 8 (ТЦ \"Novus\")','364-71-68'),(9,2,1,'Дарницкий р-н','ул. Драгоманова, 31Б (круглосуточная аптека)','572-31-48'),(10,2,1,'Дарницкий р-н','Харьковское шоссе, 152','576-04-42'),(11,2,1,'Дарницкий р-н','Харьковское шоссе, 53 (круглосуточная аптека)','576-05-23'),(12,4,1,'Дарницкий р-н','ул. Урловская 11/44 (район м. Осокорки)','575-94-41'),(13,5,1,'Деснянский р-н','ул. Закревского, 75/2','503-63-02'),(14,6,1,'Днепровский р-н','ул. А. Бучмы, 2','553-95-38');

/*Table structure for table `drugstores_brands` */

DROP TABLE IF EXISTS `drugstores_brands`;

CREATE TABLE `drugstores_brands` (
  `id` smallint(6) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `logo` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores_brands` */

insert  into `drugstores_brands`(`id`,`title`,`logo`) values (1,'Аптека доброго дня','61ca3-apteka_dobrogo_dnya.png'),(2,'Виталюкс','8e165-vialux.png'),(4,'ТАС №27','9ce4e-tas.png'),(5,'Аптека \"36.6\"','aeec8-366.png'),(6,'\"Країна здоров\'я\"','8557b-kraina.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `drugstores_regions` */

insert  into `drugstores_regions`(`id`,`alias`,`title`) values (1,'kiev-region','Киевская область'),(2,'odessa-region','Одесская область'),(3,NULL,'Житомирская область');