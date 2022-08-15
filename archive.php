<?php get_header() ?>

<section class="section">
<div class="section__inner">
	<div class="c-news">
		<div class="c-news__title-bar">
			<div class="c-news__title-container c-news__title-container--green">
				<h1 class="c-news__title">News template ARCHIVE.PHP</h1>
			</div>
			<div class="c-news__image-container">
				<img class="c-news__image" src="https://api.lorem.space/image/fashion?w=640&h=480" alt="">
			</div>
		</div>

		<?php if ($the_query->have_posts()) : ?>
			<div class="c-news__featured">
				<?php while($the_query->have_posts()) : $the_query->the_post(); ?>
				<a href="#" class="c-news__featured-item">
					<div class="c-news__title-container">
						<h2 class="c-news__title">Z News Title</h2>
						<div class="c-news__title">02/08</div>
					</div>
					<div class="c-news__image-container">

					</div>
				</a>
				<a href="#" class="c-news__featured-item">
					<div class="c-news__title-container c-news__title-container--gray">
						<h2 class="c-news__title">Z News Title</h2>
						<div class="c-news__title">02/08</div>
					</div>
					<div class="c-news__image-container">
						<img class="c-news__image" src="https://api.lorem.space/image/fashion?w=640&h=480" alt="">
					</div>
				</a>
				<a href="#" class="c-news__featured-item">
					<div class="c-news__title-container c-news__title-container--gray">
						<h2 class="c-news__title">Z News Title</h2>
						<div class="c-news__title">02/08</div>
					</div>
					<div class="c-news__image-container">
						<img class="c-news__image" src="https://api.lorem.space/image/fashion?w=640&h=480" alt="">
					</div>
				</a>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<div class="c-news__list">
			<div class="c-news__list-item">
				<h2 class="c-news__title c-news__title--small">C NEWS TITLE</h2>
				<div class="c-news__title c-news__title--small">02/08</div>
			</div>
			<div class="c-news__list-item">
				<h2 class="c-news__title c-news__title--small">C NEWS TITLE</h2>
				<div class="c-news__title c-news__title--small">02/08</div>
			</div>
			<div class="c-news__list-item">
				<h2 class="c-news__title c-news__title--small">C NEWS TITLE</h2>
				<div class="c-news__title c-news__title--small">02/08</div>
			</div>
			<div class="c-news__list-item">
				<h2 class="c-news__title c-news__title--small">C NEWS TITLE</h2>
				<div class="c-news__title c-news__title--small">02/08</div>
			</div>
			<div class="c-news__list-item">
				<h2 class="c-news__title c-news__title--small">C NEWS TITLE</h2>
				<div class="c-news__title c-news__title--small">02/08</div>
			</div>
			<div class="c-news__list-item">
				<h2 class="c-news__title c-news__title--small">C NEWS TITLE</h2>
				<div class="c-news__title c-news__title--small">02/08</div>
			</div>
		</div>
	</div>
</div>
</section>

<?php get_footer() ?>