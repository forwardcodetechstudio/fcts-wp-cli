<?php

/**
 * Template part for displaying CTA Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['cta',(get_sub_field('background_image') ? '_shadowed' : '')]) ?>>
  <?php if (get_sub_field('background_image')): ?>
    <div class="bg-img">
      <?php
      $attachment_id = get_sub_field('background_image') ?? null;
      $size = "full"; // (thumbnail, medium, large, full or custom size)
      echo wp_get_attachment_image($attachment_id, $size);
      ?>
    </div>
  <?php endif; ?>
  <div class="container">
    <div class="row justify-content-center r-gap-20">
      <div class="col-lg-7">
        <?= get_sub_field('text') ?>
      </div>
      <div class="col-lg-5">
        <?php if (have_rows('buttons')): ?>
          <div class="btn-wrapper justify-content-center mt-0">
            <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>