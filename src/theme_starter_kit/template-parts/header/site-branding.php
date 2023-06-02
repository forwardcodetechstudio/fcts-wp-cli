<?php

/**
 * Template part for displaying branding.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */

?>

<a href="<?php echo esc_url(home_url('/')); ?>">
    <?php
    if (get_field('logo', 'option')) {
        $attachment_id = get_field('logo', 'option')['id'] ?? null;
        $size = "full"; // (thumbnail, medium, large, full or custom size)
        echo wp_get_attachment_image($attachment_id, $size, false, ['class' => 'logo--gray']);
    }
    if (get_field('logo_white', 'option')) {
        $attachment_id = get_field('logo_white', 'option')['id'] ?? null;
        $size = "full"; // (thumbnail, medium, large, full or custom size)
        echo wp_get_attachment_image($attachment_id, $size, false, ['class' => 'logo--white']);
    }
    ?>
</a>