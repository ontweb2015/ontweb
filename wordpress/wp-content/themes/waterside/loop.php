<ul class="hermes-posts">
	
	<?php while (have_posts()) : the_post(); unset($prev); $m++; ?>
	<li <?php post_class('hermes-post'); ?>>

		<?php
		get_the_image( array( 'size' => 'thumb-loop-main', 'width' => 100, 'height' => 60, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
		?>
		
		<div class="post-excerpt">
			<h2 class="title-post title-s"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'waterside' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
			<p class="post-meta"><time datetime="<?php echo get_the_date('c'); ?>" pubdate><?php echo get_the_date(); ?></time> / <span class="category"><?php the_category(', '); ?></span></p>
			<?php the_excerpt(); ?>
		</div><!-- end .post-excerpt -->

		<div class="cleaner">&nbsp;</div>
		
	</li><!-- end .hermes-post -->
	<?php endwhile; ?>
	
</ul><!-- end .hermes-posts -->

<?php get_template_part( 'pagination'); ?>