<?php
session_start();
session_regenerate_id(TRUE);
// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    require 'utils/DBlibrary.php';
    $title      = "Appuntamento Frequente: Salone Anna";
    $title_meta = "Appuntamento Frequente: Salone Anna";
    $descr      = "";
    $keywords   = "Appuntamento, Frequente, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Tipo Appuntamento Frequente</strong>';
    insert_header($rif, 6, true);
    content_begin();
    echo "<h2>Classifica Appuntamenti</h2>";
    
    $result = listaAppuntamentiPerTipo();
    if(mysqli_num_rows($result) == 0){
        $str_to_print = "<p class=\"inforesult\">Non sono presenti appuntamenti nel database</p>";
    }
    else{
        $th = '<table id="topProd" summary="Classifica degli appuntamenti, divisi per tipo">
        <caption class="inforesult">Classifica degli appuntamenti, divisi per tipo</caption>
        <thead>
            <tr>
                <th scope="col">Quantità</th>
                <th scope="col">Percentuale</th>
                <th scope="col">Tipo Appuntamento</th>
            </tr>
        </thead>
        <tbody>
        ';
        $tb          = "";
        while ($row = mysqli_fetch_row($result)) {
            $tb .= "
                <tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                    <td>" . $row[2] . "</td>
                </tr>";
        }
        
        
        $tf = "</tbody></table>";
        $str_to_print = $th . $tb . $tf;
    }
    echo $str_to_print;
    content_end();
    page_end();
}
?>