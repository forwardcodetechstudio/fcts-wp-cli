<?php

/**
 * Custom Button Helper for this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Name
 */

?>

<?php if (have_rows('links')) : ?>
    <?php while (have_rows('links')) : the_row(); ?>
        <a href="<?php the_sub_field('url'); ?>" class="btn" <?= (get_sub_field('open_in_new_window') == 1) ? 'target="_blank"' : ''; ?>><?php the_sub_field('label'); ?></a>
    <?php endwhile; ?>
<?php endif; ?>