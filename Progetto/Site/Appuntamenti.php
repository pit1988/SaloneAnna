<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Appuntamenti</p>
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
echo "Benvenuto ".$_SESSION['username']." sei in Appuntamenti <br>";
echo "<table>
	<tr>
		<form action=\"NuovoAppuntamento.php\">
  		<input type=\"submit\"value=\"Nuovo Appuntamento\">
		</form>
	<tr>
	<tr>
	<form action=\"Toptype.php\">
  		<input type=\"submit\"value=\"Tipo Appuntamento Frequente\">
		</form>
	</tr>
	<tr>
	<form action=\"RicercaAppuntamenti.php\">
  		<input type=\"submit\"value=\"Ricerca Appuntamenti\">
		</form>
	</tr>
	";


}


?>
