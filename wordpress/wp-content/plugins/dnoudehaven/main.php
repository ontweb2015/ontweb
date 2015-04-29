<?php
/*
Plugin Name: D'n oude haven plugin
Description: Een plugin die de benodigdheden van d'n oude haven vervult.
Version: 1.0
*/

require_once('factuur.php');

add_action('admin_menu', 'dnh_on_admin_menu');
add_action('init','createInvoice');

function dnh_on_admin_menu() {
	add_menu_page( 'DNHAdmin instellingen', // Wat in de tab van je browser komt te staan
		           'DNHAdmin',              // Titel van het menu-item
		           'manage_options',        // Rechten
		           'dnh_menu',              // De slug (unieke naam binnen Wordpress om dit menu te identificeren)
		           'dnh_main',              // Naam van de php functie die wordt aangereoepen als gebruiker op de menu-link klikt
		           '',                      // ?
		           3                        // Plaats tov de andere menu-items
		           );
	// Hier alle on_admin_menu functies van de verschillende sub-onderdelen aanroepen
	dnh_tarieven_on_admin_menu();  // Zelf bedacht. PHP functie van het sub-onderdeel dat menu-items aan het menu kan toevoegen.
}

?>