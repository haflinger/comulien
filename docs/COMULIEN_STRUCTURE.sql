/*
Changements :
2012/11/19 : 
  - changement des libellé des clés étrangères IdUser dans la table Message provenant de la table utilisateur
2012/11/25 : 
  - renommage des tables et des champs en utilisant la notation camelcase
*/
DROP DATABASE IF EXISTS `comulien`;

CREATE DATABASE IF NOT EXISTS `comulien`;
USE `comulien`;
# -----------------------------------------------------------------------------
#       TABLE : utilisateur
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `utilisateur`
 (
   `idUser` BIGINT(4) NOT NULL AUTO_INCREMENT ,
   `loginUser` VARCHAR(128) NOT NULL  ,
   `pswUser` VARCHAR(128) NOT NULL  ,
   `emailUser` VARCHAR(128) NOT NULL  ,
   `dateInscriptionUser` DATETIME NOT NULL  ,
   `nomUser` VARCHAR(128) NULL  ,
   `prenomUser` VARCHAR(128) NULL  ,
   `nbMsgUser` BIGINT(4) NULL  
      DEFAULT 0,
   `nbApprouverUser` BIGINT(4) NULL  ,
   `estActifUser` BOOL NULL  
      DEFAULT TRUE
   , PRIMARY KEY (`idUser`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : evenement
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `evenement`
 (
   `idEvent` BIGINT(4) NOT NULL AUTO_INCREMENT ,
   `idOrga` BIGINT(4) NOT NULL  ,
   `titreEvent` CHAR(100) NOT NULL  ,
   `numEvent` VARCHAR(255) NOT NULL  ,
   `descEvent` VARCHAR(255) NULL  ,
   `logoEvent` VARCHAR(128) NULL  ,
   `dateDebutEvent` DATETIME NOT NULL  ,
   `dateFinEvent` DATETIME NULL  ,
   `delaiPersistence` INTEGER(2) NULL  
   , PRIMARY KEY (`idEvent`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : profil
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `profil`
 (
   `idProfil` BIGINT(4) NOT NULL  ,
   `nomProfil` VARCHAR(128) NOT NULL  ,
   `typeProfil` BIGINT(4) NULL  ,
   `iconeProfil` VARCHAR(255) NULL  
   , PRIMARY KEY (`idProfil`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : message
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `message`
 (
   `idMessage` BIGINT(4) NOT NULL AUTO_INCREMENT ,
   `idUser_emettre` BIGINT(4) NOT NULL  ,
   `idTypeMsg` INTEGER(2) NOT NULL  ,
   `idEvent` BIGINT(4) NOT NULL  ,
   `lblMessage` VARCHAR(255) NOT NULL  ,
   `idProfil` BIGINT(4) NULL  ,
   `idUser_moderer` BIGINT(4) NULL  ,
   `idMessage_reponse` BIGINT(4) NULL  ,
   `dateEmissionMsg` DATETIME NULL  ,
   `dateActiviteMsg` DATETIME NULL  ,
   `estActifMsg` BOOL NULL  
      DEFAULT TRUE
   , PRIMARY KEY (`idMessage`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : organisme
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `organisme`
 (
   `idOrga` BIGINT(4) NOT NULL AUTO_INCREMENT ,
   `nomOrga` VARCHAR(128) NULL  ,
   `descOrga` VARCHAR(255) NULL  ,
   `logoOrga` VARCHAR(128) NULL  
   , PRIMARY KEY (`idOrga`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : typeMessage
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `typeMessage`
 (
   `idTypeMsg` INTEGER(2) NOT NULL  ,
   `lblTypeMsg` VARCHAR(128) NULL  
   , PRIMARY KEY (`idTypeMsg`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : distinguer
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `distinguer`
 (
   `idUser` BIGINT(4) NOT NULL  ,
   `idOrga` BIGINT(4) NOT NULL  ,
   `idProfil` BIGINT(4) NOT NULL  ,
   `droitModeration` BOOL NULL  
      DEFAULT FALSE,
   `nomFonction` VARCHAR(50) NULL  
   , PRIMARY KEY (`idUser`,`idOrga`) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : apprecier
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `apprecier`
 (
   `idMessage` BIGINT(4) NOT NULL  ,
   `idUser` BIGINT(4) NOT NULL  ,
   `evaluation` CHAR(32) NULL  
   , PRIMARY KEY (`idMessage`,`idUser`) 
 ) 
 COMMENT = "";


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE table
# -----------------------------------------------------------------------------


ALTER TABLE `evenement` 
  ADD FOREIGN KEY FK_EVENEMENT_ORGANISME (`idOrga`)
      REFERENCES `organisme` (`idOrga`) ;


ALTER TABLE `message`
  ADD FOREIGN KEY FK_MESSAGE_PROFIL (`idProfil`)
      REFERENCES `profil` (`idProfil`) ;


ALTER TABLE `message` 
  ADD FOREIGN KEY FK_MESSAGE_UTILISATEURMODERER (`idUser_moderer`)
      REFERENCES `utilisateur` (`idUser`) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_TYPEMESSAGE (`idTypeMsg`)
      REFERENCES `typeMessage` (`idTypeMsg`) ;


ALTER TABLE `message`
  ADD FOREIGN KEY FK_MESSAGE_MESSAGE (`idMessage_reponse`)
      REFERENCES `message` (`idMessage`) ;


ALTER TABLE `message`
  ADD FOREIGN KEY FK_MESSAGE_UTILISATEUREMETTRE (`idUser_emettre`)
      REFERENCES `utilisateur` (`idUser`) ;


ALTER TABLE `message` 
  ADD FOREIGN KEY FK_MESSAGE_EVENEMENT (`idEvent`)
      REFERENCES `evenement` (`idEvent`) ;


ALTER TABLE DISTINGUER 
  ADD FOREIGN KEY FK_DISTINGUER_UTILISATEUR (`idUser`)
      REFERENCES `utilisateur` (`idUser`) ;


ALTER TABLE `distinguer`
  ADD FOREIGN KEY FK_DISTINGUER_PROFIL (`idProfil`)
      REFERENCES `profil` (`idProfil`) ;


ALTER TABLE `distinguer` 
  ADD FOREIGN KEY FK_DISTINGUER_ORGANISME (`idOrga`)
      REFERENCES `organisme` (`idOrga`) ;


ALTER TABLE `apprecier`
  ADD FOREIGN KEY FK_APPRECIER_MESSAGE (`idMessage`)
      REFERENCES `message` (`idMessage`) ;


ALTER TABLE `apprecier` 
  ADD FOREIGN KEY FK_APPRECIER_UTILISATEUR (`idUser`)
      REFERENCES `utilisateur` (`idUser`) ;

