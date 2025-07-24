<?php

/**
 * Template part for displaying footer logo.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

?>
<?php if (get_field('footer_logo_logo', 'option')) : ?>
<div class="footer__logo">
    <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php
        if (get_field('footer_logo_logo', 'option')) {
            $attachment_id = get_field('footer_logo_logo', 'option')['id'] ?? null;
            $size = "full"; // (thumbnail, medium, large, full or custom size)
            echo wp_get_attachment_image($attachment_id, $size);
        }
        ?>
    </a>
</div>
<?php endif; ?>