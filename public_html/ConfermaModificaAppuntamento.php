
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    if (!isset($_POST['submit'])) {
        header('loation:ScegliAppuntamento.php');
    } else {
        require 'library.php';
        include 'utils/DBlibrary.php';
        
        $title      = "Modifica appuntamento: Salone Anna";
        $title_meta = "Modifica appuntamento: Salone Anna";
        $descr      = "";
        $keywords   = "Modifica, Appuntamento, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
        
        page_start($title, $title_meta, $descr, $keywords, '');
        $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="ScegliAppuntamento.php">Modifica Appuntamento</a> / <strong>Inserisci valori</strong>';
        insert_header($rif, 6, true);
        content_begin();
        
        if (isset($_POST['submit']) && isset($_POST['TipoAppuntamento']) && isset($_POST['CodCliente']) && isset($_POST['data']) && isset($_POST['TipoAppuntamento'])) {
            $sub        = $_POST['submit'];
            $tipo       = $_POST['TipoAppuntamento'];
            $data       = $_POST['data'];
            $ora        = $_POST['orario'];
            $cod        = $_POST['CodAppuntamento'];
            $CodCliente = $_POST['CodCliente'];
            
            $ok = aggiornaAppuntamento($cod, $CodCliente, $data, $ora, $tipo);
        }
        
        if (!isset($_POST['TipoAppuntamento']) OR !isset($_POST['first_name']) OR !isset($_POST['last_name']) OR !isset($_POST['data']) OR !isset($_POST['orario'])) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
            $err = "Almeno uno dei parametri non è stato inserito correttamente";
        } else {
            $sub     = $_POST['submit'];
            $tipo    = $_POST['TipoAppuntamento'];
            $nome    = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $data    = $_POST['data'];
            $ora     = $_POST['orario'];
            $cod     = $_POST['CodAppuntamento'];
            
            if (strlen($tipo) == 0 OR strlen($nome) == 0 OR strlen($cognome) == 0 OR strlen($data) == 0 OR strlen($ora) == 0 OR strlen($cod) == 0) //OR strlen($costo) == 0 OR strlen($sconto) == 0)
                $err = "Almeno uno dei parametri non è stato inserito correttamente";
            else {
                
                $result = checkCliente($nome, $cognome);
                if (is_null($result) OR count($result) == 0) {
                    echo "<p>Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                    hyperlink("Inserisci un nuovo cliente", "NuovoCliente.php");
                }
                
                else { //uno o più
                    $number_rows = count($result);
                    if ($number_rows > 1) {
                        echo "<p>Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                        form_start("POST", "ConfermaModificaAppuntamento.php");
                        $th = '<table id="ProdottiMagazzino" summary="Prodotti in magazzino">
                    <caption>Prodotti modificabili</caption>
                    <thead>
                        <tr>
                            <th scope="col">Codice Cliente</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Email</th>
                            <th scope="col">Data di nascita</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
                        $tb = "";
                        //corpo tabella
                        foreach ($result as $cliente) {
                            $tb .= "<tr>
                            <td>" . $cliente->codice . "</td><td>" . $cliente->nome . "</td><td>" . $cliente->cognome . "</td><td>" . $cliente->telefono . "</a></td><td>" . $cliente->email . "</td><td>" . $cliente->dataNascita . "</td><td><input type='radio' name='CodCliente' value=$cliente->codice></td>
                            </tr>";
                        }
                        
                        $tf       = "</tbody></table>";
                        $to_print = $th . $tb . $tf;
                        echo $to_print;
                        echo "<input type='hidden' name='TipoAppuntamento' value='$tipo'>";
                        echo "<input type='hidden' name='data' value='$data'>";
                        echo "<input type='hidden' name='CodAppuntamento' value='$cod'>";
                        echo "<input type='hidden' name='orario' value='$ora'>";
                        echo "<input type='submit' name='submit' value='Procedi'>";
                        echo "<input type='reset' value='Cancella'>";
                        // echo"</fieldset>";
                        echo "</form>";
                    } else {
                        //una riga
                        $CodCliente = $result[0]->codice;
                        $ok = aggiornaAppuntamento($cod, $CodCliente, $data, $ora, $tipo);
                    }
                } //fine n_righe>1
            }
            
        }
        
        if (isset($ok))
            if ($ok)
                echo "<b>L'appuntamento di $nome è stato modificato correttamente ed è il $data alle $ora</b><br>";
            else
                echo "<p>Non è stato possibile modificare l'appuntamento selezionato</p>";
        echo 'Vuoi modificare altri appuntamenti? Torna a <a href="ScegliAppuntamento.php">Scegli Appuntamento</a>';
        content_end();
        page_end();
    }
}
?>