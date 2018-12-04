<?php


/*

	Customs for Realstate Addon

*/

/* Enable Realstate Addon */
add_filter('wpbc/filter/post_types/enable/realstate',function(){
	return '1';
},10,1);


include('wpbc_realstate/layout.php');

include('wpbc_realstate/settings/defaults.php');

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




function _WPBC_property_location__select($query, $args=array()){
	$defaults = array( 
		'type'=>'select', 
		'form_args' => array( 
			'form_id' => 'property_location',
			'label' => __('Locations','bootclean'), 
			'select_args' => array(
				'id' => 'property_location',
				'name' => 'property_location',
				'taxonomy' => 'property_location',
				'hide_empty' => false,
				'show_count' => true,
				'hierarchical' => true,
				'pad_counts' => false,
				'class' => 'wpbc_get_query_posts_select w-100',
				'value_field' => 'slug',
				'show_option_none' => __('Show All','bootclean'),
				'selected' => !empty($query['property_location']) ? $query['property_location'] : '',

				// See: https://developer.snapappointments.com/bootstrap-select/options/

			), 
			'show_actions_reset' => true, 
		),

	);

	return $defaults; 
}

function _WPBC_property_operation__select($query, $args=array()){
	$defaults = array( 
		'type'=>'select', 
		'form_args' => array( 
			'form_id' => 'property_operation',
			'label' => __('Operations','bootclean'), 
			'select_args' => array(
				'id' => 'property_operation',
				'name' => 'property_operation',
				'taxonomy' => 'property_operation',
				'hide_empty' => false,
				'show_count' => true,
				'hierarchical' => true,
				'pad_counts' => false,
				'class' => 'wpbc_get_query_posts_select w-100',
				'value_field' => 'slug',
				'show_option_none' => __('Show All','bootclean'),
				'selected' => !empty($query['property_operation']) ? $query['property_operation'] : '',
			), 
			'show_actions_reset' => true, 
		),

	);

	return $defaults; 
}

function _WPBC_property_type__select($query, $args=array()){
	$defaults = array( 
		'type'=>'select', 
		'form_args' => array( 
			'form_id' => 'property_type',
			'label' => __('Type','bootclean'), 
			'select_args' => array(
				'id' => 'property_type',
				'name' => 'property_type',
				'taxonomy' => 'property_type',
				'hide_empty' => false,
				'show_count' => true,
				'hierarchical' => true,
				'pad_counts' => false,
				'class' => 'wpbc_get_query_posts_select w-100',
				'value_field' => 'slug',
				'show_option_none' => __('Show All','bootclean'),
				'selected' => !empty($query['property_type']) ? $query['property_type'] : '',
			), 
			'show_actions_reset' => true, 
		),

	);

	return $defaults; 
}

include('wpbc_realstate/settings/get_query_form.php'); 
include('wpbc_realstate/settings/get_query_posts.php');