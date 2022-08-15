<?php
  	$main_menu = wp_nav_menu( array( 
		'theme_location' => 'primary_menu',
		'fallback_cb'   => false,
		'container' => 'nav',
		'container_class' => 'c-main-navigation',
		'container_id' => 'hodworks_menu',
		'menu_class' => 'c-main-navigation__list',
		'walker' => new My_Walker_Nav_Menu() ) );
?>