<?php global $post_type,$posts;
?>
<div class="row r-gap-40">
	<?php foreach ( $posts as $post ) :
		setup_postdata( $post ) ?>
  <?php get_template_part("template-parts/partials/posts/loop/loop",$post_type) ?>
	<?php endforeach;
	wp_reset_postdata() ?>
</div>