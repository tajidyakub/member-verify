<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://tajidyakub.com/
 * @since      1.0.0
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Member_Verify
 * @subpackage Member_Verify/includes
 * @author     Tajid Yakub <tajid.yakub@gmail.com>
 */
class Member_Verify {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Member_Verify_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin in Array.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $plugins    Array consist of plugins info.
	 */
	protected $plugins;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$plugins       = $this->get_plugin_data();
		$this->plugins = $plugins; 
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Member_Verify_Loader. Orchestrates the hooks of the plugin.
	 * - Member_Verify_i18n. Defines internationalization functionality.
	 * - Member_Verify_Admin. Defines all hooks for the admin area.
	 * - Member_Verify_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$plugins = $this->plugins;
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once "{$plugins['dir']}includes/class-member-verify-loader.php";

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once "{$plugins['dir']}includes/class-member-verify-i18n.php";

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once "{$plugins['dir']}admin/class-member-verify-admin.php";

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once "{$plugins['dir']}public/class-member-verify-public.php";

		$this->loader = new Member_Verify_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Member_Verify_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Member_Verify_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugins = $this->plugins;
		$plugin_admin = new Member_Verify_Admin( $plugins );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugins = $this->plugins;
		$plugin_public = new Member_Verify_Public( $plugins );

		// Styles and scripts
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'enqueue_styles_login' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		
		// Add notice in the registration form 
		$this->loader->add_action( 'register_form', $plugin_public, 'form_notice' );
		// Redirect user to verification page
		$this->loader->add_filter( 'registration_redirect', $plugin_public, 'registration_redirect' );
		// Adding query filter.
		$this->loader->add_filter( 'query_vars', $plugin_public, 'add_query_vars' );
		// Including private template file
		$this->loader->add_filter( 'template_include', $plugin_public, 'include_template' );
		// Update usermeta and Send email when new user registered
		$this->loader->add_action( 'user_register', $plugin_public, 'user_registered', 10, 1 );

		// Custom template tags
		$this->loader->add_action( 'mv_version', $plugin_public, 'show_version' );
		$this->loader->add_action( 'mv_name', $plugin_public, 'show_name' );
		$this->loader->add_action( 'mv_url', $plugin_public, 'show_url' );
		$this->loader->add_filter( 'mv_token_check', $plugin_public, 'token_check', 10, 2 );
		$this->loader->add_filter( 'login_redirect', $plugin_public, 'login_confirmed_redirect', 10, 3  );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the Plugin's data array.
	 * 
	 * @since  1.0.0
	 * @return array  $plugins Array contain plugins data.
	 */
	public static function get_plugin_data() {
		$plugins = array(
			'version' => MV_VERSION,
			'name'    => MV_NAME,
			'package' => MV_PACKAGE,
			'dir'     => MV_DIR,
			'url'     => MV_URL,
		);
		return $plugins;
	}
	 /**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Member_Verify_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}

function mv_version(){
	do_action('mv_version');
}

function mv_name(){
	do_action('mv_name');
}

function mv_url(){
	do_action('mv_url');
}

function mv_token_check( $token ) {
	$value = apply_filters('mv_token_check' , $token );
	return $value;
}

