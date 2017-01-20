<?php //file dove sono specificate le funzioni che caricano le pagine dopo che l'amministratore si è collegato
function loadPage($page) {
	if($page == 'Home') {
		loadHome();
	} elsif($page == 'Realizzazioni') {
		loadRealizzazioni();
	} elsif($page == 'Contattaci') {
		loadContattaci();
	} elsif($page == 'Prodotti') {
		loadProdotti();
	}
}

function loadHome() {
	
}

function loadRealizzazioni() {
	
}

function loadContattaci() {
	
}

function loadProdotti() {
	
}
?>