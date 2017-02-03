// Funzioni per la form delle pagine
/*
chiave: nome dell'input da controllare
[0]: prima indicazione per la compilazione dell'input
[1]: l'espressione regolare da controllare
[2]: hint nel caso in cui l'input fornito sia sbagliato
*/
// Campi dati per le varie form
var dettagli_form_contattaci = {
    "first_name": ["Mario", /^[A-Za-z ]+/, "Inserisci il tuo nome"],
    "last_name": ["Rossi", /^[A-Z][a-z]+( ([A-Z][a-z]+))?/, "Inserisci il tuo cognome"],
    "email": ["Inserire e-mail", /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/, "Inserisci un indirizzo email valido"],
    "contenuto": ["Scrivi qui la tua domanda", /.+/, "Inserisci la domanda"]
};

var dettagli_form_login = {
    "username": ["Username", /.*/, ""],
    "password": ["Password", /.*/, ""]
};

var dettagli_form_cambio_password = {
    "pwd": ["Password", /^[a-zA-Z0-9À-ÿ!@#$%^&*]{8,32}$/, "Deve avere una lunghezza di almeno 8 caratteri"],
    "conf": ["Password", /^[a-zA-Z0-9À-ÿ!@#$%^&*]{8,32}$/, "Deve avere una lunghezza di almeno 8 caratteri"]
};

var dettagli_form_immagine = {
    "img_desc": ["Descrizione", /^[a-zA-ZÀ-ÿ0-9 -v]+$/, "Inserisci una breve descrizione dell'immagine"]
};

var dettagli_form_storicoProdotti = {
    "first_name": ["Mario", /^[A-Za-z ]+/, "Inserisci il nome del cliente"],
    "last_name": ["Rossi", /^[A-Z][a-z]+( ([A-Z][a-z]+))?/, "Inserisci il cognome del cliente"],
};

var dettagli_form_nomiAppuntamenti = {
    "first_name": ["Mario", /^[A-Za-z ]+/, "Inserisci il nome del cliente"],
    "last_name": ["Rossi", /^[A-Za-z ]+/, "Inserisci il cognome del cliente"]
};

var dettagli_form_orarioAppuntamenti = {
    "date" : ["" , /[0-9]{2}[\/]{1}[0-9]{2}[\/]{1}[0-9]{4}$/ , "Inserisci una data nel formato gg/mm/AA"],
    "orario" : ["" , /([0-9]{1,2}[:][0-9]{2})?/, "Inserisci un orario nel formato hh:mm"]
};

var dettagli_form_cliente = {
    "first_name": ["", /^[A-Z][a-z]+( ([A-Z][a-z]+))?/, "Inserisci il nome del cliente"],
    "last_name": ["", /^[A-Z][a-z]+( ([A-Z][a-z]+))?/, "Inserisci il cognome del cliente"],
    "email": ["", /(^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$)?/, "Inserisci un indirizzo email valido"],
    "phone": ["", /(((\+)?[0-9]{0,4})?[0-9]{8,11}$)?/, "Inserisci un numero telefonico valido"],
    "data" : ["" , /([0-9]{2}[\/]{1}[0-9]{2}[\/]{1}[0-9]{4}$)?/ , "Inserisci una data nel formato gg/mm/AA"]
};

var dettagli_form_prodotto = {
    "nome" : ["Nome prodotto", /^[a-zA-ZÀ-ÿ0-9 -v]+$/, "Inserisci il nome"],
    "marca" : ["Marca prodotto", /^[a-zA-ZÀ-ÿ0-9 -v]+$/, "Inserisci la marca"],
    "tipo" : ["Tipo prodotto", /^[a-zA-ZÀ-ÿ0-9 -v]+$/, "Inserisci il tipo"],
    "quantita" : ["0", /^[a-zA-ZÀ-ÿ0-9 -v]+$/, "Inserisci la quantità"],
    "pvendita" : ["0.00", /[0-9]+([\.][0-9]{1,2})?/, "Inserisci il prezzo nel formato 15.00 "],
    "rivendita" : ["0.00", /[0-9]+([\.][0-9]{1,2})?/, "Inserisci il prezzo nel formato 15.00"]
};

var dettagli_form_appuntamenti = {
    "first_name" : ["", /^[A-Za-z ]+/, "Inserisci il nome del cliente"],
    "last_name" : ["", /^[A-Za-z ]+/, "Inserisci il cognome del cliente"],
    "data": ["", /[0-9]{2}[\/]{1}[0-9]{2}[\/]{1}[0-9]{4}$/ , "Inserisci una data nel formato gg/mm/AA"],
    "orario" : ["", /[0-9]{1,2}[:][0-9]{2}/, "Inserisci un orario nel formato hh:mm"]
};

var dettagli_dynamic_data = {};

var dettagli_dynamic_price = {
    "price": ["", /^\d+[\.]?(\d{1,2})?$/, "Inserisci il prezzo separato da un punto", "format"]
    //"price": ["", /^\d+[\.]?(\d{2})$/, "Inserisci il prezzo separato da un punto", "format"]
};

function caricamentoContattaci() {
    return caricamento(dettagli_form_contattaci, false);
}

function caricamentoLogin() {
    return caricamento(dettagli_form_login, false);
}

function caricamentoCambioPassword() {
    return caricamento(dettagli_form_cambio_password, false);
}

function caricamentoImmagine() {
    return caricamento(dettagli_form_immagine, true);
}

function caricamentoStorico() {
    return caricamento(dettagli_form_storicoProdotti, false);
}

function caricamentoRicercaAppuntamento() {
    caricamento(dettagli_form_orarioAppuntamenti, false);
    caricamento(dettagli_form_nomiAppuntamenti, false);
}

function caricamentoCliente() {
    caricamento(dettagli_form_cliente);
}

function caricamentoProdotto() {
    caricamento(dettagli_form_prodotto);
}

function caricamentoAppuntamento() {
    caricamento(dettagli_form_appuntamenti);
}

// Funzione che data la matrice dei campi dati, li inserisce all'interno della form e stabilisce i controlli
function caricamento(matrix, checkImg) //carica i dati nei campi
{
    if (checkImg === true) {
        var img = document.getElementById("uploadedfile");
        img.onchange = function() {
            checkImage(this);
        };
    }

    for (var key in matrix) {
        var input = document.getElementById(key);
        campoDefault(matrix, input);

        input.onfocus = function() {
            campoPerInput(matrix, this);
        }; //toglie l'aiuto
        input.onblur = function() {
            validazioneCampo(matrix, this);
        }; //fa la validazione del campo
    }
}
// togliere
function controlloImmagine() {
    return controllo(dettagli_form_immagine, true);
}
// togliere
function controllo(matrix, checkImg) {
    if (checkImg === true) {
        var img = document.getElementById("uploadedfile");
        img.onchange = function() {
            checkImage(this);
        };
    }
    for (var key in matrix) {
        var input = document.getElementById(key);

        input.onblur = function() {
            validazioneCampo(matrix, this);
        }; //fa la validazione del campo
    }
}

function campoDefault(matrix, input) {
    if (input.value === "") {
        input.value = matrix[input.id][0];
    }
}

function campoPerInput(matrix, input) {
    if (input.value == matrix[input.id][0]) {
        input.value = "";
    }
}

function validazioneCampo(matrix, input) {
    var p = input.parentNode; //prende lo span
    var errore = document.getElementById(input.id + "errore");
    if (errore) {
        p.removeChild(errore);
    }
    var regex = matrix[input.id][1];
    var text = input.value;
    // if (((text == matrix[input.id][0])) || text.search(regex) != 0) //occhio! controllo che l'input sia diverso dal placeholder (con il primo check)
    if (text.search(regex) !== 0) {
        mostraErrore(matrix, input);
        return false;
    }
    return true;
}

//togliere
function validazioneCampoDinamico(matrix, input) {
    var p = input.parentNode; //prende lo span
    var errore = document.getElementById(input.id + "errore");
    if (errore) {
        p.removeChild(errore);
    }
    var regex1 = matrix[input.id][1];
    var text = input.value;
    var companion = document.getElementById(matrix[input.id][3]);
    var c_p = companion.parentNode;
    var c_errore = document.getElementById(matrix[input.id][3] + "errore");
    var ris = true;
    if (c_errore) {
        c_p.removeChild(c_errore);
    }
    var text2 = companion.value; //prendo il valore del secondo valore
    if (((text == matrix[input.id][0])) || text.search(regex1) !== 0) //occhio! controllo che l'input sia diverso dal placeholder (con il primo check)
    {
        mostraErrore(matrix, input);
        ris = false;
    }
    if (text2 === "") {
        var e = document.createElement("strong");
        e.className = "errorSuggestion";
        e.id = matrix[input.id][3] + "errore";
        e.appendChild(document.createTextNode("Inserisci un formato"));
        c_p.appendChild(e);
        ris = false;
    }
    if (text === "" && text2 === "")
        ris = true;
    return ris;
}

// Funzioni per il controllo sul tipo dell'immagine inserita nella form
function checkPictureType(Extension) {
    return (Extension == "gif" || Extension == "png" || Extension == "svg" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg");
}

function checkImage() {
    var fuData = document.getElementById('uploadedfile');
    var p = fuData.parentNode; //prende lo span
    var errore = document.getElementById(fuData.id + "errore");
    if (errore) {
        p.removeChild(errore);
    }
    var FileUploadPath = fuData.value;

    if (FileUploadPath === '') {
        // alert("Please upload an image");
        // errImg(fuData);
        return true;
    } else {
        var Extension = FileUploadPath.substring(
            FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
        if (checkPictureType(Extension)) {
            return true;
        } else {
            errImg(fuData);
            return false;
        }
    }
}

function validazioneFormContattaci() {
    var ris = validazioneForm(dettagli_form_contattaci, true);
    if (ris === false)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    return ris;
}

function validazioneFormCambioPassword() {
    var ris = validazioneForm(dettagli_form_cambio_password, true);
    if (ris === false)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    else {
        var pw1 = (document.getElementById('pwd')).value;
        var pw2 = (document.getElementById('conf')).value;
        if (pw1 != pw2) {
            ris = false;
            document.getElementById('logError').innerHTML = "Le password non coincidono, ricontrolla, per favore";
        }
    }
    return ris;
}

function validazioneFormImmagine() {
    var rImg = checkImage();
    var rFrm = validazioneForm(dettagli_form_immagine, true);
    var valRes = (rImg && rFrm);
    if (valRes !== true)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    return valRes;
}

function validazioneFormStorico() {
    var ris = validazioneForm(dettagli_form_storicoProdotti, true);
    if (ris === false)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    return ris;
}

function validazioneFormRicercaAppuntamenti() {
    var selectedNome = document.getElementsByName('cli')[0].checked;
    var selectedOrario = document.getElementsByName('data')[0].checked;
    var ris=((selectedOrario===false) && (selectedNome===false));
    if(ris){
        document.getElementById('logError').innerHTML = "Non hai selezionato alcuna casella di ricerca";  
        return false;
    }
    else{
        var rNome= true;
        var rOrario=true;
        if(selectedNome === true){
            rNome = validazioneForm(dettagli_form_nomiAppuntamenti, true);
            if(rNome===false)
                document.getElementById('logError').innerHTML = "Sono presenti errori nelle caselle del nome cliente, potresti ricontrollare?";
        }
        if(selectedOrario ===true){
            rOrario = validazioneForm(dettagli_form_orarioAppuntamenti, true);
            if(rOrario===false)
                document.getElementById('logError').innerHTML = "Sono presenti errori nelle caselle dell'orario, potresti ricontrollare?";
        }
        return (rOrario && rNome);
    }
}

function validazioneFormCliente() {
    var ris = validazioneForm(dettagli_form_cliente, true);
    if (ris === false)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    return ris;
}

function validazioneFormProdotto() {
    var ris = validazioneForm(dettagli_form_prodotto, true);
    if (ris === false)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    return ris;
}

function validazioneFormAppuntamento() {
    var ris = validazioneForm(dettagli_form_appuntamenti, true);
    if (ris === false)
        document.getElementById('logError').innerHTML = "Sono presenti errori, potresti ricontrollare?";
    return ris;
}


function validazioneForm(matrix, Mstatica) {
    var corretto = true;
    var risultato = false;
    for (var key in matrix) {
        var input = document.getElementById(key);
        if (Mstatica === true)
            risultato = validazioneCampo(matrix, input);
        else
            risultato = validazioneCampoDinamico(matrix, input);
        corretto = corretto && risultato;
    }
    return corretto;
}

function mostraErrore(matrix, input) {
    var p = input.parentNode;
    var e = document.createElement("strong");
    e.className = "errorSuggestion";
    e.id = input.id + "errore";
    e.appendChild(document.createTextNode(matrix[input.id][2]));
    p.appendChild(e);
}

function errImg(fuData) {
    var p = fuData.parentNode;
    var e = document.createElement("strong");
    e.className = "errorSuggestion";
    e.id = (document.getElementById("image")).id + "errore";
    e.appendChild(document.createTextNode("Inserisci un file immagine"));
    p.appendChild(e);
}

// Funzioni per aumentare dinamicamente il numero di campi dati della form. Togliere

var counter_prezzo = 0;
var counter_valore = 0;

function addNInputData(divname, number) {
    for (var i = 1; i < number; ++i) {
        dettagli_dynamic_data['dataName' + i] = ["Nome del dato", /.*/, "", "dataContent" + i, /.*/, ""];
        dettagli_dynamic_data['dataContent' + i] = ["valore", /.*/, ""];
        counter_valore++;
    }
    caricamento(dettagli_dynamic_data, false);
}

function addNInputPrice(divName, number) {
    var to_set = {};
    for (var i = 1; i < number; ++i) {
        to_set['price' + i] = ["", /^\d+[\.]?(\d{1,2})?$/, "Inserisci il prezzo separato da un punto"];
        to_set['format' + i] = ["", /.*/, ""];
        dettagli_dynamic_price['price' + i] = ["", /^\d+[\.]?(\d{1,2})?$/, "Inserisci il prezzo separato da un punto", "format" + i, "", /.*/, ""];
        counter_prezzo++;
    }
    caricamento(to_set, false);
}

function addInputPrice(divName) {
    var toInsert = '<li><div class="inputsL"><label for="price" class="inputL">Prezzo (es. 7.50): &euro; </label><input type="text" name="price\[\]" id="price' + (counter_prezzo + 1) + '" class="inputL"/></div><div class="inputsR"><label for="format' + (counter_prezzo + 1) + '" class="inputR">Formato (es. al pezzo):</label><input type="text" name="format\[\]" id="format' + (counter_prezzo + 1) + '" class="inputR"/></div></li>';
    counter_prezzo = addInput(divName, counter_prezzo, toInsert);
    var to_set = {};
    to_set['price' + counter_prezzo] = ["", /^\d+[\.]?(\d{1,2})?$/, "Inserisci il prezzo separato da un punto"];
    to_set['format' + counter_prezzo] = ["", /.*/, ""];
    dettagli_dynamic_price['price' + counter_prezzo] = ["", /^\d+[\.]?(\d{1,2})?$/, "Inserisci il prezzo separato da un punto", "format" + counter_prezzo, "", /.*/, ""];
    // dettagli_dynamic_price['format'+counter_prezzo]=["", /.*/, ""];
    caricamento(to_set, false);
}

function addInputData(divName) {
    var toInsert = '<li><div class="inputsL"><label for="dataName" class="inputL">Dato (es. Altezza):</label><input type="text" name="dataName\[\]" id="dataName' + (counter_valore + 1) + '" class="inputL"/></div><div class="inputsR"><label for="dataContent' + (counter_valore + 1) + '" class="inputR">Formato (es. 10cm):</label><input type="text" name="dataContent\[\]" id="dataContent' + (counter_valore + 1) + '" class="inputR"/></div></li>';
    counter_valore = addInput(divName, counter_valore, toInsert);
    dettagli_dynamic_data['dataName' + counter_valore] = ["Nome del dato", /.*/, "", "dataContent" + counter_valore, /.*/, ""];
    dettagli_dynamic_data['dataContent' + counter_valore] = ["valore", /.*/, ""];
    caricamento(dettagli_dynamic_data, false);
}

function addInput(divName, counter, toInsert) {
    var newspan = document.createElement('span');
    newspan.innerHTML = toInsert;
    document.getElementById(divName).appendChild(newspan);
    counter++;
    return counter;
}


//funzione che sostituisce l'immagine della mappa con la mappa in google maps
function replaceMap() {
    var map = document.getElementById("visualizzaMappa");
    map.innerHTML = "<iframe id='frameMappa' class='noprint' src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.6881134863825!2d11.423686315558465!3d45.49622497910131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477f379bcb0739f5%3A0x5a67551b2fe8938a!2sParrucchiera+Anna+Cortivo!5e0!3m2!1sit!2sit!4v1486045335356' allowfullscreen></iframe><img id=\"fotoMappa\" class=\"print\" src=\"img/mappa.jpg\" alt=\"Mappa della sede di Salone Anna\" />";
}
// fine

// Funzione jQuery per il pulsante dello scroll ad inizio pagina
function scroll() {
    $(function() {
        //se in cima alla pagina nascondi il box
        $("#back_to_top").hide();
        $(window).scroll(function() {
            if ($(this).scrollTop() !== 0) {
                //se non siamo in cima alla pagina
                $("#back_to_top").fadeIn(); //faccio apparire il box
            } else {
                //altrimenti (il visitatore è in cima alla pagina scrollTop = 0)
                $("#back_to_top").fadeOut(); //Il box scompare
            }
        }); //Allo scroll function

        $("#back_to_top").click(function() {
            //Se clicco sul box torno su (scrollTop:0) con un timing di animazione.
            $('html,body').scrollTop(0);
        }); //Click
    }); //DOM
}