<?php

function getAppuntamentiData($date){
	if(preg_match("#^[0-9]{2}[-]{1}[0-9]{2}[-]{1}[0-9]{4}$#", $data)){
		$ts = date_format(date_create_from_format("d-m-Y", strtotime($date)), "Y-m-d");
		$result = eseguiQuery("SELECT CodAppuntamento, DataOra, NomeTipo, Costo, Sconto, Nome, Cognome, Telefono, Email
		FROM Appuntamenti JOIN TipoAppuntamento ON Appuntamenti.CodTipoAppuntamento=TipoAppuntamento.CodTipoAppuntamento JOIN Clienti ON Appuntamenti.CodCliente=Clienti.CodCliente
		WHERE DATE(DataOra)='$ts'
		ORDER BY DataOra DESC");
		if(!$result) {$appuntamenti = NULL;} //il valore NULL segnala che c'è stato un errore nella connessione o nell'esecuzione della query
		else {
			$appuntamenti = array();
			while($appuntamento = mysqli_fetch_assoc($result)) {
				if($appuntamento['DataOra'] !== NULL) {
					$time = strtotime($appuntamento['DataOra']);
					$data = date("d/m/Y", $time); //formato del tipo 05/01/2017
					$ora = date("H:i", $time); //formato del tipo 23:46
				}
				else {$data = NULL; $ora = NULL;}
				$prezzo = round($appuntamento['Costo'] * ((100-$appuntamento['Sconto'])/100), 2); //round arrotonda il numero alla seconda cifra decimale
				array_push($appuntamenti, new Appuntamento($appuntamento['CodAppuntamento'], $data, $ora, $appuntamento['NomeTipo'], $prezzo, $appuntamento['Nome'], $appuntamento['Cognome'], $appuntamento['Telefono'], $appuntamento['Email']));
			}
		}
	return $appuntamenti;
	}	
	else return false;
}

function appuntamentiSettimana($date) {
	if(preg_match("#^[0-9]{2}[-]{1}[0-9]{2}[-]{1}[0-9]{4}$#", $data)){
		$ts = strtotime($date);
		$start = strtotime('last monday', $ts);
		$end=strtotime('next sunday', $start);
		$result= array();
		//start date
		$date = date('Y-m-d',$start);
		// End date
		$end_date = date('Y-m-d',$end);

		while (strtotime($date) <= strtotime($end_date)) {
	        $i=date('d-m-Y',strtotime($date));
	        $app_date=getAppuntamentiData($i);
	        $p_date=date('l d-m-Y',strtotime($date));
	        array_push($result, array($p_date, $app_date ));
	        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		}
		return $result;
	}	
	else return false;
}
?>
