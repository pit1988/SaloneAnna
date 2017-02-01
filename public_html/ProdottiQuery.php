<?php
session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    include("utils/DBlibrary.php");
    $title = "Prodotti in esaurimento: Salone Anna";
    $title_meta = "Prodotti in esaurimento: Salone Anna";
    $descr = "";
    $keywords = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Prodotti in esaurimento</strong>';
    insert_header($rif, 4, true);
    content_begin();
    
    $result = prodottiInEsaurimento();
    
    $num_rows = count($result);

    echo "<h2>Prodotti in esaurimento</h2>";
    echo "<em class=\"info\">I prodotti in esaurimento sono:</em>";
    
    if ($num_rows==0)
        echo "<p class=\"inforesult\">Non ci sono prodotti da mostrare</p>";
    else {
        $th = '<table id="ProdottiMagazzino" summary="Prodotti in esaurimento">
            <caption>Prodotti presenti in numero inferiore a 6</caption>
            <thead>
                <tr>
                    <th scope="col">CodProdotto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantità</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th scope="col">CodProdotto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantità</th>
                </tr>
            </tfoot>

            <tbody>
            ';
        $tb = "";
        //corpo tabella
        foreach ($result as $prodotto)
            $tb.="<tr>
                <td>".$prodotto->codice."</td>
                <td>".$prodotto->nome."</td>
                <td>".$prodotto->marca."</td>
                <td>".$prodotto->tipo."</td>
                <td>".$prodotto->quantita."</td>
            </tr>";
        
        $tf = "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
    }
    unset($result);
    content_end();
    page_end();
}
?>
