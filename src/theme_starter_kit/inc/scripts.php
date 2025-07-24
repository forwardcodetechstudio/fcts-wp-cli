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
    wp_enqueue_style( 'theme-name-bootstrap', THEME_CSS_URI . 'libs/bootstrap.min.css', [], _S_VERSION, 'all' );
    wp_enqueue_style( 'theme-name-bootstrap', THEME_CSS_URI . 'libs/slick.css', [], _S_VERSION, 'all' );
    wp_enqueue_style( 'theme-name-custom', THEME_CSS_URI . 'theme-name.css', [], _S_VERSION, 'all' );
    wp_enqueue_style( 'theme-name-main', THEME_CSS_URI . 'style.css', [], _S_VERSION, 'all' );

    // Enqueue jQuery.
    // wp_enqueue_script( 'jquery' );

    // Enqueue custom JavaScript.
    wp_enqueue_script( 'theme-name-jquery', THEME_JS_URI . 'libs/jquery.min.js', [], _S_VERSION, true );
    wp_enqueue_script( 'theme-name-bootstrap', THEME_JS_URI . 'libs/bootstrap.min.js', [], _S_VERSION, true );
    wp_enqueue_script( 'theme-name-slick', THEME_JS_URI . 'libs/slick.min.js', [], _S_VERSION, true );
    wp_enqueue_script( 'theme-name-main', THEME_JS_URI . 'script.js', [], _S_VERSION, true );
    wp_enqueue_script( 'theme-name-custom', THEME_JS_URI . 'theme-name.js', [], _S_VERSION, true );
    wp_localize_script('theme-name-custom','php',[
      'ajax'=> home_url('custom-ajax')
    ]);
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );