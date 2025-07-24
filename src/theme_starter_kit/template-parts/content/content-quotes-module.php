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
<section <?= module()->settings(['quotes',(get_sub_field('background_image') ? '_shadowed' : '')],'',['--bg-quotes'=>"url(". get_sub_field('background_image').")"]) ?>>
  <div class="container h-100">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8 quotes__text">
        <div class="quotes__content text-white">
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