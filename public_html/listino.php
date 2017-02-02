<?php
require 'library.php';
require 'utils/DBlibrary.php';

/* se l'utente non si è gia` autenticato, mostra nel menù le pagine accessibili al pubblico*/
$login=authenticate();

$title="Listino prezzi Salone Anna";
$title_meta="Listino prezziSalone Anna, parrucchiere a Vicenza";
$descr="";
$keywords="Listino, Prezzi, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna, Storia";
page_start($title, $title_meta, $descr, $keywords, '');
$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Prezzi</strong>';
$is_admin=false;

if (checkLog() ) {
	$is_admin=true;
}

insert_header($rif, 3, $is_admin,'');
content_begin();
?>

<h2 id="titolo-prezzi">Listino Prezzi</h2>
<table id="listino" summary="Listino prezzi Salone Anna">
<caption class="nascosto">Tabella Listino Prezzi</caption>
    <thead>
    <tr><th id="c1" class="thprima"> Intervento </th> <th id="c2" class="thseconda"> Prezzo </th></tr>
    </thead>
    <tbody class="corpo-tabella">
        <tr><th id="g1" class="rtipo" colspan="2" scope="colgroup">Colore</th></tr>
        <tr><td headers="c1 g1" class="cintervento"> Base lunghezze e punte </td><td headers="c2 g1" class="cprezzo"> da &euro; 40,00 </td></tr>
        <tr><th id="g2" class="rtipo" colspan="2" scope="colgroup">Base</th></tr>
        <tr><td headers="c1 g2" class="cintervento"> Koleston Perfect </td><td headers="c2 g2" class="cprezzo"> da &euro; 31,00 </td></tr>
        <tr><td headers="c1 g2" class="cintervento"> Illumina Color </td><td headers="c2 g2" class="cprezzo"> da &euro; 34,00 </td></tr>
        <tr><td headers="c1 g2" class="cintervento"> Color Touch </td><td headers="c2 g2" class="cprezzo"> &euro; 34,00 </td></tr>
        <tr><td headers="c1 g2" class="cintervento"> Tonalizzazioni </td><td headers="c2 g2" class="cprezzo"> da &euro; 5,00 </td></tr>
        <tr><td headers="c1 g2" class="cintervento">  Reflex </td><td headers="c2 g2" class="cprezzo"> da &euro; 15,00 </td></tr>
        <tr><th id="g3" class="rtipo" colspan="2" scope="colgroup">Contrasti</th></tr>
        <tr><td headers="c1 g3" class="cintervento"> Mèchès Stagnola </td><td headers="c2 g3" class="cprezzo"> da &euro; 1,50 cad.una </td></tr>
        <tr><td headers="c1 g3" class="cintervento"> Painting </td><td headers="c2 g3"  class="cprezzo"> da &euro; 45,00 </td></tr>
        <tr><td headers="c1 g3" class="cintervento"> Effetti luce </td><td headers="c2 g3"  class="cprezzo"> da &euro; 15,00 cad.una </td></tr>
        <tr><th id="g4" class="rtipo" colspan="2" scope="colgroup">Ondulazione</th></tr>
        <tr><td headers="c1 g4" class="cintervento"> Completa </td><td headers="c2 g4" class="cprezzo"> da &euro; 36,00 </td></tr>
        <tr><th id="g5" class="rtipo" colspan="2" scope="colgroup">Taglio</th></tr>
        <tr><td headers="c1 g5" class="cintervento"> Donna </td><td headers="c2 g5" class="cprezzo"> da &euro; 19,00 </td></tr>
        <tr><td headers="c1 g5" class="cintervento"> Uomo </td><td headers="c2 g5" class="cprezzo"> da &euro; 19,00 </td></tr>
        <tr><td headers="c1 g5" class="cintervento"> Bambino </td><td headers="c2 g5" class="cprezzo"> da &euro; 15,00 </td></tr>
        <tr><th id="g6" class="rtipo" colspan="2" scope="colgroup">Piega</th></tr>
        <tr><td headers="c1 g6" class="cintervento"> Phon </td><td headers="c2 g6" class="cprezzo"> da &euro; 11,00 </td></tr>
        <tr><td headers="c1 g6" class="cintervento"> Phon + Piastra </td><td headers="c2 g6" class="cprezzo"> da &euro; 15,00 </td></tr>
        <tr><td headers="c1 g6" class="cintervento"> Bigodini </td><td headers="c2 g6" class="cprezzo"> da &euro; 11,00 </td></tr>
        <tr><td headers="c1 g6" class="cintervento"> Phon + Ferro </td><td headers="c2 g6" class="cprezzo"> da &euro; 17,00 </td></tr>
        <tr><th id="g7" class="rtipo" colspan="2" scope="colgroup">Trattamenti</th></tr>
        <tr><td headers="c1 g7" class="cintervento"> Nioxin </td><td headers="c2 g7" class="cprezzo"> da &euro; 40,00 </td></tr>
        <tr><td headers="c1 g7" class="cintervento"> Cellophane </td><td headers="c2 g7" class="cprezzo"> da &euro; 35,00 </td></tr>
        <tr><td headers="c1 g7" class="cintervento"> Shampop Specifico </td><td headers="c2 g7" class="cprezzo"> da &euro; 2,00 </td></tr>
        <tr><th id="g8" class="rtipo" colspan="2" scope="colgroup">Stiratura</th></tr>
        <tr><td headers="c1 g8" class="cintervento"> A Freddo </td><td headers="c2 g8" class="cprezzo"> da &euro; 35,00 </td></tr>
        <tr><td headers="c1 g8" class="cintervento"> A Caldo </td><td headers="c2 g8" class="cprezzo"> da &euro; 60,00 </td></tr>
        <tr><td headers="c1 g8" class="cintervento"> Curl e Relax </td><td headers="c2 g8" class="cprezzo"> &euro; 35,00 </td></tr>
        <tr><td headers="c1 g8" class="cintervento"> Liss&amp;Color </td><td headers="c2 g8" class="cprezzo"> da &euro; 55,00 </td></tr>
    </tbody>

</table>

<?php
	content_end();
  page_end();
?>