
<?php
require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login )
{
	header('location:index.php');
	exit;
}
else
{	
	if(isset($_POST['submit'])) {
	    $num=0;
	    if(isset($_POST['Ids'])) {
		    $ids=$_POST['Ids'];
		    foreach($ids as $d){
		    $ris=eliminaCliente($d);
		      if($ris)
		      	++$num;
		    unset($ris);
		    }
		}
	    if($num==0)
	    	$msg="<p>Non sono stati cancellati clienti </p>";
	    if($num==1)
	    	$msg="<p>È stato cancellato $num cliente </p>";
	    if($num>1)
	    	$msg="<p>Sono stati cancellati $num clienti </p>";
	}
	
	$title="Elimina Clienti | Salone Anna";
	$title_meta="Elimina Clienti | Salone Anna";
	$descr="Elimina il cliente e verrà segnalato il successo o il fallimento in questa pagina";
	$keywords="Elimina, Clienti, Nome, Cognome, Telefono, Email, Mail, Data";
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Elimina clienti</strong>';
	insert_header($rif, 5, true);
	content_begin();
	echo "<h2>Elimina Cliente</h2>";
	$ris=listaClienti();
	if($ris){
		$str_to_print='
		<form action="EliminaCliente.php" method="post">
		<fieldset>
		<legend>Selezione i clienti che vuoi eliminare</legend>
		<table id="clientiTabSelect" summary="Rimozione clienti">
            <caption class="nascosto">Rimozione clienti</caption>
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
					<td class=\"tdin\"><input type='checkbox' name='Ids[]' value=\"".$cliente->codice."\"/></td>
				</tr>";
		}
		$str_to_print.="
		</tbody></table>
		<input type='submit' name='submit' value='Procedi'/>
		<input type='reset' value='Cancella'/>
		</fieldset></form>
		";
		unset($cliente); //fortemente consigliato perché altrimenti l'oggetto $cliente rimane in memoria
	}
	else 
		$str_to_print="<p class=\"inforesult\">Non sono presenti clienti da poter cancellare</p>";
	
	unset($ris);

	if(isset($msg))
		echo $msg;
	echo $str_to_print;
	content_end();
	page_end();
}

?>

