<?php
require 'library.php';

/* se l'utente non si è gia` autenticato, mostra nel menù le pagine accessibili al pubblico*/
session_start();

session_regenerate_id(TRUE);

$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Chi è Anna Cortivo, descrizione delle esperienze, lavori e storia.";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna, Storia";
page_start($title, $title_meta, $descr, $keywords, '');
$rif="<strong xml:lang=&quot;en&quot;>Home</strong>";
$name="visitatore";
$is_admin=false;

if (isset($_SESSION['username'] ) ) {
	$is_admin=true;
	$name = $_SESSION['username'];
}

insert_header($rif, 3, $is_admin,'');
    content_begin();
?>

<table id="listino" summary="Listino prezzi Salone Anna">
<caption class="titolo-tabella"><h3>Listino Prezzi</h3></caption>
    <thead>
    <tr><th id="thprima"> Intervento </th> <th id="thseconda"> Prezzo </th></tr>
    </thead>
    <tbody class="corpo-tabella">
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
        <tr><td class="cintervento"> Intervento </td><td class="cprezzo"> &euro; 00,00 </td></tr>
    </tbody>

</table>

<?php
	content_end();
  page_end();
?>