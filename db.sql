/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.27 : Database - creative
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`creative` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `creative`;

/*Table structure for table `aboutus` */

DROP TABLE IF EXISTS `aboutus`;

CREATE TABLE `aboutus` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `aboutus` */

insert  into `aboutus`(`idx`,`title`,`img`,`description`) values (1,'About Us','','<p>CREATIVISIA is an interior and architecture company it has a main office in Yogyakarta and representative office in Balikpapan, Indonesia. founded by Handitya Putra and Hery Susanto in the year 2005.</p>\n\n<p>our service includes&nbsp; for residential, office space, restaurant, hotels, villas, real estate, spa as well as other commercial buildings. Our professional team of interior designer and architects are creative people and understand to create a beautiful works, each team member plays an important role in creating design in every project with their good skill and experience our team consistently look for the harmony points in our client lifestyle that are unique and unexpected.&nbsp; we are committed to outstanding design and excellence in client services it is the foundation of our work.</p>\n\n<p>Our mission and goal is to &ldquo;Make the world more beautiful and to make people lives better&rdquo; the end result is an environment that the client can connect with and evolves and grows as they do</p>\n');

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `isnav` enum('Y','N') DEFAULT 'N',
  `sort_order` int(10) DEFAULT NULL,
  `link` varchar(25) DEFAULT NULL,
  `is_parent` enum('Y','N') DEFAULT 'N',
  `bentuk_tampilan` int(10) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`idx`,`category`,`parent`,`isnav`,`sort_order`,`link`,`is_parent`,`bentuk_tampilan`) values (19,'Home',0,'Y',0,'','Y',0),(20,'Our Services',0,'Y',0,'product','Y',0),(21,'Our Project',0,'Y',0,'product','Y',0),(22,'News',0,'Y',0,'product','Y',0),(23,'Contact Us',0,'Y',0,'product','Y',0);

/*Table structure for table `contact` */

DROP TABLE IF EXISTS `contact`;

CREATE TABLE `contact` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `alamat` text,
  `no_tlp1` varchar(50) DEFAULT NULL,
  `name_company` varchar(250) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pin` varchar(50) DEFAULT NULL,
  `no_tlp2` varchar(50) DEFAULT NULL,
  `hp1` varchar(50) DEFAULT NULL,
  `hp2` varchar(50) DEFAULT NULL,
  `hp3` varchar(50) DEFAULT NULL,
  `fb` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `gplus` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `contact` */

/*Table structure for table `history` */

DROP TABLE IF EXISTS `history`;

CREATE TABLE `history` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `history` varchar(255) DEFAULT NULL,
  `ishome` enum('Y','N') DEFAULT 'N',
  `img` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `history` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `is_home` enum('Y','N') DEFAULT 'N',
  `description` text,
  `idcategory` int(10) DEFAULT NULL,
  `is_sliderhome` enum('Y','N') DEFAULT 'N',
  `tgl_input` date DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `product` */

insert  into `product`(`idx`,`product`,`img`,`is_home`,`description`,`idcategory`,`is_sliderhome`,`tgl_input`) values (9,'Studio Desain','http://localhost/creativepro/uploaded/images/074-ecrl-29may06_homepromo.jpg','Y','',0,'N','2014-05-12'),(10,'Properti News','http://localhost/creativepro/uploaded/images/20121005-bsf-0151_homepromo.jpg','Y','',0,'N','2014-05-12'),(11,'Job News','http://localhost/creativepro/uploaded/images/20090825-6917-thiess_200x150.jpg','Y','',0,'N','2014-05-12'),(12,'Utatse eudui pretium','','N','<p>CREATIVISIA is an interior and architecture company it has a main office in Yogyakarta and representative office in Balikpapan, Indonesia. founded by Handitya Putra and Hery Susanto in the year 2005.</p>\n\n<p>our service includes&nbsp; for residential, office space, restaurant, hotels, villas, real estate, spa as well as other commercial buildings. Our professional team of interior designer and architects are creative people and understand to create a beautiful works, each team member plays an important role in creating design in every project with their good skill and experience our team consistently look for the harmony points in our client lifestyle that are unique and unexpected.&nbsp; we are committed to outstanding design and excellence in client services it is the foundation of our work.</p>\n\n<p>Our mission and goal is to &ldquo;Make the world more beautiful and to make people lives better&rdquo; the end result is an environment that the client can connect with and evolves and grows as they do</p>\n',22,'N','2014-05-12'),(13,'tes','http://localhost/creativepro/uploaded/images/page3-img3.png','N','',20,'N','2014-05-12'),(14,'tes','http://localhost/creativepro/uploaded/images/page1-img1.png','N','',20,'N','2014-05-12'),(15,'Gendhis Spa','http://localhost/creativepro/uploaded/images/page3-img1.png','N','Yogyakarta (Interior Design &amp; Project)',20,'N','2014-05-12');

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `Title` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(25) DEFAULT NULL,
  `sort_order` int(10) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `slider` */

insert  into `slider`(`idx`,`Title`,`image`,`link`,`sort_order`,`description`) values (5,'','http://localhost/creativepro/uploaded/images/slider-img2.jpg','',0,''),(6,'','http://localhost/creativepro/uploaded/images/slider-img1.jpg','',0,''),(7,'','http://localhost/creativepro/uploaded/images/slider-img3.jpg','',0,'');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `randcode` varchar(50) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

/*Table structure for table `visitpage` */

DROP TABLE IF EXISTS `visitpage`;

CREATE TABLE `visitpage` (
  `idx` int(10) NOT NULL AUTO_INCREMENT,
  `ipaddr` varchar(50) DEFAULT NULL,
  `dateadd` date DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `visitpage` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
