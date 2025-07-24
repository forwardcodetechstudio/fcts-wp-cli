<?php

/**
 * Template part for displaying Image Text Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
$imagecolumn = get_sub_field('image_column');
$imageClass = [
  "col-5" => "col-lg-5",
  "col-6" => "col-lg-6",
  "col-7" => "col-lg-7",
];
$textClass = [
  "col-5" => "col-lg-6",
  "col-6" => "col-lg-6",
  "col-7" => "col-lg-5",
]
  ?>
<section <?= module()->settings(['img-text']) ?>>
  <div class="container">
    <div
      class="row justify-content-between align-items-center r-gap-20 <?= get_sub_field('image_position') == 'right' ? 'flex-row-reverse' : '' ?>">
      <div class="<?= $imageClass[$imagecolumn] ?>">
        <?php
        $attachment_id = get_sub_field('image') ?? null;
        $size = "full"; // (thumbnail, medium, large, full or custom size)
        echo wp_get_attachment_image($attachment_id, $size); ?>
      </div>
      <div class="<?= $textClass[$imagecolumn] ?>">
        <div class="img-text__content">
          <div class="img-text__deco">
            <?php
            $attachment_id = get_sub_field('deco') ?? null;
            $size = "full"; // (thumbnail, medium, large, full or custom size)
            echo wp_get_attachment_image($attachment_id, $size); ?>
          </div>
          <?= get_sub_field('text') ?>
          <?php if (have_rows('buttons')): ?>
            <div class="btn-wrapper">
              <?php get_template_part('template-parts/helpers/buttons-repeater') ?>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</section>