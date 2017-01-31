<?php
    if (isset($_POST['submit'])) {
        include 'utils/DBlibrary.php';
        if (!isset($_POST['first_name']) OR !isset($_POST['last_name']) OR !isset($_POST['contenuto'])) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
            $err = "Almeno uno dei parametri non è stato inserito correttamente";
        } else {
            $sub = $_POST['submit'];
            $email=$_POST['email'];
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $contenuto = $_POST['contenuto'];
        $ris=aggiungiMessaggio($email, $nome, $cognome, $contenuto);
        if($ris)
            $msg="Messaggio inserito con successo";
        else{
            $err=true;
            $msg="Sono presenti errori; riprova per favore";
        }

      }  
    }
    $title="Contattaci: Salone Anna";
    $title_meta="Contattaci: Salone Anna";
    $descr="Pagina con le modalità di contatto di Salone Anna. Ci puoi trovare a Montecchio Maggiore, via L.Ariosto 2";
    $keywords="Salone, Anna, telefono, email, mail, indirizzo, dove trovarci, dove siamo, Vicenza, Montecchio, Maggiore, sede, via Ariosto, e-mail, mappa";
    require 'library.php';
    $onload="caricamentoContattaci(); replaceMap();";
    page_start($title, $title_meta, $descr, $keywords, $onload);
    $rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Contattaci</strong>';
    insert_header($rif, 4, false);
    content_begin();
?>

        <div class="titolo_contattaci">
            <h2>Contattaci</h2>
            <h3>Qualsiasi informazione in modo semplice</h3>
        </div>
        <div class="body_contattaci">
<?php
    if(isset($msg))
        echo "<p>".$msg."</p>";
    if(isset($err))
        echo "<p>".$err."</p>";
?>
            <noscript><p>Compila tutti i campi dati; inserisci un indirizzo <span xml:lang="en">e-mail</span> valido</p></noscript>
            <form action="contattaci.php" onsubmit="return validazioneformcontattaci();" method="post">
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
                        <label for="contenuto">Messaggio</label>
                        <textarea cols="46" rows="3" name="contenuto" id="contenuto" tabindex="103"></textarea>
                    </li>
                    <?php
                    /* <li>
                        <label for="data">Data per appuntamento</label>
                        <input type="date" name="data" id="data" tabindex="104" />
                    <li> */
                    ?>
                        <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                        <span id="errors"></span>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                </ul>
            </form>
        </div>
        <div>
            <div class="SaloneAnna">
                <div class="info">
                    <p>Oppure puoi trovarci nella nostra sede: in via L.Ariosto, 2 - 36075 Montecchio Maggiore VI.</p>
                    <p>Siamo aperti dal Marted&igrave; al Gioved&igrave; dalle ore 8:30 alle 12:30 e dalle 15:00 alle 18:00.</p>
                    <p>Venerd&igrave; e Sabato orario continuato dalle 7:30 alle 18:30.</p>
                    <p>Il nostro numero di telefono &egrave;: <a href="tel:+39 04444 697939" tabindex="106">+39 04444 697939</a>.</p>
                </div>
            </div>
        </div>
        <div id="divMappa">
            <div id="visualizzaMappa">
                <a href="https://www.google.it/maps/place/Parrucchiera+Anna+Cortivo/@45.496225,11.4236863,17z/data=!3m1!4b1!4m5!3m4!1s0x477f379bcb0739f5:0x5a67551b2fe8938a!8m2!3d45.496225!4d11.425875?hl=it" tabindex="105"><img id="fotoMappa" src="img/mappa.png" alt="Mappa della sede di Salone Anna" /></a>
            </div>
        </div>
<?php
    content_end();
    page_end();
?>