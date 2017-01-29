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
      $title = "Ricerca Appuntamento: Salone Anna";
      $title_meta = "Ricerca Appuntamento: Salone Anna";
      $descr = "";
      $keywords = "Appuntamento, Ricerca, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
      page_start($title, $title_meta, $descr, $keywords, '');
      $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Gestione Appuntamenti</strong>';
      insert_header($rif, 6, true);
      content_begin();
      
      $result = listaAppuntamenti();
      
      
      echo "<b><h2>Lista degli appuntamenti da oggi in poi</h2></b>";
      
      if (!$result)
          echo "<p>Non ci sono appuntamenti da mostrare</p>";
      else {
          form_start("POST", "ModificaAppuntamento.php");
          echo '<fieldset>';
            // <input type=submit name="submit" value="Conferma">';
          $str_to_print = '<table id="topProd" summary="Appuntamenti successivi alla data corrente">
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
        <th scope="col">Seleziona</th>
      </tr></thead></tbody>';
          
          foreach ($result as $appuntamento) {
              $str_to_print .= "<tr>\n";
              $str_to_print.= "<tr><td>".$appuntamento->codice."</td><td>".$appuntamento->nome."</td><td>".$appuntamento->cognome."</td><td>".$appuntamento->data."</td><td>".$appuntamento->ora."</td><td>".$appuntamento->tipo."</td><td>".$appuntamento->prezzo."</td><td><input type=\"radio\" name=\"codMsg[]\" value= \"" . $appuntamento->codice . "\"/></td></tr>";
              $str_to_print .= "</tr>\n";
          }
          
          $str_to_print .= "</tbody></table>";
          echo $str_to_print;
          echo "<input type=submit name=\"submit\" value=\"Conferma\">
        </td>
        </form>";
      }
      
      content_end();
      page_end();
  }
  ?>

  public $codice;
  public $data;
  public $ora;
  public $tipo;
  public $prezzo;
  public $nome;
  public $cognome;
  public $telefono;
  public $email;