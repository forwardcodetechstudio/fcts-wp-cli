<?php

/**
 * Advanced Custom Fields Pro functions for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme_Name
 */



// function for saves field group and field settings as .json inside theme directory.
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_save_point( $path ) {

	// update path
	$path = THEME_DIR_PATH . '/acf-json';

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

add_action( 'acf/init', function () {
	/**
	 * function for Flexible Content Preview Pop Up
	 */
	if ( get_field( 'felxible_content_show_popup', 'option' ) ) {
		add_action( 'admin_enqueue_scripts', 'acf_flexible_content_thumbnail' );
    // debug(message:'Enable');
	}
  // else{
  //   debug(message:'Not Enable');
  // }
} );
function acf_flexible_content_thumbnail() {

	$images = get_field( 'felxible_content_preview_images','option' );
	if ( $images ) {
		$images = array_reduce( $images, function ($carry, $item) {
			return [ $item['module_name'] => $item['module_image'] ];
		} );
	}
  // debug($images);
	// REGISTER ADMIN.CSS
	wp_enqueue_style( 'css-theme-admin', get_template_directory_uri() . '/assets/css/admin.css', false, 1.0 );

	// REGISTER ADMIN.JS
	wp_register_script( 'js-theme-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), 1.0, true );
	wp_localize_script(
		'js-theme-admin',
		'theme_var',
		array(
			'upload' => $images,
      'icon'=> THEME_ICON_URI
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
		jQuery(document).ready(function ($) {
			// need to loop through all number fields
			// in order to add a flag to enable/disable the mousewheel
			$('input[type="number"]').each(function (index, element) {
				// disable mousewheel by default on all number fields
				$(element).data('disable-mousewheel', true);
				// test if mousewheel is disabled, if it is prevent changing number field
				$(element).on('mousewheel', function (e) {
					if ($(element).data('disable-mousewheel')) {
						e.preventDefault();
					}
				}); // end on mousewheel
				// only enable the mousewheel when the mouse enters the number field
				$(element).on('mouseenter', function (e) {
					$(element).data('disable-mousewheel', false);
				}); // end on mouseenter
				// disable the mousewheel when the mouse leaves the number field
				$(element).on('mouseleave', function (e) {
					$(element).data('disable-mousewheel', true);
				}); // end on mouseleave
			}); // end each number element
		}); // end doc ready
	</script>
	<?php
}

function limit_acf_flexible_content_modules( $field ) {
	// make sure we're on a post admin page
	if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		return $field;
	}

	global $post;

	// check the current post type
	if ( $post && $post->post_type == 'component' ) {
		$remove_layouts = array(
			'component_module',
		); // keys of the layouts you want to remove
		//remove the layouts in the array
		foreach ( $field['layouts'] as $key => $layout ) {
			if ( in_array( $layout['name'], $remove_layouts ) ) {
				unset( $field['layouts'][ $key ] );
			}
		}
	}


	return $field;
}
add_filter( 'acf/load_field/key=field_620b7af116bef', 'limit_acf_flexible_content_modules' );

add_filter( 'acf/load_field/key=field_681ca1be2568f', 'get_acf_flexible_content_modules' );

function get_acf_flexible_content_modules( $field ) {
	$layouts = get_field_object( 'field_620b7af116bef' );
  $layouts= $layouts['layouts'];
  $layouts=array_reduce($layouts,function($carry,$item){
    $carry[$item['name']]=$item['label'];
    return $carry;
  });
  // debug($layouts);
  $field['choices']=$layouts;
	return $field;
}


function acf_generate_options_css( $post_id, $menu_slug ) {

	$options = get_fields( 'options' );

	if ( $options ) {
		$variables_path = THEME_DIR_PATH . '/assets/scss/_acf-variables.scss';
		$styles_path = THEME_DIR_PATH . '/assets/scss/_acf-styles.scss';
		$options = get_fields( 'options' );
		// $variable = "@import '_generated-fonts';\n";
		$variable = [];
		$content = [];
		$fonts = [];
		$globalOptions = globalOptions();
		$colors = [ $globalOptions, 'colorFormat' ];
		$bgcolors = [ $globalOptions, 'bgColorFormat' ];
		$buttoncolors = [ $globalOptions, 'buttonColorFormat' ];
		//debug($options['farbgestaltung']);

		$variable[] = <<<scss
    @import '_generated-fonts';
    scss;
		if ( isset( $options['colors'] ) && $options['colors'] ) {
      $color_var=["\$text-colors: ("];
      $bg_var=['$bg-colors: ('];
			#Color Starts
			foreach ( $options['colors'] as $name => $value ) {
				switch ( $name ) {


					case 'background_colors':
						if ( $value ) {
							foreach ( $value as $item ) {
								$content[] = <<<css
                  ._bg-{$item['name']}{
                  --bg-color: {$item['background_color']};
                  background-color: var(--bg-color);
                }
                css;
                $bg_var[]=<<<scss
                  "{$item['name']}": {$item['background_color']},
                scss;
							}
						}
						break;
					case 'colors':
						// debug($value);
						if ( $value ) {
							$variable[] = "\$primary:{$value[0]['color']};";
							foreach ( $value as $item ) {
								$content[] = <<<css
                ._text-{$item['name']} {
                  --color: {$item['color']};
                }
                ._border-{$item['name']} {
                  --border-color: {$item['color']};
                }\n
                css;
                $color_var[]=<<<scss
                  "{$item['name']}":{$item['color']},
                scss;
							}
						}
						break;
					case 'button_colors':
						if ( $value ) {
              $btn_box_shadow= $value[0]['box_shadow']?:'none';
							$content[] = <<<css
              ._btn-{$value[0]['name']}{  
                background-color: {$buttoncolors( $value[0], 'background_color', 'bg' )};
                color:{$buttoncolors( $value[0], 'color' )};
                box-shadow: {$btn_box_shadow};
              }
              ._btn-{$value[0]['name']}:hover{
                background-color:{$buttoncolors( $value[0], 'background_color_hover', 'bg' )};
                color:{$buttoncolors( $value[0], 'color_hover' )};
              }\n
              css;
							foreach ( $value as $item ) {
                $btn_box_shadow= $item['box_shadow']?:'none';
								$content[] = <<<css
                ._btn-{$item['name']}{  
                  background-color: {$buttoncolors( $item, 'background_color', 'bg' )};
                  color:{$buttoncolors( $item, 'color' )};
                  box-shadow: {$btn_box_shadow};
                }
                ._btn-{$item['name']}:hover{
                  background-color:{$buttoncolors( $item, 'background_color_hover', 'bg' )};
                  color:{$buttoncolors( $item, 'color_hover' )};
                }\n
                css;
							}
						}
						break;
					default:
						if ( $value ) {
							$value = $colors( $value, type: 'single' ) ?? $bgcolors( $value, type: 'single' ) ?? $value;
							$variable[] = "\${$name}:{$value};";
						}
						break;
				}
			}
      $color_var[]=");";
      $bg_var[]=");";
      $color_var_text= implode("\n",$color_var);
      $color_var_text.="\n";
      $color_var_text.=implode("\n",$bg_var);
      $variable[]=$color_var_text;
      $variable[]= <<<scss
        :root{
          @each \$name, \$color in \$text-colors {
            --text--#{\$name}: #{\$color};
          }
          @each \$name, \$color in \$bg-colors {
            --bg--#{\$name}: #{\$color};
          }
        }
      scss;
		}
		if ( isset( $options['typography'] ) && $options['typography'] ) {
      $fontsizes=["\$text-sizes: ("];
      $fontsizes_mobile=['$text-sizes-mobile: ('];
			# Typography Starts
			foreach ( $options['typography'] as $key => $item ) {
				if ( $key !== '' ) {
					$content_color = isset( $item['color'] ) ? $colors( $item['color'], type: 'single' ) ?? $item['color_custom'] : '';
					$class_name = $key == 'text_main' ? 'body' : "._$key";
					$content_typo = <<<css
          $class_name {
            --font-size: {$item['font_size']}{$item['font_size_m']};
            font-size: var(--font-size);
            font-weight: {$item['font_weigth']};
            font-style: {$item['font_style']};
            line-height: {$item['line-height']};
            font-variation-settings: "wght" {$item['font_weigth']};
          css;
					if ( $content_color ) {
						$content_typo .= "color: var(--color, {$content_color});\n";
					}
					if ( $item['font_family'] === 'inherit' ) {
						$content_typo .= "  font-family: inherit;\n";
					} else {
						$content_typo .= "  font-family: \"{$item['font_family']}\";\n";
					}

					if ( isset( $item['text_transform'] ) ) {
						$content_typo .= "  text-transform: {$item['text_transform']};\n";
					}
					if ( isset( $item['font_stretch'] ) ) {
						$content_typo .= "  font-stretch: {$item['font_stretch']};\n";
					}
					if ( isset( $item['margin_bottom'] ) ) {
						$content_typo .= "  margin-bottom: {$item['margin_bottom']}px;\n";
					}
					if ( isset( $item['letter_spacing'] ) ) {
						$content_typo .= "  letter-spacing: {$item['letter_spacing']}px;\n";
					}
					if ( $key !== 'text_main' ) {
						$content_typo .= <<<css
            @include down-lg {
              --font-size: {$item['font_size_mobile']}{$item['font_size_m']};
              font-size: {$item['font_size_mobile']}{$item['font_size_m']};
            }\n
            css;
					}
					$content_typo .= "}\n";
					$content[] = $content_typo;

					if ( $item['font_family'] !== 'inherit' ) {
						generate_fonts_value( $item, $fonts );
					}
					if ( $key === 'text_main' ) {
						$variable[] = "\$font-size-body:{$item['font_size']}px;";
					}

					if ( in_array( $key, [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6','p' ] ) ) {
						if ( isset( $item['color'] ) ) {
							$_color = $colors( $item['color'], type: 'single' ) ?? $item['color_custom'];
						}
						$content[] = <<<css
            .standard-text $key._title-custom {
              --color:$_color;
            }\n
            css;
					}
          $fontsizes[]=<<<scss
            "{$key}":{$item['font_size']}{$item['font_size_m']},
          scss;
          $fontsizes_mobile[]=<<<scss
            "{$key}": {$item['font_size_mobile']}{$item['font_size_m']},
          scss;
				}
			}
      $fontsizes[]=");";
      $fontsizes_mobile[]=");";
      $fontsizes_text= implode("\n",$fontsizes);
      $fontsizes_text.="\n";
      $fontsizes_text.=implode("\n",$fontsizes_mobile);
      $variable[]=$fontsizes_text;
      $variable[]= <<<scss
        :root{
          @each \$name, \$size in \$text-sizes {
            --text--#{\$name}: #{\$size};
          }
          @each \$name, \$size in \$text-sizes-mobile {
            @media (max-width: 991.98px) {
              --text--#{\$name}: #{\$size};
            }
          }
        }
      scss;
		}
    #Header
    acf_generate_header_css( $options['header']??[], $variable, $bgcolors );
    acf_generate_body_css( $options['body']??[], $variable, $bgcolors );
    acf_generate_footer_css( $options['footer']??[], $variable, $colors, $bgcolors );
    generate_spacing_css($options['spacing'],$variable);
		// Write to separate files
		file_put_contents( $variables_path, implode( "\n", $variable ), LOCK_EX );
		file_put_contents( $styles_path, implode( "\n", $content ), LOCK_EX );
	}
	acf_generate_font_css( $fonts );
}

add_action( 'acf/options_page/save', 'acf_generate_options_css', 10, 2 );


function acf_generate_header_css( $header, &$variable, $bgColors ) {
	$color = isset($header['background_color'])&&$header['background_color']? $bgColors( $header['background_color'], type: 'single' ) : '#FFFFFF';
	$logo = $header['logo']??[];
	$header_bar = $header['header_bar']??[];
	$variable[] = format_acf_values('$header_background_color',$color,'#FFFFFF','');
	$variable[] = format_acf_values('$logo_width_desktop',$logo['width']['desktop']??0,0);
	$variable[] = format_acf_values('$logo_width_tablet',$logo['width']['tablet']??0,0);
	$variable[] = format_acf_values('$logo_width_mobile',$logo['width']['mobile']??0,0);
	$variable[] = format_acf_values('$logo_width_scrolled_desktop',$logo['width_scrolled']['desktop']??0,0);
	$variable[] = format_acf_values('$logo_width_scrolled_tablet',$logo['width_scrolled']['tablet']??0,0);
	$variable[] = format_acf_values('$logo_width_scrolled_mobile',$logo['width_scrolled']['mobile']??0,0);
	$variable[] = format_acf_values('$header_bar_box_shadow',$header_bar['box_shadow']??'','none','');
	$variable[] = format_acf_values('$header_bar_height_desktop',$header_bar['height']['desktop']??'',0);
	$variable[] = format_acf_values('$header_bar_height_tablet',$header_bar['height']['tablet']??'',0);
	$variable[] = format_acf_values('$header_bar_height_mobile',$header_bar['height']['mobile']??'',0);
	$variable[] = format_acf_values('$header_bar_height_scrolled_desktop',$header_bar['height_scrolled']['desktop']??'',0);
	$variable[] = format_acf_values('$header_bar_height_scrolled_tablet',$header_bar['height_scrolled']['tablet']??'',0);
	$variable[] = format_acf_values('$header_bar_height_scrolled_mobile',$header_bar['height_scrolled']['mobile']??'',0);
	$variable[] = format_acf_values('$header_bar_submenu_box_shadow',$header_bar['submenu']['box_shadow']??'','none','');
	$variable[] = format_acf_values('$header_bar_submenu_margin_top',$header_bar['submenu']['margin_top']??'',0);
	$variable[] = format_acf_values('$header_bar_submenu_margin_top_scrolled',$header_bar['submenu']['margin_top_scrolled']??'',0);
	$variable[] = format_acf_values('$header_bar_main_menu_items_gap',$header_bar['main_menu']['items_gap']??'',0);
	$variable[] = format_acf_values('$header_bar_main_menu_alignment',$header_bar['main_menu']['alignment']??'','none','');
}

function acf_generate_body_css( $body, &$variable, $bgColors ) {
	$color =isset($body['background_color']) &&$body['background_color'] ? $bgColors( $body['background_color'], type: 'single' ) :"#FFFFFF";
	$variable[] = format_acf_values('$body_background_color',$color,'#FFFFFF','');
	$variable[] = format_acf_values('$body_page_max_width',$body['page_max_width']??'',0);
	$variable[] = format_acf_values('$body_padding',$body['padding']??'',0);
	$color = isset($body['border']) && isset($body['border']['color']) && $body['border']['color']? $bgColors( $body['border']['color'], type: 'single' ) : '#000000';
	$variable[] = format_acf_values('$body_border_color',$color,'#000000','');
	$variable[] = format_acf_values('$body_border_width',$body['border']['width']??'',0);
	$variable[] = format_acf_values('$body_border_radius_top_left',$body['border']['radius']['top_left']??'',0);
	$variable[] = format_acf_values('$body_border_radius_top_right',$body['border']['radius']['top_right']??'',0);
	$variable[] = format_acf_values('$body_border_radius_bottom_right',$body['border']['radius']['bottom_right']??'',0);
	$variable[] = format_acf_values('$body_border_radius_bottom_left',$body['border']['radius']['bottom_left']??'',0);
	$variable[] = format_acf_values('$body_button_border_radius_top_left',$body['buttons']['border_radius']['top_left']??'',0);
	$variable[] = format_acf_values('$body_button_border_radius_top_right',$body['buttons']['border_radius']['top_right']??'',0);
	$variable[] = format_acf_values('$body_button_border_radius_bottom_right',$body['buttons']['border_radius']['bottom_right']??'',0);
	$variable[] = format_acf_values('$body_button_border_radius_bottom_left',$body['buttons']['border_radius']['bottom_left']??'',0);
}

function acf_generate_footer_css( $footer, &$variable, $colors, $bgColors ) {
	$color = isset($footer['background_color']) && $footer['background_color']? $bgColors( $footer['background_color'], type: 'single' ) : "#000000";
	$variable[] = format_acf_values('$footer_background_color',$color,'#000000','');
	$color = isset($footer['text_color']) &&$footer['text_color']? $colors( $footer['text_color'], type: 'single' ) :"#FFFFFF";
	$variable[] = format_acf_values('$footer_text_color',$color,'#FFFFFF','');
	$variable[] = format_acf_values('$footer_logo_width',$footer['logo']['width']??'',0);
	$variable[] = format_acf_values('$footer_logo_margin_bottom',$footer['logo']['margin_bottom']??'',0);
}


function acf_generate_font_css( $fonts ) {
	$fonts_dir = get_template_directory() . '/assets/fonts'; // Target SCSS directory
	$scss_dir = get_template_directory() . '/assets/scss/fonts'; // Target SCSS directory
	$main_scss_file = get_template_directory() . '/assets/scss/_generated-fonts.scss'; // Import file
	$import_statements = [];
	$main_font_dir = '../fonts/';
	$fonts_files = [];
	// Ensure the directory exists
	if ( ! file_exists( $scss_dir ) ) {
		mkdir( $scss_dir, 0755, true );
	}

	foreach ( $fonts as $font_name => $items ) {
		$css_content = [];
		$font_slug = strtolower( str_replace( ' ', '-', $font_name ) ); // Convert to lowercase slug
		$file_path = "$scss_dir/_font-$font_slug.scss";
		$weights = $items['weights'];
		$font_style = $items['font_style'];

		foreach ( $weights as $weight ) {
			$filename_woff2 = "{$fonts_dir}/{$font_slug}-$weight.woff2";
			$filename_woff = "{$fonts_dir}/{$font_slug}-$weight.woff";
			$font_src = [];
			if ( file_exists( $filename_woff ) ) {
				$font_src[] = "url('{$main_font_dir}{$font_slug}-$weight.woff') format('woff')";
				array_push( $fonts_files, [ 'path' => $filename_woff, 'type' => 'font/woff' ] );
			}
			if ( file_exists( $filename_woff2 ) ) {
				$font_src[] = "url('{$main_font_dir}{$font_slug}-$weight.woff2') format('woff2')";
				array_push( $fonts_files, [ 'path' => $filename_woff2, 'type' => 'font/woff2' ] );
			}
			$src = implode( ',', $font_src );
			if ( $src ) {

				$css_content[] = <<<scss
          @font-face {
              font-family: '{$font_name}';
              font-weight: $weight;
              font-style: $font_style ;
              src: $src;
          }
          scss;
			}
		}
		file_put_contents( $file_path, implode( "\n", $css_content ) );
		$import_statements[] = "@import 'fonts/_font-{$font_slug}';";
	}
	file_put_contents( $main_scss_file, implode( "\n", $import_statements ) );
}

function generate_fonts_value( $item, &$fonts ) {
	// debug($item,'Font Value');
	$font_family = $item['font_family'];
	$font_weight = $item['font_weigth'];
	$font_style = $item['font_style'];
	if ( ! isset( $fonts[ $font_family ] ) ) {
		$fonts[ $font_family ] = [ 
			'weights' => [],
			'font_style' => $font_style,
		];
	}
	if ( ! in_array( $font_weight, $fonts[ $font_family ]['weights'] ) ) {
		$fonts[ $font_family ]['weights'][] = $font_weight;
		$fonts[ $font_family ]['font_style'] = $font_style;
	}
}

function find_all_fonts_used() {
	$typography = get_field( 'typography', 'option' );
	$fonts = [];
	if ( ! isset( $typography ) && ! $typography )
		return null;
	foreach ( $typography as $key => $item ) {
		if ( $key !== '' ) {
			if ( $item['font_family'] !== 'inherit' ) {
				generate_fonts_value( $item, $fonts );
			}
		}
	}
	if ( count( $fonts ) == 0 )
		return null;
	$fonts_dir = get_template_directory() . '/assets/fonts'; // Target SCSS directory
	$fonts_dir_uri = get_stylesheet_directory_uri() . '/assets/fonts'; // Target SCSS directory
	$fonts_files = [];
	foreach ( $fonts as $font_name => $items ) {
		$font_slug = strtolower( str_replace( ' ', '-', $font_name ) ); // Convert to lowercase slug
		$weights = $items['weights'];
		foreach ( $weights as $weight ) {
			$filename_woff2_dir = "{$fonts_dir}/{$font_slug}-$weight.woff2";
			$filename_woff2_uri = "{$fonts_dir_uri}/{$font_slug}-$weight.woff2";
			$filename_woff_dir = "{$fonts_dir}/{$font_slug}-$weight.woff";
			$filename_woff_uri = "{$fonts_dir_uri}/{$font_slug}-$weight.woff";
			if ( file_exists( $filename_woff_dir ) ) {
				array_push( $fonts_files, [ 'path' => $filename_woff_uri, 'type' => 'font/woff' ] );
			}
			if ( file_exists( $filename_woff2_dir ) ) {
				array_push( $fonts_files, [ 'path' => $filename_woff2_uri, 'type' => 'font/woff2' ] );
			}
		}
	}
	return $fonts_files;
}
function generate_fonts_preload( $fonts ) {
	if ( count( $fonts ) == 0 )
		return null;
	$head = [];
	foreach ( $fonts as $font ) {
		$head[] = <<<html
    <link rel="preload" href="{$font['path']}" as="font" type="{$font['type']}" crossorigin>
    html;
	}
	return implode( "\n", $head );
}

add_action( 'wp_head', function () {
	$fonts = find_all_fonts_used();
	if ( $fonts ) {
		echo generate_fonts_preload( $fonts ) ?? '';
	}
} );

function format_acf_values($name,$value,$default,$suffix='px'){
  $res= "{$name}:";
  $res.= $value?"{$value}":"{$default}";
  if($suffix){
    $res.=$suffix;
  }
  $res.=";";
  return $res;
}

function generate_spacing_css($spacing,&$variable){
  // $spacing= get_field('spacing','option')?:null;
  if(!$spacing)return;
  $paddings=[];
  $margins=[];

  if(isset($spacing['paddings']) && is_array($spacing['paddings'])){

    foreach($spacing['paddings'] as $padding){
      $paddings['desktop'][]="\"{$padding['name']}\":{$padding['desktop']}";
      $paddings['tablet'][]="\"{$padding['name']}\":{$padding['tablet']}";
      $paddings['mobile'][]="\"{$padding['name']}\":{$padding['mobile']}";
    }
  
    $paddings['desktop']= implode(",\n",$paddings['desktop']);
    $paddings['tablet']= implode(",\n",$paddings['tablet']);
    $paddings['mobile']= implode(",\n",$paddings['mobile']);

    $variable[]=format_acf_values('$paddings',"(\n{$paddings['desktop']}\n)",'','');
    $variable[]=format_acf_values('$paddings-tablet',"(\n{$paddings['tablet']}\n)",'','');
    $variable[]=format_acf_values('$paddings-mobile',"(\n{$paddings['mobile']}\n)",'','');

    $variable[]=<<<scss
    @each \$names, \$space in \$paddings {
      ._pv-#{\$names} {
        padding-top: #{\$space}px;
        padding-bottom: #{\$space}px;
      }
      ._pt-#{\$names} {
        padding-top: #{\$space}px;
      }
      ._pb-#{\$names} {
        padding-bottom: #{\$space}px;
      }
    }
    @each \$names, \$space in \$paddings-tablet {
      @media (max-width: 991.98px) {
        ._pv-#{\$names} {
          padding-top: #{\$space}px;
          padding-bottom: #{\$space}px;
        }
        ._pt-#{\$names} {
          padding-top: #{\$space}px;
        }
        ._pb-#{\$names} {
          padding-bottom: #{\$space}px;
        }
      }
    }
    @each \$names, \$space in \$paddings-mobile {
      @media (max-width: 375.98px) {
        ._pv-#{\$names} {
          padding-top: #{\$space}px;
          padding-bottom: #{\$space}px;
        }
        ._pt-#{\$names} {
          padding-top: #{\$space}px;
        }
        ._pb-#{\$names} {
          padding-bottom: #{\$space}px;
        }
      }
    }
    scss;
  }

  if(isset($spacing['margins']) && $spacing['margins']){
    foreach($spacing['margins'] as $margin){
      $margins['desktop'][]="\"{$margin['name']}\":{$margin['desktop']}";
      $margins['tablet'][]="\"{$margin['name']}\":{$margin['tablet']}";
      $margins['mobile'][]="\"{$margin['name']}\":{$margin['mobile']}";
    }
  
    $margins['desktop']= implode(",\n",$margins['desktop']);
    $margins['tablet']= implode(",\n",$margins['tablet']);
    $margins['mobile']= implode(",\n",$margins['mobile']);
  
    $variable[]=format_acf_values('$margins',"(\n{$margins['desktop']}\n)",'','');
    $variable[]=format_acf_values('$margins-tablet',"(\n{$margins['tablet']}\n)",'','');
    $variable[]=format_acf_values('$margins-mobile',"(\n{$margins['mobile']}\n)",'','');
    
  
    $variable[]=<<<scss
    @each \$names, \$space in \$margins {
      ._mv-#{\$names} {
        margin-top: #{\$space}px;
        margin-bottom: #{\$space}px;
      }
      ._mt-#{\$names} {
        margin-top: #{\$space}px;
      }
      ._mb-#{\$names} {
        margin-bottom: #{\$space}px;
      }
    }
    @each \$names, \$space in \$margins-tablet {
      @media (max-width: 991.98px) {
        ._mv-#{\$names} {
          margin-top: #{\$space}px;
          margin-bottom: #{\$space}px;
        }
        ._mt-#{\$names} {
          margin-top: #{\$space}px;
        }
        ._mb-#{\$names} {
          margin-bottom: #{\$space}px;
        }
      }
    }
    @each \$names, \$space in \$margins-mobile {
      @media (max-width: 375.98px) {
        ._mv-#{\$names} {
          margin-top: #{\$space}px;
          margin-bottom: #{\$space}px;
        }
        ._mt-#{\$names} {
          margin-top: #{\$space}px;
        }
        ._mb-#{\$names} {
          margin-bottom: #{\$space}px;
        }
      }
    }
    scss;
  }
}

add_filter('acf/load_field/key=field_620b77a0d973e',function($field){
  
  if(acf_is_acf_admin_screen()){
    return $field;
  }
  $paddings= get_field('spacing_paddings','option');
  $field['choices']=[];
  foreach($paddings as $padding){
    $field['choices']["_pt-{$padding['name']}"]=$padding['name'];
    if($padding['default']){
      $field['default_value']="_pt-{$padding['name']}";
    }
  }
  debug($field);
  return $field;
});

add_filter('acf/load_field/key=field_6218842699cb6',function($field){
  if(acf_is_acf_admin_screen()){
    return $field;
  }
  $paddings= get_field('spacing_paddings','option');
  $field['choices']=[];
  foreach($paddings as $padding){
    $field['choices']["_pb-{$padding['name']}"]=$padding['name'];
    if($padding['default']){
      $field['default_value']="_pb-{$padding['name']}";
    }
  }
  return $field;
});
