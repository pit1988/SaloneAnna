<head>

<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Prodotti/ConfermaModificaProdotti</p>

</head>

<?php

include("dbconnect.php");
$conn = dbconnect();

$CodProd = $_GET['prod'];
$quantita = $_GET["quantita_".$CodProd];


echo "Il prodotto #".$CodProd." ha questa è la quantità:".$quantita."<br>";


	    $query = "UPDATE Prodotti SET Quantita=".$quantita." WHERE CodProdotto=".$CodProd ;
	  mysql_query($query) or 
	      die (mysql_error());

	echo"<b>Inserimento avvenuto con successo</b><br>Torno a <a href=\"GestioneProdotti.php\">Gestione Prodotti</a>";	

	






?>;