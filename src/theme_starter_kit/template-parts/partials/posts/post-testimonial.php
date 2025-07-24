<?php global $post_type,$posts;
?>
<div class="row r-gap-20 testimonials-slider testimonials-slider-3 slider-arrows-side">
	<?php foreach ( $posts as $post ) :
		setup_postdata( $post ) ?>
    <?php get_template_part("template-parts/partials/posts/loop/loop",$post_type) ?>
	<?php endforeach;
	wp_reset_postdata() ?>
</div>