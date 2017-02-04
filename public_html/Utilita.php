<?php
require 'library.php';
require 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login )
{
	header('location:errore.php?codmsg=1');
	exit;
}
else
{
	$title="Menù Utilità | Salone Anna";
	$title_meta="Menù Utilità | Salone Anna";
	$descr="Menù di utilità per il Salone Anna";
	$keywords="Utilita, Utilità, Messaggi, Amministratore, Password, Admin, Leggi, Cambio";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Utilit&agrave;</strong>';
	insert_header($rif, 7, true);
	content_begin();
    echo "<h2>Men&ugrave; Utilit&agrave;</h2>";
		hyperlink("Leggi i Messaggi", "Messaggi.php");
		hyperlink("Cambio Password", "CambioPassword.php");
	content_end();
	page_end();
}

?>