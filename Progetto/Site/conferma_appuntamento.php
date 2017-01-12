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
{

echo "</table>";


*/
include("NuovoAppuntamento.php");

include("dbconnect.php");
  $conn = dbconnect();
	$submit=$_POST["submit"];
	
	//verifico se ho passato codcliente
	if(isset($_POST["CodCliente"])) $CodCliente=$_POST["CodCliente"];
	else{
	$nome=$_POST["nome"];
	$cognome=$_POST["cognome"];
	//Estraiamo codice cliente
	$CodClienteA=mysql_query("SELECT RitCod('$nome', '$cognome')")
		or die("Query fallita " . mysql_error($conn));
	$CodCliente = mysql_fetch_row($CodClienteA);
	};
	
	
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
	$app=$yyyy."-".$mm."-".$gg."&nbsp".$hh.":".$min.":00";




	

  if (isset($submit))
  {		$query = "CALL ModificaAppuntamentoCliente('$CodCliente[0]', '$app', '$sconto', '$costo', '$TipoAppuntamento') ;";
		
 		$ok = mysql_query($query) or 
      			die ("Query Inserimento Fallita " . mysql_error());
	
	echo "<b>Appuntamento inserito correttamente il $gg del $mm alle $hh:$min</b><br>";
	
	};

?>




