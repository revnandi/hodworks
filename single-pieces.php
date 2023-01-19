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
					'date' => get_field('date'),
					'location' => get_field('location')
				];
				array_push($piece_dates, $piece_to_add);
			endif;

		endwhile;

		$date_and_location_to_display = array_reduce($piece_dates, function ($a, $b) {
			return @$a['date'] > $b['date'] ? $a : $b ;
		});
	
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
				
				<?php if($date_and_location_to_display): ?>

					<div class="c-piece__location"><?php echo $date_and_location_to_display['location']; ?></div>
					<div class="c-piece__date"><?php echo date('m/d', date($date_and_location_to_display['date'])); ?></div>

				<?php endif; ?>
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
							<button id="hw_single_piece_video_button" class="c-piece__menu-button"><?php pll_e('Videos'); ?></button>
						<?php endif; ?>
						<?php if (get_field('gallery')) : ?>
							<button id="hw_single_piece_gallery_button" class="c-piece__menu-button"><?php pll_e('Gallery'); ?></button>
						<?php endif; ?>
						<?php if (get_field('background_info')) : ?>
							<button id="hw_single_piece_background_info_button" class="c-piece__menu-button"><?php pll_e('Background'); ?></button>
						<?php endif; ?>
						<?php if (get_field('background_info')) : ?>
							<button id="hw_single_piece_description_button" class="c-piece__menu-button c-piece__menu-button--hidden"><?php pll_e('Description'); ?></button>
						<?php endif; ?>
						<button class="c-piece__menu-button"><?php pll_e('Press'); ?></button>
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
											<img
												class="lazyload blur-up"
												data-sizes="auto"
												data-bp="<?php echo esc_url($image['sizes']['1536x1536']); ?>"
												src="<?php echo esc_url($image['sizes']['lqip']); ?>"
												data-srcset="<?php echo esc_url($image['sizes']['thumbnail']); ?> 150w,
													<?php echo esc_url($image['sizes']['medium']); ?> 300w,
													<?php echo esc_url($image['sizes']['medium_large']); ?> 768w,
													<?php echo esc_url($image['sizes']['large']); ?>  1024w,
													<?php echo esc_url($image['sizes']['1536x1536']); ?> 1536w,
													<?php echo esc_url($image['sizes']['2048x2048']); ?> 2048w"
												alt="<?php echo esc_attr($image['alt']); ?>" />
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