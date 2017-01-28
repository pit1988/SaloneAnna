<?php
require 'library.php';

/* se l'utente non si è gia` autenticato, mostra nel menù le pagine accessibili al pubblico*/
session_start();

session_regenerate_id(TRUE);

$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="<strong xml:lang=&quot;en&quot;>Home</strong>";
$name="visitatore"; 
$is_admin=false;

if (isset($_SESSION['username'] ) ) {
	$is_admin=true;
	$name = $_SESSION['username'];
}

insert_header($rif, 0, $is_admin,'');
content_begin();
echo"<div id=\"immagine\" class=\"center\" title=\"Modella\" alt=\"Immagine modella bionda\"></div>";
content_end();
page_end();
?>
