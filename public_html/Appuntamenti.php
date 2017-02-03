<?php
require 'library.php';
require 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login )
{
	header('location:index.php');
	exit;
}
else
{
	$title="Menù Appuntamenti | Salone Anna";
	$title_meta="Menù Appuntamenti | Salone Anna";
	$descr="Menù appuntamenti Salone Anna Parrucchiera";
	$keywords="Appuntamenti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna, menù, storico, agenda, classifica";
	
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