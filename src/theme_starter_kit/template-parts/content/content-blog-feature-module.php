<?php

/**
 * Template part for displaying Blog Feature Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
if (empty(get_sub_field('featured_blog'))) {
  $query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => 1
  ]);
  $blog_feature = $query->posts;
} else {
  $blog_feature[] = get_sub_field('featured_blog');
}
?>
<section <?= module()->settings(['blog','_featured']) ?>>
  <div class="container">
    <div class="row ">
      <?php foreach ($blog_feature as $post):
        setup_postdata($post) ?>
        <div class="col-lg-6  pe-lg-0">
          <?php the_post_thumbnail() ?>
        </div>
        <div class="col-lg-6 ps-lg-0">
          <div class="blog__body">
            <h6><?= get_the_category()[0]->name ?></h6>
            <h4><?= get_the_title() ?></h4>
            <p><?= get_the_excerpt() ?></p>
            <div class="btn-wrapper">
              <a href="<?= get_the_permalink() ?>"
                class="btn btn_purple"><?php _t('mehr erfahren' ); ?></a>
            </div>
          </div>
        </div>
      <?php endforeach;
      wp_reset_postdata() ?>
    </div>
  </div>
</section>