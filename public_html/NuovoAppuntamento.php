<?php
require 'library.php';
require 'utils/DBlibrary.php';

$login=authenticate();

// Controllo accesso
if (!$login) {
    header('location:index.php');
    exit;
} 
else {    
    $title      = "Nuovo appuntamento: Salone Anna";
    $title_meta = "Nuovo appuntamento: Salone Anna";
    $descr      = "";
    $keywords   = "Nuovo, Appuntamento, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Nuovo Appuntamento</strong>';
    insert_header($rif, 6, true);
    content_begin();
    echo "<h2>Nuovo Appuntamento</h2>";

    //aggiungere tabindex;
    $str1 = '<form action="ConfermaNuovoAppuntamento.php" onsubmit="return true;" method="post">
             <fieldset>
                <legend>Compila le informazioni richieste per inserire un appuntamento</legend>
                    <div class="tipiAppun">
                        <p class="info">Tipo appuntamento:</p>
    ';

    $str2        = "";
    $result= listaTipoAppuntamenti();
    if($result){
        foreach ($result as $tipoApp){
            $str2 .= '<p class="tipoAppun"><input type="radio" name="TipoAppuntamento" id="t'.$tipoApp->codice.'" value="' . $tipoApp->codice . '" /><label for="t'.$tipoApp->codice.'">'.$tipoApp->nome."</label></p>";
        }
    }
    $str3 = '</div>
            <div class="datiAppun">
                <p>
                    <label for="first_name">Nome</label>
                    <input type="text" name="first_name" id="first_name" tabindex="100"/>
                </p>
                <p>
                    <label for="last_name">Cognome</label>
                    <input type="text" name="last_name" id="last_name" tabindex="101" />
                </p>
                <p>
                    <label for="data">Data</label>
                <input type="text" name="data" id="data" tabindex="102" />
                </p>
                <p>
                    <label for="orario">Orario</label>
                    <input type="text" name="orario" id="orario" tabindex="103" />
                </p>
            </div>
            <div class="confermAppun">
                <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                <input type="reset" value="cancella" />
                <span id="errors"></span>
            </div>
        </fieldset>
        </form>
';
    echo $str1 . $str2 . $str3;
    content_end();
    page_end();
}
?>