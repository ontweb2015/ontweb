<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: rubrieken/main.php
Doel  : Hoofd bestand voor het uploaden, combineert alle functionaliteit voor het importeren van csv-bestanden.
Auteur: Stef
*******************************************************************************************************/

// Include het script dat wijzigingen op de database verwerkt.
require_once('process.php');

/**
 * Aangeroepen tijdens de 'admin_menu' action
 */
function dnh_uploaden_on_admin_menu() {
   /* Beschrijving van de parameters van de function add_submenu_page:
    * 1: De slug van het menu waaraan dit submenu aan gekoppeld moet zijn. Null als page niet in een menu komt, maar op een 
    *    andere manier kan worden opgeroepen.
    * 2: geen idee
    * 3: Titel van het menu
    * 4: Rechten om het menu zichtbaar te maken
    * 5: slug van deze page
    * 6: PHP functie die wordt aangeroepen als de gebruiker de page oproept.
    */
	add_submenu_page( null, 'Upload transacties'  , 'Uploaden'  , 'manage_options', 'dnh_transacties_uploaden'       , 'dnh_transacties_uploaden'   );
	add_submenu_page( 'dnh_menu', 'Transacties'     , 'Transacties'      , 'manage_options', 'dnh_transacties', 'dnh_transacties' );
	add_submenu_page( null      , 'Transactie bewerken'   , 'Bewerken'   , 'manage_options', 'dnh_transacties_edit'  , 'dnh_transacties_edit'   );

}


function dnh_transacties_uploaden() {
	include "upload_form.inc.php";
}

function dnh_transacties() {
	// Beperk toegang
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  
  if(!class_exists('DNHTransacties_List_Table')){
      require_once( 'transacties-list-table-class.php' );
  }
  //Create an instance of our package class...
	$myListTable = new DNHTransacties_List_Table();
	//Fetch, prepare, sort, and filter our data...
	$myListTable->prepare_items();
	include( 'transacties-list.inc.php' );	
}

function dnh_transacties_edit() {
 	// Beperk toegang
   if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
   }
   if ( !isset( $_GET['transactie'] ) )  {
      wp_die( __( 'You do not sent sufficient data to use this page.' ) );
   }
   
   $id = sanitize_text_field( $_GET['transactie'] );
   global $wpdb;
   $item = $wpdb->get_row("SELECT * FROM TRANSACTIE WHERE TransactieId = $id");
   $aRubrieken = $wpdb->get_results("SELECT * FROM RUBRIEK");
   
   $options = "";
   foreach ($aRubrieken as $rubriek) {
       $options .= "<option value='" . $rubriek->RubriekId . "'>" . $rubriek->Naam . "</option>"; 
   }

	include( 'transactie-edit.inc.php' );
}

?>