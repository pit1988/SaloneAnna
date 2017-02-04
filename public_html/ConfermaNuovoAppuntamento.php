<?php
require 'library.php';
include 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} else {
    if (!isset($_POST['submit'])) {
        header('loation:NuovoAppuntamento.php');
    } 
    else {
        $title = "Conferma Nuovo Appuntamento | Salone Anna";
        $title_meta = "Conferma Nuovo Appuntamento| Salone Anna";
        $descr = "L'appuntamenot è stato modificato e verrà segnalato il successo o il fallimento in questa pagina. Nel caso di clienti omonimi si potrà scegliere";
        $keywords = "Nuovo, Appuntamento, Conferma, Cliente, Ominimo, Tipo, Nome, Cognome, Data, Orario";
        
        page_start($title, $title_meta, $descr, $keywords, '');
        $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Nuovo Appuntamento</strong>';
        insert_header($rif, 6, true);
        content_begin();
        
        //codcliente, orario e data e tipoappuntamento
        if (isset($_POST['TipoAppuntamento']) AND isset($_POST['CodCliente']) AND isset($_POST['data']) AND isset($_POST['orario'])){
            $codCliente = $_POST['CodCliente'];
            $codTipo = $_POST['TipoAppuntamento'];
            $data = $_POST['data'];
            $ora = $_POST['orario'];
            $nomeCognome = $_POST['nomeCognome'];
            $ok = aggiungiAppuntamento($codCliente, $data, $ora, $codTipo);

            if ($ok==false)
                echo "<p class=\"inforesult\">Non è stato possibile inserire l'appuntamento di $nome</p>";
            else
                echo "<p class=\"inforesult\">Appuntamento di $nomeCognome inserito correttamente il $data alle $ora</p>";
        }
        elseif (!isset($_POST['TipoAppuntamento']) OR !isset($_POST['first_name']) OR !isset($_POST['last_name']) OR !isset($_POST['data']) OR !isset($_POST['orario'])) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
            echo "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
        } 
        else {
            $sub = $_POST['submit'];
            $codTipo = $_POST['TipoAppuntamento'];
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $data = $_POST['data'];
            $ora = $_POST['orario'];
            
            if (strlen($codTipo) == 0 OR strlen($nome) == 0 OR strlen($cognome) == 0 OR strlen($data) == 0 OR strlen($ora) == 0) 
                echo "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
            else {
                $result = checkCliente($nome, $cognome);
                if(is_null($result) OR count($result)==0){
                    echo "<p class=\"errorSuggestion\">Non sono presenti clienti che si chiamano " . $nome . " " . $cognome . ", segui il link per aggiungerlo ai clienti:</p>";
                    hyperlink("Inserisci un nuovo cliente","NuovoCliente.php");
                }
                else{ //uno o più
                    $number_rows = count($result);
                    
                    if ($number_rows > 1) {
                        echo "<p class=\"inforesult\">Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                        form_start("post", "conferma_appuntamento.php");
                        $th = '
                            <fieldset>
                            <legend>Seleziona il cliente dalla lista</legend>
                            <table id="ElencoClienti" summary="Elenco clienti">
                                <caption>Clienti che si chiamano '.$nome.' '.$cognome.'</caption>
                                <thead>
                                <tr>
                                    <th scope="col">Codice</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Cognome</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col" xml:lang="en">E-mail</th>
                                    <th scope="col">Data nascita</th>
                                    <th scope="col">Selezione</th>
                                </tr>
                            </thead>
                            <tbody>';
                        $tb="";
                        foreach ($result as $cliente) {
                            $tb.= "
                                <tr>
                                    <td>".$cliente->codice."</td><td>".$cliente->nome."</td>
                                    <td>".$cliente->cognome."</td>
                                    <td>".$cliente->telefono."</td>
                                    <td>".$cliente->email."</td>
                                    <td>".$cliente->dataNascita."</td>
                                    <td class=\"tdin\"><input type='radio' name='CodCliente' value=$cliente->codice></td>
                                </tr>
                                ";
                        }
                        $tf="</tbody></table>";
                        $to_print = $th . $tb . $tf;
                        echo $to_print;

                        echo '
                            <input type="hidden" name="nomeCognome" id="nomeCognome" value="'.$nome." ".$cognome.'" />
                            <input type="hidden" name="data" id="data" value="'.$data.'" />
                            <input type="hidden" name="orario" id="orario" value="'.$ora.'" />
                            <input type="hidden" name="TipoAppuntamento" id="TipoAppuntamento" value="'.$codTipo.'" />';
                        echo "<input type='submit' name='submit' value='Procedi' />";
                        echo "<input type='reset' value='Cancella' />";
                        echo"</fieldset>";
                        echo "</form>";
                    } //fine n_righe>1
                    else{ //unico risultato
                        // prendi il codice cliente dall'unica riga
                        $codCliente=$result[0]->codice;
                        $ok = aggiungiAppuntamento($codCliente, $data, $ora, $codTipo); //ricontrollare paramen
                        if (!($ok==false))
                            echo "<p class=\"inforesult\">Appuntamento di $nome inserito correttamente il $data alle $ora</p>";
                        else
                            echo "<p class=\"inforesult\">Non è stato possibile inserire l'appuntamento di $nome</p>";
                    }
                    
                }
                unset($result);
            }
        } //è stato inserito o si sono verificati errori

        content_end();
        page_end();
    }
}

?>
