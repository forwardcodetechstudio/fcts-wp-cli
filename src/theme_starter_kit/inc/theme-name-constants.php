<?php

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', wp_get_theme()->get('Version'));
}

/**
 * Theme Directories for CSS, JS, IMAGES
 */
if (!defined('THEME_NAME_DIR_PATH')) {
    define('THEME_NAME_DIR_PATH', untrailingslashit(get_template_directory()));
}

if (!defined('THEME_NAME_DIR_URI')) {
    define('THEME_NAME_DIR_URI', untrailingslashit(get_template_directory_uri()));
}

$theme_name_assets_uri = untrailingslashit(THEME_NAME_DIR_URI) . '/assets';

if (!defined('THEME_NAME_CSS_URI')) {
    define('THEME_NAME_CSS_URI', $theme_name_assets_uri . '/css/');
}

if (!defined('THEME_NAME_JS_URI')) {
    define('THEME_NAME_JS_URI', $theme_name_assets_uri . '/js/');
}

if (!defined('THEME_NAME_ICON_URI')) {
    define('THEME_NAME_ICON_URI', $theme_name_assets_uri . '/img/');
}
