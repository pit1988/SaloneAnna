<?php
// così funziona
require_once 'DBlibrary.php';
require_once '../library.php';

$login=authenticate(); //per sicurezza controllo che ci sia una sessione attiva, questa condizione dovrebbe essere sempre vera quando viene eseguito questo codice

if($login!=false){
	/* distrugge la sessione */
	$sname=session_name();
	session_unset(); //questa funzione elimina le variabili contenute nella sessione
	session_destroy();

	if (isset($_COOKIE['username'])) {
	  setcookie($sname,'', time()-3600,'/');
	};
}

header('location:../index.php');
?>
