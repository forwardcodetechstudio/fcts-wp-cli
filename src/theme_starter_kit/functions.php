<?php
/**
 * Theme Name functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Theme_Name
 */

/**
 * This Theme Constants.
 */
require get_template_directory() . '/inc/theme-name-constants.php';

/**
 * This Theme Setup.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-setup.php';

/**
 * Enqueue scripts and styles.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-scripts.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-template-functions.php';

/**
 * Implement the Custom ACF functions.
 */
if ( class_exists( 'ACF' ) ) {
    require THEME_NAME_DIR_PATH . '/inc/theme-name-acf-functions.php';
}

/**
 * Implement the Custom Image functions.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-custom-image.php';

/**
 * Implement the Custom Login Screen functions.
 */
require THEME_NAME_DIR_PATH . '/inc/theme-name-custom-login.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

