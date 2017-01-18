<?php
include ("dbconnect.php");
include ("Clienti.php");
$conn=dbconnect();

$submit=$_POST["submit"];
$nome=$_POST["nome"];
$cognome=$_POST["cognome"];

if(isset($_POST["submit"])){
$CodClienteA=mysqli_query($conn, "SELECT RitCod('$nome', '$cognome')")
		or die("Query fallita " . mysqli_error($conn));
$CodCliente = mysqli_fetch_row($CodClienteA);



$query = "
    	SELECT s.Codappuntamento, s.DataOra, s.CodProdotto, s.Utilizzo, p.Nome
FROM storico s NATURAL JOIN Prodotti p
WHERE CodCliente = ".$CodCliente[0].";";

$result = mysqli_query($conn, $query);


$number_cols = mysqli_num_fields($result);

echo "<b>Storico:</b>";
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
mysqli_close($conn);
}
?>
