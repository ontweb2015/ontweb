<?php get_header(); ?>

<div id="content">
	
	<div class="wrapper wrapper-main">

		<div id="main">
		
			<div class="wrapper-content">
			
				<div class="post-meta">
					<h1 class="title-l title-margin"><?php _e('Search Results for', 'waterside');?>: <strong><?php the_search_query(); ?></strong></h1>
				</div><!-- end .post-meta -->

				<div class="divider">&nbsp;</div>
	
				<?php get_template_part('loop'); ?>			
				
			</div><!-- .wrapper-content -->
		
		</div><!-- #main -->
		
		<?php get_sidebar(); ?>
		
		<div class="cleaner">&nbsp;</div>
	</div><!-- .wrapper .wrapper-main -->

</div><!-- #content -->

<?php get_footer(); ?>