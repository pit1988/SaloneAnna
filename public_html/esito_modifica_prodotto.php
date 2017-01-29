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
    
    $title      = "Gestione Prodotti: Salone Anna";
    $title_meta = "Gestione Prodotti: Salone Anna";
    $descr      = "";
    $keywords   = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <a href="GestioneProdotti.php"> Gestione Prodotti</a> / <strong>Modifica Prodotto</strong>';
    insert_header($rif, 4, true);
    content_begin();
    
    if (!isset($_POST['submit']) OR !isset($_POST['codprod'])) {
        $err = "<p>Problemi di connessione</p>";
    } else {
        $conn = dbconnect();
        
        $cod   = $_POST["codprod"];
        $query = "SELECT * FROM Prodotti p WHERE p.CodProdotto= '$cod'";
        
        $result   = mysqli_query($conn, $query);
        // nessun risultato
        $num_rows = mysqli_num_rows($result);
        if (!$num_rows)
            echo "<p>Non è presente il prodotto richiesto</p>";
        else {
            $nome      = $_POST['nome'];
            $marca     = $_POST['marca'];
            $tipo      = $_POST['tipo'];
            $quantita  = $_POST['quantita'];
            $pvendita  = $_POST['pvendita'];
            $rivendita = $_POST['rivendita'];
            $codprod   = $_POST['codprod'];
            $ris       = modificaProdotto($codprod, $nome, $marca, $tipo, $quanita, $pvendita, $rivendita);
            if ($ris)
                $msg = "<p>Modifica avvenuta correttamente</p>";
            else
                $msg = "<p>Non è stato possibile modificare il prodotto selezionato</p>";
            echo $msg;
        }
    }
    if (isset($msg))
        echo ($msg);
    if (isset($err))
        echo ($err);
    hyperlink("Modifica altri prodotti", "ScegliProdotto.php");
    hyperlink("Torna alla home", "index.php");
    content_end();
    page_end();
}
?>