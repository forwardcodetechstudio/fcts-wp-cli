<?php

/**
 * Advanced Custom Fields Pro functions for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme_Name
 */

// Adding options page to backend.
if ( function_exists( 'acf_add_options_page' ) ) {

	// Theme Options Inside WordPress Admin Dashboard.
	acf_add_options_page( array(
		'page_title' => 'Theme Options',
		'menu_title' => 'Theme Options',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'edit_posts',
		'position'   => 2,
		'redirect'   => true,
	) );

	// Header Sub Menu Inside Theme Options.
	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Header Settings',
		'menu_title'  => 'Header',
		'parent_slug' => 'theme-general-settings',
	) );

	// Login Sub Menu Inside Theme Options.
	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Login Settings',
		'menu_title'  => 'Login',
		'parent_slug' => 'theme-general-settings',
	) );

	// 404-Page Sub Menu Inside Theme Options.
	acf_add_options_sub_page( array(
		'page_title'  => 'Theme 404-Page Settings',
		'menu_title'  => '404-Page',
		'parent_slug' => 'theme-general-settings',
	) );

	// Footer Sub Menu Inside Theme Options.
	acf_add_options_sub_page( array(
		'page_title'  => 'Theme Footer Settings',
		'menu_title'  => 'Footer',
		'parent_slug' => 'theme-general-settings',
	) );
}

// function for saves field group and field settings as .json inside theme directory.
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_save_point( $path ) {

	// update path
	$path = THEME_NAME_DIR_PATH . '/acf-json';

	// return
	return $path;
}

/**
 * Allow ShortCode In TextArea
 */
add_filter( 'acf/format_value/type=textarea', 'do_shortcode' );

/**
 * Filter Which add module title and image on flexible content.
 */
add_filter( 'acf/fields/flexible_content/layout_title/name=layouts', 'flexible_content_module_title_and_image', 10, 4 );
function flexible_content_module_title_and_image( $title, $field, $layout, $i ) {

	if ( get_sub_field( 'module_name' ) && get_sub_field( 'module_preview_image' ) ) {
		// Display thumbnail image and title.
		$image = get_sub_field( 'module_preview_image' );
		$title = '';
		$text = get_sub_field( 'module_name' );
		$html = '';
		$html .= '<div class="thumbnail" style="border: #ccd0d4 solid 1px;padding: 2px;width: auto;height: auto;translate: 0 -50%;">';
		$html .= '<img src="' . esc_url( $image['sizes']['thumbnail'] ) . '" height="36px">';
		$html .= '</div>';
		$html .= '<b>' . $text . '</b>';
		$title = $html;
		return $title;
	} elseif ( get_sub_field( 'module_name' ) ) {
		// load text sub field
		$title = '';
		$text = get_sub_field( 'module_name' );
		$title .= '<b>' . esc_html( $text ) . '</b>';
		return $title;
	} elseif ( get_sub_field( 'module_preview_image' ) ) {
		$image = get_sub_field( 'module_preview_image' );
		$html = '';
		$html .= '<div class="thumbnail" style="border: #ccd0d4 solid 1px;padding: 2px;width: auto;height: auto;translate: 0 -50%;">';
		$html .= '<img src="' . esc_url( $image['sizes']['thumbnail'] ) . '" height="36px">';
		$html .= '</div>';
		$html .= '<b>' . $title . '</b>';
		$title = $html;
	} else {
		return $title;
	}
	return $title;
}

/**
 * function for Flexible Content Preview Pop Up
 */
add_action( 'admin_enqueue_scripts', 'acf_flexible_content_thumbnail' );
function acf_flexible_content_thumbnail() {

	// REGISTER ADMIN.CSS
	wp_enqueue_style( 'css-theme-admin', get_template_directory_uri() . '/assets/css/admin.css', false, 1.0 );

	// REGISTER ADMIN.JS
	wp_register_script( 'js-theme-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), 1.0, true );
	wp_localize_script(
		'js-theme-admin',
		'theme_var',
		array(
			'upload' => get_template_directory_uri() . '/img/acf-thumbnail/',
		)
	);
	wp_enqueue_script( 'js-theme-admin' );
}

/**
 *  This script will only allow the scrollwheel to alter the field value when
 * * The number field has focus
 * * The mouse is actually over the field
 */
add_action( 'admin_footer', 'correct_number_scrollwheel' );
function correct_number_scrollwheel() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// need to loop through all number fields
			// in order to add a flag to enable/disable the mousewheel
			$('input[type="number"]').each(function(index, element) {
				// disable mousewheel by default on all number fields
				$(element).data('disable-mousewheel', true);
				// test if mousewheel is disabled, if it is prevent changing number field
				$(element).on('mousewheel', function(e) {
					if ($(element).data('disable-mousewheel')) {
						e.preventDefault();
					}
				}); // end on mousewheel
				// only enable the mousewheel when the mouse enters the number field
				$(element).on('mouseenter', function(e) {
					$(element).data('disable-mousewheel', false);
				}); // end on mouseenter
				// disable the mousewheel when the mouse leaves the number field
				$(element).on('mouseleave', function(e) {
					$(element).data('disable-mousewheel', true);
				}); // end on mouseleave
			}); // end each number element
		}); // end doc ready
	</script>
<?php
}
