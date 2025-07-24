<?php

/**
 * Functions which enhance the theme by customizing tiny mce.
 *
 * @package Necca
 */

function wpb_mce_buttons_2($buttons)
{
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

/*
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats($init_array)
{

	// Define the style_formats array

	$style_formats = array(

		/*
		* Each array child is a format with it's own settings
		* Notice that each array has title, block, classes, and wrapper arguments
		* Title is the label which will be visible in Formats menu
		* Block defines whether it is a span, div, selector, or inline style
		* Classes allows you to define CSS classes
		* Wrapper whether or not to add a new block-level element around any selected elements
		*/

		array(
			'title' => 'Paragraph Note',
			'block' => 'p',
			'classes' => 'note',
			'wrapper' => false,
		),
		array(
			'title' => 'List Block Blue Circle (One Column)',
			'block' => 'div',
			'classes' => 'list-block ul-circle',
			'wrapper' => true,
		),
		array(
			'title' => 'List Block Green Circle (One Column)',
			'block' => 'div',
			'classes' => 'list-block ul-circle ul-circle_green',
			'wrapper' => true,
		),
		array(
			'title' => 'List Block Arrows With Subtitle Wine (One Column)',
			'block' => 'div',
			'classes' => 'list-block ul-arrows subtitle-wine',
			'wrapper' => true,
		),
		array(
			'title' => 'List Block Arrows With Subtitle Wine (Two Columns)',
			'block' => 'div',
			'classes' => 'list-block ul-arrows list-two-cols subtitle-wine',
			'wrapper' => true,
		),
		array(
			'title' => 'Ordered List Block (One Column)',
			'block' => 'div',
			'classes' => 'list-block text-text_location',
			'wrapper' => true,
		),
		array(
			'title' => 'Ordered List Block (Two Columns)',
			'block' => 'div',
			'classes' => 'list-block list-two-cols text-text_location',
			'wrapper' => true,
		),
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode($style_formats);

	return $init_array;
}
// Attach callback to 'tiny_mce_before_init' 
add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');


/**
 * Use main stylesheet for visual editor
 * @see resources/assets/styles/layouts/_tinymce.scss
 */
add_editor_style(get_template_directory_uri() . '/style-mce.css');
