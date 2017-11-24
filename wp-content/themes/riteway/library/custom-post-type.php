<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function custom_post() { 
	// creating (registering) the custom type 
//	register_post_type( 'custom_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
//		array( 'labels' => array(
//			'name' => __( 'Custom Types', 'bonestheme' ), /* This is the Title of the Group */
//			'singular_name' => __( 'Custom Post', 'bonestheme' ), /* This is the individual type */
//			'all_items' => __( 'All Custom Posts', 'bonestheme' ), /* the all items menu item */
//			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
//			'add_new_item' => __( 'Add New Custom Type', 'bonestheme' ), /* Add New Display Title */
//			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
//			'edit_item' => __( 'Edit Post Types', 'bonestheme' ), /* Edit Display Title */
//			'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
//			'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
//			'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Custom Type Title */ 
//			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
//			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
//			'parent_item_colon' => ''
//			), /* end of arrays */
//			'description' => __( 'This is the example custom post type', 'bonestheme' ), /* Custom Type Description */
//			'public' => true,
//			'publicly_queryable' => true,
//			'exclude_from_search' => false,
//			'show_ui' => true,
//			'query_var' => true,
//			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
//			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
//			'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ), /* you can specify its url slug */
//			'has_archive' => 'custom_type', /* you can rename the slug here */
//			'capability_type' => 'post',
//			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
//			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
//		) /* end of options */
//	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
//	register_taxonomy_for_object_type( 'category', 'custom_type' );
	/* this adds your post tags to your custom post type */
//	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
	
}


// creating (registering) the custom type 
	register_post_type( 'testimonial', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Testimonials', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Testimonial', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Testimonials', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Testimonials', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Testimonials', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Testimonials', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Testimonials', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Testimonials', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Testimonials from happy clients.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'testimonials', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'testimonials', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'revisions')
		) /* end of options */
	); /* end of register post type */






// creating (registering) the custom type 
	register_post_type( 'sign', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Signs', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Sign', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Signs', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Sign Type', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Sign', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Sign', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Sign', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Signs', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Signs, are the content for the Our Signs Page. These are Sign Types', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'signs', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'signs', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'revisions')
		) /* end of options */
	); /* end of register post type */
	
// creating (registering) the custom type 
	register_post_type( 'accessories', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Accessories', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Accessory', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Accessories', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Accessory', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Accessory', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Accessory', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Accessory', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Accessories', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Accessories show on Brokerage Sites as a choice when adding a sign up', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'accessories', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'accessories', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title')
		) /* end of options */
	); /* end of register post type */
	
	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'custom_cat', 
		array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Custom Categories', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Custom Category', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Custom Categories', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Custom Categories', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Custom Category', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Custom Category:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Custom Category', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Custom Category', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Custom Category', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Custom Category Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'custom-slug' ),
		)
	);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'custom_tag', 
		array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Custom Tags', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Custom Tag', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Custom Tags', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Custom Tags', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Custom Tag', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Custom Tag:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Custom Tag', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Custom Tag', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Custom Tag', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Custom Tag Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
