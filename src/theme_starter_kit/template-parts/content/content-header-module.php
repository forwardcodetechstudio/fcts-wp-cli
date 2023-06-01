<?php

/**
 * Template part for displaying This Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

// Fetching modules settings like ID, Padding, Background Color etc.
list($customID, $customClass) = modules_settings();

?>

<section class="hero__img__module img-text position-relative d-flex align-items-end overflow-hidden <?= $customClass; ?>" <?= ($customID) ? 'id="' . $customID . '"' : ''; ?>>
    <div class="container-fluid position-relative z-index-12">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-12 img-text__text hero__text__block heading--color--blue text--color--green text-start text--fontweight--lighter pt-60">
                <?php if (get_sub_field('headline')) : ?>
                    <h1><?php the_sub_field('headline') ?></h1>
                <?php endif; ?>
                <?php if (get_sub_field('subline')) : ?>
                    <p><?php the_sub_field('subline') ?></p>
                <?php endif; ?>
                <?php get_template_part('template-parts/helpers/buttons-repeater'); ?>
            </div>
            <div class="col-lg-6 col-md-12  img-text__img hero__img__block pt-100">
                <div class="hero--img--inner">
                    <div class="laptop--img wow fadeInUp" data-wow-duration="1.4s" data-wow-delay="0.6s">
                        <?php
                        if (get_sub_field('image_desktop')) {
                            if (get_sub_field('image_desktop')['subtype'] == 'svg+xml') {
                                echo file_get_contents(get_sub_field('image_desktop')['url']);
                            } else {
                                $attachment_id = get_sub_field('image_desktop')['id'] ?? null;
                                $size = "full"; // (thumbnail, medium, large, full or custom size)
                                echo wp_get_attachment_image($attachment_id, $size);
                            }
                        }
                        ?>
                    </div>
                    <div class="mob--tablet--img wow fadeInUp" data-wow-duration="1.2s" data-wow-delay="1s">
                        <?php
                        if (get_sub_field('image_mobile')) {
                            if (get_sub_field('image_mobile')['subtype'] == 'svg+xml') {
                                echo file_get_contents(get_sub_field('image_mobile')['url']);
                            } else {
                                $attachment_id = get_sub_field('image_mobile')['id'] ?? null;
                                $size = "full"; // (thumbnail, medium, large, full or custom size)
                                echo wp_get_attachment_image($attachment_id, $size);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="circle--shape bg--green"></div>
</section>