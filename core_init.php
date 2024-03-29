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
	'milea_blocks' 				=> '0',
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

if( '1' == $framework_options['milea_blocks'] ){
	require_once(DISTINCTIVEPIXELS_CORE_PATH . 'page_builder_blocks/milea/functions.php' );	
}

?>