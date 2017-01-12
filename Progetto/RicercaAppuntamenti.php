<body background="sfondo.jpg">
<p align="right" valign="top">/Home/Appuntamenti/RicercaAppuntamenti</p>
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



<form action="AppClienteGiorno.php" method=POST>
	<div align="left">
	<input type=checkbox name="data" value="data" checked> Per Data<br>
	<input type=checkbox name="cli" value="cli"> Per Cliente<br>
	</div>


	<table border='1'>
	<tr>
	<td><b>Dati:</b></td>
	<td><b>Data:</b></td>
	</tr>
	<tr>
	<td>	
		<i>Nome:</i><input align="right" type="text" name="nome" value=><br>
		<i>Cognome:</i><input type="text" name="cognome" value=></td>
	</td>
	<td>

<?php
 echo"
	<i>Data:</i> <input type=date name=date /><br>
	<i>Ad un ora precisa?</i><br>	
	<i>Ore: </i><input type=text name=hh>
	";
?>





</td>
</tr>
</table>
<input type=submit name=submit value=submit>
</form>

