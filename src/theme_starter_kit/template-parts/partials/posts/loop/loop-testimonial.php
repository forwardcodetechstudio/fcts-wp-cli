<div class="col-lg-12">
	<div class="item">
		<div class="testimonials__box">
			<div class="testimonials__box__head">
				<div class="star-rating">
					<span style="width: <?= get_field( 'rating' ) ?>%;"></span>
				</div>
				<?= get_field( 'text' ) ?>
				<h6><?= get_the_title() ?></h6>
			</div>
			<div class="testimonials__box__body">
				<?php the_post_thumbnail() ?>
			</div>
		</div>
	</div>
</div>