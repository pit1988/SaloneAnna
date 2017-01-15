<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Appuntamenti/AppClientiGiorno</p>
<!-- Site navigation menu -->
<table>
	<tr>
	<td>
<ul class="navbar">
  <li><a href="index.php">Home page</a>
  <li><a href="Clienti.php">Clienti</a>
  <li><a href="Prodotti.php">Prodotti</a>
  <li><a href="Appuntamenti.php">Appuntamenti</a>
</ul>
	</td>
	<td>



<?php
	include ("dbconnect.php");
	$conn = dbconnect();

	$submit=$_POST["submit"];
	$nome=$_POST["nome"];
	$cognome=$_POST["cognome"];

	$gg=$_POST["gg"];
	$mm=$_POST["mm"];
	$yyyy=$_POST["yy"];
	$hh=$_POST["hh"];
	$app=$yyyy."-".$mm."-".$gg;

	$data=isset($_POST["data"])?$_POST["data"]:"";
	$cliente=isset($_POST["cli"])?$_POST["cli"]:"";


	if( !$data && !$cliente ) {
		echo "<b>Devi selezionare almeno una delle due ricerche!</b><br>";
		header('Location: RicercaAppuntamenti.php'); 
	};

	$query="
	SELECT c.Nome, c.Cognome, a.DataOra
	FROM Clienti c NATURAL JOIN AppuntamentiClienti	ac NATURAL JOIN Appuntamenti a";

	$where=" WHERE TRUE";

	if($data){
		$where .= " AND DATE(a.DataOra)=\"'$app'\"";
		if($hh) $where .=" AND HOUR(a.DataOra)>=\"'$hh.'\"";
	};
	if($cliente){
		if(!$nome || !$cognome) echo "La ricerca per cliente non e' andata a buon fine per mancanza di campi <br>";
		else $where .=" AND c.Nome=\"'$nome'\"AND c.Cognome=\"'$cognome'\"";
	};

	$query= $query . $where;
			
	$result = $conn->query($query);

	$number_cols = mysqli_num_fields($result);

	echo "<b>Storico:</b>";
	echo "<table border = 1>\n";
	echo "<tr align=center>\n";

	for($i=0; $i<$number_cols; $i++)
		{
			// echo "<th>" . mysql_field_name ($result, $i). "</th>\n";
			echo "<th>" . mysqli_field_seek ($result, $i). "</th>\n";
		}
	echo "</tr>\n";

	//intestazione tabella

	//corpo tabella
	while ($row = mysqli_fetch_row($result))
	{
		echo "<tr align=left>\n";

		for ($i=0; $i<$number_cols; $i++) {
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
?>

	</td>
