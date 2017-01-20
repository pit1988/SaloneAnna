<?php
// così funziona
// require_once '../library.php';

// $login=authenticate();

// if($login!=false){
// 	/* distrugge la sessione */
// 	$sname=session_name();

// 	session_destroy();

// 	if (isset($_COOKIE['username'])) {
// 	  setcookie($sname,'', time()-3600,'/');
// 	};
// }


//così non funziona
session_unset(); //questa funzione elimina le variabili contenute nella sessione
session_destroy(); //questa funzione elimina la sessione


header('location:../index.php');
?>
