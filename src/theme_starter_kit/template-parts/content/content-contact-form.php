<?php

/**
 * Template part for displaying Contact Form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

// Fetching modules settings like ID, Padding, Background Color etc.
list($customID, $customClass) = get_modules_settings();

?>

<section class="contact__module position-relative overflow-hidden <?= $customClass; ?>" <?= ($customID) ? 'id="' . $customID . '"' : ''; ?>>
    <div class="container">
        <div class="row">
            <?php if (get_sub_field('headline')) : ?>
                <div class="col-12 section__title heading--color--blue heading__border__bottom border--position--left">
                    <h2><?php the_sub_field('headline') ?></h2>
                </div>
            <?php endif; ?>

            <div class="col-lg-8 col-md-12 mx-auto mt-40 contact__form__block heading--color--blue standard__text position-relative z-index-12">
                <?php the_sub_field('text') ?>
                <?php echo do_shortcode(get_sub_field('form_shortcode')); ?>
            </div>

        </div>
    </div>
</section>