<div class="col-lg-6">
	<a href="<?= get_the_permalink() ?>">
		<div class="job__item">
			<div class="job__head">
				<h4><?= get_the_title() ?></h4>
			</div>
			<div class="job__body">
				<div class="_icon-text">
					<div class="_item">
						<img src="<?= THEME_ICON_URI ?>/icons/time.svg" alt="">
						<span><?= get_field( 'job_type' ) ?></span>
					</div>
					<div class="_item">
						<img src="<?= THEME_ICON_URI ?>/icons/map.svg" alt="">
						<span><?= get_field( 'job_location' ) ?></span>
					</div>
				</div>
				<?php if ( get_field( 'text' ) ) : ?>
					<?= get_field( 'text' ) ?>
				<?php endif ?>
			</div>
		</div>
	</a>
</div>