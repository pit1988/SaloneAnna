<?php


include("dbconnect.php");
$conn = dbconnect();
	
	$submit=$_POST["submit"];
	$username=$_POST["username"];
	$password=$_POST["password"];
	$password2=$_POST["password2"];
	
	

	  if (isset($submit))
	  {
		
		if($password<>$password2){	
			
			echo "Le due password sono differenti. Torna alla <a href=\"Registrazione.php\">registrazione</a>";
					
		}
		else{
		
	    		$query = "INSERT INTO Login (user, password) values ('$username', '$password')";
	  		mysqli_query($conn, $query) or 
	      		die (mysqli_error());
			
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;

			echo"<b>Inserimento avvenuto con successo. Benvenuto $username</b><br>Vai alla <a href=\"Root.php\">Home Page</a>";
	
	
			}
		}
	else
	{
	    include("Registrazione.php");
	}
	mysqli_close($conn);
?>
