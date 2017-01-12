<head>

<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Prodotti/ConfermaModificaProdotti</p>

</head>

<?php

include("dbconnect.php");
$conn = dbconnect();

$CodApp=$_GET["codapp"];

	if(isset($_POST["modapp"])){
		
	$submit=$_POST["modapp"];
  	$datetime=$_POST["datetime"];
	$costo=$_POST["costo"];
	$sconto=$_POST["sconto"];
	$TipoAppuntamento=$_POST["TipoAppuntamento"];
		
	};
	
	
	if(isset($_GET["addprod"])){
	$addprod=$_GET["addprod"];
	$Prodotto=$_GET["Prodotto"];
  	$quantita=$_GET["newquantita"];
	
	};
	
	if(isset($_GET["delapp"])){
		 	$query = "DELETE FROM Appuntamenti WHERE CodAppuntamento='$CodApp';";
 			$ok = mysql_query($query) or 
      			die ("Query Inserimento Fallita " . mysql_error());
	
	echo "Appuntamento #$CodApp cancellato correttamente. Torna a <a href=Appuntamenti.php>Appuntamenti</a> <br><br>";
	
	};
	
	
	//modifico appuntamenti
	 if (isset($submit)){
		 		$query = "CALL ModificaAppuntamentoCliente('$CodApp', '$datetime', '$sconto', '$costo', '$TipoAppuntamento');";
		
 		$ok = mysql_query($query) or 
      			die ("Query Inserimento Fallita " . mysql_error());
	
	echo "Appuntamento modificato correttamente $datetime. Torna a <a href=Appuntamenti.php>Appuntamenti</a> <br><br>";
	
	};
	
	//Aggiungo Prodotti All'Appuntamento
	if (isset($addprod)){
			$queryadd = "INSERT INTO ProdApp ( CodAppuntamento, CodProdotto, Utilizzo) VALUES ('$CodApp', '$Prodotto', '$quantita');";
			$ok = mysql_query($queryadd) or 
      			die ("Query Inserimento Fallita " . mysql_error());
	
	echo "<br> Il prodotto è stato inserito correttaemente. Torna a <a href=Appuntamenti.php>Appuntamenti</a> <br>";
		};	
	

	



?>;