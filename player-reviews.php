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



/* This function registers a meta box and associates it with the custom post type. This following block of code adds a metabox section/additional info to our player reviews plugin page through the dashboard on WordPress. The two tabs that can be edited are the players position, and the corresponding rating identified through the drop down menu. */

function my_admin() {
    add_meta_box( 'player_review_meta_box',
        'Player Review Details',
        'display_player_review_meta_box',
        'player_reviews', 'normal', 'high'
    );
}



/* This Fucntion retrieves the post ID and uses that to query the database to get the associated Player's name and Rating which in turn returns the fields on the screen.  The meta_post_meta returns an empty string which results in displaying empty fields in the meta box.*/


function display_player_review_meta_box( $player_review ) {
    // Retrieve current name of the Position and Player Rating based on review ID
    $player_position = esc_html( get_post_meta( $player_review->ID, 'player_position', true ) );
    $player_rating = intval( get_post_meta( $player_review->ID, 'player_rating', true ) );
    ?>
    <table>
        <tr>
            <td>Player Position</td>
            <td><input type="text" name="player_review_position_name" value="<?php echo $player_position; ?>" /></td>
        </tr>
        <tr>
            <td>Player Rating</td>
            <td>
                <select name="player_review_rating">
                <?php
                // Generate all items of drop-down list
                for ( $rating = 5; $rating >= 1; $rating -- ) {
                ?>
                    <option value="<?php echo $rating; ?>" <?php echo selected( $rating, $player_rating ); ?>>
                    <?php echo $rating; ?> stars <?php } ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}


add_action( 'save_post', 'add_player_review_fields', 10, 2 );


/* This function is executed when posts are saved or deleted from the admin panel from the WordPress Dashboard. After checking for the type of received post data, if it is a Custom Post Type then it checks again to see if the meta box elements have been assigned values and then finally stores the values in those fields */



function add_player_review_fields( $player_review_id, $player_review ) {
    // Check post type for player reviews
    if ( $player_review->post_type == 'player_reviews' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['player_review_position_name'] ) && $_POST['player_review_position_name'] != '' ) {
            update_post_meta( $player_review_id, 'player_position', $_POST['player_review_position_name'] );
        }
        if ( isset( $_POST['player_review_rating'] ) && $_POST['player_review_rating'] != '' ) {
            update_post_meta( $player_review_id, 'player_rating', $_POST['player_review_rating'] );
        }
    }
}





