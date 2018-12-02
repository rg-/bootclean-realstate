<?php


/*

	Custom form elements by form_id

*/
 


/*

	Custom filters for posts loop and filter form using:
	
	'wpbc/filter/get_query_form/form_wrap_args'
		
		- This is for global form arguments, class, css, buttons, so on

	'wpbc/filter/get_query_form/form_elements'
	
		- This will output the form elements used on front-end

	and

	'wpbc/filter/get_query_posts/query'

		- This will manage the query used on shortcode loop for "property"
		using the settings defined on the form elements used.

*/


/*

	Custom form_elements will require custom query for results, see: 
	filter: wpbc/filter/get_query_posts/query

*/
add_filter('wpbc/filter/get_query_form/form_wrap_args', function($form_wrap_args, $query, $shortcode_args, $template_args, $query_fields){

	// form_id passed from shortcode, used for diferent customs forms
	if($shortcode_args['form_id'] == 'property-home-form'){
		$form_wrap_args = array(
			'before_form' => '<div class="row gpy-1 justify-content-md-center">',
			'after_form' => '</div>',

			'form_buttons_args' => array(
				'col_class' => 'form-group col-sm-2 position-relative align-self-center',
				'group_class' => '',
			),
		);
	}

	return $form_wrap_args; 

},10, 5);

/*

	Filter specific form ID elements:

	'wpbc/filter/get_query_form/[FORM_ID]/form_elements'

*/

add_filter('wpbc/filter/get_query_form/property-home-form/form_elements', function($form_elements, $template_args, $query){

	if( $query['post_type'] == 'property' ){

		$form_elements['property_location'] = array(

			'type'=>'select',

			'wrap' => array(
				'form_group_class' => 'form-group col-sm-2 position-relative',
				'before' => '',
				'after' => '',
			),

			'form_args' => array(
				
				'form_id' => 'property_location',
				'label' => __('Locations','bootclean'),

				// since type == select
				// will use WPBC_dropdown_categories($select_args)
				'select_args' => array(
					'id' => 'property_location',
					'name' => 'property_location',
					'taxonomy' => 'property_location',
					'hide_empty' => false,
					'hierarchical' => true,
					'pad_counts' => false,
					'class' => 'wpbc_get_query_posts_select w-100',
					'value_field' => 'slug',
					'show_option_none' => __('Show All','bootclean'),

					// See: https://developer.snapappointments.com/bootstrap-select/options/
					'data_attr' => 'data-live-search="true" data-style="btn-info" data-showTick="true"',
				),

				'show_actions_reset' => true,

			),

		);

		/* Custom property_operation as dropdown */

		$form_elements['property_operation'] = array(

			'type'=>'dropdown',

			'wrap' => array(
				'form_group_class' => 'form-group col-sm-2 position-relative',
				'before' => '',
				'after' => '',
			),

			'form_args'=>array( 
				'form_id' => 'property_operation',
				'show_actions' => true,
				'label_all' => __('All Operations','bootclean'),
				'label' => __('Operations','bootclean'),
				'current' => !empty($query['property_operation']) ? $query['property_operation'] : '',  
				'show_count' => true, 
				'get_terms' => array( 
					'taxonomy' => 'property_operation', 
					'hide_empty' => false, 
				), 
				'show_actions_reset' => true,
			)

		);

		/* Custom property_type as dropdown */

		$form_elements['property_type'] = array(

			'type'=>'dropdown',

			'wrap' => array(
				'form_group_class' => 'form-group col-sm-2 position-relative',
				'before' => '',
				'after' => '',
			),

			'form_args'=>array( 
				'form_id' => 'property_type',
				'show_actions' => true,
				'label_all' => __('All Types','bootclean'),
				'label' => __('Types','bootclean'),
				'current' => !empty($query['property_type']) ? $query['property_type'] : '',  
				'show_count' => true, 
				'get_terms' => array( 
					'taxonomy' => 'property_type', 
					'hide_empty' => false, 
				), 
				'show_actions_reset' => true,
			)

		);

		/* Custom property_services as checkbox */
		/*
		$form_elements['property_services'] = array( 
			
			'type'=>'checkbox',

			'wrap' => array(
				'form_group_class' => 'form-group col-sm-4 position-relative',
				'before' => '',
				'after' => '',
			),

			'form_args'=>array( 
				'form_id' => 'property_services',
			
				'label' => 'Services',
				'current' => !empty($query['property_services']) ? $query['property_services'] : '',  
				'show_count' => true, 
				'get_terms' => array( 
					'taxonomy' => 'property_services', 
					'hide_empty' => false, 
				), 

				'show_actions_all' => true,
				'show_actions_reset' => true,
			) 
		);
		*/

		$form_elements['property_price_ranger'] = array( 

			'type' => 'price_ranger',

			'wrap' => array(
				'form_group_class' => 'form-group col-sm-4 position-relative',
				'before' => '',
				'after' => '',
			),

			'form_args'=>array(

				'min'=>'property_price_min',
				'max'=>'property_price_max', 
				'range_args' => array(

					'label'=> __('Price Range', 'bootclean'),
					'show_actions' => true,

					'input_min' => 'property_price_min',
					'input_max' => 'property_price_max',

					'prefix' => WPBC_property_currency_symbol(),
					'min' => 0,
					'max' => WPBC_property_get_max_price(),
					'start_from' => !empty($query['property_price_min']) ? $query['property_price_min'] : 0,
					'start_to' => !empty($query['property_price_max']) ? $query['property_price_max'] : WPBC_property_get_max_price(),
					'step' => 50,

				),
			),   
		);

	}

	return $form_elements;

},10,3);

/*

	Defaults for "property" post_type

*/

