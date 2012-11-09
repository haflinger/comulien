
-- -------------
-- insertions
-- -------------
SELECT * FROM role;
SELECT * FROM USER;
SELECT * FROM organisme;

-- TODO : hasher le mot de passe`user`
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('comulien','password','comulien.app@gmail.com',NOW()); 
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('BTillois','password','benedicte.tillois@sncf.fr',NOW()); 


-- Création d'un organisme
INSERT INTO organisme(nomorga) VALUES ('Les Poulpes Team');
INSERT INTO organisme(nomorga) VALUES ('Transilien');


-- promotion d'un utilisateur au titre d'organisateur pour l'organisme
INSERT INTO privilegier VALUES (1,2,1); -- comulien / organisateur / les poulpes Team
INSERT INTO privilegier VALUES (8,2,2); -- btillois / organisateur / Transilien
-- promotion de l'utilisateur comulien comme modérateur de Transilien
INSERT INTO privilegier VALUES (1,1,2); -- comulien / modérateur / Transilien
INSERT INTO privilegier VALUES (2,3,2); -- alexsolex / superviseur / Transilien

SELECT * FROM privilegier;

-- création d'un évènement
INSERT INTO evenement(titreevent,lblevent,idorga,datedebut,datefin,delaipersistence,logo)
	VALUES ('Team Poulpe Event',
	'Un évènement de test pour la team Poulpe',
	(SELECT idorga FROM organisme WHERE UPPER(nomorga)='LES POULPES TEAM'),
	NOW(),
	'2012-12-09 21:27:43',
	60,
	NULL);
SELECT * FROM evenement;

-- création d'utilisateurs
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('alexsolex','alexpsw','alexsolex@gmail.com',NOW()); 
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('Fredo','fredpsw','fredhorn@gmail.com',NOW()); 
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('laurent','lolopsw','soyris@gmail.com',NOW()); 
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('manu','manupsw','tempor05@gmail.com',NOW()); 
INSERT INTO USER (login,PASSWORD,email,dateinscription) VALUES ('JC','jcpsw','halflinger@gmail.com',NOW()); 

-- poster un message dans un évènement
INSERT INTO message(iduser_emettre,idevent,lblmessage,dateemission,idtypemsg) 
	VALUES ( (SELECT iduser FROM USER WHERE login='alexsolex') ,
	 1,
	'Bienvenue à bord de cette bulle Comulien !',
	NOW(),
	0);
SELECT * FROM message;	
-- fred répond au message
INSERT INTO message(iduser_emettre,idmessage_repondre,idevent,lblmessage,dateemission,idtypemsg) 
	VALUES ( (SELECT iduser FROM USER WHERE login='Fredo') , -- récupérer l'id de l'utilisateur qui émet
	2, -- réponse au message id 2
	1, -- évènement id 1
	'On va pouvoir commencer !', -- le message
	NOW(), -- émis le : maintenant
	0 -- type de message 
	);
INSERT INTO message(iduser_emettre,idmessage_repondre,idevent,lblmessage,dateemission,idtypemsg) 
	VALUES ( (SELECT iduser FROM USER WHERE login='Fredo') , -- récupérer l'id de l'utilisateur qui émet
	2, -- réponse au message id 2
	1, -- évènement id 1
	'Pardon pour avoir envoyé le même message dans ma réponse !', -- le message
	NOW(), -- émis le : maintenant
	0 -- type de message 
	);
	
-- approbation d'un message
INSERT INTO apprecier(idmessage,iduser,evaluation) 
	VALUES (
	2, -- appréciation du message #2
	(SELECT iduser FROM USER WHERE login='laurent') , -- Par Laurent
	-1 -- évaluation négative
	);
	
-- tous les messages d'un évènement et les réponses
SELECT * 
FROM message 
WHERE idevent=1
AND estActifMsg=TRUE;	

-- tous les messages d'un évènement sans les réponses
SELECT * 
FROM message 
WHERE idevent=1
AND estActifMsg=TRUE
AND idMessage_repondre IS NULL; -- sans idmessage_repondre

-- liste des utilisateurs avec pouvoirs pour l'évènement
SELECT u.login,r.lblrole,o.nomorga
 FROM privilegier p 
 INNER JOIN role r ON p.idrole=r.idrole
 INNER JOIN USER u ON u.iduser=p.iduser
 INNER JOIN organisme o ON o.idorga=p.idorga
 WHERE p.idorga=2;