<?php
require 'library.php';
require 'utils/DBlibrary.php';


$title="Salone Anna | errore 404 - pagina non trovata";
$title_meta="Salone Anna | errore 404 - pagina non trovata";
$descr="Salone Anna | Pagina di errore 404 - pagina non trovata";
$keywords="Pagina, errore, 404, Parrucchiere, Montecchio, Vicenza, Taglio, Donna";
page_start($title, $title_meta, $descr, $keywords, '');
$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Errore</strong>';
// $rif="<strong id=\"logError\">404: pagina non trovata</strong>";
$name="visitatore"; 
$is_admin=false;

insert_header($rif, 0, $is_admin,'');
content_begin();
    if (!isset($_GET["codmsg"])) {
    	echo"<p class=\"errorSuggestion\">Ti trovi su questa pagina perché ci sono stati problemi</p>";
        
    } 
    else {
        $cmsg = $_GET["codmsg"];
        if($cmsg=="0") //errore connessione database
        	echo"<p class=\"errorSuggestion\">Ci sono stati problemi durante la connessione al database</p>";
        elseif($cmsg=="1") //sessione scaduta o niente permessi.
        	echo"<p class=\"errorSuggestion\">Per accedere a questa pagina, effettua nuovamente l'accesso, per favore</p>";
        elseif($cmsg=="2") //accesso già effettuato
        	echo"<p class=\"errorSuggestion\">Ti trovi su questa pagina perché hai già effettuato l'accesso</p>";
        else //errore generico
        	echo"<p class=\"errorSuggestion\">Ti trovi su questa pagina perché ci sono stati problemi</p>";
    }
    //inserisci pulsante per tornare alla home
    hyperlink("Torna alla <span xml:lang=\"en\">home</span>","index.php");
/*
No connessione
errore.php?codmsg=0

Sessione scaduta
errore.php?codmsg=1
Accesso già effettuato
errore.php?codmsg=2
*/
content_end();
page_end();
?>