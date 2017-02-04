<?php

require_once 'library.php';
include 'utils/DBlibrary.php';
$login=authenticate();

// Controllo accesso
if (!$login )
{
    header('location:errore.php?codmsg=1');
    exit;
}
else{
    $title="Menù Foto | Salone Anna";
    $title_meta="Menù Foto | Salone Anna, parrucchiere a Vicenza";
    $descr="Da questa pagina si possono gestire le immagini nel sito";
    $keywords="Fotografie, Immagini, Foto, Anna, Parrucchiere, Nuova, Elimina, Modifica, Galleria";
    page_start($title, $title_meta, $descr, $keywords,'');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Immagini</strong>';
    insert_header($rif, 1, true);
    content_begin();
    echo "<h2>Men&ugrave; Foto</h2>";
        hyperlink("Inserisci foto", "NuovaFoto.php");
        hyperlink("Visualizza galleria","foto.php");
        hyperlink("Elimina foto","EliminaFoto.php");
        hyperlink("Modifica foto","SelezionaFoto.php");
    content_end();
    page_end();
}

?>

