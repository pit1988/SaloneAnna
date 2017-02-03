<?php

require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    if (isset($_POST['submit']) && isset($_POST['codImg'])) {
        $ids   = $_POST['codImg'];
        $n_el  = 0;
        $n_err = 0;
        foreach ($ids as $codice) {
            $result   = eliminaImmagine($codice);
            
            if ($result) 
                ++$n_el;
            else
                ++$n_err;
            unset($result);
        }
        
        if ($n_el > 0)
            if ($n_el == 1)
                $msg = "<p class=\"inforesult\">È stata cancellata $n_el foto</p>";
            else
                $msg = "<p class=\"inforesult\">Sono state cancellate $n_el foto</p>";
        if ($n_err > 0)
            $msg = "<p class=\"errorSuggestion\>Durante la cancellazione si sono verificati $n_err errori</p>";
    }

    $title      = "Elimina Foto | Salone Anna";
    $title_meta = "Elimina Foto | Salone Anna";
    $descr      = "Pagina per eliminare le fotografie all'interno del sito";
    $keywords   = "Fotografie, Immagini, Foto, Descrizioni, Nome, File, Seleziona, Mostrare, Galleria, Tagli ";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Elimina Foto</strong>';
    $is_admin = true;
    insert_header($rif, 1, $is_admin);
    content_begin();
    echo "<h2>Elimina Foto</h2>";
    
    $result = listaImmagini();
    
    $num_rows = count($result);

    if ($num_rows==0)
        echo "<p class=\"info\">Non ci sono immagini da mostrare</p>";
    else {
        echo "<form method=\"post\" action=\"EliminaFoto.php\">
            <fieldset><legend>Seleziona le foto che vuoi eliminare</legend>\n";
        $th = '<table id="TabellaFoto" summary="Seleziona le immagini da eliminare">
            <caption class="nascosto">Tabella di immagini</caption>
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
            $tb .= "<tr>
            <td>$foto->codice</td>
            <td>$foto->descrizione</td>
            <td><a href=\"uploads/$foto->nome\">$foto->nome</a></td>
            <td>".'<input type="checkbox" name="codImg[]" value= "' . $foto->codice . '" /></td>
            </tr>';
        }


        $tf       = "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo "<input type='submit' name='submit' value='Procedi' />";
        echo "<input type='reset' value='Cancella' />";
        echo"</fieldset>";
        echo "</form>";
    }

    unset($result);
    content_end();
    page_end();
}
?>