<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tajidyakub.com/
 * @since             1.0.0
 * @package           Member_Verify
 *
 * @wordpress-plugin
 * Plugin Name:       Member Verify
 * Plugin URI:        https://github.com/tajidyakub/member-verify
 * Description:       Send confirmation link via email when user register.
 * Version:           1.0.0
 * Author:            Tajid Yakub
 * Author URI:        https://tajidyakub.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       member-verify
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$plugins_dir = plugin_dir_path( __FILE__ );
$plugins_url = plugin_dir_url( __FILE__ );
// Plugin global constants.
define( 'MV_VERSION', '1.0.0' );
define( 'MV_NAME', 'member-verify' );
define( 'MV_PACKAGE', 'Member_Verify' );
define( 'MV_DIR', $plugins_dir );
define( 'MV_URL', $plugins_url );


if ( ! function_exists( 'member_verify_add_rule' ) ) {
	/**
	* Adding custom rewrite rules before activation.
	*
	* And put the callback in init hook so it gets loaded
	* Everytime other plugins reset the lifecycle.
	*/
	function member_verify_add_rule() {
		global $wp_rewrite;
		add_rewrite_tag( '%verify_action%', '([^&]+)' );
		add_rewrite_rule( '^verification/([^/]*)/?', 'index.php?verify_action=$matches[1]','top' );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-member-verify-activator.php
 */
function activate_member_verify() {
	require_once MV_DIR . 'includes/class-member-verify-activator.php';
	member_verify_add_rule();
	Member_Verify_Activator::activate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-member-verify-deactivator.php
 */
function deactivate_member_verify() {
	require_once MV_DIR . 'includes/class-member-verify-deactivator.php';
	Member_Verify_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_member_verify' );
register_deactivation_hook( __FILE__, 'deactivate_member_verify' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require MV_DIR . 'includes/class-member-verify.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_member_verify() {
	add_action( 'init', 'member_verify_add_rule');
	$plugin = new Member_Verify();
	$plugin->run();

}
run_member_verify();
