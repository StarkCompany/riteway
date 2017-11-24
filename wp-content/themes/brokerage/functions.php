<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// Custom Riteway admin and brokerage overrides
require_once(__DIR__ . '/../../riteway-common/functions.php' );

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic|Open+Sans:400,300,600,700,800');
  wp_register_style('awesomeFonts', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
  wp_enqueue_style( 'googleFonts');
  wp_enqueue_style( 'awesomeFonts');
}

add_action('wp_print_styles', 'bones_fonts');

//Custom Scripts
	wp_register_script( 'excellentexport-js', get_stylesheet_directory_uri() . '/library/js/excellentexport.js', array( 'jquery' ), '', true );
	wp_register_script( 'tablesorter-js', get_stylesheet_directory_uri() . '/library/js/jquery.tablesorter.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'excellentexport-js' );
	wp_enqueue_script( 'tablesorter-js' );

// Filter to fix the Post Author Dropdown
function author_override( $output ) {
    global $post, $user_ID;

    // return if this isn't the theme author override dropdown
    if (!preg_match('/post_author_override/', $output)) return $output;

    // return if we've already replaced the list (end recursion)
    if (preg_match ('/post_author_override_replaced/', $output)) return $output;

    // replacement call to wp_dropdown_users
      $output = wp_dropdown_users(array(
        'echo' => 0,
        'name' => 'post_author_override_replaced',
        'selected' => empty($post->ID) ? $user_ID : $post->post_author,
        'include_selected' => true
      ));

      // put the original name back
      $output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output);

    return $output;
}
add_filter('wp_dropdown_users', 'author_override');

//Sign Post Select list
function user_edit_dropdown()
{
	$blog_id = get_current_blog_id();
	$blogusers = get_users(
		array (
			'blog_id' => $blog_id,
			'orderby' => 'display_name',
			'role' => 'realtor',
			'meta_key' => 'user_meta_user_status',
			'meta_value' => 'active'
		)
	);
	// Array of WP_User objects.
	if( ! $blogusers ) return;

	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a User to Edit</option>';
	foreach ( $blogusers as $user ) {
//		echo '<div><a href="' . get_edit_user_link( $user->ID ) . '">' . esc_html( $user->display_name ) . '</a></div>';
		$out .= '<option value="' . get_edit_user_link( $user->ID ) . '">' . esc_html( $user->display_name ) . '</option>';
	}
    $out .= '</select></form>';
    return $out;
}

//Sign Edit Post Select list
function sign_edit_dropdown( $post_type )
{
    $posts = get_posts(
        array(
            'post_type'  => $post_type,
            'numberposts' => -1
        )
    );
    if( ! $posts ) return;

    $out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
    foreach( $posts as $p )
    {
        $out .= '<option value="index.php/?p=' . $p->ID . '">' . esc_html( $p->post_title ) . '</option>';
    }
    $out .= '</select></form>';
    return $out;
}


//Signs Up Select list
function sign_up_dropdown( $post_type )
{
    $posts = get_posts(
        array(
            'post_type'  => $post_type,
            'numberposts' => -1,
			'meta_key' => 'sign_status',
			'meta_value' => 'Sign Up'
        )
    );
    if( ! $posts ) return;

		$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
		foreach( $posts as $p )
		{
			$out .= '<option value="index.php/?p=' . $p->ID . '">' . esc_html( $p->post_title ) . '</option>';
		}
		$out .= '</select></form>';
		return $out;
}

//Sign Edit Post For Cusrrent User Select list
function sign_edit_current_user_dropdown( $post_type )
{
		global $current_user;
		  get_currentuserinfo();

		$posts = get_posts(
			array(
				'author' => $current_user->ID,
				'post_type'  => $post_type,
				'numberposts' => -1,
				'meta_key' => 'sign_status',
				'meta_value' => 'Sign Up'
			)
		);

    if( ! $posts ) return;

    $out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
    foreach( $posts as $p )
    {
		if(is_page( array ( '10' ) )) {
			$order_accessories = '&order_accessories=yes';
		}
		if(is_page( array ( '8' ) )) {
			$sign_status = '&sign_status=fix';
		}
		if(is_page( array ( '9' ) )) {
			$sign_status = '&sign_status=down';
		}

        $post_id = $p->ID;
		$address = $p->post_title;
		$city = get_post_meta($p->ID, 'city', true);
		$quadrant = get_post_meta($p->ID, 'quadrant', true);
		$install_date = get_post_meta($p->ID, 'install_date', true);
		$query_string = 'p=' . urlencode($post_id) . $order_accessories . $sign_status;
        $out .= '<option value="index.php/?' . htmlentities($query_string) . '">' . esc_html( $p->post_title ) . '</option>';
    }
    $out .= '</select></form>';
    return $out;
}

