<?php
include 'DBlibrary.php';
include 'library.php';
if (isset($_POST['submit'])) {
    if (!isset($_POST['TipoAppuntamento']) OR !isset($_POST['first_name']) OR !isset($_POST['last_name']) OR !isset($_POST['data']) OR !isset($_POST['orario'])) { //OR !isset($_POST['costo']) OR !isset($_POST['sconto'])) {
        $err = "Almeno uno dei parametri non è stato inserito correttamente";
    } else {
        $sub     = $_POST['submit'];
        $tipo    = $_POST['TipoAppuntamento'];
        $nome    = $_POST['first_name'];
        $cognome = $_POST['last_name'];
        $date    = $_POST['data'];
        $time    = $_POST['orario'];
/*        $costo   = $_POST['costo'];
        $sconto  = $_POST['sconto'];*/
        
        if (strlen($tipo) == 0 OR strlen($nome) == 0 OR strlen($cognome) == 0 OR strlen($date) == 0 OR strlen($time) == 0) //OR strlen($costo) == 0 OR strlen($sconto) == 0)
            $err = "Almeno uno dei parametri non è stato inserito correttamente";
        else {
            $orario     = date_create_from_format('H:i', $time);
            $data       = date_format(date_create_from_format('d/m/Y', $date), 'Y-m-d');
            $dataora = date('Y-m-d H:i:s', strtotime("$data $orario"));
            echo $dataora;
            
            $conn        = dbConnect();
            $queryc      = ("select * from Clienti c where c.Nome = $nome and c.Cognome = $cognome");
            $result      = mysql_query(queryc);
            $number_rows = mysql_num_rows($result);
            if ($number_rows > 1) {
                echo "<p>Più clienti hanno si chiamano ".$nome." ".$cognome.", scegline uno:</p>";
                $number_cols = mysql_num_fields($result);
                form_start("POST", "confermaAppuntamento.php");
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
                
                $tf       = "</tbody></table>";
                $to_print = $th . $tb . $tf;
                echo $to_print;
                echo "<input type='submit' name='submit' value='Procedi'>";
                echo "<input type='reset' value='Cancella'>";
                // echo"</fieldset>";
                echo "</form>";
            } //fine n_righe>1
            if(!isset($_POST['CodCliente'])) {
            	$CodClienteA = mysqli_query($conn, "SELECT RitCod('$nome', '$cognome')") or die("Query fallita " . mysqli_error($conn));
            	$CodCliente = mysqli_fetch_row($CodClienteA);
            }
            else
            	$CodCliente=$_POST['CodCliente'];

            if (isset($submit)) {
                $query = "INSERT INTO Appuntamenti (CodCliente ,  DataOra ,  CodTipoAppuntamento) values
	      	('$CodCliente', '$dataora', '$tipo')";
                
                $ok = mysqli_query($conn, $query);
    			if($ok)                
                	echo "<b>Appuntamento di $nome inserito correttamente il $date alle $time</b><br>";
                
            }
            mysqli_close($conn);
        }
    }
}
?>
