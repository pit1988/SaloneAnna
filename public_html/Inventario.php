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

    $title = "Inventario Prodotti: Salone Anna";
    $title_meta = "Inventario Prodotti: Salone Anna";
    $descr = "";
    $keywords = "Inventario, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Inventario</strong>';
    insert_header($rif, 4, true);
    content_begin();

    if (isset($_POST['submit']) && isset($_POST['codprod'])) {
        $ids = $_POST['codprod'];
        $qt_new=$_POST['qtprod'];
        $qt_old=$_POST['qtprod_old'];
        $n_el=0;
        $n_err=0;
        for ($i=0; $i<count($ids); $i++) { 
            if ($qt_new[$i] != $qt_old[$i]){
                $ris=cambiaQuantitaProdotto($ids[$i], $qt_new[$i]);
                if($ris) ++$n_el;
                else ++$n_err;
            }

        }

        if($n_el>0)
            if($n_el==1)
                echo "<p class=\"inforesult\">È stato modificato $n_el prodotto</p>";
            else
                echo "<p class=\"inforesult\">Sono stati modificati $n_el prodotti</p>";
        if($n_err>0) echo "<p class=\"errorSuggestion\">Durante le modifiche si sono verificati $n_err errori</p>";
    }


    echo "<h2>Modifica Prodotti</h2>";
    
    $result = listaProdotti();
    
    $num_rows = count($result);

    if (!$num_rows)
        echo "<p>Non ci sono entry nella tabella Prodotti</p>";
    else {
        form_start("post", "Inventario.php");
        $th = '<table id="ProdottiMagazzino" summary="Prodotti in magazzino">
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
                    <td>".$prodotto->tipo."</a></td>
                    <td><input type=\"text\" name=\"qtprod[]\" value=\"$prodotto->quantita\" /></td>
                    <td>".$prodotto->prezzo."</td>
                    <td>".$prodotto->prezzoRiv."</td>
                    <input type=\"hidden\" name=\"qtprod_old[]\" value=\"$prodotto->quantita\" />
                    <input type=\"hidden\" name=\"codprod[]\" value=\"$prodotto->codice\" />
                </tr>";

        $tf= "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo"<input type='submit' name='submit' value='Procedi'>";
        echo"<input type='reset' value='Cancella'>";
        // echo"</fieldset>";
        echo"</form>";
    }
    $result->free();
    content_end();
    page_end();
}
?>
