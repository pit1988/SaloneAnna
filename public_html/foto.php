<?php
require 'library.php';
include 'utils/DBlibrary.php';
/* se l'utente non si è gia` autenticato, va alla pagina da cui fare il login*/
$login=authenticate();

$title="Galleria Foto | Salone Anna";
$title_meta="Galleria Foto | Salone Anna, parrucchiere a Vicenza";
$descr="Galleria di fotografie di clienti o modelli realizzati dal Salone Anna";
$keywords="Foto, Modelle, Relizzazioni, Clienti, Taglio, Colore, Capelli, Uomo, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Foto</strong>';
$is_admin=false;
$name="visitatore";

if ($login ) {
    $is_admin=true;
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