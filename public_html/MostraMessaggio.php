<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    require 'library.php';
    include 'utils/DBlibrary.php';
    if (!$_GET["codmsg"]) {
        $err = "Non è stato selezionato alcun messaggio, torna a <a href=\"Messaggi.php\" e riprova";
    } else {
        $cmsg = $_GET["codmsg"];
        $query  = "SELECT c.Nome, c.Cognome, m.Contenuto, m.DataOra, c.Telefono, c.Email FROM Messaggi m JOIN Clienti c WHERE m.CodCliente=c.CodCliente AND m.CodMessaggi='$cmsg'";
        $conn     = dbconnect();
        $result   = mysqli_query($conn, $query);
        // nessun risultato
        $num_rows = mysqli_num_rows($result);
        if (!$num_rows)
            echo "<p>Non è presente il messaggio richiesto</p>";
        else {
            $row      = mysqli_fetch_row($result);
            $to_print = '
        <ul>
			<li><p><em>Messaggio inviato da:</em>' . $row[0] . ' ' . $row[1] . '</p></li>
			<li><p><em>Ricevuto: </em>' . date("d/m/Y H:i", strtotime($row[3])) . '</p></li>
			<li><p><em>Telefono cliente: </em><a href="tel: ' . $row[4] . '"">' . $row[4] . '</a> ; <em xml:lang="en">email:</em> <a href="mailto:' . $row[5] . '"">' . $row[5] . '</a></p></li>
			<li><p><em>Contentuto: </em>' . $row[2] . '</p></li>
		</ul>
        ';
            $qr2      = "UPDATE Messaggi SET ToRead='false' WHERE CodMessaggi='$cmsg'";
            $result   = mysqli_query($conn, $qr2);
        }
    }
    
    $title      = "Messaggi: Salone Anna";
    $title_meta = "Messaggi: Salone Anna";
    $descr      = "";
    $keywords   = "Messaggi, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Messaggi.php">Messaggi</a> / <strong>Leggi Messaggio</strong>';
    insert_header($rif, 6, true);
    content_begin();
    if (isset($err))
        echo $err;
    if (isset($to_print))
        echo $to_print;
    content_end();
    page_end();
}

?>