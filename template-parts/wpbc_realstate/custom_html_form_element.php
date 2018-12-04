<?php if(!empty($_GET['debug'])){ ?>

<p>Testeando aca como hacer para updatear los (count) de los select al filtrar.</p>
<p>Aca abajo esta el WP_Query usado, la idea es chequear con has_term u otros la cantidad de posts que ademas tienen x otra tax/term de ese resultado el query filtrado justamente!</p>
<p>Despues la idea seria mechar eso dentro de WPBC_dropdown_categories o de WPBC_dropdown_categories_waker o quien sabe donde.</p>
<?php

$test = WPBC_get_query_posts('property'); 

// Reseteo el posts_per_page para obtener todos los posts... ver bien.
$args['query']['posts_per_page'] = '-1';
// levanto de los args pasados el "query" pasado que es el mismisimo query usado en el form y en el shortcode del loop y etc...
$query_posts = new WP_Query( $args['query'] );  

if( $query_posts->have_posts() ){ 

	while ( $query_posts->have_posts() ) { 
		
		$query_posts->the_post();  

		echo get_the_title();
		echo " - ";
		echo get_the_ID(); 

		// esto mismo para todas las taxonomias usadas

		if( has_term( 'sale', 'property_operation', get_the_ID() )  ){
			echo " - is sale";
			
		}
		echo "<br>";

		// y despue contar (count) todo eso para cada una, cosa de alguna manera luego usar esa data en el count del option en cuestion.... pssss
	}

}
?>
<?php } ?>