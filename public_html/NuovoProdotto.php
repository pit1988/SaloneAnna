<?php
require 'library.php';
require 'utils/DBlibrary.php';
$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:errore.php?codmsg=1');
    exit;
} 
else {    
    if (isset($_POST['submit'])) {
        $nome      = $_POST['nome'];
        $marca     = $_POST['marca'];
        $tipo      = $_POST['tipo'];
        $quantita  = $_POST['quantita'];
        $pvendita  = $_POST['pvendita'];
        $rivendita = $_POST['rivendita'];
        $ris       = aggiungiProdotto($nome, $marca, $tipo, $quantita, $pvendita, $rivendita);
        if ($ris)
            $msg = "<p class=\"inforesut\">Il prodotto è stato creato correttamente</p>";
        else
            $msg = "<p class=\"inforesut\">Non è stato possibile creare il prodotto</p>";
        unset($ris);
    }
    
    $title      = "Nuovo Prodotto | Salone Anna";
    $title_meta = "Nuovo Prodotto | Salone Anna";
    $descr      = "Pagina per inserire un nuovo prodoot all'interno del sito";
    $keywords   = "Nuovo, Prodotto, Nome, Marca, Tipo, Quatità, Prezzo, Vendita, Rivendita, Inserisci";
    
    page_start($title, $title_meta, $descr, $keywords, 'caricamentoProdotto()');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <strong>Nuovo Prodotto</strong>';
    insert_header($rif, 4, true);
    content_begin();

    if (isset($msg))
        echo ($msg);
    if (isset($err))
        echo ($err);

    echo "<h2>Inserisci nuovo prodotto</h2>";

    
    $to_print = '
    <form method="post" onsubmit="return validazioneFormCliente();" action="NuovoProdotto.php">
    <fieldset>
    <legend>Completa le informazioni per inserire un nuovo prodotto</legend>
        <ul>
                <li>
                    <p>
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" tabindex="100" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" tabindex="101" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="tipo">Tipo</label>
                        <input type="text" name="tipo" id="tipo" tabindex="102" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="quantita">Quanità</label>
                        <input type="text" name="quantita" id="quantita" tabindex="103" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="pvendita">Prezzo alla vendita</label>
                        <input type="text" name="pvendita" id="pvendita" tabindex="104" />
                    </p>
                </li>
                <li>
                    <p>
                        <label for="rivendita">Prezzo di rivendita</label>
                        <input type="text" name="rivendita" id="rivendita" tabindex="105" />
                    </p>
                </li>
            </ul>
            <input type="submit" name="submit" value="Procedi"/>
            <input type="reset" value="Cancella"/>
            <span id="logError"></span>
        </fieldset>
        </form>
    ';

    
    echo $to_print;
    content_end();
    page_end();
}
?>