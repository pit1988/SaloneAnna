<?php
require_once 'library.php';
require_once 'utils/DBlibrary.php';
$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    $dati_ok=false;
    if(isset($_POST['CodCliente']) && isset($_POST['data'] && isset($_POST['ora']))){
        $date = $_POST['date'];
        $ora=$_POST['orario'];
        $codCliente=$_POST['CodCliente'];
        $dati_ok=true;
    }

    if (!isset($_POST['submit']) OR (!isset($_POST['cli']) AND !isset($_POST['data']))) {
        $err = "<p class=\"errorSuggestion\">Potresti non aver selezionato alcuna casella di ricerca.</p>";
    } 
    else {
        $codCliente=0;
        $data=""; 
        $ora="";
        $s_client = (isset($_POST['cli']) && ($_POST["cli"] == "cli")) ? true : false;
        $s_data   = (isset($_POST['data']) && ($_POST["date"] == "date")) ? true : false;
        
        if (($s_client == true && (empty($_POST['first_name']) OR (empty($_POST['last_name'])))) OR ($s_data == true && (empty($_POST['date'])))) {
            $err = "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
            
        } else {
            if (empty($_POST['date']))
                $sub = $_POST['submit'];
            
            $query = "SELECT c.Nome, c.Cognome, a.DataOra   FROM Clienti c JOIN Appuntamenti a";
            
            if ($s_data == true) {
                $date = $_POST['date'];
                if (!empty($_POST['orario'])) {
                    $ora=$_POST['orario'];
                }
            }

            if ($s_client == true) {
                $nome    = $_POST['first_name'];
                $cognome = $_POST['last_name'];

                // inserire parte controllo cliente
                $result = checkCliente($nome, $cognome);
                if (is_null($result) OR count($result) == 0) { //nessuno
                    $err = "<p class=\"errorSuggestion\">Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                    hyperlink("Inserisci un nuovo cliente", "NuovoCliente.php");
                } 
                else { //uno o più
                    $number_rows = count($result);
                    
                    if ($number_rows > 1) {
                        $err= "<p class=\"inforesult\">Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                        $th = '<form method="post" action="StoricoProd.php">
                          <fieldset>
                          <legend>Seleziona il cliente dalla lista</legend>
                          <table id="ElencoClienti" summary="Elenco clienti">
                              <caption>Clienti che si chiamano ' . $nome . ' ' . $cognome . '</caption>
                              <thead>
                              <tr>
                                  <th scope="col">Codice</th>
                                  <th scope="col">Nome</th>
                                  <th scope="col">Cognome</th>
                                  <th scope="col">Telefono</th>
                                  <th scope="col" xml:lang="en">E-mail</th>
                                  <th scope="col">Data nascita</th>
                                  <th scope="col">Selezione</th>
                              </tr>
                          </thead>
                          <tbody>';
                        $tb = "";
                        foreach ($result as $cliente) {
                            $tb .= "
                                <tr>
                                    <td>" . $cliente->codice . "</td>
                                    <td>" . $cliente->nome . "</td>
                                    <td>" . $cliente->cognome . "</td>
                                    <td>" . $cliente->telefono . "</td>
                                    <td>" . $cliente->email . "</td>
                                    <td>" . $cliente->dataNascita . "</td>
                                    <td class=\"tdin\"><input type='radio' name='CodCliente' value='$cliente->codice'/>
                                    <input type='hidden' name='data' value='$data'/>
                                    <input type='hidden' name='data' value='$ora'/>
                                    </td>
                                </tr>
";
                        }
                        $tf       = "</tbody></table>";
                        $to_print.= $th . $tb . $tf;
                        $to_print.= "<input type='submit' name='submit' value='Procedi' />";
                        $to_print.= "<input type='reset' value='Cancella' />";
                        $to_print.= "</fieldset>";
                        $to_print.= "</form>";
                    } //fine n_righe>1
                    
                    else { //unico risultato
                        // prendi il codice cliente dall'unica riga
                        $codCliente = $result[0]->codice;
                        $nome       = $result[0]->nome;
                        $cognome    = $result[0]->cognome;
                        $dati_ok=true;
                    }
                    unset($result);
                }
                // TO HERE
            }
        }
    }    

//*******************************HA TUTTI I DATI **************************//
    if($dati_ok)  {
        // inserire funzione Andrea
        $result = $conn->query($query);
        
        $num_rows = mysqli_num_rows($result);
        $ris      = "";
        if (!$num_rows)
            $ris = "<p class=\"inforesult\">La ricerca non ha prodotto risultati</p>";
        else {
            
            $number_cols = mysqli_num_fields($result);
            
            $ris .= "<p class=\"inforesult\"><strong>Storico:</strong></p>";
            $ris .= '<table id="ListaAppuntamenti" summary="Lista degli appuntamenti">
        <caption class="nasconsto">Lista degli appuntamenti</caption>
        <thead>
            <tr>' . "\n";
            for ($i = 0; $i < $number_cols; $i++) {
                // echo "<th scope=\"col\">" . mysql_field_name ($result, $i). "</th>\n";
                $ris .= "<th scope=\"col\">" . (mysqli_fetch_field_direct($result, $i)->name) . "</th>\n";
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
                $ris .= "</tr>\n";
            }
            $ris .= "</tbody></table>";
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



            else {
                
            }