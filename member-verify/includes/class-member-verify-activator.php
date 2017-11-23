<?php

/**
 * Fired during plugin activation
 *
 * @link       https://tajidyakub.com/
 * @since      1.0.0
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Member_Verify
 * @subpackage Member_Verify/includes
 * @author     Tajid Yakub <tajid.yakub@gmail.com>
 */
class Member_Verify_Activator {
	/**
	 * Flush WP rewrite rules during activation.
	 * 
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
}
