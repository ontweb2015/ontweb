<?php get_header(); ?>

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
					
					<div class="cleaner">&nbsp;</div>
					
					<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'waterside').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
				</div><!-- .post-single -->
				
				<?php endwhile; ?>

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