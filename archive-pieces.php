<?php get_header() ?>

<div class="c-pieces">
	<div class="c-page-header">

		<div id="hw_pieces_current_container" class="c-pieces__current-container">

			<div id="hw_pieces_current_image_container" class="c-pieces__image-container">
				<img class="c-pieces__image" src="">
			</div>

			<div id="hw_pieces_current_title" class="c-pieces__title-container">
				<div class="c-pieces__title-container-inner"><?php pll_e('Current Pieces'); ?></div>
			</div>

			<ul id="hw_pieces_past_list" class="c-pieces__list">
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php if ( !get_field('is_active') ) : ?>

							<li class="c-pieces__list-item">
								<a
									class="c-pieces__link"
									href="<?php the_permalink(); ?>"
									data-image="<?php echo wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)),  'medium_large')[0] ?>"
								>
									<?php the_title(); ?>
								</a>
							</li>

						<?php endif; ?>

					<?php endwhile; ?>
					
				<?php endif; ?>
			</ul>

		</div>

		<div id="hw_pieces_past_container" class="c-pieces__past-container">

			<div id="hw_pieces_past_image_container" class="c-pieces__image-container">
				<img class="c-pieces__image" src="">
			</div>

			<div  id="hw_pieces_past_title" class="c-pieces__title-container c-pieces__title-container--inverse">
				<div class="c-pieces__title-container-inner"><?php pll_e('Past Pieces'); ?></div>
			</div>

			<ul id="hw_pieces_current_list" class="c-pieces__list">
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php if ( get_field('is_active') ) : ?>

							<li class="c-pieces__list-item">
								<a
									class="c-pieces__link"
									href="<?php the_permalink(); ?>"
									data-image="<?php echo wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)),  'medium_large')[0] ?>"
								>
									<?php the_title(); ?>
								</a>
							</li>

						<?php endif; ?>

					<?php endwhile; ?>
					
				<?php endif; ?>
			</ul>

		</div>

	</div>
</div>

<?php get_footer() ?>