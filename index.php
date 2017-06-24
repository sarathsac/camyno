<?php

global $canvys;

/**
 * The index template for our theme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

// Call the header
get_header();

$atts = array();

// Add the layout attribute
$atts['sidebar_layout'] = cv_theme_setting( 'sidebar', 'blog_layout', 'sidebar-right' );

// Set the global sidebar layout
$canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

// Add the sidebar setting, if applicable
if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
   $atts['sidebar'] = is_active_sidebar( 'blog_sidebar' ) ? 'blog_sidebar' : 'sidebar';
}

$blog_style = cv_theme_setting( 'blog', 'loop_type', 'standard' );

if ( 'masonry-stretched' == $blog_style ) {
   $blog_style = 'masonry';
   if ( 'no-sidebar' == $atts['sidebar_layout'] ) {
      $atts['stretched'] = 'free';
      $atts['padding_top'] = 'less';
   }
}

if ( 'minimal-stretched' == $blog_style ) {
   $blog_style = 'minimal';
   if ( 'no-sidebar' == $atts['sidebar_layout'] ) {
      $atts['stretched'] = 'stretched';
      $atts['padding_top'] = 'none';
      $atts['padding_bottom'] = 'none';
   }
}

if ( 'masonry' == $blog_style ) {
   global $num_columns;
   $num_columns = cv_theme_setting( 'blog', 'masonry_columns', '3' );
}

// Grab the loop
ob_start();
get_template_part( 'inc/loops/blog-' . $blog_style );
echo cv_pagination();
$content = ob_get_clean();

// Display the page
echo cv_content_section( $atts, $content );

// Call the footer
get_footer();