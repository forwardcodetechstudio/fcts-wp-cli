<?php

/**
 * Functions which enhance the Login Page by hooking into WordPress
 *
 * @package Theme_Name
 */

/**
 * Adds custom styles and logo to the login screen.
 */
function theme_name_login_logo() {
    // Set CSS variables for secondary and primary colors
    $secondary_color = get_field('login_screen_secondary_color', 'option');
    $primary_color = get_field('login_screen_primary_color', 'option');
    $logo = get_field('login_screen_logo', 'option')['url'] ?? null;

    $html = null;
    if ($secondary_color && $primary_color && $logo) {
        $html .= '<style type="text/css">';
        $html .= ':root {';
        $html .= "--c-secondary: {$secondary_color};";
        $html .= "--c-primary: {$primary_color};";
        $html .= "--c-login-screen-logo: url({$logo});";
        $html .= '}';
        $html .= '</style>';
        echo $html;
    }
}
add_action( 'login_enqueue_scripts', 'theme_name_login_logo' );

/**
 * Set the login logo URL to the homepage URL.
 *
 * @return string Homepage URL.
 */
function theme_name_login_logo_url() {
    return home_url();
}

// Add the filter to modify the login header URL
add_filter( 'login_headerurl', 'theme_name_login_logo_url' );

/**
 * Gets the title and description of the site for use in the login header text.
 *
 * @return string The concatenated site title and description.
 */
function theme_name_login_logo_url_title_and_description() {
    // Get the name and description fields from the site.
    $fields = [ 'name', 'description' ];
    $info = array_map( 'get_bloginfo', $fields );

    // Concatenate the title and description.
    return implode( ' ', $info );
}

// Add the site title and description to the login header text.
add_filter( 'login_headertext', 'theme_name_login_logo_url_title_and_description' );

/**
 * Enqueues a custom stylesheet for the login screen.
 */
function theme_name_login_stylesheet() {
    // Enqueue the custom login stylesheet
    wp_enqueue_style( 'theme-name-custom-login', get_template_directory_uri() . '/style-login.css' );

    // If you have any custom JavaScript for the login screen, you can enqueue it here
    // wp_enqueue_script( 'theme-name-custom-login', get_template_directory_uri() . '/style-login.js' );
}

// Add the login_enqueue_scripts action to enqueue the custom login stylesheet and JavaScript
add_action( 'login_enqueue_scripts', 'theme_name_login_stylesheet' );