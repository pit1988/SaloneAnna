<?php

require_once 'library.php';
include 'utils/DBlibrary.php';

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'] ) )
{
    header('location:index.php');
    exit;
}
else{
    $title="Salone Anna: Inserisci foto";
    $title_meta="Salone Anna, parrucchiere a Vicenza";
    $descr="Pagina per inserire fotografie all'interno del sito";
    $keywords="Fotografie, Immagini, Foto, Anna, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";
    page_start($title, $title_meta, $descr, $keywords,'');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Clienti</strong>';
    insert_header($rif, 1, true);
    content_begin();
        hyperlink("Inserisci foto", "img_db.php");
        hyperlink("Visualizza galleria","foto.php");
        hyperlink("Elimina foto","EliminaFoto.php");
        hyperlink("Modifica foto","ModificaFoto.php");
    content_end();
    page_end();
}

?>

