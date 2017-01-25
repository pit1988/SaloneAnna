
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'] ) )
{
  header('location:index.php');
  exit;
}
else
{
  require 'library.php';
  $title="Compleanni: Salone Anna";
  $title_meta="Compleanni: Salone Anna";
  $descr="";
  $keywords="Compleanni, Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
  
  page_start($title, $title_meta, $descr, $keywords,'');
  $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Compleanni nel mese</strong>';
  insert_header($rif, 2, true);

  include("dbconnect.php");
  $conn = dbconnect();
  
  $query  = "SELECT c.CodCliente, c.Nome, c.Cognome, c.DataNascita FROM Clienti c WHERE DataNascita BETWEEN CURDATE() AND (ADDDATE(CURDATE(), INTERVAL 31 DAY))";
  $result = mysqli_query($conn, $query);
  
 $num_rows = mysqli_num_rows($result);
  if (!$num_rows)
      $err = "<p>Non ci sono compleanni previsti per i prossimi 31 giorni</p>";
  else {
  $number_cols = mysqli_num_fields($result);
  
  echo "<b>I compleanni questo mese sono:</b>";

   $th = '<table class="storicoApp" summary="Storico Appuntamenti cliente">
              <caption>Di seguito gli appuntamenti di ' . $nome . $cognome . '</caption>
              <thead>
                  <tr>
                      <th scope="col">Codice Cliente</th>
                      <th scope="col">Nome</th>
                      <th scope="col">Cognome</th>
                      <th scope="col">Utilizzo</th>
                      <th scope="col">Data di Nascita</th>
                  </tr>
              </thead>

              <tfoot>
                  <tr>
                      <th scope="col">Codice Cliente</th>
                      <th scope="col">Nome</th>
                      <th scope="col">Cognome</th>
                      <th scope="col">Utilizzo</th>
                      <th scope="col">Data di Nascita</th>
              </tfoot>

              <tbody>
              ';
                //corpo tabella
                $tb = "";

  $tb="";
  
  //corpo tabella
  while ($row = mysqli_fetch_row($result))
  {
          $tb.= "<tr align=left>\n";
          
          for ($i = 0; $i < $number_cols; $i++)
          {
                  $tb.=  "<td>";
                  if (!isset($row[$i]))
                  {
                          $tb.=  "NULL";
                  }
                  else
                  {
                          $tb.=  $row[$i];
                  }
                  $tb.=  "</td>\n";
          }
          $tb.=  "</td>\n";
  }
  
  $tf = "</tbody></table>";
  $to_print = $th . $tb . $tf;
}
  if(isset($err))
    echo $err;
  content_end();
  page_end();
  mysqli_close($conn);
}

?>
