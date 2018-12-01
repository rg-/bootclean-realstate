<?php 
add_filter('wpbc/filter/template-parts/property_location_iframe/args',function($args){

	$args['map_item_style'] = 'background-image:url('.get_stylesheet_directory_uri().'/images/theme/mapa-ejemplo.jpg);';

	return $args;
},10,1);

add_filter('wpbc/filter/template-parts/property_temporary_prices/args',function($args){

	$args['class'] = '';

	return $args;
},10,1);

// layout content replacement/injection

add_filter('wpbc/filter/layout/a1/content-area/shortcode/area-main', function($shortcode, $value){
	if( is_tax() || is_archive() ){ 
		$post_type = get_post_type();
		if( $post_type  == 'property'){ 
			$shortcode = "[WPBC_get_query_properties target_id='property-tax' query_string='posts_per_page=3'/]";
		}

	}
	return $shortcode;

},10,2);

add_filter('wpbc/filter/post_breadcrumb/args', function($args){
	$args['delimiter'] = '>';
	return $args;
},10,1);

add_action('wpbc/layout/start', function(){ 
	if( is_tax() || is_archive() ){ 
		$post_type = get_post_type();
		if( $post_type  == 'property'){ 
			$queried_object = get_queried_object(); 
			$title = !empty($queried_object->name) ? $queried_object->name : '';
			$desc = !empty($queried_object->description) ? $queried_object->description : '';
?><div class="container gpy-1">
	<div class="row">
		<div class="col-12">
			<h2 class="section-title"><?php echo $title;?></h2>
			<?php if(!empty($desc)){ ?>
				<h4 class="section-title xs"><?php echo $desc;?></h4>
			<?php } ?>
			<?php
			$args = array( 
				'title_cats' => '',
				'after_home' => '<a href="/buscador-de-propiedades">'.__('Properties','bootclean').'</a>',
			);
			WPBC_post_breadcrumb($args);
			?>
		</div>
	</div>
</div><?php
		} 
	}
}, 5.5 ); 


/* Change article class for property loop only */
add_filter('wpbc/filter/property/loop/class', function($out, $target_id){ 
	$out = 'col-sm-6 col-md-4 gmy-1';  
	if($target_id == 'property'){
		$out = 'col-sm-6 col-md-6 gmy-1'; 
	} 
	return $out; 
},10,2);
 
/* Change class for property single page article */
add_filter('wpbc/filter/property/single/class', 'WPBC_property_single_class',10,1);
	function WPBC_property_single_class(){
		return 'gmy-2';
	}

add_action('wpbc/layout/inner/content/loop/before', function(){ 
	if( is_tax() || is_archive() ){ 
		$post_type = get_post_type();
		if( $post_type  == 'property' || $post_type  == 'post' ){ 
			echo "<div class='row gmy-1'>";
		} 
	}

},10,1);
add_action('wpbc/layout/inner/content/loop/after', function(){ 
	if( is_tax() || is_archive() ){ 
		$post_type = get_post_type();
		if( $post_type  == 'property' || $post_type  == 'post' ){ 
			echo "</div>";
		} 
	} 
},10,1);

/* Change filters on init (required) */
add_action('init', function(){

	add_filter('wpbc/filter/layout/locations', function($locations){ 
		
		$post_type = get_post_type();
		
		$locations['_template_builder']['id'] = 'a1';

		if( $post_type  == 'property' ){ 
			$locations['tax']['id'] = 'a1';
			$locations['single']['id'] = 'a1';
		} 
		
		return $locations; 
	},10,1); 
	
	/* for single property */
	add_filter('wpbc/filter/layout/template-path', function($path, $post_type){  
		if( is_single() && $post_type  == 'property' ){
			$path = 'template-parts/wpbc_realstate/post_property_single';
		} 
		return $path; 
	},10,2);
	add_filter('wpbc/filter/layout/template-part', function($path, $post_type){  
		if( is_single() && $post_type  == 'property' ){
			$path = '';
		} 
		return $path; 
	},10,2);


	/* for loop property */
	add_filter('wpbc/filter/layout/template-path', function($path, $post_type){ 
		$template = WPBC_get_template();
		if( (is_tax() && $post_type == 'property') ||  is_post_type_archive( 'property' ) ){
			$path = 'template-parts/wpbc_realstate/post_property';
		} 
		return $path; 
	},10,2);
	add_filter('wpbc/filter/layout/template-part', function($path, $post_type){ 
		$template = WPBC_get_template();
		if( (is_tax() && $post_type == 'property') || is_post_type_archive( 'property' ) ){
			$path = '';
		} 
		return $path; 
	},10,2);
}); 