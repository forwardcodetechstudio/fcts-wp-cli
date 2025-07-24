<div class="col-lg-6">
	<div class="blog__item">
		<div class="blog__img">
			<?php the_post_thumbnail() ?>
		</div>
		<div class="blog__body">
			<h6><?= get_the_category()[0]->name ?></h6>
			<h4><?= get_the_title() ?></h4>
			<p><?= get_the_excerpt() ?></p>
			<div class="btn-wrapper">
				<a href="<?= get_the_permalink() ?>" class="btn btn_purple"><?php _t( 'mehr erfahren' ); ?></a>
			</div>
		</div>
	</div>
</div>