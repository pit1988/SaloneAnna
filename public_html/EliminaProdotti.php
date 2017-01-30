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
            $query_el = "delete from Prodotti where CodProdotto='$d'";
            $ris=mysqli_query($conn, $query_el);
            if($ris) ++$n_el;
            else ++$n_err;
        }

        if($n_el>0)
            if($n_el==1)
                echo "<p>È stato cancellato $n_el prodotto</p>";
            else
                echo "<p>Sono stati cancellati $n_el prodotti</p>";
        if($n_err>0) echo "<p>Durante la cancellazione si sono verificati $n_err errori</p>";
    }
    

    
    $query  = "SELECT * FROM Prodotti p WHERE p.Quantita is not NULL AND p.Quantita>0 ";
    $result = mysqli_query($conn, $query);
    
    $number_cols = mysqli_num_fields($result);
    
    $num_rows = mysqli_num_rows($result);
    if (!$num_rows)
        echo "<p>Non ci sono entry nella tabella Prodotti</p>";
    else {
        form_start("POST", "EliminaProdotti.php");
        echo "<fieldset><legend>Seleziona il prodotto da eliminare</legend>"
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
        while ($row = mysqli_fetch_row($result)) {
            
            $tb .= "<tr>\n";
            for ($i = 0; $i < $number_cols + 1; $i++) {
                $tb .= "<td>";
                if (!isset($row[$i]))
                    $tb .= " ";
                if ($i == $number_cols)
                    $tb .= "<input type=\"checkbox\" name=\"codprod[]\" value= \"" . $row[0] . "\"\/>";
                else {
                    $tb .= $row[$i];
                }
                
                $tb .= "</td>\n";
            }
            $tb .= "</tr>\n";
        }
        
        $tf       = "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo "<input type='submit' name='submit' value='Procedi'>";
        echo "<input type='reset' value='Cancella'>";
        echo "</fieldset></form>";
    }
    content_end();
    page_end();
    mysqli_close($conn);
}
?>