//Signs on user profile page
function sign_user_profile_dropdown( $post_type )
{
		global $current_user;
		  get_currentuserinfo();
		$user_id = $_GET['user_id'];
		$posts = get_posts(
			array(
				'author' => $_GET['user_id'],
				'post_type'  => $post_type,
				'numberposts' => -1,
				'meta_key' => 'sign_status',
				'meta_value' => array('Sign Up', 'Fix Sign')
			)
		);

    if( ! $posts ) return;

    $out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
    foreach( $posts as $p )
    {
		$post_id = $p->ID;
		if ($_GET['order_accessories']) {
			$order_accessories = '&order_accessories=yes';
		}
		if ($_GET['sign_status'] == 'fix') {
			$sign_status = '&sign_status=fix';
		}
		if ($_GET['sign_status'] == 'down') {
			$sign_status = '&sign_status=down';
		}
		$query_string = 'p=' . urlencode($post_id) . $order_accessories . $sign_status;
        $out .= '<option value="' . get_site_url() . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $p->post_title ) . '</option>';
    }
    $out .= '</select></form>';
    return $out;
}
//Signs on user profile page (fix)
function sign_user_profile_dropdown_fix( $post_type )
{
    global $current_user;
      get_currentuserinfo();
    $user_id = $_GET['user_id'];
    $posts = get_posts(
      array(
        'author' => $_GET['user_id'],
        'post_type'  => $post_type,
        'numberposts' => -1,
        'meta_key' => 'sign_status',
        'meta_value' => array('Sign Up')
      )
    );

    if( ! $posts ) return;

    $out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
    foreach( $posts as $p )
    {
    $post_id = $p->ID;
    if ($_GET['order_accessories']) {
      $order_accessories = '&order_accessories=yes';
    }
    if ($_GET['sign_status'] == 'fix') {
      $sign_status = '&sign_status=fix';
    }
    if ($_GET['sign_status'] == 'down') {
      $sign_status = '&sign_status=down';
    }
    $query_string = 'p=' . urlencode($post_id) . $order_accessories . $sign_status;
        $out .= '<option value="' . get_site_url() . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $p->post_title ) . '</option>';
    }
    $out .= '</select></form>';
    return $out;
}

//Signs Up - Brokerage Current Signs Up for Selected Realtor
function sign_up_selected_realtor_dropdown( $post_type )
{
		global $current_user;
		get_currentuserinfo();
		$user_id = $_GET['user_id'];
		$posts = get_posts(
			array(
				'author' => $_GET['user_id'],
				'post_type'  => $post_type,
				'numberposts' => -1,
				'meta_key' => 'sign_status',
				'meta_value' => 'Sign Up'
			)  
		);

    if( ! $posts ) return;

    $out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
    foreach( $posts as $p )
    {
		$post_id = $p->ID;
		$address = $p->post_title;
		$city = get_post_meta($p->ID, 'city', true);
		$quadrant = get_post_meta($p->ID, 'quadrant', true);
		$install_date = get_post_meta($p->ID, 'install_date', true);
		$query_string = 'p=' . urlencode($post_id);
        $out .= '<option value="' . get_site_url() . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $p->post_title ) . '</option>';
    }
    $out .= '</select></form>';
    return $out;
}

//Signs Down - Brokerage Current Signs Down for Selected Realtor
function sign_down_selected_realtor_dropdown( $post_type )
{
		global $current_user;
		get_currentuserinfo();
		$user_id = $_GET['user_id'];
		$posts = get_posts(
			array(
				'author' => $_GET['user_id'],
				'post_type'  => $post_type,
				'numberposts' => -1,
				'meta_key' => 'sign_status',
				'meta_value' => 'Sign Down'
			)
		);

    if( ! $posts ) return;

    $out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select an Address</option>';
    foreach( $posts as $p )
    {
		$post_id = $p->ID;
		$address = $p->post_title;
		$city = get_post_meta($p->ID, 'city', true);
		$quadrant = get_post_meta($p->ID, 'quadrant', true);
		$install_date = get_post_meta($p->ID, 'install_date', true);
		$query_string = 'p=' . urlencode($post_id);
        $out .= '<option value="' . get_site_url() . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $p->post_title ) . '</option>';
    }
    $out .= '</select></form>';
    return $out;
}

//* Add custom body class to the head
//add_filter( 'body_class', 'nmg_body_class' );
//function nmg_body_class( $classes ) {
//	if(is_page( 37 )) {
//		$classes[] = 'edit-page';
//		return $classes;
//	}
//}

