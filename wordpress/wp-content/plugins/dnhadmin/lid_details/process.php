<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: lid_details/process.php
Doel  : Alles voor het verwerken van wijzigingen van leden.
Auteur: Rajenco
*******************************************************************************************************/

/**************************************************************** 
BIJWERKEN VAN EEN lid
Dit wordt aangeroepen zowel bij het bijwerken van een bestaand lid.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_save_lid_details', 'dnh_process_edit_lid_details' );
// De functie
function dnh_process_edit_lid_details() {
  // Controleer de rechten
  if ( !current_user_can( 'manage_options' ) )
  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  // Check that nonce field
  check_admin_referer( 'dnh_verify' );

  // Ophalen en valideren van de data
  $error_message = Array();
  $data = array();
  $lid = array();
  if ( isset( $_POST['lidid'] ) )
  {
    $lid['LidId'] = sanitize_text_field( $_POST['lidid'] );
  } else {
    $error_message .= 'ID is niet meegestuurd';
  }
  
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
  } else {
    $error_message .= 'Telefoonnummer is niet ingevuld';
  }
  
  if ( isset( $_POST['emailadres'] ) )
  {
    $data['Emailadres'] = sanitize_text_field( $_POST['emailadres'] );
  } else {
    $error_message .= 'Emailadres is niet ingevuld';
  }

  if ( isset( $_POST['status'] ) )
  {
  	$data['status'] = $_POST['status'];
  }

 if(strlen($error_message) > 0) {
    // Redirect met foutbericht voorbereiden
    $qvars = array( 'page' => 'dnh_lid_details&LidId=' . $_POST['lidid'] . "'", 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb;
    $updates = $wpdb->update('LID', $data, $lid);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_lid_details&LidId=' . $_POST['lidid'] . "'", 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Lid is succesvol bijgewerkt' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}

/**************************************************************** 
BIJWERKEN VAN EEN schip
Dit wordt aangeroepen zowel bij het bijwerken van een bestaand schip.
*****************************************************************/
add_action( 'admin_post_dnh_save_edit_schip_details', 'dnh_process_edit_schip_details' );
// De functie
function dnh_process_edit_schip_details() {
  // Controleer de rechten
  if ( !current_user_can( 'manage_options' ) )
  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  // Check that nonce field
  check_admin_referer( 'dnh_verify' );

  // Ophalen en valideren van de data
  $error_message = array();
  $data = array();
  $schip = array();
  if ( isset( $_POST['schipid'] ) )
  {
  	$schip['SchipId'] = sanitize_text_field( $_POST['schipid'] );
  } else {
    $error_message .= 'Schip ID is niet meegestuurd.';
  }
  
  if ( isset( $_POST['naam'] ) )
  {
  	$data['Naam'] = sanitize_text_field( $_POST['naam'] );
  } else {
    $error_message .= 'Naam is niet meegestuurd';
  }
  
  if ( isset( $_POST['lengte'] ) )
  {
  	$data['Lengte'] = sanitize_text_field( $_POST['lengte'] );
  } else {
    $error_message .= 'Lengte veld is niet meegestuurd';
  }
  
  if ( isset( $_POST['type'] ) )
  {
  	$data['type'] = $_POST['type'];
  }
  
  if ( isset( $_POST['lid_lidid'] ) )
  {
  	$data['lid_lidid'] = $_POST['lid_lidid'];
  }

  if(strlen($error_message) > 0) {
    // Redirect met foutbericht voorbereiden
    $qvars = array( 'page' => 'dnh_lid_details&LidId=' . $_POST['lid_lidid'] . "'", 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb;
    $updates = $wpdb->update('SCHIP', $data, $schip);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_lid_details&LidId=' . $_POST['lid_lidid'] . "'", 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Schip is succesvol bijgewerkt' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}

/**************************************************************** 
VERWIJDEREN VAN EEN Schip
Dit wordt aangeroepen als één of meer schepen moeten worden
verwijderd.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_delete_schip_details', 'dnh_process_delete_schip_details' );
// De functie
function dnh_process_delete_schip_details() {
  // Controleer de rechten
  if ( !current_user_can( 'manage_options' ) )
  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  // Check that nonce field
  check_admin_referer( 'dnh_verify' );

  // TODO nog te implementeren

  // ophalen schepen
  $error_message = "";
  // Ophalen en valideren van de data
  // Alle gemarkeerde rubrieken in een array stoppen
  $schepen = Array();
  if (isset($_POST['schip'])) {
    $value = $_POST['schip'];
    if (is_array($value)) {
      foreach ($value as $val) {
        $schepen[] = sanitize_text_field($val);
      }
    } else {
      $schepen[] = sanitize_text_field($value);
    }
  } else {
    $error_message .= 'Er zijn geen schepen meegestuurd';
  }

  foreach ($schepen as $schip) {
    if (!is_numeric($schip)) {
      $error_message .= 'Schip $schip is niet geldig';
    }
  }

  if(strlen($error_message) > 0) {
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_schepen', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb; //This is used only if making any database queries
    // TODO aanpassen van de transacties, mbv SQL

    // verwijderen rubrieken
    foreach ($schepen as $schip) {
      $wpdb->delete( 'SCHIP', Array( 'SchipId' => $schip ) );
    }
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_schepen', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Schip succesvol verwijderd' ) 
     );
  }
  //echo add_query_arg( $qvars, admin_url( 'admin.php' ));
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}
?>