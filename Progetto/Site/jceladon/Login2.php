<?php
include ("dbconnect.php");
$conn = dbconnect();
//start session
session_start();

session_regenerate_id(TRUE);

//variabili per criptare in md5 = $password=md5(( $_POST[pass]));
$username=addslashes($_POST["username"]);

$password=addslashes($_POST["password"]);

$query = "SELECT * FROM Login WHERE user='$username' AND password='$password'";

$result = mysql_query($query, $conn);

if(mysql_num_rows($result)) {

//se è loggato creo la sessione
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
header('location:Root.php');
} 

else {
  print("Login invalido.");
  exit;
}
?>


<form name="login" action="Login.php" method="POST">
<i>Username</i><br>
<input type="text" name="username" value=""><br>
<i>Password</1><br>
<input type="password" name="password" value=""><br>
<input type="submit" value="Login...">
</form>
