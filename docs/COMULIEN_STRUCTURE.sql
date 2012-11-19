/*
Changements :
2012/11/19 : 
  - changement des libellé des clés étrangères IdUser dans la table Message provenant de la table utilisateur

*/
DROP DATABASE IF EXISTS COMULIEN;

CREATE DATABASE IF NOT EXISTS COMULIEN;
USE COMULIEN;
# -----------------------------------------------------------------------------
#       TABLE : UTILISATEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS UTILISATEUR
 (
   IDUSER BIGINT(4) NOT NULL AUTO_INCREMENT ,
   LOGINUSER VARCHAR(128) NOT NULL  ,
   PSWUSER VARCHAR(128) NOT NULL  ,
   EMAILUSER VARCHAR(128) NOT NULL  ,
   DATEINSCRIPTIONUSER DATETIME NOT NULL  ,
   NBMSGUSER BIGINT(4) NULL  
      DEFAULT 0,
   NBAPPROUVUSER BIGINT(4) NULL  ,
   ESTACTIFUSER BOOL NULL  
      DEFAULT TRUE
   , PRIMARY KEY (IDUSER) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : EVENEMENT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS EVENEMENT
 (
   IDEVENT BIGINT(4) NOT NULL AUTO_INCREMENT ,
   IDORGA BIGINT(4) NOT NULL  ,
   TITREEVENT CHAR(100) NOT NULL  ,
   NUMEVENT VARCHAR(255) NOT NULL  ,
   DESCEVENT VARCHAR(255) NULL  ,
   LOGOEVENT VARCHAR(128) NULL  ,
   DATEDEBUTEVENT DATETIME NOT NULL  ,
   DATEFINEVENT DATETIME NULL  ,
   DELAIPERSISTENCE INTEGER(2) NULL  
   , PRIMARY KEY (IDEVENT) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : PROFIL
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS PROFIL
 (
   IDPROFIL BIGINT(4) NOT NULL  ,
   NOMPROFIL VARCHAR(128) NOT NULL  ,
   TYPEPROFIL BIGINT(4) NULL  ,
   ICONEPROFIL VARCHAR(255) NULL  
   , PRIMARY KEY (IDPROFIL) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : MESSAGE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS MESSAGE
 (
   IDMESSAGE BIGINT(4) NOT NULL AUTO_INCREMENT ,
   IDUSER_EMETTRE BIGINT(4) NOT NULL  ,
   IDTYPEMSG INTEGER(2) NOT NULL  ,
   IDEVENT BIGINT(4) NOT NULL  ,
   LBLMESSAGE VARCHAR(255) NOT NULL  ,
   IDPROFIL BIGINT(4) NULL  ,
   IDUSER_MODERER BIGINT(4) NULL  ,
   IDMESSAGE_REPONSE BIGINT(4) NULL  ,
   DATEEMISSIONMSG DATETIME NULL  ,
   DATEACTIVITEMSG DATETIME NULL  ,
   ESTACTIFMSG BOOL NULL  
      DEFAULT TRUE
   , PRIMARY KEY (IDMESSAGE) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : ORGANISME
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS ORGANISME
 (
   IDORGA BIGINT(4) NOT NULL AUTO_INCREMENT ,
   NOMORGA VARCHAR(128) NULL  ,
   DESCORGA VARCHAR(255) NULL  ,
   LOGOORGA VARCHAR(128) NULL  
   , PRIMARY KEY (IDORGA) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : TYPEMESSAGE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS TYPEMESSAGE
 (
   IDTYPEMSG INTEGER(2) NOT NULL  ,
   LBLTYPEMSG VARCHAR(128) NULL  
   , PRIMARY KEY (IDTYPEMSG) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : DISTINGUER
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS DISTINGUER
 (
   IDUSER BIGINT(4) NOT NULL  ,
   IDORGA BIGINT(4) NOT NULL  ,
   IDPROFIL BIGINT(4) NOT NULL  ,
   DROITMODERATION BOOL NULL  
      DEFAULT FALSE,
   NOMFONCTION VARCHAR(50) NULL  
   , PRIMARY KEY (IDUSER,IDORGA) 
 ) 
 COMMENT = "";

# -----------------------------------------------------------------------------
#       TABLE : APPRECIER
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS APPRECIER
 (
   IDMESSAGE BIGINT(4) NOT NULL  ,
   IDUSER BIGINT(4) NOT NULL  ,
   EVALUATION CHAR(32) NULL  
   , PRIMARY KEY (IDMESSAGE,IDUSER) 
 ) 
 COMMENT = "";


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE EVENEMENT 
  ADD FOREIGN KEY FK_EVENEMENT_ORGANISME (IDORGA)
      REFERENCES ORGANISME (IDORGA) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_PROFIL (IDPROFIL)
      REFERENCES PROFIL (IDPROFIL) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_UTILISATEUR (IDUSER_MODERER)
      REFERENCES UTILISATEUR (IDUSER) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_TYPEMESSAGE (IDTYPEMSG)
      REFERENCES TYPEMESSAGE (IDTYPEMSG) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_MESSAGE (IDMESSAGE_REPONSE)
      REFERENCES MESSAGE (IDMESSAGE) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_UTILISATEUR1 (IDUSER_EMETTRE)
      REFERENCES UTILISATEUR (IDUSER) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_EVENEMENT (IDEVENT)
      REFERENCES EVENEMENT (IDEVENT) ;


ALTER TABLE DISTINGUER 
  ADD FOREIGN KEY FK_DISTINGUER_UTILISATEUR (IDUSER)
      REFERENCES UTILISATEUR (IDUSER) ;


ALTER TABLE DISTINGUER 
  ADD FOREIGN KEY FK_DISTINGUER_PROFIL (IDPROFIL)
      REFERENCES PROFIL (IDPROFIL) ;


ALTER TABLE DISTINGUER 
  ADD FOREIGN KEY FK_DISTINGUER_ORGANISME (IDORGA)
      REFERENCES ORGANISME (IDORGA) ;


ALTER TABLE APPRECIER 
  ADD FOREIGN KEY FK_APPRECIER_MESSAGE (IDMESSAGE)
      REFERENCES MESSAGE (IDMESSAGE) ;


ALTER TABLE APPRECIER 
  ADD FOREIGN KEY FK_APPRECIER_UTILISATEUR (IDUSER)
      REFERENCES UTILISATEUR (IDUSER) ;

