<?php  

/*

	Based on form elements used, filter the posts query loop

	Some params like order, orderby, post_type, posts_per_page and so on, came by default

	This query is used on shortcode output

*/

add_filter('wpbc/filter/get_query_posts/query', function($query){
	
	if( $query['post_type'] == 'property' ){ 

		foreach ($query as $key => $value) {
			if($value=='-1'){
				$query[$key] = '';
			}
		}
		if($query['property_location'] == '-1'){
			//$query['property_location'] = '';	
		}

		// TAX
		/* https://codex.wordpress.org/Class_Reference/WP_Query#Return_Fields_Parameter */
		$property_taxonomy_list = WPBC_property_taxonomies(); 
		$tax_query = array();
		foreach ($property_taxonomy_list as $key => $value) { 
			if( !empty( $query[$value['id']] ) ){

				$terms = $query[$value['id']]; 
				 
				$terms_comma = explode(",",$terms); // %2C
				if(is_array($terms_comma) && count($terms_comma)>1){
					$terms_a = $terms_comma;
				} 

				if(!empty($terms_a)){
					$terms = $terms_a;
				} 

				$terms_plus = explode("+",$terms); // showld be %2B on url
				if(is_array($terms_plus) && count($terms_plus)>1){
					$terms_a = $terms_plus;
					foreach($terms_plus as $term){ 
						$tax_query[] = array(
							'taxonomy' => $value['id'],
							'terms' => $term,
							'field' => 'slug',
							// 'operator' => 'IN',
						);  
					} 
				} else{ 
					$tax_query[] = array(
						'taxonomy' => $value['id'],
						'terms' => $terms,
						'field' => 'slug',
						// 'operator' => 'IN',
					); 
				} 
				 
				
				// $tax_query['relation'] = 'AND';
			}

		} 
 
		if(!empty($tax_query)){
			$query['tax_query'] = $tax_query;
		}


		// META
		$meta_query = array(); 

		if( !empty( $query['property_price_max'] ) ){
			$query['property_price_min'] = !empty( $query['property_price_min'] ) ? $query['property_price_min'] : 0;
			$meta_query[] = array(
				'key'     => 'property_price',
		            'value'   => array($query['property_price_min'], $query['property_price_max']),
		            'compare' => 'BETWEEN', 
		            'type'    => 'numeric',
			); 
			
		}

		if(!empty($meta_query)){
			$query['meta_query'][] = $meta_query; 
		} 

	}

	return $query;
},10,1); 