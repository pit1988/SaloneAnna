<body background="sfondo.jpg">
<p align="right" valign="top">/Home/GestioneAppuntamenti</p>
<!-- Site navigation menu -->

<table>
  <td width= "10%" valign="top" height="10">
    <ul class="navbar">
      <li><a href="index.php">Home page</a>
      <li><a href="Clienti.php">Clienti</a>
      <li><a href="Prodotti.php">Prodotti</a>
      <li><a href="Appuntamenti.php">Appuntamenti</a>
    </ul>
  </td>
<td>
<?php
  session_start();
  session_regenerate_id(TRUE);

  // Controllo accesso

  if (!isset($_SESSION['username'] ) )
  {
  header('location:Accesso.php');
  exit;
  }
  else
  {
  echo "Benvenuto ".$_SESSION['username'];
  echo"<form method=post action=\"ConfermaModificaAppuntamenti.php\">
  <input type=submit name=\"submit\" value=\"Conferma\"><br>";

  include ("dbconnect.php");
  $conn=dbconnect();

  $query = "SELECT c.Nome, c.Cognome, c.CodCliente, a.DataOra, a.CodAppuntamento, a.Costo, ac.TipoAppuntamento FROM Appuntamenti a NATURAL JOIN AppuntamentiClienti ac NATURAL JOIN Clienti c WHERE DATE(a.DataOra)>CURDATE()";
  $result = $conn->query($query);


  $number_cols = $result->num_fields;

  echo "<b><h2>Lista Appuntamenti Prossimi</h2></b>";
  echo "<table border = 1>\n";
  echo "<tr align=center>\n";
  for($i=0; $i<$number_cols+1; $i++)
    {
  	if($i==$number_cols) echo"<th> Modifica </th>\n";
  	else echo "<th>" . mysqli_field_seek ($result, $i). "</th>\n";
    }
  echo "</tr>\n";

  //intestazione tabella

  //corpo tabella
  while ($row = mysqli_fetch_row($result))
  {


  echo "<tr align=left>\n";
    for ($i=0; $i<$number_cols+1; $i++)
    {
  	echo "<td align=center>";
      if(!isset($row[$i])) echo " ";
      else if($i==3) echo "<input type=\"text\" name=\"DataOra\" value=\"$row[$i]\" />";
      else
        {echo $row[$i];} 
  	if($i==$number_cols)echo "<input type=submit name=\"ok\" value='modifica' >";

   
      echo "</td>\n";
    }
    echo "</tr>\n";
  }

  echo "</table>";

  echo"<input type=submit name=\"submit\" value=\"Conferma\">
  </td>
  </form>

  	</td>";
  }
  mysqli_close($conn);
?>
