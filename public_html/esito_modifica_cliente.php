
<?php

session_start();
session_regenerate_id(TRUE);
require 'library.php';
require 'utils/DBlibrary.php';

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    $title      = "Modifica cliente: Salone Anna";
    $title_meta = "Modifica cliente: Salone Anna";
    $descr      = "";
    $keywords   = "Modifica, Clienti, Nuovo, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Modifica Cliente</strong>';
    insert_header($rif, 5, true);
    content_begin();
        if (!isset($_POST['submit']) OR !isset($_POST['codCliente'])) {
        $err = "<p>Problemi di connessione</p>";
    } else {
        $conn = dbconnect();
        
        $cod   = $_POST["codCliente"];
        $query = "SELECT * FROM Prodotti p WHERE p.CodProdotto= '$cod'";
        
        $result   = mysqli_query($conn, $query);
        // nessun risultato
        $num_rows = mysqli_num_rows($result);
        if (!$num_rows)
            $err= "<p>Non è presente il cliente richiesto</p>";
        else {
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $email = $_POST['email'];
            $telefono = $_POST['phone'];
            $date=$_POST['data'];
            $codice   = $_POST['codCliente'];
            if(strlen($nome)==0 OR strlen($cognome)==0) // OR strlen($email)==0 OR strlen($telefono)==0 OR strlen($date)==0)
                $err= "<p>Almeno uno dei parametri non è stato inserito correttamente</p>";
            else{
                $dataNascita=(strlen($date)==0? "" :date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d'));
                $ris = aggiornaCliente($codice, $nome, $cognome, $telefono, $email, $dataNascita);
                if ($ris)
                    $msg = "<p>Modifica avvenuta correttamente</p>";
                else
                    $msg = "<p>Non è stato possibile modificare il cliente selezionato</p>";
            }
        }
    }
    if (isset($msg))
        echo ($msg);
    if (isset($err))
        echo ($err);
    hyperlink("Modifica altri clienti", "ScegliCliente.php");
    hyperlink("Torna alla home", "index.php");
    content_end();
    page_end();
}
?>