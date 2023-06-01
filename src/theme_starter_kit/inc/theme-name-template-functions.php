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
 * Get custom ID and class for ACF Pro modules settings
 *
 * @return array Associative array with custom ID and class
 */
function get_modules_settings() {
    
    $classes = []; // Initialize an empty array to hold the custom classes
    $customID = get_sub_field('custom_id'); // Get the custom ID field value
    $customClass = get_sub_field( 'custom_class' ); // Get the custom class field value
    $paddingTop = get_sub_field('padding-top'); // Get the padding-top field value
    $paddingBottom = get_sub_field('padding-bottom'); // Get the padding-bottom field value
    $bgColor = get_sub_field('background_color'); // Get the background color field value

    if ($customID) { // Check if the custom ID field has a value
        array_push($classes, $customID); // Add the custom ID value to the classes array
    }

    if ($customClass) { // Check if the custom class field has a value
        array_push($classes, $customClass); // Add the custom class value to the classes array
    }

    if ($paddingTop) { // Check if the padding-top field has a value
        array_push($classes, $paddingTop); // Add the padding-top value to the classes array
    }

    if ($paddingBottom) { // Check if the padding-bottom field has a value
        array_push($classes, $paddingBottom); // Add the padding-bottom value to the classes array
    }

    if ($bgColor) { // Check if the background color field has a value
        array_push($classes, $bgColor); // Add the background color value to the classes array
    }

    return [$customID, implode(' ', $classes)]; // Return the custom ID and classes as an array
}

/**
 * Enable SVG support in WordPress
 *
 * This function adds new allowed MIME types for SVG files to be uploaded to WordPress.
 *
 * @param array $mimes Array of allowed MIME types.
 * @return array Modified array of allowed MIME types.
 */
function enable_svg_upload( $mimes ) {

    // Add new allowed MIME types for SVG files.
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}

// Add the enable_svg_upload function to the upload_mimes filter.
add_filter( 'upload_mimes', 'enable_svg_upload' );

/**
 * Move Yoast SEO metabox to the bottom of the post editor
 *
 * @return string
 */
function yoasttobottom() {
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom' );

/**
 * Add 'active' class to the current menu item.
 *
 * @param array  $classes The CSS classes applied to the menu item's <li> element.
 * @param object $item    The current menu item.
 * @return array $classes The updated CSS classes.
 */
function special_nav_class( $classes, $item ) {
    if ( in_array( 'current-menu-item', $classes ) ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );

/**
 * Add site info and favicon to the head section of the site.
 * 
 * This function adds a script tag with two JavaScript variables that hold the URI of the theme's icon and the home URL.
 * It also adds links to the apple-touch-icon.png, favicon-32x32.png, favicon-16x16.png, and site.webmanifest files.
 */
function theme_name_site_info_and_favicon() {
    $theme_name_icon_uri = THEME_NAME_ICON_URI; // URI of the theme's icon.
    $home_url = esc_url(home_url('/')); // The home URL of the site.
    ?>
    <script>
        var THEME_NAME_ICON_URI = '<?php echo $theme_name_icon_uri; ?>'; // A JavaScript variable that holds the URI of the theme's icon.
        var HOME_URL = '<?php echo $home_url; ?>'; // A JavaScript variable that holds the home URL of the site.
    </script>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo THEME_NAME_DIR_URI ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo THEME_NAME_DIR_URI ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo THEME_NAME_DIR_URI ?>/favicon-16x16.png">
    <link rel="manifest" href="<?php echo THEME_NAME_DIR_URI ?>/site.webmanifest">
    <?php
}
add_action( 'wp_head', 'theme_name_site_info_and_favicon', 999 );

// ******************** Security Tips - Clean up WordPress Header START ********************** //

// Remove unnecessary head tags
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove redundant shortlink
add_filter( 'after_setup_theme', 'remove_redundant_shortlink' );

function remove_redundant_shortlink() {
    // Remove HTML meta tag
    // <link rel='shortlink' href='http://example.com/?p=25' />
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

    // Remove HTTP header
    // Link: <https://example.com/?p=25>; rel=shortlink
    remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
}

// Remove other unnecessary tags
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'wlwmanifest_link' );

// ******************** Clean up WordPress Header END ********************** //

/**
 * Wraps YouTube and Vimeo video embeds in a custom HTML container.
 *
 * @param string $html The original HTML embed code.
 * @param string $url The URL of the video.
 * @param array $attr Attributes of the video embed.
 * @param int $post_ID ID of the post containing the video.
 * @return string The modified HTML embed code.
 */
function theme_name_embed_oembed_wrapper( $html, $url, $attr, $post_ID ) {
    // Check if the video is from YouTube
    if ( strpos( $url, 'youtube.com' ) !== false ) {
        // Customize the HTML wrapper for YouTube videos
        $wrapper_html = '<div class="youtube-embed">%s</div>';
    }
    // Check if the video is from Vimeo
    else if ( strpos( $url, 'vimeo.com' ) !== false ) {
        // Customize the HTML wrapper for Vimeo videos
        $wrapper_html = '<div class="vimeo-embed">%s</div>';
    }
    // Return the original HTML code if the video service is not supported
    else {
        return $html;
    }

    // Wrap the original HTML code in the custom container
    return sprintf( $wrapper_html, $html );
}

add_filter( 'embed_oembed_html', 'theme_name_embed_oembed_wrapper', 10, 4 );

/**
 * Display an image from an ACF field.
 *
 * @param array|null $image_field The ACF image field to display.
 */
function display_image( $image_field = null ) {

    // If the $image_field parameter is not an array, return early
    if ( ! is_array($image_field) ) {
        return;
    }

    // Check if the file is an SVG
    if ( $image_field['subtype'] === 'svg+xml' ) {
        // If the file is an SVG, output its contents
        echo file_get_contents( $image_field['url'] );
    } else {
        // If the file is not an SVG, get its attachment ID
        $attachment_id = $image_field['id'] ?? null;

        // Set the size of the image
        $size = 'full'; // (thumbnail, medium, large, full or custom size)

        // Output the image using its attachment ID and size
        echo wp_get_attachment_image( $attachment_id, $size );
    }
}
