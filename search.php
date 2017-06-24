<?php

global $canvys;

/**
 * The search page template for our theme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

// Call the header
get_header();

$atts = array();

// Add the layout attribute
$atts['sidebar_layout'] = cv_theme_setting( 'sidebar', 'search_layout', 'sidebar-right' );

// Set the global sidebar layout
$canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

// Add the sidebar setting, if applicable
if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
   $atts['sidebar'] = is_active_sidebar( 'search_sidebar' ) ? 'search_sidebar' : 'sidebar';
}

// Grab the loop
ob_start();

// grab the before search content
get_template_part( 'inc/content/before-search' );

// grab the seach loop
get_template_part( 'inc/loops/search' );

// Display pagination
echo cv_pagination();

// grab all content
$content = ob_get_clean();

// Display the page
echo cv_content_section( $atts, $content );

// Call the footer
get_footer();