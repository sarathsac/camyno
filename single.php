<?php

global $canvys;

/**
 * The template for displaying single posts
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

// Call the header
get_header();

$atts = array();

// Add the layout attribute
$atts['sidebar_layout'] = cv_theme_setting( 'sidebar', 'single_layout', 'sidebar-right' );

// Add the sidebar setting, if applicable
if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
   $atts['sidebar'] = is_active_sidebar( 'blog_sidebar' ) ? 'blog_sidebar' : 'sidebar';
}

// Set the global sidebar layout
$canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

ob_start();

// The post
get_template_part( 'inc/loops/blog-standard' );

echo '<div class="below-single-post">';

// Display pagination
wp_link_pages( array(
   'before'           => '<p class="pagination">' . __('Pages: ', 'canvys'),
   'after'            => '</p>',
   'nextpagelink'     => __( 'Next page', 'canvys' ),
   'previouspagelink' => __( 'Previous page', 'canvys' ),
) );

// Post tags
if ( has_tag() ) {
   echo '<p class="post-tags">';
   the_tags( __( '<span>Tagged</span>', 'canvys' ), null, null );
   echo '</p>';
}

// Share Buttons
if ( cv_theme_setting( 'social', 'share_buttons', true ) ) {
   echo '<div class="share-buttons-wrap">';
   echo '<h3>' . __( 'Share This Entry', 'canvys' ) . '</h3>';
   get_template_part( 'inc/content/share-buttons' );
   echo '</div>';
}

// Display Comments
comments_template();

echo '</div>';

$content = ob_get_clean();

echo cv_content_section( $atts, $content );

// Call the footer
get_footer();