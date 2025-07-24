<?php

/**
 * Template part for displaying Hero Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>

<section <?= module()->settings(['hero',(get_sub_field('background_image') ? '_shadowed' : '')]) ?>>
  <?php if (get_sub_field('background_image')): ?>
    <div class="bg-img">
      <?php
      $attachment_id = get_sub_field('background_image') ?? null;
      $size = "full"; // (thumbnail, medium, large, full or custom size)
      $attr = [
        'data-skip-lazy' => '1',
        'loading' => 'eager',
        'fetchpriority' => 'high',
      ];
      echo wp_get_attachment_image($attachment_id, $size, false, $attr);
      ?>
    </div>
  <?php endif; ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 hero__text">
        <div class="text">
          <?= get_sub_field('text') ?>
          <?php if (have_rows('buttons')): ?>
            <div class="btn-wrapper">
              <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>