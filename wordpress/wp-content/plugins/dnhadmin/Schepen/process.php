<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: schepen/process.php
Doel  : Alles voor het verwerken van wijzigingen van schepen
Auteur: Rajenco
*******************************************************************************************************/

/**************************************************************** 
TOEVOEGEN SCHIP
Dit wordt aangeroepen zowel bij het aanmaken van een nieuwe rubriek
als het bijwerken van een bestaande rubriek.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_save_schip', 'dnh_process_schip' );
// De functie
function dnh_process_schip() {
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
    $error_message .= 'Naam veld is niet meegestuurd';
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
    $qvars = array( 'page' => 'dnh_schepen', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb;
    $updates = $wpdb->insert('SCHIP', $data);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_schepen', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Schip is succesvol aangemaakt' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}

/**************************************************************** 
TOEVOEGEN/BIJWERKEN VAN EEN RUBRIEK
Dit wordt aangeroepen zowel bij het aanmaken van een nieuwe rubriek
als het bijwerken van een bestaande rubriek.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_edit_save_schip', 'dnh_process_edit_schip' );
// De functie
function dnh_process_edit_schip() {
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
    $error_message .= 'schip ID is niet meegestuurd';
  }
  
  if ( isset( $_POST['naam'] ) )
  {
  	$data['Naam'] = sanitize_text_field( $_POST['naam'] );
  } else {
    $error_message .= 'Naam veld is niet meegestuurd';
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
    $qvars = array( 'page' => 'dnh_schepen', 
      'dnh_ntc' => 'error',
      'dnh_ntm' => urlencode( $error_message )
    );
  } else {
    global $wpdb;
    $updates = $wpdb->update('SCHIP', $data, $schip);
    // Redirect voorbereiden
    $qvars = array( 'page' => 'dnh_schepen', 
      'dnh_ntc' => 'updated',
      'dnh_ntm' => urlencode( 'Schip is succesvol gewijzigd' ) );
  }
  wp_redirect( add_query_arg( $qvars, admin_url( 'admin.php' ) ) );
  exit;
}

/**************************************************************** 
VERWIJDEREN VAN EEN SCHIP.
*****************************************************************/
// De Action Hook
add_action( 'admin_post_dnh_delete_schip', 'dnh_process_delete_schip' );
// De functie
function dnh_process_delete_schip() {
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