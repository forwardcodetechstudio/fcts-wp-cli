<?php

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    $my_theme = wp_get_theme();
    $liw_shop_version = esc_html($my_theme->get('Version'));
    define('_S_VERSION', $liw_shop_version);
}

/**
 * Theme Directorys for CSS, JS, IMAGES
 */

if (!defined('THEME_NAME_DIR_PATH')) {
    // Fetching the Directory Path for this theme.
    define('THEME_NAME_DIR_PATH', untrailingslashit(get_template_directory()));
}

if (!defined('THEME_NAME_DIR_URI')) {
    // Fetching the directory Path URL for this theme.
    define('THEME_NAME_DIR_URI', untrailingslashit(get_template_directory_uri()));
}

if (!defined('THEME_NAME_CSS_URI')) {
    // Fetching The CSS Files URL for this theme.
    define('THEME_NAME_CSS_URI', untrailingslashit(get_template_directory_uri()) . '/assets/css/');
}

if (!defined('THEME_NAME_JS_URI')) {
    // Fetching The JS Files URL for this theme.
    define('THEME_NAME_JS_URI', untrailingslashit(get_template_directory_uri()) . '/assets/js/');
}

if (!defined('THEME_NAME_ICON_URI')) {
    // Fetching The ICON Files URL for this them.
    define('THEME_NAME_ICON_URI', untrailingslashit(get_template_directory_uri()) . '/assets/img/');
}
