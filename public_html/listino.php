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

<h2 id="titolo-prezzi">Listino Prezzi</h2>
<table id="listino" summary="Listino prezzi Salone Anna">
<caption class="nascosto">Tabella Listino Prezzi</caption>
    <thead>
    <tr><th id="thprima"> Intervento </th> <th id="thseconda"> Prezzo </th></tr>
    </thead>
    <tbody class="corpo-tabella">
        <tr><td class="rtipo" colspan="2">Colore</td></tr>
        <tr><td class="cintervento"> Base lunghezze e punte </td><td class="cprezzo"> da &euro; 40,00 </td></tr>
        <tr><td class="rtipo" colspan="2">Base</td></tr>
        <tr><td class="cintervento"> Koleston Perfect </td><td class="cprezzo"> da &euro; 31,00 </td></tr>
        <tr><td class="cintervento"> Illumina Color </td><td class="cprezzo"> da &euro; 34,00 </td></tr>
        <tr><td class="cintervento"> Color Touch </td><td class="cprezzo"> &euro; 34,00 </td></tr>
        <tr><td class="cintervento"> Tonalizzazioni </td><td class="cprezzo"> da &euro; 5,00 </td></tr>
        <tr><td class="cintervento">  Reflex </td><td class="cprezzo"> da &euro; 15,00 </td></tr>
        <tr><td class="rtipo" colspan="2">Contrasti</td></tr>
        <tr><td class="cintervento"> Mèchès Stagnola </td><td class="cprezzo"> da &euro; 1,50 cad.una </td></tr>
        <tr><td class="cintervento"> Painting </td><td class="cprezzo"> da &euro; 45,00 </td></tr>
        <tr><td class="cintervento"> Effetti luce </td><td class="cprezzo"> da &euro; 15,00 cad.una </td></tr>
        <tr><td class="rtipo" colspan="2">Ondulazione</td></tr>
        <tr><td class="cintervento"> Completa </td><td class="cprezzo"> da &euro; 36,00 </td></tr>
        <tr><td class="rtipo" colspan="2">Taglio</td></tr>
        <tr><td class="cintervento"> Donna </td><td class="cprezzo"> da &euro; 19,00 </td></tr>
        <tr><td class="cintervento"> Uomo </td><td class="cprezzo"> da &euro; 19,00 </td></tr>
        <tr><td class="cintervento"> Bambino </td><td class="cprezzo"> da &euro; 15,00 </td></tr>
        <tr><td class="rtipo" colspan="2">Piega</td></tr>
        <tr><td class="cintervento"> Phon </td><td class="cprezzo"> da &euro; 11,00 </td></tr>
        <tr><td class="cintervento"> Phon + Piastra </td><td class="cprezzo"> da &euro; 15,00 </td></tr>
        <tr><td class="cintervento"> Bigodini </td><td class="cprezzo"> da &euro; 11,00 </td></tr>
        <tr><td class="cintervento"> Phon + Ferro </td><td class="cprezzo"> da &euro; 17,00 </td></tr>
        <tr><td class="rtipo" colspan="2">Trattamenti</td></tr>
        <tr><td class="cintervento"> Nioxin </td><td class="cprezzo"> da &euro; 40,00 </td></tr>
        <tr><td class="cintervento"> Cellophane </td><td class="cprezzo"> da &euro; 35,00 </td></tr>
        <tr><td class="cintervento"> Shampop Specifico </td><td class="cprezzo"> da &euro; 2,00 </td></tr>
        <tr><td class="rtipo" colspan="2">Stiratura</td></tr>
        <tr><td class="cintervento"> A Freddo </td><td class="cprezzo"> da &euro; 35,00 </td></tr>
        <tr><td class="cintervento"> A Caldo </td><td class="cprezzo"> da &euro; 60,00 </td></tr>
        <tr><td class="cintervento"> Curl e Relax </td><td class="cprezzo"> &euro; 35,00 </td></tr>
        <tr><td class="cintervento"> Liss&Color </td><td class="cprezzo"> da &euro; 55,00 </td></tr>
    </tbody>

</table>

<?php
	content_end();
  page_end();
?>