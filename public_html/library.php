<?php

/***************************************/
/* FUNZIONI GENERALI PER PAGINE HTML   */
/***************************************/

/* Funzione per iniziare la pagina. In input il titolo */
// inserire variabili per keywords e descrizione, titolo
function page_start($title, $title_meta, $descr, $keywords, $fun) {
    $str1='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
<title>'.trim($title).'</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="title" content="'.trim($title_meta).'"/>
<meta name="description" content="'.trim($descr).'"/>
<meta name="keywords" content="'.trim($keywords).'"/>
<meta name="author" content="Andrea Grendene, Pietro Gabelli, Sebastiano Marchesini"/>
<meta name="language" content="italian it"/>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Script-Type" content="application/javascript"/>
<link rel="stylesheet" href="css/home.css" type="text/css" media="screen and (min-width: 650px)"/>
<link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
<link rel="stylesheet" type="text/css" href="css/small-devices.css" media="screen and (max-width: 650px)"/>
<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/explorer.css"/><![endif]-->
<link rel="icon" href="img/logo2.png" type="image/png"/>
<script type="text/javascript" src="script/script.js"></script>
</head>
';
$str2='<body>';
if($fun!='')
    $str2='<body onload="'. trim($fun) . '">';
$str3='
<p class="nascosto">
<a title="salta header" href="#contenitore-menu" tabindex="1" accesskey="a">Salta l&apos;intestazione</a>
</p>
';
$to_print=$str1.$str2.$str3;
    echo  $to_print;
}
/* Funzione per terminare una pagina */
function page_end() {
    $to_print='
<div id="footer" class="footer">
<ul class="nascosto">
<li><a href="#header" title="vai-a-inizio-pagina" tabindex="1000" accesskey="i">Torna all&apos;inizio pagina</a></li>
<li><a href="#finePagina" title="vai-a-fine-pagina" tabindex="1001" accesskey="f">Vai a fine pagina</a></li>
</ul>
<div class="footer-left">
<h3 id="logo_mini"><span>Salone Anna</span></h3>
<p class="footer-nome-azienda">Salone Anna &copy; 2017</p>
</div>
<div class="footer-center">
<div>
<address class="testo-footer">Via Ludovico Ariosto, 36075 Montecchio Maggiore VI, Italy</address>
</div>
<div>
    <p class="testo-footer">tell: <a href="tel:+390444697939">+39 0444 697939</a></p>
</div>
<div>
<p xml:lang="en">E-Mail <a href="mailto:salone_anna@gmail.com" accesskey="e" tabindex="104">salone_anna@gmail.com</a></p>
</div>
<div class="testo-footer, center">
<p class="imgW3C">
<a href="http://validator.w3.org/check?uri=referer">Documento XHTML 1.0 Valido!</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS Valido</a>
</p>
</div>
</div>
<div class="footer-right">
<p class="footer-company-info" title="motto">
<span class="testo-footer">Salone Anna</span>
<span class="testo-footer">Lascia una firma professionale e di stile sul tuo capello. Salone Anna &egrave; al tuo servizio</span>
</p>
</div>
</div>
<p id="finePagina"></p>
</body>
</html>
';
    echo $to_print;
};
/*funzione per inserire l'header*/
function insert_header($pth, $num, $is_admin) {
$str1='
<div id="header">
<h1><span id="logo" class="nascosto">Salone Anna</span></h1>';
$str2='';
if($is_admin == false)
    $str2= '<div class="contentLogButton"><a id="login" href="login.php" accesskey="w" tabindex="5">Area Riservata</a></div>';
else
    $str2= '<div class="contentLogButton"><a id="logout" href="utils/logout.php" accesskey="w" tabindex="5">logout</a></div>';
$str3='
<div id="breadcrumbs">
<span id="rifnav" >Ti trovi in: '.trim($pth).'</span>
</div>';
echo $str1.$str2.$str3;
if($is_admin == true)
    contenitore_menu_admin($num);
else
    contenitore_menu($num);
echo "</div>";
}

/* funzione per inserire il menu; num serve ad evidenziare l'elemento del menu in cui si è */
function contenitore_menu($num) {
    $to_print='
<div id="contenitore-menu">
<p class="nascosto">
<a href="#content" title="salta al contenuto principale">Salta menu navigazione</a>
</p>
<ul class="menu">
<li><a href="index.php" id="home" class="'.(($num == 0) ? ("vnav"):("nav")).'" xml:lang="en" accesskey="h" tabindex="10">Home </a></li>
<li><a href="foto.php" id="foto" class="'.(($num == 1) ? ("vnav"):("nav")).'" accesskey="p" tabindex="11">Foto</a></li>
<li><a href="chi_siamo.php" id="chsia" class="'.(($num == 2) ? ("vnav"):("nav")).'" accesskey="c" tabindex="11">Chi Siamo</a></li>
<li><a href="listino.php" id="list" class="'.(($num == 3) ? ("vnav"):("nav")).'" accesskey="l" tabindex="12">Prezzi</a></li>
<li><a href="contattaci.php" id="cont" class="'.(($num == 4) ? ("vnav"):("nav")).'" accesskey="m" tabindex="13">Contattaci</a></li>
</ul>
</div>
';
    echo $to_print;
};

