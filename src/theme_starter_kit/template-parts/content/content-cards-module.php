<?php

/**
 * Template part for displaying Headline Image Video Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
$column = get_sub_field('columns');
$columnClass = [
  "col-3" => "col-lg-3",
  "col-4" => "col-lg-4",
  "col-6" => "col-lg-6",
]
  ?>
<section <?= module()->settings(['cards']) ?>>
  <div class="container">
    <?php if (get_sub_field('headline')): ?>
      <div class="row justify-content-center text-center _pb-50">
        <div class="col-lg-12">
          <h2><?= get_sub_field('headline') ?></h2>
        </div>
      </div>
    <?php endif; ?>
    <div class="row cards__items r-gap-40">
      <?php while (have_rows('cards')):
        the_row(); ?>
        <div class="<?= $columnClass[$column] ?>">
          <div class="cards__item">
            <div class="cards__img">
              <?php
              $attachment_id = get_sub_field('image') ?? null;
              $size = "full"; // (thumbnail, medium, large, full or custom size)
              echo wp_get_attachment_image($attachment_id, $size);
              ?>
            </div>
            <div class="cards__body">
              <div class="cards__content">
                <div>
                  <?= get_sub_field('text') ?>
                </div>
                <?php if (have_rows('buttons')): ?>
                  <div class="btn-wrapper">
                    <?php get_template_part('template-parts/helpers/buttons-repeater') ?>
                  </div>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile ?>
    </div>
  </div>
</section>