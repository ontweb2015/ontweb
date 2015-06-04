<?php			

/**
 * Adds the Customize page to the WordPress admin area
 */
function waterside_customizer_menu() {
	add_theme_page( __('Customize','waterside'), __('Customize','waterside'), 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'waterside_customizer_menu' );

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */

function waterside_customizer( $wp_customize ) {

	// Define array of web safe fonts
	$waterside_fonts = array(
		'default' => __('Default','waterside'),
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'Georgia, serif' => 'Georgia, serif',
		'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
		'"Open Sans", Arial, Helvetica, sans-serif' => 'Open Sans, Arial, Helvetica, sans-serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype, Book Antique, Palatino, serif',
		'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
	);

	$wp_customize->add_section(
		'waterside_section_general',
		array(
			'title' => __('General Settings','waterside'),
			'description' => 'This controls various general theme settings.',
			'priority' => 5,
		)
	);

	$wp_customize->add_section(
		'waterside_section_fonts',
		array(
			'title' => __('Fonts & Color Settings','waterside'),
			'description' => 'Customize theme fonts and color of elements.',
			'priority' => 35,
		)
	);


	$wp_customize->add_setting( 
		'waterside_logo_upload',
		array(
			'sanitize_callback' => 'sanitize_file_upload',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'file-upload',
			array(
				'label' => __('Logo File Upload','waterside'),
				'section' => 'waterside_section_general',
				'settings' => 'waterside_logo_upload'
			)
		)
	);

	$copyright_default = __('Copyright &copy; ','waterside') . date("Y",time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved', 'waterside');
	$wp_customize->add_setting(
		'waterside_copyright_text',
		array(
			'default' => $copyright_default,
			'sanitize_callback' => 'sanitize_text_input',
		)
	);

	$wp_customize->add_control(
		'waterside_copyright_text',
		array(
			'label' => __('Copyright text in Footer','waterside'),
			'section' => 'waterside_section_general',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'waterside_color_header',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'waterside_color_header',
			array(
				'label' => __('Header background color','waterside'),
				'section' => 'waterside_section_fonts',
				'settings' => 'waterside_color_header',
			)
		)
	);

	$wp_customize->add_setting(
		'waterside_font_main',
		array(
			'default' => 'default',
			'sanitize_callback' => 'sanitize_font',
		)
	);
	
	$wp_customize->add_control(
		'waterside_font_main',
		array(
			'type' => 'select',
			'label' => __('Choose the main body font','waterside'),
			'section' => 'waterside_section_fonts',
			'choices' => $waterside_fonts,
		)
	);

	$wp_customize->add_setting(
		'waterside_color_body',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'waterside_color_body',
			array(
				'label' => __('Main body text color','waterside'),
				'section' => 'waterside_section_fonts',
				'settings' => 'waterside_color_body',
			)
		)
	);

	$wp_customize->add_setting(
		'waterside_color_link',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'waterside_color_link',
			array(
				'label' => __('Main body anchor(link) color','waterside'),
				'section' => 'waterside_section_fonts',
				'settings' => 'waterside_color_link',
			)
		)
	);

	$wp_customize->add_setting(
		'waterside_color_link_hover',
		array(
			'default' => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'waterside_color_link_hover',
			array(
				'label' => __('Main body anchor(link) :hover color','waterside'),
				'section' => 'waterside_section_fonts',
				'settings' => 'waterside_color_link_hover',
			)
		)
	);

}
add_action( 'customize_register', 'waterside_customizer' );