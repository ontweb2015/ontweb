<?php
/**
 * Template Name: Booking form
 */

get_header(); ?>

<?php 
// We need to sanitize user input

$name = isset($_POST['fname']) ? esc_html(trim($_POST['fname'])) : '';
$telephone = isset($_POST['phone']) ? esc_html(trim($_POST['phone'])) : '';
$email = isset($_POST['email']) ? esc_html(trim($_POST['email'])) : '';
$arrival = isset($_POST['arrival']) ? esc_html(trim($_POST['arrival'])) : '';
$departure = isset($_POST['departure']) ? esc_html(trim($_POST['departure'])) : '';
$adults = isset($_POST['adults']) ? intval($_POST['adults']) : '1';
$children = isset($_POST['children']) ? intval($_POST['children']) : '0';
$comments = isset($_POST['booking-comments']) ? esc_html(trim($_POST['booking-comments'])) : '';

$errorString = '';
$emailSent = false;

$post_meta = get_post_custom($post->ID);

if(isset($_POST['submit-booking']))
{

	if (isset($post_meta['hermes_booking_email'][0]) && is_email($post_meta['hermes_booking_email'][0])) {
		$to = esc_attr($post_meta['hermes_booking_email'][0]);
	} else {
		$to = get_option('admin_email');
	}
	
	$subject = __('Booking Enquiry', 'waterside');
	
	// We need to validate user input
	
	if(empty($name) or mb_strlen($name) < 2)
		$errorString .= '<li>'.__('Your name is required', 'waterside').'</li>';

	if(empty($email) or !is_email($email))
		$errorString .= '<li>'.__('A valid email is required', 'waterside').'</li>';

	if(empty($arrival) or strlen($arrival) < 6)
		$errorString .= '<li>'.__('A complete arrival date is required', 'waterside').'</li>';

	if(empty($departure) or strlen($departure) < 6)
		$errorString .= '<li>'.__('A complete departure date is required', 'waterside').'</li>';

	if(empty($adults) or !is_numeric($adults) or intval($adults) < 1)
		$errorString .= '<li>'.__('A number of one or more adults is required', 'waterside').'</li>';

	/*
	if(!is_numeric($children) or intval($children) < 0)
		$errorString .= '<li>'.__('A number of zero or more children is required', 'waterside').'</li>';
	*/

	$headers = 'From: ' . $name . ' <'.$email.'>' . "\r\n";

	// Send e-mail if there are no errors
	if(empty($errorString))
	{
		$mailbody  = __("Name:", 'waterside') . " " . $name . "\n";
		$mailbody .= __("Email:", 'waterside') . " " . $email . "\n";
		$mailbody .= __("Telephone:", 'waterside') . " " . $telephone . "\n";
		$mailbody .= __("Date of arrival:", 'waterside') . " " . $arrival . "\n";
		$mailbody .= __("Date of departure:", 'waterside') . " " . $departure . "\n";
		$mailbody .= __("Adults:", 'waterside') . " " . $adults . "\n";
		$mailbody .= __("Children:", 'waterside') . " " . $children . "\n";
		$mailbody .= __("Comments:", 'waterside') . " " . $comments . "\n";
		$emailSent = wp_mail($to, $subject, $mailbody, $headers);
	}
	
}

?>

