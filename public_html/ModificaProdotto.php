<?php
session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else{
    require 'library.php';
    include("utils/DBlibrary.php");
    
    $title = "Modifica Prodotti: Salone Anna";
    $title_meta = "Modifica Prodotti: Salone Anna";
    $descr = "";
    $keywords = "Modifica, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Modifica Prodotto</strong>';
    insert_header($rif, 4, true);
    content_begin();

if (!isset($_POST['submit']) OR !isset($_POST['codprod'])) {
    $err = "Problemi di connessione";
} else {
    $cod=$_POST['codprod'];
    $result = mostraProdotto($cod);
    // nessun risultato
    $num_rows = count($result);
    if (!$num_rows)
        echo "<p class=\"inforesult\">Non è presente il prodotto richiesto</p>";
    else {
        //$prodotto=$result[0];
        $to_print = '
        <form method="post" action="ConfermaModificaProdotto.php">
        <fieldset>
        <legend>Seleziona il prodotto da modificare</legend>
    		<ul>
                    <li>
                        <p>
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" tabindex="100" value="' . $result->nome . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="marca">Marca</label>
                            <input type="text" name="marca" id="marca" tabindex="101" value="' . $result->marca . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="tipo">Tipo</label>
                            <input type="text" name="tipo" id="tipo" tabindex="102" value="' . $result->tipo . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="quantita">Quanità</label>
                            <input type="text" name="quantita" id="quantita" tabindex="103" value="' . $result->quantita . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="pvendita">Prezzo alla vendita</label>
                            <input type="text" name="pvendita" id="pvendita" tabindex="104" value="' . $result->prezzo . '" />
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="privendita">Prezzo di rivendita</label>
                            <input type="text" name="privendita" id="privendita" tabindex="105" value=' . $result->prezzoRiv . ' />
                        </p>
                    </li>
                </ul>
                <input type="hidden" name="codprod" value="'.$cod.'" />
                <input type="submit" name="submit" value="Procedi">
        		<input type="reset" value="Cancella">
            </fieldset></form>
    	';
        echo $to_print;
    }
    $result->free();
}
    if(isset($err))
        echo($err);
    content_end();
    page_end();
}
?>