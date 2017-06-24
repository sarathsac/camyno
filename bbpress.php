<?php

global $canvys;

/**
 * The template for displaying bbpress forums
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

// Call the header
get_header();

// grab the post
the_post();

// Check if page builder is active
if ( 'advanced' == get_post_meta( get_the_ID(), '_cv_active_editor', true ) ) {
   $template = get_post_meta( get_the_ID(), '_cv_page_template', true );
   echo do_shortcode( do_shortcode( $template ) );
}

// Or use default page
else {

   $atts = array();

   // grab the default layout setting
   $default_layout = cv_theme_setting( 'bbpress', 'layout', 'sidebar-right' );

   if ( $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab theme meta settings
      $cv_meta = get_post_meta( $forum_page->ID, '_cv_page_settings', true );
      $layout_setting  = isset( $cv_meta['layout'] ) ? $cv_meta['layout'] : 'default';
      $sidebar_setting = isset( $cv_meta['sidebar'] ) ? $cv_meta['sidebar'] : 'default';

      // If we`re not viewing the forum index page
      if ( ! bbp_is_forum_archive() ) {
         $layout_setting = 'default'; $sidebar_setting = 'default';
      }

      // If default layout is in use
      if ( 'default' == $layout_setting ) {
         $layout_setting = $default_layout;
      }

      // Add the layout attribute
      $atts['sidebar_layout'] = $layout_setting;

      // Add the sidebar setting, if applicable
      if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
         $default = is_active_sidebar( 'bbpress_forums_sidebar' ) ? 'bbpress_forums_sidebar' : 'sidebar';
         $atts['sidebar'] = 'default' == $sidebar_setting ? $default : $sidebar_setting;
      }

   }

   else {

      // Add the layout attribute
      $atts['sidebar_layout'] = $default_layout;

      // Add the sidebar setting, if applicable
      if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
         $atts['sidebar'] = is_active_sidebar( 'bbpress_forums_sidebar' ) ? 'bbpress_forums_sidebar' : 'sidebar';
      }

   }

   // Set the global sidebar layout
   $canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

   ob_start();

   // Grab the content
   echo apply_filters( 'the_content', get_the_content() );

   // Display pagination
   wp_link_pages( array(
      'before'           => '<p class="pagination">' . __('Pages: ', 'canvys'),
      'after'            => '</p>',
      'nextpagelink'     => __( 'Next page', 'canvys' ),
      'previouspagelink' => __( 'Previous page', 'canvys' ),
   ) );

   $content = ob_get_clean();

   // output the content section
   echo cv_content_section( $atts, $content );

}

// Call the footer
get_footer();