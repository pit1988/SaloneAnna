
<?php
require 'library.php';
require 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} 
else{ 
    if(isset($_POST['submit'])) {
        if (!isset($_POST['first_name']) OR !isset($_POST['last_name'])) {// OR !isset($_POST['email']) OR !isset($_POST['phone']) OR !isset($_POST['data'])) {
            $err= "Almeno uno dei parametri non è stato inserito correttamente";
        }
        else{
            $sub=$_POST['submit'];
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $email = $_POST['email'];
            $telefono = $_POST['phone'];
            $date=$_POST['data'];
            if(strlen($nome)==0 OR strlen($cognome)==0) // OR strlen($email)==0 OR strlen($telefono)==0 OR strlen($date)==0)
                $err= "<p class=\"errorSuggestion\">Almeno uno dei parametri non è stato inserito correttamente</p>";
            else{
                $result = checkCliente($nome, $cognome, $telefono, $email, $date);
                if(is_null($result) OR count($result)==0){
                    $ris = aggiungiCliente($nome, $cognome, $telefono, $email, $date);
                    if (!$ris) {
                        $err= "<p class=\"errorSuggestion\">Non è stato possibile inserire il nuovo cliente</p>";
                    } else
                        $esito= "<p class=\"inforesult\">Operazione eseguita con successo</p>";
                }
                else{ //uno o più
                    $err= "<p class=\"errorSuggestion\">Il cliente " . $nome . " " . $cognome . " è già presente nel database</p>";
                }
                unset($result);
            }
        }
    }
    $title = "Nuovo Cliente | Salone Anna";
    $title_meta = "Nuovo Cliente | Salone Anna";
    $descr = "Pagina per inserire un nuovo appuntamento all'interno del sito";
    $keywords = "Nuovo, Cliente, Nome, Cognome, Telefono, Email, Mail, Data, Inserisci";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Nuovo Cliente</strong>';
    insert_header($rif, 5, true);
    content_begin();
    if(isset($err))
        echo $err;
    if(isset($esito))
        echo $esito;

    echo '<h2>Nuovo Cliente</h2>
            <form action="NuovoCliente.php" onsubmit="return true;" method="post">
                <fieldset>
                <legend>Dati nuovo cliente</legend>
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
                    <li xml:lang="en">
                        <p>
                            <label for="email">E-Mail</label>
                            <input type="text" name="email" id="email" tabindex="102" />
                        </p>
                    </li>
                    <li>
                        <label for="phone">Telefono</label>
                         <input type="text" name="phone" id="phone" tabindex="103" />
                    </li>
                    <li>
                        <label for="data">Data di nascita</label>
                        <input type="text" name="data" id="data" tabindex="104" />
                    </li>  
                    <li class="noPrint" xml:lang="en">
                        <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                        <input type="reset" value="cancella" />
                        <span id="errors"></span>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                </ul>
                </fieldset>
            </form>
';
    content_end();
    page_end();
}
?>
            