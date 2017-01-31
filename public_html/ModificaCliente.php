
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
        $err = "Errore di connessione";
    } else {
        
        $conn = dbconnect();
        
        $cod   = $_POST["codCliente"];
        $query = "SELECT Nome, Cognome, Email, Telefono, DataNascita FROM Clienti p WHERE p.CodCliente= '$cod'";

        $result   = mysqli_query($conn, $query);
 
        if (!$result)
            $err = "<p>Non è presente il cliente selezionato</p>";
        else {
            $row = mysqli_fetch_row($result);
            
            echo '<h2>Modifica Cliente</h2>
            <form action="ConfermaModificaCliente.php" onsubmit="return true;" method="post">
                <ul>
                    <li>
                        <p>
                            <label for="first_name">Nome</label>
                            <input type="text" name="first_name" id="first_name" tabindex="100" value="' . $row[0] . '" />
                        </p>
                        <p>
                            <label for="last_name">Cognome</label>
                            <input type="text" name="last_name" id="last_name" tabindex="101" value="' . $row[1] . '" />
                        </p>
                    </li>
                    <li xml:lang="en">
                        <p>
                            <label for="email">E-Mail</label>
                            <input type="text" name="email" id="email" tabindex="102" value="' . $row[2] . '" />
                        </p>
                    </li>
                    <li>
                        <label for="phone">Telefono</label>
                         <input type="text" name="phone" id="phone" tabindex="103" value="' . $row[3] . '" />
                    </li>
                    <li>
                        <label for="data">Data di nascita</label>
                        <input type="text" name="data" id="data" tabindex="104" value="' . ((empty($row[4])) ?: date("d/m/Y", strtotime($row[4]))) . '" />
                    <li xml:lang="en">
                        <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                        <input type="reset" value="cancella" />
                        <input type="hidden" name="codCliente" value="' . $cod . '" />
                        <span id="errors"></span>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                </ul>
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
            