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

