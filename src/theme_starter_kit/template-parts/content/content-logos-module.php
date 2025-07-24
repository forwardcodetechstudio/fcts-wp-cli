<?php

/**
 * Template part for displaying Logos Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.

?>

<section <?= module()->settings(['logos']) ?>>
  <div class="container">
    <?php if (get_sub_field('headline')): ?>
      <div class="row _pb-25">
        <div class="col">
          <?= get_sub_field('headline') ?>
        </div>
      </div>
    <?php endif ?>
    <div class="row r-gap-20">
      <div class="col">
        <div class="logos__gallery">
          <?php while (have_rows('logos')):
            the_row(); ?>
            <div class="_logo-img">
              <?php if (empty(get_sub_field('link'))): ?>
                <?php
                $attachment_id = get_sub_field('logo') ?? null;
                $size = "full"; // (thumbnail, medium, large, full or custom size)
                echo wp_get_attachment_image($attachment_id, $size);
                ?>
              <?php else: ?>
                <a href="<?php echo esc_url(get_sub_field('link')); ?>" target="_blank">
                  <?php
                  $attachment_id = get_sub_field('logo') ?? null;
                  $size = "full"; // (thumbnail, medium, large, full or custom size)
                  echo wp_get_attachment_image($attachment_id, $size);
                  ?>
                </a>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</section>