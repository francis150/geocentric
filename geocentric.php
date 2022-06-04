<?php
/**
 * Plugin Name: Geocentric
 * Description: Pull all relevant geocentric data to your service area page in one click!
 * Version: 2.0.2
 * Requires at least: 5.2
 * Tested up to: 5.9
 * Requires PHP: 7.2
 * Author: SEO Rocket Tools
 * Author URI: http://seorockettools.com/
 * Text Domain: _geocentric
 */

defined( 'ABSPATH' ) or die( 'Silence is Golden!' );

// Require the core php file with class
require plugin_dir_path( __FILE__ ) . 'includes/geocentric_core_class.php';
new _geocentric_core();