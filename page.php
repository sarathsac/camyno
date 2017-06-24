<?php

global $canvys;

/**
 * The page template for our theme
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
if ( ! post_password_required() && 'advanced' == get_post_meta( get_the_ID(), '_cv_active_editor', true ) ) {
   $template = get_post_meta( get_the_ID(), '_cv_page_template', true );
   echo do_shortcode( $template );

   // Display the page comments
   $disabled_comments = cv_theme_setting( 'general', 'disabled_comments' );
   $disabled = isset( $disabled_comments['page'] ) && $disabled_comments['page'] ? true : false;
   if ( ! $disabled && comments_open() ) {
      ob_start();
      comments_template();
      if ( $comments = ob_get_clean() ) {
         echo cv_content_section( array('id'=>'cv-builder-comments'), $comments );
      }
   }

}

// Or use default page
else {

   $atts = array();

   // Grab theme meta settings
   $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
   $layout_setting  = isset( $cv_meta['layout'] ) ? $cv_meta['layout'] : 'default';
   $sidebar_setting = isset( $cv_meta['sidebar'] ) ? $cv_meta['sidebar'] : 'default';

   // If default layout is in use
   if ( 'default' == $layout_setting ) {
      $layout_setting = cv_theme_setting( 'sidebar', 'page_layout', 'sidebar-right' );
   }

   // Add the layout attribute
   $atts['sidebar_layout'] = $layout_setting;

   // Add the sidebar setting, if applicable
   if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
      $default = is_active_sidebar( 'page_sidebar' ) ? 'page_sidebar' : 'sidebar';
      $atts['sidebar'] = 'default' == $sidebar_setting ? $default : $sidebar_setting;
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

   // Display Comments
   $disabled_comments = cv_theme_setting( 'general', 'disabled_comments' );
   $disabled = isset( $disabled_comments['page'] ) && $disabled_comments['page'] ? true : false;
   if ( ! $disabled ) comments_template();

   $content = ob_get_clean();

   // output the content section
   echo cv_content_section( $atts, $content );

}

// Call the footer
get_footer();