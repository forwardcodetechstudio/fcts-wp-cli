<?php

/**
 * Template part for displaying navbar.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

if ( has_nav_menu( 'header-menu' ) ) {
    wp_nav_menu( [
        'theme_location' => 'header-menu',
        'container'      => false,
        'menu_class'     => false,
    ] );
}
