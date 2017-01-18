<?php
function login($username, $password) { //TODO: verificare se lo spostamento delle funzioni di creazione delle sessioni dall'inizio a dopo il check finale crea problemi
	include("dbconnect.php");
	$conn = dbconnect();
	$username = addslashes($_POST["username"]); //come dice il nome aggiunge gli slash di escape alla stringa per i caratteri ', " e \
	$password = addslashes($_POST["password"]);
	$query = "SELECT * FROM Login WHERE user='$username' AND password='$password'";
	$result = $conn->query($query);

	if ($result->num_rows > 0) //se il risultato è stato trovato, ovvero se non è stato restituito un risultato vuoto
			{
					
					//se è loggato creo la sessione
					session_start(); //inizia la sessione, forse meglio spostare il tutto dopo il check del login, probabilmente devo usaral anche quando voglio fare il check o voglio recuperare le variabili
					session_regenerate_id(TRUE); //cambia l'ID della sessione, è una tecnica di sicurezza da inserire dopo la creazione dell'ID
					$_SESSION['username'] = $username; //salvo i dati
					$_SESSION['password'] = $password;
					header('location:Root.php'); //carica la pagina Root.php, inoltre se ci sono errori di header questo comando li aggira (vedo se usarla o no, dato che le pagine dovrebbero essere fatte bene la sua assenza non dovrebbe causare problemi)
			}
	
	else
			{
					print("Login invalido.");
					exit; //stampa quello che c'è sopra e la funzione viene chiusa con questo comando, in pratica si vede solo una pagina vuota con una scritta sopra, decisamente da evitare
			}
	mysqli_close($conn); //chiude la connessione con il db
}

function checkSessionLifetime() { //TODO: da verificare se e come funziona
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // l'ultima richiesta era di almeno 30 minuti fa
    session_unset();     // elimina tutte le variabili salvate nella sessione
    session_destroy();   // elimina la sessione
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // aggiorna il timestamp dell'attività
}

function logout() {
	session_unset(); //nella funzione sopra è spiegato cosa fanno queste due istruzioni
	session_destroy();
}
?>