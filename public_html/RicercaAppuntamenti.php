<body background="sfondo.jpg">
	<p align="right" valign="top">/Home/Appuntamenti/RicercaAppuntamenti</p>
	<!-- Site navigation menu -->
	<table>
		<tr>
			<td>
				<ul class="navbar">
					<li><a href="index.php">Home page</a></li>
					<li><a href="Clienti.php">Clienti</a></li>
					<li><a href="Prodotti.php">Prodotti</a></li>
					<li><a href="Appuntamenti.php">Appuntamenti</a></li>
				</ul>
			</td>
			<td>
				<form action="AppClienteGiorno.php" method=POST>
					<div align="left">
						<input type=checkbox name="data" value="data" checked> Per Data<br>
						<input type=checkbox name="cli" value="cli"> Per Cliente<br>
					</div>
					<table border='1'>
						<tr>
							<td><b>Dati:</b></td>
							<td><b>Data:</b></td>
						</tr>
						<tr>
							<td>	
								<i>Nome:</i><input align="right" type="text" name="nome" value=><br>
								<i>Cognome:</i><input type="text" name="cognome" value=>
							</td>
							</td>
							<td>
								<?php
									echo 	"
										<i>Giorno:</i><input type=text size=40 name=gg value=".date('d')."><br>
										<i>Mese: </i><input type=text size=40 name=mm value=".date('m')."><br>
										<i>Anno: </i><input type=text size=40 name=yy value=".date('Y')."><br>
										<i>Ad un ora precisa?</i><br>	
										<i>Ore: </i><input type=text size=40 name=hh>
										";
									?>
							</td>
						</tr>
					</table>
					<input type=submit name=submit value=submit>
				</form>
			</td>
		</tr>
	</table>
</body>