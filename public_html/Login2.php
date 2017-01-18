<?php
include("dbconnect.php");
$conn = dbconnect();
//start session
session_start();
// cambiare sessioni secondo le slide
session_regenerate_id(TRUE);

//variabili per criptare in md5 = $password=md5(( $_POST[pass]));
$username = addslashes($_POST["username"]);

$password = addslashes($_POST["password"]);

$query = "SELECT * FROM Login WHERE user='$username' AND password='$password'";

$result = $conn->query($query);

if ($result->num_rows > 0)
		{
				
				//se è loggato creo la sessione
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password;
				header('location:index.php');
		}

else
		{
				print("Login invalido.");
				exit;
		}
mysqli_close($conn);
?>


<form name="login" action="Login.php" method="POST">
	<p><i>Username</i></p>
	<p><input type="text" name="username" value=""></p>
	<p><i>Password</i></p>
	<p><input type="password" name="password" value=""></p>
	<p><input type="submit" value="Login..."></p>
</form>
