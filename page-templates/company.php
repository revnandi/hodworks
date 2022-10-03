<?php 
/*
Template Name: Company
*/
?>

<?php get_header() ?>

	<div class="c-company">
		<div class="c-columns">
			<div class="c-columns__column c-columns__column--green c-columns__column--mobile-row">
				<div class="c-color-box">
					<div class="c-color-box__inner">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
				<div class="c-company__list-container">

					<?php if( have_rows('years') ): ?>

						<ul id="hw_company_list" class="c-company__list">

						<?php while( have_rows('years') ) : the_row(); ?>

							<li class="c-company__item">

								<h3 class="c-company__year"><?php echo the_sub_field('year'); ?></h3>

								<div class="c-company__year-description"><?php echo the_sub_field('description'); ?></div>

							</li>

						<?php endwhile; ?>

						</ul>

					<?php endif; ?>

				</div>
			</div>
			<div class="c-columns__column">
				<div id="hw_company_text_container_alt" class="c-company__text-container-alt">
				</div>
				<div id="hw_company_text_container" class="c-company__text-container">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer() ?>