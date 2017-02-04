<?php
require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:errore.php?codmsg=1');
    exit;
} else {
    $title      = "Modifica Appuntamento | Salone Anna";
    $title_meta = "Modifica Appuntamento | Salone Anna";
    $descr      = "Pagina che permette di modificare i dati per correggere un appuntamento inserito";
    $keywords   = "Modifica, Appuntamento, Tipo, Nome, Cognome, Data, Ora, Conferma, Correggi";
    
    page_start($title, $title_meta, $descr, $keywords, 'caricamentoAppuntamento()');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="ScegliAppuntamento.php">Modifica Appuntamento</a> / <strong>Inserisci valori</strong>';
    insert_header($rif, 6, true);
    content_begin();
    echo "<h2>Modifica Appuntamento</h2>";

    
    if (!isset($_POST['submit']) OR !isset($_POST['codapp'])) {
        echo "<p class=\"errorSuggestion\">Problemi di connessione; <a href=\"ScegliAppuntamento.php\">segui il link per selezionare un altro appuntamento da modificare</a></p>";
    } else {
        $cod=$_POST['codapp'];
        $result = mostraAppuntamento($cod);
        // nessun risultato
        if (!$result)
            echo "<p class=\"errorSuggestion\">L'appuntamento richiesto non è prensente nel database</p>";
        else {
            //aggiungere tabindex;
            $str1 = '<form action="ConfermaModificaAppuntamento.php" onsubmit="return validazioneFormAppuntamento();" method="post">
            <fieldset><legend>Modifica i dati per correggere l\'appuntamento</legend>
               <div class="tipiAppun">
                        <p class="info">Tipo appuntamento:</p>
';
            
            $str2 = "";
            $res= listaTipoAppuntamenti();
            if(!is_null($res)){
                foreach ($res as $tipoApp){
                    if(($tipoApp->nome)  == ($result->tipo))
                        $str2 .= '<p class="tipoAppun"><input type="radio" name="TipoAppuntamento" id="t'.$tipoApp->codice.'" value="' . $tipoApp->codice . '" checked="checked" /><label for="t'.$tipoApp->codice.'">'.$tipoApp->nome."</label></p>";
                    else
                        $str2 .= '<p class="tipoAppun"><input type="radio" name="TipoAppuntamento" id="t'.$tipoApp->codice.'" value="' . $tipoApp->codice . '" /><label for="t'.$tipoApp->codice.'">'.$tipoApp->nome."</label></p>";
                }
            }
            unset($res);
            $str3 = '</div>
                        <div class="datiAppun">
                            <p>
                                <label for="first_name">Nome</label>
                                <input type="text" name="first_name" id="first_name" tabindex="100" value="' . $result->nome . '"/>
                            </p>
                            <p>
                                <label for="last_name">Cognome</label>
                                <input type="text" name="last_name" id="last_name" tabindex="101" value="' . $result->cognome . '"/>
                            </p>
                            <p>
                                <label for="data">Data</label>
                            <input type="text" name="data" id="data" tabindex="104" value="' . $result->data . '"/>
                            </p>
                            <p>
                                <label for="orario">Orario</label>
                                <input type="text" name="orario" id="orario" tabindex="102" value="' . date("H:i", strtotime($result->ora)) . '"/>
                            </p>
                        </div>
                        <div class="confermAppun">
                            <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                            <input type="reset" value="cancella" />
                            <span id="errors"></span>
                        </div>
                <input type="hidden" name="CodAppuntamento" value="'.$result->codice.'" />
            </fieldset>
            </form>
';
            unset($result);
            echo $str1 . $str2 . $str3;
        }
    }
    content_end();
    page_end();
}
?>