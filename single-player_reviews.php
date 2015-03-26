<?php
 /*Template Name: Player Reviews
 */


// This following code sets the framework for our plugin content (template)using the loop.


get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    
/* The query_posts function specifies the quantity of posts that are shown when loading the page using the loop done so by retreving the custom post type elements. The div classes that we assigned are used to categorize our body content which can then be properly formatted for styling in our external css stylesheet.*/
   
    <?php
    $mypost = array( 'post_type' => 'player_reviews', 'orderby' => 'rand', 'posts_per_page' => '3',);
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
 
                <!-- This code displays the featured image. Thumbnail image is set to medium resolution -->
                <div class="fimage">
                    <?php the_post_thumbnail( 'thumbnail' );  // Thumbnail (default 150px x 150px max) 
                    ?>
               