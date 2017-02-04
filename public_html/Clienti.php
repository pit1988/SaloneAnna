<?php
require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login )
{
	header('location:index.php');
	exit;
}
else
{
	$title="Menù Clienti | Salone Anna";
	$title_meta="Menù Clienti | Salone Anna";
	$descr="Menù per gestire i clienti del Salone Anna";
	$keywords="Menù, Clienti, Parrucchiere, Montecchio, Vicenza, Colorazioni, Donna, Compleanni, Storico";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Clienti</strong>';
	insert_header($rif, 5, true);
	content_begin();
    echo "<h2>Men&ugrave; Clienti</h2>";
		hyperlink("Compleanni Questo Mese", "QueryCompleanno.php");
		hyperlink("Mostra l'elenco di tutti i clienti","ElencoClienti.php");
		hyperlink("Inserisci un nuovo cliente","NuovoCliente.php");
		hyperlink("Modifica clienti presenti nell'elenco","ScegliCliente.php");
		hyperlink("Elimina clienti dall'elenco","EliminaCliente.php");
		hyperlink("Storico Prodotti","StoricoProd.php");
	content_end();
	page_end();
}

?>

