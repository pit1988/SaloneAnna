1-compleanni da qui a un mese

SELECT *
FROM Clienti
WHERE Compleanno BETWEEN CURDATE() AND (ADDDATE(CURDATE(), INTERVAL 31 DAY));

2- prodotti in esaurimento senza contare quelli gia' finiti

SELECT *
FROM Prodotti
WHERE quantita<6 AND quantita!=0


3- classifica dei primi dieci prodotti piu usati

SELECT p.Nome,p.Marca, a.Utilizzo
FROM Prodotti p NATURAL JOIN ProdApp a
ORDER BY Utilizzo DESC
LIMIT 5;


4- Storico dei prodotti usati per un Cliente nei vari appuntamenti per il cliente con CodCliente= '5'

CREATE VIEW storico (CodCliente, CodAppuntamento, DataOra, CodProdotto, Utilizzo)AS 
SELECT a.CodCliente, a.CodAppuntamento, b.DataOra, pa.CodProdotto, pa.Utilizzo 
FROM Appuntamenti b NATURAL JOIN AppuntamentiClienti a NATURAL JOIN ProdApp pa; 

SELECT s.Codappuntamento, s.DataOra, s.CodProdotto, s.Utilizzo, p.Nome
FROM storico s NATURAL JOIN Prodotti p
WHERE CodCliente = $CodCliente;


5-statistica tipo Appuntamenti

CREATE VIEW Contatori(Parziali, Tipo) AS
SELECT COUNT(*), TipoAppuntamento 
FROM AppuntamentiClienti
GROUP BY TipoAppuntamento;

SELECT (p.Parziali/COUNT(*))*100 AS Percentuale, a.TipoAppuntamento
FROM Contatori p NATURAL JOIN AppuntamentiClienti a
GROUP BY a.TipoAppuntamento;


6- trovare il tipo di appuntamento piu' usato tra chi ha piu' appuntamenti.

CREATE View Fedele(fCod, fNome, fCognome) AS
SELECT a.CodCliente, c.Nome, c.Cognome  
FROM AppuntamentiClienti a NATURAL JOIN Clienti c
GROUP BY CodCliente
ORDER BY COUNT(*) DESC
LIMIT 1

SELECT COUNT(*), a.CodCliente, a.TipoAppuntamento
FROM AppuntamentiClienti a JOIN Fedele f ON(a.CodCliente= f.fCod)
GROUP BY TipoAppuntamento
ORDER BY COUNT(*) DESC
LIMIT 1;

7- trovare gli appuntamenti di un giorno

CREATE View agenda(CodAppuntamento, DataOra) AS
SELECT CodAppuntamento, DataOra
FROM Appuntamenti
