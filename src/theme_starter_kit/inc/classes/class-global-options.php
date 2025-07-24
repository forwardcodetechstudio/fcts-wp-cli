<?php
class GlobalOptions{
  use WithSingleton;

  public $colors;
  public $bgColors;

  public function __construct(){
    $this->colors= $this->colors();
    $this->bgColors= $this->bgColors();
  }
  public function colors(){
    $colors= get_field('colors_colors','option')?:[];

    if(is_array($colors)){
      $colors= array_reduce($colors,function($carry,$item){
        if (isset($item['name']) && isset($item['color'])) {
          $carry[$item['name']] = $item['color'];
        }
      return $carry;
      },['inherit'=>'inherit']);
    }else{
      $colors=['inherit'=>'inherit'];
    }
    return $colors;
  }

  public function bgColors(){
    $colors= get_field('colors_background_colors','option')??[];

    if(is_array($colors)){
      $colors= array_reduce($colors,function($carry,$item){
        if (isset($item['name']) && isset($item['background_color'])) {
          $carry[$item['name']] = $item['background_color'];
        }
        // debug($carry);
      return $carry;
      },['inherit'=>'inherit']);
    }else{
      $colors=['inherit'=>'inherit'];
    }
    return $colors;
  }

  public function colorFormat(array|string $field,$name='',$type='loop'){
    $colors= $this->colors;
    $res='';
    if(is_array($field)){
      $res=$field[$name]=='custom'?$field["{$name}_custom"]:($colors[$field[$name]]?:"#000000");
    }else{
      if($type=='single'){
        $res= $field=='custom'?null:$colors[$field]??'#000000';
      }else{
        $get_field= $type=='loop'?'get_sub_field':'get_field';
        $res=$get_field($field)=='custom'?$get_field("{$field}_custom"):($colors[$get_field($field)]?:'#000000');
      }
    }
    return $res;
  }
  public function bgColorFormat(array|string $field,$name='',$type='loop'){
    $colors= $this->bgColors;
    $res='';
    if(is_array($field)){
      $res=$field[$name]=='custom'?$field["{$name}_custom"]:($colors[$field[$name]]?:'#FFFFFF');
    }else{
      if($type=='single'){
        $res= $field=='custom'?null:$colors[$field]??'#FFFFFF';
      }else{
        $get_field= $type=='loop'?'get_sub_field':'get_field';
        $res=$get_field($field)=='custom'?$get_field("{$field}_custom"):($colors[$get_field($field)]?:'#FFFFFF');
      }
    }
    return $res;
  }
  public function buttonColorFormat(array|string $field,$name='',$set='main',$type='loop'){
    $colors=$set=='main'?$this->colors: $this->bgColors;
    $res='';
    if(is_array($field)){
      $res=$field[$name]=='custom'?$field["{$name}_custom"]:($colors[$field[$name]]?:($set=='main'?'#FFFFFF':'#000000'));
    }else{
      $get_field= $type=='loop'?'get_sub_field':'get_field';
      $res=$get_field($field)=='custom'?$get_field("{$field}_custom"):($colors[$get_field($field)]?:($set=='main'?'#FFFFFF':'#000000'));
    }
    return $res;
  }
}

function globalOptions(){return GlobalOptions::getInstance();}