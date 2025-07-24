<?php

/**
 * Template part for displaying Comparison Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['comparison']) ?>>
  <div class="container">
    <?php if (get_sub_field('text')): ?>
      <div class="row _pb-50 text-center justify-content-center">
        <div class="col-lg-8">
          <?= get_sub_field('text') ?>
        </div>
      </div>
    <?php endif ?>
    <div class="row r-gap-20">
      <?php while (have_rows('cards')):
        the_row(); ?>
        <div class="col-lg-4">
          <div class="comparison__item <?= get_sub_field('type') ?>">
            <?= get_sub_field('text') ?>
          </div>
        </div>
      <?php endwhile ?>
    </div>
  </div>
</section>