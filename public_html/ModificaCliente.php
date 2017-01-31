
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
        $err = "<p class=\"errorSuggestion\">Errore di connessione</p>";
    } else {
        
        $conn = dbconnect();
        
        $cod   = $_POST["codCliente"];
        
        $result   = mostraCliente($cod);
 
        if (is_null($result))
            $err = "<p class=\"info\">Non è presente il cliente selezionato</p>";
        else {
            
            echo '<h2>Modifica Cliente</h2>
            <form action="ConfermaModificaCliente.php" onsubmit="return true;" method="post">
            <fieldset><legend>Modifica le informazioni per cambiare le informazioni del cliente</legend>
                <ul>
                    <li>
                        <p>
                            <label for="first_name">Nome</label>
                            <input type="text" name="first_name" id="first_name" tabindex="100" value="' . $result->nome . '" />
                        </p>
                        <p>
                            <label for="last_name">Cognome</label>
                            <input type="text" name="last_name" id="last_name" tabindex="101" value="' . $result->cognome . '" />
                        </p>
                    </li>
                    <li xml:lang="en">
                        <p>
                            <label for="email">E-Mail</label>
                            <input type="text" name="email" id="email" tabindex="102" value="' . $result->email . '" />
                        </p>
                    </li>
                    <li>
                        <label for="phone">Telefono</label>
                         <input type="text" name="phone" id="phone" tabindex="103" value="' . $result->telefono . '" />
                    </li>
                    <li>
                        <label for="data">Data di nascita</label>
                        <input type="text" name="data" id="data" tabindex="104" value="' . $result->dataNascita . '" />
                    <li xml:lang="en">
                        <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                        <input type="reset" value="cancella" />
                        <input type="hidden" name="codCliente" value="' . $result->codice . '" />
                        <span id="errors"></span>
                    </li>
                    <li>
                        <p class="divider"></p>
                    </li>
                </ul>
            </fieldset>
            </form>
';
        }
    }
    if (isset($err))
        echo $err;
    content_end();
    page_end();
}
?>
