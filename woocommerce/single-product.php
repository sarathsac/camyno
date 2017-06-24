<?php

global $canvys;

/**
 * The Template for displaying all single products.
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    1.6.4
 */

// Call the header
get_header();

if ( has_action('woocommerce_before_main_content') ) {

   ob_start();

   /**
    * woocommerce_before_main_content hook
    *
    * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
    * @hooked woocommerce_breadcrumb - 20
    */
   do_action( 'woocommerce_before_main_content' );

   $before_content = trim( ob_get_clean() );

   if ( $before_content ) {
      echo cv_content_section( array(), $before_content );
   }

}

$atts = array();

// Add the layout attribute
$atts['sidebar_layout'] = cv_theme_setting( 'woocommerce', 'product_layout', 'no-sidebar' );

// Add the sidebar setting, if applicable
if ( 'no-sidebar' != $atts['sidebar_layout'] ) {
   $atts['sidebar'] = is_active_sidebar( 'woocommerce_shop_sidebar' ) ? 'woocommerce_shop_sidebar' : 'sidebar';
}

// Set the global sidebar layout
$canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

ob_start();

   while ( have_posts() ) : the_post();

      wc_get_template_part( 'content', 'single-product' );

   endwhile; // end of the loop

$content = ob_get_clean();

echo cv_content_section( $atts, $content );

if ( has_action('woocommerce_after_main_content') ) {

   ob_start();

   /**
    * woocommerce_after_main_content hook
    *
    * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    */
   do_action( 'woocommerce_after_main_content' );

   $after_content = trim( ob_get_clean() );

   if ( $after_content ) {
      echo cv_content_section( array(), $after_content );
   }

}

// Call the footer
get_footer();