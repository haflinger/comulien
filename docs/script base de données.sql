
# -----------------------------------------------------------------------------
#       TABLE : TYPE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS TYPE
 (
   IDTYPE BIGINT(4) NOT NULL  ,
   IMAGETYPE VARCHAR(255) NULL  
   , PRIMARY KEY (IDTYPE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : USER
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS USER
 (
   IDUSER BIGINT(4) NOT NULL  ,
   LOGIN VARCHAR(128) NULL  ,
   PASSWORD VARCHAR(128) NULL  ,
   EMAIL VARCHAR(128) NULL  ,
   NBMESSAGE BIGINT(4) NULL  ,
   NBOK BIGINT(4) NULL  ,
   DATEINSCRIPTION DATE NULL  
   , PRIMARY KEY (IDUSER) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : GARE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS GARE
 (
   IDGARE VARCHAR(255) NOT NULL  ,
   NOMGARE VARCHAR(255) NULL  
   , PRIMARY KEY (IDGARE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : BULLE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS BULLE
 (
   IDBULLE BIGINT(4) NOT NULL  ,
   IDTYPE BIGINT(4) NOT NULL  ,
   DATEDEBUT DATE NULL  ,
   DATEFIN DATE NULL  
   , PRIMARY KEY (IDBULLE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE BULLE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_BULLE_TYPE
     ON BULLE (IDTYPE ASC);

# -----------------------------------------------------------------------------
#       TABLE : MESSAGE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS MESSAGE
 (
   IDMESSAGE BIGINT(4) NOT NULL  ,
   IDTYPE CHAR(32) NOT NULL  ,
   IDMESSAGE_REPONDRE BIGINT(4) NULL  ,
   IDUSER BIGINT(4) NOT NULL  ,
   IDBULLE BIGINT(4) NOT NULL  ,
   LBLMESSAGE VARCHAR(255) NULL  ,
   DATEEMISSION DATE NULL  ,
   DATELIMITE DATE NULL  
   , PRIMARY KEY (IDMESSAGE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE MESSAGE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_MESSAGE_TYPEMESSAGE
     ON MESSAGE (IDTYPE ASC);

CREATE  INDEX I_FK_MESSAGE_MESSAGE
     ON MESSAGE (IDMESSAGE_REPONDRE ASC);

CREATE  INDEX I_FK_MESSAGE_USER
     ON MESSAGE (IDUSER ASC);

CREATE  INDEX I_FK_MESSAGE_BULLE
     ON MESSAGE (IDBULLE ASC);

# -----------------------------------------------------------------------------
#       TABLE : ROLE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS ROLE
 (
   IDROLE BIGINT(4) NOT NULL  ,
   LBLROLE VARCHAR(128) NULL  ,
   TYPEROLE BIGINT(4) NULL  ,
   IMAGEROLE VARCHAR(255) NULL  
   , PRIMARY KEY (IDROLE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : TRAIN
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS TRAIN
 (
   IDTRAIN BIGINT(4) NOT NULL  ,
   IDBULLE BIGINT(4) NOT NULL  ,
   NOTRAIN VARCHAR(128) NULL  
   , PRIMARY KEY (IDTRAIN) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE TRAIN
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_TRAIN_BULLE
     ON TRAIN (IDBULLE ASC);

# -----------------------------------------------------------------------------
#       TABLE : TYPEMESSAGE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS TYPEMESSAGE
 (
   IDTYPE CHAR(32) NOT NULL  ,
   TYPEMESSAGE VARCHAR(128) NULL  
   , PRIMARY KEY (IDTYPE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : AVOIR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS AVOIR
 (
   IDUSER BIGINT(4) NOT NULL  ,
   IDROLE BIGINT(4) NOT NULL  
   , PRIMARY KEY (IDUSER,IDROLE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE AVOIR
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_AVOIR_USER
     ON AVOIR (IDUSER ASC);

CREATE  INDEX I_FK_AVOIR_ROLE
     ON AVOIR (IDROLE ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE BULLE 
  ADD FOREIGN KEY FK_BULLE_TYPE (IDTYPE)
      REFERENCES TYPE (IDTYPE) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_TYPEMESSAGE (IDTYPE)
      REFERENCES TYPEMESSAGE (IDTYPE) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_MESSAGE (IDMESSAGE_REPONDRE)
      REFERENCES MESSAGE (IDMESSAGE) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_USER (IDUSER)
      REFERENCES USER (IDUSER) ;


ALTER TABLE MESSAGE 
  ADD FOREIGN KEY FK_MESSAGE_BULLE (IDBULLE)
      REFERENCES BULLE (IDBULLE) ;


ALTER TABLE TRAIN 
  ADD FOREIGN KEY FK_TRAIN_BULLE (IDBULLE)
      REFERENCES BULLE (IDBULLE) ;


ALTER TABLE AVOIR 
  ADD FOREIGN KEY FK_AVOIR_USER (IDUSER)
      REFERENCES USER (IDUSER) ;


ALTER TABLE AVOIR 
  ADD FOREIGN KEY FK_AVOIR_ROLE (IDROLE)
      REFERENCES ROLE (IDROLE) ;

