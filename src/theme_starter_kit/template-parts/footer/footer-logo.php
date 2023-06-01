<?php

/**
 * Template part for displaying footer logo.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

?>

<a href="<?php echo esc_url(home_url('/')); ?>">
    <?php
    if (get_field('footer_logo', 'option')) {
        $attachment_id = get_field('footer_logo', 'option')['id'] ?? null;
        $size = "full"; // (thumbnail, medium, large, full or custom size)
        echo wp_get_attachment_image($attachment_id, $size);
    }
    ?>
</a>