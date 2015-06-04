<?php
add_action("admin_post_dnh_upload_transactions", "dnh_upload_transactions");

/**
 * Dit script converteert een .csv-bestand(comma separated file) in een array, welke om wordt gezet in een SQL insert statement.
 *
 */
function dnh_upload_transactions() {
	$filename = $_FILES["file"]["tmp_name"];

	$queryLine = csv_to_array($filename);
	global $wpdb;	
	foreach ($queryLine as $i => $temp) {
		if (count($temp) <= 1) {
			continue;
		}

		$wpdb -> insert('transactie', 
				array(
					'Bedrag' => (float)($temp[3] == D ? $temp[4] : $temp[4] * -1), 
					'Datum' => substr($temp[7], 0, 4) . '-' . substr($temp[7], 4, 2) . '-' . substr($temp[7], 6, 2),
					'Rekeningnummer' => $temp[0],
					'Valuta' => $temp[1],
					'Tegenrekening' => $temp[5],
					'Tegenpersoon' => $temp[6],
					'Typetransactie' => $temp[8],
					//'Leeg' => $temp[9],
					'Referentienummer' => ''
				)
			);
			
			
		
	}
		
	wp_redirect(add_query_arg( array('page' => 'dnh_uploaden_1'), admin_url( 'admin.php' ) ) );
  	exit;
}

function csv_to_array($filename = 'transactions', $delimiter = ',') {
	/**Als $filename niet bestaat of niet leesbaar is, returnt de if-lus false. is_readable is een boolean die aangeeft of een bestand bestaat en leesbaar is.
	 *explode(php_eol, $csvData), splitst een variabele verder op, en slaat deze op in $lines
	 *str_getcsv parst de .csvStrings die zijn gedelimited in een array, staat in een foreach lusje, zodat deze stap steeds herhaald wordt.
	 */
	if (!file_exists($filename) || !is_readable($filename))
		return FALSE;

	$csvData = file_get_contents($filename);
	$lines = explode(PHP_EOL, $csvData);
	$array = array();
	foreach ($lines as $line) {
		$array[] = str_getcsv($line);
	}
	return $array;

}

add_action( 'admin_post_dnh_save_transactie', 'dnh_process_transactie' );
// De functie
function dnh_process_transactie() {
  // Controleer de rechten
  if ( !current_user_can( 'manage_options' ) )
  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  // Check that nonce field
  check_admin_referer( 'dnh_verify' );

  // Ophalen en valideren van de data
  $error_message = "";
  $data = array();
  if ( isset( $_POST['rubriek'] ) )
  {
    $data['Rubriek_RubriekId'] = sanitize_text_field( $_POST['rubriek'] );
    if (!is_numeric($data['Rubriek_RubriekId'])) {
      $error_message .= 'Id veld is niet mumeriek';
    }
  } else {
    $error_message .= 'Rubriek veld is niet meegestuurd';
  }
  if ( isset( $_POST['transactieid'] ) )
  {
    $data['TransactieId'] = sanitize_text_field( $_POST['transactieid'] );
  } else {
    $error_message .= 'Id veld is niet meegestuurd';
  }

  if(strlen($error_message) > 0) {
    // Redirect met foutbericht voorbereiden
    $qvars = array( 'page' => 'dnh_transacties', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb; //This is used only if making any database queries
    $updates = $wpdb->replace('TRANSACTIE', $data);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_transacties', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Transactie is succesvol aangemaakt/bijgewerkt' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}

?>