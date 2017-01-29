
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
	include 'utils/DBlibrary.php';

	if(isset($_POST['submit'])) {
	    $num=0;
	    if(isset($_POST['Ids'])) {
		    $ids=$_POST['Ids'];
		    foreach($ids as $d){
		      $ris=eliminaCliente($d);
		      if($ris)
		      	++$num;
		    }
		}
	    if($num==0)
	    	$msg="<p>Non sono stati cancellati clienti </p>";
	    if($num==1)
	    	$msg="<p>È stato cancellato $num cliente </p>";
	    if($num>1)
	    	$msg="<p>Sono stati cancellati $num clienti </p>";
	}
	
	$title="Elenco clienti: Salone Anna";
	$title_meta="Elenco clienti: Salone Anna";
	$descr="";
	$keywords="Elenco, Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Elenco clienti</strong>';
	insert_header($rif, 5, true);
	content_begin();
	$ris=listaClienti();
	if($ris){
		$str_to_print='<form action="ModificaCliente.php" method="POST">
		<table id="clientiTab" summary="Elenco clienti">
            <caption>Elenco clienti</caption>
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
				<td>".$cliente->codice."</td><td>".$cliente->nome."</td><td>".$cliente->cognome."</td><td>".$cliente->telefono."</a></td><td>".$cliente->email."</td><td>".$cliente->dataNascita."</td><td><input type='checkbox' name='codCliente' value=$cliente->codice></td>
				</tr>";
		}
		$str_to_print.="
		</tbody></table>
		<input type='submit' name='submit' value='Procedi' />
		<input type='reset' value='Cancella' />
		</form>
		";
                    // echo"</fieldset>";
		unset($cliente); //fortemente consigliato perché altrimenti l'oggetto $cliente rimane in memoria
	}
	else 
		$str_to_print="<p>Non sono presenti clienti nell'elenco</p>";
	if(isset($msg))
		echo $msg;
	echo $str_to_print;
	content_end();
	page_end();
}

?>

