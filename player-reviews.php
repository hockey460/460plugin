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


add_filter( 'template_include', 'include_template_function', 1 );

/* Here the code searches for a template single-player_reviews.php in the current theme directory. If nothing is identified then it resorts to the plugin directory for the template, which serves this part of the plugin. The template_include hook was used to change the default post type to the custom post type template. */


function include_template_function( $template_path ) {
    if ( get_post_type() == 'player_reviews' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-player_reviews.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-player_reviews.php';
            }
        }
    }
    return $template_path;
}

/* This incorporates and activtates the shortcode. This piece of code is taken from the simgle-player_reviews.php file as that file serves as the template for the plugin. In order to create a shortcode which follows the same format, the peice of code is incorperaed within this shortcode function. The following fucntion explains that, when a shortcode is found, it is replaced by a piece of code (in our case it is our template file). This function will retrieve these posts acting as a callback function. */

function player_reviews_function() {


    $mypost = array( 'post_type' => 'player_reviews','orderby' => 'rand', 'posts_per_page' => '3',);
    $loop = new WP_Query( $mypost );
     while ( $loop->have_posts() ) : $loop->the_post(); ?> 
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
 
                <!-- Display featured image -->
                <div class="fimage">
                    <?php the_post_thumbnail( 'thumbnail' );   // Thumbnail (default 150px x 150px max)
                    ?>
                </div>
 
                <!-- Display and Player Name -->
               <div class="pname">
                <strong>Player: </strong><?php the_title(); ?><br />
                <strong>Position: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'player_position', true ) ); ?>
                <br />
                
 
                <!-- Display red stars based on player rating -->
                <strong>Rating: </strong>
                <?php
                $nb_stars = intval( get_post_meta( get_the_ID(), 'player_rating', true ) );
                for ( $star_counter = 1; $star_counter <= 5; $star_counter++ ) {
                    if ( $star_counter <= $nb_stars ) {
                        echo '<img src="' . plugins_url( 'Player-Reviews/images/redstar.png' ) . '" />';
                    } else {
                        echo '<img src="' . plugins_url( 'Player-Reviews/images/greystaricon.png' ). '" />';
                    }
                }
                ?>
                </div>
            </header>
 
            <!-- Display player review contents -->
           <div class="rcontents">
            <div class="entry-content"><?php the_content(); ?></div>
            </div>
        </article>
 
    <?php endwhile; 

}

// Ιf a shortcode of [player-reviews] is found in a post’s content, then the player_reviews_function() is called automatically.


function register_shortcodes(){
   add_shortcode('player-reviews', 'player_reviews_function');
}

add_action( 'init', 'register_shortcodes');
?>



