<?php get_header() ?>


<div class="c-cocreators">
	<div class="c-cocreators__header">
		<div class="c-color-box">
			<div class="c-color-box__inner">
				<h1><?php pll_e('Co-Creators'); ?></h1>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>

			<ul class="c-cocreators__list">
		
			<?php while ( have_posts() ) : the_post(); ?>
			
				<li class="c-cocreators__list-item">
					<a class="c-cocreators__scroll-link" href="<?php echo '#' . $post->post_name ?>"><?php the_title(); ?></a> <span>+</span>
				</li>

			<?php endwhile; ?>

			</ul>

		<?php endif; ?>

	</div>

	<?php if ( have_posts() ) : ?>

		<ul class="c-cocreators__grid">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
				$post_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)), 'lqip');
				$post_image = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)),  'medium_large');
			?>

			<li id="<?php echo $post->post_name ?>" class="c-cocreators__grid-item">
				<div class="c-cocreators__text-container">
					<h2 class="c-cocreators__title"><?php the_title(); ?></h2>
					<div class="c-cocreators__description">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="c-cocreators__image-container">

					<?php if ($post_image[0]) :?>
						<img
						class="c-cocreators__image lazyload blur-up"
						src="<?php echo $post_image_lqip[0] ?>"
						data-src="<?php echo $post_image[0] ?>"
						alt="<?php echo $post->post_title ?>"
						/>
					<?php endif; ?>

				</div>
			</li>

		<?php endwhile; ?>

		</ul>

	<?php endif; ?>
</div>



<?php get_footer() ?>