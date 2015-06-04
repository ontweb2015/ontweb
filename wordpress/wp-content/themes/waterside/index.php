<?php get_header(); ?>

<div id="content">
	
	<div class="wrapper wrapper-main">

		<div id="main">
		
			<div class="wrapper-content">
			
				<?php if (get_option('page_on_front') == $post->ID) {
				
					get_template_part('featured-page');
				
				} // if displaying a static page
				else {
				
					?>
					
					<div class="post-meta">
						<h1 class="title-l title-margin"><?php _e('Recent Posts','waterside'); ?></h1>
					</div><!-- end .post-meta -->
					
					<div class="divider">&nbsp;</div>
					
					<?php
					get_template_part('loop','index');
				
				} // if displaying posts
				
				?>
				
			</div><!-- .wrapper-content -->
		
		</div><!-- #main -->
		
		<?php get_sidebar(); ?>
		
		<div class="cleaner">&nbsp;</div>
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->
	
<?php get_footer(); ?>