//Add a Realtor from a Contact Form
function create_user_from_registration($cfdata) {
    if (!isset($cfdata->posted_data) && class_exists('WPCF7_Submission')) {
        // Contact Form 7 version 3.9 removed $cfdata->posted_data and now
        // we have to retrieve it from an API
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $formdata = $submission->get_posted_data();
        }
	} else {
        // We can't retrieve the form data
        return $cfdata;
    }
    // Check this is the user registration form
    if ( $cfdata->title() == 'Create a Realtor') {
        $password = wp_generate_password( 12, false );
        $email = $formdata['email'];
		$name = $formdata['name'];
        // Construct a username from the user's name
        $username = strtolower(str_replace(' ', '', $formdata['email']));
        $name_parts = explode(' ',$name);
        if ( !username_exists( $username )  && !email_exists( $email ) ) {
            $user_id = wp_create_user( $username, $password, $email );
            wp_update_user(
                array(
                    'ID'            =>   $user_id,
                    'nickname'      =>   $username,
					          'display_name'  =>   $name,
                    'first_name'    =>   reset($name_parts),
                    'last_name'     =>   end($name_parts)
                )
            );
            $user = new WP_User( $user_id );
            // Set the user's role
            $user->set_role( 'realtor' );
            // Email login details to user
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $message = "Welcome! Your login details are as follows:" . "\r\n";
            $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n";
            $message .= sprintf(__('Password: %s'), $password) . "\r\n";
            $message .= wp_login_url() . "\r\n";
            wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);
        }
    }
    return $cfdata;
}
add_action('wpcf7_before_send_mail', 'create_user_from_registration', 1);



// Redirect to the post/page itself after publishing or updating a post in
// WordPress. This code is from the WordPress forum [1], modified so it doesn't
// redirect when saving a draft.

// [1]: http://wordpress.org/support/topic/redirect-to-new-post-after-publish


add_filter('redirect_post_location', function($location)
{
    global $post;

 	if ( 'signs' == get_post_type($_POST['id']) ) {

		if (
			(isset($_POST['publish']) || isset($_POST['save'])) &&
			preg_match("/post=([0-9]*)/", $location, $match) &&
			$post &&
			$post->ID == $match[1] &&
			(isset($_POST['update']) || $post->post_status == 'publish') && // Publishing draft or updating published post
			$pl = get_permalink($post->ID)
		) {
			// Always redirect to the post
			$location = $pl;
		}
	}

    return $location;

});

//Disable the Admin Bar for every but ADMIN
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

//Register New Menus
register_nav_menus( array(
	'brokerage_menu' => 'Brokerage Menu',
	'realtor_menu' => 'Realtor Menu',
) );

//Check the current users role
function user_role_check( $role, $user_id = null ) {
  $user = wp_get_current_user();
    if ( empty( $user ) )
    return false;

  return in_array( $role, (array) $user->roles );
}




function set_realtor( $form_id, $post_id, $form_settings ) {
    $value = $_GET['user_id'];
	   update_post_meta( $post_id, 'realtor', $value );
    ?>
    <div class="wpuf-fields">
        <input type="text" name="realtor_id" value="<?php echo esc_attr( $value ); ?>">
    </div>
    <?php
}
add_action( 'authorhook', 'set_realtor', 10, 3 );
/* Write meta key */
function update_set_realtor( $post_id ) {
    if ( isset( $_POST['realtor_id'] ) ) {
        update_post_meta( $post_id, 'realtor', $_POST['realtor_id'] );
    }
      write_log('UP SET REALTOR');
      write_log($_POST);
}
add_action( 'wpuf_add_post_after_insert', 'update_set_realtor' );
add_action( 'wpuf_edit_post_after_update', 'update_set_realtor' );
/**
 * Modify the post array
 */
function realtor( $post_id ) {
	$realtor =  get_post_meta( $post_id, 'realtor', $value );
	return $realtor;
}


//Change the Sign Author to the realtor
function wpufe_change_post_status( $my_post ) {

    $realtor_id = get_post_meta( $my_post, 'realtor', $value );
	//want to change the post author?
    $my_post['post_author'] = $realtor_id;
    //must return
   return $my_post;
}
add_filter( 'wpuf_add_post_args', 'wpufe_change_post_status' );






