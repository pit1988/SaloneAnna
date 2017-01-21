<?php
login($_REQUEST['username'], $_REQUEST['password']);
header('location:../index.php'); //da controllare che indirizzi correttamente la pagina

function login($username, $password) { //TODO: verificare se lo spostamento delle funzioni di creazione delle sessioni dall'inizio a dopo il check finale crea problemi
	include("dbconnect.php");
	$conn = dbconnect();
	$username = addslashes($_POST["username"]); //come dice il nome aggiunge gli slash di escape alla stringa per i caratteri ', " e \
	$password = addslashes($_POST["password"]);
	$query = "SELECT * FROM Account WHERE user='$username' AND password='$password'";
	$result = $conn->query($query);

	if ($result->num_rows > 0) //se il risultato è stato trovato, ovvero se non è stato restituito un risultato vuoto
			{
					
					//se è loggato creo la sessione
					session_start(); //inizia la sessione
					session_regenerate_id(TRUE); //cambia l'ID della sessione, è una tecnica di sicurezza da inserire dopo la creazione dell'ID
					$_SESSION['username'] = $username; //salvo i dati
					$_SESSION['password'] = $password;
					$_SESSION['LAST_ACTIVITY'] = time(); //salvo l'ultima attività
					header('location:../index.php'); //carica la pagina index.php, inoltre se ci sono errori di header questo comando li aggira
			}
	
	else
			{
					print("Login invalido.");
					exit; //stampa quello che c'è sopra e la funzione viene chiusa con questo comando, in pratica si vede solo una pagina vuota con una scritta sopra, decisamente da evitare
			}
	mysqli_close($conn); //chiude la connessione con il db
}
?>