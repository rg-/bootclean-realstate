<?php


/*

	Customs for Realstate Addon

*/

/* Enable Realstate Addon */
add_filter('wpbc/filter/post_types/enable/realstate',function(){
	return '1';
},10,1);


include('wpbc_realstate/layout.php');

include('wpbc_realstate/settings.php');