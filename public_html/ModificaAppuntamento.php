<body background="sfondo.jpg">
	<p align="right" valign="top">/Home/Appuntamenti/ModificaAppuntamento</p>
	<body background="sfondo.jpg">
		<p align="right" valign="top">/Home/Appuntamenti/ModificaAppuntamento</p>
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

        
<?php

include("DBlibrary.php");
$conn = dbconnect();

$CodApp  = $_GET['CodApp'];
$nome    = $_GET["nome" . $CodApp];
$cognome = $_GET["cognome" . $CodApp];

echo "<h3>Appuntamento #$CodApp di $nome $cognome :</h3><br>";

$query = "
    		SELECT s.DataOra, p.Nome as NomeProdotto, s.Utilizzo, a.Costo as CostoAppuntamento, ap.Sconto, ap.TipoAppuntamento
			FROM Appuntamenti a NATURAL JOIN AppuntamentiClienti ap NATURAL JOIN storico s NATURAL JOIN Prodotti p
			WHERE s.Codappuntamento=" . $CodApp . "
			ORDER BY s.CodAppuntamento;";

echo "<i>Modifica gli appuntamenti:</i>";
$result      = mysqli_query($conn, $query);
$number_cols = mysqli_num_fields($result);

echo "<table border = 1>\n";
echo "<tr align=center>\n";
//intestazione tabella		
for ($i = 0; $i < $number_cols; $i++)
		{
				echo "<th>" . mysqli_field_seek($result, $i) . "</th>\n";
		}
echo "</tr>\n";

//corpo tabella
while ($row = mysqli_fetch_row($result))
		{
				echo "<tr align=left>\n";
				for ($i = 0; $i < $number_cols; $i++)
						{
								echo "<td>";
								if (!isset($row[$i]))
												echo " ";
								else
												echo $row[$i];
								echo "</td>\n";
						}
				echo "</tr>\n";
		}
$intes = mysqli_fetch_row($result);

echo "
						<form method=POST action=\"ConfermaModificaApp.php\">
						<tr align=left>
						<td><input type=datetime name=datetime placeholder=\"AAAA-MM-GG hh:mm:ss\"></td>
						<td><b><i>Modifica Costo:</i></b></td>
						<td><input type=text name=costo placeholder=\"Costo Appuntamento €\"></td> 
						<td><b><i>Modifica Sconto:</i></b></td>
						<td><input type=text name=sconto placeholder=\"Sconto Appuntamento €\"></td>
						<td><select name=TipoAppuntamento>
							<option value=shampoo>Shampoo</option>
							<option value=taglio>Taglio</option>
							<option value=piega e phon>Piega e Phon</option>
							<option value=piega e casco>Piega e Casco</option>
							<option value=ondulazione>Ondulazione</option>
							<option value=colore>Colore</option>
							<option value=riflessante>Riflessante</option>
							<option value=decolorazione>Decolorazione</option>
							<option value=meches>Meches</option>
							<option value=trattamenti>Trattamenti</option>
							<option value=manicure/pedicure>Manicure/Pedicure</option>
							</select>
						</td>
						</tr>
							<input type=submit name=modapp value=\"Modifica Appuntamento\" >
						</form>
					</table>";
echo $intes;

//Inserisci Nuovo Prodotto
echo "<br><i>Aggiungi Prodotto:</i>  ";
$queryp  = "
    	SELECT p.CodProdotto, p.Nome FROM Prodotti p WHERE p.Tipo='In Salon Service' AND p.Quantita is not NULL AND p.Quantita>0 ";
$resultp = mysqli_query($conn, $queryp);


$number_cols = mysqli_num_fields($resultp);
echo "<form method=get action=\"ConfermaModificaApp.php\">
	<input type=\"hidden\" name=codapp value=" . $CodApp . ">
	<select name=Prodotto>";
//corpo tabella
while ($row = mysqli_fetch_row($resultp))
		{
				for ($i = 0; $i < $number_cols; $i++)
						{
								if (!isset($row[$i]))
												echo " ";
								echo "<option value=" . $row[0] . ">$row[1]</option>";
						}
		}

echo "</select> Quantità di prodotto :<input type=text name=newquantita>
		<input type=submit name=addprod value=\"Aggiungi Prodotto\" ><br>";


echo "<br><i>Vuoi cancellare questo appuntamento?</i><input type=submit name=delapp value=\"Cancella\" ></form>
	<br>Torna a <a href=\"RicercaAppuntamenti.php\">Ricerca Appuntamenti</a>";

mysqli_close($conn);
?>;
				</td>
			</tr>
		</table>
</body>

