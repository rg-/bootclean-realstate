<?php
/* ----------------------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------------------- */


// Use parent styles...
add_filter( 'BC_enqueue_scripts__styles_uri', function($styles_uri){
	$styles_uri = THEME_URI; 
	return $styles_uri;
}, 10,1 );

	function bc_child_wp_enqueue_scripts() {   
		
		/**
		 * Add custom js
		 */ 
		wp_register_script( 'realstate-customs', get_stylesheet_directory_uri() .'/js/customs.js', array('jquery','main'), null, true);
		wp_enqueue_script( 'realstate-customs' ); 
 
	}
	add_action( 'wp_enqueue_scripts', 'bc_child_wp_enqueue_scripts', 0 );

 

/* ----------------------------------------------------------------------------------------------- */ 
/* ----------------------------------------------------------------------------------------------- */