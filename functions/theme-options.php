<?php

/*
	
	Bootclean Child Theme Options

*/ 


/* ----------------------------------------------------------------------------------------------- */
/* Enable/Disable Theme Options Admin Page */
/* true/false[default] */

	add_filter('WPBC_options_show_menu',function(){ return true; }, 10, 1);

/* ----------------------------------------------------------------------------------------------- */