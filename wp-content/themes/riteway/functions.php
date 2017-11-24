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
require_once( 'library/admin.php' );

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

  //adding scripts file in the footer
	wp_register_script( 'skrollr', get_stylesheet_directory_uri() . '/library/js/libs/skrollr.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'skrollr' );

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
add_image_size( 'xsmal', 154 );
add_image_size( 'small', 190, 230, true );
add_image_size( 'md', 510, 315, true );
add_image_size( 'lg', 650, 440, true );
add_image_size( 'testimonial-image', 145, 175, true );
add_image_size( 'realtor-logo', 105, 50);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.
To call a different size, simply change the text
inside the thumbnail function.
For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>
You can change the names and dimensions to whatever
you like. Enjoy!
*/

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
	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:
	Just change the name to whatever your new
	sidebar's id is, for example:
	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php
	*/
} // don't remove this bracket!

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

  //Nivoslider
	wp_register_style( 'nivo-slider-style', get_stylesheet_directory_uri() . '/library/js/libs/nivo-slider/nivo-slider.css', array(), '' );
	wp_register_script( 'nivoslider-js', get_stylesheet_directory_uri() . '/library/js/libs/nivo-slider/jquery.nivo.slider.pack.js', array( 'jquery' ), '', true );
	wp_register_script( 'excellentexport-js', get_stylesheet_directory_uri() . '/library/js/excellentexport.js', array( 'jquery' ), '', true );
	wp_register_script( 'tablesorter-js', get_stylesheet_directory_uri() . '/library/js/jquery.tablesorter.min.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'nivo-slider-style' );
	wp_enqueue_script( 'nivoslider-js' );
	wp_enqueue_script( 'excellentexport-js' );
	wp_enqueue_script( 'tablesorter-js' );

//custom admin styling
add_action('admin_head', 'my_custom_styles');

function my_custom_styles() {
  echo '<style>
	.field_key-field_53b7573188461 ul li {
		display: block;
		float: left;
		margin: 0 10px 10px;
	}
	.field_key-field_53b7573188461 ul li:before {
		display: block;
	}
	.field_key-field_53b7573188461 ul li:nth-child(1):before {
		content: url(' . get_template_directory_uri() . '/library/images/layout-1.png);
	}
	.field_key-field_53b7573188461 ul li:nth-child(2):before {
		content: url(' . get_template_directory_uri() . '/library/images/layout-2.png);
	}
	.field_key-field_53b7573188461 ul li:nth-child(3):before {
		content: url(' . get_template_directory_uri() . '/library/images/layout-3.png);
	}
	.field_key-field_53b7573188461 ul li:nth-child(4):before {
		content: url(' . get_template_directory_uri() . '/library/images/layout-4.png);
	}
  </style>';
}

//Discard menu class cluster
add_filter('nav_menu_css_class', 'discard_menu_classes', 10, 2);

function discard_menu_classes($classes, $item) {
    $classes = array_filter(
        $classes,
        create_function( '$class',
                 'return in_array( $class,
                      array( "current-menu-item", "current-menu-parent" ) );' )
        );
    return array_merge(
        $classes,
        (array)get_post_meta( $item->ID, '_menu_item_classes', true )
        );
    }

function register_my_menus() {
  register_nav_menus(
    array(
      'seconday-nav' => __( 'Secondary Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

add_action('wpmu_new_blog', 'wpb_create_my_pages', 10, 2);

function wpb_create_my_pages($blog_id, $user_id){
  switch_to_blog($blog_id);

// create new page
  $page_id = wp_insert_post(array(
    'post_title'     => 'About',
    'post_name'      => 'about',
    'post_content'   => 'This is an about page. Feel free to edit or delete this page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 1,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'DASHBOARD',
    'post_name'      => 'dashboard',
    'post_content'   => 'This is Dashboard page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 2,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'CURRENT SIGNS UP',
    'post_name'      => 'signs-up',
    'post_content'   => 'This is Current Signs Up page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 3,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'SIGNS TAKEN DOWN',
    'post_name'      => 'signs-down',
    'post_content'   => 'This is Signs Taken Down page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 4,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'ORDER SIGN UP',
    'post_name'      => 'order-sign-up',
    'post_content'   => 'This is Order Sign Up page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 5,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'ORDER SIGN FIX',
    'post_name'      => 'order-sign-fix',
    'post_content'   => 'This is Order Sign Fix page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 6,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'ORDER SIGN DOWN',
    'post_name'      => 'order-sign-down',
    'post_content'   => 'This is Order Sign Down page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 7,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'ORDER ACCESSORIES',
    'post_name'      => 'order-accessories',
    'post_content'   => 'This is Order Accessories page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 8,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'ORDER CUSTOM SIGNS',
    'post_name'      => 'order-custom-signs',
    'post_content'   => 'This is Order Custom Signs page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 9,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'ADD NEW USER',
    'post_name'      => 'user-new',
    'post_content'   => 'This is the Add New User page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 10,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
  $page_id = wp_insert_post(array(
    'post_title'     => 'EDIT USERS',
    'post_name'      => 'user-edit',
    'post_content'   => 'This is Edit Users page.',
    'post_status'    => 'publish',
    'post_author'    => 1, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 11,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));
// Find and delete the WP default 'Sample Page'
$defaultPage = get_page_by_title( 'Sample Page' );
wp_delete_post( $defaultPage->ID );

  restore_current_blog();
}

//Change Default Role for new Blogs
  function woo_admin_to_editor($blog_id, $user_id) {
    switch_to_blog($blog_id);
    $user = new WP_User($user_id);
    if ($user->exists()) {
      $user->set_role('aamrole_5410d7b003aa5');
    }
    restore_current_blog();
  }

  add_action( 'wpmu_new_blog', 'woo_admin_to_editor', 10, 2 );

//Default MultiSite Tagline
function set_default_tagline($blog_id){
	switch_to_blog($blog_id);
	update_option( 'blogdescription', 'Your source for all your daily sign needs' );
	restore_current_blog();
}
add_action('wpmu_new_blog', 'set_default_tagline' );


function get_all_sites() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	echo '<ul>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			echo '<li>';
			echo '<a href="http://';
			echo $blog->domain;
			echo $blog -> path;
			echo '">';
			echo $name->option_value;
			echo '</a><br/>';
			echo '</li>';

		}

	}

	// End unordered list
	echo '</ul>';
}

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

//Register New Menus
register_nav_menus( array(
	'accessories' => 'Accessories Menu',
	'reports' => 'Reports Menu',
	'users' => 'Users Menu',
	'signs' => 'Signs Menu',
	'website' => 'Website Menu',
) );

add_filter('wp_dropdown_users', 'author_override');

/*Changing the ADMIN TOOLBAR*/
function my_edit_toolbar($wp_toolbar) {
	$wp_toolbar->add_node(array(
	'id' => 'reports-adminbar',
	'title' => 'Reports',
	'href' => '/reports/',
	'meta' => array('target' => 'projects')
	));
}

add_action('admin_bar_menu', 'my_edit_toolbar', 999);


//Add Sign - Select a brokerage
function add_sign_select_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode(295);
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}

//Order Signs Down - Select a brokerage
function order_sign_down_select_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode(9);
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}

//Edit Signs - Select a brokerage
function edit_signs_select_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode(5);
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}

//Edit Signs - Select a brokerage
function view_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode();
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}

