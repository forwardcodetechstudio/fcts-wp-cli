<?php

/**
 * Template part for displaying Logos Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
$components = get_sub_field('components');
$related_field_id = $components->ID;
if ($related_field_id && have_rows('layouts', $related_field_id)) {
  // Loop through the rows
  while (have_rows('layouts', $related_field_id)) {
    the_row();
    // Get layout name
    $layout_name = str_replace('_', '-', get_row_layout());
    // Include content file
    get_template_part('template-parts/content/content', $layout_name);
  }
} else {
  echo 'No layouts found in the related post.';
}

?>