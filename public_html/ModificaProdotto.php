<body background="sfondo.jpg">
	<p align="right" valign="top">/Home/Appuntamenti/ModificaProdotto</p>
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
				<table>
					<tr>
						<th>
							<h2>Nuovo Appuntamento Clienti</h2>
						</th>
					<tr>
						<form method=post action="conferma_appuntamento.php">
						<td>
						<b>Cliente:</b>
						<i>Nome:</i><input type=text size=40 name=nome>
						</td>
						<td>
							<i>Cognome:</i><input type=text size=40 name=cognome>
						</td>
					</tr>
					<tr>
						<td>
							<b>Sconto:</b><input type=text size=40 name=sconto>
						</td>
					</tr>
					<tr>
						<td>
							<b>Tipo appuntamento:</b>
							<select name="TipoAppuntamento">
								<option value="shampoo">Shampoo</option>
								<option value="taglio">Taglio</option>
								<option value="piega e phon">Piega e Phon</option>
								<option value="piega e casco">Piega e Casco</option>
								<option value="ondulazione">Ondulazione</option>
								<option value="colore">Colore</option>
								<option value="riflessante">Riflessante</option>
								<option value="decolorazione">Decolorazione</option>
								<option value="meches">Meches</option>
								<option value="trattamenti">Trattamenti</option>
								<option value="manicure/pedicure">Manicure/Pedicure</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>Data:</b>
							<i>Giorno:</i><input type=text size=40 name=gg>
						</td>
						<td>
							<i>Mese: </i><input type=text size=40 name=mm>
						</td>
					</tr>
					<tr>		
						<td>
							<b>Orario:</b>
							<i>Ore: </i><input type=text size=40 name=hh>
						</td>
						<td>
							<i>Minuti: </i><input type=text size=40 name=min>
						</td>
					</tr>
					<tr>
						<td>
							<b>Costo:</b><input type=text size=40 name=costo>
						</td>
					</tr>
					<tr>
						<td>
							<input type=submit name=submit value="Conferma">
						</td>
						<td>
							<input type=reset name=reset value="Cancella">
						</td>
					</tr>
					</form>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

<?php
$submit = $_GET["codprod"];
?>