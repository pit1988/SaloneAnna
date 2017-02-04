<?php
require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    $title      = "Conferma Modifica Cliente | Salone Anna";
    $title_meta = "Conferma Modifica Cliente | Salone Anna";
    $descr      = "Modifica i clienti e verrà segnalato il successo o il fallimento in questa pagina";
    $keywords   = "Modifica, Clienti, Nuovo, Nome, Cognome, Telefono, Mail, Data, Conferma";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Modifica Cliente</strong>';
    insert_header($rif, 5, true);
    content_begin();
        if (!isset($_POST['submit']) OR !isset($_POST['codCliente'])) {
        $err = "<p class=\"errorSuggestion\">Problemi di connessione</p>";
    } else {
        $cod = $_POST["codCliente"];
        
        $result   = mostraCliente($cod);
        // nessun risultato
        $num_rows = count($result);
        if($num_rows==0)
            $err= "<p class=\"inforesult\">Non è presente il cliente richiesto</p>";
        else {
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $email = $_POST['email'];
            $telefono = $_POST['phone'];
            $date=$_POST['data'];
            $codice   = $_POST['codCliente'];
            if(strlen($nome)==0 OR strlen($cognome)==0) // OR strlen($email)==0 OR strlen($telefono)==0 OR strlen($date)==0)
                $err= "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
            else{
                $ris = aggiornaCliente($codice, $nome, $cognome, $telefono, $email, $date);
                if ($ris)
                    $msg = "<p class=\"inforesult\">Modifica avvenuta correttamente</p>";
                else
                    $msg = "<p class=\"errorSuggestion\">Non è stato possibile modificare il cliente selezionato</p>";

            }
        }
        unset($result);
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