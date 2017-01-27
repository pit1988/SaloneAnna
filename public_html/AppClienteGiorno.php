<?php
session_start();
session_regenerate_id(TRUE);
// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require_once 'library.php';
    require_once 'utils/DBlibrary.php';
    if (!isset($_POST['submit']) OR (!isset($_POST['cli']) AND !isset($_POST['data']))) {
        $err = "<p>Problemi di connessione, potresti non aver selezionato alcuna casella di ricerca. Segui il link per tornare alla <a href=\"RicercaAppuntamenti.php\">pagina di ricerca</a></p>";
    } else {
        $s_client = isset($_POST["cli"]) ? true : false;
        $s_data   = isset($_POST["data"]) ? true : false;
        
        if (($s_client == true && (!isset($_POST['first_name']) OR !isset($_POST['last_name']))) OR ($s_data == true && (!isset($_POST['data'])))) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
            $err = "Almeno uno dei parametri non è stato inserito correttamente";
        } else {
            $sub = $_POST['submit'];
            
            $query = "SELECT c.Nome, c.Cognome, a.DataOra	FROM Clienti c JOIN Appuntamenti a";
            
            if ($s_client == true) {
                $nome    = $_POST['first_name'];
                $cognome = $_POST['last_name'];
                
                $query .= "  WHERE c.Nome='$nome' AND c.Cognome='$cognome'";
            }
            
            if ($s_data == true) {
                if ($s_client == true)
                    $query .= " AND ";
                else
                    $query .= " WHERE ";
                $date = $_POST['date'];
                $where .= "DATE(a.DataOra)=\"'$app'\"";
                if (isset($_POST['orario'])) {
                    $hh = substr($_POST['orario'], 0, 2);
                    $where .= " AND HOUR(a.DataOra)>=\"'$hh.'\"";
                }
            }
            
            $conn  = dbConnect();
            $query = $query;
            
            $result = $conn->query($query);
            
            $num_rows = mysqli_num_rows($result);
            $ris      = "";
            if (!$num_rows)
                $ris = "<p>La ricerca non ha prodotto risultati</p>";
            else {
                
                $number_cols = mysqli_num_fields($result);
                
                $ris .= "<p><strong>Storico:</strong></p>";
                $ris .= '<table id="ProdottiMagazzino" summary="Prodotti in magazzino">
            <caption>Prodotti modificabili</caption>
            <thead>
                <tr>' . "\n";
                for ($i = 0; $i < $number_cols; $i++) {
                    // echo "<th>" . mysql_field_name ($result, $i). "</th>\n";
                    $ris .= "<th>" . (mysqli_fetch_field_direct($result, $i)->name) . "</th>\n";
                }
                $ris .= "</tr>\n</thead>\n<tbody>\n";
                
                while ($row = mysqli_fetch_row($result)) {
                    $ris .= "<tr>\n";
                    
                    for ($i = 0; $i < $number_cols; $i++) {
                        $ris .= "<td>";
                        if (!isset($row[$i])) {
                            $ris .= "NULL";
                        } else {
                            $ris .= $row[$i];
                        }
                        $ris .= "</td>\n";
                    }
                    $ris .= "</td>\n";
                }
                
                $ris .= "</tbody></table>";
            }
            mysqli_close($conn);
        }
    }
    $title      = "Ricerca Appuntamento: Salone Anna";
    $title_meta = "Ricerca Appuntamento: Salone Anna";
    $descr      = "";
    $keywords   = "Appuntamento, Ricerca, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="RicercaAppuntamenti.php">Ricerca Appuntamento</a> / <strong>Risultati</strong>';
    insert_header($rif, 4, true);
    content_begin();
    if (isset($err))
        echo $err;
    if (isset($ris))
        echo $ris;
    echo "<p>Segui il link per tornare alla <a href=\"RicercaAppuntamenti.php\">pagina di ricerca</a></p>";
    content_end();
    page_end();
}
?>