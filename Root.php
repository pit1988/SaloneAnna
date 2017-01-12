<body background="sfondo.jpg">
<p align="right" valign="top">/Home</p>
<!-- Site navigation menu -->
<ul class="navbar">
  <li><a href="Root.php">Home page</a>
  <li><a href="NuovoCliente.php">Clienti</a>
  <li><a href="ProdottiQuery">Prodotti</a>
  <li><a href="NuovoAppuntamento">Appuntamenti</a>
</ul>


<?php

session_start();

session_regenerate_id(TRUE);

// Controllo accesso

if (!isset($_SESSION['username'] ) )
{
header('location:Accesso.php');
exit;
}
else
{
echo "Benvenuto ".$_SESSION['username'];


}


?>
