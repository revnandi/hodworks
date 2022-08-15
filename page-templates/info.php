<?php 
/*
Template Name: Info
*/
?>

<?php get_header() ?>

<div class="c-columns">
	<div class="c-columns__column c-columns__column--green">
		<div class="c-color-box">
			<div class="c-color-box__inner">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<div class="c-columns__column">
		<div class="c-content">
			<?php the_content(); ?>
		</div>
	</div>
</div>


<?php get_footer() ?>