<?php
require_once "library.php";
include "utils/DBlibrary.php";
$login=authenticate();
// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
	if(isset($_POST['submit']) &&  ) {
      
		$nuovaPassword=SHA1($_POST['pwd']);
		$l=strlen($_POST['pwd']);
		$conferma=SHA1($_POST['conf']);

		$ris=cambiaPassword($username, $nuovaPassword) 
		if($pwd!=$conferma) 
			$err="<p>La nuova password e la conferma devono essere uguali</p>";
		elseif($l<8)
		$err="<p>La password dev'essere di almeno 8 caratteri</p>";
		else{
			$ris=cambiaPassword($username, $nuovaPassword);
			if($ris)
				$msg="<p>Password cambiata correttamente</p>";
			else
				$err="<p>Non è stato possibile cambiare la <span xml:lan=\"en\">password</span></p>"
		}
	}
	$title="Cambio password, Salone Anna";
	$title_meta="Cambio password, Salone Anna, parrucchiere a Vicenza";
	$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
	$keywords="Cambio, Password, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	page_start($title, $title_meta, $descr, $keywords, '');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <a href="Utilita.php">Utilit&agrave;</a> / <strong>Cambio Password</strong>';

	insert_header($rif, 0, true);
	content_begin();
		echo<<<END
	<form id="contenitore-login" action="login.php" method="post">
		<fieldset>
			<legend>Inserisci i dati per accedere alla parte amministratore</legend>
			<ul>
				<li>
					<p>
						<label for="pwd">Nuova <span lang=\"en\">Password</span></label>
						<input type="password" name="pwd" id="pwd" tabindex="100" />
					</p>
				</li>
				<li>
					<p>
						<label for="conf" xml:lang="en">Conferma <span lang=\"en\">password</span></label>
						<input type="password" id="conf" name="conf" tabindex="101" />
					</p>
				</li>
				<li>
					<p>
						<input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
	                    <span id="errors"></span>
	                </p>
	            </li>
	        </ul>
		</fieldset>
	</form>
END;
	}
	else
		hyperlink("Vai alla <span lang=\"en\">home</span>","index.php");
	if(isset($err))
	    echo $err;
	if(isset($msg))
		echo $msg;
	content_end();
	page_end();
}











?>

