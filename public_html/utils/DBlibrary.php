<?php
function dbconnect() {
	$host = "localhost";
	/*$user = "pgabelli";
	$pass = "bi9UJ9ohCoochei7";
	$db = "pgabelli";*/
	$user = "agrenden";
	$pass = "EloTeeli0SaePohF";
	$db = "agrenden";
	/*$user = "smarches";
	$pass = "";
	$db = "smarches";*/
	$conn=new mysqli($host, $user, $pass, $db);
	if($conn -> connect_errno)
		echo "Connessione fallita(".$conn -> connect_errno."): ".$conn -> connect_error;
	return $conn;
};

class Messaggio { //classe che rappresenta un messaggio
	public $codice;
	public $contenuto;
	public $data;
	public $ora;
	public $daLeggere;
	public $email;
	public $nome;
	public $cognome;
	
	function __construct($codice, $contenuto, $data, $ora, $daLeggere, $email, $nome, $cognome) {
		$this->codice = $codice;
		$this->contenuto = $contenuto;
		$this->data = $data;
		$this->ora = $ora;
		$this->daLeggere = $daLeggere;
		$this->email = $email;
		$this->nome = $nome;
		$this->cognome = $cognome;
	}
}

function listaMessaggi() { //i messaggi verranno già ordinati dal più recente al più vecchio
	$conn = dbconnect();
	$query = 'SELECT CodMessaggi, Contenuto, DataOra, ToRead, Email, Nome, Cognome
	FROM Messaggi JOIN Clienti ON Messaggi.CodCliente = Clienti.CodCliente
	ORDER BY DataOra DESC';
	$result = $conn->query($query);
	if(!$result) {$messaggi = NULL;} //il valore NULL segnala che c'è stato un errore nella connessione o nell'esecuzione della query
	else {
		$messaggi = array();
		while($messaggio = mysqli_fetch_assoc($result)) {
			$time = strtotime($messaggio['DataOra']);
			$data = date("d/m/Y", $time); //formato del tipo 05/01/2017
			$ora = date("H:i", $time); //formato del tipo 23:46
			array_push($messaggi, new Messaggio($messaggio['CodMessaggi'], $messaggio['Contenuto'], $data, $ora, $messaggio['ToRead'], $messaggio['Email'], $messaggio['Nome'], $messaggio['Cognome']));
		}
	}
	$conn->close();
	return $messaggi; //è un array di Messaggi, non viene garantito che $messaggi sia stato effettivamente istanziato
}

function eseguiQuery($query) {
	$conn = dbconnect();
	$result = $conn->query($query); //se ci sono problemi segnala che c'è un errore
	$conn->close();
	return $result;
}

function aggiungiMessaggio($email, $nome, $cognome, $contenuto) {
	$conn = dbconnect();
	$cliente = $conn->query("SELECT CodCliente FROM Clienti WHERE Nome='$nome' AND Cognome='$cognome' AND Email='$email'");
	if($cliente->num_rows == 0) { //se il cliente è nuovo lo aggiungo al database
		$result = $conn->query("INSERT INTO Clienti(Nome, Cognome, Email) VALUES ($nome, $cognome, $email)");
		//per inserire il messaggio mi serve il codice del cliente, quindi devo eseguire nuovamente la query per ottenerlo
		if($result==TRUE) $cliente = $conn->query("SELECT MAX(CodCliente) FROM Clienti");
		else {$cliente=FALSE;} //se ci sono stati problemi di connessione li segnalo
	}
	if($cliente) {
		$contenuto = htmlentities($contenuto);
		$dataora = date("Y-m-d H:i:s", time());
		$codcliente = $cliente->fetch_assoc();
		$codcliente = $codcliente['CodCliente'];
		$result = $conn->query("INSERT INTO Messaggi(CodCliente, Contenuto, DataOra, ToRead) VALUES ($codcliente, '$contenuto', '$dataora', 1)");
		$conn->close();
		return $result;
	}
	$conn->close();
	return FALSE;
}

function eliminaMessaggio($codice) {
	return eseguiQuery("DELETE FROM Messaggi WHERE CodMessaggi=$codice");
}
?>