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
				header('location:Root.php');
		}

else
		{
				print("Login invalido.");
				exit;
		}
mysqli_close($conn);
?>