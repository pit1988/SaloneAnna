<?php
require 'library.php';
include 'utils/DBlibrary.php';

/* se l'utente non si è gia` autenticato, mostra nel menù le pagine accessibili al pubblico*/
$login=authenticate();

$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="<strong xml:lang=\"en\">Home</strong>";
$name="visitatore"; 
$is_admin=false;

if (checkLog() ) {
	$is_admin=true;
	$name = $login;
}

insert_header($rif, 0, $is_admin,'');
content_begin();
echo"<div id=\"immagine\" class=\"center\" title=\"Modella bionda\"></div>";
content_end();
page_end();
?>
