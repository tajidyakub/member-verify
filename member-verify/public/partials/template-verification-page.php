<?php

/**
 * Template for plugin's public interface.
 * 
 * Check slug '/verification/register' or '/verification/verify'
 */
//TODO: Make the template more accessible and custom
//TODO: Check referrer, can only open if call from designated referrer
// check referrer
global $wp_query;
$action   = $wp_query->query_vars['verify_action'];
$verified = false;

if ( $action == 'verify' ) {
	$token    = $_GET['token'];
	$verified = mv_token_check( $token );
} 
?>
<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
</head>
<body>
	<div class="mv-confirmation-notice">
	<?php if ( $action == 'register' && wp_get_referer() ) {
		?>
		<h1><?php _e( 'Thank You', 'member-verify' ) ?></h1>
		<p><?php bloginfo('name'); ?></p>
		<p><?php _e( 'Thankyou for your registration, you need to <strong>confirm your Email address</strong> to continue using the website.', 'member-verify' )?></p>
		<p><?php _e( 'Please Check your email to do so.', 'member-verify' ); ?></p>
	<?php
	} elseif ( $verified ) {
		?>
			<h1><?php _e( 'Email Confirmed', 'member-verify' ) ?></h1>
			<p><?php _e( 'Thank you for your confirmation, your Email Address is now confirmed', 'member-verify' ) ?></p>
	<?php
	} elseif ( $action == 'required' && wp_get_referer() ) {
		?>
			<h1><?php _e( 'Email Confirmation Required', 'member-verify' ) ?></h1>
			<p><?php _e( 'Email address confirmation is <strong>required to continue</strong>, please check your email address for confirmation link', 'member-verify' ) ?></p>
	<?php
		//logout user
		wp_logout();
		exit;
	} else {		
		?>
		<h1><?php _e( 'Error in request', 'member-verify' ) ?></h1>
		<p><?php _e( 'An error occured, please contact Web Administrator', 'member-verify' ) ?></p>
	<?php } ?>
	<span class="mv-plugin-label"><a href="<?php mv_url(); ?>"><?php mv_name(); ?> <strong>v.<?php mv_version(); ?></strong></a></span>
	</div>
	<?php wp_footer(); ?>
</body>
</html>