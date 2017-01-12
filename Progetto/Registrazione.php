<?php

session_start();

session_regenerate_id(TRUE);

// Controllo accesso

if (!isset($_SESSION['username'] ) )
{
echo"<h2>Registrati</h2>
<form method=post action=\"ConfermaRegistrazione.php\">

Inserisci i tuoi dati per poter registrarti sul Salone Anna :

<table>
<td><i>Username:</i><input type=text size=40 name=username></td>
<td><i>Password:</i><input type=password size=40 name=password></td>
<td><i>Conferma Password:</i><input type=password size=40 name=password2></td>
<td><input type=submit name=submit value=Conferma></td>
</table>


</form>";
}
else
{


header('location:Root.php');
exit;
}
?>
