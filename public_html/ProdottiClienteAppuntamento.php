<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login = authenticate();

// Controllo accesso
if (!$login) {
    header('location:errore.php?codmsg=1');
    exit;
} else {
    $to_print  = "";
    $err       = "";
    $trovati   = false;
    $to_insert = false;
    
    if (!isset($_POST['first_name']) XOR !isset($_POST['last_name'])) {
        $err = "<p>Problemi di connessione</p>";
    }
    
    elseif (isset($_POST['first_name']) && isset($_POST['last_name'])) {
        $submit  = $_POST["submit"];
        $nome    = $_POST["first_name"];
        $cognome = $_POST["last_name"];
        //modificare pulendo i dati in ingresso
        if (isset($_POST["submit"])) {
            $result = checkCliente($nome, $cognome);
            if (strlen($nome) == 0 && strlen($cognome) == 0) {
                $err = "<p class=\"errorSuggestion\">Non è stato inserito alcun dato, prova ad effettuare una nuova ricerca</p>";
            } elseif (is_null($result) OR count($result) == 0) {
                $err = "<p class=\"errorSuggestion\">Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                $to_insert = true;
            } else { //uno o più
                $trovati     = true;
                $number_rows = count($result);
                
                if ($number_rows > 1) {
                    $to_print .= "<p class=\"inforesult\">Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                }
                $th = '
                  <form method="post" action="SelezionaAppuntamentoCliente.php">
                  <fieldset>
                  <legend>Seleziona il cliente dalla lista</legend>
                  <table id="ProdottiMagazzino" summary="Elenco clienti">
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
                          <td>" . $cliente->codice . "</td><td>" . $cliente->nome . "</td>
                          <td>" . $cliente->cognome . "</td>
                          <td>" . $cliente->telefono . "</td>
                          <td>" . $cliente->email . "</td>
                          <td>" . $cliente->dataNascita . "</td>
                          <td class=\"tdin\"><input type='radio' name='CodCliente' value='$cliente->codice'/></td>
                      </tr>
                      ";
                }
                $tf = "</tbody></table>";
                $to_print .= $th . $tb . $tf;
                
                $to_print .= "<input type='submit' name='submit' value='Procedi' />
                <input type='reset' value='Cancella' />
                </fieldset>
                </form>";
                unset($result);
            }
        }
    } //è stato fatto il controllo.
    $form       = '
      <p class="info">Inserisci i dettagli del cliente, verrai condotto ad una pagina da cui selezionare i relativi appuntamenti, per poi arrivare ad aggiungere i prodotti.</p>
      
        <form method="post" onsubmit="return validazioneFormStorico();" action="ProdottiClienteAppuntamento.php">
          <fieldset>
            <legend>Ricerca cliente</legend>
            <ul>
              <li>
                  <p>
                      <label for="first_name">Nome</label>
                      <input type="text" name="first_name" id="first_name" tabindex="100"/>
                  
                      <label for="last_name">Cognome</label>
                      <input type="text" name="last_name" id="last_name" tabindex="101" />
                  </p>
              </li>
              <li>
                <p class="noPrint"><input type="submit" name="submit" value="Procedi"/></p>
                <span id="logError"></span>
              </li>
            </ul>
          </fieldset>
        </form>
        ';
    $title      = "Inserisci Prodotti Appuntamento Cliente | Salone Anna";
    $title_meta = "Inserisci prodotti Appuntamento Cliente | Salone Anna";
    $descr      = "";
    $keywords   = "Storico, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    if (!$trovati)
        page_start($title, $title_meta, $descr, $keywords, 'caricamentoStorico()');
    else
        page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a>  / <strong>Prodotti-Clienti-Appuntamento</strong>';
    insert_header($rif, 4, true);
    content_begin();
    echo "<h2>Seleziona Cliente</h2>";
    
    
    if (!$trovati)
        echo $form;
    if (isset($err)) {
        echo $err;
    }
    if ($to_insert)
        hyperlink("Inserisci un nuovo cliente", "NuovoCliente.php");
    echo $to_print;
    content_end();
    page_end();
}
?>
