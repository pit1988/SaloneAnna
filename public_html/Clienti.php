
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'] ) )
{
	header('location:index.php');
	exit;
}
else
{
	require 'library.php';
	$title="Clienti: Salone Anna";
	$title_meta="Clienti: Salone Anna";
	$descr="";
	$keywords="Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Clienti</strong>';
	insert_header($rif, 1, true);
	content_begin();
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
	content_end();
	page_end();
}

?>

