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

// Display pagination
wp_link_pages( array(
   'before'           => '<p class="pagination">' . __('Pages: ', 'canvys'),
   'after'            => '</p>',
   'nextpagelink'     => __( 'Next page', 'canvys' ),
   'previouspagelink' => __( 'Previous page', 'canvys' ),
) );

echo '<div class="below-single-post has-clearfix">';

// Post tags
$disabled_meta = cv_theme_setting( 'blog', 'disabled_meta' );
$show_tags = isset( $disabled_meta['tags'] ) && $disabled_meta['tags'] ? false : true;
if ( $show_tags & has_tag() ) {
   echo '<div class="post-tags">';
   echo '<div style="float:inherit;">';
   echo '<h4>' . __( 'Tagged', 'canvys' ) . '</h4>';
   echo '<p>';
   the_tags( '', null, null );
   echo '</p>';
   echo '</div>';
   echo '</div>';
}

// Share Buttons
if ( cv_theme_setting( 'social', 'share_buttons', true ) ) {
   echo '<div class="share-buttons-wrap">';
   echo '<div style="float:inherit;">';
   echo '<h4>' . __( 'Share', 'canvys' ) . '</h4>';
   get_template_part( 'inc/content/share-buttons' );
   echo '</div>';
   echo '</div>';
}

echo '</div>';

// Related posts
if ( cv_theme_setting( 'blog', 'related_posts', true ) ) {
   get_template_part( 'inc/content/related-posts' );
}

// Display Comments
$disabled_comments = cv_theme_setting( 'general', 'disabled_comments' );
$disabled = isset( $disabled_comments['post'] ) && $disabled_comments['post'] ? true : false;
if ( ! $disabled ) comments_template();

$content = ob_get_clean();

echo cv_content_section( $atts, $content );

// Call the footer
get_footer();