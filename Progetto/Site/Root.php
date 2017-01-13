<body background="sfondo.jpg">
	<p align="right" valign="top">/Home</p>
	<!-- Site navigation menu -->
	<table>
		<tr>
			<td>
				<ul class="navbar">
					<li><a href="Root.php">Home page</a></li>
					<li><a href="Clienti.php">Clienti</a></li>
					<li><a href="Prodotti.php">Prodotti</a></li>
					<li><a href="Appuntamenti.php">Appuntamenti</a></li>
				</ul>
			</td>
			<td>
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
			</td>
			<img valign= "center" align= "center" src="parrucchiera.jpg" >
		</tr>
	</table>
</body>