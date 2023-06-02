<?php
/**
 * Theme Name functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Theme_Name
 */

/**
 * Define constants used throughout the theme.
 */
require get_template_directory() . '/inc/theme-name-constants.php';

/**
 * Set up the theme by adding support for various features and setting default options.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-setup.php';

/**
 * Register and enqueue stylesheets and scripts for the theme.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-scripts.php';

/**
 * Functions that enhance the theme by hooking into WordPress
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-template-functions.php';

/**
 * If the Advanced Custom Fields plugin is active, add custom functions for ACF fields.
 */
if ( class_exists( 'ACF' ) ) {
    require THEME_NAME_DIR_PATH . '/inc/theme-name-acf-functions.php';
}

/**
 * Add custom functions to manage custom images used in the theme.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-custom-image.php';

/**
 * Add custom functions to modify the WordPress login screen.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-custom-login.php';

/**
 * If Jetpack is active, load the Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

