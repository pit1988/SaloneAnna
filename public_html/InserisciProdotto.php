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
    
    $title = "Gestione Prodotti: Salone Anna";
    $title_meta = "Gestione Prodotti: Salone Anna";
    $descr = "";
    $keywords = "Gestione, Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a> / <a href="GestioneProdotti.php"> Gestione Prodotti</a> / <strong>Modifica Prodotto</strong>';
    insert_header($rif, 4, true);
    content_begin();

    $to_print = '<form method="POST" action="esito_modifica.php">
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
                            <label for="quanita">Quanità</label>
                            <input type="text" name="quanita" id="quanita" tabindex="103" />
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
                            <label for="privendita">Prezzo di rivendita</label>
                            <input type="text" name="privendita" id="privendita" tabindex="105" />
                        </p>
                    </li>
                </ul>
                <input type="submit" name="submit" value="Procedi">
                <input type="reset" value="Cancella">
            </form>
        ';
        echo $to_print;


    if(isset($err))
        echo($err);
    content_end();
    page_end();
}
?>