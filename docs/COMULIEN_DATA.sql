<<<<<<< HEAD
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

/*Data for the table `apprecier` */

/*Data for the table `distinguer` */

insert  into `distinguer`(`IDUSER`,`IDORGA`,`IDPROFIL`,`DROITMODERATION`,`NOMFONCTION`) values (1,1,2,1,'aiguilleur des compétences'),(1,2,2,0,'Agent d\'étude Signalisation'),(2,1,2,0,'Développeur'),(2,2,2,0,'Tractionnaire'),(3,1,2,0,'Développeur'),(3,2,2,0,'Agent Gare'),(4,1,2,0,'Designer / Référent Zend'),(4,2,2,0,'Agent Gare'),(5,1,1,1,'Team manager'),(6,1,2,0,'Découvreur ;)'),(6,2,2,0,'Agent Gare'),(7,3,1,1,'Directrice'),(8,2,1,1,'Président');

/*Data for the table `evenement` */

insert  into `evenement`(`IDEVENT`,`IDORGA`,`NUMEVENT`,`TITREEVENT`,`DESCEVENT`,`LOGOEVENT`,`DATEDEBUTEVENT`,`DATEFINEVENT`,`DELAIPERSISTENCE`) values (1,1,'AZERT12345','Bulle permanente','bulle sans fin','comulien.png','2012-11-14 19:50:31',NULL,NULL),(2,1,'AZERT23456','Bulle à venir','débute dans une semaine','comulien.png','2012-11-21 19:50:31','2012-11-28 19:50:31',0);

/*Data for the table `message` */

/*Data for the table `organisme` */

insert  into `organisme`(`IDORGA`,`NOMORGA`,`DESCORGA`,`LOGOORGA`) values (1,'Les Poulpes Team','la team des dév comulien','poulpe.png'),(2,'sncf','Entreprise Ferroviaire francaise','sncf.fr'),(3,'transilien','Transport SNCF en Ile de France','transilien.jpg');

/*Data for the table `profil` */

insert  into `profil`(`IDPROFIL`,`NOMPROFIL`,`TYPEPROFIL`,`ICONEPROFIL`) values (1,'Organisateur',0,'organisateur.png'),(2,'Corporate',0,'corps.png'),(3,'Partenaire',0,'partenaire.png');

/*Data for the table `typemessage` */

insert  into `typemessage`(`IDTYPEMSG`,`LBLTYPEMSG`) values (0,'Défaut');

/*Data for the table `utilisateur` */

