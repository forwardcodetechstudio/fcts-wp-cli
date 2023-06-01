<?php

/**
 * Functions which enhance the Login Page by hooking into WordPress
 *
 * @package Theme_Name
 */

function theme_name_login_logo() {?>
    <style type="text/css">
        :root {
            --c-secondary: <?php echo get_field('login_screen_secondary_color', 'option'); ?>;
            --c-primary: <?php echo get_field('login_screen_primary_color', 'option'); ?>;
            --c-login-screen-logo: url(<?php echo get_field('login_screen_logo', 'option')['url'] ?? null; ?>);
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'theme_name_login_logo' );

function theme_name_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'theme_name_login_logo_url' );

function theme_name_login_logo_url_title_and_description() {
    $fields = [ 'name', 'description' ];
    $data = [];
    foreach ( $fields as $field ) {
        $data[] = get_bloginfo( $field );
    }
    return implode( " ", $data );
}
add_filter( 'login_headertext', 'theme_name_login_logo_url_title_and_description' );

function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/style-login.css' );
    // wp_enqueue_script( 'custom-login', PURVITAL_JS_URI . 'style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );
