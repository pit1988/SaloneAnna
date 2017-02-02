<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    $title = "Gestione Prodotti: Salone Anna";
    $title_meta = "Gestione Prodotti: Salone Anna";
    $descr = "";
    $keywords = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Gestione Prodotti</strong>';
    insert_header($rif, 4, true);
    content_begin();
    echo "<h2>Modifica Prodotti</h2>";
    
    $result = listaProdotti();
    
    $num_rows = count($result);

    if (!$num_rows)
        echo "<p>Non ci sono entry nella tabella Prodotti</p>";
    else {
        form_start("post", "ModificaProdotto.php");
        $th = '
        <fieldset>
        <table id="ProdottiMagazzino" summary="Prodotti in magazzino">
            <caption class="nascosto">Prodotti modificabili</caption>
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
                    <td>".$prodotto->tipo."</a></td>
                    <td>".$prodotto->quantita."</td>
                    <td>".$prodotto->prezzo."</td><td>".$prodotto->prezzoRiv."</td>
                    <td><input type=\"radio\" name=\"codprod\" value= \"" . $prodotto->codice . "\"\/></td>
                </tr>";

        $tf= "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo"<input type='submit' name='submit' value='Procedi'>";
        echo"<input type='reset' value='Cancella'>";
        echo"</fieldset>";
        echo"</form>";
    }
    unset($result);
    content_end();
    page_end();
}
?>
