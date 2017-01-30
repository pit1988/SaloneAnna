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
    
    if (isset($_POST['submit'])) {
        $nome      = $_POST['nome'];
        $marca     = $_POST['marca'];
        $tipo      = $_POST['tipo'];
        $quantita  = $_POST['quantita'];
        $pvendita  = $_POST['pvendita'];
        $rivendita = $_POST['rivendita'];
        $codprod   = $_POST['codprod'];
        $ris       = inserisciProdotto($nome, $marca, $tipo, $quanita, $pvendita, $rivendita);
        if ($ris)
            $msg = "<p class=\"inforesut\">Modifica avvenuta correttamente</p>";
        else
            $msg = "<p class=\"inforesut\">Non è stato possibile modificare il prodotto selezionato</p>";
        echo $msg;
    }
    
    $title      = "Gestione Prodotti: Salone Anna";
    $title_meta = "Gestione Prodotti: Salone Anna";
    $descr      = "";
    $keywords   = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <a href="GestioneProdotti.php"> Gestione Prodotti</a> / <strong>Modifica Prodotto</strong>';
    insert_header($rif, 4, true);
    content_begin();
    echo "<h2>Inserisci nuovo prodotto</h2>";

    
    $to_print = '
    <form method="POST" action="esito_modifica.php">
    <fieldset>
    <legend>Completa le informazioni per inserire un nuovo prodotto</legend>
        <ul>
                <li>
                    <p>
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" tabindex="100" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" tabindex="101" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="tipo">Tipo</label>
                        <input type="text" name="tipo" id="tipo" tabindex="102" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="quantita">Quanità</label>
                        <input type="text" name="quantita" id="quantita" tabindex="103" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="pvendita">Prezzo alla vendita</label>
                        <input type="text" name="pvendita" id="pvendita" tabindex="104" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="privendita">Prezzo di rivendita</label>
                        <input type="text" name="privendita" id="privendita" tabindex="105" />
                    </p>
                </li>
            </ul>
            <input type="submit" name="submit" value="Procedi">
            <input type="reset" value="Cancella">
        </fieldset>
        </form>

        // hyperlink("Modifica altri prodotti", "GestioneProdotti.php");
        // hyperlink("Torna alla home", "index.php");
    ';
    if (isset($msg))
        echo ($msg);
    if (isset($err))
        echo ($err);
    
    echo $to_print;
    content_end();
    page_end();
}
?>