	<footer>
	
		<div class="wrapper wrapper-footer">
		
			<?php if (has_nav_menu( 'footer' )) { 
				wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'footer-menu', 'menu_id' => 'menu-footer', 'sort_column' => 'menu_order', 'depth' => 1, 'theme_location' => 'footer', 'link_after' => '<span class="divider"> / </span>') );
			} ?>

			<div class="cleaner">&nbsp;</div>
		
		</div><!-- end .wrapper .wrapper-footer -->

	</footer>

	<div class="wrapper wrapper-copy">

		<p class="hermes-credit"><?php _e('Theme by', 'waterside'); ?> <a href="http://www.hermesthemes.com" target="_blank">HermesThemes</a></p>
		<?php $copyright_default = __('Copyright &copy; ','waterside') . date("Y",time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved', 'waterside'); ?>
		<p class="copy"><?php echo esc_attr(get_theme_mod( 'hermes_copyright_text', $copyright_default )); ?></p>

	</div><!-- .wrapper .wrapper-center -->

</div><!-- end #container -->

<?php 
wp_footer(); 
wp_reset_query();
?>
</body>
</html>