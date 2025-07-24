<?php
/**
 * Template part for displaying Teams Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIGITALLEAP
 */

 global $post_type,$posts;
$post_type= get_sub_field('post_type');
if (empty(get_sub_field('posts'))) {
  $query = new WP_Query([
    'post_type' => $post_type,
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => -1
  ]);
  $posts = $query->posts;
} else {
  $posts = get_sub_field('posts');
}
// debug($post_type);
?>
<section <?= module()->settings(['post']) ?> >
  <div class="container">
    <div class="row">
      <?= get_sub_field('text') ?>
    </div>
    <?php 
      if(file_exists("template-parts/partials/posts/post-$post_type")){
        get_template_part('template-parts/partials/posts/post',$post_type);
      }else{
        get_template_part('template-parts/partials/posts/post');
      }
    ?>
  </div>
</section>
<?php