/* funzione per inserire il menu per l'amministratore; num serve ad evidenziare l'elemento del menu in cui si è */
function contenitore_menu_admin($num) { /*TOTO: Cambiare ordine elementi menu; sistemare tabindex ed id*/
    $to_print='
<div id="contenitore-menu-admin">
<p class="nascosto">
<a href="#content" title="salta al contenuto principale">Salta menu navigazione</a>
</p>
<ul class="menu">
<li><a href="index.php" id="home" class="'.(($num == 0) ? ("vnav"):("nav")).'" xml:lang="en" accesskey="h" tabindex="10">Home </a></li>
<li><a href="listino.php" id="list" class="'.(($num == 3) ? ("vnav"):("nav")).'" accesskey="l" tabindex="12">Prezzi</a></li>
<li><a href="Immagini.php" id="insf" class="'.(($num == 1) ? ("vnav"):("nav")).'" accesskey="c" tabindex="13">Immagini</a></li>
<li><a href="Prodotti.php" id="prod" class="'.(($num == 4) ? ("vnav"):("nav")).'" accesskey="p" tabindex="15">Prodotti </a></li>
<li><a href="Clienti.php" id="clie" class="'.(($num == 5) ? ("vnav"):("nav")).'" accesskey="c" tabindex="14">Clienti</a></li>
<li><a href="Appuntamenti.php" id="apps" class="'.(($num == 6) ? ("vnav"):("nav")).'" accesskey="a" tabindex="16">Appuntamenti</a></li>
<li><a href="Utilita.php" id="msgs" class="'.(($num == 7) ? ("vnav"):("nav")).'" accesskey="a" tabindex="17">Utilità</a></li>
</ul>
</div>
';
    echo $to_print;
};

/*funzione per inserire l'inizio del content*/
function content_begin() {
    echo<<<END
<div id="content">
<p class="nascosto">
    <a title="saltare-contenuto-testuale" href="#footer" tabindex="30" accesskey="b">Salta il contenuto testuale</a>
</p>\n
END;
};

//funzione per inserire la fine del content
function content_end() {
    echo "</div>";
};

/* funzione per il sottotitolo */
function subtitle($str) {
    echo "<h3>$str</h3>";
};

/* Funzione che ritorna un link, associato ad una URL. */
function hyperlink($str, $url) {
    echo "<p><a class=\"createButton\" href=\"$url\">$str</a></p>";
};

/***************************************/
/* FUNZIONI PER LA GESTIONE DI TABELLE */
/***************************************/

/* Funzione per iniziare una tabella html. In input l'array degli
header delle colonne */
function table_start($row) {
    echo "<table border=\"1\">";
    echo "<tr>";
    foreach ($row as $field) 
        echo "<th>$field</th>";
    echo "</tr>";
};

/* funzione per stampare un array, come riga di tabella html */
function table_row($row) {
    echo "<tr>";
    foreach ($row as $field) 
        if ($field)
        echo "<td>$field</td>\n";
        else
        echo "<td>---</td>\n";
        echo "</tr>";
};

/* funzione per chiudere una tabella html */
function table_end() {
    echo "</table>";
};

/*funzione per la generazione di form*/
    function form_start($type, $dest){
      echo"<form method='$type' action='$dest'>";
      echo"<fieldset>";
    };
    
   //funzione per la chiusura d'una form 
    function form_end(){
      echo"<input type='submit' name='submit' value='Procedi'>";
      echo"<input type='reset' value='Cancella'>";
      echo"</fieldset>";
      echo"</form>";
    };


/***************************************/
/* FUNZIONI PER AUTENTICAZIONE         */
/***************************************/

function checkSessionLifetime() { 
    if (isset($_SESSION['creazione']) && (time() - $_SESSION['creazione'] > 3600)) {
        //la sessione è stata creata almeno un'ora fa
		$sname=session_name();
		session_unset(); //questa funzione elimina le variabili contenute nella sessione
		session_destroy();
		if (isset($_COOKIE['username'])) {
	  		setcookie($sname,'', time()-3600,'/');
		}
    	return false;
    }
    return true;
};

function checkLog() {
    if(isset($_SESSION) && checkSessionLifetime()) { //la prima funzione controlla se è stata creata una sessione, se ci sono errori ho qualche altra variante da poter provare, la seconda invece fa il controllo del tempo di vita della sessione, non ho usato altri metodi più semplici per vari motivi che spiego a voce
        return true;
    } else {
        return false;
    }
};

function new_user($login, $password) { 
    /* si connette e seleziona il database da usare */
    $dbname="login-ES";
    $conn = dbConnect($dbname);
    /* preparazione dello statement */
    $query= sprintf("INSERT INTO Eser5Users VALUES (\"%s\", \"%s\")", 
                    $login, SHA1($password));
    /* Stampa la query a video ... utile per debug */
    /* echo "<B>Query</B>: $query <BR />"; */
    mysqli_query($conn, $query)
        or die("Query fallita" . mysqli_error($conn));
};



?>

