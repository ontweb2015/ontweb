<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: lid_details_edit.inc.php
Doel  : "Template" voor het bewerken van een bestaand lid.
Auteur: Rajenco Noort
*******************************************************************************************************/
?>
<div class="wrap">
	<h2>Bewerk lid</h2>
	<!-- Our form is sending out data to admin-post.php. This is where you should send all your data.-->
	<form method="post" action="admin-post.php"> 

		<!-- We create a hidden field named action with the value corresponding.
			 This value is important as we’ll be able to process the form. -->
		<input type="hidden" name="action" value="dnh_save_lid_details" />

		<!-- This function is extremely useful and prevents your form from being submitted by a user other than an admin. 
	    	 It’s a security measure	-->
		<?php wp_nonce_field( 'dnh_verify' ); ?>

		<!-- En nu... de inhoud van het form -->
		<table class="form-table">
			<tbody>
				<tr><td><input type='hidden' name="lidid" type="text" id="lidid" value="<?php echo $_GET['LidId'] ?>"></td></tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="naam">Naam: </label></th>
					<td><input name="naam" type="text" id="naam" value="<?php echo $item->Naam ?>" aria-required="true"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="adres">Adres: </label></th>
					<td><input name="adres" type="text" id="adres" value="<?php echo $item->Adres ?>" aria-required="false"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="woonplaats">Woonplaats: </label></th>
					<td><input name="woonplaats" type="text" id="woonplaats" value="<?php echo $item->Woonplaats ?>" aria-required="false"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="telefoonnummer">Telefoonnummer: </label></th>
					<td><input name="telefoonnummer" type="text" id="telefoonnummer" value="<?php echo $item->Telefoonnummer ?>" aria-required="false"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="emailadres">Emailadres: </label></th>
					<td><input name="emailadres" type="text" id="emailadres" value="<?php echo $item->Emailadres ?>" aria-required="false"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="status">Status: </label></th>
					<td>
						<select id="status" name="status">
							<option value="1">Actief</option>
							<option value="0">Non-actief</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<input type="submit" value="Lid bijwerken" class="button button-primary"/>
	</form>
</div>

