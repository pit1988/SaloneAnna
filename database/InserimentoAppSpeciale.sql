DROP PROCEDURE IF EXISTS InserimentoAppuntamentospeciale;
DELIMITER $

CREATE PROCEDURE InserimentoAppuntamentoSpeciale (
	IN aDataOra DATETIME, 
	IN aCosto DOUBLE, 
	IN aDurata TIME,
	IN aNomeApp VARCHAR(15),
	IN aLuogo VARCHAR(20),
	IN aLimPersone INT)
DETERMINISTIC

BEGIN

	DECLARE CodiceApp INT;
	INSERT INTO Appuntamenti(DataOra, Costo) VALUES (ADataOra, aCosto)

	SELECT CodAppuntamento INTO CodiceApp FROM Appuntamenti WHERE DataOra=aDataOra AND Costo=aCosto
	INSERT INTO AppuntamentiSpeciali(CodAppuntamento, Durata, NomeApp, Luogo, LimitePersone) VALUES (CodiceApp, aDurata, aNomeApp, aLuogo, aLimPersone)
END; 
$

DELIMITER ;