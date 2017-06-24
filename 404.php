<?php

global $canvys;

/**
 * The 404 template for our theme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

// Call the header
get_header();

// Allow users to hook into 404 pages
do_action('cv_404_page');

// Grab the 404 page template
get_template_part( 'inc/content/404', 'page' );

// Allow users to hook into 404 pages
do_action('cv_404_page_after');

// Call the footer
get_footer();