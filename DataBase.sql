
CREATE USER 'monnaie_db_user'@'localhost';
set password for 'monnaie_db_user'@'localhost'=password('<yourPassword>');


CREATE DATABASE IF NOT EXISTS monnaie_db;

GRANT SELECT, INSERT, UPDATE, DELETE ON monnaie_db.* TO 'monnaie_db_user'@'localhost';

USE monnaie_db;

CREATE TABLE  MonnaieSiteUser (
  Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  CreatedOn TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  LastLoggedIn DATETIME NULL ,
  EMail VARCHAR( 255 ) NOT NULL ,
  Salt VARCHAR( 255 ) NOT NULL ,
  Password VARCHAR( 32 ) NOT NULL ,
  IsAdmin TINYINT NOT NULL DEFAULT 0
);

INSERT MonnaieSiteUser (EMail,Salt,Password,IsAdmin)
VALUES('Admin_0','2019-02-08:09:02:43','09330e7eda5c331f6b6a4249a9ada8c7',1);


CREATE TABLE  MonnaieMembers ( 
  Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  CreatedOn TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  Nom VARCHAR( 255 ) NOT NULL ,  
  Prenom VARCHAR( 255 ) NOT NULL ,
  EMail VARCHAR( 255 ) NOT NULL,
  Code VARCHAR( 32 ) NOT NULL,
  Count INT NOT NULL DEFAULT 0
);

/*////////////////////////////////////////////////////////*/

