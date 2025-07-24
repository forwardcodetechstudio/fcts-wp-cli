<?php

/**
 * Template part for displaying Stats Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['stats']) ?>>
  <div class="container">
    <div class="row r-gap-40 _pb-50">
      <?php if (get_sub_field('headline')): ?>
        <div class="col-lg-5">
          <?= get_sub_field('headline') ?>
        </div>
      <?php endif ?>
      <?php if (get_sub_field('text')): ?>
        <div class="col-lg-6 offset-lg-1">
          <?= get_sub_field('text') ?>
        </div>
      <?php endif ?>
    </div>
    <div class="row  stats__row text-center r-gap-20">
      <?php while (have_rows('stats')):
        the_row(); ?>
        <div class="col-lg-4">
          <div class="stats__item">
            <div class="stats-sample">
              <?= get_sub_field('stats_prefix') ?>
              <div class="stats-value" data-count="<?= get_sub_field('stats_value') ?>">0</div>
              <?= get_sub_field('stats_postfix') ?>
            </div>
            <?php if (get_sub_field('stats_heading')): ?>
              <h5><?= get_sub_field('stats_heading') ?></h5>
            <?php endif ?>
          </div>
        </div>
      <?php endwhile ?>
    </div>
  </div>
</section>