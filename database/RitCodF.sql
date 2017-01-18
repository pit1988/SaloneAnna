DELIMITER $
CREATE FUNCTION RitCod(aNome VARCHAR(10), aCognome VARCHAR(10)) 
RETURNS INT
BEGIN
	DECLARE CodCli INT;
	
	SELECT CodCliente INTO CodCli
	FROM Clienti
	WHERE Nome=aNome AND Cognome=aCognome;
	
	RETURN CodCli;
END $
delimiter ;

