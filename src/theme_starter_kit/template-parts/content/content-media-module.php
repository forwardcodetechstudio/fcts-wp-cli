<?php

/**
 * Template part for displaying Image Module.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DL_BOILERPLATE
 */

// Fetching modules settings like ID, Padding, Background Color etc.
$to_display = get_sub_field( 'to_display' );
?>
<section <?= module()->settings(['image']) ?>>
	<div class="container">
		<?php if ( get_sub_field( 'text' ) ) : ?>
			<div class="row justify-content-center text-center _pb-50">
				<div class="col-lg-8">
					<?= get_sub_field( 'text' ) ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="row justify-content-center">
			<?php while ( have_rows( 'images' ) ) :
				the_row(); ?>
				<div class="col-lg-6">
					<?php if ( $to_display == 'image' ) : ?>
						<div class="_image">
							<?php display_image( get_sub_field( 'image' ) ) ?>
						</div>
					<?php elseif ( $to_display == 'video' ) : ?>
						<div class="_video">
							<video autoplay playsinline loop muted src="<?= get_sub_field( 'video' )['url'] ?>"
								poster="<?= get_sub_field( 'poster_image' ) ?>"></video>
						</div>
					<?php else : ?>
						<div class="_embed">
							<?= get_sub_field( 'iframe' ) ?>
						</div>
					<?php endif ?>
				</div>
			<?php endwhile ?>
		</div>
	</div>
</section>