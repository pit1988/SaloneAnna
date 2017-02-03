<?php
require_once "library.php";
include "utils/DBlibrary.php";
$login=authenticate();
// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
}
else {
	$successo=false;
	if(isset($_REQUEST['pwd']) && isset($_REQUEST['conf'])) {
		$username=$_SESSION['username'];
		$nuovaPassword=md5($_REQUEST['pwd']);
		$l=strlen($nuovaPassword);
		$conferma=md5($_REQUEST['conf']);

		if($nuovaPassword!=$conferma) 
			$err="<p>La nuova password e la conferma devono essere uguali</p>";
		elseif($l<8)
		$err="<p>La password dev'essere di almeno 8 caratteri</p>";
		else{
			$ris=cambiaPassword($username, $nuovaPassword);
			if($ris){
				$successo=true;
				$msg="<p class=\"inforesult\">Password cambiata correttamente</p>";
			}
			else
				$err="<p id=\"logError\">Non è stato possibile cambiare la <span xml:lan=\"en\">password</span></p>";
		}
	}
	$form='
	<form id="contenitore-cambio" onsubmit="return validazioneFormCambioPassword();" action="CambioPassword.php" method="post">
		<fieldset>
			<legend>Cambio <span xml:lang="en">Password</span> </legend>
			<ul>
				<li>
					<p>
						<label for="pwd">Nuova <span lang="en">Password</span></label>
						<input type="password" name="pwd" id="pwd" tabindex="100" />
					</p>
				</li>
				<li>
					<p>
						<label for="conf" xml:lang="en">Ripeti <span lang="en">password</span></label>
						<input type="password" id="conf" name="conf" tabindex="101" />
					</p>
				</li>
				<li>
					<p>
						<input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
	                    <span id="logError"></span>
	                </p>
	            </li>
	        </ul>
		</fieldset>
	</form>
	';
	$title="Cambio password, Salone Anna";
	$title_meta="Cambio password, Salone Anna, parrucchiere a Vicenza";
	$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
	$keywords="Cambio, Password, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	page_start($title, $title_meta, $descr, $keywords, 'caricamentoCambioPassword()');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Utilita.php">Utilit&agrave;</a> / <strong>Cambio Password</strong>';

	insert_header($rif, 7, true);
	content_begin();

	if(isset($msg))
		echo $msg;
	if(!$successo){
		echo $form;
		if(isset($err))
	    	echo $err;
	}

	hyperlink("Torna alla <span lang=\"en\">home</span>","index.php");
	content_end();
	page_end();
}
?>

