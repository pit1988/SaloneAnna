SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Clienti;
DROP TABLE IF EXISTS Appuntamenti;
DROP TABLE IF EXISTS Prodotti;
DROP TABLE IF EXISTS ProdApp;
DROP TABLE IF EXISTS Eccezioni;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Messaggi;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS TipoAppuntamento;
DROP TRIGGER IF EXISTS ControlloAppuntamentiSpeciali;
DROP TRIGGER IF EXISTS InserimentoProdotto;

CREATE TABLE Clienti(
	CodCliente INT PRIMARY KEY AUTO_INCREMENT,
	Nome VARCHAR(30) NOT NULL, 
	Cognome VARCHAR(30) NOT NULL,
	Telefono VARCHAR(10),
	Email VARCHAR(50),
	DataNascita DATE
)Engine=InnoDB;

INSERT INTO Clienti (CodCliente, Nome, Cognome, Telefono, Email, DataNascita) VALUES
	('1','Anna Rosa', 'Cortivo', '3394188995', 'anna.cortivo@gmail.com', '1962-01-12'),
	('2', 'Elena', 'Mason', '3464268921', 'elson@gmail.com', '1985-05-24'),
	('3', 'Vittoria Maddalena', 'Brignani', '0495345198', '', '1945-11-12'),
	('4', 'Silvia', 'Zanella', '3382319004', 'silvia.zanella87@gmail.com', '1987-01-25');


CREATE TABLE TipoAppuntamento ( 
	CodTipoAppuntamento SMALLINT PRIMARY KEY AUTO_INCREMENT,
	NomeTipo VARCHAR(30) NOT NULL,
	Costo DOUBLE,
	Sconto DOUBLE 
)Engine=InnoDB;

INSERT INTO TipoAppuntamento (CodTipoAppuntamento, NomeTipo, Costo, Sconto) VALUES
('1', 'shampoo', '0', '0'),
('2', 'taglio', '10', '5'),
('3', 'piega e phon', '0', '0'),
('4', 'piega e casco', '0', '0'),
('5', 'ondulazione', '20', '0'),
('6', 'colore', '50', '0'),
('7', 'riflessante', '0', '0'),
('8', 'decolorazione', '0', '0'),
('9', 'meches', '70', '0'),
('10', 'trattamenti', '0', '0'),
('11', 'manicure/pedicure', '0', '0');

CREATE TABLE Appuntamenti (
	CodAppuntamento INT PRIMARY KEY AUTO_INCREMENT,
	CodCliente INT,
	DataOra DATETIME NOT NULL,
	CodTipoAppuntamento SMALLINT,
	FOREIGN KEY(CodCliente) REFERENCES Clienti(CodCliente) ON DELETE CASCADE,
	FOREIGN KEY(CodTipoAppuntamento) REFERENCES TipoAppuntamento(CodTipoAppuntamento) ON DELETE CASCADE
)Engine=InnoDB;

INSERT INTO Appuntamenti (CodAppuntamento, CodCliente, DataOra, CodTipoAppuntamento) VALUES
('1', '1', '2012-06-13 10:30:00', '2'),
('2', '2', '2012-06-13 14:00:00', '5'),
('3', '2', '2012-06-14 10:30:00', '6'),
('4', '3', '2012-06-15 14:00:00', '6'),
('5', '4', '2012-06-15 10:30:00', '9'),
('6', '3', '2012-06-18 14:00:00', '2');


CREATE TABLE Prodotti(
	CodProdotto INT PRIMARY KEY, 
	Nome VARCHAR(20) NOT NULL,
	Marca VARCHAR(30) NOT NULL,
	Tipo VARCHAR(30) NOT NULL,
	Quantita INT NOT NULL,
	Prezzo DOUBLE,
	PRivendita DOUBLE
)Engine=InnoDB;

