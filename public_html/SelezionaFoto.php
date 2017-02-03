<?php

require_once 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login )
{
    header('location:index.php');
    exit;
}
else{
    $title="Seleziona Foto | Salone Anna";
    $title_meta="Seleziona Foto | Salone Anna";
    $descr="Pagina di selezione tra le foto del sito";
    $keywords="Seleziona, Fotografia, Immagine, Foto, Descrizione, Nome, File, Seleziona, Galleria, Tagli";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Modifica Foto</strong>';
    $is_admin=true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    echo "<h2>Modifica Foto</h2>";

    
    $result = listaImmagini();
    
    $num_rows = count($result);

    if (!$num_rows)
        echo "<p class=\"info\">Non sono presenti fotografie da modificare</p>";
    else {
        form_start("post", "ModificaFoto.php");
        echo "<fieldset>
            <legend>Seleziona l'immagine che vuoi modificare</legend>
            ";
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
            foreach ($result as $foto) {
                $tb .= "
                    <tr>
                        <td>$foto->codice</td>
                        <td>$foto->descrizione</td>
                        <td><a href=\"uploads/$foto->nome\">$foto->nome</a></td>
                        <td>".'<input type="radio" name="codImg" value= "' . $foto->codice . '" /></td>
                    </tr>
                    ';
            }

            $tf       = "</tbody></table>";
            $to_print = $th . $tb . $tf;
            echo $to_print;
            echo "<input type='submit' name='submit' value='Procedi'>";
            echo "<input type='reset' value='Cancella'>";
        echo"</fieldset>";
        echo "</form>";
    }
    unset($result);
    content_end();
    page_end();
}
?>