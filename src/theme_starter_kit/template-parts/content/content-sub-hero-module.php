<?php

/**
 * Template part for displaying Sub Hero Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['sub-hero',((get_sub_field('background_image')) ? '_shadowed' : '')]) ?>>
  <?php if (get_sub_field('background_image')): ?>
    <div class="bg-img">
      <?php
      $attachment_id = get_sub_field('background_image') ?? null;
      $size = "full"; // (thumbnail, medium, large, full or custom size)
      echo wp_get_attachment_image($attachment_id, $size);
      ?>
    </div>
  <?php endif; ?>
  <div class="container h-100">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8 sub-hero__text">
        <div class="sub-hero__content">
          <?= get_sub_field('text') ?>
          <?php if (have_rows('buttons')): ?>
            <div class="btn-wrapper justify-content-center">
              <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</section>