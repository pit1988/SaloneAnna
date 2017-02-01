<?php

require_once 'library.php';
include 'utils/DBlibrary.php';

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    $title      = "Salone Anna: Inserisci foto";
    $title_meta = "Salone Anna, parrucchiere a Vicenza";
    $descr      = "Pagina per inserire fotografie all'interno del sito";
    $keywords   = "Fotografie, Immagini, Foto, Anna, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Inserisci Foto</strong>';
    $is_admin = true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    echo "<h2>Inserisci nuova Foto</h2>";
    if (isset($_POST["submit"])) {
        $img_desc = $_POST["img_desc"];
        $ris=aggiungiImmagine($img_desc, $_FILES['uploadedfile']);
        if (isset($ris) && (!$ris)) {
            $err= "<p class=\"errorSuggestion\">Non è stato possibile inserire l'immagine nel <span lang=\"en\">database</span></p>";
        } 
        else {
            echo "<p class=\"inforesult\">È stato aggiunto un file nel <span lang=\"en\">database</span></p>";
        }
        $ris->free();
    }
    
    
    if (isset($err))
        echo "<p class=\"errorSuggestion\"><b>Errore: $err</b></p>";
    
    $to_print = '
    <form enctype="multipart/form-data" action="NuovaFoto.php" method="post">
    <fieldset><legend>Carica un <span lang="en">file</span> e completa i campi per inserire una nuova immagine</legend>
        <ul>
            <li>
                <p>
                    <label for="uploadedfile">Inserisci un\'immagine</label>
                    <input name="uploadedfile" id="uploadedfile" type="file" />
                </p>
                <p>
                    <label for="img_desc">Descrizione</label>
                    <input type="text" name="img_desc" id="img_desc" />
                </p>
                <p>
                    <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                    <span id="errors"></span>
                </p>
            </li>
        </ul>
    </fieldset>
    </form>
    ';
    echo $to_print;
    
    content_end();
    page_end();
}
?>

