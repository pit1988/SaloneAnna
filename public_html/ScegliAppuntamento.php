<?php
require 'library.php';
require 'utils/DBlibrary.php';
  $login=authenticate();
  // Controllo accesso
  if (!$login) {
      header('location:index.php');
      exit;
  } else {
      $title = "Seleziona Appuntamento | Salone Anna";
      $title_meta = "Seleziona Appuntamento | Salone Anna";
      $descr = "Pagina di selezione appuntamento visualizzato tra varie scelte";
      $keywords = "Appuntamento, Ricerca, Nome, Cognome, Data, Ora, Tipo, Prezzo";
      page_start($title, $title_meta, $descr, $keywords, '');
      $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Gestione Appuntamenti</strong>';
      insert_header($rif, 6, true);
      content_begin();
      
      $result = listaAppuntamenti();
      
      echo "<h2>Lista degli appuntamenti da oggi in poi</h2>";
      
      if (!$result)
          echo "<p>Non ci sono appuntamenti da mostrare</p>";
      else {
          echo '<form method="post" action="ModificaAppuntamento.php">
          <fieldset>';
          $str_to_print = '<table id="tabAppSelect" summary="Elenco Appuntamenti">
      <caption>Appuntamenti successivi alla data corrente</caption>
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Nome</th>
          <th scope="col">Cognome</th>
          <th scope="col">Data</th>
          <th scope="col">Ora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Prezzo</th>
          <th scope="col" class="noPrint">Seleziona</th>
        </tr>
      </thead>
      <tbody>';
          
          foreach ($result as $appuntamento) {
              $str_to_print.= "
                <tr>
                  <td>".$appuntamento->codice."</td>
                  <td>".$appuntamento->nome."</td>
                  <td>".$appuntamento->cognome."</td>
                  <td>".$appuntamento->data."</td>
                  <td>".$appuntamento->ora."</td>
                  <td>".$appuntamento->tipo."</td>
                  <td>".$appuntamento->prezzo."</td>
                  <td class=\"tdin\"><input type=\"radio\" name=\"codapp\" value= \"" . $appuntamento->codice . "\"/></td>
                </tr>";
          }
          
          $str_to_print .= "</tbody></table>";
          echo $str_to_print;
          echo "<input type=\"submit\" name=\"submit\" value=\"Conferma\" />
          </fieldset>
        </form>";
      }
      unset($result);
      content_end();
      page_end();
  }
  ?>