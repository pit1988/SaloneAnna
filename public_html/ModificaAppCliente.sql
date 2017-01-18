DELIMITER $
CREATE PROCEDURE ModificaAppuntamentoCliente
(
IN aCodAppuntamento INT, 
IN aDataOra DATETIME, 
IN aSconto DOUBLE, 
IN aCosto DOUBLE, 
IN aTipo ENUM('shampoo', 'taglio', 'piega e phon', 'piega e casco', 'ondulazione', 'colore', 'riflessante', 'decolorazione', 'meches', 'trattamenti', 'manicure/pedicure'))

BEGIN

UPDATE Appuntamenti SET DataOra=aDataOra WHERE CodAppuntamento=aCodAppuntamento;
UPDATE Appuntamenti SET Costo=aCosto WHERE CodAppuntamento=aCodAppuntamento;
UPDATE AppuntamentiClienti SET Sconto=aSconto WHERE CodAppuntamento=aCodAppuntamento;
UPDATE AppuntamentiClienti SET TipoAppuntamento=aTipo WHERE CodAppuntamento=aCodAppuntamento;


END $
DELIMITER ;

