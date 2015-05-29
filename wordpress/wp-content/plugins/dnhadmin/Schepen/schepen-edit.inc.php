<?php
/*******************************************************************************************************
Plugin: DNHAdmin
Script: rubrieken-edit.inc.php
Doel  : "Template" voor het bewerken van een bestaande Rubiek
Auteur: BugSlayer
*******************************************************************************************************/
?>
<div class="wrap">
	<h2>Bewerk schip</h2>
	<!-- Our form is sending out data to admin-post.php. This is where you should send all your data.-->
	<form method="post" action="admin-post.php"> 

		<!-- We create a hidden field named action with the value corresponding.
			 This value is important as we’ll be able to process the form. -->
		<input type="hidden" name="action" value="dnh_edit_save_schip" />

		<!-- This function is extremely useful and prevents your form from being submitted by a user other than an admin. 
	    	 It’s a security measure	-->
		<?php wp_nonce_field( 'dnh_verify' ); ?>

		<!-- En nu... de inhoud van het form -->
		<table class="form-table">
			<tbody>
				<tr>
					<td><input type='hidden' name="schipid" type="text" id="schipid" value="<?php echo $_GET['SchipId'] ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="naam">Naam </label></th>
					<td><input name="naam" type="text" id="naam" value="<?php echo $item->Naam ?>" aria-required="true"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="lengte">Lengte </label></th>
					<td><input name="lengte" type="text" id="lengte" value="<?php echo $item->Lengte ?>" aria-required="true"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="type">Type </label></th>
					<td>
						<select id="type" name="type">
							<option value="Motorboot">Motorboot</option>
							<option value="Zeilboot">Zeilboot</option>
						</select>
					</td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="lid_lidid">Eigenaar </label></th>
					<td>
						<?php
						global $wpdb; //This is used only if making any database queries
        				$leden =  $wpdb->get_results("SELECT LidId, Naam FROM LID");
						if($leden != 0){
                            echo '<select name="lid_lidid" id="lid_lidid" style="width: 300px">';
                            foreach($leden as $value){
                                $id = $value->LidId;
                                $naam = $value->Naam;
                                if($id == $item->Lid_LidId){
                                    echo '<option value="' . $id . '" selected>' . $naam . '</option>';
                                }
                                else {
                                    echo '<option value="'.$id.'">' . $naam . '</option>';
                                }
                            }
                            echo '</select>';
                        }
                         ?>
					</td>
				</tr>
			</tbody>
		</table>

		<input type="submit" value="Lid bijwerken" class="button button-primary"/>
	</form>
</div>
