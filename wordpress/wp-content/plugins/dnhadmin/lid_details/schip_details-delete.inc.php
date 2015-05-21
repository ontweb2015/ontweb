<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: schip_details_delete.inc.php
Doel  : "Template" voor het bevestigen van het verwijderen van Rubrieken. Bij het verwijderen moet de
        gebruiker wel aangeven wat er met gekoppelde transacties moet worden gedaan.
Auteur: Rajenco Noort
*******************************************************************************************************/

// Alle gemarkeerde rubrieken in een array stoppen
$schepen = Array();
if (isset($_GET['schip'])) {
	$value = $_GET['schip'];
	if (is_array($value)) {
		foreach ($value as $val) {
			$schepen[] = sanitize_text_field($val);
		}
	} else {
		$schepen[] = sanitize_text_field($value);
	}
}

// Rubriek-informatie ophalen
global $wpdb;
$ids = join(',',$schepen);  
$myrows = $wpdb->get_results("SELECT * FROM SCHIP WHERE SchipId IN ($ids)");
?>

<div class="wrap">
	<h2>Verwijder schip</h2>
	<p>Je hebt de volgende schepen gemarkeerd om te verwijderen:</p>
	<ul> <?php
		foreach ($myrows as $row) {
			printf("<li>%d: %s</li>",$row->SchipId, $row->Naam);
		}
	?></ul>

	<form method="post" action="admin-post.php"> 

		<!-- We create a hidden field named action with the value corresponding.
			 This value is important as we’ll be able to process the form. -->
		<input type="hidden" name="action" value="dnh_delete_schip" />

		<?php
			//Hier hidden array-fields maken voor alle geselecteerde rubrieken
			foreach($schepen as $schip) {
				printf('<input type="hidden" name="schip[]" value="%s" />', $schip);
			}
		?>

		<!-- This function is extremely useful and prevents your form from being submitted by a user other than an admin. 
	    	 It’s a security measure	-->
		<?php wp_nonce_field( 'dnh_verify' ); ?>
		<input type="submit" value="Bevestig verwijderen" class="button button-primary"/>
	</form>
</div>
