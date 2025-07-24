<?php

/**
 * Template part for displaying Footer Menu 1.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

if (has_nav_menu('footer-menu-1')) {
    wp_nav_menu([
        'theme_location' => 'footer-menu-1',
        'container' => false,
        'menu_class' => false,
    ]);
}