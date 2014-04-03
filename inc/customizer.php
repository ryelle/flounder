<?php
/**
 * Flounder Theme Customizer
 *
 * @package Flounder
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function flounder_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'flounder_settings', array(
		'title'       => __('Layout', 'flounder'),
		'priority'    => 35,
		'description' => __( "In the classic layout, the sidebar is responsive and moves to the right side if the screen is larger than 1300px wide. You can force it to always stay left by choosing 'Sidebar always on left'", 'museum' ),
	) );

	$wp_customize->add_setting( 'flounder_layout', array(
		'default' => 'classic',
	) );

	$wp_customize->add_control( 'flounder_layout', array(
		'label'   => 'Site layout',
		'section' => 'flounder_settings',
		'type'    => 'select',
		'choices' => array(
			'sidebar-classic'     => __( 'Classic (responsive columns)', 'flounder' ),
			'sidebar-force-left'  => __( 'Sidebar always on left', 'flounder' ),
		),
	) );

}
add_action( 'customize_register', 'flounder_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function flounder_customize_preview_js() {
	wp_enqueue_script( 'flounder_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130304', true );
}
add_action( 'customize_preview_init', 'flounder_customize_preview_js' );
