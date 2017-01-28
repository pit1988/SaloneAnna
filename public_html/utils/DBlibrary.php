<?php
function dbconnect() {
	$host = "localhost";
	$user = "pgabelli";
	$pass = "bi9UJ9ohCoochei7";
	$db = "pgabelli";
	/*$user = "agrenden";
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

function eseguiQuery($query) {
	$conn = dbconnect();
	$result = $conn->query($query); //se ci sono problemi segnala che c'è un errore, oppure restituisce i risultati nel caso la query sia una SELECT
	$conn->close();
	return $result;
}

function checkCommaSet(&$set) { //metodo di supporto usato durante l'aggiornamento delle entità
	if($set != "") {$set = $set.", ";}
}

/*******************MESSAGGI************************/

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
	eseguiQuery("DELETE FROM Messaggi WHERE DataOra < (CURDATE() - INTERVAL 2 MONTH)"); //non mi interessa se va a buon fine perché non è una query essenziale, se questa query fallisce ma quella sotto no allora la funzione ha esito positivo
	$result = eseguiQuery('SELECT CodMessaggi, Contenuto, DataOra, ToRead, Email, Nome, Cognome
	FROM Messaggi JOIN Clienti ON Messaggi.CodCliente = Clienti.CodCliente
	ORDER BY DataOra DESC');
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
	return $messaggi; //è un array di Messaggi, non viene garantito che $messaggi sia stato effettivamente istanziato perché potrebbero esserci stato un errore
}

function aggiungiMessaggio($email, $nome, $cognome, $contenuto) { //se ci sono errori in qualche query la funzione restituisce FALSE, altrimenti TRUE
	$conn = dbconnect();
	$errore = FALSE;
	$checkChiocciola = strpos($email, '@');
	$checkPunto = strrpos($email, '.');
	if($email == "" || ($checkChiocciola === FALSE || $checkPunto === FALSE || $checkChiocciola>$checkPunto) || $nome=="" || $cognome=="") {$errore = TRUE;}
	if($errore === FALSE) {
		$cliente = $conn->query("SELECT CodCliente FROM Clienti WHERE Nome='$nome' AND Cognome='$cognome' AND Email='$email'");
		if($cliente && $cliente->num_rows == 0) { //se il cliente è nuovo lo aggiungo al database
			$result = $conn->query("INSERT INTO Clienti(Nome, Cognome, Email) VALUES ('$nome', '$cognome', '$email')");
			//per inserire il messaggio mi serve il codice del cliente, quindi devo eseguire nuovamente la query per ottenerlo
			if($result==1) {$cliente = $conn->query("SELECT MAX(CodCliente) AS CodCliente FROM Clienti");}
			else {$cliente=FALSE;} //se ci sono stati problemi di connessione li segnalo
		}
		if($cliente) {
			$nome = htmlentities($nome);
			$cognome = htmlentities($cognome);
			$contenuto = htmlentities($contenuto);
			$dataora = date("Y-m-d H:i:s", time());
			$codcliente = $cliente->fetch_assoc();
			$codcliente = $codcliente['CodCliente'];
			$result = $conn->query("INSERT INTO Messaggi(CodCliente, Contenuto, DataOra, ToRead) VALUES ($codcliente, '$contenuto', '$dataora', 1)");
			$conn->close();
			if($result) return TRUE;
			return FALSE;
		}
	}
	$conn->close();
	return FALSE;
}

function eliminaMessaggio($codice) {
	return eseguiQuery("DELETE FROM Messaggi WHERE CodMessaggi=$codice");
}

/************************Clienti**************************/

class Cliente {
	public $codice;
	public $nome;
	public $cognome;
	public $telefono;
	public $email;
	public $dataNascita;
	
	function __construct($codice, $nome, $cognome, $telefono, $email, $dataNascita) {
		$this->codice = $codice;
		$this->nome = $nome;
		$this->cognome = $cognome;
		$this->telefono = $telefono;
		$this->email = $email;
		$this->dataNascita = $dataNascita;
	}
}

function listaClienti() {
	$result = eseguiQuery("SELECT * FROM Clienti");
	if(!$result) {$clienti = NULL;} //il valore NULL segnala che c'è stato un errore nella connessione o nell'esecuzione della query
	else {
		$clienti = array();
		while($cliente = mysqli_fetch_assoc($result)) {
			$time = strtotime($cliente['DataNascita']);
			$data = date("d/m/Y", $time); //formato del tipo 05/01/2017
			array_push($clienti, new Cliente($cliente['CodCliente'], $cliente['Nome'], $cliente['Cognome'], $cliente['Telefono'], $cliente['Email'], $data));
		}
	}
	return $clienti; //è un array di Clienti, non viene garantito che $clienti sia stato effettivamente istanziato perché potrebbero esserci stato un errore
}

function aggiungiCliente($nome, $cognome, $telefono = "", $email = "", $dataNascita = "") {
	$data = strtotime($dataNascita);
	if($data !== FALSE) {$data = "'".date("Y-m-d", $data)."'";}
	else {$data = "NULL";}
	$nome = htmlentities($nome);
	$cognome = htmlentities($cognome);
	$checkChiocciola = strpos($email, '@');
	$checkPunto = strrpos($email, '.');
	if($telefono == "") {$telefono="NULL";}
	if($email == "" || ($checkChiocciola === FALSE || $checkPunto === FALSE || $checkChiocciola>$checkPunto)) {$email="NULL";}
	return eseguiQuery("INSERT Clienti(Nome, Cognome, Telefono, Email, DataNascita) VALUES('$nome', '$cognome', '$telefono', '$email', $data)");
}

function eliminaCliente($codice) {
	return eseguiQuery("DELETE FROM Clienti WHERE CodCliente=$codice");
}

function aggiornaCliente($codice, $nome = "", $cognome = "", $telefono = "", $email = "", $dataNascita = "") {
	$set = "";
	if($nome != "") {$nome = htmlentities($nome); $set = $set."Nome='$nome'";}
	if($cognome != "") {$cognome = htmlentities($cognome); checkCommaSet($set); $set = $set."Cognome='$cognome'";}
	if($telefono != "") {checkCommaSet($set); $set = $set."Telefono='$telefono'";}
	$checkChiocciola = strpos($email, '@');
	$checkPunto = strrpos($email, '.');
	if($checkChiocciola !== FALSE && $checkPunto !== FALSE && $checkChiocciola<$checkPunto) {checkCommaSet($set); $set = $set."Email='$email'";}
	if($dataNascita != "") {
		$data = strtotime($dataNascita);
		if($data !== FALSE) {$data = date("Y-m-d", $data); checkCommaSet($set); $set = $set."DataNascita='$data'";}
	}
	return eseguiQuery("UPDATE Clienti
	SET $set
	WHERE CodCliente=$codice"); //se $set è vuoto (non viene aggiornato nulla) viene restituito FALSE
}

/**********************TIPO APPUNTAMENTI***********************/

class TipoAppuntamento {
	public $codice;
	public $nome;
	public $costo;
	public $sconto;
	
	function __construct($codice, $nome, $costo, $sconto) {
		$this->codice = $codice;
		$this->nome = $nome;
		$this->costo = $costo;
		$this->sconto = $sconto;
	}
}

function listaTipoAppuntamenti() {
	$result = eseguiQuery("SELECT * FROM TipoAppuntamento");
	if(!$result) {$tipi = NULL;} //il valore NULL segnala che c'è stato un errore nella connessione o nell'esecuzione della query
	else {
		$tipi = array();
		while($tipo = mysqli_fetch_assoc($result)) {
			array_push($tipi, new TipoAppuntamento($tipo['CodTipoAppuntamento'], $tipo['NomeTipo'], $tipo['Costo'], $tipo['Sconto']));
		}
	}
	return $tipi; //è un array di TipoAppuntamento, non viene garantito che $tipi sia stato effettivamente istanziato perché potrebbero esserci stato un errore
}

function aggiungiTipoAppuntamento($nome, $costo=0, $sconto=0) {
	$nome = htmlentities($nome);
	if($nome === "") {return FALSE;} //un TipoAppuntamento senza nome non ha senso
	if($costo === "") {$costo=0;} //per sicurezza faccio questi controlli, anche se non dovrebbero servire, non dovrebbe essere possibile immettere come valore una stringa vuota
	if($sconto === "") {$sconto=0;}
	echo "INSERT TipoAppuntamento(NomeTipo, Costo, Sconto) VALUES('$nome', $costo, $sconto)";
	return eseguiQuery("INSERT TipoAppuntamento(NomeTipo, Costo, Sconto) VALUES('$nome', $costo, $sconto)");
}

function eliminaTipoAppuntamento($codice) {
	return eseguiQuery("DELETE FROM TipoAppuntamento WHERE CodTipoAppuntamento=$codice");
}

function aggiornaTipoAppuntamento($codice, $nome = "", $costo = -1, $sconto = -1) {
	$set = "";
	if($nome != "") {$nome = htmlentities($nome); $set = $set."NomeTipo='$nome'";}
	if($costo > -1) {checkCommaSet($set); $set = $set."Costo=$costo";} //uso -1 come valore nullo perché 0 potrebbe essere un numero valido, soprattutto per sconto
	if($sconto > -1) {checkCommaSet($set); $set = $set."Sconto=$sconto";}
	return eseguiQuery("UPDATE TipoAppuntamento
	SET $set
	WHERE CodTipoAppuntamento=$codice"); //se $set è vuoto (non viene aggiornato nulla) viene restituito FALSE
}

/***********************APPUNTAMENTI***********************/

class Appuntamento {
	public $codice;
	public $data;
	public $ora;
	public $tipo;
	public $prezzo;
	public $nome;
	public $cognome;
	public $telefono;
	public $email;
	
	function __construct($codice, $data, $ora, $tipo, $prezzo, $nome, $cognome, $telefono, $email) {
		$this->codice = $codice;
		$this->codice = $data;
		$this->codice = $ora;
		$this->codice = $tipo;
		$this->codice = $prezzo; //inteso come costo già scontato
		$this->codice = $nome;
		$this->codice = $cognome;
		$this->codice = $telefono;
		$this->codice = $email;
	}
}

function listaAppuntamenti() {
	$result = eseguiQuery("SELECT CodAppuntamento, DataOra, NomeTipo, Costo, Sconto, Nome, Cognome, Telefono, Email
	FROM Appuntamenti JOIN TipoAppuntamento ON Appuntamenti.CodTipoAppuntamento=TipoAppuntamento.CodTipoAppuntamento JOIN Clienti ON Appuntamenti.CodCliente=Clienti.CodCliente
	ORDER BY DataOra DESC");
	if(!$result) {$appuntamenti = NULL;} //il valore NULL segnala che c'è stato un errore nella connessione o nell'esecuzione della query
	else {
		$appuntamenti = array();
		while($appuntamento = mysqli_fetch_assoc($result)) {
			$time = strtotime($appuntamento['DataNascita']);
			$data = date("d/m/Y", $time); //formato del tipo 05/01/2017
			$ora = date("H:i", $time); //formato del tipo 23:46
			$prezzo = round($appuntamento['prezzo'] * ((100-$appuntamento['sconto'])/100), 2); //round arrotonda il numero alla seconda cifra decimale
			array_push($appuntamenti, new Appuntamento($appuntamento['CodAppuntamento'], $data, $ora, $appuntamento['NomeTipo'], $prezzo, $appuntamento['Nome'], $appuntamento['Cognome'], $appuntamento['Telefono'], $appuntamento['Email']));
		}
	}
	return $appuntamenti; //è un array di Clienti, non viene garantito che $clienti sia stato effettivamente istanziato perché potrebbero esserci stato un errore
}
?>