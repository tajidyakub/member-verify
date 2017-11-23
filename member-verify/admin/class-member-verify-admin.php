<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tajidyakub.com/
 * @since      1.0.0
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/admin
 * @author     Tajid Yakub <tajid.yakub@gmail.com>
 */
class Member_Verify_Admin {

	/**
	 * The Identity of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $plugins    The Identity of this plugin.
	 */
	private $plugins;

	/**
	 * Initialize the class.
	 * 
	 * Populate private properties.
	 */
	public function __construct( $plugins ) {
		$this->plugins = $plugins;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		$plugins = $this->plugins;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Member_Verify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Member_Verify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $plugins['package'], $plugins['url'] . 'admin/css/member-verify-admin.css', array(), $plugins['version'], 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$plugins = $this->plugins;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Member_Verify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Member_Verify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $plugins['name'], $plugins['url'] . 'js/member-verify-admin.js', array( 'jquery' ), $plugins['version'], false );

	}

}
