<?php
add_filter('acf/upload_prefilter/key=field_68061d17d7ea8', 'load_custom_file_path_favicon');// image
add_filter('acf/upload_prefilter/key=field_68061d42d7ea9', 'load_custom_file_path_favicon');// manifest
add_filter('acf/upload_prefilter/key=field_68061d61d7eaa', 'load_custom_file_path_favicon');// browser config
add_filter('acf/upload_prefilter/key=field_680779482f1e5', 'load_custom_file_path_font');// fonts

function load_custom_file_path_favicon($file){
  add_filter('upload_dir', 'my_custom_favicon_upload_dir');
  return $file;
}
function load_custom_file_path_font($file){
  add_filter('upload_dir', 'my_custom_font_upload_dir');
  return $file;
}

function my_custom_favicon_upload_dir($dirs) {
    // Optional: Customize folder name, e.g., "custom-images"
    $theme_path = get_stylesheet_directory() . '/favicon';
    $theme_url  = get_stylesheet_directory_uri() . '/favicon';
    if (!file_exists($theme_path)) {
      wp_mkdir_p($theme_path);
    }
    $dirs['path']   = $theme_path;
    $dirs['url']    = $theme_url;
    $dirs['subdir'] = '';

    // Remove filter after running to avoid affecting other uploads
    remove_filter('upload_dir', 'my_custom_favicon_upload_dir');

    return $dirs;
}
function my_custom_font_upload_dir($dirs) {
    // Optional: Customize folder name, e.g., "custom-images"
    $theme_path = get_stylesheet_directory() . '/assets/fonts';
    $theme_url  = get_stylesheet_directory_uri() . '/assets/fonts';
    if (!file_exists($theme_path)) {
      wp_mkdir_p($theme_path);
    }
    $dirs['path']   = $theme_path;
    $dirs['url']    = $theme_url;
    $dirs['subdir'] = '';

    // Remove filter after running to avoid affecting other uploads
    remove_filter('upload_dir', 'my_custom_font_upload_dir');

    return $dirs;
}

add_filter('acf/load_field/key=field_67489756460e7',function($field){
  $field['choices'] = [
    'inherit' => 'Vorgabe'
  ];
  $fonts= get_field('fonts_items', 'option');
  if($fonts && $fonts[0]){
    $fonts= array_reduce($fonts, function($result, $font){
      $font_name= explode('-', $font['name'])[0];
      $result[] = $font_name;
      return $result;
    });
    $fonts= array_unique($fonts);
    foreach($fonts as $font){
      // sanitize title to prevent potential security risks
      $field['choices'][$font] = ucwords($font);
    }
  }
  return $field;
});