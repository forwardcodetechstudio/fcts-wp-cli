<?php

/**
 * Functions which enhance the Login Page by hooking into WordPress
 *
 * @package Theme_Name
 */

use function PHPSTORM_META\type;

/**
 * Adds custom styles and logo to the login screen.
 */
function theme_name_login_logo() {
    // Set CSS variables for secondary and primary colors
    $login= get_field('login','option');
    if(isset($login['primary_color'])){
      $primary_color = $login['primary_color']? globalOptions()->bgColorFormat($login['primary_color'],type:'single'):$login['primary_color_custom'];
    }else{
      $primary_color = $login['primary_color_custom']??'#000000';
    }
    if(isset($login['secondary_color'])){
      $secondary_color = $login['secondary_color']? globalOptions()->bgColorFormat($login['secondary_color'],type:'single'):$login['secondary_color_custom'];
    }else{
      $secondary_color =$login['secondary_color_custom']??'#FFFFFF';
    }
    $logo = $login['logo']??[];
    
    if($logo){
      $logo_image=$logo['logo']['url']??null;
      $height= isset($logo['height']) && $logo['height']?$logo['height'].'px':'100px';
      $width= isset($logo['width'])&& $logo['width']?$logo['width'].'px':'200px';
      $margin_top= isset($logo['margin_top'])&& $logo['margin_top']?$logo['margin_top'].'px':'30px';
      $logo_styles=<<<style
      body.login div#login h1 a {
      height: var($height);
      width: var($width);
      background-image: var($logo_image);
      background-size: var($width) var($height);
      background-repeat: no-repeat;
      margin-top: var($margin_top);
      }
      style;
    }else{
      $logo_styles="body.login div#login h1 a {\nmargin-top: 20px;margin-bottom:0px;\n}";
    }

    $html = null;
    $html =<<<style
    <style type='text/css'>
      :root {
        --c-secondary: {$secondary_color};
        --c-primary: {$primary_color};
        }
      $logo_styles
    </style>
    style;
    echo $html;
}
add_action( 'login_enqueue_scripts', 'theme_name_login_logo' );

/**
 * Set the login logo URL to the homepage URL.
 *
 * @return string Homepage URL.
 */
function theme_name_login_logo_url() {
    return home_url();
}

// Add the filter to modify the login header URL
add_filter( 'login_headerurl', 'theme_name_login_logo_url' );

/**
 * Gets the title and description of the site for use in the login header text.
 *
 * @return string The concatenated site title and description.
 */
function theme_name_login_logo_url_title_and_description() {
    // Get the name and description fields from the site.
    $fields = [ 'name', 'description' ];
    $info = array_map( 'get_bloginfo', $fields );

    // Concatenate the title and description.
    return implode( ' ', $info );
}

// Add the site title and description to the login header text.
add_filter( 'login_headertext', 'theme_name_login_logo_url_title_and_description' );

/**
 * Enqueues a custom stylesheet for the login screen.
 */
function theme_name_login_stylesheet() {
    // Enqueue the custom login stylesheet
    wp_enqueue_style( 'theme-name-custom-login', get_template_directory_uri() . '/style-login.css' );

    // If you have any custom JavaScript for the login screen, you can enqueue it here
    // wp_enqueue_script( 'theme-name-custom-login', get_template_directory_uri() . '/style-login.js' );
}

// Add the login_enqueue_scripts action to enqueue the custom login stylesheet and JavaScript
add_action( 'login_enqueue_scripts', 'theme_name_login_stylesheet' );