<?php
$login=authenticate();
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
    if(empty($result)){
        $str_to_print = "<p class=\"inforesult\">Non sono presenti appuntamenti nel database</p>";
    }
    else{
        $th = '<table id="topApp" summary="Classifica degli appuntamenti, divisi per tipo">
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
        foreach ($result as $row) {
            $tb .= "
                <tr>
                    <td>" . $row->quantita . "</td>
                    <td>" . $row->percentuale . "</td>
                    <td>" . $row->nomeTipo . "</td>
                </tr>";
        }
        
        
        $tf = "</tbody></table>";
        $str_to_print = $th . $tb . $tf;
    }
    unset($result);
    echo $str_to_print;
    content_end();
    page_end();
}
?>