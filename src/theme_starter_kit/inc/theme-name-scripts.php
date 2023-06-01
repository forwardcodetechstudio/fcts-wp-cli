<?php

/**
 * custom Scripts functions for this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Name
 */

function theme_name_scripts() {
	wp_enqueue_style( 'theme-name-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_enqueue_style('theme-name-custom', THEME_NAME_CSS_URI . "theme-name.css", [], _S_VERSION, 'all');

    wp_enqueue_script('jquery');
    wp_enqueue_script('theme-name-custom', THEME_NAME_JS_URI . 'theme-name.js', [], _S_VERSION, true);
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );