<?php

class Ajax {
  use WithSingleton;

  public function demo($request){
    debug($request);
  }

  public function filter_posts($request){
    $s= isset($request->s)? sanitize_text_field($request->s):'';
    $cat= isset($request->terms)?sanitize_text_field($request->terms):'';
    // $meta= isset($request->meta)?sanitize_text_field($request->meta):'';
    $paged= isset($request->paged)?sanitize_text_field($request->paged):2;
    $posts_per_page= isset($request->posts_per_page)?sanitize_text_field($request->posts_per_page):12;
    $post_type= isset($request->post_type)?sanitize_text_field($request->post_type):'post';
    $taxonomy= isset($request->taxonomy)?sanitize_text_field($request->taxonomy):'category';
    $taxonomy_field= isset($request->taxonomy_field)?sanitize_text_field($request->taxonomy_field):'slug';
    $args= [
      'post_type'=> $post_type,
      'post_status'=> 'publish',
      'order'=>'DESC',
      'orderby'=>'date',
      'post_per_page'=>$posts_per_page,
      'paged'=>$paged
    ];
    
    if(!empty($s)){
      $args['s']=$s;
    }
    if(!empty($cat)){
      $tax= [
        'taxonomy'=>$taxonomy,
        'field'=>$taxonomy_field,
        'terms'=>$cat
      ];
      $args['tax_query']=[$tax];
    }
    // if(!empty($meta)){
    //   $meta_query= apply_filters('theme_ajax_add_args_meta',$meta,$request);
    //   $args['meta_query']=[$meta_query];
    // }
    
    $query= new WP_Query($args);
    if($query->have_posts()){
      $max_num_pages= $query->max_num_pages;
      $path=THEME_DIR_PATH."/template-parts/partials/posts/loop/loop-$post_type.php";
      ob_start();
      foreach($query->posts as $post){
        require $path;
      }
      $html= ob_get_clean();
      wp_send_json_success(['html'=>$html,'max_num_pages'=> $max_num_pages,'current_page'=>$paged,'next_page'=>$max_num_pages==$paged?null:($paged+1)]);
    }else{
      wp_send_json_error(['message'=>'No posts found']);
    }
    wp_die();
    }

}
