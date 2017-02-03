<?php
require 'library.php';
require 'utils/DBlibrary.php';


$title="Salone Anna | errore 404 - pagina non trovata";
$title_meta="Salone Anna | errore 404 - pagina non trovata";
$descr="Salone Anna | Pagina di errore 404 - pagina non trovata";
$keywords="Pagina, errore, 404, Parrucchiere, Montecchio, Vicenza, Taglio, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="<strong id="logError">404: pagina non trovata</strong>";
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
