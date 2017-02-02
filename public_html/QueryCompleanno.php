<?php

$login=authenticate();

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    $title      = "Compleanni: Salone Anna";
    $title_meta = "Compleanni: Salone Anna";
    $descr      = "";
    $keywords   = "Compleanni, Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Clienti.php">Clienti</a> / <strong>Compleanni nel mese</strong>';
    insert_header($rif, 5, true);
    content_begin();
    echo "<h2>Compleanni questo mese</h2>";
    
    include("utils/DBlibrary.php");
    
    $result   = elencoClientiCompleanni();
    $num_rows = count($result);
    if($num_rows>1)
        echo "<p class=\"inforesult\">Ci sono $num_rows persone che compiono gli anni nei prossimi 31 giorni</p>\n";
    if($num_rows==1)
        echo "<p class=\"inforesult\">C'è un cliente che compie gli anni entro i prossimi 31 giorni</p>\n";
    $tb = "";
    if ($num_rows>0) {
        $th = '<table id="clientiTab" summary="Elenco clienti">
            <caption class="nascosto">Elenco clienti che compiono gli anni nei prossimi 31 giorni</caption>
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Telefono</th>
                    <th scope="col" xml:lang="en">E-mail</th>
                    <th scope="col">Data nascita</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($result as $cliente) {
            $tb .= "
              <tr>
                <td>" . $cliente->nome . "</td>
                <td>" . $cliente->cognome . "</td>
                <td>" . $cliente->telefono . "</td>
                <td>" . $cliente->email . "</td>
                <td>" . $cliente->dataNascita . "</td>
              </tr>";
        }
        $tf       = "</tbody></table>";
        $str_to_print = $th . $tb . $tf;
    } else
        $str_to_print = "<p class=\"inforesult\">Non sono presenti clienti che compiono gli anni nei prossimi 31 giorni</p>";
    unset($result);
    if(isset($str_to_print))
        echo $str_to_print;
    if (isset($err))
        echo $err;
    content_end();
    page_end();
}

?>
