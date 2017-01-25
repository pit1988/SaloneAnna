<?php
function dbconnect() {
	$host = "localhost";
	$user = "pgabelli";
	$pass = "bi9UJ9ohCoochei7";
	$db = "pgabelli";
	$conn=new mysqli($host, $user, $pass, $db);
	if($conn -> connect_errno)
		echo "Connessione fallita(".$conn -> connect_errno."): ".$conn -> connect_error;
	return $conn;
};

class Messaggio { //classe che rappresenta un messaggio
	
}

function listaMessaggi() { //i messaggi verranno già ordinati dal più recente al più vecchio
	$conn = dbconnect();
	$query = '';
	$result = $conn->query($query);
	if(!result) {$err = "Errore nella query: ".$conn->error.".";} //intanto segnalo così il caso, è da eliminare se l'errore viene gestito in locale
	else {return $result;}
	$conn->close();
}
?>