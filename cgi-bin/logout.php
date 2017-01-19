<?php
session_unset(); //questa funzione elimina le variabili contenute nella sessione
session_destroy(); //questa funzione elimina la sessione
header('location:../index.php'); //da controllare che indirizzi correttamente la pagina
?>