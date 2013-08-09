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

/*Table structure for table `faq` */

DROP TABLE IF EXISTS `faq`;

CREATE TABLE `faq` (
  `id` int(11) NOT NULL auto_increment,
  `question` text,
  `answer` text,
  `is_visible` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `faq` */

insert  into `faq`(`id`,`question`,`answer`,`is_visible`) values (1,'Вопрос №1','Ответ №1',1),(2,'Второй вопрос','Второй ответ',1),(3,'<p>Большой текст третьего вопроса. Нет, не так. ООООЧЕНЬ большой текст третьего вопроса! Такой большой, что даже пожалуй на несколько экранов хватит. Ну ладно, может и загнул, на несколько экранов не хватит, но на несколько строк точно должно хватить. </p>\r\n<p>А это вторая строка ну оооочень длинного вопроса. Даже не знаю, что ещё такого написать тут!</p>','<p>Не менее большой текст ответа, который включает в себя классический лорем ипсум. Лорем ипсум - это так называемая рыба. но в нашем случае это будет не рыба, а такая себе \"рыбка\", так как чуть чуть урезанная получается. Вот такие пироги с картошкой!</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',1),(4,'Скрытый четвертый вопрос','Скрытый четвертый ответ',0),(5,'Открытый пятый вопрос (в отличие от четвертого, которого не видно)','Открыытй пятый ответ (в отличие от четвертого, который спрятался)',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
