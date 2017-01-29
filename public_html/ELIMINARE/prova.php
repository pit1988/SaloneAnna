<?php

include ("DBlibrary.php");
$conn=dbconnect();



$query = "
    	SELECT s.DataOra, p.Nome as Nome Prodotto, s.Utilizzo, a.Costo as Costo Appuntamento, ap.Sconto, ap.TipoAppuntamento
			FROM Appuntamenti a NATURAL JOIN AppuntamentiClienti ap NATURAL JOIN storico s NATURAL JOIN Prodotti p
			WHERE s.Codappuntamento=".$CodApp."
			ORDER BY s.CodAppuntamento; ";
$result = mysqli_query($conn, $query);


$number_cols = mysqli_num_fields($result);

echo "<b><h2>Gestione Prodotti</h2></b>";
echo "<table border = 1>\n";
echo "<tr align=center>\n";
for($i=0; $i<$number_cols; $i++)
  {
	echo "<th>" . mysqli_field_seek ($result, $i). "</th>\n";
  }
echo "</tr>\n";

//intestazione tabella


echo"<form method=get action=\"ConfermaModificaProd.php\">";
//corpo tabella
while ($row = mysqli_fetch_row($result))
{


echo "<tr align=left>\n";
   for ($i=0; $i<$number_cols; $i++)
  {
	echo "<td align=center>";
    if(!isset($row[$i])) echo " ";
	else if($i==0)echo "<input type=submit name=prod value=".$row[0]." >";
    else if($i==4) echo "<input type=\"text\" name=\"quantita_".$row[0]."\" value=".$row[$i].">";
    else echo $row[$i]; 
	

 
    echo "</td>\n";
  }
  echo "</tr>\n";
}

echo "</form></table>";
mysqli_close($conn);
?>