insert  into `utilisateur`(`IDUSER`,`LOGINUSER`,`PSWUSER`,`EMAILUSER`,`DATEINSCRIPTIONUSER`,`NBMSGUSER`,`NBAPPROUVUSER`,`ESTACTIFUSER`) values (1,'alex','pswalex','alex@mail.fr','2012-11-14 18:57:34',0,NULL,1),(2,'fred','pswfred','fred@mail.fr','2012-11-14 18:57:52',0,NULL,1),(3,'manu','pswmanu','manu@mail.fr','2012-11-14 18:58:05',0,NULL,1),(4,'laurent','pswlaurent','laurent@mail.fr','2012-11-14 18:58:13',0,NULL,1),(5,'comulien','pswcomulien','comulien@mail.fr','2012-11-14 18:58:23',0,NULL,1),(6,'jc','pswjc','jc@mail.fr','2012-11-14 18:58:23',0,NULL,1),(7,'bénédicte','pswbenedicte','benedicte@mail.fr','2012-11-14 18:58:23',0,NULL,1),(8,'guillaume','pswguillaume','guillaume@mail.fr','2012-11-14 18:58:23',0,NULL,1),(9,'inactif','pswinactif','inactif@mail.fr','2012-11-14 19:12:11',0,NULL,0),(10,'lambda','pswlambda','lambda@mail.fr','2012-11-14 19:21:20',0,NULL,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
=======
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

/*Data for the table `profil` */

insert  into `profil`(`IDPROFIL`,`NOMPROFIL`,`TYPEPROFIL`,`ICONEPROFIL`) values (1,'Organisateur',0,'organisateur.png'),(2,'Corporate',0,'corps.png'),(3,'Partenaire',0,'partenaire.png');

/*Data for the table `typemessage` */

insert  into `typemessage`(`IDTYPEMSG`,`LBLTYPEMSG`) values (0,'Défaut');

/*Data for the table `organisme` */

insert  into `organisme`(`IDORGA`,`NOMORGA`,`DESCORGA`,`LOGOORGA`) values (1,'Les Poulpes Team','la team des dév comulien','poulpe.png'),(2,'sncf','Entreprise Ferroviaire francaise','sncf.fr'),(3,'transilien','Transport SNCF en Ile de France','transilien.jpg');

/*Data for the table `utilisateur` */

insert  into `utilisateur`(`IDUSER`,`LOGINUSER`,`PSWUSER`,`EMAILUSER`,`DATEINSCRIPTIONUSER`,`NOMUSER`,`PRENOMUSER`,`NBMSGUSER`,`NBAPPROUVUSER`,`ESTACTIFUSER`) values (1,'alex','pswalex','alex@mail.fr','2012-11-14 18:57:34','Alexandre','Solex',0,NULL,1),(2,'fred','pswfred','fred@mail.fr','2012-11-14 18:57:52','Frédéric',NULL,0,NULL,1),(3,'manu','pswmanu','manu@mail.fr','2012-11-14 18:58:05',NULL,NULL,0,NULL,1),(4,'laurent','pswlaurent','laurent@mail.fr','2012-11-14 18:58:13',NULL,NULL,0,NULL,1),(5,'comulien','pswcomulien','comulien@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,NULL,1),(6,'jc','pswjc','jc@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,NULL,1),(7,'bénédicte','pswbenedicte','benedicte@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,NULL,1),(8,'guillaume','pswguillaume','guillaume@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,NULL,1),(9,'inactif','pswinactif','inactif@mail.fr','2012-11-14 19:12:11',NULL,NULL,0,NULL,0),(10,'lambda','pswlambda','lambda@mail.fr','2012-11-14 19:21:20','toto',NULL,0,NULL,1);

/*Data for the table `distinguer` */

insert  into `distinguer`(`IDUSER`,`IDORGA`,`IDPROFIL`,`DROITMODERATION`,`NOMFONCTION`) values (1,1,2,1,'aiguilleur des compétences'),(1,2,2,0,'Agent d\'étude Signalisation'),(2,1,2,0,'Développeur'),(2,2,2,0,'Tractionnaire'),(3,1,2,0,'Développeur'),(3,2,2,0,'Agent Gare'),(4,1,2,0,'Designer / Référent Zend'),(4,2,2,0,'Agent Gare'),(5,1,1,1,'Team manager'),(6,1,2,0,'Découvreur ;)'),(6,2,2,0,'Agent Gare'),(7,3,1,1,'Directrice'),(8,2,1,1,'Président');

/*Data for the table `evenement` */

insert  into `evenement`(`IDEVENT`,`IDORGA`,`TITREEVENT`,`NUMEVENT`,`DESCEVENT`,`LOGOEVENT`,`DATEDEBUTEVENT`,`DATEFINEVENT`,`DELAIPERSISTENCE`) values (1,1,'Bulle permanente','AZERT12345','bulle sans fin','comulien.png','2012-11-14 19:50:31',NULL,NULL),(2,1,'Bulle à venir','AZERT23456','débute dans une semaine','comulien.png','2012-11-21 19:50:31','2012-11-28 19:50:31',0),(3,3,'Train POPI','ABCD987654','Paris Saint Lazare à Mantes','ligneJ.png','2012-11-19 08:53:00','2012-11-19 09:12:00',60);

/*Data for the table `message` */

insert  into `message`(`IDMESSAGE`,`IDUSER_EMETTRE`,`IDTYPEMSG`,`IDEVENT`,`LBLMESSAGE`,`IDPROFIL`,`IDUSER_MODERER`,`IDMESSAGE_REPONSE`,`DATEEMISSIONMSG`,`DATEACTIVITEMSG`,`ESTACTIFMSG`) values (1,1,0,1,'Bonjour à tous, bienvenue dans cette bulle permanente',1,NULL,NULL,'2012-11-19 22:13:44','2012-11-19',1),(2,2,0,1,'Salut ! C\'est parti pour des tests !',1,NULL,1,'2012-11-19 22:15:17','2012-11-19',1),(3,1,0,2,'ceci est un message insultant !!!',NULL,2,1,'2012-11-19 22:16:34','2012-11-19',0),(4,10,0,3,'Ah je prend mon train, mais pour l\'instant je suis seul',NULL,NULL,NULL,'2012-11-19 08:53:45','2012-11-19',1),(5,8,0,3,'Mais non ! moi aussi je suis dans la bulle !',NULL,NULL,NULL,'2012-11-19 08:55:35','2012-11-19',1);

/*Data for the table `apprecier` */

insert  into `apprecier`(`IDMESSAGE`,`IDUSER`,`EVALUATION`) values (1,2,'+'),(3,2,'-'),(3,8,'-'),(3,10,'+'),(5,10,'+');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
>>>>>>> branch 'master' of https://github.com/haflinger/comulien.git
