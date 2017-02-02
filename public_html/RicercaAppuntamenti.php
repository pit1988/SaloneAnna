<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login=authenticate();
// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    $title      = "Ricerca Appuntamento: Salone Anna";
    $title_meta = "Ricerca Appuntamento: Salone Anna";
    $descr      = "";
    $keywords   = "Appuntamento, Ricerca, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Ricerca Appuntamento</strong>';
    insert_header($rif, 6, true);
    content_begin();
    echo "<h2>Ricerca Appuntamento</h2>";

    $str_to_print = '
<form action="AppClienteGiorno.php" method="post">
	<fieldset class="inputsL">
		<legend>Ricerca tramite dati cliente:</legend>
		<ul>
			<li>
				<p>
					<label for="first_name">Nome</label>
					<input type="text" name="first_name" id="first_name" tabindex="100"/>
				</p>
				<p>
					<label for="last_name">Cognome</label>
					<input type="text" name="last_name" id="last_name" tabindex="101" />
				</p>
			</li>
			<li>
				<p>
					<input type="checkbox" name="cli" value="cli" /> Per Cliente
				</p>
			</li>
		</ul>
	</fieldset>
	<fieldset class="inputsR">
		<legend>Ricerca tramite data appuntamento:</legend>
		<ul>
			<li>
				<p>
					<label for="date">Data</label>
					<input type="text" name="date" id="date" tabindex="104" />
				</p>
			</li>
			<li>
				<p>
					<label for="orario">Ad un ora precisa?</label>
					<input type="text" name="orario" id="orario" tabindex="102" />
				</p>
			</li>
			<li>
				<p>
					<input type="checkbox" name="data" value="data" /> Per Data
				</p>
			</li>
		</ul>
	<input type="submit" name="submit" value="Invia" />
	</fieldset>
</form>
	';
    echo $str_to_print;
    content_end();
    page_end();
}
?>