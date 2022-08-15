<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_content(); 
		//
		// Post Content here
    the_title();
		//
	} // end while
} // end if
?>