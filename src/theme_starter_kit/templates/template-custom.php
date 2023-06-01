<?php

/**
 * Template Name: Custom Template
 * The template for displaying Custom Template Page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme_Name
 */


get_header(); // Template Header File.

// ACF Pro loop
if (have_rows('layouts')) {
    while (have_rows('layouts')) {
        the_row();

        $layout_name = str_replace('_', '-', get_row_layout());

        get_template_part('template-parts/content/content', $layout_name);
    }
}

get_footer(); // Template Footer File.
