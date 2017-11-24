<?php
/*
Plugin Name: Reminder Emails
Plugin URI: http://www.christopherguitar.net/
Description: Sends a reminder email if you haven't posted in seven days.
Version: n/a
Author: Christopher Davis
Author URI: http://www.christopherguitar.net
License: GPL2, Creative Commons
*/

register_activation_hook( __FILE__, 'wpse29671_activation' );
function wpse29671_activation()
{
	wp_schedule_event( time(), 'daily', 'wpse29671_cron' );
}

add_action( 'wpse29671_cron', 'wpse29671_maybe_send_email' );
function wpse29671_maybe_send_email()
{
	// get the latest post
	$posts = get_posts( array( 'numberposts' => 1 ) );
	if( ! $posts ) return;

	// Latest posts date as a unix timestamp
	$latest = strtotime( $posts[0]->post_date );
	
	// how long has it been?
	$diff = ( time() - $latest ) / ( 60 * 60 * 24 );
	
	// if it has been more than 7 days, send the email
	if( $diff >= 7 )
	{
		wp_mail( 'shane@thenewmediagroup.ca', 'Better Write a Post!', 'Hey, you should go write a blog post or something' );
	}
}

register_deactivation_hook( __FILE__, 'wpse29671_deactivation' );
function wpse29671_deactivation()
{
	wp_clear_scheduled_hook( 'wpse29671_cron' );
}