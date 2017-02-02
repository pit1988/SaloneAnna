<?php

$login=authenticate();

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    include 'utils/DBlibrary.php';
    
    $title      = "Appuntamenti Settimana: Salone Anna";
    $title_meta = "Appuntamenti Settimana: Salone Anna";
    $descr      = "";
    $keywords   = "Settimana, Appuntamenti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <strong>Appuntamenti Settimana</strong>';
    insert_header($rif, 6, true);
    content_begin();
    
    // echo "<h2>Lista degli appuntamenti da oggi in poi</h2>";
    
    $date="";
    if (!isset($_GET["date"])) {
        //setta la data ad oggi
        $date=date('j-m-Y');
    }
    else{
        // leggi la data e settala
        $date=date('j-m-Y',strtotime($_GET["date"]));
    }
    // echo $date;
    $ts = strtotime($date);
    $start = strtotime('last monday', $ts);
    $end=strtotime('next sunday', $start);
    echo "<h2>Appuntamenti dal ".date('d/m/Y', $start)." al ".date('d/m/Y', $end)."</h2>\n";

    //chiama la funzione
    $result=appuntamentiSettimana($date);
    
    //leggi array, se presente cicla sugli elementi e costruisci le tabelle
    if(count($result)>0){
        //ciclo
            //ciclo interno uguale ad elimina
        echo "<div>
            <ul>
            ";
        for($i=0; $i<count($result); $i++){
            $appuntamenti=$result[$i];
            echo "<li class=\"ggApp\">\n";
            echo "<p class=\"ggCalendario\">".$result[$i][0]."</p>\n";
            $elenco=$appuntamenti[1];
            if (count($elenco)==0)
                echo "<p class=\"inforesult\">Non ci sono appuntamenti da mostrare</p>\n";
            else {
                $str_to_print = '
                    <table class="tabApp" summary="tabella appuntamenti">
                        <caption class="nascosto">Appuntamenti relativi al $result[$i][0]</caption>
                        <thead>
                            <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Ora</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Prezzo</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                
                foreach ($elenco as $appuntamento) {
                    $str_to_print .= "
                    <tr>
                        <td>" . $appuntamento->codice . "</td>
                        <td>" . $appuntamento->nome . "</td>
                        <td>" . $appuntamento->cognome . "</td>
                        <td>" . $appuntamento->data . "</td>
                        <td>" . $appuntamento->ora . "</td>
                        <td>" . $appuntamento->tipo . "</td>
                        <td>" . $appuntamento->prezzo . "</td>
                    </tr>
                    ";
                }
                
                $str_to_print .= "</tbody></table>
                ";
                echo $str_to_print;
            }
            echo "</li>";
            // to here
        }
        echo "</ul></div>";
    }
    else
        echo "<p class=\"info\">Ci sono stati problemi nel reperire i risultati</p>\n";
    //Inserisci collegamenti a settimana precenente, odierna e successiva con la data presa in precedenza
    hyperlink("Precenente" , "AppuntamentiSettimana.php?date=".date('d-m-Y',strtotime($date.'-1 week')));
    hyperlink("Settimana odierna", "AppuntamentiSettimana.php");
    hyperlink("Successiva", "AppuntamentiSettimana.php?date=".date('d-m-Y',strtotime($date.' + 1 week')));

    unset($result);
    if (isset($msg))
        echo $msg;
/*    if (isset($str_to_print))
    echo $str_to_print;*/
    content_end();
    page_end();
}

?>