<?php
require_once 'library.php';
include 'utils/dbconnect.php';
if(!isset($_POST['username']) xor !isset($_POST['password'])){
    $err="Problemi di connessione";
}
elseif(isset($_POST['username']) && isset($_POST['password'])){
    $conn = dbconnect();
    session_start();
    session_regenerate_id(TRUE);
    /*		//start session
session_start();
// cambiare sessioni secondo le slide
session_regenerate_id(TRUE);*/


    //variabili per criptare in md5 = $password=md5(( $_POST[pass]));
    /*		$username = addslashes($_POST["username"]);
$password = addslashes($_POST["password"]);*/
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(isset($username) and $password == get_pwd($username)){
        $result=mysqli_query($conn, "select * from Clienti Natural Join Account l where l.username='$username'");
        $rg=mysqli_fetch_assoc($result);
        $nome=$rg['Nome'];
        $id=$rg['CodCliente'];
        if ($result->num_rows > 0){
            //se è loggato creo la sessione
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header('location:index.php');
        }
        else{
            $err="Nome utente o password errata";
        }
    }
    else
    {
        $err="Nome utente o password errata";
    }
    mysqli_close($conn);
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
<form name="login" action="login.php" method="POST">
<p><i>Username</i></p>
<p><input type="text" name="username" value=""></p>
<p><i>Password</i></p>
<p><input type="password" name="password" value=""></p>
<p><input type="submit" value="Login..."></p>
</form>
END;
if(isset($err))
    echo"<BR><b>Errore: $err</b>";
page_end();
?> 