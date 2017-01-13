<body background="sfondo.jpg">
	<p align="right" valign="top">/Home/Appuntamenti/ConfermaAppuntamento</p>
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
					
					
					  include("dbconnect.php");
					  $conn = dbconnect();
						$submit=$_POST["submit"];
						$name=$_POST["name"];
						$surname=$_POST["surname"];
						$tel=$_POST["tel"];
						
						$mail=$_POST["mail"];
						$dominio=$_POST["dominio"];
						$mail=$mail."@".$dominio;
						
						$gg=$_POST["gg"];
						$mm=$_POST["mm"];
						if($mm<=date('m') && $gg<=date('d')) 
						$yyyy = date('Y')+1;
						else
						$yyyy = date('Y');
						$compl = $yyyy."-".$mm."-".$gg;
						
					
						  if (isset($submit))
						  {
						    $query = "INSERT INTO Clienti (Nome, Cognome, Telefono, Email, Compleanno) values
							      ('$name', '$surname', '$tel', '$mail', '$compl')"
						  ;
						  mysqli_query($conn, $query) or 
						      die (mysqli_error());
					
						echo"<b>Inserimento avvenuto con successo</b><br>";
						echo"<i>Vuoi inserire un appuntamento per $name $surname?</i>";
					
						echo"
						<form action=\"./NuovoAppuntamento.php\" target=\"_blank\">
						  <input type=\"submit\"value=\"Si\">
						</form>";
					
						}
						else
						{
						    include("NuovoCliente.php");
						}
						mysqli_close($conn);
					}
					?>
			</td>
		</tr>
	</table>
</body>