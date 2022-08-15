<?php get_header() ?>

<section class="section">
	<div class="section__inner">
		<div class="c-news">
			<div class="c-news__title-bar">
				<div class="c-news__title-container c-news__title-container--green">
					<h1 class="c-news__title">Hírek</h1>
				</div>
				<div class="c-news__image-container">

					<?php
						$page_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( 80)), 'lqip');
						$page_image = wp_get_attachment_image_src((get_post_thumbnail_id( 80)),  'medium_large');
					?>

					<?php if ($page_image[0]) :?>
						<img
						class="c-news__image lazyload"
						src="<?php echo $page_image_lqip[0] ?>"
						data-src="<?php echo $page_image[0] ?>"
						alt="<?php echo $post->post_title ?>"
						/>
					<?php endif; ?>

				</div>
			</div>

			<?php if ( have_posts() ) : ?>

				<div class="c-news__featured">

					<?php while(have_posts()) : the_post(); ?>

						<?php
							$post_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)), 'lqip');
							$post_image = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)),  'medium_large');
						?>

						<?php if( $wp_query->current_post < 3 ): ?>
							<a href="<?php the_permalink(); ?>" class="c-news__featured-item">
								<div class="c-news__title-container">
									<h2 class="c-news__title"><?php the_title(); ?></h2>
									<div class="c-news__title"><?php echo get_the_date('m'); ?>/<?php echo get_the_date('d'); ?></div>
								</div>
								<div class="c-news__image-container">

									<?php if ($post_image[0]) :?>
										<img
										class="c-news__image lazyload"
										src="<?php echo $post_image_lqip[0] ?>"
										data-src="<?php echo $post_image[0] ?>"
										alt="<?php echo $post->post_title ?>"
										/>
									<?php endif; ?>

								</div>
							</a>
						<?php endif; ?>

					<?php endwhile; ?>

				</div>
				<div class="c-news__list">

					<?php while(have_posts()) : the_post(); ?>

						<?php if( $wp_query->current_post >= 3 ): ?>

							<div class="c-news__list-item">
								<a href="<?php the_permalink(); ?>" class="c-news__list-link">
									<h2 class="c-news__title c-news__title--small"><?php the_title(); ?></h2>
									<div class="c-news__title c-news__title--small"><?php echo get_the_date('m'); ?>/<?php echo get_the_date('d'); ?></div>
								</a>
							</div>

						<?php endif; ?>

					<?php endwhile; ?>

				</div>

			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_footer() ?>