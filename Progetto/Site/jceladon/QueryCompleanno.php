<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Compleanno</p>
<!-- Site navigation menu -->
<table>
	<tr>
	<td>
<ul class="navbar">
  <li><a href="Root.php">Home page</a>
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


include ("dbconnect.php");
$conn=dbconnect();

$query = "
    	SELECT c.CodCliente, c.Nome, c.Cognome, c.Compleanno FROM Clienti c WHERE Compleanno BETWEEN CURDATE() AND (ADDDATE(CURDATE(), INTERVAL 31 DAY));";
$result = mysql_query($query);


$number_cols = mysql_num_fields($result);

echo "<b>I compleanni questo mese sono:</b>";
echo "<table border = 1>\n";
echo "<tr align=center>\n";
for($i=0; $i<$number_cols; $i++)
  {
    echo "<th>" . mysql_field_name ($result, $i). "</th>\n";
  }
echo "</tr>\n";

//intestazione tabella

//corpo tabella
while ($row = mysql_fetch_row($result))
{
  echo "<tr align=left>\n";

  for ($i=0; $i<$number_cols; $i++)
  {
    echo "<td>";
    if(!isset($row[$i]))
      {echo "NULL";}
    else
      {echo $row[$i];}
    echo "</td>\n";
  }
  echo "</td>\n";
}

echo "</table>";
}
?>

	</td>
