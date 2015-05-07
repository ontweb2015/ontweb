<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: leden/process.php
Doel  : Alles voor het verwerken van wijzigingen van een lid
Auteur: Rajenco
*******************************************************************************************************/

/**************************************************************** 
TOEVOEGEN/BIJWERKEN VAN EEN lid
Dit wordt aangeroepen zowel bij het aanmaken van een nieuw lid
als het bijwerken van een bestaand lid.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_save_lid', 'dnh_process_lid' );
// De functie
function dnh_process_lid() {
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
  if ( isset( $_POST['naam'] ) )
  {
    $data['Naam'] = sanitize_text_field( $_POST['naam'] );
  } else {
    $error_message .= 'Naam is niet ingevuld';
  }
  
  if ( isset( $_POST['adres'] ) )
  {
    $data['Adres'] = sanitize_text_field( $_POST['adres'] );
  } else {
    $error_message .= 'Adres is niet ingevuld';
  }
  
  if ( isset( $_POST['woonplaats'] ) )
  {
    $data['Woonplaats'] = sanitize_text_field( $_POST['woonplaats'] );
  } else {
    $error_message .= 'Woonplaats is niet ingevuld';
  }
  
  if ( isset( $_POST['telefoonnummer'] ) )
  {
    $data['Telefoonnummer'] = sanitize_text_field( $_POST['telefoonnummer'] );
  }
  
  if ( isset( $_POST['emailadres'] ) )
  {
    $data['Emailadres'] = sanitize_text_field( $_POST['emailadres'] );
  }
  
  if ( isset( $_POST['status'] ) )
  {
    $data['Status'] = sanitize_text_field( $_POST['status'] );
  } else {
    $error_message .= 'Status is niet ingevuld';
  }

  if(strlen($error_message) > 0) {
    // Redirect met foutbericht voorbereiden
    $qvars = array( 'page' => 'dnh_leden', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb;
    $updates = $wpdb->insert('DNH_LID', $data);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_leden', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Lid is succesvol aangemaakt/bijgewerkt' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}
?>