
<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Prodotti</p>



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
echo "Benvenuto ".$_SESSION['username']." sei in Prodotti <br>";
echo "<table>
	<tr>
		<form action=\"ProdottiQuery.php\">
  		<input type=\"submit\"value=\"Prodotti in esaurimento\">
		</form>
	</tr>
	<tr>
	<form action=\"ProdottiMax.php\">
  		<input type=\"submit\"value=\"Maggior numero Prodotti Usati\">
		</form>
	</tr>
	<tr>
	<form action=\"GestioneProdotti.php\">
  		<input type=\"submit\"value=\"Gestione Prodotti\">
		</form>
	</tr>
	";


}


?>

</td>
