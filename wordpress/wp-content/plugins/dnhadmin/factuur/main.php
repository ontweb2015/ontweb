<?php

require_once("process.php");


function dnh_factuur_on_admin_menu() {
	
   /* Beschrijving van de parameters van de function add_submenu_page:
    * 1: De slug van het menu waaraan dit submenu aan gekoppeld moet zijn. Null als page niet in een menu komt, maar op een 
    *    andere manier kan worden opgeroepen.
    * 2: titel van de pagina in de browser
    * 3: Titel van het menu
    * 4: Rechten om het menu zichtbaar te maken
    * 5: slug van deze page
    * 6: PHP functie die wordt aangeroepen als de gebruiker de page oproept.
    */

	add_submenu_page( null, 'Factuur weergeve' , 'Factuur weergeven' , 'manage_options' , 'factuur_weergeven' , 'showFactuur');
	
}

function showFactuur()
{
	include('showFactuur.php');
	show_Factuur();
}
?>