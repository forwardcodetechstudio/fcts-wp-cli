<?php

/**
 * Template part for displaying Footer Menu 2.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

if (has_nav_menu('footer-menu-2')) {
    wp_nav_menu([
        'theme_location' => 'footer-menu-2',
        'container' => false,
        'menu_class' => false,
    ]);
}