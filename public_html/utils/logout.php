<?php
// così funziona
require_once '../library.php';

$login=authenticate();

if($login!=false){
	/* distrugge la sessione */
	$sname=session_name();

	session_destroy();

	if (isset($_COOKIE['username'])) {
	  setcookie($sname,'', time()-3600,'/');
	};
}

/*
//da provare
session_unset(); //questa funzione elimina le variabili contenute nella sessione
if(ini_get("session.use.cookies")) { //in teoria con queste istruzioni dovrebbe eliminarsi il cookie e di conseguenza la sessione
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();
*/

header('location:../index.php');
?>
