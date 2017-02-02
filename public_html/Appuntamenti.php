<?php

$login=authenticate();

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
	insert_header($rif, 6, true);
	content_begin();
    echo "<h2>Men&ugrave; Appuntamenti</h2>";
		hyperlink("Tipo Appuntamento Frequente", "Toptype.php");
		hyperlink("Vista Appuntamenti settimana", "AppuntamentiSettimana.php");
		hyperlink("Ricerca Appuntamenti", "RicercaAppuntamenti.php");
		hyperlink("Nuovo Appuntamento", "NuovoAppuntamento.php");
		hyperlink("Modifica Appuntamento", "ScegliAppuntamento.php");
		hyperlink("Elimina Appuntamenti", "EliminaAppuntamenti.php");
	content_end();
	page_end();
}

?>