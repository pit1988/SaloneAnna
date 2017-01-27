
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    require 'utils/DBlibrary.php';
    
    $title      = "Modifica appuntamento: Salone Anna";
    $title_meta = "Modifica appuntamento: Salone Anna";
    $descr      = "";
    $keywords   = "Modifica, Appuntamento, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="ScegliAppuntamento.php">Modifica Appuntamento</a> / <strong>Inserisci valori</strong>';
    insert_header($rif, 4, true);
    content_begin();
    
    if (!isset($_POST['submit']) OR !isset($_POST['codapp'])) {
        echo "<p>Problemi di connessione; <a href=\"ScegliAppuntamento.php\">segui il link per selezionare un altro appuntamento da modificare</a></p>";
    } else {
        
        $conn = dbconnect();
        $cod = $_POST["codapp"];
        $query = "SELECT CodAppuntamento, Nome, Cognome, DataOra, CodTipoAppuntamento FROM Appuntamenti a JOIN Clienti c WHERE a.CodAppuntamento= '$cod'";
        
        $result   = mysqli_query($conn, $query);
        // nessun risultato
        $num_rows = mysqli_num_rows($result);
        if (!$num_rows)
            echo "<p>L'appuntamento richiesto non è prensente nel database</p>";
        else {
            
            //aggiungere tabindex;
            $str1 = '<form action="ConfermaModificaAppuntamento.php" onsubmit="return true;" method="post">
                <ul>
                    <li>
                        <p> 
                            <label for="TipoAppuntamento">Tipo appuntamento:</label>
';
            
            $str2 = "";
            $qry = "SELECT CodTipoAppuntamento, NomeTipo FROM TipoAppuntamento";
            $conn = dbconnect();
            $ris = mysqli_query($conn, $qry);
            $number_rows = mysqli_num_rows($ris);
            
            if ($number_rows > 1) {
                while ($entry = mysqli_fetch_row($ris)) {
                    if ($entry[0] == $cod)
                        $str2 .= '<input type="radio" name="TipoAppuntamento" value="' . $entry[0] . '" checked="checked" />' . $entry[1] . "\n";
                    else
                        $str2 .= '<input type="radio" name="TipoAppuntamento" value="' . $entry[0] . '" />' . $entry[1] . "\n";
                }
            }
            
            $row = mysqli_fetch_row($result);
            
            $str3 = '</p>
                    </li>
                    <li>
                        <p>
                            <label for="first_name">Nome</label>
                            <input type="text" name="first_name" id="first_name" tabindex="100" value="' . $row[1] . '"/>
                        </p>
                        <p>
                            <label for="last_name">Cognome</label>
                            <input type="text" name="last_name" id="last_name" tabindex="101" value="' . $row[2] . '"/>
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="data">Data</label>
                        <input type="text" name="data" id="data" tabindex="104" value="' . date("d/m/Y", strtotime($row[3])) . '"/>
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="orario">Orario</label>
                            <input type="text" name="orario" id="orario" tabindex="102" value="' . date("H:i", strtotime($row[3])) . '"/>
                        </p>
                    </li>
                    <li>
                        <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                        <input type="reset" value="cancella" />
                        <span id="errors"></span>
                    </li>
                </ul>
                <input type="hidden" name="CodAppuntamento" value="'.$row[0].'">
            </form>
';
            echo $str1 . $str2 . $str3;
        }
    }
    content_end();
    page_end();
}
?>