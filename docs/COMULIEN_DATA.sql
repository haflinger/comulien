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

insert  into `profil`(`idProfil`,`nomProfil`,`typeProfil`,`iconeProfil`) values (1,'Organisateur',0,'organisateur.png'),(2,'Corporate',0,'corps.png'),(3,'Partenaire',0,'partenaire.png');

/*Data for the table `typemessage` */

insert  into `typeMessage`(`idTypeMsg`,`lblTypeMsg`) values (0,'Défaut');

/*Data for the table `organisme` */

insert  into `organisme`(`idOrga`,`nomOrga`,`descOrga`,`logoOrga`) values (1,'Les Poulpes Team','la team des dév comulien','poulpe.png'),(2,'sncf','Entreprise Ferroviaire francaise','sncf.fr'),(3,'transilien','Transport SNCF en Ile de France','transilien.jpg');

/*Data for the table `utilisateur` */

insert  into `utilisateur`(`idUser`,`loginUser`,`pswUser`,`salt`,`emailUser`,`dateInscriptionUser`,`nomUser`,`prenomUser`,`nbMsgUser`,`nbApprouverUser`,`estActifUser`) values
(1,'alex','beb9748212d961bd8e99e59bf10eb573','','alex@mail.fr','2012-11-14 18:57:34','Alexandre','Solex',0,0,1),
(2,'fred','b795892405d279d4687ed90d6dfd906b','','fred@mail.fr','2012-11-14 18:57:52','Frédéric',NULL,0,0,1),
(3,'manu','d183f55556f9aac10044839e0d2c4557','','manu@mail.fr','2012-11-14 18:58:05',NULL,NULL,0,0,1),
(4,'laurent','d0fa4ed3c0ce524821537cc8d84a478a','','laurent@mail.fr','2012-11-14 18:58:13',NULL,NULL,0,0,1),
(5,'comulien','371d93dc80e33bb3837a1b73e71b780e','','comulien@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,0,1),
(6,'jc','3bfd7db3174cb78eed3ec886e32a02c9','','jc@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,0,1),
(7,'bénédicte','469454b74bf6d0896cba0fe8901b090c','','benedicte@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,0,1),
(8,'guillaume','469f41d575114522d5aa7e0181d9998d','','guillaume@mail.fr','2012-11-14 18:58:23',NULL,NULL,0,0,1),
(9,'inactif','f3514e9851ab349014052b47ea324c13','','inactif@mail.fr','2012-11-14 19:12:11',NULL,NULL,0,0,0),
(10,'lambda','b2230db520fed5a457f68841c319c796','','lambda@mail.fr','2012-11-14 19:21:20','toto',NULL,0,0,1);

/*Data for the table `distinguer` */

insert  into `distinguer`(`idUser`,`idOrga`,`idProfil`,`droitModeration`,`nomFonction`) values (1,1,2,1,'aiguilleur des compétences'),(1,2,2,0,'Agent d\'étude Signalisation'),(2,1,2,0,'Développeur'),(2,2,2,0,'Tractionnaire'),(3,1,2,0,'Développeur'),(3,2,2,0,'Agent Gare'),(4,1,2,0,'Designer / Référent Zend'),(4,2,2,0,'Agent Gare'),(5,1,1,1,'Team manager'),(6,1,2,0,'Découvreur ;)'),(6,2,2,0,'Agent Gare'),(7,3,1,1,'Directrice'),(8,2,1,1,'Président');

/*Data for the table `evenement` */

insert  into `evenement`(`idEvent`,`idOrga`,`titreEvent`,`numEvent`,`descEvent`,`logoEvent`,`dateDebutEvent`,`dateFinEvent`,`delaiPersistence`) values (1,1,'Bulle permanente','AZERT12345','bulle sans fin','comulien.png','2012-11-14 19:50:31',NULL,NULL),(2,1,'Bulle à venir','AZERT23456','débute dans une semaine','comulien.png','2012-11-21 19:50:31','2012-11-28 19:50:31',0),(3,3,'Train POPI','ABCD987654','Paris Saint Lazare à Mantes','ligneJ.png','2012-11-19 08:53:00','2012-11-19 09:12:00',60);

/*Data for the table `message` */

insert  into `message`(`idMessage`,`idUser_emettre`,`idTypeMsg`,`idEvent`,`lblMessage`,`idProfil`,`idUser_moderer`,`idMessage_reponse`,`dateEmissionMsg`,`dateActiviteMsg`,`estActifMsg`) values (1,1,0,1,'Bonjour à tous, bienvenue dans cette bulle permanente',1,NULL,NULL,'2012-11-19 22:13:44','2012-11-19',1),(2,2,0,1,'Salut ! C\'est parti pour des tests !',1,NULL,1,'2012-11-19 22:15:17','2012-11-19',1),(3,1,0,2,'ceci est un message insultant !!!',NULL,2,1,'2012-11-19 22:16:34','2012-11-19',0),(4,10,0,3,'Ah je prend mon train, mais pour l\'instant je suis seul',NULL,NULL,NULL,'2012-11-19 08:53:45','2012-11-19',1),(5,8,0,3,'Mais non ! moi aussi je suis dans la bulle !',NULL,NULL,NULL,'2012-11-19 08:55:35','2012-11-19',1);

/*Data for the table `apprecier` */

insert  into `apprecier`(`idMessage`,`idUser`,`evaluation`) values (1,2,-1),(3,2,1),(3,8,1),(3,10,-1),(5,10,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
