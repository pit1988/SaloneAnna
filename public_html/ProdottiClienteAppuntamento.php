<?php
session_start();
session_regenerate_id(TRUE);
require 'library.php';
include("utils/DBlibrary.php");

$to_print = "";
$err      = "";
$trovati  = false;
// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    
    $title      = "Inserisci prodotti Appuntamento Cliente: Salone Anna";
    $title_meta = "Inserisci prodotti Appuntamento Cliente: Salone Anna";
    $descr      = "";
    $keywords   = "Storico, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a>  / <strong>Prodotti-Clienti-Appuntamento</strong>';
    insert_header($rif, 4, true);
    content_begin();
    echo "<h2>Seleziona Cliente</h2>";
    
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
            
            if (is_null($result) OR count($result) == 0) {
                echo "<p class=\"errorSuggestion\">Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                hyperlink("Inserisci un nuovo cliente", "NuovoCliente.php");
            } else { //uno o più
                $trovati     = true;
                $number_rows = count($result);
                
                if ($number_rows > 1) {
                    echo "<p class=\"inforesult\">Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                }
                $th = '
                  <form method=post action="SelezionaAppuntamentoCliente.php">
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
                          <td>" . $cliente->telefono . "</a></td>
                          <td>" . $cliente->email . "</td>
                          <td>" . $cliente->dataNascita . "</td>
                          <td><input type='radio' name='CodCliente' value=$cliente->codice></td>
                      </tr>
                      ";
                }
                $tf       = "</tbody></table>";
                $to_print = $th . $tb . $tf;
                echo $to_print;
                
                echo "<input type='submit' name='submit' value='Procedi'>";
                echo "<input type='reset' value='Cancella'>";
                echo "</fieldset>";
                echo "</form>";
                unset($result);
            }
        }
    } //è stato fatto il controllo.
    $form = '
      <p class="info">Inserisci i dettagli del cliente per visualizzarne il registro dei prodotti utilizzati</p>
      <p>
        <form method=post action="ProdottiClienteAppuntamento.php">
          <fieldset>
            <legend>Ricerca prodotti</legend>
            <ul>
              <li>
                  <p>
                      <label for="first_name">Nome</label>
                      <input type="text" name="first_name" id="first_name" tabindex="100"/>
                  
                      <label for="last_name">Cognome</label>
                      <input type="text" name="last_name" id="last_name" tabindex="101" />
                  </p>
              </li>
              <li><p><input type="submit" name="submit" value="Storico Prodotti"/></p></li>
            </ul>
          <fieldset>
        </form>
      </p>
        ';
    if (!$trovati)
        echo $form;
    if (isset($err))
        echo $err;
    content_end();
    page_end();
}
?>
