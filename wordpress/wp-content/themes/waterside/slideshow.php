<?php 
global $slideshow_autoplay, $slideshow_speed;

// If it is a post or page, retrieve all attached images to it.

if ( is_single() || is_page() || is_page_template() ) {

	$args = array(
		'order'          => 'ASC',
		'orderby'          => 'menu_order',
		'post_parent'    => $post->ID,
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => null,
		'numberposts'    => -1
	);
	
	$attachments = get_posts($args);
	$attachments_num = count($attachments);
	
	if ($attachments_num == 0) {
	
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured_image_id = get_post_thumbnail_id($post->ID);

			unset($attachments,$attachments_num);
			
			$args = array(
				'p'    => $featured_image_id,
				'post_type'      => 'attachment',
				'post_mime_type' => 'image'
			);
			
			$attachments = get_posts($args);
			$attachments_num = count($attachments);

		}
	}

} 

$i = 0;

if ( $attachments_num > 1 ) { ?>

<div class="wrapper wrapper-slider">

	<div id="hermes-gallery" class="flexslider">
		<ul class="hermes-slides">
	
			<?php
			foreach ($attachments as $attachment) {
			$i++; 
	
			$large_image_url = wp_get_attachment_image_src( $attachment->ID, 'thumb-hermes-slideshow');
	
			?>
			<li class="hermes-gallery-slide">
			
				<img src="<?php echo $large_image_url[0]; ?>" width="1020" height="350" alt="" />
	
			</li><!-- end .hermes-gallery-slide -->
			<?php 
			} // foreach
			?>
	
		</ul><!-- .hermes-slides -->
	</div><!-- end #hermes-gallery .flexslider -->

</div><!-- .wrapper .wrapper-slider -->

<script type="text/javascript">
jQuery(document).ready(function() {
	
	jQuery("#hermes-gallery").flexslider({
        selector: ".hermes-slides > .hermes-gallery-slide",
		animationLoop: true,
        initDelay: 1000,
		smoothHeight: false,
		<?php if ($slideshow_autoplay == 'on') { ?>
		slideshow: true,
		slideshowSpeed: <?php echo $slideshow_speed; ?>,
		<?php } else { ?>
		slideshow: false,
		<?php } ?>
		pauseOnAction: true,
        controlNav: false,
		directionNav: true,
		useCSS: true,
		touch: false,
        animationSpeed: 500
    });	 

});
</script>
<?php 
} // if there are attachments
elseif ($attachments_num == 1) { ?>

<div class="wrapper wrapper-slider">

	<div id="hermes-gallery">
	
			<?php
			foreach ($attachments as $attachment) {
			$i++; 
	
			$large_image_url = wp_get_attachment_image_src( $attachment->ID, 'thumb-hermes-slideshow');
	
			?>
			<img src="<?php echo $large_image_url[0]; ?>" alt="<?php echo esc_attr($attachment->post_title); ?>" width="1000" height="400" />
			
			<?php 
			} // foreach
			?>
	
	</div><!-- end #hermes-gallery -->

</div><!-- .wrapper .wrapper-slider -->

<?php } ?>