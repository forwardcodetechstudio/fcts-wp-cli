<?php

/**
 * Adds custom image sizes to this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Name
 */

// Hook the custom image sizes function to the 'after_setup_theme' action
add_action( 'after_setup_theme', 'theme_name_custom_image_sizes' );

/**
 * Defines custom image sizes for this theme.
 */
function theme_name_custom_image_sizes() {

    // Add a custom image size for the IMG Text Module Thumbnail
    add_image_size( 'img-text-module-thumb', 748, 614, true ); // 748 pixels wide by 614 pixels tall, cropped

    // Add a custom image size for the Team Module Thumbnail
    add_image_size( 'team-module-thumb', 255, 255, true ); // 255 pixels wide by 255 pixels tall, cropped

    // Add a custom image size for the Icon Text Repeater Thumbnail
    add_image_size( 'icon-text-repeater-thumb', 330, 85, false ); // 330 pixels wide by 85 pixels tall, not cropped

}