//Gravity Form User Dropdown
//Add Brokerage List to the Request an Account Page
add_filter('gform_pre_render_1', 'populate_posts');
function populate_posts($form){

  foreach($form['fields'] as &$field){

        if($field['type'] != 'select' || strpos($field['cssClass'], 'brokerage-dd') === false)
            continue;

  global $wpdb;

  // Query all blogs from multi-site install
  $blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");
  $choices[] = array('text' => 'Select a Brokerage', 'value' => '');
  // Start unordered list
  echo '<ul>';

  // For each blog search for blog name in respective options table
  foreach( $blogs as $blog ) {

    // Query for name from options table
    $blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");

    foreach( $blogname as $name ) {
      $choices[] = array('text' => $name->option_value, 'value' => $name->option_value);
    }

      $field['choices'] = $choices;

    }
  }

  return $form;
}

// Gravity Forms User Populate, update the '1' to the ID of your form
add_filter( 'gform_pre_render_1', 'populate_user_email_list' );
function populate_user_email_list( $form ){

    // Add filter to fields, populate the list
    foreach( $form['fields'] as &$field ) {

	// If the field is not a dropdown and not the specific class, move onto the next one
	// This acts as a quick means to filter arguments until we find the one we want
        if( $field['type'] !== 'select' || strpos($field['cssClass'], 'realtor-dd') === false )
            continue;

	// The first, "select" option
        $choices = array( array( 'text' => 'Select a Realtor', 'value' => ' ' ) );

	// Collect user information
	// prepare arguments
	$args  = array(
		// order results by user_nicename
		'orderby' => 'user_nicename',
		// Return the fields we desire
		'fields'  => array( 'id', 'display_name', 'user_email' ),
		'role' => 'realtor',
		'meta_key' => 'user_meta_user_status',
		'meta_value' => 'active'
	);
	// Create the WP_User_Query object
	//$wp_user_query = new WP_User_Query( $args );
	// Get the results
	//$users = $wp_user_query->get_results();
	$users = get_riteway_active_realtors();

	// Check for results
        if ( !empty( $users ) ) {
		foreach ( $users as $user ){
			// Make sure the user has an email address, safeguard against users can be imported without email addresses
			// Also, make sure the user is at least able to edit posts (i.e., not a subscriber). Look at: http://codex.wordpress.org/Roles_and_Capabilities for more ideas
			if( !empty( $user->user_email ) && user_can( $user->id, 'edit_posts' ) ) {
				// add users to select options
				$choices[] = array(
					'text'  => $user->display_name,
					'value' => $user->id
				);
			}
		}
	}
        $field['choices'] = $choices;

    }
    return $form;
}

$last_realtor_id = null;

add_action('gform_pre_submission_1', 'pre_submission_handler');
function pre_submission_handler($form){
	global $last_realtor_id;
  global $last_realtor_email;


  //This is the area to fix the logic of the broken gravity forms.
	$last_realtor_id = $_POST['input_3'];

  $user = get_user_by( 'id', $last_realtor_id);
  
  $_POST['input_37'] = $user->user_email;

	if (!empty($user)) {
	    $_POST['input_3'] = $user->first_name . ' ' . $user->last_name;

      //All imported users only have login, nicename, or firstname due to data constraints.
      if(empty($user->last_name)){
        $_POST['input_3'] = $user->user_login;
      }

	}

}

add_filter("gform_pre_submission_filter_1", "add_bcc");
function add_bcc($form){

  $brokerageType = get_option ('brokeragetype');

  $current_user = wp_get_current_user();

  switch($brokerageType) {
    case A:

      $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 'aamrole_5410d7b003aa5',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '',
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
       );

      $bcc = '';

      break;

    case B:

      //Send to Realtor ONLY no matter who orders the sign. 
      $bcc = $_POST['input_37'];

      break;

    case C:

      $bcc = $_POST['input_37'];

      break;

    case D:

         $args = array(
          'blog_id'      => $GLOBALS['blog_id'],
          'role'         => 'aamrole_5410d7b003aa5',
          'meta_key'     => '',
          'meta_value'   => '',
          'meta_compare' => '',
          'meta_query'   => array(),
          'include'      => array(),
          'exclude'      => array(),
          'orderby'      => 'login',
          'order'        => 'ASC',
          'offset'       => '',
          'search'       => '',
          'number'       => '',
          'count_total'  => false,
          'fields'       => 'all',
          'who'          => ''
         );

        $bcc = $current_user->user_email;

      break;      
  }


  if($brokerageType == 'A' || $brokerageType == 'D'){
      $brokerageUsers = get_users( $args );
      $users = json_decode(json_encode($brokerageUsers), true);

      foreach($users as $user){
        $bcc .= ', '.$user['data']['user_email'];

      }
  }    

  
  $bcc = trim($bcc, ",");
  //appending "to" emails with the current brokerages admin users
  
  //FOR TESTING
  $to = 'laurellindsay@gmail.com, ';
  $form["notifications"]["54234c8213ea9"]["to"] = $to;
  $form["notifications"]["54f238ef62c87"]["to"] = $to;
  $form["notifications"]["55186e4b76c0a"]["to"] = $to;
  $form["notifications"]["5532b5b0cadc4"]["to"] = $to;
  //FOR TESTING 

  $form["notifications"]["54234c8213ea9"]["to"] .= $bcc;
  $form["notifications"]["54f238ef62c87"]["to"] .= $bcc;
  $form["notifications"]["55186e4b76c0a"]["to"] .= $bcc;
  $form["notifications"]["5532b5b0cadc4"]["to"] .= $bcc; 


  //returning modified form object
  return $form;

}


