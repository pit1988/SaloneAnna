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
    $rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Modifica Foto</strong>';
    $is_admin = true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    echo "<h2>Modifica Foto</h2>";

    
    if (isset($_POST['submit']) && isset($_POST['codImg'])) {
        $codice = $_POST['codImg'];
        
        $conn     = dbconnect();
        $query_tl = "SELECT Img_filename, Img_desc from Images where Img_title='$codice'";
        $result   = mysqli_query($conn, $query_tl);
        
        if ($result) {
            $row      = mysqli_fetch_row($result);
            $filename = $row[0];
            $descr    = $row[1];
            
            $to_print = '
            <form enctype="multipart/form-data" action="NuovaFoto.php" method="post">
                <fieldset><legend>Inserisci una nuova foto</legend>
                    <ul>
                        <li>
                            <p>
                                <label for="uploadedfiled">Inserisci un\'immagine</label>
                                <input name="uploadedfile" id="uploadedfiled" type="file" />
                            </p>
                            <p>
                                <label for="img_desc">Descrizione</label>
                                <input type="text" name="img_desc" id="img_desc" value="' . $descr . '" />
                            </p>
                            <p>
                                <input type="hidden" name="img_old_file" id="img_old_file" value="' . $filename . '" />
                                <input type="hidden" name="codImg_old" id="codImg_old" value="' . $codice . '" />
                                <input class="btn btn-submit" type="submit" name="invia" value="Invia" tabindex="105"/>
                                <span id="errors"></span>
                            </p>
                        </li>
                    </ul>
                </fieldset>
            </form>
            ';
        } else
            $to_print = "<p class=\"errorSuggestion\">Errore, non è stata selezionata alcuna foto o la foto non è più presente nel <span lang=\"en\">database</span></p>";
    }
    
    elseif (isset($_POST['invia']) && isset($_POST['img_desc']) && isset($_POST['img_old_file']) && isset($_POST['codImg_old'])) {
        $img_desc = $_POST["img_desc"];
        $codice   = $_POST['codImg_old'];
        $filename = $_POST['img_old_file'];
        if (isset($_FILES["uploadedfile"])) {
            $img_name = $_FILES["uploadedfile"]["name"];
            $ris=modificaImmagine($codice, $img_desc, $_FILES["uploadedfile"]);

            if (!$ris) {
                        $to_print = "<p class=\"errorSuggestion\">Modiifcare l'immagine selezionata</span></p>";
            } else {
                $to_print = "<p class=\"inforesult\">L'immagine è stata modificata con successo</p>";
            }
        }
        //cambia solo la descrizione.
        else {
            $ris=modificaImmagine($codice, $img_desc);

            if (!$ris) {
                $to_print = "<p class=\"errorSuggestion\">Modiifcare l'immagine selezionata</span></p>";
            } else {
                $to_print = "<p class=\"inforesult\">L'immagine è stata modificata con successo</p>";
            }

/*
            $qry = "UPDATE Images SET Img_desc='$img_desc' WHERE Img_title='$codice'";
            if (!mysqli_query($conn, $qry)) {
                $to_print = "<p class=\"errorSuggestion\">Non è stato possibile inserire l'immagine nel <span lang=\"en\">database</span></p>";
            } else {
                $to_print = "<p class=\"inforesult\">È stato aggiunto un file nel <span lang=\"en\">database</span></p>";
            }*/
        }
    }
    
    else {
        $to_print = "<p class=\"errorSuggestion\">Non hai selezionato alcuna immagine</p>";
    }
    
    
    echo $to_print;
    echo "<div><p class=\"inforesult\">Immagine da modificare</p><img src=\"uploads/$filename\" alt=\"\" /></div>";
    
    content_end();
    page_end();
}
?>

