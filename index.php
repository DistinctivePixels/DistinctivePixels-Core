<?php

/*
Plugin Name: DistinctivePixels Core
Plugin URI:https://www.distinctivepixels.com
Description: Core Framework Plugin for DistinctivePixels WordPress Themes.
Version: 1.0.0
Author: DistinctivePixels
Author URI: https://www.distinctivepixels.com
*/	
/**
 * Plugin definitions
 */
define( 'DISTINCTIVEPIXELS_CORE_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'DISTINCTIVE_CORE_VERSION', '1.0');

/**
 * Grab all custom post type functions
 */
require_once( DISTINCTIVEPIXELS_CORE_PATH . 'core_cpts.php' );

/**
 * Everything else in the framework is conditionally loaded depending on theme options.
 * Let's include all of that now.
 */
require_once( DISTINCTIVEPIXELS_CORE_PATH . 'core_init.php' );

?>
