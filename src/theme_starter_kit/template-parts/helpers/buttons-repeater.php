<?php

/**
 * Custom Button Helper for this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Theme_Name
 */

?>

<?php if ( have_rows( 'buttons' ) ) : ?>
	<?php while ( have_rows( 'buttons' ) ) :
		the_row();
		$url = get_sub_field( 'link_option' ) === 'internal' ? get_sub_field( 'page_link' ) : get_sub_field( 'url' );
		?>
		<a href="<?= $url ?>" 
      class="btn <?= get_sub_field( 'variant' ) ?> <?= get_sub_field( 'size' ) ?> "
			<?= ( get_sub_field( 'open_in_new_window' ) == 1 ) ? 'target="_blank"' : ''; ?>>
			<?php the_sub_field( 'label' ); ?>
		</a>
	<?php endwhile; ?>
<?php endif; ?>