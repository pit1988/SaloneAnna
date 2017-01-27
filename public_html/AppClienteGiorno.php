<?php
session_start();
session_regenerate_id(TRUE);
// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} elseif (!isset($_POST['submit']) OR !isset($_POST['cli']) OR !isset($_POST['data'])) {
    $err = "<p>Problemi di connessione, <a href=\"RicercaAppuntamenti.php\"> segui il link per tornare alla pagina di ricerca</a>";
} else {

    require 'library.php';
    require 'utils/DBlibrary.php';
    $title      = "Ricerca Appuntamento: Salone Anna";
    $title_meta = "Ricerca Appuntamento: Salone Anna";
    $descr      = "";
    $keywords   = "Appuntamento, Ricerca, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="RicercaAppuntamento.php">Ricerca Appuntamento</a> / <strong>Risultati</strong>';
    insert_header($rif, 4, true);
    content_begin();

	include ("utils/DBlibrary.php");
	$conn = dbconnect();

	$s_client = $_POST['cli'];
	$s_data = $_POST['data'];
	echo $s_client.$s_data;
/*
	if (($s_client==true && (!isset($_POST['first_name']) OR !isset($_POST['last_name']))) OR ($s_data==true && (!isset($_POST['data'])))) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
            $err = "Almeno uno dei parametri non è stato inserito correttamente";
        } else {
            $sub = $_POST['submit'];
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $date = $_POST['date'];
            $time = $_POST['orario'];
            
            if (strlen($nome) == 0 OR strlen($cognome) == 0 OR strlen($date) == 0 OR strlen($time) == 0) //OR strlen($costo) == 0 OR strlen($sconto) == 0)
                $err = "Almeno uno dei parametri non è stato inserito correttamente";
            else {
                $orario = $time.":00";
                $data = date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d');
                $dataora = date('Y-m-d H:i:s', strtotime("$data $orario"));
                
                
                $conn = dbConnect();

	$data=isset($_POST["data"])?$_POST["data"]:"";
	$cliente=isset($_POST["cli"])?$_POST["cli"]:"";


	if( !$data && !$cliente ) {
		echo "<b>Devi selezionare almeno una delle due ricerche!</b><br>";
		header('Location: RicercaAppuntamenti.php'); 
	};

	$query="
	SELECT c.Nome, c.Cognome, a.DataOra
	FROM Clienti c JOIN Appuntamenti a";

	$where=" WHERE TRUE";

	if($data){
		$where .= " AND DATE(a.DataOra)=\"'$app'\"";
		if($hh) $where .=" AND HOUR(a.DataOra)>=\"'$hh.'\"";
	};
	if($cliente){
		if(!$nome || !$cognome) echo "La ricerca per cliente non e' andata a buon fine per mancanza di campi <br>";
		else $where .=" AND c.Nome=\"'$nome'\"AND c.Cognome=\"'$cognome'\"";
	};

	$query= $query . $where;
			
	$result = $conn->query($query);

	$number_cols = mysqli_num_fields($result);

	echo "<b>Storico:</b>";
	echo "<table border = 1>\n";
	echo "<tr align=center>\n";

	for($i=0; $i<$number_cols; $i++)
		{
			// echo "<th>" . mysql_field_name ($result, $i). "</th>\n";
			echo "<th>" . mysqli_field_seek ($result, $i). "</th>\n";
		}
	echo "</tr>\n";

	//intestazione tabella

	//corpo tabella
	while ($row = mysqli_fetch_row($result))
	{
		echo "<tr align=left>\n";

		for ($i=0; $i<$number_cols; $i++) {
			echo "<td>";
			if(!isset($row[$i]))
			  {echo "NULL";}
			else
			  {echo $row[$i];}
			echo "</td>\n";
		}
	echo "</td>\n";
	}

	echo "</table>";

	mysqli_close($conn);
}
	    
} */
content_end();
    page_end();
}
?>
