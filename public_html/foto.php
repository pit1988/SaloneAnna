<?php
require 'library.php';
include 'utils/DBlibrary.php';
/* se l'utente non si è gia` autenticato, va alla pagina da cui fare il login*/
session_start();
session_regenerate_id(TRUE);

$title="Foto Salone Anna";
$title_meta="Foto Salone Anna, parrucchiere a Vicenza";
$descr="Fotografie di clienti del Salone Anna";
$keywords="Foto, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Foto</strong>';
$is_admin=false;
$name="visitatore";

if (isset($_SESSION['username'] ) ) {
    $is_admin=true;
    $name = $_SESSION['username'];
    $rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Foto</strong>';
}

insert_header($rif, 1, $is_admin);
content_begin();


// collegarsi al DB, leggere le immagini ed inserirle.
$result = listaImmagini();

$num_rows = count($result);

echo "<h2>Image Gallery</h2>\n";

if ($num_rows>0){
	echo "<div id=\"galleria\">";
	foreach ($result as $foto) {
        echo "
	    	<div class=\"photo\">
	    	    <a href=\"uploads/".$foto->nome."\">
                <img src=\"uploads/".$foto->nome."\" alt=\"". trim($foto->descrizione)." \"/>
                <span class=\"desc\">" . $foto->descrizione. "</span>
                </a>
	    	</div>
	    	";
    }
    echo "</div>";
}
else
    echo "<p class=\"info\">Non ci sono immagini da mostrare</p>";

unset($result);

content_end();
page_end();
?>