<div id="content">
	
	<?php while (have_posts()) : the_post();
	
	$post_meta = get_post_custom($post->ID);
	if (isset($post_meta['hermes_post_display_featured'][0])) { $display_featured = esc_attr($post_meta['hermes_post_display_featured'][0]); };
	if (isset($post_meta['hermes_post_display_slideshow'][0])) { $display_slideshow = esc_attr($post_meta['hermes_post_display_slideshow'][0]); };
	if (isset($post_meta['hermes_post_display_slideshow_autoplay'][0])) { $slideshow_autoplay = esc_attr($post_meta['hermes_post_display_slideshow_autoplay'][0]); };
	if (isset($post_meta['hermes_post_display_slideshow_speed'][0])) { $slideshow_speed = esc_attr($post_meta['hermes_post_display_slideshow_speed'][0]); };
	if (!isset($slideshow_speed)) {
		$slideshow_speed = 5000;
	}
	
	endwhile;
 
	if (isset($display_featured) && $display_featured == 'Yes') {
	
		get_template_part('slideshow');
	
	}
	?>

	<div class="wrapper wrapper-main">

		<div id="main">
		
			<div class="wrapper-content">
			
				<?php while (have_posts()) : the_post(); ?>
	
				<div class="post-meta">
					<h1 class="title-l title-margin"><?php the_title(); ?></h1>
					<?php edit_post_link( __('Edit page', 'waterside'), '<p class="postmeta">', '</p>'); ?>
				</div><!-- end .post-meta -->
	
				<div class="divider">&nbsp;</div>
	
				<div class="post-single">
	
					<?php the_content(); ?>
					
					<?php if(!empty($errorString)): ?>
						<ul id="hermes-form-errors">
							<?php echo $errorString; ?>
						</ul>
					<?php endif; ?>
	
					<?php if ($emailSent == true): ?>
						<p id="hermes-form-success"><?php _e('You booking enquiry has been sent. We will contact you as soon as possible.', 'waterside'); ?></p>
					<?php endif; ?>
	
					<?php if( !isset($_POST['submit-booking']) || (isset($_POST['submit-booking']) && !empty($errorString)) ): ?>
						<form action="" id="form-booking" method="post">
							
							<p>
								<label class="hermes-label" for="fname"><?php _e('Name', 'waterside'); ?></label>
								<input class="hermes-input" name="fname" id="fname" type="text" value="<?php echo esc_attr($name);?>" />
							</p>
							
							<p>
								<label class="hermes-label" for="email"><?php _e('Email', 'waterside'); ?></label>
								<input class="hermes-input" name="email" id="email" type="email" value="<?php echo esc_attr($email); ?>" />
							</p>
	
							<p>
								<label class="hermes-label" for="phone"><?php _e('Telephone', 'waterside'); ?></label>
								<input class="hermes-input" name="phone" id="phone" type="tel" value="<?php echo esc_attr($telephone);?>" />
							</p>
	
							<p>
								<label class="hermes-label" for="arrival"><?php _e('Date of Arrival', 'waterside'); ?></label>
								<input class="hermes-input" name="arrival" id="arrival" type="date" value="<?php echo esc_attr($arrival); ?>" />
							</p>
							
							<p>
								<label class="hermes-label" for="departure"><?php _e('Date of Departure', 'waterside'); ?></label>
								<input class="hermes-input" name="departure" id="departure" type="date" value="<?php echo esc_attr($departure); ?>" />
							</p>
							
							<p>
								<label class="hermes-label" for="adults"><?php _e('Adults', 'waterside'); ?></label>
								<input class="hermes-input hermes-input-small" name="adults" id="adults" type="text" value="<?php echo esc_attr($adults); ?>" />
							</p>
	
							<p>
								<label class="hermes-label" for="children"><?php _e('Children', 'waterside'); ?></label>
								<input class="hermes-input hermes-input-small" name="children" id="children" type="text" value="<?php echo esc_attr($children); ?>" />
							</p>
							
							<p>
								<label class="hermes-label" for="booking-comments"><?php _e('Comments', 'waterside'); ?></label>
								<textarea class="hermes-input" name="booking-comments" id="booking-comments"><?php echo esc_textarea($comments); ?></textarea>
							</p>
																	
							<p>
								<input type="submit" name="submit-booking" class="button green" value="<?php _e('Send Request','waterside'); ?>" />
							</p>
	
						</form>
					<?php endif; ?>	
	
					<div class="cleaner">&nbsp;</div>
	
				</div><!-- end .post-single -->
				
				<?php endwhile; ?>

				<?php get_template_part('loop-gallery'); ?>

				<div id="hermes-comments">
					<?php comments_template(); ?>  
				</div><!-- end #hermes-comments -->
				
			</div><!-- .wrapper-content -->
		
		</div><!-- #main -->
		
		<?php get_sidebar(); ?>
		
		<div class="cleaner">&nbsp;</div>
	</div><!-- .wrapper .wrapper-main -->
	
</div><!-- #content -->

<?php get_footer(); ?>