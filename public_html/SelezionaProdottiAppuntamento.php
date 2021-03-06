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
    $title = "Utilizzo Prodotti Appuntamento | Salone Anna";
    $title_meta = "Utilizzo Prodotti Appuntamento | Salone Anna";
    $descr = "Pagina in cui è possibile inserire la Quantità di utilizzo di ogni Prodotto per poter creare uno storico per il Cliente ";
    $keywords = "Storico, Prodotti, Appuntamento, Cliente, Utilizzo, Quantità, Nome, Data, Marca";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Prodotti.php">Prodotti</a>  / <strong>Prodotti-Clienti-Appuntamento</strong>';
    insert_header($rif, 4, true);
    content_begin();
    //seleziona l'appuntamento, mostra i dati dell'appuntamento, se non c'è segnala errore. 
    // se il submot non c'è segnala errore

    if (isset($_POST['submit'])) {
        if(isset($_POST['codApt']) && isset($_POST['qtprod'])) {
                $codice=$_POST['codApt'];
                $ids = $_POST['codprod'];
                $qt_new=$_POST['qtprod'];
                $qt_old=$_POST['qtprod_old'];
                $n_el=0;
                $n_err=0;
                for ($i=0; $i<count($ids); $i++) { 
                    if ($qt_new[$i] != $qt_old[$i]){
                        $ris=cambiaUtilizzoProdottiAppuntamento($codice, $ids[$i], $qt_new[$i]);
                        if($ris) ++$n_el;
                        else ++$n_err;
                    }
        
                }
                if($n_el>0)
                    if($n_el==1)
                        echo "<p class=\"inforesult\">È stato modificato $n_el prodotto</p>";
                    else
                        echo "<p class=\"inforesult\">Sono stati modificati $n_el prodotti</p>";
                if($n_err>0) echo "<p class=\"errorSuggestion\">Durante le modifiche si sono verificati $n_err errori</p>";
            }
        if(isset($_POST['codapp'])) {
            $codice = $_POST['codapp'];
            $appuntamento=mostraAppuntamento($codice);
            if(!$appuntamento){
                $err="<p>L'appuntamento selezionato non è presente nel database. Torna al livello superiore </p>\n";
            }
            else{
                // mostra l'appuntamento
                $str_to_print='<table id="tabApp" summary="Dati appuntamento">
                <caption>Riepilogo appuntamento selezionato</caption>
                <thead>
                    <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Data</th>
                    <th scope="col">Ora</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Prezzo</th>
                    </tr>
                </thead>
                <tbody>
                ';
        
                $str_to_print .= "
                <tr>
                    <td>" . $appuntamento->codice . "</td>
                    <td>" . $appuntamento->nome . "</td>
                    <td>" . $appuntamento->cognome . "</td>
                    <td>" . $appuntamento->data . "</td>
                    <td>" . $appuntamento->ora . "</td>
                    <td>" . $appuntamento->tipo . "</td>
                    <td>" . $appuntamento->prezzo . "</td>
                </tr>
                ";
        
                $str_to_print .= "</tbody></table>\n";
                echo $str_to_print;
                //mostra prodotti
                $result = listaTotaleProdottiAppuntamento($codice);
    
                $num_rows = count($result);

                if (!$num_rows)
                    echo "<p>Non ci sono entry nella tabella Prodotti</p>";
                else {
                    $th = '
                    <form method="post" action="SelezionaProdottiAppuntamento.php">
                    <fieldset>
                    <table id="ProdottiMagazzino" summary="Prodotti in magazzino">
                        <caption class="nascosto">Elenco prodotti utilizzabili</caption>
                        <thead>
                            <tr>
                                <th scope="col">CodProdotto</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Utilizzo</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th scope="col">CodProdotto</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Utilizzo</th>
                            </tr>
                        </tfoot>

                        <tbody>
                        ';
                    $tb = "";
                    //corpo tabella
                    foreach ($result as $prodotto)
                        $tb.="<tr>
                                <td>".$prodotto->codProdotto."</td>
                                <td>".$prodotto->nome."</td>
                                <td>".$prodotto->marca."</td>
                                <td>".$prodotto->tipo."</td>
                                <td class=\"tdin\"><input type=\"text\" name=\"qtprod[]\" value=\"$prodotto->utilizzo\" />
                                    <input type=\"hidden\" name=\"codprod[]\" value=\"$prodotto->codProdotto\" />
                                    <input type=\"hidden\" name=\"qtprod_old[]\" value=\"$prodotto->utilizzo\" />
                                    <input type=\"hidden\" name=\"codApt\" value=\"$codice\" />
                                </td>
                                
                            </tr>";
                    $tf= "</tbody></table>
                        <input type='submit' name='submit' value='Procedi'/>
                        <input type='reset' value='Cancella'/>
                        </fieldset>
                        </form>";
                    $to_print = $th . $tb . $tf;
                    echo $to_print;
                //TO HERE
                }
            }
            unset($appuntamento);
        }
        else{
            $err="<p>Non è stato selezionato alcun appuntamento. Torna al livello superiore </p>\n";
        }
    content_end();
    page_end();
    }
}
?>