INSERT INTO `Prodotti`(`CodProdotto`, `Nome`, `Marca`, `Tipo`, `Quantita`, `Prezzo`, `PRivendita`) 
VALUES 
	('1', 'Smoothen Mask 200 ml', 'SP','Smoothen', '2', '10', '12.5'),
	('2', 'Smoothen Mask 400 ml', 'SP','Smoothen', '24', '10', '12.5'),
	('3', 'Smoothen Infusion 5', 'SP','Smoothen', '7', '10', '12.5'),
	('4', 'Hydrate Mask 200 ml', 'SP','Hydrate', '12', '10', '12.5'),
	('5', 'Hydrate Emulsion 50', 'SP','Hydrate', '14', '10', '12.5'),
	('6', 'Repair Infusion 5 ml', 'SP','Repair', '24', '10', '12.5'),
	('7', 'Volumize Infusion 5', 'SP','Volumize', '33', '10', '12.5'),
	('8', 'After Sun Fluid 125', 'SP','Sun', '79', '10', '12.5'),
	('9', 'Precise Shine 75 ml', 'SP','Men', '96', '10', '12.5'),
	('10', 'Penetraitt Condition', 'Sebastian', 'In Salon Service', '2', '10', '12.5');

CREATE TABLE ProdApp(
	CodAppuntamento INT,
	CodProdotto INT,
	Utilizzo DOUBLE,
	FOREIGN KEY(CodProdotto) REFERENCES Prodotti(CodProdotto) ON UPDATE CASCADE,
	FOREIGN KEY(CodAppuntamento) REFERENCES AppuntamentiClienti(CodAppuntamento) ON UPDATE
	CASCADE ON DELETE CASCADE
)Engine=InnoDB;

CREATE TABLE Eccezioni(
	Id_Eccezione INT PRIMARY KEY,
	Descrizione VARCHAR(100)
)Engine=InnoDB;

INSERT INTO Eccezioni(Id_Eccezione, Descrizione) VALUES
('1', 'Errore 1: Errore di Inserimento, e presente un appuntamento speciale'),
('2', 'Errore 2: Errore di Inserimento, il prodotto che si vuole inserire e gia inserito');

CREATE TABLE Account(
	CodAccount SMALLINT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(20), 
	password VARCHAR(32)
)Engine=InnoDB;

INSERT INTO Account(CodAccount, username, password) VALUES
(1, "admin", "21232f297a57a5a743894a0e4a801fc3");

CREATE TABLE Messaggi (
	CodMessaggi INT PRIMARY KEY AUTO_INCREMENT,
	CodCliente INT,
	Contenuto VARCHAR(512),
	ToRead BOOLEAN,
	FOREIGN KEY (CodCliente) REFERENCES Clienti(CodCliente) ON UPDATE CASCADE ON DELETE CASCADE
)Engine=InnoDB;

CREATE TABLE Images (
	Img_title INT PRIMARY KEY AUTO_INCREMENT,
	Img_desc VARCHAR(200),
	Img_filename VARCHAR(160)
)Engine=InnoDB;

SET FOREIGN_KEY_CHECKS=1;   

