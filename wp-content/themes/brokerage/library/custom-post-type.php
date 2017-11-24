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
function custom_posts() { 
	// creating (registering) the custom type 
	register_post_type( 'signs', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Signs', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Sign', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Signs', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add Sign', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Signs', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Sign', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Sign', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Sign', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is a sign oder', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'signs', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'signs', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor')
		) /* end of options */
	); /* end of register post type */
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_posts');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
/**
*	register_taxonomy( 'sign_cat', 
*		array('signs'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
/*		array('hierarchical' => true,     /* if this is true, it acts like categories */
/*			'labels' => array(
/*				'name' => __( 'Sign Categories', 'bonestheme' ), /* name of the custom taxonomy */
/*				'singular_name' => __( 'Sign Category', 'bonestheme' ), /* single taxonomy name */
/*				'search_items' =>  __( 'Search Sign Categories', 'bonestheme' ), /* search title for taxomony */
/*				'all_items' => __( 'All Sign Categories', 'bonestheme' ), /* all title for taxonomies */
/*				'parent_item' => __( 'Parent Sign Category', 'bonestheme' ), /* parent title for taxonomy */
/*				'parent_item_colon' => __( 'Parent Sign Category:', 'bonestheme' ), /* parent taxonomy title */
/*				'edit_item' => __( 'Edit Sign Category', 'bonestheme' ), /* edit custom taxonomy title */
/*				'update_item' => __( 'Update Sign Category', 'bonestheme' ), /* update title for taxonomy */
/*				'add_new_item' => __( 'Add New Sign Category', 'bonestheme' ), /* add new title for taxonomy */
/*				'new_item_name' => __( 'New Sign Category Name', 'bonestheme' ) /* name title for taxonomy */
/*			),
/*			'show_admin_column' => true, 
/*			'show_ui' => true,
/*			'query_var' => true,
/*			'rewrite' => array( 'slug' => 'sign-category' ),
/*		)
/*	);
*/	
//	register_taxonomy( 'quadrant_cat', 
//		array('signs'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
//		array('hierarchical' => true,     /* if this is true, it acts like categories */
//			'labels' => array(
//				'name' => __( 'Quadrants', 'bonestheme' ), /* name of the custom taxonomy */
//				'singular_name' => __( 'Quadrant', 'bonestheme' ), /* single taxonomy name */
//				'search_items' =>  __( 'Search Quadrants', 'bonestheme' ), /* search title for taxomony */
//				'all_items' => __( 'All Quadrants', 'bonestheme' ), /* all title for taxonomies */
//				'parent_item' => __( 'Parent Quadrant', 'bonestheme' ), /* parent title for taxonomy */
//				'parent_item_colon' => __( 'Parent Quadrant:', 'bonestheme' ), /* parent taxonomy title */
//				'edit_item' => __( 'Edit Quadrant', 'bonestheme' ), /* edit custom taxonomy title */
//				'update_item' => __( 'Update Quadrant', 'bonestheme' ), /* update title for taxonomy */
//				'add_new_item' => __( 'Add New Quadrant', 'bonestheme' ), /* add new title for taxonomy */
//				'new_item_name' => __( 'New Quadrant Name', 'bonestheme' ) /* name title for taxonomy */
//			),
//			'show_admin_column' => true, 
//			'show_ui' => true,
//			'query_var' => true,
//			'rewrite' => array( 'slug' => 'quadrant' ),
//		)
//	);
//	register_taxonomy( 'city_cat', 
//		array('signs'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
//		array('hierarchical' => true,     /* if this is true, it acts like categories */
//			'labels' => array(
//				'name' => __( 'Cities', 'bonestheme' ), /* name of the custom taxonomy */
//				'singular_name' => __( 'City', 'bonestheme' ), /* single taxonomy name */
//				'search_items' =>  __( 'Search Cities', 'bonestheme' ), /* search title for taxomony */
//				'all_items' => __( 'All Cities', 'bonestheme' ), /* all title for taxonomies */
//				'parent_item' => __( 'Parent City', 'bonestheme' ), /* parent title for taxonomy */
//				'parent_item_colon' => __( 'Parent City', 'bonestheme' ), /* parent taxonomy title */
//				'edit_item' => __( 'Edit City', 'bonestheme' ), /* edit custom taxonomy title */
//				'update_item' => __( 'Update City', 'bonestheme' ), /* update title for taxonomy */
//				'add_new_item' => __( 'Add New City', 'bonestheme' ), /* add new title for taxonomy */
//				'new_item_name' => __( 'New City Name', 'bonestheme' ) /* name title for taxonomy */
//			),
//			'show_admin_column' => true, 
//			'show_ui' => true,
//			'query_var' => true,
//			'rewrite' => array( 'slug' => 'city' ),
//		)
//	);

	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'custom_tag', 
		array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,    /* if this is false, it acts like tags */
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
