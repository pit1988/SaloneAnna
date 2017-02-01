<?php
session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    $title = "Prodotti Max: Salone Anna";
    $title_meta = "Prodotti Max: Salone Anna";
    $descr = "";
    $keywords = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Prodotti Max</strong>';
    insert_header($rif, 4, true);
    content_begin();
    
    include("utils/DBlibrary.php");

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
