<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function theme_name_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Theme Name, use a find and replace
		* to change 'theme-name' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'theme-name', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
            'header-menu' => esc_html__( 'Header Menu', 'theme-name' ),
			'footer-legal-menu' => esc_html__( 'Legal Menu', 'theme-name' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

}
add_action( 'after_setup_theme', 'theme_name_setup' );

/**
 * Function to create a custom AJAX route using rewrite rules.
 */
function my_custom_ajax_rewrite() {
  add_rewrite_rule(
      '^custom-ajax/?$', // The custom endpoint URL (e.g., yourdomain.com/custom-ajax-endpoint/)
      'index.php?custom_ajax_action=1', // Rewrite to index.php with a custom query var
      'top' // Add the rule at the top for priority
  );
}
add_action( 'init', 'my_custom_ajax_rewrite' );

/**
 * Function to register the custom query variable.
 *
 * @param array $query_vars The array of allowed query variables.
 * @return array Modified array of query variables.
 */
function my_custom_ajax_query_vars( $query_vars ) {
  $query_vars[] = 'custom_ajax_action';
  return $query_vars;
}
add_filter( 'query_vars', 'my_custom_ajax_query_vars' );

/**
 * Function to handle the custom AJAX request.
 *
 * This function checks if the 'custom_ajax_action' query variable is set
 * and then executes the desired AJAX logic.
 *
 * @param WP $wp The WordPress query object.
 */
function my_custom_ajax_handler( $wp ) {
  if ( isset( $wp->query_vars['custom_ajax_action'] ) ) {
      // Perform your AJAX actions here
      $request= (object)$_REQUEST;
      if(!isset($_REQUEST['action'])){
        wp_send_json(['message'=>'Action field is required'],500);
        exit;
      }

      $ajax= Ajax::getInstance();
      if(!method_exists($ajax,$request->action)){
        wp_send_json(['message'=>'Action field is Invalid'],500);
        exit;
      }

      call_user_func([$ajax,$request->action],$request);
  }
}
add_action( 'parse_request', 'my_custom_ajax_handler' );