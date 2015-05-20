<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: lid_details/main.php
Doel  : Hoofd bestand voor de details van een lid, combineert het weergeven van zowel de details van het 
		lid als de schepen die toebehoren aan dit lid.
Auteur: Rajenco
*******************************************************************************************************/

/**
 * Aangeroepen tijdens de 'admin_menu' action
 */
function dnh_lid_details_on_admin_menu() {
   /* Beschrijving van de parameters van de function add_submenu_page:
    * 1: De slug van het menu waaraan dit submenu aan gekoppeld moet zijn. Null als page niet in een menu komt, maar op een 
    *    andere manier kan worden opgeroepen.
    * 2: geen idee
    * 3: Titel van het menu
    * 4: Rechten om het menu zichtbaar te maken
    * 5: slug van deze page
    * 6: PHP functie die wordt aangeroepen als de gebruiker de page oproept.
    */
	add_submenu_page( null		, 'DetailsLid'  , 'DetailsLid'  , 'manage_options', 'dnh_lid_details'       , 'dnh_lid_details_list'   );
	add_submenu_page( null      , 'Lid Bewerken'   , 'Bewerken'   , 'manage_options', 'dnh_lid_details_edit'  , 'dnh_lid_details_edit'   );
	add_submenu_page( null		, 'DetailsSchip'  , 'DetailsSchip'  , 'manage_options', 'dnh_lid_details' , 'dnh_schip_details_list'   );
	add_submenu_page( null		, 'Schip toevoegen'  , 'Toevoegen'  , 'manage_options', 'dnh_schip_details_create' , 'dnh_schip_details_create'   );
	add_submenu_page( null		, 'Schip bewerken'  , 'Bewerken'  , 'manage_options', 'dnh_schip_details_edit' , 'dnh_schip_details_edit'   );
	add_submenu_page( null		, 'Schip verwijderen'  , 'Verwijderen'  , 'manage_options', 'dnh_schip_details_delete' , 'dnh_schip_details_delete'   );
}

/**
 * Renderen van de table.
 */
function dnh_lid_details_list() {
  // Beperk toegang
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  
  if(!class_exists('DNHlid_details_List_Table')){
      require_once( 'lid_details-list-table-class.php' );
  }
  
  	//Create an instance of our package class...
	$myListTable = new DNHlid_details_List_Table();
	//Fetch, prepare, sort, and filter our data...
	$myListTable->prepare_items();
	include( 'lid_details-list.inc.php' );
	
		
}

function dnh_schip_details_list() {
  // Beperk toegang
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  
  if(!class_exists('DNHschip_details_List_Table')){
      require_once( 'schip_details-list-table-class.php' );
  }
  
  	//Create an instance of our package class...
	$myListTable = new DNHschip_details_List_Table();
	//Fetch, prepare, sort, and filter our data...
	$myListTable->prepare_items();
	include( 'schip_details-list.inc.php' );
}


function dnh_lid_details_create() {
   // Beperk toegang
   if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
   }
	include( 'lid_details_create.inc.php' );
}

function dnh_lid_details_edit() {
   // Beperk toegang
   if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
   }
   if ( !isset( $_GET['LidId'] ) )  {
      wp_die( __( 'You do not sent sufficient data to use this page.' ) );
   }
   
   $id = sanitize_text_field( $_GET['lid'] );
   global $wpdb;
   $item = $wpdb->get_row("SELECT * FROM DNH_LID WHERE ID = $id");

	include( 'lid_details_edit.inc.php' );
}
?>