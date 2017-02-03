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
    $title="Menù Prodotti | Salone Anna";
    $title_meta="Menù Prodotti | Salone Anna";
    $descr="Menù per gestire i prodotti del Salone Anna";
    $keywords="Prodotti, Esaurimento, Classifica, Modifica, Elimina, Inserisci, Storico, Inventario";
    
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