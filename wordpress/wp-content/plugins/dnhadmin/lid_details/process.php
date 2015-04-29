<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: rubrieken/process.php
Doel  : Alles voor het verwerken van wijzigingen van Rubrieken
Auteur: Rajenco
*******************************************************************************************************/

/**************************************************************** 
TOEVOEGEN/BIJWERKEN VAN EEN RUBRIEK
Dit wordt aangeroepen zowel bij het aanmaken van een nieuwe rubriek
als het bijwerken van een bestaande rubriek.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_save_lid', 'dnh_process_lid' );
// De functie
function dnh_process_lid_details() {
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
  if ( isset( $_POST['id'] ) )
  {
    $data['ID'] = sanitize_text_field( $_POST['id'] );
    if (!is_numeric($data['ID'])) {
      $error_message .= 'Id veld is niet mumeriek';
    }
  } else {
    $error_message .= 'Id veld is niet meegestuurd';
  }
  if ( isset( $_POST['naam'] ) )
  {
    $data['Naam'] = sanitize_text_field( $_POST['naam'] );
  } else {
    $error_message .= 'Naam veld is niet meegestuurd';
  }
  if ( isset( $_POST['omschrijving'] ) )
  {
    $data['Omschrijving'] = sanitize_text_field( $_POST['omschrijving'] );
  }

  if(strlen($error_message) > 0) {
    // Redirect met foutbericht voorbereiden
    $qvars = array( 'page' => 'dnh_lid_details', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb; //This is used only if making any database queries
    $updates = $wpdb->replace('DNH_LID', $data);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_lid_details', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Lid is succesvol aangemaakt/bijgewerkt' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}

/**************************************************************** 
VERWIJDEREN VAN EEN RUBRIEK, EN BIJWERKEN VAN DAARAAN GEKOPPELDE 
TRANSACTIES
Dit wordt aangeroepen als één of meer rubrieken moeten worden
verwijderd.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_delete_leden', 'dnh_process_delete_rubrieken' );
// De functie
/*function dnh_process_delete_leden() {
  // Controleer de rechten
  if ( !current_user_can( 'manage_options' ) )
  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  // Check that nonce field
  check_admin_referer( 'dnh_verify' );

  // TODO nog te implementeren

  // ophalen rubrieken, keuze en eventueel nieuwe rubriek
  $error_message = "";
  // Ophalen en valideren van de data
  // Alle gemarkeerde rubrieken in een array stoppen
  $leden = Array();
  if (isset($_POST['lid'])) {
    $value = $_POST['lid'];
    if (is_array($value)) {
      foreach ($value as $val) {
        $leden[] = sanitize_text_field($val);
      }
    } else {
      $rubrieken[] = sanitize_text_field($value);
    }
  } else {
    $error_message .= 'Er zijn geen leden meegestuurd';
  }

  foreach ($leden as $lid) {
    if (!is_numeric($lid)) {
      $error_message .= 'Lid $lid is niet geldig';
    }
  }

  if ( isset( $_POST['trans_action'] ) )
  {
    $what_to_do_with_transactions = sanitize_text_field( $_POST['trans_action'] );
  } else {
    $error_message .= 'Er is niet aangegeven wat er gedaan moet worden met de transacties';
  }
  if ( isset( $_POST['nwe_lid'] ) )
  {
    $nwe_transactie = sanitize_text_field( $_POST['nwe_lid'] );
  } else {
    if ($what_to_do_with_transactions==='rubr')
      $error_message .= 'Er is geen nieuwe lid meegestuurd';
  }


  if(strlen($error_message) > 0) {
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_leden', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb; //This is used only if making any database queries
    // TODO aanpassen van de transacties, mbv SQL

    // verwijderen rubrieken
    foreach ($leden as $lid) {
      $wpdb->delete( 'DNH_LID', Array( 'ID' => $lid ) );
    }
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_leden', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Rubriek(en) succesvol verwijderd' ) 
     );
  }
  //echo add_query_arg( $qvars, admin_url( 'admin.php' ));
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}*/

?>