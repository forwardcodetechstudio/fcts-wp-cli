<div class="col-sm-6 col-lg-4 col-xl-3">
	<div class="team__box">
		<?php the_post_thumbnail() ?>
		<div class="team__box__body">
			<h4><?= get_the_title() ?></h4>
			<?php if ( get_field( 'job_position' ) ) : ?>
				<p><?= get_field( 'job_position' ) ?></p>
			<?php endif ?>
			<?php if ( have_rows( 'social_links' ) ) : ?>
				<div class="team__links">
					<?php while ( have_rows( 'social_links' ) ) :
						the_row(); ?>
						<a href="<?= get_sub_field( 'link' ) ?>" target="_blank">
							<?php
							$attachment_id = get_sub_field( 'icon' ) ?? null;
							$size = "full"; // (thumbnail, medium, large, full or custom size)
							echo wp_get_attachment_image( $attachment_id, $size );
							?>
						</a>
					<?php endwhile ?>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>