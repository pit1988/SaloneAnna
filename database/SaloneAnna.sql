SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Clienti;
DROP TABLE IF EXISTS Appuntamenti;
DROP TABLE IF EXISTS Prodotti;
DROP TABLE IF EXISTS ProdApp;
DROP TABLE IF EXISTS Eccezioni;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Messaggi;
DROP TRIGGER IF EXISTS ControlloAppuntamentiSpeciali;
DROP TRIGGER IF EXISTS InserimentoProdotto;

CREATE TABLE Clienti(
	CodCliente INT PRIMARY KEY AUTO_INCREMENT,
	Nome NVARCHAR(30) NOT NULL, --NVARCHAR è un tipo di VARCHAR che usa la codifica Unicode, qundi l'ho messo dove potrebbero esserci dei caratteri speciali, ovviamente è un po' più pesante del VARCHAR normale perché occupa il doppio dei bytes
	Cognome NVARCHAR(30) NOT NULL,
	Telefono VARCHAR(10),
	Email VARCHAR(50),
	DataNascita DATE
)Engine=InnoDB;

INSERT INTO Clienti (CodCliente, Nome, Cognome, Telefono, Email, DataNascita) VALUES
	('1','Anna Rosa', 'Cortivo', '3394188995', 'anna.cortivo@gmail.com', '1962-01-12'),
	('2', 'Elena', 'Mason', '3464268921', 'elson@gmail.com', '1985-05-24');
	('3', 'Vittoria Maddalena', 'Brignani', '0495345198', '', '1945-11-12');
	('4', 'Silvia', 'Zanella', '3382319004', 'silvia.zanella87@gmail.com', '1987-01-25');

/* Inserisco una mia versione, lascio comunque qui il codice se si preferisce strutturarlo così, occhio che questo codice è già stato cambiato unendo due entità
CREATE TABLE Appuntamenti (
	CodAppuntamento INT PRIMARY KEY AUTO_INCREMENT,
	CodCliente INT,
	DataOra DATETIME NOT NULL,
	Costo DOUBLE,
	Sconto DOUBLE,
	TipoAppuntamento ENUM('shampoo','taglio','piega e phon','piega e
	casco','ondulazione','colore','riflessante','decolorazione','meches','trattamenti','manicure/pedicure'),
	FOREIGN KEY(CodCliente) references Clienti(CodCliente) on delete cascade
)Engine=InnoDB;

INSERT INTO Appuntamenti (CodAppuntamento, CodCliente, DataOra, Costo, Sconto, TipoAppuntamento) VALUES
('1', '1', '2012-06-13 10:30:00', '10', '5', 'taglio'),
('2', '2', '2012-06-13 14:00:00', '20', '0', 'ondulazione'),
('3', '2', '2012-06-14 10:30:00', '50', '0', 'colore'),
('4', '3', '2012-06-15 14:00:00', '50', '0', 'colore'),
('5', '4', '2012-06-15 10:30:00', '70', '0', 'meches'),
('6', '3', '2012-06-18 14:00:00', '10', '5', 'taglio');*/

CREATE TABLE TipoAppuntamento ( /*separando il tipo di appuntamento dagli appuntamenti diventa un po' più semplice inserirne altri*/
	CodTipoAppuntamento SMALLINT PRIMARY KEY AUTO_INCREMENT,
	NomeTipo NVARCHAR(30) NOT NULL,
	Costo DOUBLE,
	Sconto DOUBLE /*in questo modo si può applicare uno sconto per il tipo di intervento da fare, ad esempio per una promozione. Si potrebbe anche volendo inserire uno sconto per i clienti, da sommare a questo*/
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
	CodProdotto INT PRIMARY KEY, /*qui non metterei AUTO_INCREMENT perché in genere i prodotti dovrebbero avere già un proprio codice di fabbrica*/
	Nome NVARCHAR(20) NOT NULL,
	/*Marca ENUM('Wella', 'SP', 'Sebastian') NOT NULL,
	Tipo ENUM('Koleston Perfect', 'Inspire by KP', 'Welloxon Perfect', 'Color Touch', 'Color Fresh', 'Perfection', 'Eos',
	'Blondor Multi-Blonde', 'Magma', 'Texturize', 'Styling Wet', 'Styling Dry', 'Styling Finish', 'Exclusiv', 'Care Brilliance',
	'Care Enrich', 'Care Balance', 'Care Service', 'Care Sun', 'Smoothen', 'Hydrate', 'Repair', 'Volumize', 'Color
	Save', 'Shine Define', 'Clear Scalp', 'Balance Scalp', 'Expert Kit', 'Styling', 'Sun', 'Men', 'Flow', 'Form', 'Flaunt',
	'Foundation', 'In Salon Service') NOT NULL,*/
	Marca NVARCHAR(30) NOT NULL,
	Tipo NVARCHAR(30) NOT NULL, /*io metterei marca e tipo come due semplici varchar per due motivi: il primo è che così facilita l'inserimento di un nuovo tipo o di una nuova marca (per questo toglierei l'enum), il secondo è che dubito che un tipo possa essere associato a molti prodotti, o che separare la marca porti dei vantaggi rilevanti ai fini del sito (quindi eviterei di creare un'entità a sé)*/
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
	Descrizione NVARCHAR(100)
)Engine=InnoDB;

INSERT INTO Eccezioni(Id_Eccezione, Descrizione) VALUES
('1', 'Errore 1: Errore di Inserimento, e presente un appuntamento speciale'),
('2', 'Errore 2: Errore di Inserimento, il prodotto che si vuole inserire e gia inserito');

/* come sopra mantengo questa classe in caso si voglia tornare alla versione vecchia
CREATE TABLE Account( 
	CodCliente INT PRIMARY KEY,
	username VARCHAR (20), 
	password VARCHAR(16),
	FOREIGN KEY (CodCliente) REFERENCES Clienti(CodCliente) ON UPDATE CASCADE ON DELETE CASCADE
)Engine=InnoDB;*/

CREATE TABLE Account( 
	CodAccount SMALLINT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR (20), 
	password VARCHAR(16)
)Engine=InnoDB;

-- inserire tabella password

INSERT INTO Account VALUES (1, "admin", "password");

CREATE TABLE Messaggi (
	CodMessaggi INT PRIMARY KEY AUTO_INCREMENT,
	CodCliente INT,
	CodAccountAdmin INT,
	Contenuto NVARCHAR[512], --512 caratteri dovrebbero bastare anche per i clienti più prolissi
	FOREIGN KEY (CodCliente) REFERENCES Clienti(CodCliente) ON DELETE CASCADE,
	FOREIGN KEY (CodAccountAdmin) REFERENCES Account(CodAccount) ON DELETE CASCADE
)Engine=InnoDB;


--non ho ancora guardato i trigger, aspetto prima di avere il DB definitivo
delimiter //
CREATE TRIGGER ControlloAppuntamentiSpeciali BEFORE INSERT ON Appuntamenti
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
END; //


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
END; //
delimiter ;

SET FOREIGN_KEY_CHECKS=1;   