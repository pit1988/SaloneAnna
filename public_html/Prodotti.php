<?php
  require 'library.php';
  require 'utils/DBlibrary.php';
  $login=authenticate();

  // Controllo accesso
  if (!$login )
  {
    header('location:index.php');
    exit;
  }
  else
  {
    $title="Prodotti: Salone Anna";
    $title_meta="Prodotti: Salone Anna";
    $descr="";
    $keywords="Prodotti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords,'');
    $rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Prodotti</strong>';
    insert_header($rif, 4, true);
    content_begin();

    echo "<h2>Menù Prodotti</h2>";

    hyperlink("Prodotti in esaurimento", "ProdottiQuery.php");
    hyperlink("Maggior numero di prodotti Usati", "ProdottiMax.php");
    hyperlink("Associa prodotti ad un appuntamento", "ProdottiClienteAppuntamento.php");
    // hyperlink("Modifica Prodotti", "ScegliProdotto.php");
    hyperlink("Elimina Prodotti", "EliminaProdotti.php");
    hyperlink("Inserisci un nuovo prodotto", "NuovoProdotto.php");
    hyperlink("Storico Prodotti","StoricoProd.php");
    hyperlink("Inventario","Inventario.php");

	content_end();
  page_end();
}
?>