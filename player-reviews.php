<?php
/*
Plugin Name: Player Reviews
Plugin URI: http://phoenix.sheridanc.on.ca/~ccit2659/
Description: Declares a plugin that will create a custom post type displaying player reviews.
Version: 1.0
Author: Anthony Theroux, Michael Grande, Steven Yoon
Author URI: http://phoenix.sheridanc.on.ca/~ccit2659/
License: GPLv2
*/

/*
function player_reviews_stylesheet() {
	wp_enqueue_style( 'player-reviews' , plugins_url( '/style.css' , __FILE__ ) );
	}
	
add_action( 'wp_enqueue_scripts' , 'player_reviews_stylesheet' );
*/


// This executes the custom function during the initialization page every time a new page is generated
add_action( 'init', 'create_player_review' );

/*This array specifies the name of the plugin when it displays within WordPress. This creates a new post type and its corresponding label. As soon as it is called it prepares the WordPress environment for a new custom post type including the different sections in the admin. */

function create_player_review() {
    register_post_type( 'player_reviews',
        array(
            	'labels'             => array(
                'name'               => 'Player Reviews',
                'singular_name'      => 'Player Review',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Player Review',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Player Review',
                'new_item'           => 'New Player Review',
                'view'               => 'View',
                'view_item'          => 'View Player Review',
                'search_items'       => 'Search Player Reviews',
                'not_found'          => 'No Players Reviews found',
                'not_found_in_trash' => 'No Player Reviews found in Trash',
                'parent'             => 'Parent Player Review'
            ),
 
 //We register the new post type called Player Reviews, which has the following arguments that is contained within this array.
 
            'public'        => true,
            'menu_position' => 15,
            'supports'      => array( 'title', 'editor', 'comments', 'thumbnail'),
            'menu_icon'     => 'dashicons-chart-bar',
            'has_archive'   => true
        )
    );
}

add_action( 'admin_init', 'my_admin' );


/*
 * Enqueue styles is meant to link stylesheets to the php files.
*/


// Attempt #2 
function player_reviews_stylesheet() {
	wp_enqueue_style( 'player-reviews' , plugins_url( '/style.css' , __FILE__ ) );
	}
	
add_action( 'wp_enqueue_scripts' , 'player_reviews_stylesheet' );


/*
function player_reviews() {
	wp_enqueue_style( 'hockey-style', get_stylesheet_uri() );
	
	//adding stylesheet for the body on player reviews plugin //
	
	wp_enqueue_style( '', plugins_url() . '/plugins/Player-Reviews/style.css');
	
	}
add_action( 'wp_enqueue_style', 'player_reviews' );

*/


/* Attemp 2 Options page */


add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() { 
	add_submenu_page( '/edit.php?post_type=player_reviews', 'Options Page', 'Options Page', 'manage_options', 'options-page', 'my_custom_submenu_page_callback' ); } 

function my_custom_submenu_page_callback() { echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>'; echo '<h2>Options Page</h2>'; echo 
'</div>'; }

//Atempt #3
/*
add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function
);

function cd_add_submenu(){
add_submenu_page( 'options-general.php','Submenu', 'Submenu', 'manage_options', 'awesome-sub-menu', 'cd_display_submenu_options');
}
add_action( 'admin_menu', 'cd_add_submenu' );


add_action('admin_menu', 'pr_custom_menu_page');

function pr_custom_menu_page() { 
add_menu_page('PR Custom Submenu Page', 'PR Custom Submenu Page', 'manage_options', 'pr-custom-submenu-page', 'pr_custom_submenu_page_init');
}

function pr_custom_submenu_page_init(){
		echo "<h1> Player Reviews </h1>";
		}
*/

