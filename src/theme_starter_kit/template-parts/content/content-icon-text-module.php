<?php

/**
 * Template part for displaying Icon Text Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
$type = get_sub_field('type');
$column = get_sub_field('column');
?>
<section <?= module()->settings(['icon-text',$type]) ?>>
  <div class="container">
    <div
      class="row <?= $type == '_timeline' ? 'r-gap-40 justify-content-between' : 'justify-content-center text-center _pb-50' ?>">
      <div class=" <?= $type == '_timeline' ? 'col-lg-4' : 'col-lg-8' ?>">
        <?= get_sub_field('text') ?>
      </div>
      <?php if ($type == '_timeline'): ?>
        <div class="col-lg-7 text-dark">
          <div class="row  icon-text__data r-gap-40">
            <?php while (have_rows('icon_text_box')):
              the_row(); ?>
              <div class="col-sm-6 col-xl-6">
                <div class="icon-text__box">
                  <?php
                  $attachment_id = get_sub_field('image') ?? null;
                  $size = "full"; // (thumbnail, medium, large, full or custom size)
                  echo wp_get_attachment_image($attachment_id, $size);
                  echo get_sub_field('text');
                  ?>
                  <?php if (have_rows('buttons')): ?>
                    <div class="btn-wrapper justify-content-center">
                      <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
                    </div>
                  <?php endif ?>
                </div>
              </div>
            <?php endwhile ?>
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
  <?php if ($type != '_timeline'): ?>
    <div class="row icon-text__data justify-content-center text-center r-gap-40 text-dark">
      <?php while (have_rows('icon_text_box')):
        the_row(); ?>
        <div class="col-12 <?= $column ?>">
          <div class="icon-text__box">
            <?php
            $attachment_id = get_sub_field('image') ?? null;
            $size = "full"; // (thumbnail, medium, large, full or custom size)
            echo wp_get_attachment_image($attachment_id, $size);
            echo get_sub_field('text');
            ?>
            <?php if (have_rows('buttons')): ?>
              <div class="btn-wrapper justify-content-center">
                <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      <?php endwhile ?>
    </div>
  <?php endif ?>
  </div>
</section>