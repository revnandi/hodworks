<?php 
/*
Template Name: Hod Adrienn
*/
?>

<?php get_header() ?>

<?php
  $post_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)), 'lqip');
  $post_image = wp_get_attachment_image_src((get_post_thumbnail_id( $post->ID)),  'medium_large');
?>

<div class="c-hod">
	<div class="c-page-header">
		<div class="c-color-box">
			<div class="c-color-box__inner">
				<h1><?php the_title(); ?></h1>
				<div class="c-hod__buttons">
					<button id="hw_hod_cv_button" class="c-hod__button">Szakmai életrajz</button>
					<button id="hw_hod_works_button" class="c-hod__button">Mozgóképes munkák</button>
				</div>
			</div>
		</div>
		<div class="c-hod__image-container">

			<?php if ($post_image[0]) :?>
				<img
					class="c-hod__image lazyload blur-up"
					src="<?php echo $post_image_lqip[0] ?>"
					data-src="<?php echo $post_image[0] ?>"
					alt="<?php echo $post->post_title ?>"
				/>
			<?php endif; ?>
		</div>
	</div>
	<div class="c-hod__columns">

		<div class="c-hod__column c-hod__column--green">
			<div class="c-hod__info">
			</div>
		</div>

		<div class="c-hod__column">
			<div id="hw_hod_content" class="c-hod__content c-hod__content--active">
				<?php the_content(); ?>
			</div>
			<div id="hw_hod_cv" class="c-hod__content">

				<?php if(get_field('cv')) : ?>

					<?php the_field('cv'); ?>

				<?php endif; ?>

			</div>
			<div id="hw_hod_works" class="c-hod__content">

			<?php if( have_rows('works') ) : ?>


				<?php while( have_rows('works') ): the_row();  ?>

					<div class="c-hod__works-container">

						<h2 class="c-hod__works-type">/ <?php the_sub_field('type'); ?></h2>

							<?php if( have_rows('projects') ): ?>

								<div class="c-hod__works-list">

									<?php while( have_rows('projects') ): the_row();

										$link = get_sub_field('title');
										if( $link ): 
											$link_url = $link['url'];
											$link_title = $link['title'];
											$link_target = $link['target'] ? $link['target'] : '_self';
										?>

											<a
												class="c-hod__works-link"
												href="<?php echo esc_url( $link_url ); ?>"
												target="<?php echo esc_attr( $link_target ); ?>"
											>
												<?php echo esc_html( $link_title ); ?>
												<span>
													<?php if(get_sub_field('date')) :
														echo '(' . date('Y', (strtotime(get_sub_field('date')))) . ')';
													endif; ?>
												</span>
												<span>
													<?php if(get_sub_field('extra_info')) :
														echo ' / ' . get_sub_field('extra_info');
													endif; ?>
												</span>
											</a>

										<?php endif; ?>

									<?php endwhile; ?>

								</div>

							<?php endif; ?>

					</div>

				<?php endwhile; ?>

			<?php endif; ?>

			</div>
		</div>

	</div>
</div>

<?php get_footer() ?>