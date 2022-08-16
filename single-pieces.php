<?php get_header() ?>

	<?php

		$slug_to_match = $post->post_name;

		$args = array(  
			'post_type' => 'performances',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
	
		$loop = new WP_Query( $args ); 

		$piece_dates = [];
			
		while ( $loop->have_posts() ) : $loop->the_post();

			$piece = get_field('piece');

			
			if ($piece->post_name == $slug_to_match) :
				$piece_to_add = [
					'date' => strtotime($piece->date)
				];
				array_push($piece_dates, $piece_to_add);
			endif;

		endwhile;

		// groupBy($piece_dates, 'date');

		// pretty_dump($piece_dates);
	
		wp_reset_postdata(); 


		$post_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)), 'lqip');
		$post_image = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)),  'medium_large');
	?>

	<div class="c-piece">
		<div class="c-page-header">
			<div class="c-color-box">
				<div class="c-color-box__inner">
					<h1 ><?php the_title(); ?></h1>
				</div>
			</div>
			<div class="c-piece__image-container">

				<?php if ($post_image[0]) :?>
					<img
					class="c-piece__image lazyload blur-up"
					src="<?php echo $post_image_lqip[0] ?>"
					data-src="<?php echo $post_image[0] ?>"
					alt="<?php echo $post->post_title ?>"
					/>
				<?php endif; ?>

				<div class="c-piece__location">Trafó Budapest</div>
				<div class="c-piece__date">03/27</div>
			</div>
		</div>

		<div class="c-piece__columns">

			<div class="c-piece__column c-piece__column--green">
				<div class="c-piece__info">
					<?php the_field('description'); ?>
				</div>
			</div>

			<div class="c-piece__column">
				<div class="c-piece__menu">
						<?php if (get_field('video')) : ?>
							<button id="hw_single_piece_video_button" class="c-piece__menu-button">Videók</button>
						<?php endif; ?>
						<?php if (get_field('gallery')) : ?>
							<button id="hw_single_piece_gallery_button" class="c-piece__menu-button">Galéria</button>
						<?php endif; ?>
						<?php if (get_field('background_info')) : ?>
							<button id="hw_single_piece_background_info_button" class="c-piece__menu-button">Háttér</button>
						<?php endif; ?>
						<button class="c-piece__menu-button">Sajtó</button>
				</div>

				<?php $gallery_images = get_field('gallery');
				if( $gallery_images ): ?>

					<div id="hw_single_piece_galleries_container" class="c-piece__gallery-container c-piece__sub-content">
						<div
							id="hw_single_piece_gallery"
							class="splide c-piece__gallery"
							aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel."
						>
							<div class="splide__track c-piece__gallery-track">
								<ul id="hw_single_piece_gallery_list" class="splide__list c-piece__gallery-list">

									<?php foreach( $gallery_images as $image ): ?>

										<li class="splide__slide c-piece__gallery-slide">
											<a href="<?php echo esc_url($image['url']); ?>" target="_blank">
												<img
													class="lazyload blur-up"
													src="<?php echo esc_url($image['sizes']['lqip']); ?>"
													data-src="<?php echo esc_url($image['sizes']['large']); ?>"
													alt="<?php echo esc_attr($image['alt']); ?>" />
											</a>
											<p><?php echo esc_html($image['caption']); ?></p>
										</li>

									<?php endforeach; ?>

								</ul>
							</div>
						</div>
						<div
							id="hw_single_piece_thumbnail_gallery"
							class="splide c-piece__thumbnail-gallery"
							aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel."
						>
							<div class="splide__track c-piece__thumbnail-gallery-track">
								<ul id="hw_single_piece_thumbnail_gallery_list" class="splide__list c-piece__thumbnail-gallery-list">

									<?php foreach( $gallery_images as $image ): ?>

										<li class="splide__slide c-piece__thumbnail-gallery-slide">
											<img
												class="lazyload blur-up"
												src="<?php echo esc_url($image['sizes']['thumbnail']); ?>"
												data-src="<?php echo esc_url($image['sizes']['thumbnail']); ?>"
												alt="<?php echo esc_attr($image['alt']); ?>" />
											<p><?php echo esc_html($image['caption']); ?></p>
										</li>
										
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>

				<?php endif; ?>

				<?php if( have_rows('video') ): ?>

					<div id="hw_single_piece_videos_container" class="c-piece__sub-content">

						<?php while( have_rows('video') ) : the_row(); ?>

							<div
								id="vimeo_player_<?php the_sub_field('video_url'); ?>"
								class="c-vimeo-player"
								data-code="<?php the_sub_field('video_url'); ?>"
								data-plyr-provider="vimeo"
								data-plyr-embed-id="<?php the_sub_field('video_url'); ?>"
							></div>

						<?php endwhile; ?>

					</div>

				<?php endif; ?>

				<?php if( get_field('background_info') ): ?>

					<div id="hw_background_info_container" class="c-piece__background-info-container c-piece__sub-content">

						<?php the_field('background_info'); ?>

					</div>

				<?php endif; ?>

				<div class="c-piece__content">
					<?php the_content(); ?>
				</div>
			</div>

		</div>
	</div>

<?php get_footer() ?>