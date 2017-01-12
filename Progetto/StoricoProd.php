<?php
include ("dbconnect.php");
include ("Clienti.php");
$conn=dbconnect();

$submit=$_POST["submit"];
$nome=$_POST["nome"];
$cognome=$_POST["cognome"];


$CodClienteA=mysql_query("SELECT RitCod('$nome', '$cognome')")
		or die("Query fallita " . mysql_error($conn));
$CodCliente = mysql_fetch_row($CodClienteA);



$query = "
    	SELECT s.Codappuntamento, s.DataOra, s.CodProdotto, s.Utilizzo, p.Nome
FROM storico s NATURAL JOIN Prodotti p
WHERE CodCliente = ".$CodCliente[0].";";

$result = mysql_query($query);


$number_cols = mysql_num_fields($result);

echo "<b>Storico:</b>";
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

?>

	</td>
