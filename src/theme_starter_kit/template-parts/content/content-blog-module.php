<?php

/**
 * Template part for displaying News Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
$args = [
  'post_type' => 'post',
  'post_status' => 'publish',
  'order' => 'DESC',
  'orderby' => 'date',
  'posts_per_page' => -1
];
$skip_post = get_sub_field('skip_selected_post');
$categories = get_sub_field('categories');
if ($categories) {
  $tax_query = ['relation' => 'OR'];
  foreach ($categories as $category) {
    $tax_query[] = [
      'taxonomy' => 'category',
      'field' => 'id',
      'terms' => $category,
    ];
  }
  $args['tax_query'] = $tax_query;
}
$query = new WP_Query($args);
$blogs = $query->posts;
?>
<section <?= module()->settings(['blog']) ?>>
  <div class="container">
    <div class="row">

    </div>

  </div>
</section>