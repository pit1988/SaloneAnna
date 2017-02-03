<?php
require 'library.php';
include 'utils/DBlibrary.php';

/* se l'utente non si è gia` autenticato, mostra nel menù le pagine accessibili al pubblico*/
$login=authenticate();

$title      = "Salone Anna | Chi è Anna Rosa Cortivo";
$title_meta = "Salone Anna | Chi Siamo";
$descr      = "Chi è Anna Rosa Cortivo, descrizione delle esperienze, lavori e storia.";
$keywords   = "Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna, Storia, Anna, Cortivo";
page_start($title, $title_meta, $descr, $keywords, '');
$rif      = '<a href="index.php" xml:lang="en">Home</a> / <strong>Chi Siamo</strong>';
$is_admin = false;
$name     = "visitatore";

if ($login) {
    $is_admin = true;
    content_begin();
    $rif  = '<a href="index.php" xml:lang="en">Home</a> / <a href="Immagini.php">Immagini</a> / <strong>Foto</strong>';
}

insert_header($rif, 2, $is_admin, '');
content_begin();
$to_print="
<p class=\"center\">\"Quando i miei clienti mi si affidano per tagliare loro i capelli, \" afferma Anna Cortivo \" inevitabilmente mi rendo conto di avere tra le mani qualcosa di estremamente importante, capisco di dovere affrontare ogni diversa personalit&agrave;, ogni singolo caso, con profonda responsabilit&agrave; e rispetto. Considero questa professione, che più che aver scelto mi ha scelto, un complesso di sfumature che ben al di l&agrave; del mero aspetto estetico si spingono a lambire una sfera pi&ugrave; intima e, oserei dire, psicologica ed emozionale.\"</p>
<p class=\"center\">Il suo destino era proprio scritto nei capelli. Anna Cortivo nasce figlia d'arte. Oggi Anna &egrave; tra i pi&ugrave; affermati <span xml:lang=\"en\">hairdresser</span> della provincia, con base a Montecchio Maggiore. La sua particolare visione creativa si distingue innanzitutto per la cura oltremodo personale, <span xml:lang=\"en\">customized</span>, totalmente indipendente e immediata del suo approccio. Vicepresidente del consorzio di Vicenza Parrucchieri, Anna ha seguito sulle passerelle italiane grandi stilisti internazionali, imponendosi in vari <span xml:lang=\"en\">hair show</span> di rilievo. Vicintrice di un concorso di <span xml:lang=\"en\">concept moda</span> a Milano. La successiva tappa professionale lo vede dedicarsi al 100% alle sue clienti.</p>
<p class=\"center\">La filosofia dell'<span xml:lang=\"en\">hair styling</span> Anna si sviluppa intorno a una serie di concetti e attuazioni fondamentali. Si tratta di un cocktail speciale, unico, nutrito di estro, fantasia, di un gusto oltremodo sicuro, versatile e caratterizzato da una padronanza tecnica eccezionale e in continuo aggiornamento. Alla spiccata e fluida geometria delle forme, a una rigorosa ricerca sulle proporzioni e a una raffinata e insieme basica armonia con lo stile personale di ognuno, Anna accosta il potenziamento delle attitudini e il profondo rispetto per la natura di ogni capello, inteso come materiale prezioso da valorizzare.</p>";
echo $to_print;
content_end();
page_end();
?>
