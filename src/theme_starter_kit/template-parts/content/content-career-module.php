<?php

/**
 * Template part for displaying Teams Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIGITALLEAP
 */

// Fetching modules settings like ID, Padding, Background Color etc.
if (empty(get_sub_field('jobs'))) {
  $query = new WP_Query([
    'post_type' => 'career',
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => -1
  ]);
  $jobs = $query->posts;
} else {
  $jobs = get_sub_field('jobs');
}
?>

<section <?= module()->settings(['job']) ?>>
  <div class="container">
    <?php if (get_sub_field('text')): ?>
      <div class="row justify-content-center text-center _pb-50">
        <div class="col-lg-8">
          <?= get_sub_field('text') ?>
        </div>
      </div>
    <?php endif; ?>


  </div>
</section>