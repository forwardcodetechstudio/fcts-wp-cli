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
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
// add_filter( 'body_class', 'theme_name_body_classes' );




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
	$mimes['ico'] = 'image/x-icon';
  $mimes['json'] = 'application/json';
  $mimes['webmanifest'] = 'application/manifest+json';
  $mimes['xml'] = 'text/xml';
  $mimes['woff'] = 'font/woff';
  $mimes['woff2'] = 'font/woff2';

	return $mimes;
}

// Add the enable_svg_upload function to the upload_mimes filter.
add_filter( 'upload_mimes', 'enable_svg_upload' );

// Fix strict filetype checking for .ico files
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  if ($ext === 'ico') {
      $data['ext']  = 'ico';
      $data['type'] = 'image/x-icon';
  }
  elseif ($ext === 'svg') {
      $data['ext']  = 'svg';
      $data['type'] = 'images/svg+xml';
  }
  elseif ($ext === 'svgz') {
      $data['ext']  = 'svgz';
      $data['type'] = 'images/svg+xml';
  }
  elseif ($ext === 'json') {
      $data['ext']  = 'json';
      $data['type'] = 'application/json';
  }
  elseif ($ext === 'webmanifest') {
      $data['ext']  = 'json';
      $data['type'] = 'application/manifest+json';
  }
  elseif ($ext === 'xml') {
      $data['ext']  = 'json';
      $data['type'] = 'text/xml';
  }
  elseif ($ext === 'woff') {
      $data['ext']  = 'woff';
      $data['type'] = 'font/woff';
  }
  elseif ($ext === 'woff2') {
      $data['ext']  = 'woff2';
      $data['type'] = 'font/woff2';
  }

  return $data;
}, 10, 4);
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
	$THEME_ICON_URI = THEME_ICON_URI; // URI of the theme's icon.
	$home_url = esc_url( home_url( '/' ) ); // The home URL of the site.
	$favicon= get_field('favicon','option');
  $html=[];
  if(isset($favicon['icons']) && $favicon['icons']){
    $icons= $favicon['icons'];
    foreach($icons as $icon){
      if(empty($item)){
        continue;
      }
      $image_url = get_stylesheet_directory_uri() . '/favicon/' . $icon['filename'];
      if($icon['title']=='favicon'){
        $html[]=<<<html
        <link rel="shortcut icon" href="{$image_url}">
        html;
      }
      elseif(str_contains($icon['title'],'favicon')){
        $size=explode('-',$icon['title'])[1];
        $html[]=<<<html
        <link rel="icon" type="image/png" sizes="$size" href="{$image_url}">
        html;
      }
      elseif(str_contains($icon['title'],'android-chrome')){
        $size=explode('-',$icon['title'])[2];
        $html[]=<<<html
        <link rel="icon" type="image/png" sizes="$size" href="{$image_url}">
        html;
      }
      elseif(str_contains($icon['title'],'apple-touch-icon')){
        $html[]=<<<html
        <link rel="icon" type="image/png" sizes="180x180" href="{$image_url}">
        html;
      }
      elseif(str_contains($icon['title'],'safari-pinned-tab')){
        $html[]=<<<html
        <link rel="mask-icon" href="{$image_url}" color="{$favicon['theme_color']}" >
        html;
      }
      // debug($icon);
    }
  }
  if(isset($favicon['manifest']['filename'])){
    $image_url = get_stylesheet_directory_uri() . '/favicon/' . $favicon['manifest']['filename'];
    $html[]=<<<html
    <link rel="manifest" href="{$image_url}">
    html;
  }
  if(isset($favicon['browser_config']['filename'])){
    $image_url = get_stylesheet_directory_uri() . '/favicon/' . $favicon['browser_config']['filename'];
    $html[]=<<<html
    <link rel="msapplication-config" href="{$image_url}">
    html;
  }
  if(isset($favicon['theme_color'])){
    $html[]=<<<html
    <meta name="msapplication-TileColor" content="{$favicon['theme_color']}">
    <meta name="theme-color" content="{$favicon['theme_color']}">
    html;
  }
  echo implode("\n",$html);
  ?>
	<script>
		var THEME_ICON_URI = '<?php echo $THEME_ICON_URI; ?>'; // A JavaScript variable that holds the URI of the theme's icon.
		var HOME_URL = '<?php echo $home_url; ?>'; // A JavaScript variable that holds the home URL of the site.
	</script>
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

add_action( 'wp_ajax_filter_posts', 'theme_name_filter_posts_data' );
add_action( 'wp_ajax_nopriv_filter_posts', 'theme_name_filter_posts_data' );

