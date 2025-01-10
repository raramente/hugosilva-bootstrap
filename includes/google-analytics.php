<?php
/**
* Sets up a page on the backoffice to configure google analytics and adds the code to the frontend.
*/


// Adds the google analytics menu to the Settings menu.
add_action( 'admin_menu', function() {
    add_submenu_page(
        'options-general.php', // parent slug
        'Google Analytics', // page <title>Title</title>
        'Google Analytics', // link text
        'manage_options', // user capabilities
        'google_analytics', // page slug
        'google_analytics_callback', // this function prints the page content
    );
} );

function google_analytics_callback(){
    ?>
    <h1><?php echo get_admin_page_title() ?></h1>
    <form method="post" action="options.php">
    <?php
    settings_fields( 'google_analytics_settings' ); // settings group name
    do_settings_sections( 'google_analytics_settings' ); // just a page slug
    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Google analytics code:</th>
            <td><input type="text" name="ga_code" value="<?php echo esc_attr( get_option('ga_code') ); ?>" /></td>
        </tr>
    </table>
    
    <?php
    submit_button(); // "Save Changes" button
    ?>
    </form>
    <?php
}


add_action( 'admin_init',  function() {
    
    // I created variables to make the things clearer
    $page_slug = 'google_analytics';
    $option_group = 'google_analytics_settings';
    
    register_setting( 'google_analytics_settings', 'ga_code' );
    
} );

/**
 * Adds a warning if GTM is not set.
 */
add_action( 'admin_notices', function() {
    if ( get_option('ga_code') == '' ) {
        echo '<div class="notice notice-warning"><p>Google Tag Manager not set.</p></div>';
    }
} );


/**
 * Adds the analytics code to WP.
 */
add_action( 'init', function() {
    if ( get_option('ga_code') != '' && !is_user_logged_in() && WP_ENV == 'production' ) {
        add_action( 'wp_enqueue_scripts', function() {
            wp_register_script( 'google-tag-manager', '', [], '', true );
            wp_enqueue_script( 'google-tag-manager');            
            wp_add_inline_script('google-tag-manager', "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . get_option('ga_code') . "');", 'after');
        } );
    }
} );