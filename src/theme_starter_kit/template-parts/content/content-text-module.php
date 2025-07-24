<?php

/**
 * Template part for displaying Text Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['text']) ?>>
  <div class="container">
    <div class="row justify-content-center <?= get_sub_field('is_center') ? 'text-lg-center' : '' ?>">
      <div class="<?= get_sub_field('column') ?>">
        <?= get_sub_field('text') ?>
        <?php if (get_sub_field('buttons')): ?>
          <div class="btn-wrapper <?= get_sub_field('is_center') ? 'justify-content-center' : '' ?>">
            <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
          </div>
        <?php endif ?>
      </div>
    </div>
    <div class="row r-gap-20">
      <?php while (have_rows('items')):
        the_row(); ?>
        <div class="<?= get_sub_field('column') ?> <?= get_sub_field('is_center') ? 'text-lg-center' : '' ?>">
          <?= get_sub_field('text') ?>
          <?php if (get_sub_field('buttons')): ?>
            <div class="btn-wrapper">
              <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
            </div>
          <?php endif ?>
        </div>
      <?php endwhile ?>
    </div>
  </div>
</section>