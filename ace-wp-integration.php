<?php
/**
 * Plugin Name:       Ace Integration
 * Plugin URI:         https://playace.de
 * Description:        Official WordPress integration for the Ace tennis platform. Thin-wrapper plugin that outputs lightweight web components powered by Ace's Next.js widget infrastructure.
 * Version:            1.0.0
 * Requires at least:  5.8
 * Requires PHP:       7.4
 * Author:             Ace
 * Author URI:         https://playace.de
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:        ace-wp-integration
 */

// Block direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ACE_WP_VERSION', '1.0.0' );
define( 'ACE_WP_PLUGIN_FILE', __FILE__ );
define( 'ACE_WP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ACE_WP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once ACE_WP_PLUGIN_DIR . 'includes/class-ace-wp-settings.php';
require_once ACE_WP_PLUGIN_DIR . 'includes/class-ace-wp-assets.php';
require_once ACE_WP_PLUGIN_DIR . 'includes/class-ace-wp-shortcode.php';
require_once ACE_WP_PLUGIN_DIR . 'includes/class-ace-wp-block.php';

/**
 * Boot the plugin.
 */
function ace_wp_init() {
	Ace_Wp_Settings::instance();
	Ace_Wp_Assets::instance();
	Ace_Wp_Shortcode::instance();
	Ace_Wp_Block::instance();
}
add_action( 'plugins_loaded', 'ace_wp_init' );
