<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Theme_Name
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function theme_name_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( !is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( !is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
// add_filter( 'body_class', 'theme_name_body_classes' );

/**
 * All ACF Pro Modules Settings function
 *
 * @return void
 */
function modules_settings() {

    $customClass = '';
    $customID = get_sub_field( 'custom_id' );
    $customClass .= get_sub_field( 'custom_class' );

    $paddingTop = get_sub_field( 'padding-top' ); // Fetching Paddings From Modules Settings Field Group.
    if ( $paddingTop ) {
        $customClass .= ' ' . $paddingTop;
    }

    $paddingBottom = get_sub_field( 'padding-bottom' ); // Fetching Paddings From Modules Settings Field Group.
    if ( $paddingBottom ) {
        $customClass .= ' ' . $paddingBottom;
    }

    $bgColor = get_sub_field( 'background_color' ); // Fetching Background Color From Modules Settings Field Group
    if ( $bgColor ) {
        $customClass .= ' ' . $bgColor;
    }

    return [$customID, $customClass];
}

/**
 * function Enable SVG Support in WordPress
 *
 * @param [type] $mimes
 * @return void
 */
function enable_svg_upload( $mimes ) {

    // New Allowed mime types.

    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}

add_filter( 'upload_mimes', 'enable_svg_upload' );

/**
 * Move Yoast to the Bottom
 *
 * @return void
 */
function yoasttobottom() {
    return 'low';
}

add_filter( 'wpseo_metabox_prio', 'yoasttobottom' );

add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );

function special_nav_class( $classes, $item ) {
    if ( in_array( 'current-menu-item', $classes ) ) {
        $classes[] = 'active ';
    }
    return $classes;
}

function theme_name_site_info_and_favicon() {
    ?>
    <script type="text/javascript">
        var THEME_NAME_ICON_URI = '<?php echo THEME_NAME_ICON_URI ?>';
        var HOME_URL = '<?php echo esc_url( home_url( '/' ) ); ?>';
    </script>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo THEME_NAME_DIR_URI ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo THEME_NAME_DIR_URI ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo THEME_NAME_DIR_URI ?>/favicon-16x16.png">
    <link rel="manifest" href="<?php echo THEME_NAME_DIR_URI ?>/site.webmanifest">
<?php
}
add_action( 'wp_head', 'theme_name_site_info_and_favicon', 999 );

// ******************** Security Tips - Clean up WordPress Header START ********************** //

remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// REMOVE WP EMOJI
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

add_filter( 'after_setup_theme', 'remove_redundant_shortlink' );

remove_action( 'wp_head', 'wp_generator' );

remove_action( 'wp_head', 'rsd_link' );

remove_action( 'wp_head', 'feed_links_extra', 3 );

remove_action( 'wp_head', 'feed_links', 2 );

remove_action( 'wp_head', 'wlwmanifest_link' );

function remove_redundant_shortlink() {
    // remove HTML meta tag
    // <link rel='shortlink' href='http://example.com/?p=25' />
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

    // remove HTTP header
    // Link: <https://example.com/?p=25>; rel=shortlink
    remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
}
// ******************** Clean up WordPress Header END ********************** //

/**
 * YouTube/Vimeo wrapper function
 *
 * @param [type] $html
 * @param [type] $url
 * @param [type] $attr
 * @param [type] $post_ID
 * @return void
 */
function embed_handler_oembed_youtube( $html, $url, $attr, $post_ID ) {
    if ( strpos( $url, 'youtube.com' ) !== false ) {
        /*  YOU CAN CHANGE RESULT HTML CODE HERE */
        $html = '<div class="youtube-wrap">' . $html . '</div>';
    } else if ( strpos( $url, 'vimeo.com' ) !== false ) {
        $html = '<div class="vimeo-wrap">' . $html . '</div>';
    }
    return $html;
}

add_filter( 'embed_oembed_html', 'embed_handler_oembed_youtube', 10, 4 );
