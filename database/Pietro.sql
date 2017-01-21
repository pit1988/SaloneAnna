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
	Tipo VARCHAR(30) NOT NULL, /*io metterei marca e tipo come due semplici varchar per due motivi: il primo è che così facilita l'inserimento di un nuovo tipo o di una nuova marca (per questo toglierei l'enum), il secondo è che dubito che un tipo possa essere associato a molti prodotti, o che separare la marca porti dei vantaggi rilevanti ai fini del sito (quindi eviterei di creare un'entità a sé)*/
	Quantita INT NOT NULL,
	PVendita DOUBLE,
	PRivendita DOUBLE
)Engine=InnoDB; /*TODO: inserire prodotti*/

CREATE TABLE ProdApp( /*Secondo me a fini pratici quest'entità non ha senso, cioè si fa prima a togliere i prodotti a mano, o a creare una form e uno script PHP apposta per togliere i prodotti dal magazzino.*/
	CodAppuntamento INT,
	CodProdotto INT,
	Utilizzo DOUBLE,
	FOREIGN KEY(CodProdotto) REFERENCES Prodotti(CodProdotto) ON UPDATE CASCADE,
	FOREIGN KEY(CodAppuntamento) REFERENCES AppuntamentiClienti(CodAppuntamento) ON UPDATE
	CASCADE ON DELETE CASCADE
)Engine=InnoDB;

CREATE TABLE Eccezioni( /*teniamo o eliminiamo?*/
	Id_Eccezione INT PRIMARY KEY,
	Descrizione VARCHAR(100)
)Engine=InnoDB;

INSERT INTO Eccezioni(Id_Eccezione, Descrizione) VALUES
('1', 'Errore 1: Errore di Inserimento, e presente un appuntamento speciale'),
('2', 'Errore 2: Errore di Inserimento, il prodotto che si vuole inserire e gia inserito');

CREATE TABLE Account( 
	CodCliente INT PRIMARY KEY,
	username VARCHAR(20), 
	password VARCHAR(16),
	FOREIGN KEY (CodCliente) REFERENCES Clienti(CodCliente) ON UPDATE CASCADE ON DELETE CASCADE
)Engine=InnoDB;


INSERT INTO Account VALUES (1, "admin", "admin");

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