function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}

add_action("gform_post_submission_1", "set_post_content", 10, 2);
function set_post_content($entry, $form){

	global $last_realtor_id;
	global $current_user;

	if (empty($last_realtor_id)) {
    $realtor = get_userdatabylogin($entry['3']);
    $last_realtor_id = $realtor->ID;

	}

	if (!empty($last_realtor_id)) {

		$post = array(
			'ID' => $entry['post_id'],
			'post_author' => $last_realtor_id
		);

		wp_update_post($post);

	}

    set_post_type( $entry['post_id'], 'signs' );

}

add_filter("gform_post_data_1", "change_post_status", 10, 3);
function change_post_status($post_data, $form, $entry){
	foreach( $form['fields'] as &$field ) {

		// Similar to above, find the right field
		if( $field['type'] != 'select' || strpos($field['cssClass'], 'realtor-dd') === false )
			continue;

		// Pull out the user id selected, by the field id and the $entry element
		$field_id = (string) $field['id'];

    //This is incorrect. Ther user_id is blank on the edit submit.
		$user_id = $entry[ $field_id ];

	}

  $user = get_userdatabylogin($user_id);
  
  //if($user) echo $user->ID; // Outputs 1
	//$post_data['post_author'] = $user_id;
  $post_data['post_author'] = $user->ID;
  

  return $post_data;
}

//do_action('gform_update_post/setup_form', array('post_id' => $post->ID, 'form_id' => $form_id));

// populate acf field (sample_field) with post types (accessories)
function acf_load_sample_field( $field ) {
	global $switched;
	switch_to_blog(1);
	$field['choices'] = get_post_type_values( 'accessories' );
	return $field;
}
add_filter( 'acf/load_field/name=accessories_list', 'acf_load_sample_field' );

function get_post_type_values( $post_type ) {
	$values = array();
	$defaults = array(
	'post_type' => $post_type,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'title',
	'order' => 'ASC'
	);
	$query = new WP_Query( $defaults );
	if ( $query->found_posts > 0 ) {
		foreach ( $query->posts as $post ) {
			$values[get_the_title( $post->ID )] = get_the_title( $post->ID );
		}
		restore_current_blog(); //switched back to main site
	}
	return $values;
}

/**
* dirty hack to write checkbox field values as serialised arrays
* to please Advanced Custom Fields, which is _doing_it_wrong()
* @param array $post_data not really the $_POST data, more like a summary of it
* @param array $form the GF form "object"
* @param array $lead the GF lead / entry "object"
* @return array
*/
add_filter("gform_post_data_1", 'wpse_78826_gformPostData', 10, 3);
function wpse_78826_gformPostData($post_data , $form, $lead) {
    $post_data['post_custom_fields']['accessories_list'] = serialize(explode(',', $post_data['post_custom_fields']['accessories_list']));

    return $post_data;
}

//Add User Role as a Body Class so that we may hide elements using CSS based on current user role
/**
 * Returns the translated role of the current user. If that user has
 * no role for the current blog, it returns false.
 *
 * @return string The name of the current role
 **/
add_filter('body_class','add_role_to_body');
function add_role_to_body($classes) {
	if( user_role_check( 'aamrole_5410d7b003aa5') ) {
		$current_user = new WP_User(get_current_user_id());
		$user_role = array_shift($current_user->roles);
		$classes[] = 'role-brokerage';
	}
	if( user_role_check( 'realtor') ) {
		$current_user = new WP_User(get_current_user_id());
		$user_role = array_shift($current_user->roles);
		$classes[] = 'role-realtor';
	}
		return $classes;
}

// Add this within the init() hook
add_filter('gform_update_post/public_edit', '__return_true');
add_filter('gform_update_post/public_edit', 'custom_gform_update_post_public_edit');
function custom_gform_update_post_public_edit()
{
    return 'loggedin';
}

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}



/* DON'T DELETE THIS CLOSING TAG */ ?>
