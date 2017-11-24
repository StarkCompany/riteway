<?php
/**
 * Plugin Name: RitewaySigns.com Custom Plugins
 * Plugin URI:  http://ritewaysigns.com
 * Text Domain: custom plugins and shortcodes for rightwaysigns.com
 * Domain Path: /languages
 * Description: custom plugins and shortcodes for rightwaysigns.com
 * Author:      Riteway
 * Author URI:  http://ritewaysigns.com
 * Version:     1.0.0
 * License:     GPLv3
 */

//[rightway-terms-conditions]
function rightWayTermsAndConditions($atts) {
	return '<a title="Terms & Conditions" href="/terms-conditions" target="_blank">Terms & Conditions</a>';
}

add_shortcode( 'rightway-terms-conditions', 'rightWayTermsAndConditions' );

// Set user registration to pending state
// wp-admin/users.php?role=wpau_unapproved
function ritewayRegistrationSave( $user_id ) {
	update_user_meta($user_id, 'wp-approve-user', '');
}

add_action( 'user_register', 'ritewayRegistrationSave', 100, 1 );
