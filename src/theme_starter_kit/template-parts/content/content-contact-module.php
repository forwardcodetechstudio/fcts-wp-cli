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
<section <?= module()->settings(['contact-us']) ?>>
  <div class="container">
    <div class="row r-gap-40 justify-content-center">
      <div class="col-lg-8">
        <?= get_sub_field('shortcode') ?>
      </div>
    </div>
  </div>
</section>