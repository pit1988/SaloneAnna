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
    $conn        = dbconnect();
    $query       = "
SELECT p.Parziali AS Quantità, CONCAT((TRUNCATE((p.Parziali/COUNT(*))*100, 2)), ' %')  AS Percentuale, NomeTipo AS 'Tipo Appuntamento' FROM Contatori p JOIN Appuntamenti a JOIN TipoAppuntamento ta on a.CodAppuntamento=ta.CodTipoAppuntamento GROUP BY a.CodTipoAppuntamento";
    $result      = mysqli_query($conn, $query);
    $number_cols = mysqli_num_fields($result);
    // echo "<b>Classifica appuntamenti per tipo:</b>";
    $str_toprint = '<table id="topProd" summary="Classifica degli appuntamenti, divisi per tipo">
<caption>Classifica degli appuntamenti, divisi per tipo</caption>
<thead>
<tr>
';
    for ($i = 0; $i < $number_cols; $i++) {
        $str_toprint .= '<th scope="col">' . (mysqli_fetch_field_direct($result, $i)->name) . "</th>\n";
    }
    $str_toprint .= "</tr></thead><tbody>\n";
    while ($row = mysqli_fetch_row($result)) {
        $str_toprint .= "<tr>\n";
        for ($i = 0; $i < $number_cols; $i++) {
            $str_toprint .= "<td>";
            if (!isset($row[$i])) {
                $str_toprint .= "NULL";
            } else {
                $str_toprint .= $row[$i];
            }
            $str_toprint .= "</td>\n";
        }
        $str_toprint .= "</td>\n";
    }
    $str_toprint .= "</tbody></table>";
    echo $str_toprint;
    content_end();
    page_end();
}
?>