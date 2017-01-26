<?php
  session_start();
  session_regenerate_id(TRUE);

  // Controllo accesso
  if (!isset($_SESSION['username'] ) )
  {
    header('location:index.php');
    exit;
  }
  else
  {
    require 'library.php';
    $title="Prodotti: Salone Anna";
    $title_meta="Prodotti: Salone Anna";
    $descr="";
    $keywords="Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords,'');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Prodotti</strong>';
    insert_header($rif, 3, true);
    content_begin();

    hyperlink("Prodotti in esaurimento", "ProdottiQuery.php");
    hyperlink("Maggior numero di prodotti Usati", "ProdottiMax.php");
    hyperlink("Modifica Prodotti", "GestioneProdotti.php");
    hyperlink("Elimina Prodotti", "EliminaProdotti.php");
    hyperlink("Inserisci un nuovo prodotto", "InserisciProdotto.php");

	content_end();
  page_end();
}
?>