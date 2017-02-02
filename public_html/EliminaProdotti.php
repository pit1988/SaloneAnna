<?php
$login=authenticate();

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';    
    include("utils/DBlibrary.php");

    $conn = dbconnect();

    $title      = "Elimina Prodotti: Salone Anna";
    $title_meta = "Elimina Prodotti: Salone Anna";
    $descr      = "";
    $keywords   = "Elimina, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Elimina Prodotti</strong>';
    insert_header($rif, 4, true);
    content_begin();
    echo "<h2>Elimina Prodotti</h2>";
    
    if (isset($_POST['submit']) && isset($_POST['codprod'])) {
        $ids = $_POST['codprod'];
        $n_el=0;
        $n_err=0;
        foreach ($ids as $d) {
            $ris=eliminaProdotto($d);
            if($ris) ++$n_el;
            else ++$n_err;
            unset($ris);
        }

        if($n_el>0)
            if($n_el==1)
                echo "<p class=\"inforesult\">È stato cancellato $n_el prodotto</p>";
            else
                echo "<p class=\"inforesult\">Sono stati cancellati $n_el prodotti</p>";
        if($n_err>0) echo "<p class=\"errorSuggestion\">Durante la cancellazione si sono verificati $n_err errori</p>";
    }

    $result = listaProdotti();
    
    
    if(count($result)==0)
        echo "<p class=\"errorSuggestion\">Non ci sono entry nella tabella Prodotti</p>";
    else {
        echo "<form method=\"post\" action=\"EliminaProdotti.php\">
        <fieldset><legend>Seleziona il prodotto da eliminare</legend>";
        $th = '<table id="ProdottiMagazzino" summary="Elimina Prodotti dal magazzino">
            <caption class="nascosto">Elimina Prodotti dal magazzino</caption>
            <thead>
                <tr>
                    <th scope="col">CodProdotto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantità</th>
                    <th scope="col">PVendita</th>
                    <th scope="col">PRivendita</th>
                    <th scope="col">Seleziona</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th scope="col">CodProdotto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantità</th>
                    <th scope="col">PVendita</th>
                    <th scope="col">PRivendita</th>
                    <th scope="col">Seleziona</th>
                </tr>
            </tfoot>

            <tbody>
            ';
        $tb = "";
        //corpo tabella
        foreach ($result as $prodotto)
            $tb.="
                <tr>
                    <td>".$prodotto->codice."</td>
                    <td>".$prodotto->nome."</td>
                    <td>".$prodotto->marca."</td>
                    <td>".$prodotto->tipo."</td>
                    <td>".$prodotto->quantita."</td>
                    <td>".$prodotto->prezzo."</td>
                    <td>".$prodotto->prezzoRiv."</td>
                    <td><input type=\"checkbox\" name=\"codprod[]\" value= \"" . $prodotto->codice . "\"/></td>
                </tr>
            ";
        
        $tf       = "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo "<input type='submit' name='submit' value='Procedi'/>";
        echo "<input type='reset' value='Cancella'/>";
        echo "</fieldset></form>";
    }
    unset($result);
    content_end();
    page_end();
    mysqli_close($conn);
}
?>
