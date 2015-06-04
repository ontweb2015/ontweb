<?php
 
/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

add_action('admin_menu', 'waterside_options_box');

function waterside_options_box() {
	
	add_meta_box('waterside_post_template', 'Post Options', 'waterside_post_options', 'post', 'side', 'high');
	add_meta_box('waterside_post_template', 'Page Options', 'waterside_post_options', 'page', 'side', 'high');

	$template_file = '';
	
	// get the id of current post/page
	if (isset($_GET['post'])) {
		$post_id = $_GET['post'];
	} elseif (isset($_POST['post_ID'])) {
		$post_id = $_POST['post_ID'];
	}

	// get the template file used (if a page)
	if (isset($post_id)) {
		$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
	}
	
	// if we are using the booking.php page template, add additional meta boxes
	if ( isset($template_file) && ($template_file == 'page-templates/booking.php') ) {
		add_meta_box('waterside_booking_template', 'Form Options', 'waterside_booking_options', 'page', 'side', 'high');
	}

}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
	
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
		$postID = $parent_id;
	}
	
	if (isset($_POST['save']) || isset($_POST['publish'])) {
		
		if (isset($_POST['hermes_post_display_featured'])) { update_custom_meta($postID, esc_attr($_POST['hermes_post_display_featured']), 'hermes_post_display_featured'); }
		if (isset($_POST['hermes_post_display_slideshow'])) { update_custom_meta($postID, esc_attr($_POST['hermes_post_display_slideshow']), 'hermes_post_display_slideshow'); }
		if (isset($_POST['hermes_post_display_slideshow_autoplay'])) { update_custom_meta($postID, esc_attr($_POST['hermes_post_display_slideshow_autoplay']), 'hermes_post_display_slideshow_autoplay'); }
		if (isset($_POST['hermes_post_display_slideshow_speed'])) { update_custom_meta($postID, esc_attr($_POST['hermes_post_display_slideshow_speed']), 'hermes_post_display_slideshow_speed'); }
		
	}
	if (isset($_POST['saveBooking'])) {
		
		if (isset($_POST['hermes_booking_email'])) { update_custom_meta($postID, esc_attr($_POST['hermes_booking_email']), 'hermes_booking_email'); }

	}
}

function update_custom_meta($postID, $newvalue, $field_name) {
	// To create new meta
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		// or to update existing meta
		update_post_meta($postID, $field_name, $newvalue);
	}
	
}

// Regular Posts Options
function waterside_post_options() {
	global $post;
	?>
	<fieldset>
		<div>
			<p>
 				<label for=""><?php _e('Display attached images as a slideshow','waterside'); ?></label><br />
				<select name="hermes_post_display_featured" id="hermes_post_display_featured">
					<option<?php selected( get_post_meta($post->ID, 'hermes_post_display_featured', true), 'Yes' ); ?>><?php _e('Yes','waterside'); ?></option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_post_display_featured', true), 'No' ); ?>><?php _e('No','waterside'); ?></option>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" id="hermes_post_display_slideshow_autoplay" name="hermes_post_display_slideshow_autoplay" value="on" <?php checked( get_post_meta($post->ID, 'hermes_post_display_slideshow_autoplay', true), 'on' ); ?> />
 				<label for="hermes_post_display_slideshow_autoplay"><?php _e('Enable slideshow autoplay','waterside'); ?></label><br />
			</p>
			<p>
				<label for="hermes_post_display_slideshow_speed"><?php _e('Slideshow autoplay speed in miliseconds', 'waterside'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_post_display_slideshow_speed" id="hermes_post_display_slideshow_speed" value="<?php echo esc_attr(get_post_meta($post->ID, 'hermes_post_display_slideshow_speed', true)); ?>"><br />
				<span class="description"><?php _e('1 second = 1000 miliseconds','waterside'); ?></span>
			</p>
  		</div>
	</fieldset>
	<?php
}

// Booking Page Template Options
function waterside_booking_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveBooking" id="saveBooking" value="1" />
		<div>
			<p>
				<label for="hermes_booking_email"><?php _e('Send form submissions to this email', 'waterside'); ?>:</label><br />
				<input type="text" style="width:90%;" name="hermes_booking_email" id="hermes_booking_email" value="<?php echo esc_attr(get_post_meta($post->ID, 'hermes_booking_email', true)); ?>"><br />
				<span class="description"><?php _e('If left blank, submissions will be sent to', 'waterside'); ?>: <strong><?php echo get_option('admin_email'); ?></strong>.</span>
			</p>
			
  		</div>
	</fieldset>
	<?php
	}