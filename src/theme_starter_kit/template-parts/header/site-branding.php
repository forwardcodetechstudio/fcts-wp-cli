<?php

/**
 * Template part for displaying branding.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

?>

<a href="<?php echo esc_url(home_url('/')); ?>">
  <?php //
  if (get_field('header_logo_logo', 'option')) {
    $attachment_id = get_field('header_logo_logo', 'option')['id'] ?? null;
    $size = "medium"; // (thumbnail, medium, large, full or custom size)
    echo wp_get_attachment_image($attachment_id, $size, false, ['class' => 'light-logo']);
  }
  ?>
</a>