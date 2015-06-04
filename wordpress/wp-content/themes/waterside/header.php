<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php wp_title(); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="container">

	<header>
	
		<?php if (has_nav_menu( 'secondary' )) { ?> 

		<div class="wrapper">

			<?php wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'secondary-menu', 'menu_id' => 'menu-secondary-menu', 'sort_column' => 'menu_order', 'depth' => '1', 'theme_location' => 'secondary', 'after' => '<span class="divider"> / </span>') ); ?>

		</div><!-- .wrapper -->

		<?php }	?>
		
		<div class="wrapper wrapper-header">

			<div id="logo">
				<?php if (get_theme_mod('hermes_logo_upload') != '') { ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('description'); ?>">
					<img src="<?php echo esc_attr(get_theme_mod('hermes_logo_upload')); ?>" alt="<?php bloginfo('name'); ?>" />
				</a>
				<?php } else { ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" id="logo-anchor"><?php bloginfo('name'); ?></a>
				<p class="logo-tagline"><?php bloginfo('description'); ?></p>
				<?php } ?>
			</div><!-- end #logo -->
			
			<nav id="menu-main">

				<?php if (has_nav_menu( 'primary' )) { 
					wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => 'dropdown', 'menu_id' => 'menu-main-menu', 'sort_column' => 'menu_order', 'theme_location' => 'primary', 'items_wrap' => '<ul id="menu-main-menu" class="dropdown sf-js-enabled">%3$s</ul>') );
				}
				else
				{
					if (current_user_can('edit_theme_options')) {
						echo '<div id="menu-main-menu"><p class="hermes-notice">Please set your Main Menu on the <a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a> page.</p></div>';
					}
				}
				?>

			</nav><!-- #header-menu -->
			
			<div class="cleaner">&nbsp;</div>

		</div><!-- .wrapper .wrapper-header -->
		
	</header>