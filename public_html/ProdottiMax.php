
<body background="sfondo.jpg">
<p align="right" valign="top">/Home/ProdottiMax</p>
<!-- Site navigation menu -->
<table>
	<tr>
	<td>
    <ul class="navbar">
      <li><a href="index.php">Home page</a></li>
      <li><a href="Clienti.php">Clienti</a></li>
      <li><a href="Prodotti.php">Prodotti</a></li>
      <li><a href="Appuntamenti.php">Appuntamenti</a></li>
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
    	SELECT p.CodProdotto, p.Nome, p.Tipo, p.Marca, p.PRivendita, a.Utilizzo
	FROM Prodotti p NATURAL JOIN ProdApp a
	ORDER BY Utilizzo DESC
	LIMIT 10;
";
$result = mysqli_query($conn, $query);


$number_cols = mysqli_num_fields($result);

echo "<b>I prodotti piu' usati in appuntamento sono:</b>";
echo "<table border = 1>\n";
echo "<tr align=center>\n";
for($i=0; $i<$number_cols; $i++)
  {
    echo "<th>" . mysqli_field_seek ($result, $i). "</th>\n";
  }
echo "</tr>\n";

//intestazione tabella

//corpo tabella
while ($row = mysqli_fetch_row($result))
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
mysqli_close($conn);
?>

        
      </td>
    </tr>
  </table>
</body>
