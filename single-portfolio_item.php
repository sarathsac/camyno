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

// grab the post
the_post();

// Check if page builder is active
if ( ! post_password_required() && 'advanced' == get_post_meta( get_the_ID(), '_cv_active_editor', true ) ) {

   $template = get_post_meta( get_the_ID(), '_cv_page_template', true );
   echo do_shortcode( $template );

   // Related Portfolio items
   if ( cv_theme_setting( 'portfolio', 'related_portfolio_items', true ) ) {
      ob_start();
      get_template_part( 'inc/content/related-portfolio_items' );
      if ( $related = ob_get_clean() ) {
         $related = '<div class="portfolio-related-page-builder">' . $related . '</div>';
         echo cv_content_section( array( 'color_scheme' => 'main' ), $related );
      }
   }

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
      $layout_setting = cv_theme_setting( 'sidebar', 'portfolio_layout', 'sidebar-right' );
   }

   // Add the layout attribute
   $atts['sidebar_layout'] = $layout_setting;

   // Add the sidebar setting, if applicable
   if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
      $default = is_active_sidebar( 'portfolio_sidebar' ) ? 'portfolio_sidebar' : 'sidebar';
      $atts['sidebar'] = 'default' == $sidebar_setting ? $default : $sidebar_setting;
   }

   // Set the global sidebar layout
   $canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

   ob_start();

   // Display the featured image
   if ( ! post_password_required() && has_post_thumbnail() && cv_theme_setting( 'portfolio', 'featured_image_visible', true ) ) {

      // Grab the image ID
      $id = get_post_thumbnail_id();

      // Whether or not image can be opened in a modal window
      if ( $modal_enabled = cv_theme_setting( 'portfolio', 'featured_image_full' ) ) {
         $full_size = wp_get_attachment_image_src( $id, 'full' );
         $link_url = $full_size[0];
      }

      // Determine which size to show
      $size = $modal_enabled ? 'cv_featured_large' : 'cv_featured_tall';

      // Grab the image URL
      if ( $img_info = wp_get_attachment_image_src( $id, $size ) ) {
         if ( $modal_enabled ) echo '<a href="' . $link_url . '" class="image-hover" data-icon="expand">';
         echo '<img src="' . $img_info[0] . '" alt="' . get_the_title() . '" />';
         if ( $modal_enabled ) echo '</a>';
      }

   }

   // Grab the item content
   echo apply_filters( 'the_content', get_the_content() );

   // Display pagination
   wp_link_pages( array(
      'before'           => '<p class="pagination">' . __('Pages: ', 'canvys'),
      'after'            => '</p>',
      'nextpagelink'     => __( 'Next page', 'canvys' ),
      'previouspagelink' => __( 'Previous page', 'canvys' ),
   ) );

   // Related Portfolio items
   if ( cv_theme_setting( 'portfolio', 'related_portfolio_items', true ) ) {
      get_template_part( 'inc/content/related-portfolio_items' );
   }

   // Display Comments
   $disabled_comments = cv_theme_setting( 'general', 'disabled_comments' );
   $disabled = isset( $disabled_comments['portfolio_item'] ) && $disabled_comments['portfolio_item'] ? true : false;
   if ( ! $disabled ) comments_template();

   $content = ob_get_clean();

   // output the content section
   echo cv_content_section( $atts, $content );

}

// Call the footer
get_footer();