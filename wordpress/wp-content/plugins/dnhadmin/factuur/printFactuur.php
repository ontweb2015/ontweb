<?php
function createInvoice()
{
	if(isset($_GET['page']) && $_GET['page']== 'printFactuur'){
		include ('factuur_functions.php');
		//Om het dompdf script te gebruiken is het nodig om het eerst in te laden.*/
		require_once ("dompdf/dompdf_config.inc.php");
		require_once ('factuur_functions.php');
		// Connectie met de database.
		global $wpdb;
		//lidnummer ophalen uit de url
		if (isset($_GET['lidnr'])) {
			$lidnr = $_GET['lidnr'];
		}
		else{
			$lidnr = 0;
		}
		createHtml($lidnr);
		//In de variabele dompdf wordt een nieuwe dompdf aangemaakt.
		$dompdf = new DOMPDF();
		//Hier wordt de html variabele in ingeladen
		$dompdf -> load_html($html);
		//Deze wordt omgezet naar een pdf
		$dompdf -> render();
		/*En wordt doorgestuurd naar de pc van de gebruiker. Deze krijgt een "opslaan als"
 		venster te zien, waar hij zelf kan beslissen waar de file opgeslagen moet worden.*/
		$dompdf -> stream("sample.pdf");
	}
}

