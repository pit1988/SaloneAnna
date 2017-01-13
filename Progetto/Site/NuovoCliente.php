<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Clienti/NuovoCliente</p>
<!-- Site navigation menu -->
<table>
	<tr>
		<td>
			<ul class="navbar">
			  <li><a href="Root.php">Home page</a></li>
			  <li><a href="Clienti.php">Clienti</a></li>
			  <li><a href="Prodotti.php">Prodotti</a></li>
			  <li><a href="Appuntamenti.php">Appuntamenti</a></li>
			</ul>
		</td>
	</tr>
	<tr>
	<td>
<?php

session_start();

session_regenerate_id(TRUE);

// Controllo accesso

if (!isset($_SESSION['username']))
		{
				header('location:Accesso.php');
				exit;
		}
else
		{
				echo "Benvenuto " . $_SESSION['username'];
				
				echo "<h2>Nuovo Cliente</h2>
<form method=post action=\"conferma_inserimento.php\">

<table>
<tr>
	<td><i>Nome:</i></td><td><input type=text size=40 name=name></td>
	<td><i>Cognome:</i><input type=text size=40 name=surname></td>
</tr>

<tr>
	<td><i>Telefono:</i></td><td><input type=text size=40 name=tel></td><td></td>
</tr>

<tr>
	<td><i>Mail:</i></td><td><input type=text size=40 name=mail><i>@</i></td><td><input type=text size=40 name=dominio></td>
</tr>

<tr>
<td><i>Compleanno:</td>
</tr>
<tr>
<td> Giorno: </i></td><td><input type=text size=40 name=gg <i></td><td> Mese: </i><input type=text size=40 name=mm> </td>
</tr>

<tr>
	<td><input type=submit name=\"submit\" value=\"conferma\"></td>
	<td><input type=reset name=\"reset\" value=\"cancella\"></td>
</tr>

</form>";
		}
?>
			</td>
		</tr>
	</table>
</body>