<?php



/*
	
	Defaults TERMS for: property_taxonomies 

	The above filters create the default terms for the taxonomies previously declared.

	See: "defaults.php"
		on => bootclean\bc\core\addons\wpbc_realstate\init/ 


	IMPORTANT: name and slug not be translatable using textdomain

*/

add_filter('wpbc/filter/property/property_taxonomies/property_location', function(){

	$args = array(
		array(
			'name' => 'Uruguay',
			'slug' => 'uruguay'
		), 
		array(
			'name' => 'Argentina',
			'slug' => 'argentina'
		),
		array(
			'name' => 'Brasil',
			'slug' => 'brasil'
		),
	);

	return $args;

},10,1); 

add_filter('wpbc/filter/property/property_taxonomies/property_location', function(){

	$args = array( 
		array(
			'name' => 'Montevideo',
			'slug' => 'montevideo',
			'parent' => 'uruguay',
		), 
		array(
			'name' => 'Maldonado',
			'slug' => 'maldonado',
			'parent' => 'uruguay',
		), 

			array(
				'name' => 'Punta del este',
				'slug' => 'punta-del-este',
				'parent' => 'maldonado',
			), 
			array(
				'name' => 'Punta Ballena',
				'slug' => 'punta-ballena',
				'parent' => 'maldonado',
			), 

		array(
			'name' => 'Rocha',
			'slug' => 'rocha',
			'parent' => 'uruguay',
		), 

			array(
				'name' => 'Cabo Polonio',
				'slug' => 'cabo-polonio',
				'parent' => 'rocha',
			),
			array(
				'name' => 'La Paloma',
				'slug' => 'la-paloma',
				'parent' => 'rocha',
			),
			array(
				'name' => 'Punta del Diablo',
				'slug' => 'punta-del-diablo',
				'parent' => 'rocha',
			), 
			 
	);

	return $args;

},11,1); 

add_filter('wpbc/filter/property/property_taxonomies/property_operation', function(){

	$args = array(
		array(
			'name' => 'Sale',
			'slug' => 'sale'
		),
		array(
			'name' => 'Rental',
			'slug' => 'rental'
		),
		array(
			'name' => 'Temporary rent',
			'slug' => 'temporary-rent',
			'conditional_field' => 'property_operation',
			'conditional_target' => 'property_u_temporary_prices'
		),
	);

	return $args;

},10,1);

add_filter('wpbc/filter/property/property_taxonomies/property_type', function(){

	$args = array(
		array(
			'name' => 'House',
			'slug' => 'house'
		),
		array(
			'name' => 'Apartment',
			'slug' => 'apartment'
		),
		array(
			'name' => 'Land',
			'slug' => 'land'
		),
		array(
			'name' => 'Office',
			'slug' => 'office'
		),
	);

	return $args;

},10,1);

add_filter('wpbc/filter/property/property_taxonomies/property_services', function(){

	$args = array(
		array(
			'name' => 'Running water',
			'slug' => 'running-water'
		),
		array(
			'name' => 'Cable',
			'slug' => 'cable'
		),
		array(
			'name' => 'Sewer',
			'slug' => 'sewer'
		),
		array(
			'name' => 'Electricity',
			'slug' => 'electricity'
		),
		array(
			'name' => 'Natural gas',
			'slug' => 'natural-gas'
		),
		array(
			'name' => 'Internet',
			'slug' => 'internet'
		),
		array(
			'name' => 'Telephone',
			'slug' => 'telephone'
		),
	);

	return $args;

},10,1);

add_filter('wpbc/filter/property/property_taxonomies/property_aditionals', function(){

	$args = array(
		array(
			'name' => 'Garage',
			'slug' => 'garage'
		),
		array(
			'name' => 'Loft',
			'slug' => 'loft'
		),
		array(
			'name' => 'Balcony',
			'slug' => 'balcony'
		), 
		array(
			'name' => 'Laundry',
			'slug' => 'laundry'
		), 
	);

	return $args;

},10,1);



/*
	
	Filtering meta fields

		Features, or anything else like this.

		Property Meta (ACF) custom fields

*/
add_filter('wpbc/filter/property/property_meta/property_features', function(){

	$fields = array(

		array(
			'name' => 'built-area',
			'label' => __('Built Area','bootclean'),
			'prepend' => 'M2',
			'type' => 'number',
		), 

		array(
			'name' => 'total-area',
			'label' => __('Total Area','bootclean'),
			'prepend' => 'M2',
			'type' => 'number',
		), 

		array(
			'name' => 'rooms',
			'label' => __('Rooms','bootclean'), 
			'type' => 'number',
		),

		array(
			'name' => 'toilets',
			'label' => __('Toilets','bootclean'), 
			'type' => 'number',
		),

		array(
			'name' => 'bedrooms',
			'label' => __('Bedrooms','bootclean'),
			'type' => 'number',
		), 

	);

	return $fields; 
},10,1); 