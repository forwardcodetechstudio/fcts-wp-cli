<?php

/**
 * custom image sizes functions for this theme
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Name
 */

// Adding custom image sizes to backend of this theme.
add_action( 'after_setup_theme', 'theme_name_custom_image_sizes' );

function theme_name_custom_image_sizes() {

    add_image_size( 'img-text-module-thumb', 748, 614, true ); // (cropped) IMG Text Module Thumbnail Image Size for this theme.
    add_image_size( 'team-module-thumb', 255, 255, true ); // (cropped) Team Module Thumbnail Image Size for this theme.
    add_image_size( 'icon-text-repeater-thumb', 330, 85, false ); // (cropped) Icon Text Repeater Thumbnail Image Size for this theme.

}
