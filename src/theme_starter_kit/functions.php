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
require get_template_directory() . '/inc/constants.php';

require get_template_directory() . '/inc/traits/trait-singleton.php';

$classes= get_template_directory() . '/inc/classes';

foreach (glob("$classes/*.php") as $filename) {
  require $filename;
}

/**
 * Set up the theme by adding support for various features and setting default options.
 */
require THEME_DIR_PATH . '/inc/setup.php';

/**
 * Register and enqueue stylesheets and scripts for the theme.
 */
require THEME_DIR_PATH . '/inc/scripts.php';

/**
 * Functions that enhance the theme
 */
require THEME_DIR_PATH . '/inc/utilities-functions.php';

/**
 * Functions that enhance the theme by hooking into WordPress
 */
require THEME_DIR_PATH . '/inc/template-functions.php';

/**
 * If the Advanced Custom Fields plugin is active, add custom functions for ACF fields.
 */
if ( class_exists( 'ACF' ) ) {
    require THEME_DIR_PATH . '/inc/acf-functions.php';
}

/**
 * Add custom functions to manage custom images used in the theme.
 */
require THEME_DIR_PATH . '/inc/custom-image.php';

/**
 * Add custom functions to modify the WordPress login screen.
 */
require THEME_DIR_PATH . '/inc/custom-login.php';

/**
 * Functions which enhance the theme by customizing tiny mce.
 */
require get_template_directory() . '/inc/tiny-mce-functions.php';

/**
 * If Jetpack is active, load the Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * File Inserts Hooks
 */
require get_template_directory() . '/inc/action-hooks.php';
require get_template_directory() . '/inc/filter-hooks.php';


/* ============================================================================== 
	WP User Profile Demo
 ============================================================================== */
// zuerst erzeugen wir demo metadaten
require THEME_DIR_PATH .'/inc/wp-user-profil/user-profile-daten.php';

// zuletzt generieren wir die tabs
require THEME_DIR_PATH .'/inc/wp-user-profil/user-profile-tabs.php';

/**
 * Add custom functions to optimize the WordPress.
 */
add_action('acf/init',function(){
  require THEME_DIR_PATH . '/inc/optimizer.php';
});