//Add User - Select a brokerage
function add_user_select_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode(496);
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}

//Edit User - Select a brokerage
function edit_user_select_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode(13);
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}
//Edit User - Select a brokerage
function view_user_select_brokerage() {

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

	// Start unordered list
	$out = '<form name="jump1"><select name="jump2" id="sign_edit_select" OnChange="location.href=jump1.jump2.options[selectedIndex].value">><option>Select a Brokerage</option>';

	// For each blog search for blog name in respective options table
	foreach( $blogs as $blog ) {

		// Query for name from options table
		$blogname = $wpdb->get_results("SELECT option_value FROM wp_".$blog->blog_id ."_options WHERE option_name='blogname' ");
		foreach( $blogname as $name ) {

			// Create bullet with name linked to blog home pag
			$query_string = 'p=' . urlencode(498);
	        $out .= '<option value="' . esc_html($blog -> path) . '/index.php/?' . htmlentities($query_string) . '">' . esc_html( $name->option_value ) . '</option>';

		}
	}
	$out .= '</select></form>';
    return $out;
}

//Disable admin bar for all users except Admin
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}

//Update Sign to Charge or not Charge
function sign_update_renewal() {
    
    $pk = $_POST['pk'];
    $name = $_POST['name'];
    $value = $_POST['value'];
    
    switch_to_blog($name);
    update_post_meta($pk, 'charge_renewal', $value); 

    return 'Ok';

} 

add_action( 'update_charge', 'sign_update_renewal' );

//Add Brokerage List to the Request an Account Page
add_filter('gform_pre_render_2', 'populate_posts');
function populate_posts($form){
	foreach($form['fields'] as &$field){

        if($field['type'] != 'select' || strpos($field['cssClass'], 'brokerage-dd') === false)
            continue;

	global $wpdb;

	// Query all blogs from multi-site install
	$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM wp_blogs where blog_id > 1 AND deleted = 0 ORDER BY path");

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

//Remove Paging from Archives
function no_nopaging($query) {
	if (is_post_type_archive()) {
	$query->set('nopaging', 1);
	}
}
add_action('parse_query', 'no_nopaging');
/* DON'T DELETE THIS CLOSING TAG */ ?>