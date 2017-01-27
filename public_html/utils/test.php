<?php
require_once 'DBlibrary.php';
$messaggi=listaMessaggi();
if($messaggi) {
	foreach ($messaggi as $messaggio) {
		echo $messaggio->codice."	".$messaggio->contenuto."	".$messaggio->data."	".$messaggio->ora."	".$messaggio->daLeggere."	".$messaggio->nome."	".$messaggio->cognome;
	}
	unset($messaggio); //fortemente consigliato perché altrimenti l'oggetto $messaggio rimane in memoria
}
?>