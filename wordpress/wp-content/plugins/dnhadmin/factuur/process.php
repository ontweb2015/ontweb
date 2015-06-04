<?php
/*******************************************************************************************************
 Plugin: DNHAdmin
 Script: factuur/process.php
 Doel  : Alles voor het maken van een factuur
 Auteur: Maaike
 *******************************************************************************************************/

/****************************************************************
 Aanmaken van een factuur
 Dit wordt aangeroepen bij het aanmaken van een factuur
 *****************************************************************/
// De Action Hook
add_action('admin_post_dnh_download_factuur', 'createInvoice');
// De functie
function createInvoice() {
	if (isset($_GET['lidnr'])) {
		include ('factuur_functions.php');
		//Om het dompdf script te gebruiken is het nodig om het eerst in te laden.*/
		require_once ("dompdf/dompdf_config.inc.php");
		require_once ('factuur_functions.php');
		// Connectie met de database.
		global $wpdb;
		//lidnummer ophalen uit de url
		$lidnr = $_GET['lidnr'];
		$data = buildData($lidnr);
		$html = createHtml($data);
		//In de variabele dompdf wordt een nieuwe dompdf aangemaakt.
		$dompdf = new DOMPDF();
		//Hier wordt de html variabele ingeladen
		$dompdf -> load_html($html);
		//Deze wordt omgezet naar een pdf
		$dompdf -> render();
		/*En wordt doorgestuurd naar de pc van de gebruiker. Deze krijgt een "opslaan als"
		 venster te zien, waar hij zelf kan beslissen waar de file opgeslagen moet worden.*/
		$dompdf -> stream("sample.pdf");

		// Redirect voorbereiden
		$qvars = array('page' => 'dnh_leden', 'dnh_ntc' => 'printed', 'dnh_ntm' => urlencode('Factuur is succesvol geprint'));

	} else {
		// Redirect met foutbericht voorbereiden
		$error_message = "Er is geen lidnummer meegestuurd met de request. Factuur kon niet gemaakt worden.";
		$qvars = array('page' => 'dnh_leden', 'dnh_ntc' => 'error', 'dnh_ntm' => urlencode($error_message));
	}
	wp_redirect(add_query_arg($qvars, admin_url('admin.php')));
	exit ;
}


?>