<?php
session_start();
session_regenerate_id(TRUE);
require 'library.php';
include("utils/DBlibrary.php");

$to_print = "";
$err = "";
// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} elseif (!isset($_POST['first_name']) XOR !isset($_POST['last_name'])) {
    $err = "<p>Problemi di connessione</p>";
} elseif (isset($_POST['first_name']) && isset($_POST['last_name'])) {
    $submit = $_POST["submit"];
    $nome = $_POST["first_name"];
    $cognome = $_POST["last_name"];
    //modificare pulendo i dati in ingresso
    if (isset($_POST["submit"])) {
        $conn = dbconnect();
        $qry  = "SELECT CodCliente FROM Clienti WHERE Nome='$nome' AND Cognome='$cognome'";
        
        $CodClienteA = mysqli_query($conn, $qry);

        $num_rows = mysqli_num_rows($CodClienteA);
        if (!$num_rows)
            $err .= "<p class=\"inforesult\">Non è presente il cliente richiesto</p>";
        else {
            // vedere se fare lo stesso lavoro per gli altri clienti omonimi
            $CodCliente = mysqli_fetch_row($CodClienteA);
            
            $query = "SELECT s.Codappuntamento, s.DataOra, pa.CodProdotto, pa.Utilizzo, p.Nome FROM Appuntamenti s JOIN ProdApp pa ON s.Codappuntamento=pa.Codappuntamento JOIN Prodotti p ON pa.CodProdotto=p.CodProdotto WHERE CodCliente = '$CodCliente[0]'";
            
            $result = mysqli_query($conn, $query);
            
            $num_rows = mysqli_num_rows($result);
            if (!$num_rows)
                $err .= "<p class=\"inforesult\">Non sono presenti prodotti per il cliente selezionato</p>";
            else {
                $number_cols = mysqli_num_fields($result);
                // echo "<h2>Storico Prodotti:</h2>";
                
                $th = '<table class="storicoApp" summary="Storico Appuntamenti cliente">
              <caption>Di seguito gli appuntamenti di ' . $nome . $cognome . '</caption>
              <thead>
                  <tr>
                      <th scope="col">Codice Appuntamento</th>
                      <th scope="col">Data e Ora</th>
                      <th scope="col">Codice Prodotto</th>
                      <th scope="col">Utilizzo</th>
                      <th scope="col">Nome Prodotto (ml)</th>
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
                while ($row = mysqli_fetch_row($result)) {
                    $tb .= "<tr>\n";
                    
                    for ($i = 0; $i < $number_cols; $i++) {
                        $tb .= "<td>";
                        if (!isset($row[$i])) {
                            $tb .= "NULL";
                        } else {
                            $tb .= $row[$i];
                        }
                        $tb .= "</td>\n";
                    }
                    $tb .= "</tr>\n";
                }
                $tf = "</tbody></table>";
                $to_print = $th . $tb . $tf;
            }
        }
        
    }
}
$form = '
<p class="info">Inserisci i dettagli del cliente per visualizzarne il registro dei prodotti utilizzati</p>
<form method="post" action="StoricoProd.php">
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
      <li><p><input type="submit" name="submit" value="Storico Prodotti"/></p></li>
    </ul>
  </fieldset>
</form>
  ';


$title      = "Storico prodotti: Salone Anna";
$title_meta = "Storico prodotti: Salone Anna";
$descr      = "";
$keywords   = "Storico, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";

page_start($title, $title_meta, $descr, $keywords, '');
$rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a>  / <strong>Storico Prodotti</strong>';
insert_header($rif, 4, true);
content_begin();
echo "<h2>Storico prodotto</h2>";
echo $form;
echo $err;
echo $to_print;

content_end();
page_end();
?>
