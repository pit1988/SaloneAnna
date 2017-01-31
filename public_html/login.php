<?php
require_once "library.php";
include "utils/DBlibrary.php";

if (isset($_SESSION['username'] ) )
  {
    header('location:index.php');
    exit;
  }

$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="<strong xml:lang=&quot;en&quot;>Home</strong>";





$is_logged=false;

if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
    $password = md5($password);
	$conn = dbconnect();
	$query = "SELECT * FROM Account WHERE username='$username' AND password='$password'";
	$result = $conn->query($query);
	
	if ($result->num_rows > 0) { //se il risultato è stato trovato, ovvero se non è stato restituito un risultato vuoto
		session_start(); //inizia la sessione
		session_regenerate_id(TRUE); //cambia l'ID della sessione, è una tecnica di sicurezza da inserire dopo la creazione dell'ID
		$_SESSION['username'] = $username; //salvo i dati
		$_SESSION['password'] = $password;
		$_SESSION['creazione'] = time(); //salvo l'ultima attività
		// header('location:index.php'); //carica la pagina index.php, inoltre se ci sono errori di header questo comando li aggira
		$msg="<p class=\"inforesult\">Accesso eseguito con successo</p>";
		
		$is_logged=true;
	}
	else {
		$err="<p class=\"errorSuggestion\">Nome utente o password errata</p>";
	}
	mysqli_close($conn); //chiude la connessione con il db
}

insert_header($rif, 0, $is_logged);
content_begin();

if(!$is_logged) { 
	if(isset($_POST['submit']) && (!isset($_REQUEST['username']) || !isset($_REQUEST['password']))) {
		$err="Problemi di connessione";
	}

	echo<<<END
<form id="contenitore-login" name="login" action="login.php" method="post">
<p><i>Username</i></p>
<p><input id="inputUsername" type="text" name="username" value="" tabindex="100" accesskey="u"></p>
<p><i>Password</i></p>
<p><input id="inputPassword" type="password" name="password" value="" tabindex="101" accesskey="p"></p>
<p><input id="accedi" name="submit" type="submit" value="Login..." tabindex="102" accesskey="s"></p>
</form>
END;
}
else
	hyperlink("Vai alla <span lang=\"en\">home</span>","index.php");
if(isset($err))
    echo"<strong id=\"logError\">Errore: $err</strong>";
if(isset($msg))
	echo $msg;
content_end();
page_end();
?>
