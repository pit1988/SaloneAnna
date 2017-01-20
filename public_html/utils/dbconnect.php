<?php
function dbconnect()
	{
		$host = "localhost";
		$user = "pgabelli";
		$pass = "bi9UJ9ohCoochei7";
		$db = "pgabelli";
		$conn=new mysqli($host, $user, $pass, $db);
		if($conn -> connect_errno)
			echo "Connessione fallita(".$conn -> connect_errno."): ".$conn -> connect_error;
		return $conn;
	};
?>
