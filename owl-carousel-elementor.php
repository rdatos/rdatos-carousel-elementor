<?php
/**
 * Plugin Name: Rdatos Owl Carousel for Elementor
 * Description: A highly customizable & responsive carousel plugin for Elementor page builder based on Owl Carousel
 * Plugin URI: https://github.com/rdatos/owl-carousel-elementor
 *
 * Version: 0.1.0
 * Author: Rdatos
 * Author URI: https://www.rdatos.com
 *
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: rdatos-owl-carousel-elementor
 * Domain Path: /languages
 *
 * Requires at least: 5.0
 * Tested up to: 5.9.3
 * Requires PHP version: 7.3
 *
 * Elementor tested up to: 3.6.5
 * Elementor Pro tested up to: 3.6.5
 */

defined( 'ABSPATH' ) || exit;

use Owl_Carousel_Elementor\Plugin;

/**
 * Define useful constants
 */
define( "OWCE_VERSION", '0.1.0' );
define( "OWCE_PLUGIN_FILE", __FILE__ );
define( "OWCE_PLUGIN_PATH", __DIR__ );
define( "OWCE_PLUGIN_URL", plugins_url( '', OWCE_PLUGIN_FILE ) );
define( "OWCE_PLUGIN_ASSETS", OWCE_PLUGIN_URL . '/assets' );

/**
 * Plugin function
 *
 * The main plugin function that initializes the plugin
 *
 * @since 1.0.0
 */
function owl_carousel_elementor_addon() {
	// Load plugin file
	require_once( OWCE_PLUGIN_PATH . '/includes/plugin.php' );
	// Run the plugin
	Plugin::instance();
}

add_action( 'plugins_loaded', 'owl_carousel_elementor_addon' );

/**
 * Plugin activation
 *
 * Add options to database upon plugin activation
 *
 * @since 1.0.0
 */
function owce_activate() {
	update_option( 'owce_version', OWCE_VERSION );
	add_option( 'owce_installed', time() );
}

register_activation_hook( __FILE__, 'owce_activate' );
