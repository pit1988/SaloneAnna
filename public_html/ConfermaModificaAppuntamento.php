
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
} else {
    if (!isset($_POST['submit'])) {
        header('loation:ScegliAppuntamento.php');
    } else {
        require 'library.php';
        include 'utils/DBlibrary.php';
        
        $title      = "Modifica appuntamento: Salone Anna";
    $title_meta = "Modifica appuntamento: Salone Anna";
    $descr      = "";
    $keywords   = "Modifica, Appuntamento, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
    
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif = '<a href="index.php" xml:lang="en">Home</a> / <a href="Appuntamenti.php">Appuntamenti</a> / <a href="ScegliAppuntamento.php">Modifica Appuntamento</a> / <strong>Inserisci valori</strong>';
    insert_header($rif, 4, true);
        content_begin();
        
        if (!isset($_POST['TipoAppuntamento']) OR !isset($_POST['first_name']) OR !isset($_POST['last_name']) OR !isset($_POST['data']) OR !isset($_POST['orario'])) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
            $err = "Almeno uno dei parametri non è stato inserito correttamente";
        } else {
            $sub = $_POST['submit'];
            $tipo = $_POST['TipoAppuntamento'];
            $nome = $_POST['first_name'];
            $cognome = $_POST['last_name'];
            $date = $_POST['data'];
            $time = $_POST['orario'];
            $cod = $_POST['CodAppuntamento'];
            
            if (strlen($tipo) == 0 OR strlen($nome) == 0 OR strlen($cognome) == 0 OR strlen($date) == 0 OR strlen($time) == 0 OR strlen($cod) == 0) //OR strlen($costo) == 0 OR strlen($sconto) == 0)
                $err = "Almeno uno dei parametri non è stato inserito correttamente";
            else {
                $orario = $time.":00";
                $data = date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d');
                $dataora = date('Y-m-d H:i:s', strtotime("$data $orario"));
                
                
                $conn = dbConnect();
                $queryc = "SELECT * FROM Clienti c WHERE c.Nome = '$nome' AND c.Cognome = '$cognome'";
                
                $result = mysqli_query($conn, $queryc);
                $number_rows = mysqli_num_rows($result);
                if ($number_rows > 1) {
                    echo "<p>Più clienti hanno si chiamano " . $nome . " " . $cognome . ", scegline uno:</p>";
                    $number_cols = mysqli_num_fields($result);
                    form_start("POST", "confermaModificaAppuntamento.php");
                    $th = '<table id="ProdottiMagazzino" summary="Prodotti in magazzino">
	            <caption>Prodotti modificabili</caption>
	            <thead>
	                <tr>
	                    <th scope="col">Codice Cliente</th>
	                    <th scope="col">Nome</th>
	                    <th scope="col">Cognome</th>
	                    <th scope="col">Telefono</th>
	                    <th scope="col">Email</th>
	                    <th scope="col">Data di nascita</th>
	                </tr>
	            </thead>
	            <tbody>
	            ';
                    $tb = "";
                    //corpo tabella
                    while ($row = mysqli_fetch_row($result)) {
                        
                        $tb .= "<tr>\n";
                        for ($i = 0; $i < $number_cols + 1; $i++) {
                            $tb .= "<td>";
                            if (!isset($row[$i]))
                                $tb .= " ";
                            if ($i == 0)
                                $tb .= "<input type=\"radio\" name=\"CodCliente\" value= \"" . $row[$i] . "\"\/>";
                            else {
                                $tb .= $row[$i - 1];
                            }
                            
                            $tb .= "</td>\n";
                        }
                        $tb .= "</tr>\n";
                    }
                    
                    $tf = "</tbody></table>";
                    $to_print = $th . $tb . $tf;
                    echo $to_print;
                    echo "<input type='submit' name='submit' value='Procedi'>";
                    echo "<input type='reset' value='Cancella'>";
                    // echo"</fieldset>";
                    echo "</form>";
                } //fine n_righe>1
                if (!isset($_POST['CodCliente'])) {
                	$query="SELECT CodCliente FROM Clienti c WHERE c.Nome = '$nome' AND c.Cognome = '$cognome'";
                    $CodClienteA = mysqli_query($conn, $query); //or die("Query fallita " . mysqli_error($conn));
                    $CodCliente = mysqli_fetch_row($CodClienteA)[0];
                } else
                    $CodCliente = $_POST['CodCliente'];
                
                $query = "UPDATE Appuntamenti SET CodCliente='$cod', DataOra='$dataora' ,  CodTipoAppuntamento='$tipo' Where CodAppuntamento='$cod'";
		      	
                $ok = mysqli_query($conn, $query);
                if ($ok)
                    echo "<b>L'appuntamento di $nome è stato modificato correttamente ed è il $date alle $time</b><br>";
                else
                	echo "<p>Non è stato possibile modificare l'appuntamento selezionato</p>";
                mysqli_close($conn);
            }
            echo 'Vuoi modificare altri appuntamenti? Torna a <a href="ScegliAppuntamento.php">Scegli Appuntamento</a>';
            content_end();
            page_end();
        }
    }
}
?>