/******************/
/*

DROP PROCEDURE IF EXISTS AggiornamentoProdotti;
DELIMITER $$
CREATE DEFINER=`pgabelli`@`localhost` PROCEDURE `AggiornamentoProdotti`(IN `aCodProd` INT, IN `aQuantita` INT, IN `aPVendita` INT, IN `aPRivendita` INT)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT '1. La procedura aggiorna i campi di un prodotto, con le modifich'
UPDATE Prodotti
SET Quantita=aQuantita, PVendita=aPVendita, PRivendita=aPRivendita
WHERE CodProd=aCodProd$$
DELIMITER ;
*/
/*1. La procedura aggiorna i campi di un prodotto, con le modifiche a essa passata.*/
/*
DROP PROCEDURE IF EXISTS AggiornamentoProdotti;
DELIMITER $$
CREATE PROCEDURE `AggiornamentoProdotti`(IN `aCodProd` INT, IN `aQuantita` INT, IN `aPVendita` DOUBLE, IN `aPRivendita` DOUBLE)
UPDATE Prodotti
SET Quantita=aQuantita, PVendita=aPVendita, PRivendita=aPRivendita
WHERE CodProd=aCodProd$$
DELIMITER ;
*/
/*2. La procedura inserisce un nuovo appuntamento cliente*/
/*
DROP PROCEDURE IF EXISTS InserimentoAppuntamentoCliente;
DELIMITER $
CREATE PROCEDURE InserimentoAppuntamentoCliente (
IN aCodCliente INT,
IN aDataOra DATETIME,
IN aSconto DOUBLE,
IN aCosto DOUBLE,
IN aTipo ENUM ('shampoo', 'taglio', 'piega e phon', 'piega e casco', 'ondulazione', 'colore', 'riflessante',
'decolorazione', 'meches', 'trattamenti', 'manicure/pedicure'))
BEGIN
DECLARE CodiceApp INT;
INSERT INTO Appuntamenti(DataOra, Costo) VALUES (ADataOra, aCosto);
SELECT CodAppuntamento INTO CodiceApp FROM Appuntamenti WHERE DataOra=aDataOra AND
Costo=aCosto;
INSERT INTO AppuntamentiClienti(CodAppuntamento, CodCliente, Sconto, TipoAppuntamento) VALUES
(CodiceApp, aCodCliente, aSconto, aTipo);
END $
DELIMITER ;
*/
/*2. La procedura inserisce un nuovo appuntamento cliente*/
/*
DROP PROCEDURE IF EXISTS InserimentoAppuntamentoCliente;
DELIMITER $
CREATE PROCEDURE InserimentoAppuntamentoCliente (IN aCodCliente INT, IN aDataOra DATETIME, IN aSconto DOUBLE, IN aCosto DOUBLE, IN aTipo ENUM ('shampoo', 'taglio', 'piega e phon', 'piega e casco', 'ondulazione', 'colore', 'riflessante', 'decolorazione', 'meches', 'trattamenti', 'manicure/pedicure'))
DECLARE CodiceApp = SELECT CodAppuntamento FROM Appuntamenti WHERE DataOra=aDataOra AND Costo=aCosto;
INSERT INTO Appuntamenti(DataOra, Costo) VALUES (ADataOra, aCosto);
SELECT CodAppuntamento FROM Appuntamenti WHERE DataOra=aDataOra AND Costo=aCosto;
INSERT INTO AppuntamentiClienti(CodAppuntamento, CodCliente, Sconto, TipoAppuntamento) VALUES
(CodiceApp, aCodCliente, aSconto, aTipo);
DELIMITER ;
*/
/*3. Dato un prodotto (codice prodotto) la procedura lo elimina, cioè azzera la sua quantità*/
/*
DELIMITER $
CREATE PROCEDURE EliminaProdotto (IN aCodProdotto INT)
BEGIN
UPDATE Prodotti SET Quantita=0 WHERE CodProdotto=aCodProdotto;
END $
DELIMITER ;
*/
/*4. La procedura inserisce un nuovo appuntamento di tipo speciale*/
/*
DELIMITER $
CREATE PROCEDURE InserimentoAppuntamentoSpeciale (
	IN aDataOra DATETIME,
	IN aCosto DOUBLE,
	IN aDurata TIME,
	IN aNomeApp VARCHAR(15),
	IN aLuogo VARCHAR(20),
	IN aLimPersone INT)
BEGIN
DECLARE CodiceApp INT;
INSERT INTO Appuntamenti(DataOra, Costo) VALUES (ADataOra, aCosto);
SELECT CodAppuntamento INTO CodiceApp FROM Appuntamenti WHERE DataOra=aDataOra AND
Costo=aCosto;
INSERT INTO AppuntamentiSpeciali(CodAppuntamento, Durata, NomeApp, Luogo, LimitePersone) VALUES
(CodiceApp, aDurata, aNomeApp, aLuogo, aLimPersone);
END $
DELIMITER ;
*/
/*5. La procedura inserisce un nuovo Cliente nella tabella cliente.*/
/*
DELIMITER $
CREATE PROCEDURE InserimentoNewCliente (
	IN aNome VARCHAR(10),
	IN aCognome VARCHAR(10),
	IN aTelefono VARCHAR(10),
	IN aEmail VARCHAR(50),
	IN aCompleanno DATE)
BEGIN
INSERT INTO Clienti(Nome, Cognome, Telefono, Email, Compleanno) VALUES
(aNome, aCognome, aTelefono, aEmail, aCompleanno);
END $
DELIMITER ;
CREATE VIEW storico AS SELECT a.CodAppuntamento, a.DataOra, pa.CodProdotto, pa.Utilizzo FROM Appuntamenti a NATURAL JOIN ProdApp pa
*/