<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
require 'library.php';

/* se l'utente non si è gia` autenticato, va alla pagina da cui fare il login*/
session_start();

session_regenerate_id(TRUE);
if (!isset($_SESSION['username'] ) ) {
	header('location:Accesso.php');
	exit;
}
else
{
	$title="Salone Anna: tariffe, orari, indirizzo";
	$title_meta="Salone Anna, parrucchiere a Vicenza";
	$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
	$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";

	page_start($title, $title_meta, $descr, $keywords);
	$rif="Ti trovi in: <strong xml:lang=&quot;en&quot;>Home</strong>";
	insert_header($rif, 0);
	content_begin();
	echo "Benvenuto ".$_SESSION['username'];
	echo '<img valign= "center" align= "center" src="parrucchiera.jpg" >';
	content_end();
	page_end();
}
?>