<?php

/**
 * Template part for displaying Testimonials Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
if (empty(get_sub_field('testimonials'))) {
  $query = new WP_Query([
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => -1
  ]);
  $testimonials = $query->posts;
} else {
  $testimonials = get_sub_field('testimonials');
}
?>
<section <?= module()->settings(['testimonials']) ?>>
  <div class="container">
    <?php if (get_sub_field('text')): ?>
      <div class="row justify-content-center text-center _pb-75">
        <div class="col-lg-12">
          <?= get_sub_field('text') ?>
        </div>
      </div>
    <?php endif ?>

  </div>
</section>