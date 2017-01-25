<?php
/*

PROBLEMA SE DUE CLIENTI HANNO LO STESSO NOME NON SA QUALE SCEGLIERE ! FAGLIELO SCEGLIERE


$queryc =("select * from Clienti c where c.Nome = $nome and c.Cognome = $cognome");
$result = mysql_query(queryc);
$number_cols = mysql_num_fields($result);
echo "Ci sono piu' persone con lo stesso nome per questo appuntamento seleziona quale:";
//intestazione tabella
echo "<table border = 1>\n";
echo "<tr align=center>\n";
for ($i=0; $i<$number_cols; $i++)
  {
    echo "<th>" . mysql_field_name ($result, $i). "</th>\n";
  }
echo "</tr>\n";
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
      {
      	echo $row[$i];
      }
    echo "</td>\n";
  }
  echo "</td>\n";
}

echo "</table>";


*/
include("NuovoAppuntamento.php");

include("DBlibrary.php");
  $conn = dbconnect();
	$submit=$_POST["submit"];
	$nome=$_POST["nome"];
	$cognome=$_POST["cognome"];
	$sconto=$_POST["sconto"];
	$costo=$_POST["costo"];
	
	$TipoAppuntamento=$_POST["TipoAppuntamento"];
	
	$gg=$_POST["gg"];
	$mm=$_POST["mm"];
	if($mm<=date('m') && $gg<=date('d')) 
	$yyyy = date('Y')+1;
	else
	$yyyy = date('Y');
	$hh=$_POST["hh"];
	$min=$_POST["min"];
	$app=$yyyy."-".$mm."-".$gg." ".$hh.":".$min.":00";




//Estraiamo codice cliente
	$CodClienteA=mysqli_query($conn, "SELECT RitCod('$nome', '$cognome')")
		or die("Query fallita " . mysqli_error($conn));
	$CodCliente = mysqli_fetch_row($CodClienteA);

	

  if (isset($submit))
  {		$query = "INSERT INTO Appuntamenti (Costo, DataOra) values
	      	($costo, '$app' );
		INSERT INTO AppuntamentiClienti (CodCliente, Sconto, TipoAppuntamento) values
		(.$CodCliente[0].,$sconto,'$TipoAppuntamento',);";
		
 		$ok = mysqli_query($conn, "CALL InserimentoAppuntamentoCliente('$CodCliente[0]', '$app', '$sconto', '$costo', '$TipoAppuntamento');") or 
      			die ("Query Inserimento Fallita " . mysqli_error());
	
	echo "<b>Appuntamento di $nome inserito correttamente il $gg del $mm alle $hh:$min</b><br>";
	
	};
	mysqli_close($conn);

?>




