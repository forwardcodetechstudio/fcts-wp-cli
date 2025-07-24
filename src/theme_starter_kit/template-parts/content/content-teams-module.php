<?php

/**
 * Template part for displaying Teams Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
if (empty(get_sub_field('teams'))) {
  $query = new WP_Query([
    'post_type' => 'team',
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => -1
  ]);
  $teams = $query->posts;
} else {
  $teams = get_sub_field('teams');
}
?>
<section <?= module()->settings(['team']) ?>>
  <div class="container">
    <div class="row justify-content-center text-center _pb-50">
      <?php if (get_sub_field('text')): ?>
        <div class="col-lg-8">
          <?= get_sub_field('text') ?>
        </div>
      <?php endif ?>
    </div>

  </div>
</section>