<?php

require_once 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!checkLog()) {
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

    $modified=false;
    
    if (isset($_POST['submit']) && isset($_POST['codImg'])) {
        $codice = $_POST['codImg'];
        
        $result   = mostraImmagine($codice);
        
        $n_rows=count($result);

        if ($n_rows==1) {
            $filename = $result->nome;
            $descr    = $result->descrizione;
            $to_print = '
            <form enctype="multipart/form-data" action="ModificaFoto.php" method="post">
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
                            <p>
                                <label for="oldfile">Immagine da modificare</label>
                                <img src="uploads/' . $filename . '" class="oldfile" alt="'.$descr.'" />
                        </li>
                    </ul>
                </fieldset>
            </form>
            
            ';
        } 
        else
            $to_print = "<p class=\"errorSuggestion\">Errore, non è stata selezionata alcuna foto o la foto non è più presente nel <span lang=\"en\">database</span></p>";
        unset($result);
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
                $to_print = "<p class=\"errorSuggestion\">Modifcare l'immagine selezionata</span></p>";
            } else {
                $to_print = "<p class=\"inforesult\">L'immagine è stata modificata con successo</p>";
            }
        }
    }
    
    else {
        $to_print = "<p class=\"errorSuggestion\">Non hai selezionato alcuna immagine</p>";
    }
    
    
    echo $to_print;
    
    content_end();
    page_end();
}
?>

