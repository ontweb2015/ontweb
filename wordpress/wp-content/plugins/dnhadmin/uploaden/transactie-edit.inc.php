<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: rubrieken-edit.inc.php
Doel  : "Template" voor het bewerken van een bestaande Rubiek
Auteur: BugSlayer
*******************************************************************************************************/
?>
<div class="wrap">
	<h2>Bewerk rubriek</h2>
	<!-- Our form is sending out data to admin-post.php. This is where you should send all your data.-->
	<form method="post" action="admin-post.php"> 

		<!-- We create a hidden field named action with the value corresponding.
			 This value is important as we’ll be able to process the form. -->
		<input type="hidden" name="action" value="dnh_save_transactie" />
		<input type="hidden" name="transactieid" value="<?php echo $item->TransactieId ?>" />

		<!-- This function is extremely useful and prevents your form from being submitted by a user other than an admin. 
	    	 It’s a security measure	-->
		<?php wp_nonce_field( 'dnh_verify' ); ?>

		<!-- En nu... de inhoud van het form -->
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row"><label for="TransactieId">Code</label></th>
					<td><?php echo $item->TransactieId ?></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="naam">Rubriek <span class="description">(verplicht)</span></label></th>
					<td>
						<select name="rubriek">
							<?php echo $options; ?>
						</select>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="omschrijving">Bedrag </label></th>
					<td><?php echo $item->Bedrag ?></td>
				</tr>
			</tbody>
		</table>

		<input type="submit" value="Rubriek bijwerken" class="button button-primary"/>
	</form>
</div>
