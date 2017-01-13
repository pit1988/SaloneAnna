SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Clienti;
DROP TABLE IF EXISTS Appuntamenti;
DROP TABLE IF EXISTS AppuntamentiSpeciali;
DROP TABLE IF EXISTS AppuntamentiClienti;
DROP TABLE IF EXISTS Prodotti;
DROP TABLE IF EXISTS ProdApp;
DROP TABLE IF EXISTS Eccezioni;
DROP TRIGGER IF EXISTS ControlloAppuntamentiSpeciali;
DROP TRIGGER IF EXISTS InserimentoProdotto;

CREATE TABLE Clienti(
	CodCliente INT PRIMARY KEY AUTO_INCREMENT,
	Nome VARCHAR(10) NOT NULL,
	Cognome VARCHAR(10) NOT NULL,
	Telefono VARCHAR(10),
	Email VARCHAR(50),
	Compleanno DATE
)Engine=InnoDB;

INSERT INTO Clienti (CodCliente, Nome, Cognome, Telefono, Email, Compleanno) VALUES
	('1','Anna Rosa', 'Cortivo', '3394188995', 'anna.cortivo@gmail.com', '1962-01-12');

CREATE TABLE Appuntamenti(
	CodAppuntamento INT PRIMARY KEY AUTO_INCREMENT,
	DataOra DATETIME NOT NULL,
	Costo DOUBLE
)Engine=InnoDB;

INSERT INTO Appuntamenti (DataOra, Costo) VALUES
('2012-06-13 10:30:00', '10'),
('2012-06-13 14:00:00', '20'),
('2012-06-14 10:30:00', '5'),
('2012-06-15 14:00:00', '50'),
('2012-06-15 10:30:00', '70'),
('2012-06-18 14:00:00', '10'),
('2012-06-20 09:00:00', '-100'),
('2012-06-21 09:00:00', '-50'),
('2012-06-22 10:00:00', '-150');

CREATE TABLE AppuntamentiSpeciali (
	CodAppuntamento INT PRIMARY KEY,
	Durata TIME,
	NomeAppuntamento VARCHAR(15),
	Luogo VARCHAR(20),
	LimitePersone INT,
	FOREIGN KEY(CodAppuntamento)
		references Appuntamenti(CodAppuntamento) 
		on delete cascade
)Engine=InnoDB;

INSERT INTO AppuntamentiSpeciali (CodAppuntamento, Durata, NomeAppuntamento, Luogo) VALUES
('4', '02:00:00', 'Aggiornamento', 'Verona'),
('7', '01:00:00', 'AggiornamentoTaglio', 'Vicenza'),
('9', '01:30:00', 'AggiornamentoProdotti', 'Altavilla');

CREATE TABLE AppuntamentiClienti (
	CodAppuntamento INT,
	CodCliente INT,
	Sconto DOUBLE,
	TipoAppuntamento ENUM('shampoo','taglio','piega e phon','piega e
	casco','ondulazione','colore','riflessante','decolorazione','meches','trattamenti','manicure/pedicure'),
	FOREIGN KEY(CodAppuntamento) references Appuntamenti(CodAppuntamento) on delete cascade,
	FOREIGN KEY(CodCliente) references Clienti(CodCliente) on delete cascade
)Engine=InnoDB;

INSERT INTO AppuntamentiClienti (CodAppuntamento, CodCliente, Sconto, TipoAppuntamento) VALUES
('1', '2', '5', 'taglio'),
('2', '3', '0', 'ondulazione'),
('3', '3', '0', 'colore'),
('4', '5', '0', 'colore'),
('5', '4', '0', 'meches'),
('6', '7', '5', 'taglio');

CREATE TABLE Prodotti(
	CodProdotto INT PRIMARY KEY,
	Nome VARCHAR(20) NOT NULL,
	Marca ENUM('Wella', 'SP', 'Sebastian') NOT NULL,
	Tipo ENUM('Koleston Perfect', 'Inspire by KP', 'Welloxon Perfect', 'Color Touch', 'Color Fresh', 'Perfection', 'Eos',
	'Blondor Multi-Blonde', 'Magma', 'Texturize', 'Styling Wet', 'Styling Dry', 'Styling Finish', 'Exclusiv', 'Care Brilliance',
	'Care Enrich', 'Care Balance', 'Care Service', 'Care Sun', 'Smoothen', 'Hydrate', 'Repair', 'Volumize', 'Color
	Save', 'Shine Define', 'Clear Scalp', 'Balance Scalp', 'Expert Kit', 'Styling', 'Sun', 'Men', 'Flow', 'Form', 'Flaunt',
	'Foundation', 'In Salon Service') NOT NULL,
	Quantita INT NOT NULL,
	PVendita DOUBLE,
	PRivendita DOUBLE
)Engine=InnoDB;

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
	Descrizione VARCHAR(50)
)Engine=InnoDB;

INSERT INTO Eccezioni(Id_Eccezione, Descrizione) VALUES
('1', 'Errore 1: Errore di Inserimento, e presente un appuntamento speciale'),
('2', 'Errore 2: Errore di Inserimento, il prodotto che si vuole inserire e gia inserito');

DROP TABLE IF EXISTS Login;

CREATE TABLE Login( 
user VARCHAR (55) , 
password VARCHAR(55)
)
Engine=InnoDB;

-- inserire tablella password



DELIMITER $$
CREATE TRIGGER ControlloAppuntamentiSpeciali BEFORE INSERT ON
Appuntamenti
FOR EACH ROW
BEGIN
DECLARE AppSpeciali INT;
SELECT count(*) INTO AppSpeciali FROM AppuntamentiSpeciali a JOIN Appuntamenti b
WHERE b.DataOra<NEW.DataOra AND
NEW.DataOra<(ADDTIME(b.DataOra,a.Durata));
IF(AppSpeciali) THEN
    SELECT Descrizione FROM Eccezione WHERE Id_Eccezione=1;
    INSERT INTO Eccezioni(Id_Eccezione) VALUES ('1');
END IF;
END$$



CREATE TRIGGER InserimentoProfo BEFORE INSERT ON Prodotti
FOR EACH ROW
BEGIN
    DECLARE presente INT;
    SELECT count(*) INTO presente
    FROM Prodotti
    WHERE quantita>1
    IF(!presente) THEN
    SELECT Descrizione FROM Eccezione WHERE Id_Eccezione=2;
    INSERT INTO Eccezioni(Id_Eccezione) VALUES ('2');
    END IF;
END $$
DELIMITER ;

SET FOREIGN_KEY_CHECKS=1;   