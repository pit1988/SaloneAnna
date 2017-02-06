<?php
require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:errore.php?codmsg=1');
    exit;
} 
else {
    if (isset($_POST['submit']) && isset($_POST['codMsg'])) {
        $ids   = $_POST['codMsg'];
        $n_el  = 0;
        $n_err = 0;
        foreach ($ids as $codice) {
            $ris = eliminaMessaggio($codice);
            if ($ris)
                ++$n_el;
            else
                ++$n_err;
            unset($ris);
        }
        
        if ($n_el > 0)
            if ($n_el == 1)
                $msg = "<p class=\"inforesult\">È stato cancellato $n_el messaggio</p>";
            else
                $msg = "<p class=\"inforesult\">Sono stati cancellati $n_el messaggi</p>";
        if ($n_err > 0)
            $msg = "<p class=\"errorSuggestion\">Durante la cancellazione si sono verificati $n_err errori</p>";
    }
    
    $title      = "Elimina Messaggi | Salone Anna";
    $title_meta = "Elimina Messaggi | Salone Anna";
    $descr      = "Elimina i messaggi e verrà segnalato il successo o il fallimento in questa pagina";
    $keywords   = "Messaggi, Elimina, Nome, Cognome, Messaggio, Data, Ora";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Utilita.php">Utilit&agrave;</a> / <a href="Messaggi.php">Messaggi</a> / <strong>Elimina Messaggi</strong>';
    insert_header($rif, 7, true);
    content_begin();
    echo "<h2>Gestione Messaggi</h2>";
    $ris = listamessaggi();
    if ($ris) {
        $str_to_print = '
    <form action="EliminaMessaggi.php" method="post">
        <fieldset>
        <legend>Seleziona un messaggio da eliminare</legend>
            <table id="messaggi" summary="Messaggi">
            <caption>Tabella messaggi</caption>
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Messaggio</th>
                    <th scope="col">Data</th>
                    <th scope="col">Ora</th>
                    <th scope="col">Seleziona</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($ris as $messaggio) {
            if ($messaggio->daLeggere == true)
                $str_to_print .= "
				<tr>
					<td><strong>" . $messaggio->nome . "</strong></td><td><strong>" . $messaggio->cognome . "</strong></td>
                    <td><strong><a href=\"MostraMessaggio.php?codmsg=" . $messaggio->codice . " \">" . (strlen($messaggio->contenuto) > 60 ? substr($messaggio->contenuto, 0, 60) . "..." : $messaggio->contenuto) . "</a></strong></td>
                    <td>" . $messaggio->data . "</td>
                    <td>" . $messaggio->ora . "</td>
                    <td class=\"tdin\"><input type=\"checkbox\" name=\"codMsg[]\" id= \"cm" . $messaggio->codice . "\" value= \"" . $messaggio->codice . "\"/><label for= \"cm" . $messaggio->codice . "\">Seleziona</label></td>
				</tr>";
            else
                $str_to_print .= "
                <tr>
                    <td>" . $messaggio->nome . "</td>
                    <td>" . $messaggio->cognome . "</td>
                    <td><a href=\"MostraMessaggio.php?codmsg=" . $messaggio->codice . " \">" . (strlen($messaggio->contenuto) > 60 ? substr($messaggio->contenuto, 0, 60) . "..." : $messaggio->contenuto) . "</a></td>
                    <td>" . $messaggio->data . "</td>
                    <td>" . $messaggio->ora . "</td>
                    <td class=\"tdin\"><input type=\"checkbox\" name=\"codMsg[]\" id= \"cm" . $messaggio->codice . "\" value= \"" . $messaggio->codice . "\"/><label for= \"cm" . $messaggio->codice . "\">Seleziona</label></td>
                </tr>";
        }
        $str_to_print .= "</tbody></table>
		<input type='submit' name='submit' value='Procedi'/>
		<input type='reset' value='Cancella'/>
		</fieldset>
		</form>";
        unset($messaggio); //fortemente consigliato perché altrimenti l'oggetto $messaggio rimane in memoria
    } 
    else
        $str_to_print = "<p class=\"inforesult\">Non sono presenti messaggi</p>";
    unset($ris);
    if (isset($msg))
        echo $msg;
    echo $str_to_print;
    content_end();
    page_end();
}

?>