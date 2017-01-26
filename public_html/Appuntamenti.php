
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
	$title="Clienti: Salone Anna";
	$title_meta="Clienti: Salone Anna";
	$descr="";
	$keywords="Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Clienti</strong>';
	insert_header($rif, 4, true);
	content_begin();
		hyperlink("Nuovo Appuntamento", "NuovoAppuntamento.php");
		hyperlink("Tipo Appuntamento Frequente", "Toptype.php");
		hyperlink("Ricerca Appuntamenti", "RicercaAppuntamenti.php");
		hyperlink("Gestione Appuntamenti", "GestioneAppuntamenti.php");
	content_end();
	page_end();
}

?>