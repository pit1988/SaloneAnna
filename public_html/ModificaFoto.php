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
    $rif      = "Ti trovi in: <strong xml:lang=&quot;en&quot;>Home</strong>";
    $is_admin = true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    
    if (isset($_POST['submit']) && isset($_POST['codImg'])) {
        $codice = $_POST['codImg'];
        
        $conn     = dbconnect();
        $query_tl = "SELECT Img_filename, Img_desc from Images where Img_title='$codice'";
        $result   = mysqli_query($conn, $query_tl);
        
        if ($result) {
            $row      = mysqli_fetch_row($result);
            $filename = $row[0];
            $descr    = $row[1];
            
            $to_print = '<form enctype="multipart/form-data" action="NuovaFoto.php" method="POST">
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
                </form>
            ';
        } else
            $to_print = "<p>Errore, non è stata selezionata alcuna foto o la foto non è più presente nel database</p>";
    }
    
    elseif (isset($_POST['invia']) && isset($_POST['img_desc']) && isset($_POST['img_old_file']) && isset($_POST['codImg_old'])) {
        $img_desc = $_POST["img_desc"];
        $codice   = $_POST['codImg_old'];
        $filename = $_POST['img_old_file'];
        if (isset($_FILES["uploadedfile"])) {
            $img_name = $_FILES["uploadedfile"]["name"];
            if (($_FILES["uploadedfile"]["type"] == "image/gif" || $_FILES["uploadedfile"]["type"] == "image/jpeg" || $_FILES["uploadedfile"]["type"] == "image/jpg" || $_FILES["uploadedfile"]["type"] == "image/pjpeg" && $_FILES["uploadedfile"]["size"] < 20000)) {
                if ($_FILES["uploadedfile"]["error"] > 0) {
                    $to_print = "<p>Un errore si è presentato durante il caricamento: <span lang=\"en-us\">" . $_FILES["uploadedfile"]["error"] . "</span></p>";
                } else {
                    if (file_exists("uploads/$filename"))
                        unlink("uploads/$filename");
                    $query_el     = "delete from Images where Img_title='$codice'";
                    $i            = 1;
                    $success      = false;
                    $new_img_name = $img_name;
                    while (!$success) {
                        if (file_exists("uploads/" . $new_img_name)) {
                            $i++;
                            $new_img_name = "$i" . $img_name;
                        } else {
                            $success = true;
                        }
                    }
                    
                    $ris = mysqli_query($conn, $query_el);
                    move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "uploads/" . $new_img_name);
                    $to_print = "<p>Immagine memorizzata in: " . "<span lang=\"en\"uploads</span>/" . $new_img_name . "</p>";
                    $qry      = "UPDATE Images SET Img_desc='$img_desc', Img_filename='$new_img_name' WHERE Img_title='$codice'";
                    
                    if (!mysqli_query($conn, $qry)) {
                        $to_print = "<p>Non è stato possibile inserire l'immagine nel database</p>";
                    } else {
                        $to_print = "<p>È stato aggiunto un file nel <span lang=\"en-us\">database</span></p>";
                    }
                }
            } else {
                $to_print = "Il <span lang=\"en-us\">file</span> inserito non è valido</p>";
            }
        }
        //cambia solo la descrizione.
        else {
            $qry = "UPDATE Images SET Img_desc='$img_desc' WHERE Img_title='$codice'";
            if (!mysqli_query($conn, $qry)) {
                $to_print = "<p>Non è stato possibile inserire l'immagine nel database</p>";
            } else {
                $to_print = "<p>È stato aggiunto un file nel <span lang=\"en-us\">database</span></p>";
            }
        }
    }
    
    else {
        $to_print = "<p>Non hai selezionato alcuna immagine</p>";
    }
    
    
    echo $to_print;
    echo "<div><p>Immagine da modificare</p><img src=\"uploads/$filename\" alt=\"\" /></div>";
    
    content_end();
    page_end();
}
?>

