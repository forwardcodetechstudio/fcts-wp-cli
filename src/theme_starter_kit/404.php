<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Theme_Name
 */

get_header();

if (get_field('select_404_page', 'option')) : ?>
	<?php
	// ACF Pro loop
	$_404_page = get_field('select_404_page', 'option');
	$post_id = $_404_page[0];
	if (have_rows('layouts', $post_id)) {
		while (have_rows('layouts', $post_id)) {
			the_row();

			$layout_name = str_replace('_', '-', get_row_layout());

			get_template_part('template-parts/content/content', $layout_name);
		}
	}

	?>

<?php else : ?>
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'theme-name'); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'theme-name'); ?></p>

			<?php get_search_form(); ?>

		</div><!-- .page-content -->
	</section><!-- .error-404 -->
<?php endif;
get_footer();
