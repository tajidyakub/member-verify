<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tajidyakub.com/
 * @since      1.0.0
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Member_Verify
 * @subpackage Member_Verify/public
 * @author     Tajid Yakub <tajid.yakub@gmail.com>
 */
class Member_Verify_Public {

	/**
	 * The identity of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $plugins    The identity of this plugin.
	 */
	protected $plugins;

	/**
	 * The identity of the user.
	 * 
	 * @since   1.0.0
	 * @access  protected
	 * @var     integer   $user_id  The identity of the user.
	 */
	protected $user_id;
	
	/**
	 * WP Mail instance.
	 * 
	 * @since   1.0.0
	 * @access  public
	 * @var     object   WP_Mail instance.
	 */
	public $wp_mail;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    array    $plugins       The Identity array of the plugin.
	 */
	public function __construct( $plugins ) {
		$this->plugins = $plugins;
	}
	/**
	 * Register custom query var.
	 * 
	 * @param array $vars Query var array.
	 */
	function add_query_vars( $vars ) {
		$vars[] = 'verify_action';
		$vars[] = 'verify_token';
		return $vars;
	}
	/**
	 * Function to display notice in the registration form.
	 */
	public function form_notice() {
		$plugins  = $this->plugins;
		// TODO: Modify from admin page
		// TODO: Plugin Name, link and version as params
		include( $plugins['dir'] . 'public/partials/regis-form-confirmation-notice.php');
	}
	/**
	 * Define redirection URLs after user register.
	 */
	function registration_redirect() {
		return '/verification/register/';
	}
	/**
	 * Including a template file to display the virtual page
	 */
	public function include_template( $template ) {
		$plugins = $this->plugins;		
		global $wp_query;		
		$new_tempate = '';
		
		if (array_key_exists( 'verify_action', $wp_query->query_vars ) ) {
			$new_template = $plugins['dir'] . "/public/partials/template-verification-page.php";
			return $new_template;
		}
		return $template;
	}
	/**
	 * Callback executed after user registration saved.
	 * 
	 * @param  integer $user_id  ID of the new user.
	 * @since  1.0.0 
	 */
	public function user_registered( $user_id ) {
		// Update class property
		$this->user_id     = $user_id;
		// Update user meta in the DB
		update_user_meta( $user_id, 'is_confirmed', 0);
		// Send Email to user
		$this->send_confirmation_mail();
	}

	/**
	 * Send confirmation email.
	 * 
	 * @since 1.0.0
	 */
	public function send_confirmation_mail() {
		$plugins           = $this->plugins;
		$user_id           = $this->user_id;
		$user              = get_userdata( $user_id );
		
		$token             = sha1(uniqid());
		$prefix            = $this->plugins['name'] . '-';

		// TODO: Email templating accessible from the admin page
		// TODO: Option for non HTML email
		$oldData = get_option($prefix .'data') ?: array();
		$data = array();
		$data[$token] = $_POST;
		update_option($prefix .'data', array_merge($oldData, $data));

		$mail_template         = $plugins['dir'] . 'public/partials/template-confirmation-email.html';
		$mail_to               = $user->user_email;
		$mail_subject          = __( 'Please Confirm your Email Address', 'member-verify' );
		$mail_confirmation_url = home_url() . '/verification/verify' . "?token=" . $token;
		$mail_from             = get_option( 'admin_email' );
		$blog_name             = get_option( 'blogname' );
		$mail_headers          = array(
			"X-Mailer: PHP",
			"MIME-Version: 1.0\r\n",
			"Content-Type: text/html; charset=ISO-8859-1\r\n",
			"From: {$mail_from}"
		);
		require_once "{$plugins['dir']}public/WP_Mail.php";
		$wp_mail = ( new WP_Mail )
			->headers( $mail_headers )
			->to( $mail_to )
			->subject( "[{$blog_name}] $mail_subject" )
			->template( $mail_template, [
				'mail_web_name'          => $blog_name,
				'mail_title'             => $mail_subject,
				'mail_body_title'        => __( 'Confirmation Required', 'member-verify' ),
				'mail_user'              => $mail_to,
				'mail_notice'            => __( 'Thank you for your registration. Please Click the link below to confirm your Email address.', 'member-verify' ),
				'mail_confirmation_url'  => $mail_confirmation_url,
				'mail_confirmation_text' => __( 'Click to Confirm', 'member-verify' ),
				'plugin_link'            => 'https://tajidyakub.com/from=wp-member-verify',
				'plugin_name'            => 'Member Verify',
				'plugin_version'         => $plugins['version'],
				] )
				->send();
	
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$plugins = $this->plugins;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 */

		wp_enqueue_style( $plugins['name'], $plugins['url'] . 'public/css/member-verify-public.css', array(), $plugins['version'], 'all' );

	}

	/**
	 * Register the stylesheets for the login form.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_login() {

		$plugins = $this->plugins;
		/**
		 * This function is provided for demonstration purposes only.
		 */

		wp_enqueue_style( $plugins['name'] .'-login', $plugins['url'] . 'public/css/member-verify-login.css', array(), $plugins['version'], 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$plugins = $this->plugins;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 */

		wp_enqueue_script( $plugins['name'], $plugins['url'] . 'js/member-verify-public.js', array( 'jquery' ), $plugins['version'], false );

	}

	public function show_version() {
		$plugins = $this->plugins;
		echo $plugins['version'];
	}
	
	public function show_name() {
		echo 'Member Verify';
	}

	public function show_url() {
		echo 'https://tajidyakub.com/from=wp-member-verify';
	}

	public function token_check( $token ) {
		$plugins        = $this->plugins;
		$prefix         = "{$plugins['name']}-";
		$data           = get_option($prefix .'data');

		if ( ! empty( $data[$token] ) )	{
			$userData       = $data[$token];
			$user_email     = $userData['user_email'] ;
			$user           = get_user_by( 'email', $user_email );
			$user_id        = $user->ID;			
			update_user_meta( $user_id, 'is_confirmed', '1' );
			unset( $data[$token] );
			update_option( $prefix .'data', $data );			
			return true; 
		} else {
			return false; 
		}
	}

	public function login_confirmed_redirect( $redirect_to, $request, $user ) {
		$redirect_to = '/verification/required';
		if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
			$user_id = $user->ID;
			// check user meta is_confirmed
			if ( get_user_meta( $user_id, 'is_confirmed', true ) ) {
				return admin_url();	
			} 
			return $redirect_to;
		} else {
			return $redirect_to;
		}
	}

}



