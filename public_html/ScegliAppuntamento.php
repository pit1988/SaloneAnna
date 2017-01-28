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
      
      $conn = dbconnect();
      
      $query  = "SELECT a.CodAppuntamento AS 'ID', c.Nome, c.Cognome, c.CodCliente, a.DataOra, ta.NomeTipo AS 'Tipo' FROM Appuntamenti a JOIN TipoAppuntamento ta on a.CodAppuntamento=ta.CodTipoAppuntamento JOIN Clienti c on a.CodCliente=c.CodCliente WHERE DATE(a.DataOra)>=CURDATE() ORDER BY a.DataOra ASC, a.CodAppuntamento ASC";
      $result = $conn->query($query);
      
      $number_cols = mysqli_num_fields($result);
      
      echo "<b><h2>Lista degli appuntamenti da oggi in poi</h2></b>";
      $num_rows = mysqli_num_rows($result);
      if (!$num_rows)
          echo "<p>Non ci sono appuntamenti da mostrare</p>";
      else {
          // form_start("POST", "ConfermaModificaAppuntamenti.php");
          form_start("POST", "ModificaAppuntamento.php");
          echo '<fieldset>';
            // <input type=submit name="submit" value="Conferma">';
          $str_to_print = '<table id="topProd" summary="Appuntamenti successivi alla data corrente">
      <caption>Appuntamenti successivi alla data corrente</caption>
      <thead>
      <tr>
        <th scope="col">Seleziona</th>
      ';
          for ($i = 0; $i < $number_cols; $i++) {
              $str_to_print .= '<th scope="col">' . (mysqli_fetch_field_direct($result, $i) ->name) . "</th>\n";
          }
          $str_to_print .= "</tr></thead></tbody>\n";
          
          while ($row = mysqli_fetch_row($result)) {
              
              $str_to_print .= "<tr>\n";
              for ($i = 0; $i < $number_cols + 1; $i++) {
                  $str_to_print .= "<td>";
                  if (!isset($row[$i]))
                      $str_to_print .= " ";
                  if ($i == 0)
                      $str_to_print .= "<input type=\"radio\" name=\"codapp\" value= \"" . $row[$i] . "\"\/>";
                  else {
                      $str_to_print .= $row[$i - 1];
                  }
                  
                  $str_to_print .= "</td>\n";
              }
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