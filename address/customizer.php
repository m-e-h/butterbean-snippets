<?php
/**
 * Theme Customizer.
 *
 * @package butterbean-snippets
 */

add_action( 'customize_register', 'bbs_customize_register' );

/**
 * Customizer Settings
 *
 * @param  array $wp_customize Add controls and settings.
 */
function bbs_customize_register( $wp_customize ) {

	// Add our API Customization section section.
	$wp_customize->add_section(
		'meh_api_section',
		array(
			'title'    => esc_html__( 'Owner Info and APIs', 'bbs' ),
			'priority' => 90,
		)
	);

	// Add maps api text field.
	$wp_customize->add_setting(
		'google_maps_api',
		array(
			'default' => '',
		)
	);
	$wp_customize->add_control(
		'google_maps_api',
		array(
			'label'       		=> esc_html__( 'Google Maps JS API', 'bbs' ),
			'description' 		=> esc_html__( 'YOUR_API_KEY', 'bbs' ),
			'section'     		=> 'meh_api_section',
			'type'        		=> 'text',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);
}
