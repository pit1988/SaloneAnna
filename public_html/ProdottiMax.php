<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    $title = "Classica Proddotti Maggiormente Usati | Salone Anna";
    $title_meta = "Classica Proddotti Maggiormente Usati | Salone Anna";
    $descr = "Classifica dei prodotti maggiormente usati per facilità di visualizzazione";
    $keywords = "Classica, Prodotti, Maggiormente, Uso, CodProdotto, Nome, Tipo, Marca, Utilizzo";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Prodotti Max</strong>';
    insert_header($rif, 4, true);
    content_begin();
    
    $result = listaProdottiAppuntamentoMax();
    
    echo "<h2>Prodotti pi&ugrave; usati</h2>";
    echo "<em class=\"info\">I prodotti pi&ugrave; usati in appuntamento sono:</em>";
    
    $num_rows = count($result);
    if (!$num_rows)
        echo "<p class=\"inforesult\">Non ci sono entry nella tabella Appuntamenti o nella tabella dei Prodotti</p>";
    else {
        $th = '<table id="ProdottiMagazzino" summary="Prodotti più usati">
            <caption>Prodotti più usati negli appuntamenti</caption>
            <thead>
                <tr>
                    <th scope="col">CodProdotto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Utilizzo</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th scope="col">CodProdotto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Utilizzo</th>
                </tr>
            </tfoot>

            <tbody>
            ';
        $tb = "";
        //corpo tabella
        foreach ($result as $prodottoApp) {
            $tb.="
                <tr>
                    <td>$prodottoApp->codProdotto</td>
                    <td>$prodottoApp->nome</td>
                    <td>$prodottoApp->marca</td>
                    <td>$prodottoApp->tipo</td>
                    <td>$prodottoApp->utilizzo</td>
                </tr>
            ";
        }
        
        $tf = "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
    }
    unset($result);
    content_end();
    page_end();
}
?>
