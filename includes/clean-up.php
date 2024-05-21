<?php

/**
 * Clean up code on the website.
 */

// Removes the emojies from WP.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Removes the generator meta tag from the header.
remove_action('wp_head', 'wp_generator');

//Remove Gutenberg Block Library CSS from loading on the frontend
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    // wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
    wp_dequeue_style( 'global-styles' );
}, 100 );

// Disable JSON Headers.
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'template_redirect', 'rest_output_link_header', 11);

// Remove page/post's short links
// Like: <link rel='shortlink' href='http://localhost/wp/?p=5' />
remove_action( 'wp_head', 'wp_shortlink_wp_head');

// Remove the EditURI/RSD
remove_action ('wp_head', 'rsd_link');

// Remove feed links
remove_action( 'wp_head', 'feed_links', 2 );
remove_action('wp_head', 'feed_links_extra', 3 );

// Remove inline css for WP core blocks.
add_action('wp_footer', function () {
    wp_dequeue_style('core-block-supports');
});
