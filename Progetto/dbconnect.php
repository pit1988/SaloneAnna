
<?php
function dbconnect()
	{
		$conn=mysql_connect ("localhost","smarches","L8uPwhWV");
		mysql_select_db("smarches-PR")
  		or die ("Cannot select database".mysql_error());
		return $conn;
	};
?>
