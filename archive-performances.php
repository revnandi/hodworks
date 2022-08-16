<?php get_header() ?>

<?php
  // Create month name list by locale

  	$locale = pll_current_language('locale');

	$month_lists = [
		'en_GB' => [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'March',
			4 => 'Apr',
			5 => 'May',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Aug',
			9 => 'Sept',
			10 => 'Oct',
			11 => 'Nov',
			12 => 'Dec',
		],
		'hu_HU' => [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Marc',
			4 => 'Ápr',
			5 => 'Máj',
			6 => 'Jún',
			7 => 'Júl',
			8 => 'Aug',
			9 => 'Szept',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Dec',
		]
	];

	$months_locale = $month_lists[$locale];

?>

<?php if ( have_posts() ) :

  $formatted_performances = [];

    foreach ($posts as $performance) :

		$formatted_performance = [
			'id' => $performance->ID,
            'performance_id' => get_field('piece', $performance)->ID,
			'title' => get_field('piece', $performance)->post_title,
			'location' => get_field('location', $performance),
			'event_url' => get_field('event_url', $performance),
			'ticket_url' => get_field('ticket_url', $performance),
      		'date' => get_field('date', $performance),
			'year' => date('Y', (get_field('date', $performance))),
			'full_date_string' => date('Y.m.d.', (get_field('date', $performance)))
		];

		array_push($formatted_performances, $formatted_performance);

    endforeach;

    // Sort array
    usort($formatted_performances, function ($a, $b) {
      return $a['date'] - $b['date'];
    });

    $year_groups = groupBy($formatted_performances, 'year');

    wp_reset_postdata();
    
    $future_performances = array_filter($formatted_performances, function($val){
        return ($val['date'] >= date('U'));
    });

    $latest_performance = find_closest($future_performances, date('U'));

    $latest_performance_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( $latest_performance['id'])), 'lqip');
	$latest_performance_image = wp_get_attachment_image_src((get_post_thumbnail_id( $latest_performance['id'])),  'medium_large');
	$latest_performance_piece_image_lqip = wp_get_attachment_image_src((get_post_thumbnail_id( $latest_performance['performance_id'])), 'lqip');
	$latest_performance_piece_image = wp_get_attachment_image_src((get_post_thumbnail_id( $latest_performance['performance_id'])),  'medium_large');
  ?>

<?php endif; ?>

<div class="c-calendar">
	<div class="c-page-header">
		<div class="c-color-box">
			<div class="c-color-box__inner">
				<h1>Naptár</h1>
			</div>
		</div>
		<div class="c-calendar__image-container">

			<?php if ($latest_performance_image[0]) :?>
				<img
                    class="c-calendar__image lazyload blur-up"
                    src="<?php echo $latest_performance_image_lqip[0] ?>"
                    data-src="<?php echo $latest_performance_image[0] ?>"
                    alt="<?php echo $latest_performance->post_title ?>"
				/>
			<?php elseif ($latest_performance_piece_image[0]) : ?>
                <img
                    class="c-calendar__image lazyload blur-up"
                    src="<?php echo $latest_performance_piece_image_lqip[0] ?>"
                    data-src="<?php echo $latest_performance_piece_image[0] ?>"
                    alt="<?php echo $latest_performance->post_title ?>"
				/>
            <?php endif; ?>
			<div class="c-calendar__image-date-title">
                <span><?php echo date('m', $latest_performance['date'])?>/<?php echo date('d', $latest_performance['date'])?></span>
                <span><?php echo $latest_performance['title']; ?></span>
            </div>
            <div class="c-calendar__image-location"><?php echo $latest_performance['location']; ?></div>
		</div>
	</div>
	<div class="c-calendar__inner">

		<?php if ($year_groups) : $counter = 1 ?>

		<ul id="hw_calendar_years" class="c-calendar__year-list">

			<?php foreach ($year_groups as $key => $table) : ?>

				<li
					id="hw_calendar_year_<?php echo $key ?>"
					class="c-calendar__year <?php echo $counter == 1 ? 'c-calendar__year--active' : null ?>"
					data-year="<?php echo $key ?>"
				>
					<?php echo $key ?>
				</li>

				<?php $counter++; ?>
			<?php endforeach; ?>

		</ul>

		<?php endif ?>

		<div class="c-calendar__table-container">
			<div class="c-calendar__header">
				<div class="c-calendar__header-item">Dátum</div>
				<div class="c-calendar__header-item">PROGRAM</div>
				<div class="c-calendar__header-item">VENUE</div>
			</div>

			<?php if ($year_groups) : $counter = 1 ?>
				<div id="hw_calendar_tables" class="c-calendar__tables">

					<?php foreach ($year_groups as $key => $table) : ?>

						<div
							id="hw_calendar_table_<?php echo $key ?>"
							class="c-calendar__table <?php echo $counter == 1 ? 'c-calendar__table--visible' : null ?>"
							data-year="<?php echo $key ?>"
						>
							<?php $counter++ ?>
							<?php foreach ($table as $row) :?>

								<div class="c-calendar__row">
									<div class="c-calendar__cell c-calendar__cell--uppercase"><?php echo $months_locale[date('n', $row['date'])] ?> <?php echo date('j', $row['date']) ?>.</div>
									<div class="c-calendar__cell c-calendar__cell--uppercase"><?php echo $row['title'] ?></div>
									<div class="c-calendar__cell"><?php echo $row['location'] ?></div>

									<?php if ($row['event_url']) : ?>

										<a
											href="<?php echo $row['event_url'] ?>"
											class="c-calendar__link"
											target="_blank"
										>
											Event
										</a>

									<?php endif ?>

									<?php if ($row['ticket_url']) : ?>
										<a
											href="<?php echo $row['ticket_url'] ?>"
											class="c-calendar__link"
											target="_blank"
										>
											Ticket
										</a>
									<?php endif ?>

								</div>

							<?php endforeach; ?>

						</div>

					<?php endforeach; ?>

				</div>

			<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer() ?>