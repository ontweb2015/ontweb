<?php 
$pagid = hermes_wpml_pageid(get_option('page_on_front'));
?>

<?php
if ($pagid > 0)
{

	$waterside_loop = new WP_Query( array( 'page_id' => $pagid ) );
					
		if ($waterside_loop->have_posts()) {
		//The Loop
		while ( $waterside_loop->have_posts() ) : $waterside_loop->the_post(); ?>
	
		<div class="post-meta">
			<h1 class="title-l"><?php the_title(); ?></h1>
		</div><!-- end .post-meta -->

		<div class="divider">&nbsp;</div>

		<div class="post-single">
		
			<?php the_content(); ?>
			
			<div class="cleaner">&nbsp;</div>
			
		</div><!-- .post-single -->
	
		<?php endwhile;
	}
} else { ?>

<div class="post-meta">
	<h1 class="title title-l"><?php _e('Thank you for installing Waterside Theme','waterside'); ?></h1>
</div><!-- end .post-meta -->

<div class="divider">&nbsp;</div>

<div class="post-single">

	<p><?php _e('Please select a static page to be displayed on the homepage.','waterside'); ?><br />
	<?php _e('You can do so by going to','waterside'); ?> <a href="<?php echo get_admin_url(); ?>/options-reading.php">Dashboard > Settings > Reading</a></p>
	
	<div class="cleaner">&nbsp;</div>
	
</div><!-- .post-single -->

<?php wp_reset_query(); ?>

<?php } // if page is set ?>