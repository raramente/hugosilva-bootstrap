<?php
/**
* Plugin Name: Bootstrap
* Plugin URI: https://www.hugosilva.me/
* Description: Performs a series of funcationalities common to every theme.
* Version: 0.1
* Author: Hugo Silva
* Author URI: https://www.hugosilva.me/
**/

include 'includes/clean-up.php';
include 'includes/google-analytics.php';
include 'includes/plugins.php';

/**
* Allow svg uploads
*/
add_filter( 'upload_mimes', function( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

/**
* Remove jQuery migrate
*/

//Remove jQuery Migrate
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
        if ( $script->deps ) { 
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
} );

// Remove Contact form 7 css
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'contact-form-7' );
    global $post;
    if( is_front_page() || ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'contact-form-7') ) ) {
        wp_enqueue_script('contact-form-7');
    }else{
        wp_dequeue_script( 'contact-form-7' );
    }
});

// Adds loading="lazy" to all <img /> tags.
add_filter('the_content', function( $content ) {
    $content = str_replace('<img', '<img loading="lazy"', $content);
    return $content;
});

// Move jquery to footer
add_action( 'wp_enqueue_scripts', function() {
    wp_scripts()->add_data( 'jquery', 'group', 1 );
    wp_scripts()->add_data( 'jquery-core', 'group', 1 );
} );
