<?php
session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} elseif (!isset($_POST['submit']) OR !isset($_POST['codprod'])) {
    $err = "Problemi di connessione";
} else {
    require 'library.php';
    include("utils/DBlibrary.php");
    
    $title = "Gestione Prodotti: Salone Anna";
    $title_meta = "Gestione Prodotti: Salone Anna";
    $descr = "";
    $keywords = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <a href="GestioneProdotti.php"> Gestione Prodotti</a> / <strong>Modifica Prodotto</strong>';
    insert_header($rif, 3, true);
    content_begin();
    
    $conn = dbconnect();
    
    $cod = $_POST["codprod"];
    $query = "SELECT p.Nome, p.Marca, p.Tipo, p.Quantita, p.PVendita, p.PRivendita FROM Prodotti p WHERE p.CodProdotto= '$cod'";
    
    $result = mysqli_query($conn, $query);
    // nessun risultato
    $num_rows = mysqli_num_rows($result);
    if (!$num_rows)
        echo "<p>Non è presente il prodotto richiesto</p>";
    else {
        $row = mysqli_fetch_row($result);
        $to_print = '<form method="POST" action="esito_modifica.php">
    		<ul>
                    <li>
                        <p>
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" tabindex="100" value="' . $row[0] . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="marca">Marca</label>
                            <input type="text" name="marca" id="marca" tabindex="101" value="' . $row[1] . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="tipo">Tipo</label>
                            <input type="text" name="tipo" id="tipo" tabindex="102" value="' . $row[2] . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="quanita">Quanità</label>
                            <input type="text" name="quanita" id="quanita" tabindex="103" value="' . $row[3] . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="pvendita">Prezzo alla vendita</label>
                            <input type="text" name="pvendita" id="pvendita" tabindex="104" value="' . $row[4] . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="privendita">Prezzo di rivendita</label>
                            <input type="text" name="privendita" id="privendita" tabindex="105" value=' . $row[5] . ' />
                        </p>
                    </li>
                </ul>
                <input type="submit" name="submit" value="Procedi">
        		<input type="reset" value="Cancella">
            </form>
    	';
        echo $to_print;
    }
    content_end();
    page_end();
}
mysqli_close($conn);
?>