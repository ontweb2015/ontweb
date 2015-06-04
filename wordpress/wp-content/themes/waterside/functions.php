<?php			

if ( ! isset( $content_width ) ) $content_width = 960;

/* Disable PHP error reporting for notices, leave only the important ones 
================================== */

// error_reporting(E_ERROR | E_PARSE);

/* Add javascripts and CSS used by the theme 
================================== */

function waterside_scripts_styles() {

	// Loads our main stylesheet
	wp_enqueue_style( 'waterside-style', get_stylesheet_uri(), array(), '2015-02-07' );
	
	if (! is_admin()) {

		wp_enqueue_script(
			'superfish',
			get_template_directory_uri() . '/js/superfish.js',
			array('jquery'),
			null
		);
		
		wp_enqueue_script(
			'init',
			get_template_directory_uri() . '/js/init.js',
			array('jquery'),
			null
		);

		wp_enqueue_script(
			'flexslider',
			get_template_directory_uri() . '/js/jquery.flexslider-min.js',
			array('jquery'),
			null
		);

		wp_enqueue_script('thickbox', null,  array('jquery'), null);
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, null);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

		// Loads our default Google Webfont
		wp_enqueue_style( 'waterside-webfont-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,600', array() );

	}

}
add_action('wp_enqueue_scripts', 'waterside_scripts_styles');

// This theme styles the visual editor to resemble the theme style.
add_editor_style( array( 'css/editor-style.css' ) );

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Waterside supports.
 *
 * @return void
 */

function waterside_setup() {

	/* Register Thumbnails Size 
	================================== */
	
	add_image_size( 'thumb-hermes-slideshow', 1020, 350, true );
	add_image_size( 'thumb-loop-gallery', 190, 115, true );
	add_image_size( 'thumb-loop-main', 100, 60, true );
	
	/* 	Register Custom Menu 
	==================================== */
	
	register_nav_menu('primary', 'Main Menu');
	register_nav_menu('secondary', 'Secondary Menu');
	register_nav_menu('footer', 'Footer Menu');
	
	/* Add support for Localization
	==================================== */
	
	load_theme_textdomain( 'waterside', get_template_directory() . '/languages' );
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);
	
	/* Add support for Custom Background 
	==================================== */
	
	add_theme_support( 'custom-background' );
	
	/* Add support for post and comment RSS feed links in <head>
	==================================== */
	
	add_theme_support( 'automatic-feed-links' ); 
}

add_action( 'after_setup_theme', 'waterside_setup' );

/**
 * Registers one widget area.
 *
 * @return void
 */

function waterside_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'waterside' ),
		'id'            => 'sidebar',
		'description'   => __( 'Appears in the narrow column of the site.', 'waterside' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '<div class="cleaner">&nbsp;</div></div>',
		'before_title'  => '<p class="title-widget title-s">',
		'after_title'   => '</p>',
	) );

}

add_action( 'widgets_init', 'waterside_widgets_init' );

/* Enable Excerpts for Static Pages
==================================== */

add_action( 'init', 'waterside_excerpts_for_pages' );

function waterside_excerpts_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

/* Custom Excerpt Length
==================================== */

function waterside_new_excerpt_length($length) {
	return 40;
}
add_filter('excerpt_length', 'waterside_new_excerpt_length');

/* Replace invalid ellipsis from excerpts
==================================== */

function waterside_excerpt($text)
{
   return str_replace(' [...]', '...', $text); // if there is a space before ellipsis
   return str_replace('[...]', '...', $text);
}
add_filter('the_excerpt', 'waterside_excerpt');

/* Reset [gallery] shortcode styles						
==================================== */

add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

/* Comments Custom Template						
==================================== */

function waterside_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
				
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 50 ); ?>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->

					</div><!-- .comment-author .vcard -->
	
					<div class="comment-body">
	
						<?php printf( __( '%s', 'waterside' ), sprintf( '<cite class="comment-author-name">%s</cite>', get_comment_author_link() ) ); ?>
						<span class="comment-timestamp"><?php printf( __('%s at %s', 'waterside'), get_comment_date(), get_comment_time()); ?></span><?php edit_comment_link( __( 'Edit', 'waterside' ), ' <span class="comment-bullet">&#8226;</span> ' ); ?>
	
						<div class="comment-content">
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'waterside' ); ?></p>
						<?php endif; ?>
	
						<?php comment_text(); ?>
						</div><!-- .comment-content -->

					</div><!-- .comment-body -->
	
					<div class="cleaner">&nbsp;</div>
				
				</div><!-- #comment-<?php comment_ID(); ?> -->
		
			</li><!-- #li-comment-<?php comment_ID(); ?> -->
		
			<?php
		break;

		case 'pingback'  :
		case 'trackback' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'waterside' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'waterside' ), ' ' ); ?></p>
			</li>
			<?php
		break;
	
	endswitch;
}

/* Add theme customizer to <head> 
================================== */

function waterside_customizer_head() {

	/*
	This block refers to the functionality of the Appearance > Customize screen.
	*/
	
	$hermes_font_main = get_theme_mod( 'hermes_font_main' );
	$hermes_color_header = get_theme_mod( 'hermes_color_header' );
	$hermes_color_body = get_theme_mod( 'hermes_color_body' );
	$hermes_color_link = get_theme_mod( 'hermes_color_link' );
	$hermes_color_link_hover = get_theme_mod( 'hermes_color_link_hover' );
	
	if( $hermes_font_main != '' || $hermes_color_header != '' || $hermes_color_body != '' || $hermes_color_link != '' || $hermes_color_link_hover != '') {
		echo '<style type="text/css">';
		if (($hermes_font_main != '') && ($hermes_font_main != 'default')) {
			echo 'body { font-family: '.$hermes_font_main.'; } ';
		}
		if ($hermes_color_header != '') {
			echo '.wrapper-header { background-color: '.$hermes_color_header.'; } ';
		}
		if ($hermes_color_body != '') {
			echo 'body, .post-single { color: '.$hermes_color_body.'; } ';
		}
		if ($hermes_color_link != '') {
			echo 'a, .featured-pages h2 a { color: '.$hermes_color_link.'; } ';
		}
		if ($hermes_color_link_hover != '') {
			echo 'a:hover, .featured-pages h2 a:hover { color: '.$hermes_color_link_hover.'; } ';
		}

		echo '</style>';
	}

}
add_action('wp_head', 'waterside_customizer_head');

/* Include WordPress Theme Customizer
================================== */

require_once('hermes-admin/hermes-customizer.php');

/* Include Additional Options and Components
================================== */

if ( !function_exists( 'get_the_image' ) ) {
	require_once('hermes-admin/components/get-the-image.php');
}
require_once('hermes-admin/components/wpml.php'); // enables support for WPML plug-in
require_once('hermes-admin/post-options.php');