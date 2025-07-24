<?php
class ModuleOptions {
  use WithSingleton;
  public function column($field_name,$type='loop'){
    $columns=[
      'col-1'=>'col-lg-1',
      'col-2'=>'col-lg-2',
      'col-3'=>'col-lg-3',
      'col-4'=>'col-lg-4',
      'col-5'=>'col-lg-5',
      'col-6'=>'col-lg-6',
      'col-7'=>'col-lg-7',
      'col-8'=>'col-lg-8',
      'col-9'=>'col-lg-9',
      'col-10'=>'col-lg-10',
      'col-11'=>'col-lg-11',
      'col-12'=>'col-lg-12'
    ];
    $field=$type='loop'?'get_sub_field':'get_field';
    $column= $type=='array'?$field_name:$field($field_name);
    return $columns[$column]??'';
  }
  public function offset($field_name,$type='loop'){
    $columns=[
      'offset-0'=>'offset-lg-0',
      'offset-1'=>'offset-lg-1',
      'offset-2'=>'offset-lg-2',
      'offset-3'=>'offset-lg-3',
      'offset-4'=>'offset-lg-4',
      'offset-5'=>'offset-lg-5',
      'offset-6'=>'offset-lg-6',
      'offset-7'=>'offset-lg-7',
      'offset-8'=>'offset-lg-8',
      'offset-9'=>'offset-lg-9',
      'offset-10'=>'offset-lg-10',
      'offset-11'=>'offset-lg-11',
      'offset-12'=>'offset-lg-12'
    ];
    $field=$type='loop'?'get_sub_field':'get_field';
    $column= $type=='array'?$field_name:$field($field_name);
    return $columns[$column]??'';
  }

  /**
 * Get custom ID and class for ACF Pro modules settings
 *
 * @return string String with custom ID and class
 */
  public function settings( $class = [], $id = '',$styles=[] ) {

    $settings= get_sub_field('settings');
    $classes = []; // Initialize an empty array to hold the custom classes
    $customID = $settings['custom_id']; // Get the custom ID field value
    $customClass = $settings['custom_class']; // Get the custom class field value
    $paddingTop = $settings['padding-top']; // Get the padding-top field value
    $paddingBottom = $settings['padding-bottom']; // Get the padding-bottom field value
    $bgColor = $settings['background_color']; // Get the background color field value
    $textColor = $settings['color']; // Get the background color field value
  
    array_push($classes,'standard-text');
    if ( $class ) {
     $classes= array_merge( $classes, $class );
    }
    if ( $customID ) { // Check if the custom ID field has a value
      array_push( $classes, $customID ); // Add the custom ID value to the classes array
    }
  
    if ( $customClass ) { // Check if the custom class field has a value
      array_push( $classes, $customClass ); // Add the custom class value to the classes array
    }
  
    if ( $paddingTop ) { // Check if the padding-top field has a value
      array_push( $classes, $paddingTop ); // Add the padding-top value to the classes array
    }
  
    if ( $paddingBottom ) { // Check if the padding-bottom field has a value
      array_push( $classes, $paddingBottom ); // Add the padding-bottom value to the classes array
    }
  
    if ( $bgColor ) { // Check if the background color field has a value
      array_push( $classes, $bgColor ); // Add the background color value to the classes array
      if($bgColor=='_bg-custom'){
        $styles['--background-color']= $settings['background_color_custom'];
      }
    }
    if ( $textColor ) { // Check if the background color field has a value
      array_push( $classes, $textColor ); // Add the background color value to the classes array
      if($textColor=='_text-custom'){
        $styles['--color']= $settings['color_custom'];
      }
    }
  
    $resultClasses = implode( ' ', $classes );
    $resultstyle = "";
    foreach($styles as $key=>$value){
      $resultstyle .= "$key:$value;";
    }
    $customID = $id;
    $result=[];
    if($resultClasses){
      $result[]="class='$resultClasses'";
    }
    if($customID){
      $result[]="id='$customID'";
    }
    if($resultstyle){
      $result[]="style='$resultstyle;'";
    }
    return implode(' ',$result);
  }
}

function module(){
  return ModuleOptions::getInstance();
}