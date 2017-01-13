<html>
	<head>
		<title> PaginaLogin </title>
	</head>

	<body>

<?php

echo '<form method="post" action="session-auth.php">' . "Login: " . '<input type="text"     name="login">' . "Password: " . '<input type="password" name="password"
                 maxlength="8">
<input type="submit" value="Vai">' . "Devi " . '<a href="session-auth-register.php">registrarti</a>
</form>';

/* recupera i dati immessi */
$login    = $_POST['login'];
$password = $_POST['password'];
/* verifica se login e' valido e recupera la password */
$db_pwd   = get_pwd($login);
if ($db_pwd && (SHA1($password) == $db_pwd)) {
	/* se login e' valido e la password e' corretta ...
	registra i dati nella sessione */
	session_start();
	$_SESSION['login'] = $login;
		
}
else {
	/* se login e' invalido o la password e' incorretta, rimanda
	alla pagina di login */
	;
}
;

?>

	</body>
</html>
