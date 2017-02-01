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
	$title="Utilit&agrave;: Salone Anna";
	$title_meta="Utilit&agrave;: Salone Anna";
	$descr="";
	$keywords="Utilita, Utilit&agrave;, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	
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