<?php

/**
 * Displays the site header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

?>
<header class="header">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-6 col-lg-4 header__logo">
        <?php get_template_part('template-parts/header/site', 'branding') ?>
      </div>
      <div class="col-6 col-lg-8 d-flex justify-content-end align-items-center">
        <nav class="navbar">
          <?php get_template_part('template-parts/header/site', 'nav') ?>
          <div class="header__btns">
            <?php if (have_rows('header_buttons', 'option')): ?>
              <?php while (have_rows('header_buttons', 'option')):
                the_row(); ?>
                <a href="<?php the_sub_field('url'); ?>" class="btn <?= get_sub_field('variant') ?>"
                  <?= (get_sub_field('open_in_new_window') == 1) ? 'target="_blank"' : ''; ?>><?php the_sub_field('label'); ?></a>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </nav>
        <button class="menu-trigger">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </div>
</header>