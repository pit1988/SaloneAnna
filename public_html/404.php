<?php
require 'library.php';
require 'utils/DBlibrary.php';


$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="<strong>404: pagina non trovata</strong>";
$name="visitatore"; 
$is_admin=false;

if (authenticate() ) {
	$is_admin=true;
}

insert_header($rif, 0, $is_admin,'');
content_begin();
echo"<div><p>Ci sono stati problemi durante la connessione al database</p></div>";
content_end();
page_end();
?>
