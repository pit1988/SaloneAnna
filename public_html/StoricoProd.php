<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login = authenticate();

$to_print  = "";
$err       = "";
$to_insert = true;
$trovato   = false;
// Controllo accesso
if (!$login) {
    header('location:errore.php?codmsg=1');
    exit;
} elseif (isset($_POST['submit'])) {
    if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
        $submit  = $_POST["submit"];
        $nome    = $_POST["first_name"];
        $cognome = $_POST["last_name"];
        //modificare pulendo i dati in ingresso
        if (strlen($nome) == 0 OR strlen($cognome) == 0) //
            $err = "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
        else {
            $result = checkCliente($nome, $cognome);
            if (is_null($result) OR count($result) == 0) { //nessuno
                $err = "<p class=\"errorSuggestion\">Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                hyperlink("Inserisci un nuovo cliente", "NuovoCliente.php");
            } else { //uno o più
                $number_rows = count($result);
                $to_insert=false;
                if ($number_rows > 1) {
                    $err = "<p class=\"inforesult\">Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                    $th  = '<form method="post" action="StoricoProd.php">
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
                    $tb  = "";
                    foreach ($result as $cliente) {
                        $tb .= "
                              <tr>
                                  <td>" . $cliente->codice . "</td>
                                  <td>" . $cliente->nome . "</td>
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
                    $to_print .= "<input type='submit' name='submit' value='Procedi' />";
                    $to_print .= "<input type='reset' value='Cancella' />";
                    $to_print .= "</fieldset>";
                    $to_print .= "</form>";
                } //fine n_righe>1
                
                else { //unico risultato
                    // prendi il codice cliente dall'unica riga
                    $codCliente = $result[0]->codice;
                    $nome       = $result[0]->nome;
                    $cognome    = $result[0]->cognome;
                    $trovato    = true;
                }
                unset($result);
            }
        }
    }
    
    if (isset($_POST['CodCliente'])) {
        $to_insert  = false;
        $codCliente = $_POST['CodCliente'];
        $cliente    = mostraCliente($codCliente);
        $nome       = $cliente->nome;
        $cognome    = $cliente->cognome;
        $trovato    = true;
    }
    
    if ($trovato == true) {
        // USA IL CODICE CLIENTE
        $ris = listaProdottiAppuntamentoDatato($codCliente);
        if (count($ris) > 0) {
            
            $th = '<table class="storicoApp" summary="Storico Prodotti cliente">
                    <caption>Di seguito i prodotti usati negli appunamenti di ' . $nome . " " . $cognome . '</caption>
                    <thead>
                        <tr>
                            <th scope="col">Codice Appuntamento</th>
                            <th scope="col">Data e Ora</th>
                            <th scope="col">Codice Prodotto</th>
                            <th scope="col">Utilizzo (ml)</th>
                            <th scope="col">Nome Prodotto</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th scope="col">Codice Appuntamento</th>
                            <th scope="col">Data e Ora</th>
                            <th scope="col">Codice Prodotto</th>
                            <th scope="col">Utilizzo (ml)</th>
                            <th scope="col">Nome Prodotto</th>
                        </tr>
                    </tfoot>

                    <tbody>
                    ';
            //corpo tabella - Inserire ml su cella utilizzo
            $tb = "";
            foreach ($ris as $appuntamentoDatato) {
                $tb .= "<tr>
                      <td>" . $appuntamentoDatato->codAppuntamento . "</td>
                      <td>" . $appuntamentoDatato->data . " " . $appuntamentoDatato->ora . "</td>
                      <td>" . $appuntamentoDatato->codProdotto . "</td>
                      <td>" . $appuntamentoDatato->utilizzo . " ml</td>
                      <td>" . $appuntamentoDatato->nome . "</td>
                    </tr>
                    ";
                $tf       = "</tbody></table>";
                $to_print = $th . $tb . $tf;
            }
        } else {
            $err = "<p class=\"inforesult\">Non sono presenti prodotti per il cliente selezionato</p>";
        }
        unset($ris);
    }
    if (!isset($_POST['CodCliente']) && (!isset($_POST['first_name']) OR !isset($_POST['last_name']))) {
        $err = "<p class=\"errorSuggestion\">Problemi di connessione</p>";
    } //almeno uno dei due è settato)
}


$form = '
<p class="info">Riporta il cliente di cui vuoi visualizare i prodotti utilizzati</p>
<form method="post" onsubmit="return validazioneFormStorico();" action="StoricoProd.php">
  <fieldset>
    <legend>Cerca prodotti utilizzati dal cliente:</legend>
    <ul>
      <li>
          <p>
              <label for="first_name">Nome</label>
              <input type="text" name="first_name" id="first_name" tabindex="100"/>
          
              <label for="last_name">Cognome</label>
              <input type="text" name="last_name" id="last_name" tabindex="101" />
          </p>
      </li>
      <li class="noPrint">
        <p><input type="submit" name="submit" value="Invia"/></p>
        <span id="logError"></span>
      </li>
    </ul>
  </fieldset>
</form>
  ';


$title      = "Storico Prodotti | Salone Anna";
$title_meta = "Storico Prodotti | Salone Anna";
$descr      = "Pagina in cui inserendo Nome e Cognome del Cliente ti dà la possibilità di vedere i vari prodotti usati nel tempo in tabella";
$keywords   = "Storico, Prodotti, Nome, Cognome, Cliente, Quantità, Utilizzo, Codice, Prodotto, Appuntamento";

if ($to_insert){
    page_start($title, $title_meta, $descr, $keywords, 'caricamentoStorico()');
}
else{
    page_start($title, $title_meta, $descr, $keywords, '');
}
$rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a>  / <strong>Storico Prodotti</strong>';
insert_header($rif, 4, true);
content_begin();
echo "<h2>Storico prodotti</h2>";
echo $err;
if ($to_insert) {
    echo $form;
}
if ($trovato)
    hyperlink("Cerca un altro cliente", "StoricoProd.php");
echo $to_print;

content_end();
page_end();
?>
