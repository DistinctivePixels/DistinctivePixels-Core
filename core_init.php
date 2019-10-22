<?php

/**
 * Grab our framework options as registered by the theme.
 * If ebor_framework_options isn't set then we'll pull a list of defaults.
 * By default everything is turned off.
 */

$defaults = array(
	'portfolio_post_type'   	=> '0',
	'team_post_type'        	=> '0',
	'client_post_type'      	=> '0',
	'testimonial_post_type' 	=> '0',
	'core_widgets' 				=> '0',
	'buzzpress_blocks' 			=> '0',
	'distinctpress_blocks' 		=> '0',
);
$framework_options = wp_parse_args( get_option('distinctive_core_options'), $defaults);

if( '1' == $framework_options['core_widgets'] ){
	require_once( DISTINCTIVEPIXELS_CORE_PATH . 'widgets/core-widgets.php' );	
}

/**
 * Register Portfolio Post Type
 */

if( '1' == $framework_options['portfolio_post_type'] ){
		add_action( 'init', 'register_portfolio' );		
		add_action( 'init', 'create_portfolio_taxonomies');
}

/**
 * Register Team Post Type
 */
if( '1' == $framework_options['team_post_type'] ){
		add_action( 'init', 'register_team');
		add_action( 'init', 'create_team_taxonomies');
}

/**
 * Register Client Post Type
 */
if( '1' == $framework_options['client_post_type'] ){
		add_action( 'init', 'register_client' );
		add_action( 'init', 'create_client_taxonomies');
}

/**
 * Register Testimonials Post Type
 */
if( '1' == $framework_options['testimonial_post_type'] ){
		add_action( 'init', 'register_testimonials_post_type' );
		add_action( 'init', 'create_testimonial_taxonomies');
}

/* 
MCE Buttons & SHORTCODES
*/
add_action( 'init', 'distinctivepixels_core_shortcode_button' );
function distinctivepixels_core_shortcode_button() {
    add_filter("mce_external_plugins", "distinctivepixels_core_shortcode_add_buttons");
    add_filter('mce_buttons', 'distinctivepixels_core_shortcode_register_buttons');
}

function distinctivepixels_core_shortcode_add_buttons($plugin_array) {
    $plugin_array['distinctivepixels_core_shortcode'] = plugins_url( 'shortcodes/assets/js/shortcode-mce.js', __FILE__ );
    return $plugin_array;
}

function distinctivepixels_core_shortcode_register_buttons($buttons) {
    array_push( $buttons, 'open_builder' ); // dropcap', 'recentposts
    return $buttons;
}

require_once( DISTINCTIVEPIXELS_CORE_PATH . 'shortcodes/core_shortcodes.php' );	

if( '1' == $framework_options['distinctpress_blocks'] ){
	require_once(DISTINCTIVEPIXELS_CORE_PATH . 'page_builder_blocks/distinctpress-pro/page_builder_init.php' );	
}

if( '1' == $framework_options['buzzpress_blocks'] ){
	require_once( DISTINCTIVEPIXELS_CORE_PATH . 'page_builder_blocks/buzzpress/page_builder_init.php' );	
}

?>