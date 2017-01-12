
<?php
function dbconnect()
	{
		$conn=mysql_connect ("localhost","jceladon","XSioyQG4");
		mysql_select_db("jceladon-PR") or die ("Cannot select database".mysql_error());
		return $conn;
	};
?>
