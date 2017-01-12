<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Prodotti/ConfermaModificaProdotti</p>
<!-- Site navigation menu -->


<?php
include ("dbconnect.php");
$conn = dbconnect();

	
	
 $query="SELECT * FROM Prodotti";
	$result = mysql_query($query);
while ($row = mysql_fetch_row($result))
{	
	$submit=$_POST["submit"];
	$quantita=$_POST["quantita"];
	if(isset($_POST["ok"])){
		$prod=$_POST["ok"];
		echo" :) ";
				
		$query1="UPDATE Prodotti SET Quantita=$quantita";
		$result1= mysql_query($query1)or die (mysql_error());
		if(isset($result1)) echo " :: ";
	}
}
	
	echo "<b>Modifica avvenuta correttamente</b><br>";
	echo "<i>Vuoi modificare altri prodotti?</i>";
	echo "<form action=\"./GestioneProdotti.php\">
		 <input type=\"submit\"value=\"Si\">
		</form>";		
	
  /*else
  {
	 include("GestioneProdotti.php");
  }
  */

/*	
$query="SELECT * FROM Prodotti WHERE quantita<>$quantita";
$result = mysql_query($query);
$number_cols = mysql_num_fields($result);

for($i=0; $i<$number_cols; $i++){
$query1="UPDATE Prodotti SET Quantita=$quantita[$i]";;
$result1= mysql_query($query); // or die (mysql_error());
}
$query1="UPDATE Prodotti SET Quantita=$quantita";
$result1= mysql_query($query1);	


if (isset($submit)){
	if(isset($prod)){
	
	$query="SELECT * FROM Prodotti WHERE $prod";
	$result = mysql_query($query);
	if(isset($result)){
		$query1="UPDATE Prodotti SET Quantita=$quantita";
		$result1= mysql_query($query1)or die (mysql_error());
			}
	}
}*/

?>
