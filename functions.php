<?php

// funtions.php is empty so you can easily track what code is needed in order to Vite + Tailwind JIT run well


// Main switch to get fontend assets from a Vite dev server OR from production built folder
// it is recommeded to move it into wp-config.php
define('IS_VITE_DEVELOPMENT', true);


include 'inc/inc.vite.php';


// Register Menus
function my_custom_menu() {
  register_nav_menu('primary_menu',__( 'Primary Menu' ));
}
add_action( 'init', 'my_custom_menu' );

// Add custom menu classes.

function add_id_and_classes_to_page_menu( $ulclass ) {
  return preg_replace( '/<ul>/', '<ul class="c-main-navigation__list">', $ulclass, 1 );
}
add_filter( 'wp_page_menu', 'add_id_and_classes_to_page_menu' );

function special_nav_class($classes, $item, $args) {
	if($args->theme_location === 'primary_menu') {
		if($item->menu_item_parent > 0) {
			if (in_array('current-menu-item', $classes) ){
				$classes[] = 'c-main-navigation__item c-main-navigation__item--sub c-main-navigation__item--active ';
			} else {
				$classes[] = 'c-main-navigation__item c-main-navigation__item--sub';
			}
		} else {
			if (in_array('current-menu-item', $classes) ){
				$classes[] = 'c-main-navigation__item c-main-navigation__item--active ';
			} else {
				$classes[] = 'c-main-navigation__item';
			}
		}
	} else if($args->theme_location === 'secondary') {
		if($item->menu_item_parent > 0) {
			if (in_array('current-menu-item', $classes) ){
				$classes[] = 'c-secondary-navigation__item c-secondary-navigation__item--sub c-secondary-navigation__item--active ';
			} else {
				$classes[] = 'c-secondary-navigation__item c-secondary-navigation__item--sub';
			}
		} else {
			if (in_array('current-menu-item', $classes) ){
				$classes[] = 'c-secondary-navigation__item c-secondary-navigation__item--active ';
			} else {
				$classes[] = 'c-secondary-navigation__item';
			}
		}
	}
	return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 3);

function add_menu_link_class($atts, $item, $args) {
	if($args->theme_location === 'primary_menu') {
		$atts['class'] = 'c-main-navigation__link';
	} else if($args->theme_location === 'secondary') {
		$atts['class'] = 'c-secondary-navigation__link';
	}
	return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth = 0, $args = array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"c-main-navigation__sub-list\">\n";
  }
};

// Pretty dump for debug
function pretty_dump($data) {
	highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
};

// Add post thumbnail support
add_theme_support('post-thumbnails');

// add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    echo basename($template);
}

// Group arrays by key
function groupBy($arr, $criteria): array
{
		return array_reduce($arr, function($accumulator, $item) use ($criteria) {
				$key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
				if (!array_key_exists($key, $accumulator)) {
						$accumulator[$key] = [];
				}

				array_push($accumulator[$key], $item);
				return $accumulator;
		}, []);
};

// Redirect CPT single posts
add_action( 'template_redirect', function() {
	$post_type = 'staff';
	if ( is_singular($post_type) ) {
		global $post;
		$redirectLink = get_post_type_archive_link( $post_type );
		wp_redirect( $redirectLink, 302 );
		exit;
	};
});

add_action( 'template_redirect', function() {
	$post_type = 'performances';
	if ( is_singular($post_type) ) {
		global $post;
		$redirectLink = get_post_type_archive_link( $post_type );
		wp_redirect( $redirectLink, 302 );
		exit;
	};
});

add_action( 'template_redirect', function() {
	$post_type = 'cocreators';
	if ( is_singular($post_type) ) {
		global $post;
		$redirectLink = get_post_type_archive_link( $post_type );
		wp_redirect( $redirectLink, 302 );
		exit;
	};
});

// function wpa_parse_query( $query ){
// 	if( is_singular() && isset( $query->query_vars['cpt_history'] ) ){
// 			wp_redirect( home_url() );
// 	}
// }
// add_action( 'parse_query', 'wpa_parse_query' );

// Find closest date to date from array
function find_closest($array, $date)
{
	$items = [];
    foreach($array as $index => $item)
    {
		array_push($items, [
			'distance' => abs(intval($date) - intval($item['date'])),
			'id' => $item['id']
		]);
    }

	uasort($items,function($a,$b){
		return strcmp($a['distance'], $b['distance']);
	});

	foreach ($array as $item)
	{
	  if ($item['id'] == reset($items)['id'])
		return $item;
	}
};

// Custom query params
add_action('init','add_get_val');
function add_get_val() { 
    global $wp; 
    $wp->add_query_var('date'); 
    $wp->add_query_var('piece'); 
    $wp->add_query_var('type'); 
};

// Strip off URL parameter
function strip_param_from_url($url, $param) {
	$base_url = strtok($url, '?');                   // Get the base URL
	$parsed_url = parse_url($url);                   // Parse it
	if(array_key_exists('query',$parsed_url)) {       // Only execute if there are parameters
			$query = $parsed_url['query'];               // Get the query string
			parse_str($query, $parameters);              // Convert Parameters into array
			unset($parameters[$param]);                  // Delete the one you want
			$new_query = http_build_query($parameters);  // Rebuilt query string
			$url =$base_url.'?'.$new_query;              // Finally URL is ready
	}
	return $url;
}

// Add or replace URL parameter
function add_or_replace_url_param($add_to, $rem_from = array(), $clear_all = false){
	if ($clear_all){
			$query_string = array();
	} else {
			parse_str($_SERVER['QUERY_STRING'], $query_string);
	}
	if (!is_array($add_to)){ $add_to = array(); }
	$query_string = array_merge($query_string, $add_to);
	if (!is_array($rem_from)){ $rem_from = array($rem_from); }
	foreach($rem_from as $key){
			unset($query_string[$key]);
	}
	return http_build_query($query_string);
}

// Add Polylang string translations
add_action('init', function() {
  pll_register_string('archive_pieces', 'Current Pieces', 'hod');
  pll_register_string('archive_pieces', 'Past Pieces', 'hod');
  pll_register_string('single_piece_button_video', 'Videos', 'single_piece');
  pll_register_string('single_piece_button_gallery', 'Gallery', 'single_piece');
  pll_register_string('single_piece_button_background', 'Background', 'single_piece');
  pll_register_string('single_piece_button_press', 'Press', 'single_piece');
  pll_register_string('page_title_staff', 'Staff', 'staff');
  pll_register_string('page_title_cocreators', 'Co-Creators', 'cocreators');
  pll_register_string('page_title_news', 'News', 'home');
  pll_register_string('page_title_hod', 'Adrienn Hód', 'hod');
  pll_register_string('hod_cv_button', 'Professional biography', 'hod');
  pll_register_string('hod_works_button', 'Motion picture works', 'hod');
});

function get_page_ID() {
  //if on the blog page
	if ( is_home() && ! in_the_loop() ) {
		pretty_dump('is home or is not in the loop');
		pretty_dump(wp_title());
    $ID = get_option('page_for_posts');
	} elseif ( is_post_type_archive()) {
		//reference a custom archive page based it's slug
		//eg. for a 'houses' custom post type, you would create a page called `houses` and store any archive front matter on this page
		$query = get_queried_object();
		$slug = $query->name;
		$pageobj = get_page_by_path($slug);
		$ID = $pageobj->ID;
	} else {
		$ID = get_the_ID();
	}
	return $ID;
}