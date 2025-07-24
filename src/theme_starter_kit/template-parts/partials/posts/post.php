<?php
global $post_type;
// debug($post_type);
?>
<div class="row blog__items r-gap-40">
	<?php foreach ( $posts as $key => $post ) :
		setup_postdata( $post );
		// if ( $skip_post ) {
		// 	if ( $post->ID == $skip_post->ID ) {
		// 		continue;
		// 	}
		// }
		?>
    <?php get_template_part("template-parts/partials/posts/loop/loop",$post_type) ?>
	<?php endforeach;
	wp_reset_postdata() ?>
</div>