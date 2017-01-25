<?php
    $title="Contattaci: Salone Anna";
    $title_meta="Contattaci: Salone Anna";
    $descr="Pagina con le modalità di contatto di GGarden. Ci puoi trovare a Padova, via Trieste, 63";
    $keywords="GGarden, telefono, email, mail, indirizzo, dove trovarci, dove siamo, Padova, sede, via Trieste, e-mail, mappa";
    require 'library.php';
    $onload="caricamentoContattaci(); replaceMap();";
    page_start($title, $title_meta, $descr, $keywords, $onload);
    $rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Contattaci</strong>';
    insert_header($rif, 5, false);
    content_begin();
?>

        <div class="titolo_contattaci">
            <h2>Contattaci</h2>
            <h3>Qualsiasi informazione in modo semplice</h3>
        </div>
        <div class="body_contattaci">
            <noscript><p>Compila tutti i campi dati; inserisci un indirizzo <span xml:lang="en">e-mail</span> valido</p></noscript>
            <form action="" onsubmit="return validazioneFormContattaci();" method="post">
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
                        <label for="comments">Messaggio</label>
                        <textarea cols="46" rows="3" name="comments" id="comments" tabindex="103"></textarea>
                    </li>
                    <li>
                        <label for="data">Data per appuntamento</label>
                        <input type="date" name="data" id="data" tabindex="104"
                    <li xml:lang="en">
                        <input class="btn btn-submit" type="submit" value="Invia" tabindex="105"/>
                        <span id="errors"></span>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                </ul>
            </form>
        </div>
        <div>
            <div class="Gaddress">
                <div class="info">
                    <p>Oppure puoi trovarci nella nostra sede: in via Trieste, 63 - 35121 Padova PD.</p>
                    <p>Siamo aperti dal luned&igrave; al sabato, dalle ore 8:30 alle 13:30 e dalle 15:00 alle 19:30.</p>
                    <p>Il nostro numero di telefono &egrave;: <a href="tel:+1 555 123456" tabindex="106">+1 555 123456</a>.</p>
                </div>
            </div>
        </div>
        <div id="divMappa">
            <div id="visualizzaMappa">
                <a href="https://www.google.it/maps/place/Torre+Archimede,+Via+Trieste,+63,+35121+Padova+PD/@45.4113311,11.8854431,17z/data=!3m1!4b1!4m5!3m4!1s0x477eda58b44676df:0xfacae5884fca17f5!8m2!3d45.4113311!4d11.8876318" tabindex="105"><img id="fotoMappa" src="img/mappa.png" alt="Mappa della sede di GGarden" /></a>
            </div>
        </div>
    </div>

<?php
    content_end();
    page_end();
?>