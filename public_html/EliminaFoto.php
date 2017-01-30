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
    if (isset($_POST['submit']) && isset($_POST['codImg'])) {
        $ids   = $_POST['codImg'];
        $n_el  = 0;
        $n_err = 0;
        foreach ($ids as $codice) {
            $conn     = dbconnect();
            $query_tl = "SELECT Img_filename from Images where Img_title='$codice'";
            $result   = mysqli_query($conn, $query_tl);
            
            if ($result) {
                $row      = mysqli_fetch_row($result);
                $filename = $row[0];
                if (file_exists("uploads/$filename"))
                    unlink("uploads/$filename");
            }
            $query_el = "delete from Images where Img_title='$codice'";
            $ris = mysqli_query($conn, $query_el);
            if ($ris)
                ++$n_el;
            else
                ++$n_err;
        }
        
        if ($n_el > 0)
            if ($n_el == 1)
                $msg = "<p>È stato cancellato $n_el messaggio</p>";
            else
                $msg = "<p>Sono stati cancellati $n_el messaggi</p>";
        if ($n_err > 0)
            $msg = "<p>Durante la cancellazione si sono verificati $n_err errori</p>";
    }
    $title      = "Salone Anna: Inserisci foto";
    $title_meta = "Salone Anna, parrucchiere a Vicenza";
    $descr      = "Pagina per inserire fotografie all'interno del sito";
    $keywords   = "Fotografie, Immagini, Foto, Anna, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif      = "<strong xml:lang=&quot;en&quot;>Home</strong>";
    $is_admin = true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    
    $conn   = dbconnect();
    $query  = "SELECT * FROM Images";
    $result = mysqli_query($conn, $query);
    
    $number_cols = mysqli_num_fields($result);
    
    $num_rows = mysqli_num_rows($result);
    if (!$num_rows)
        echo "<p>Non ci sono immagini da mostrare</p>";
    else {
        form_start("POST", "EliminaFoto.php");
        $th = '<table id="TabellaFoto" summary="Seleziona le immagini da eliminare">
            <caption>Seleziona le immagini da eliminare</caption>
            <thead>
                <tr>
                    <th scope="col">Img_title</th>
                    <th scope="col">Img_desc</th>
                    <th scope="col">Img_filename</th>
                    <th scope="col">Seleziona</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th scope="col">Img_title</th>
                    <th scope="col">Img_desc</th>
                    <th scope="col">Img_filename</th>
                    <th scope="col">Seleziona</th>
                </tr>
            </tfoot>

            <tbody>
            ';
        $tb = "";
        //corpo tabella
        while ($row = mysqli_fetch_row($result)) {
            $tb .= "<tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td><a href=\"uploads/$row[2]\">$row[2]</a></td>
            <td>" . '<input type="checkbox" name="codImg[]" value= "' . $row[0] . '" /></td>
            </tr>';
        }
        
        $tf       = "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo "<input type='submit' name='submit' value='Procedi'>";
        echo "<input type='reset' value='Cancella'>";
        // echo"</fieldset>";
        echo "</form>";
    }
    content_end();
    page_end();
    mysqli_close($conn);
}
?>