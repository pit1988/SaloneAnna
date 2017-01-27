
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
	$title="Appuntamenti: Salone Anna";
	$title_meta="Appuntamenti: Salone Anna";
	$descr="";
	$keywords="Appuntamenti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Appuntamenti</strong>';
	insert_header($rif, 4, true);
	content_begin();
		hyperlink("Nuovo Appuntamento", "NuovoAppuntamento.php");
		hyperlink("Tipo Appuntamento Frequente", "Toptype.php");
		hyperlink("Ricerca Appuntamenti", "RicercaAppuntamenti.php");
		hyperlink("Modifica Appuntamenti", "GestioneAppuntamenti.php");
		hyperlink("Elimina Appuntamenti", "GestioneAppuntamenti.php");
	content_end();
	page_end();
}

?>