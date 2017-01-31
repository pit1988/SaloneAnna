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
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Modifica Foto</strong>';
    $is_admin=true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    echo "<h2>Modifica Foto</h2>";

    
    $conn=dbconnect();
    $query  = "SELECT * FROM Images";
    $result = mysqli_query($conn, $query);
    
    $number_cols = mysqli_num_fields($result);
    
    $num_rows = mysqli_num_rows($result);
    if (!$num_rows)
        echo "<p class=\"info\">Non sono presenti fotografie da modificare</p>";
    else {
        form_start("post", "ModificaFoto.php");
        echo "<fieldset><legend>Seleziona l\' immagine che vuoi modificare</legend>";
            $th = '<table id="TabellaFoto" summary="Seleziona le immagini da eliminare">
                <caption class="nascosto">Tabella immagini</caption>
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
                <td>".'<input type="radio" name="codImg" value= "' . $row[0] . '" /></td>
                </tr>';
            }

            $tf       = "</tbody></table>";
            $to_print = $th . $tb . $tf;
            echo $to_print;
            echo "<input type='submit' name='submit' value='Procedi'>";
            echo "<input type='reset' value='Cancella'>";
        echo"</fieldset>";
        echo "</form>";
    }
    content_end();
    page_end();
    mysqli_close($conn);
}
?>