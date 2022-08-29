<?php get_header() ?>

<?php

if ( have_posts() ) :

	$filter_date = null;
	$filter_type = null;
	$filter_piece = null;

	if( get_query_var('date') ) :
		$filter_date = get_query_var('date');
	endif;

	if( get_query_var('type') ) :
		$filter_type = get_query_var('type');
	endif;

	if( get_query_var('piece') ) :
		$filter_piece = get_query_var('piece');
	endif;

	$formatted_press_items = [];
	$year_list = [];
	$piece_list = [];

		foreach ($posts as $press_item) :

			$formatted_press_item = [
				'id' 		=> $press_item->ID,
				'title'		=> $press_item->post_title,
				// 'location' => get_field('location', $performance),
				// 'event_url' => get_field('event_url', $performance),
				'year' 		=> date('Y', (strtotime(get_field('date', $press_item)))),
				'type' 		=> get_field('type', $press_item),
				'piece' 	=> [
					'title' => get_field('piece', $press_item)->post_title,
					'slug' 	=> get_field('piece', $press_item)->post_name
				],
				'sources' 	=> get_field('sources', $press_item),
				'content' 	=> $press_item->post_content,
				// 'full_date_string' => date('Y.m.d.', (get_field('date', $performance)));
			];
			array_push($formatted_press_items, $formatted_press_item);

			if(!in_array(
				[
					'title' => get_field('piece', $press_item)->post_title,
					'slug' 	=> get_field('piece', $press_item)->post_name
				],
				$piece_list,
				true
			) && get_field('piece', $press_item)->post_title !== null
				) :
				array_push($piece_list, [
					'title' => get_field('piece', $press_item)->post_title,
					'slug' 	=> get_field('piece', $press_item)->post_name
				]);
			endif;

			if(!in_array(date('Y', (strtotime(get_field('date', $press_item)))), $year_list, true)) :
				array_push($year_list, date('Y', (strtotime(get_field('date', $press_item)))));
			endif;

		endforeach;
  
	wp_reset_postdata();
	  
  
endif;

?>

<div class="c-press">
	<div class="c-press__header">
		<div class="c-press__header-inner">
			<div class="c-color-box">
				<div class="c-color-box__inner">
					<h1>Sajtó</h1>
				</div>
			</div>
			<div class="c-press__filters">

				<div class="c-press__filter-group">

					<?php if($year_list) : ?>

						<button class="c-press__button <?php echo $filter_date ? 'c-press__button--active' : ''; ?>">
							<a <?php echo $filter_date ? 'href="' . strip_param_from_url(home_url( add_query_arg( NULL, NULL ) ), 'date') . '"' : ''; ?>>
								<svg class="c-press__button-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="6.85938" y="0.864441" width="2.99514" height="15" fill="black"/>
									<rect x="15.8398" y="6.86365" width="3" height="14.9757" transform="rotate(90 15.8398 6.86365)" fill="black"/>
								</svg>
							</a>
							Megjelenés dátuma szerint
						</button>
						<div class="c-press__filter-list c-press__filter-list--years">

						<?php foreach ($year_list as $year) : ?>

							<a
								class="c-press__filter-item c-press__filter-item--years <?php echo $filter_date === $year ? 'c-press__filter-item--active' : ''; ?>"
								href="?<?=add_or_replace_url_param(array('date' => $year))?>"
							>
								<?php echo $year ?>
							</a>

						<?php endforeach; ?>

						</div>

					<?php endif; ?>

					<button class="c-press__button c-press__button--has-bottom-margin <?php echo ($filter_type == 'interview') ? 'c-press__button--active' : ''; ?>">
						<a <?php echo $filter_type ? 'href="' . strip_param_from_url(home_url( add_query_arg( NULL, NULL ) ), 'type') . '"' : ''; ?>>
							<svg class="c-press__button-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="6.85938" y="0.864441" width="2.99514" height="15" fill="black"/>
								<rect x="15.8398" y="6.86365" width="3" height="14.9757" transform="rotate(90 15.8398 6.86365)" fill="black"/>
							</svg>
						</a>
						<a href="?<?=add_or_replace_url_param(array('type' => 'interview'))?>">
							Interjúk
						</a>
					</button>
					<button class="c-press__button c-press__button--has-bottom-margin <?php echo ($filter_type == 'review') ? 'c-press__button--active' : ''; ?>">
						<a <?php echo $filter_type ? 'href="' . strip_param_from_url(home_url( add_query_arg( NULL, NULL ) ), 'type') . '"' : ''; ?>>
							<svg class="c-press__button-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="6.85938" y="0.864441" width="2.99514" height="15" fill="black"/>
								<rect x="15.8398" y="6.86365" width="3" height="14.9757" transform="rotate(90 15.8398 6.86365)" fill="black"/>
							</svg>
						</a>
						<a href="?<?=add_or_replace_url_param(array('type' => 'review'))?>">
							Kritikák
						</a>
					</button>
				</div>
				<div class="c-press__filter-group">

					<?php if($piece_list) : ?>


						<button class="c-press__button <?php echo $filter_piece ? 'c-press__button--active' : ''; ?>">
							<a <?php echo $filter_piece ? 'href="' . strip_param_from_url(home_url( add_query_arg( NULL, NULL ) ), 'piece') . '"' : ''; ?>>
								<svg class="c-press__button-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="6.85938" y="0.864441" width="2.99514" height="15" fill="black"/>
									<rect x="15.8398" y="6.86365" width="3" height="14.9757" transform="rotate(90 15.8398 6.86365)" fill="black"/>
								</svg>
							</a>
							Előadás szerint
						</button>
						<div class="c-press__filter-list c-press__filter-list--pieces">

						<?php foreach ($piece_list as $piece) : ?>

							<a
								class="c-press__filter-item c-press__filter-item--pieces <?php echo $filter_piece == $piece['slug'] ? 'c-press__filter-item--active' : ''; ?>"
								href="?<?=add_or_replace_url_param(array('piece' => $piece['slug']))?>"
							>
								<?php echo $piece['title'] ?>
							</a>

						<?php endforeach; ?>

						</div>

					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
	<div class="c-press__list-container">
		<?php if($formatted_press_items) : ?>

			<?php if( $filter_date ) :

				$formatted_press_items = array_filter($formatted_press_items, function ($item) use ($filter_date) {
					if($item['year'] == $filter_date){
						return $item;
					  }
				});

			endif; ?>

			<?php if( $filter_piece) :

				$formatted_press_items = array_filter($formatted_press_items, function ($item) use ($filter_piece) {
					if($item['piece']['slug'] == $filter_piece){
						return $item;
					}
				});

			endif; ?>

			<div class="c-press__list-header">
				<div class="c-press__list-header-item">Források</div>
				<div class="c-press__list-header-item">Kritikák</div>
			</div>
			
			<ul class="c-press__list">

				<?php foreach ($formatted_press_items as $press_item) : ?>

					<li class="c-press__item">
						<div>
							<?php echo $press_item['sources']?>
						</div>
						<div>
							<?php echo $press_item['content']?>
						</div>
					</li>

				<?php endforeach; ?>

			</ul>

			<?php if(count($formatted_press_items) == 0) : ?>

				<div>Nincs a szűrési feltételeknek megfelelő találat.</div>

			<?php endif; ?>

		<?php endif; ?>
	</div>
</div>

<?php get_footer() ?>