<?php

/*

	@filter 'wpbc/filter/get_query_form/form_wrap_args'

	Change form things like:

	- form div wrapper
	- classes for common elements

*/

add_filter('wpbc/filter/get_query_form/form_wrap_args', function($form_wrap_args, $query, $shortcode_args, $template_args, $query_fields){

	// form_id passed from shortcode, used for diferent customs forms
	if( $shortcode_args['form_id'] == 'property-home-form' ){
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

		// property_location
		$property_location_select = _WPBC_property_location__select($query);
		$form_elements['property_location'] = $property_location_select; 

		// property_operation
		$property_operation_select = _WPBC_property_operation__select($query);
		$form_elements['property_operation'] = $property_operation_select; 

		// property_type
		$property_type_select = _WPBC_property_type__select($query);
		$form_elements['property_type'] = $property_type_select; 

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

	Filter specific form ID elements:

	'wpbc/filter/get_query_form/[FORM_ID]/form_elements'

*/

add_filter('wpbc/filter/get_query_form/property-home-form/form_elements', function($form_elements, $template_args, $query){

	if( $query['post_type'] == 'property' ){

		/*

		Custom html element, can be anything, better to use "template_part" for complex
		and reusable elements.
		*/
		$form_elements['custom_html'] = array(
			'type'=>'html',
			//'content' => 'OPS',
			'template_part' => 'wpbc_realstate/custom_html_form_element',
			'template_args' => array(
				'query' => $query,
			),
		);
		

		/*
	
		Using type "select", this will use "bootstrap-select" jquery plugin
		data-* can be passed, see functions and parameters
		can be changed here like:

		$form_elements['property_location']['form_args']['select_args']['data_attr']...

		after the function -> array

		*/

		$property_location_select = _WPBC_property_location__select($query);
		$form_elements['property_location'] = $property_location_select;

		$form_elements['property_location']['wrap'] = array(
			'form_group_class' => 'form-group col-sm-2 position-relative',
			'before' => '',
			'after' => '',
		);
		$form_elements['property_location']['form_args']['select_args']['data_attr'] = 'data-live-search="true" data-style="btn-info" data-showTick="true"';

		// property_operation
		$property_operation_select = _WPBC_property_operation__select($query);
		$form_elements['property_operation'] = $property_operation_select;

		$form_elements['property_operation']['wrap'] = array(
			'form_group_class' => 'form-group col-sm-2 position-relative',
			'before' => '',
			'after' => '',
		); 
		$form_elements['property_operation']['form_args']['select_args']['data_attr'] = 'data-style="btn-warning" data-showTick="true"';

		// property_type
		$property_type_select = _WPBC_property_type__select($query);
		$form_elements['property_type'] = $property_type_select; 

		$form_elements['property_type']['wrap'] = array(
			'form_group_class' => 'form-group col-sm-2 position-relative',
			'before' => '',
			'after' => '',
		); 
		$form_elements['property_type']['form_args']['select_args']['data_attr'] = 'data-style="btn-danger"';

		/*

		Using type "dropdown", this will use bootstrap drowpdowns and NOT select
		elements.

		*/

		/* Custom property_operation as dropdown 

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

				// since type == dropdown, use get_terms() args 
				'get_terms' => array( 
					'taxonomy' => 'property_operation', 
					'hide_empty' => false, 
				), 
				'show_actions_reset' => true,
			)

		);

		*/

		/* Custom property_type as dropdown 

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

		*/

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

				// since type == checkbox, use get_terms() args
				'get_terms' => array( 
					'taxonomy' => 'property_services', 
					'hide_empty' => false, 
				), 

				'show_actions_all' => true,
				'show_actions_reset' => true,
			) 
		);
		*/

		/*
	
		custom meta for price_ranger

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