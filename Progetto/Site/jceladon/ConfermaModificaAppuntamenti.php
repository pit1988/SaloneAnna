<HTLM>
<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Prodotti/ConfermaModificaAppuntamenti</p>
<!-- Site navigation menu -->


<?php
include ("dbconnect.php");
$conn = dbconnect();

	$submit=$_POST["submit"];
	$DataOra=$_POST["DataOra"];
	//echo" il valore cambiato e $DataOra";
	 if (isset($submit)){
		if(isset($DataOra)){
			$query="SELECT * FROM Appuntamenti";
			$result = mysql_query($query);
			if(isset($result)){
				$query1="UPDATE Appuntamenti SET DataOra=$DataOra";
				$result1= mysql_query($query1)or die (mysql_error());
			}
		}
	}
		
		echo "<b>Modifica avvenuta correttamente</b><br>";
		echo "<i>Vuoi modificare altri appuntamenti?</i>";
		echo "<form action=\"./GestioneAppuntamenti.php\" target=\"_blank\">
			  <input type=\"submit\"value=\"Si\">
			</form>";		
	
?>
</HTLM>
