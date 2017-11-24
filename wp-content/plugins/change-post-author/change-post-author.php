<?php
/*
Plugin Name: Change Post Author
Description: This plugin will let you change the author of a post to any user (not just admin or author).
Author: Richard Bonk
Version: 1.0.2
Plugin URI: http://premiumwebservices.co.uk/shop/premiumpress-plugins/change-post-author/
Author's Website: http://premiumwebservices.co.uk
Last modified: 23rd March 2014
*/

$api_url = 'http://premiumwebservices.co.uk/updates/update.php';
$plugin_slug = basename(dirname(__FILE__));

if(!function_exists('remove_author_box')) {
function remove_author_box() {
	$themetype = THEME_TAXONOMY."_type";
    remove_meta_box( 'authordiv', 'post', 'normal' );
	remove_meta_box( 'authordiv', $themetype, 'normal' );
}
}

if(!function_exists('move_author_meta')) {
function move_author_meta() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
    better_author_meta_box( $post );  //This function is being called in replace author_meta_box()
	echo '</div>';
}
}

if(!function_exists('better_author_meta_box')) {
function better_author_meta_box($post) { global $user_ID; ?>
   <label class="screen-reader-text" for="post_author_override"><?php _e('Author'); ?></label>
  <?php
	$selected = $post->post_author;
    wp_dropdown_users( array(
            'name' => 'post_author_override',
			'selected' => empty($post->ID) ? $user_ID : $post->post_author,
            'orderby'          => 'display_name',
            'show'             => 'display_name',
            'order'            => 'ASC'
      ) );
}
}

if(!function_exists('check_for_plugin_update')) {
	function check_for_plugin_update($checked_data) {
		global $api_url, $plugin_slug;
		
		if (empty($checked_data->checked))
			return $checked_data;
		
		$request_args = array(
			'slug' => $plugin_slug,
			'version' => $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
		);
		
		$request_string = prepare_request('basic_check', $request_args);
		
		// Start checking for an update
		$raw_response = wp_remote_post($api_url, $request_string);
		
		if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
			$response = unserialize($raw_response['body']);
		
		if (is_object($response) && !empty($response)) // Feed the update data into WP updater
			$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;
		
		return $checked_data;
	}
}

if(!function_exists('my_plugin_api_call')) {
	function my_plugin_api_call($def, $action, $args) {
		global $plugin_slug, $api_url;
		
		if ($args->slug != $plugin_slug)
			return false;
		
		// Get the current version
		$plugin_info = get_site_transient('update_plugins');
		$current_version = $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
		$args->version = $current_version;
		
		$request_string = prepare_request($action, $args);
		
		$request = wp_remote_post($api_url, $request_string);
		
		if (is_wp_error($request)) {
			$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
		} else {
			$res = unserialize($request['body']);
			
			if ($res === false)
				$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
		}
		
		return $res;
	}
}	

if(!function_exists('prepare_request')) {
	function prepare_request($action, $args) {
		global $wp_version;
		
		return array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);	
	}
}

function init_change_post_author() {
	add_action( 'admin_menu', 'remove_author_box' );
	add_action( 'post_submitbox_misc_actions', 'move_author_meta' );
	// Take over the Plugin info screen
	add_filter('plugins_api', 'my_plugin_api_call', 10, 3);
	// Take over the update check
	add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');
}

add_action( 'init', 'init_change_post_author' );
?>