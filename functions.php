<?php

include('functions/wpbc_realstate.php');

include('functions/textdomain.php'); 

include('functions/theme-options.php'); 

include('functions/layout.php'); 

include('functions/enqueue_scripts.php'); 




add_action('wpbc/layout/start', function(){

	//global $wp_query; 
	//echo "<pre>";
	//print_r($wp_query);
	//echo "</pre>";

}, 5.4 ); 

function WPBC_realstate_custom_pre_get_posts( $query ) {
	
	if ( is_admin() || ! $query->is_main_query() ) return;
	
	if ( $query->is_main_query() ) {
	        //$query->set( 'cat', '-1,-1347' );
	    	$s = $_GET["order"];
	    	if( $s ){
	    		//$query->set( 'order', 'ASC' ); 
	    	} 

    }
}
// add_action( 'pre_get_posts', 'WPBC_realstate_custom_pre_get_posts' );