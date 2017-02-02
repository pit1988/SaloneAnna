<?php
require 'library.php';
require 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login )
{
	header('location:index.php');
	exit;
}
else
{	
	$title="Modifica cliente: Salone Anna";
	$title_meta="Modifica cliente: Salone Anna";
	$descr="";
	$keywords="Modifica, Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Modifica cliente</strong>';
	insert_header($rif, 5, true);
	content_begin();
	echo "<h2>Modifica cliente</h2>";

	$ris=listaClienti();
	if($ris){
		$str_to_print='
		<form action="ModificaCliente.php" method="post">
        <fieldset>
        <legend>Seleziona il cliente per poterlo modificare</legend>
		<table id="clientiTabSelect" summary="Elenco clienti">
            <caption class="inforesult">Elenco clienti</caption>
            <thead>
                <tr>
                	<th scope="col">Codice</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Telefono</th>
                    <th scope="col" xml:lang="en">E-mail</th>
                    <th scope="col">Data nascita</th>
                    <th scope="col">Selezione</th>
                </tr>
            </thead>
            <tbody>';
		foreach ($ris as $cliente) {
				$str_to_print.= "<tr>
				<td>".$cliente->codice."</td>
				<td>".$cliente->nome."</td>
				<td>".$cliente->cognome."</td>
				<td>".$cliente->telefono."</td>
				<td>".$cliente->email."</td>
				<td>".$cliente->dataNascita."</td>
				<td class=\"tdin\"><input type=\"radio\" name=\"codCliente\" value=\"".$cliente->codice."\"/></td>
				</tr>";
		}
		$str_to_print.="
				</tbody></table>
				<input type='submit' name='submit' value='Procedi' />
				<input type='reset' value='Cancella' />
			</fieldset>
		</form>
		";
		unset($cliente); //fortemente consigliato perché altrimenti l'oggetto $cliente rimane in memoria
	}
	else 
		$str_to_print="<p class=\"inforesult\">Non sono presenti clienti nell'elenco</p>";

	unset($ris);
	
	if(isset($msg))
		echo $msg;
	echo $str_to_print;
	content_end();
	page_end();
}

?>

