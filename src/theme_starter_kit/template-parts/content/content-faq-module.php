<?php

/**
 * Template part for displaying Contact Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>
<section <?= module()->settings(['faq']) ?>>
  <div class="container">
    <div class="row justify-content-between r-gap-20">
      <?php if (get_sub_field('text')): ?>
        <div class="col-lg-4">
          <?= get_sub_field('text') ?>
        </div>
      <?php endif; ?>
      <div class="col-lg-7 selector-contents-wrapper content-show-hide">
        <div class="accordion selector-content">
          <?php while (have_rows('faqs')):
            the_row(); ?>
            <div class="item">
              <<?= get_sub_field('tag') ?> class="toggle"><?= get_sub_field('headline') ?></<?= get_sub_field('tag') ?>>
              <div class="inner">
                <?= get_sub_field('text') ?>
              </div>
            </div>
          <?php endwhile ?>
        </div>
      </div>
    </div>
  </div>
</section>