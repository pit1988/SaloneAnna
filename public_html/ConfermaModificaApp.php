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
 			$ok = mysqli_query($conn, $query) or 
      			die ("Query Inserimento Fallita " . mysqli_error());
	
	echo "Appuntamento #$CodApp cancellato correttamente. Torna a <a href=Appuntamenti.php>Appuntamenti</a> <br><br>";
	
	};
	
	
	//modifico appuntamenti
	 if (isset($submit)){
		 		$query = "CALL ModificaAppuntamentoCliente('$CodApp', '$datetime', '$sconto', '$costo', '$TipoAppuntamento');";
		
 		$ok = mysqli_query($conn, $query) or 
      			die ("Query Inserimento Fallita " . mysqi_error());
	
	echo "Appuntamento modificato correttamente $datetime. Torna a <a href=Appuntamenti.php>Appuntamenti</a> <br><br>";
	
	};
	
	//Aggiungo Prodotti All'Appuntamento
	if (isset($addprod)){
			$queryadd = "INSERT INTO ProdApp ( CodAppuntamento, CodProdotto, Utilizzo) VALUES ('$CodApp', '$Prodotto', '$quantita');";
			$ok = mysqli_query($conn,$queryadd) or 
      			die ("Query Inserimento Fallita " . mysqli_error());
	
		echo "<br> Il prodotto è stato inserito correttamente. Torna a <a href=Appuntamenti.php>Appuntamenti</a> <br>";
	};	
	
mysqli_close($conn);
	



?>;