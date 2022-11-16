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