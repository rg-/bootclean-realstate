<?php
/* ----------------------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------------------- */
/**
 * Setup Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function bc_child_theme_setup() {
    load_child_theme_textdomain( 'realstate', get_stylesheet_directory() . '/languages' ); 
}
add_action( 'after_setup_theme', 'bc_child_theme_setup' ); 
/* ----------------------------------------------------------------------------------------------- */
/* ----------------------------------------------------------------------------------------------- */