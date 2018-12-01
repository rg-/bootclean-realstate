<?php


add_filter('wpbc/filter/layout/main-navbar/defaults', function($args){ 
	$args['class'] = 'gpx-1 gpx-sm-0 navbar navbar-dark bg-primary navbar-expand-lg navbar-expand-aside collapse-right'; 
	$args['navbar_toggler']['type'] = 'animate';
	$args['navbar_toggler']['effect'] = 'cross'; 
	return $args;
});  


add_filter('wpbc/filter/post/loop/class', function($class){
	if( is_tax() || is_archive() ){ 
		
	}
	$class = 'col-12 gmy-1';
	return $class; 
});

add_action('init', function(){

	add_filter('wpbc/filter/layout/locations', function($locations){ 
		
		$post_type = get_post_type();

		if( $post_type  == 'post' ){ 
			$locations['archive']['id'] = 'a1';
			$locations['category']['id'] = 'a1';
		}

		return $locations;

	},10,1);

}); 