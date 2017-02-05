SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Clienti;
DROP TABLE IF EXISTS Appuntamenti;
DROP TABLE IF EXISTS Prodotti;
DROP TABLE IF EXISTS ProdApp;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Messaggi;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS TipoAppuntamento;
DROP VIEW IF EXISTS Contatori;

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
	('3', 'Vittoria Maddalena', 'Brignani', '0495345198', NULL, '1945-11-12'),
	('4', 'Silvia', 'Zanella', '3382319004', 'silvia.zanella87@gmail.com', '1987-01-25');


CREATE TABLE TipoAppuntamento ( 
	CodTipoAppuntamento SMALLINT PRIMARY KEY AUTO_INCREMENT,
	NomeTipo VARCHAR(30) NOT NULL,
	Costo DOUBLE NOT NULL,
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
	FOREIGN KEY(CodCliente) REFERENCES Clienti(CodCliente) ON DELETE CASCADE ON UPDATE NO ACTION,
	FOREIGN KEY(CodTipoAppuntamento) REFERENCES TipoAppuntamento(CodTipoAppuntamento) ON DELETE CASCADE
)Engine=InnoDB;

INSERT INTO Appuntamenti (CodAppuntamento, CodCliente, DataOra, CodTipoAppuntamento) VALUES
('1', '1', '2017-02-5 10:30:00', '2'),
('2', '2', '2017-02-10 14:00:00', '5'),
('3', '2', '2017-02-10 10:30:00', '6'),
('4', '3', '2017-02-15 14:00:00', '6'),
('5', '4', '2017-02-15 10:30:00', '9'),
('6', '3', '2017-02-18 14:00:00', '2');


CREATE TABLE Prodotti(
	CodProdotto INT PRIMARY KEY AUTO_INCREMENT, 
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
	FOREIGN KEY(CodProdotto) REFERENCES Prodotti(CodProdotto) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(CodAppuntamento) REFERENCES Appuntamenti(CodAppuntamento) ON UPDATE
	CASCADE ON DELETE CASCADE
)Engine=InnoDB;

CREATE TABLE Account(
	CodAccount SMALLINT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(20) UNIQUE, 
	password VARCHAR(32)
)Engine=InnoDB;

INSERT INTO Account(CodAccount, username, password) VALUES
(1, "admin", "21232f297a57a5a743894a0e4a801fc3");

CREATE TABLE Messaggi (
	CodMessaggi INT PRIMARY KEY AUTO_INCREMENT,
	CodCliente INT,
	Contenuto VARCHAR(512),
	DataOra DATETIME NOT NULL,
	ToRead BOOLEAN,
	FOREIGN KEY (CodCliente) REFERENCES Clienti(CodCliente) ON UPDATE CASCADE ON DELETE CASCADE
)Engine=InnoDB;

INSERT INTO Messaggi(CodMessaggi, CodCliente, Contenuto, DataOra, ToRead) VALUES
(1, 1, "Ciao! Hai un buco per il 5 febbraio? Possibilmente al mattino? Perche&#769; ho bisogno di una spuntatina veloce", "2017-02-01 15:13:34", 0),
(2, 2, "E&#768; possibile per la settimana prossima prendere un appuntamento? Ho bisogno del solito, senza colore", "2017-02-01 21:03:15", 0),
(3, 4, "Riesci a fissarmi un appuntamento per il 15 mattina? Che cosi&#768; passo prima o dopo aver fatto la spesa", "2017-02-09 22:19:45", 0),
(4, 2, "Ho cambiato idea, riesci a farmi anche il colore? Va bene anche se mi dai un altro appuntamento, scusa per il disturbo", "2017-02-09 11:35:19", 0),
(5, 4, "Mi spiace ma ho avuto un contrattempo, domani non riesco a venire. Ti dico appena trovo un momento libero per fissare un appuntamento", "2017-02-14 20:11:28", 1);

CREATE TABLE Images (
	Img_title INT PRIMARY KEY AUTO_INCREMENT,
	Img_desc VARCHAR(200),
	Img_filename VARCHAR(160)
)Engine=InnoDB;

INSERT INTO Images (Img_title, Img_desc, Img_filename) VALUES
(1, 'd', "AnyScale_MG_5358-Pano.jpg"),
(2, '', "tumblr_ok6b4sc6Ds1rtauwdo1_500.jpg"),
(3, 'nmfkjdsfdff', "ericabello2_orig.jpg");

SET FOREIGN_KEY_CHECKS=1;  

CREATE VIEW Contatori(Parziali, Tipo)
AS SELECT COUNT(*), CodTipoAppuntamento
FROM Appuntamenti GROUP BY CodTipoAppuntamento