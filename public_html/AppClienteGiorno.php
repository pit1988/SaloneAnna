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
    $no_client=false;
    if(isset($_POST['CodCliente']) && isset($_POST['date']) && isset($_POST['ora'])) {
        $data = $_POST['date'];
        $ora=$_POST['ora'];
        $codCliente=$_POST['CodCliente'];
        $dati_ok=true;
    }

    if (!isset($_POST['submit']) OR (!isset($_POST['cli']) AND !isset($_POST['data']))) {
        $err = "<p class=\"errorSuggestion\">Potresti non aver selezionato alcuna casella di ricerca.</p>";
    } 
    elseif(isset($_POST['submit']) AND (isset($_POST['cli']) OR isset($_POST['data']))) {
        $codCliente="";
        $data=""; 
        $ora="";
        $s_client = (isset($_POST['cli']) && ($_POST["cli"] == "cli")) ? true : false;
        $s_data   = (isset($_POST['data']) && ($_POST["data"] == "data")) ? true : false;
        
        if (($s_client == true && (empty($_POST['first_name']) OR (empty($_POST['last_name'])))) OR ($s_data == true && (empty($_POST['date'])))) {
            $err = "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
            
        } 
        else {
            if ($s_data == true) {
                $data = $_POST['date'];
                if (!empty($_POST['orario'])) {
                    $ora=$_POST['orario'];
                }
                $dati_ok=true;
            }

            if ($s_client == true) {
                $nome    = $_POST['first_name'];
                $cognome = $_POST['last_name'];

                // inserire parte controllo cliente
                $result = checkCliente($nome, $cognome);
                if (is_null($result) OR count($result) == 0) { //nessuno
                    $dati_ok=false;
                    $err = "<p class=\"errorSuggestion\">Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                    $no_client=true;
                } 
                else { //uno o più
                    $number_rows = count($result);
                    
                    if ($number_rows > 1) {
                        $dati_ok=false;
                        $err= "<p class=\"inforesult\">Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                        $th = '<form method="post" action="AppClienteGiorno.php">
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
                                  <th scope="col" class="noPrint">Selezione</th>
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
                                    <input type='hidden' name='date' value='$data'/>
                                    <input type='hidden' name='ora' value='$ora'/>
                                    </td>
                                </tr>
                                ";
                        }
                        $tf       = "</tbody></table>";
                        $ris = $th . $tb . $tf;
                        $ris.= "
                            <input type='submit' name='submit' value='Procedi' />
                            <input type='reset' value='Cancella' />
                            </fieldset>
                        </form>";
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
            }
        }
    }    

//*******************************HA TUTTI I DATI **************************//
    if($dati_ok)  {
        $res = AppuntamentiDataCliente($codCliente, $data, $ora);
        
        $num_rows = count($res);
        $ris      = "";
        if ($num_rows==0)
            $ris = "<p class=\"inforesult\">La ricerca non ha prodotto risultati</p>";
        else {
            
            $ris .= "<p class=\"inforesult\"><strong>Storico:</strong></p>";
            $ris .= '<table id="ListaAppuntamenti" summary="Lista degli appuntamenti">
        <caption class="nasconsto">Lista degli appuntamenti</caption>
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Cognome</th>
                <th scope="col">Data Ora</th>
                <th scope="col">Tipo</th>
            </tr>
        </thead>
        <tbody>';
            
            foreach ($res as $appuntamento) {
                $ris.="
                    <tr>
                        <td>".$appuntamento->nome."</td>
                        <td>".$appuntamento->cognome."</td>
                        <td>".$appuntamento->data." ".$appuntamento->ora."</td>
                        <td>".$appuntamento->tipo."</td>
                    </tr>
                ";
            }
            $ris .= "</tbody></table>";
        }
        unset($result);
    }    

    $title      = "Ricerca Appuntamento | Salone Anna";
    $title_meta = "Ricerca Appuntamento | Salone Anna";
    $descr      = "Pagina di ricerca appuntamento del Salone Anna";
    $keywords   = "Appuntamento, Ricerca, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="RicercaAppuntamenti.php">Ricerca Appuntamento</a> / <strong>Risultati</strong>';
    insert_header($rif, 6, true);
    content_begin();
    if (isset($err))
        echo $err;
    if (isset($ris))
        echo $ris;
    if($no_client)
        hyperlink("Inserisci un nuovo cliente", "NuovoCliente.php");
    echo "<p>Segui il link per tornare alla <a href=\"RicercaAppuntamenti.php\">pagina di ricerca</a></p>";
    content_end();
    page_end();
}
?>