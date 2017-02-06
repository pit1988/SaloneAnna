<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login=authenticate();
// Controllo accesso
if (!$login) {
    header('location:errore.php?codmsg=1');
    exit;
} else {
    $title      = "Ricerca Appuntamento | Salone Anna";
    $title_meta = "Ricerca Appuntamento | Salone Anna";
    $descr      = "Pagina in cui è possibile effettuare una ricarca dell'appuntamento per data o nome del cliente";
    $keywords   = "Appuntamento, Ricerca, Nome, Cognome, Data, Ora, Dati, Appuntamento, Cliente";
    page_start($title, $title_meta, $descr, $keywords, 'caricamentoRicercaAppuntamento()');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Ricerca Appuntamento</strong>';
    insert_header($rif, 6, true);
    content_begin();
    echo "<h2>Ricerca Appuntamento</h2>";

    $str_to_print = '
<form action="AppClienteGiorno.php" onsubmit="return validazioneFormRicercaAppuntamenti();" method="post">
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
					<input type="checkbox" id="cli" name="cli" value="cli" /> <label for="cli">Per Cliente</label>
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
					<input type="checkbox" name="data" id="dataa" value="data" /> <label for="dataa">Per Data</label>
				</p>
			</li>
		</ul>
	<input type="submit" name="submit" value="Invia" />
	<span id="logError"></span>
	</fieldset>
</form>
	';
    echo $str_to_print;
    content_end();
    page_end();
}
?>