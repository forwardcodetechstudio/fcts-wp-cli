<?php

/**
 * Template part for displaying Timeline Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['image-icon'],'',["--deco-img"=>'url('.get_sub_field('deco_image').')']) ?>>
  <div class="container">
    <div class="row r-gap-40 justify-content-between">
      <div class="col-lg-5">
        <?= get_sub_field('headline') ?>
        <?php
        if (get_sub_field('image')) {
          $attachment_id = get_sub_field('image') ?? null;
          $size = "full"; // (thumbnail, medium, large, full or custom size)
          echo wp_get_attachment_image($attachment_id, $size);
        }
        ?>
        <?php if (have_rows('buttons')): ?>
          <div class="btn-wrapper">
            <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-6">
        <?php while (have_rows('timeline')):
          the_row(); ?>
          <div class="image-icon__box">
            <div class="_img">
              <?php
              $attachment_id = get_sub_field('image') ?? null;
              $size = "full"; // (thumbnail, medium, large, full or custom size)
              echo wp_get_attachment_image($attachment_id, $size);
              ?>
            </div>
            <div class="_text">
              <?= get_sub_field('text') ?>
            </div>
          </div>
        <?php endwhile ?>
      </div>
    </div>
  </div>
</section>