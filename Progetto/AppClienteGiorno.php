<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Appuntamenti/AppClientiGiorno</p>
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


include ("dbconnect.php");
$conn = dbconnect();
	
	$submit=$_POST["submit"];
	$nome=$_POST["nome"];
	$cognome=$_POST["cognome"];
	
	$date=$_POST["date"];
	
	$data=isset($_POST["data"])?$_POST["data"]:"";
	$hh=$_POST["hh"];

	
	$cliente=isset($_POST["cli"])?$_POST["cli"]:"";

	if(!$data && !$cliente){
		echo "<b>Devi selezionare almeno una delle due ricerche!</b>";
		
	}
	else{
		$query="
		SELECT a.CodAppuntamento, c.CodCliente, c.Nome, c.Cognome, a.DataOra
		FROM Clienti c NATURAL JOIN AppuntamentiClienti	 ac NATURAL JOIN Appuntamenti a";
		
		$where=" WHERE TRUE";
		if($cliente){
			if($nome=="" || $cognome=="")
			{ echo "La ricerca per cliente non e' andata a buon fine per mancanza di campi"; 
				$where .=" AND FALSE ";
			}else{
				$where .=" AND c.Nome=\"$nome\"AND c.Cognome=\"$cognome\"";
			};
		};
		if($data){
			$where .= " AND DATE(a.DataOra)=\"$date\"";
			if($hh) $where .=" AND HOUR(a.DataOra)>=\"$hh.\"";
		};
		
	
		$query= $query . $where;
		$result = mysql_query($query);
		$number_cols = mysql_num_fields($result);
		
		
		echo"<form method=get action=\"ModificaAppuntamento.php\">";
		echo "<b>Storico:</b>";
		echo "<table border = 1>\n";
		echo "<tr align=center>\n";
		//intestazione tabella		
		for($i=0; $i<$number_cols; $i++)
		  {
		    echo "<th>" .mysql_field_name ($result, $i)."</th>\n";
		  }
		echo "</tr>\n";
		
		//corpo tabella
		while ($row = mysql_fetch_row($result))
		{
		  echo "<tr align=left>\n";
		  for ($i=0; $i<$number_cols; $i++)
		  {
		    echo "<td>";
		    if(!isset($row[$i])) echo " ";
			else if($i==0) echo "<input type=submit name=CodApp value=".$row[0]." >";
			else if($i==2) echo $row[2]."<input type=hidden name=nome".$row[0]." value=".$row[2].">";
			else if($i==3) echo $row[3]."<input type=hidden name=cognome".$row[0]." value=".$row[3].">";
		   	else echo $row[$i];
		    echo "</td>\n";
		  }
		  echo "</tr>\n";
		}
		echo "</form></table>";
	};
echo" <br>Torna a <a href=\"RicercaAppuntamenti.php\">Ricerca Appuntamenti</a>";
}	
?>

