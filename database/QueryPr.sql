V 1-compleanni da qui a un mese

SELECT *
FROM Clienti
WHERE Compleanno BETWEEN CURDATE() AND (ADDDATE(CURDATE(), INTERVAL 31 DAY));

V 2- prodotti in esaurimento senza contare quelli gia' finiti

SELECT *
FROM Prodotti
WHERE quantita<6 AND quantita!=0


V 3- classifica dei primi dieci prodotti piu usati

SELECT p.CodProdotto, p.Nome, p.Tipo, p.Marca, p.PRivendita, a.Utilizzo
FROM Prodotti p NATURAL JOIN ProdApp a
ORDER BY Utilizzo DESC
LIMIT 10;


4- Storico dei prodotti usati per un Cliente nei vari appuntamenti per il cliente con CodCliente= '5'

CREATE VIEW storico AS 
SELECT a.CodAppuntamento, a.DataOra, pa.CodProdotto, pr.Nome, pa.Utilizzo 
FROM AppuntamentiClienti a NATURAL JOIN ProdApp pa NATURAL JOIN Prodotti pr; 

(SELECT * FROM storico WHERE CodCliente = 5;)


v 5-statistica tipo Appuntamenti

CREATE VIEW Contatori(Parziali, Tipo) AS
SELECT COUNT(*), TipoAppuntamento
FROM AppuntamentiClienti
GROUP BY TipoAppuntamento;

SELECT (p.Parziali/COUNT(*))*100 AS Percentuale, TipoAppuntamento
FROM Contatori p NATURAL JOIN AppuntamentiClienti
GROUP BY TipoAppuntamento;


v 6- trovare il tipo di appuntamento piu' usato tra chi ha piu' appuntamenti.  

CREATE View Fedele(fedele, nome, cognome) AS
SELECT ac.CodCliente, c.Nome, c.Cognome  
FROM AppuntamentiClienti ac NATURAL JOIN Clienti c
GROUP BY CodCliente
ORDER BY COUNT(*) DESC
LIMIT 1

SELECT COUNT(*), a.CodCliente, a.TipoAppuntamento
FROM AppuntamentiClienti a JOIN Fedele f ON(a.CodCliente= f.fedele)
GROUP BY TipoAppuntamento
ORDER BY COUNT(*) DESC
LIMIT 1;

7- trovare gli appuntamenti di un giorno

CREATE View agenda(CodAppuntamento, DataOra) AS
SELECT CodAppuntamento, DataOra
FROM Appuntamenti
