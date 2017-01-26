
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    require 'utils/DBlibrary.php';
    
    $title = "Nuovo appuntamento: Salone Anna";
    $title_meta = "Nuovo appuntamento: Salone Anna";
    $descr = "";
    $keywords = "Nuovo, Appuntamento, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Nuovo Appuntamento</strong>';
    insert_header($rif, 4, true);
    content_begin();
    //aggiungere tabindex; modificare input type radio in modo da lasciare 
    $str1= '<form action="conferma_appuntamento.php" onsubmit="return true;" method="post">
                <ul>
                    <li>
                        <p> 
                            <label for="TipoAppuntamento">Tipo appuntamento:</label>
                            <input type="radio" name="TipoAppuntamento" value="shampoo" />Shampoo
							<input type="radio" name="TipoAppuntamento" value="taglio" />Taglio
							<input type="radio" name="TipoAppuntamento" value="piega e phon" />Piega e Phon
							<input type="radio" name="TipoAppuntamento" value="piega e casco" />Piega e Casco
							<input type="radio" name="TipoAppuntamento" value="ondulazione" />Ondulazione
							<input type="radio" name="TipoAppuntamento" value="colore" />Colore
							<input type="radio" name="TipoAppuntamento" value="riflessante" />Riflessante
							<input type="radio" name="TipoAppuntamento" value="decolorazione" />Decolorazione
							<input type="radio" name="TipoAppuntamento" value="meches" />Meches
							<input type="radio" name="TipoAppuntamento" value="trattamenti" />Trattamenti
';

	$str2="";
$str3='
                        </p>
                    </li>
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
                    <li>
                        <p>
                            <label for="data">Data</label>
                        <input type="text" name="data" id="data" tabindex="104"
                        </p>
                    </li>
                    <li>
                        <p>
                            <label for="orario">Orario</label>
                            <input type="text" name="orario" id="orario" tabindex="102" />
                        </p>
                    </li>
                    <li>
                        <label for="costo">Costo</label>
                         <input type="text" name="costo" id="costo" tabindex="103" />
                    </li>
                        <li>
                        <label for="sconto">Sconto</label>
                         <input type="text" name="sconto" id="sconto" tabindex="103" />
                    </li>
                    <li>
                        <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                        <input type="reset" value="cancella"
                        <span id="errors"></span>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                </ul>
            </form>
';
	echo $str1.$str2.$str3;
    content_end();
    page_end();
}
?>