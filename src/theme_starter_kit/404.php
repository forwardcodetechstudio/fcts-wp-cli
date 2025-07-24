<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Theme_Name
 */

get_header();

if ( get_field( '404_errorcode_select_404_page', 'option' ) ) : ?>
	<?php
	// ACF Pro loop
	$_404_page = get_field( '404_errorcode_select_404_page', 'option' );
	$post_id = $_404_page->ID;
	if ( have_rows( 'layouts', $post_id ) ) {
		while ( have_rows( 'layouts', $post_id ) ) {
			the_row();

			$layout_name = str_replace( '_', '-', get_row_layout() );

			get_template_part( 'template-parts/content/content', $layout_name );
		}
	}

	?>

<?php else : ?>
	<section class="error-404 not-found standard-text">
		<div class="container">
			<div class="row">
				<div class="col">
					<?= get_field( '404_errorcode_404_page_text', 'option' ) ?>
				</div>
			</div>
		</div>
	</section><!-- .error-404 -->
<?php endif;
get_footer();
