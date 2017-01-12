
<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Clienti</p>
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
echo "Benvenuto ".$_SESSION['username']." sei in Clienti <br>";
echo "<table>
	<tr>
		<form action=\"QueryCompleanno.php\">
  		<input type=\"submit\"value=\"Compleanni Questo Mese\">
		</form>
		<br>
	</tr>
	<tr>
		<form action=\"NuovoCliente.php\">
  		<input type=\"submit\"value=\"Nuovo Cliente\">
		</form>
	</tr>
	<tr>
		<form method=post action=\"StoricoProd.php\">
		<td><input type=submit name=submit value=\"Storico Prodotti\"></td>
		<td>Nome:<input type=text name=nome></td>
		<td>Cognome:<input type=text name=cognome></td>
		</from>
	</tr>
	</table>
	";


}


?>

</td>
</table>
