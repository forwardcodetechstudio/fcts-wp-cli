<?php
/**
 * Display an image from an ACF field.
 *
 * @param array|null $image_field The ACF image field to display.
 */
function display_image( string|array|int|null $image_field, $size = 'full', $attrs = [] ) {

	if ( is_string( $image_field ) ) {
		$attr = '';
		if ( $attrs ) {
			foreach ( $attrs as $key => $value ) {
				$attr .= "$key='$value'";
			}
		}
		$result = "<img src='$image_field' alt='Image' $attr />";
    echo $result;
    return;
	} elseif ( is_array( $image_field ) ) {
		// If the file is not an SVG, get its attachment ID
		$attachment_id = $image_field['id'] ?? null;
	} else {
		$attachment_id = $image_field;
	}
	// Output the image using its attachment ID and size
	echo wp_get_attachment_image( $attachment_id, $size, false, $attrs );
}

/**
 * Function to display content in page or in log file
 * @param mixed $content
 * @param mixed $message
 * @param mixed $echo
 * @return void
 */
function debug($content=null,$message='',$echo=false){
  $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
  $file = isset($backtrace['file']) ? $backtrace['file'] : 'unknown file';
  $filename= basename($file);
  $line = isset($backtrace['line']) ? $backtrace['line'] : 'unknown line';
  if($echo){
    $print=$message;
  }else{
    $print= "[log.local] $filename $file:$line\n$message\n";
  }
  if(is_array($content)|| is_object($content)){
    $print.= var_export($content,true);
  }else{
    $print.= $content;
  }
  if($echo){
    var_dump( $print);
  }else{
    error_log($print);
  }
}

/**
 * Function to return text with text domain
 */

function _t($text){
  return __($text,TEXT_DOMAIN);
}