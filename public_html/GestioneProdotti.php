<?php
session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    $title = "Gestione Prodotti: Salone Anna";
    $title_meta = "Gestione Prodotti: Salone Anna";
    $descr = "";
    $keywords = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Gestione Prodotti</strong>';
    insert_header($rif, 3, true);
    content_begin();

    include("DBlibrary.php");
    $conn = dbconnect();
    
    $query = "SELECT * FROM Prodotti p WHERE p.Quantita is not NULL AND p.Quantita>0 ";
    $result = mysqli_query($conn, $query);
    
    $number_cols = mysqli_num_fields($result);
    
    $num_rows = mysqli_num_rows($result);
    if (!$num_rows)
        echo "<p>Non ci sono entry nella tabella Prodotti</p>";
    else {
        form_start("POST", "ModificaProdotto.php");
        //echo "<form action=\"ModificaProdotto.php\">";
        $th = '<table id="ProdottiMagazzino" summary="Prodotti in magazzino">
            <caption>Prodotti modificabili</caption>
            <thead>
                <tr>
                    <th scope="col">Modifica</th>
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
                    <th scope="col">Modifica</th>
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
        while ($row = mysqli_fetch_row($result)) {
            
            $tb .= "<tr>\n";
            for ($i = 0; $i < $number_cols + 1; $i++) {
                $tb .= "<td>";
                if (!isset($row[$i]))
                    $tb .= " ";
                if ($i == 0)
                    $tb .= "<input type=\"radio\" name=\"codprod\" value= \"" . $row[$i] . "\"\/>";
                else {
                    $tb .= $row[$i - 1];
                }
                
                $tb .= "</td>\n";
            }
            $tb .= "</tr>\n";
        }
        
        $tf= "</tbody></table>";
        $to_print = $th . $tb . $tf;
        echo $to_print;
        echo"<input type='submit' name='submit' value='Procedi'>";
        echo"<input type='reset' value='Cancella'>";
        // echo"</fieldset>";
        echo"</form>";
    }
    content_end();
    page_end();
}
mysqli_close($conn);
?>
