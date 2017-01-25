CREATE PROCEDURE InserimentoCliente
(IN aNome VARCHAR(10), aCognome VARCHAR(10), aCodCliente INT, aDataOra DATETIME, aSconto DOUBLE, aCosto DOUBLE, aTipo ENUM ('shampoo', 'taglio', 'piega e phon', 'piega e casco', 'ondulazione', 'colore', 'riflessante', 'decolorazione', 'meches', 'trattamenti', 'manicure/pedicure'),
 OUT ok BOOL)

BEGIN

DECLARE CodiceApp INT;

INSERT INTO Appuntamento(DataOra, Costo) VALUES (ADataOra, aCosto);

SELECT CodAppuntamento INTO CodiceApp FROM Appuntamento WHERE DataOra=aDataOra AND Costo=aCosto;

INSERT INTO AppuntamentiClienti(CodAppuntamento, CodCliente, Sconto, TipoAppuntamento) VALUES (CodiceApp, aCodCliente, aSconto, aTipo)
END

