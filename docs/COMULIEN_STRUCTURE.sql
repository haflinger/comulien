/*
SQLyog Community v10.3 
MySQL - 5.5.24-log : Database - comulien
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`comulien` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `comulien`;

/*Table structure for table `apprecier` */

DROP TABLE IF EXISTS `apprecier`;

CREATE TABLE `apprecier` (
  `IDMESSAGE` BIGINT(4) NOT NULL,
  `IDUSER` BIGINT(4) NOT NULL,
  `EVALUATION` CHAR(32) DEFAULT NULL,
  PRIMARY KEY (`IDMESSAGE`,`IDUSER`),
  KEY `FK_APPRECIER_UTILISATEUR` (`IDUSER`),
  CONSTRAINT `apprecier_ibfk_2` FOREIGN KEY (`IDUSER`) REFERENCES `utilisateur` (`IDUSER`),
  CONSTRAINT `apprecier_ibfk_1` FOREIGN KEY (`IDMESSAGE`) REFERENCES `message` (`IDMESSAGE`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Table structure for table `distinguer` */

DROP TABLE IF EXISTS `distinguer`;

CREATE TABLE `distinguer` (
  `IDUSER` BIGINT(4) NOT NULL,
  `IDORGA` BIGINT(4) NOT NULL,
  `IDPROFIL` BIGINT(4) NOT NULL,
  `DROITMODERATION` TINYINT(1) DEFAULT '0',
  `NOMFONCTION` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`IDUSER`,`IDORGA`),
  KEY `FK_DISTINGUER_PROFIL` (`IDPROFIL`),
  KEY `FK_DISTINGUER_ORGANISME` (`IDORGA`),
  CONSTRAINT `distinguer_ibfk_3` FOREIGN KEY (`IDORGA`) REFERENCES `organisme` (`IDORGA`),
  CONSTRAINT `distinguer_ibfk_1` FOREIGN KEY (`IDUSER`) REFERENCES `utilisateur` (`IDUSER`),
  CONSTRAINT `distinguer_ibfk_2` FOREIGN KEY (`IDPROFIL`) REFERENCES `profil` (`IDPROFIL`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Table structure for table `evenement` */

DROP TABLE IF EXISTS `evenement`;

CREATE TABLE `evenement` (
  `IDEVENT` BIGINT(4) NOT NULL AUTO_INCREMENT,
  `IDORGA` BIGINT(4) NOT NULL,
  `NUMEVENT` VARCHAR(255) NOT NULL,
  `TITREEVENT` CHAR(100) NOT NULL,
  `DESCEVENT` VARCHAR(255) DEFAULT NULL,
  `LOGOEVENT` VARCHAR(128) DEFAULT NULL,
  `DATEDEBUTEVENT` DATETIME NOT NULL,
  `DATEFINEVENT` DATETIME DEFAULT NULL,
  `DELAIPERSISTENCE` INT(2) DEFAULT NULL,
  PRIMARY KEY (`IDEVENT`),
  KEY `FK_EVENEMENT_ORGANISME` (`IDORGA`),
  CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`IDORGA`) REFERENCES `organisme` (`IDORGA`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `IDMESSAGE` BIGINT(4) NOT NULL AUTO_INCREMENT,
  `IDUSER` BIGINT(4) DEFAULT NULL,
  `IDTYPEMSG` INT(2) NOT NULL,
  `IDMESSAGE_REPONSE` BIGINT(4) DEFAULT NULL,
  `IDUSER_EMETTRE` BIGINT(4) NOT NULL,
  `IDEVENT` BIGINT(4) NOT NULL,
  `IDPROFIL` BIGINT(4) NOT NULL,
  `LBLMESSAGE` VARCHAR(255) NOT NULL,
  `DATEEMISSIONMSG` DATETIME DEFAULT NULL,
  `DATEACTIVITEMSG` DATE DEFAULT NULL,
  `ESTACTIFMSG` TINYINT(1) DEFAULT '1',
  PRIMARY KEY (`IDMESSAGE`),
  KEY `FK_MESSAGE_UTILISATEUR` (`IDUSER`),
  KEY `FK_MESSAGE_TYPEMESSAGE` (`IDTYPEMSG`),
  KEY `FK_MESSAGE_MESSAGE` (`IDMESSAGE_REPONSE`),
  KEY `FK_MESSAGE_UTILISATEUR1` (`IDUSER_EMETTRE`),
  KEY `FK_MESSAGE_EVENEMENT` (`IDEVENT`),
  KEY `FK_MESSAGE_PROFIL` (`IDPROFIL`),
  CONSTRAINT `message_ibfk_5` FOREIGN KEY (`IDEVENT`) REFERENCES `evenement` (`IDEVENT`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`IDUSER_MODERER`) REFERENCES `utilisateur` (`IDUSER`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`IDTYPEMSG`) REFERENCES `typemessage` (`IDTYPEMSG`),
  CONSTRAINT `message_ibfk_3` FOREIGN KEY (`IDMESSAGE_REPONSE`) REFERENCES `message` (`IDMESSAGE`),
  CONSTRAINT `message_ibfk_4` FOREIGN KEY (`IDUSER_EMETTRE`) REFERENCES `utilisateur` (`IDUSER`),
  CONSTRAINT `message_ibfk_6` FOREIGN KEY (`IDPROFIL`) REFERENCES `profil` (`IDPROFIL`),
) ENGINE=INNODB DEFAULT CHARSET=latin1;

   

/*Table structure for table `organisme` */

DROP TABLE IF EXISTS `organisme`;

CREATE TABLE `organisme` (
  `IDORGA` BIGINT(4) NOT NULL AUTO_INCREMENT,
  `NOMORGA` VARCHAR(128) DEFAULT NULL,
  `DESCORGA` VARCHAR(255) DEFAULT NULL,
  `LOGOORGA` VARCHAR(128) DEFAULT NULL,
  PRIMARY KEY (`IDORGA`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `profil` */

DROP TABLE IF EXISTS `profil`;

CREATE TABLE `profil` (
  `IDPROFIL` BIGINT(4) NOT NULL,
  `NOMPROFIL` VARCHAR(128) NOT NULL,
  `TYPEPROFIL` BIGINT(4) DEFAULT NULL,
  `ICONEPROFIL` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`IDPROFIL`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Table structure for table `typemessage` */

DROP TABLE IF EXISTS `typemessage`;

CREATE TABLE `typemessage` (
  `IDTYPEMSG` INT(2) NOT NULL,
  `LBLTYPEMSG` VARCHAR(128) DEFAULT NULL,
  PRIMARY KEY (`IDTYPEMSG`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Table structure for table `utilisateur` */

DROP TABLE IF EXISTS `utilisateur`;

CREATE TABLE `utilisateur` (
  `IDUSER` BIGINT(4) NOT NULL AUTO_INCREMENT,
  `LOGINUSER` varchar(128) NOT NULL,
  `PSWUSER` varchar(128) NOT NULL,
  `EMAILUSER` varchar(128) NOT NULL,
  `DATEINSCRIPTIONUSER` datetime NOT NULL,
  `NBMSGUSER` bigint(4) DEFAULT NULL,
  `NBAPPROUVUSER` bigint(4) DEFAULT NULL,
  `ESTACTIFUSER` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`IDUSER`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;