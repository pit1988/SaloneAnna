<?php
require_once '../library.php';

include 'dbconnect.php';
if(!isset($_POST['username']) xor !isset($_POST['password'])){
    $err="Problemi di connessione";
}
elseif(isset($_POST['username']) && isset($_POST['password'])){
    $conn = dbconnect();
    session_start();
    session_regenerate_id(TRUE);


$username = addslashes($_POST["username"]); 
$password = md5(addslashes($_POST["password"]));
echo $username. " ".addslashes($_POST["password"]). " ".$password;
$query = "SELECT * FROM Account WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($result);

if ($num_rows > 0) { //se il risultato è stato trovato, ovvero se non è stato restituito un risultato vuoto
	//se è loggato creo la sessione
	session_start(); //inizia la sessione
	session_regenerate_id(TRUE); //cambia l'ID della sessione, è una tecnica di sicurezza da inserire dopo la creazione dell'ID
	$_SESSION['username'] = $username; //salvo i dati
	$_SESSION['password'] = $password;
	$_SESSION['LAST_ACTIVITY'] = time(); //salvo l'ultima attività
	header('location:../index.php'); //carica la pagina index.php, inoltre se ci sono errori di header questo comando li aggira
}
else{
            $err="Nome utente o password errata";
        }
mysqli_close($conn); //chiude la connessione con il db
};
$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="Ti trovi in: <strong xml:lang=&quot;en&quot;>Home</strong>";
$is_admin=false;
insert_header($rif, 0, $is_admin);
echo<<<END
<div id="content">
<form id="contenitore-login" name="login" action="login.php" method="POST">
<p><i>Username</i></p>
<p><input id="inputUsername" type="text" name="username" value="" tabindex="100" accesskey="u"></p>
<p><i>Password</i></p>
<p><input id="inputPassword" type="password" name="password" value="" tabindex="101" accesskey="p"></p>
<p><input id="accedi" type="submit" value="Login..." tabindex="102" accesskey="s"></p>
</form>
</div>
END;
if(isset($err))
    echo"<BR><b>Errore: $err</b>";
page_end();
?>
