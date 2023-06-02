<?php

/**
 * Template Name: Custom Template
 * The template for displaying Custom Template Page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Theme_Name
 */

// Include Header File
get_header();

// Check if there are any rows in ACF Pro loop
if ( have_rows( 'layouts' ) ) {

	// Loop through the rows
	while ( have_rows( 'layouts' ) ) {
		the_row();

		// Get layout name
		$layout_name = str_replace( '_', '-', get_row_layout() );

		// Include content file
		get_template_part( 'template-parts/content/content', $layout_name );
	}
}

// Include Footer File
get_footer();