add_filter('wpbc/filter/get_query_form/form_elements', function($form_elements, $template_args, $query){

	$form_id = $template_args['form_id'];

	if( $query['post_type'] == 'property' && $form_id != 'property-home-form' ){

		$form_elements['p_search'] = array(  
			'type'=>'text',
			'form_args'=>array( 
				'form_id' => 'p_search',
				'label' => 'Search',
				'placeholder' => 'Search',
				'current' => !empty($query['p_search']) ? $query['p_search'] : '', 
				'show_actions_reset' => true,
			),
		);

		/* The price ranger */

		$form_elements['property_price_ranger'] = array( 
			'type' => 'price_ranger',
			'form_args'=>array(

				'min'=>'property_price_min',
				'max'=>'property_price_max', 
				'range_args' => array(

					'label'=> 'Price Range',
					'show_actions' => true,

					'input_min' => 'property_price_min',
					'input_max' => 'property_price_max',

					'prefix' => WPBC_property_currency_symbol(),
					'min' => 0,
					'max' => WPBC_property_get_max_price(),
					'start_from' => !empty($query['property_price_min']) ? $query['property_price_min'] : 0,
					'start_to' => !empty($query['property_price_max']) ? $query['property_price_max'] : WPBC_property_get_max_price(),
					'step' => 50,

				),
			),   
		); 

		$form_elements['p_order'] = array( 
			'type'=>'radio',
			'form_args'=>array( 
				'form_id' => 'p_order',
				'label' => 'Order',
				'label_all' => 'None',
				'current' => !empty($query['p_order']) ? $query['p_order'] : 'DESC',
				'items' => array(
					'DESC' => 'DESC',
					'ASC' => 'ASC',
				),
			),
		);

		$form_elements['p_orderby'] = array( 
			'type'=>'radio',
			'form_args'=>array( 
				'form_id' => 'p_orderby',
				'label' => 'Order by',
				
				'current' => !empty($query['p_orderby']) ? $query['p_orderby'] : 'date',  
				'items' => array(
					'date'  => 'Date',
					'modified' => 'Last modified',
					'title' => 'Title',
					'rand' => 'Rand',
				),
			),
		);

		/* All property taxonomies as dropowns */
		$property_taxonomy_list = WPBC_property_taxonomies(); 
		foreach ($property_taxonomy_list as $key => $value) {  
			
			$form_elements[$value['id']] = array(

				'type'=>'dropdown',
				'form_args'=>array( 
					'form_id' => $value['id'],
					'show_actions' => true,
					'label_all' => __('All','bootclean').' '.$value['args']['label'],
					'label' => $value['args']['label'],
					'current' => !empty($query[$value['id']]) ? $query[$value['id']] : '',  
					'show_count' => true, 
					'get_terms' => array( 
						'taxonomy' => $value['id'], 
						'hide_empty' => false, 
					), 
					'show_actions_reset' => true,
				),


			);

		} 

		// Next elements will replace above since use same name "taxonomy_NAME"

		$form_elements['property_operation']['form_args']['label'] = __('Operation','bootclean');
		$form_elements['property_type']['form_args']['label'] = __('Type','bootclean');

		$form_elements['property_operation']['form_args']['label_all'] = __('Show All','bootclean');
		$form_elements['property_type']['form_args']['label_all'] = __('Show All','bootclean');

		// property_location

		$form_elements['property_location'] = array(

			'type'=>'select',

			'form_args' => array(
				
				'form_id' => 'property_location',
				'label' => __('Locations','bootclean'),

				'select_args' => array(
					'id' => 'property_location',
					'name' => 'property_location',
					'taxonomy' => 'property_location',
					'hide_empty' => false,
					'show_count' => false,
					'hierarchical' => true,
					'pad_counts' => false,
					'class' => 'wpbc_get_query_posts_select w-100',
					'value_field' => 'slug',
					'show_option_none' => __('Show All','bootclean'),
					'selected' => !empty($query['property_location']) ? $query['property_location'] : '',
				),

				'show_actions_reset' => true,

			),

		);


		/* Custom property_services as checkbox */

		$form_elements['property_services'] = array( 
			
			'type'=>'checkbox',
			'form_args'=>array( 
				'form_id' => 'property_services',
			
				'label' => 'Services',
				'current' => !empty($query['property_services']) ? $query['property_services'] : '',  
				'show_count' => true, 
				'get_terms' => array( 
					'taxonomy' => 'property_services', 
					'hide_empty' => false, 
				), 

				'show_actions_all' => true,
				'show_actions_reset' => true,
			) 
		);

		/* Custom property_aditionals as radio */

		$form_elements['property_aditionals'] = array( 
			
			'type'=>'checkbox',

			'wrap' => array(
				'before' => '<div class="bg-primary text-white gmy-1 gp-1">',
				'after' => '</div>',
				'form_group_class' => 'bg-secondary gp-2',
			),

			'form_args'=>array( 
				'form_id' => 'property_aditionals',
				
				'label' => 'Aditionals',
				'current' => !empty($query['property_aditionals']) ? $query['property_aditionals'] : '',  
				'show_count' => false, 
				'get_terms' => array( 
					'taxonomy' => 'property_aditionals', 
					'hide_empty' => false, 
				), 

				'show_actions_all' => true,
				'show_actions_reset' => true,
			) 
		); 
		

	}
	return $form_elements;

},10,3);


/*

	Based on form elements used, filter the posts query loop

	Some params like order, orderby, post_type, posts_per_page and so on, came by default

	This query is used on shortcode output

*/

add_filter('wpbc/filter/get_query_posts/query', function($query){
	
	if( $query['post_type'] == 'property' ){ 

		if($query['property_location'] == '-1'){
			$query['property_location'] = '';	
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