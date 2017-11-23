<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://tajidyakub.com/
 * @since      1.0.0
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Member_Verify
 * @subpackage Member_Verify/includes
 * @author     Tajid Yakub <tajid.yakub@gmail.com>
 */
class Member_Verify_Deactivator {

	/**
	 * Flush WP rewrite rules during deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		// delete_metadata ( 'user', NULL, 'is_confirmed', NULL, true );
		// delete option
		delete_option('member-verify-data');
	}

}
