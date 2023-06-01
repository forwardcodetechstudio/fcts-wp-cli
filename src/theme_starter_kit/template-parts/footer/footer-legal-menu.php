<?php

/**
 * Template part for displaying Footer Legal Menu.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

if ( has_nav_menu( 'footer-legal-menu' ) ) {
    wp_nav_menu( [
        'theme_location' => 'footer-legal-menu',
        'container'      => false,
        'echo'           => true,
        'menu_id'        => '',
        'menu_class'     => false,
        'items_wrap'     => '<ul>%3$s</ul>',
        'depth'          => 1,
    ] );
}