function loadColors($field){
  $colors= get_field('colors_colors','option');
  $field['choices']=[];
  $field['choices']['inherit']='inherit';
  if($colors){
    foreach($colors as $color){
      $field['choices']["{$color['name']}"]= $color['view_name'];
    }
  }
  $field['choices']['custom']='custom';
  return $field;
}
function loadBgColors($field){
  $colors= get_field('colors_background_colors','option');
  // debug($colors);
  $field['choices']=[];
  $field['choices']['inherit']='inherit';
  if($colors){
    foreach($colors as $color){
      $field['choices']["{$color['name']}"]= $color['view_name'];
    }
  }
  $field['choices']['custom']='custom';
  return $field;
}

add_filter('acf/load_field/key=field_67e68c0cf9e66','loadBgColors');// main menu
add_filter('acf/load_field/key=field_67810dd58b411','loadBgColors');// mob menu
add_filter('acf/load_field/key=field_67810e1c8b412','loadColors');
add_filter('acf/load_field/key=field_67810e598b413','loadColors');
add_filter('acf/load_field/key=field_67810e8d8b414','loadBgColors');// menu trigger
add_filter('acf/load_field/key=field_67810eb18b415','loadBgColors');// menu trigger active
add_filter('acf/load_field/key=field_673df137a369e','loadBgColors');# header bg color
add_filter('acf/load_field/key=field_673df35e8ae29','loadBgColors');#footer bg color
add_filter('acf/load_field/key=field_67daee5f3b17d','loadColors');
add_filter('acf/load_field/key=field_673b61a210b46','loadBgColors'); # login primary 
add_filter('acf/load_field/key=field_673b61df10b47','loadBgColors');# login secondary
add_filter('acf/load_field/key=field_67489c512a65f','loadColors');
add_filter('acf/load_field/key=field_67ebdbc70cc94','loadBgColors');// submenu
add_filter('acf/load_field/key=field_67ebdbd10cc96','loadColors');
add_filter('acf/load_field/key=field_67ebdbd80cc98','loadColors');
add_filter('acf/load_field/key=field_67ebdbdf0cc9a','loadColors');

add_filter('acf/load_field/key=field_673ddedd8ff07','loadColors');# link color
add_filter('acf/load_field/key=field_673ddf698ff08','loadColors');# link color Hover

add_filter('acf/load_field/key=field_67c6dcb0a84b1','loadColors');# button color
add_filter('acf/load_field/key=field_67c6dcdea84b4','loadColors');# button color Hover

add_filter('acf/load_field/key=field_67c6dca5a84b0','loadBgColors');# button background color
add_filter('acf/load_field/key=field_67c6dcd4a84b3','loadBgColors');# button background color Hover
add_filter('acf/load_field/key=field_67f29140237a5','loadBgColors');# body background color
add_filter('acf/load_field/key=field_67f7a7d05be56','loadBgColors');# body border color


add_filter('acf/load_field/key=field_620b79681e6d1',function($field){
  $bg_colors= get_field('colors_background_colors','option');
  $field['choices']=[];
  $field['choices']['_bg-inherit']='inherit';
  if($bg_colors){
    foreach($bg_colors as $bg_color){
      $field['choices']["_bg-{$bg_color['name']}"]= $bg_color['view_name'];
    }
  }
  $field['choices']['_bg-custom']='custom';
  return $field;
});# flexible content background color

add_filter('acf/load_field/key=field_68022d01f4046',function($field){
  $colors= get_field('colors_colors','option');
  // debug($btn_colors);
  $field['choices']=[];
  $field['choices']['_text-inherit']='inherit';
  if($colors){
    foreach($colors as $color){
      $field['choices']["_text-{$color['name']}"]= $color['view_name'];
    }
  }
  $field['choices']['_text-custom']='custom';
  return $field;
});# flexible content text color

add_filter('acf/load_field/key=field_680231fdea626',function($field){
  $btn_colors= get_field('colors_button_colors','option');
  // debug($btn_colors);
  $field['choices']=[];
  if($btn_colors){
    foreach($btn_colors as $btn_color){
      $field['choices']["_btn-{$btn_color['name']}"]= $btn_color['view_name'];
    }
  }
  $field['choices']['_btn-custom']='custom';
  return $field;
});# flexible content button color

add_action('template_redirect', function () {
  if (!is_admin() && !wp_doing_ajax() && !is_user_logged_in() && get_field('block_user_access_block_access', 'option')) {
      
    if (get_field('block_user_access_redirect_page_link', 'option')) {
        wp_redirect(get_field('block_user_access_redirect_page_link', 'option'));
        exit;
      }
  }
});