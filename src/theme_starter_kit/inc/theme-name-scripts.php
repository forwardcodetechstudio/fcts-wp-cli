<?php

/**
 * Enqueues custom styles and scripts for this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Name
 */

function theme_name_scripts() {
    // Enqueue main stylesheet.
    wp_enqueue_style( 'theme-name-style', get_stylesheet_uri(), array(), _S_VERSION );

    // Enqueue custom stylesheet.
    wp_enqueue_style( 'theme-name-custom', THEME_NAME_CSS_URI . 'theme-name.css', [], _S_VERSION, 'all' );

    // Enqueue jQuery.
    wp_enqueue_script( 'jquery' );

    // Enqueue custom JavaScript.
    wp_enqueue_script( 'theme-name-custom', THEME_NAME_JS_URI . 'theme-name.js', [], _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );