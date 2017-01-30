
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'] ) )
{
	header('location:index.php');
	exit;
}
else
{
	require 'library.php';
	include 'utils/DBlibrary.php';
	$title="Messaggi: Salone Anna";
	$title_meta="Messaggi: Salone Anna";
	$descr="";
	$keywords="Messaggi, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Messaggi</strong>';
	insert_header($rif, 7, true);
	content_begin();
	hyperlink("Elimina messaggi","EliminaMessaggi.php");
	$ris=listamessaggi();
	if($ris){
		$str_to_print='<table id="messaggi" summary="Messaggi">
            <caption>Messaggi</caption>
            <thead>
                <tr>
                    <th scope="col">Mittente</th>
                    <th scope="col">Messaggio</th>
                    <th scope="col">Ricevuto</th>
                </tr>
            </thead>
            <tbody>';
		foreach ($ris as $messaggio) {
			if($messaggio->daLeggere==true)
				$str_to_print.= "<tr><td><strong>".$messaggio->nome." " .$messaggio->cognome."</strong></td><td><strong><a href=\"MostraMessaggio.php?codmsg=".$messaggio->codice." \">".(strlen($messaggio->contenuto)>60? substr($messaggio->contenuto, 0, 60)."...":$messaggio->contenuto)."</a></strong></td><td>".$messaggio->data." ".$messaggio->ora."</td></tr>";
			else
				$str_to_print.= "<tr><td>".$messaggio->nome." ".$messaggio->cognome."</td><td><a href=\"MostraMessaggio.php?codmsg=".$messaggio->codice." \">".(strlen($messaggio->contenuto)>60? substr($messaggio->contenuto, 0, 60)."...":$messaggio->contenuto)."</a></td><td>".$messaggio->data." ".$messaggio->ora."</td></tr>";
		}
		$str_to_print.="</tbody></table>";
		unset($messaggio); //fortemente consigliato perché altrimenti l'oggetto $messaggio rimane in memoria
	}
	else 
		$str_to_print="Non sono presenti messaggi";
	echo $str_to_print;
	content_end();
	page_end();
}

?>

