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
					class="c-piece__image lazyload"
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
				<div class="c-piece__content">
					<?php the_content(); ?>
				</div>
			</div>

		</div>
	</div>

<?php get_footer() ?>