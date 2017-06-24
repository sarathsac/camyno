<?php

global $canvys, $woocommerce_loop;

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    2.0.0
 */

// Call the header
get_header();

// Grab the ID of the bage being used for the shop
$shop_page_id = get_option( 'woocommerce_shop_page_id' );

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

// Check if page builder is active
if ( 'advanced' == get_post_meta( $shop_page_id, '_cv_active_editor', true ) ) {
   $template = get_post_meta( $shop_page_id, '_cv_page_template', true );
   echo do_shortcode( $template );
}

// If not show normal content
else {
   $page = get_page( $shop_page_id );
   if ( $content = apply_filters( 'the_content', $page->post_content ) ) {
      $args = array( 'padding_bottom' => 'less' );
      echo cv_content_section( $args, $content );
   }
}

do_action( 'woocommerce_archive_description' );

$atts = array();

// Grab theme meta settings
$cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );
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
   $default = is_active_sidebar( 'woocommerce_shop_sidebar' ) ? 'woocommerce_shop_sidebar' : 'sidebar';
   $atts['sidebar'] = 'default' == $sidebar_setting ? $default : $sidebar_setting;
}

// Set the global sidebar layout
$canvys['current_sidebar_layout'] = $atts['sidebar_layout'];

// Grab the shop content
ob_start();

if ( have_posts() ) :

   ob_start();
   woocommerce_product_subcategories();
   if ( $subcategories = ob_get_clean() ) {
      woocommerce_product_loop_start();
      echo $subcategories;
      woocommerce_product_loop_end();
   }

   /**
    * woocommerce_before_shop_loop hook
    *
    * @hooked woocommerce_result_count - 20
    * @hooked woocommerce_catalog_ordering - 30
    */
   do_action( 'woocommerce_before_shop_loop' );

   $woocommerce_loop['columns'] = cv_theme_setting( 'woocommerce', 'shop_columns', '3' );

   woocommerce_product_loop_start();

   while ( have_posts() ) : the_post();

      wc_get_template_part( 'content', 'product' );

   endwhile; // End the loop

   woocommerce_product_loop_end();

   /**
    * woocommerce_after_shop_loop hook
    *
    * @hooked woocommerce_pagination - 10
    */
   do_action( 'woocommerce_after_shop_loop' );

   /**
    * woocommerce_after_shop_loop hook
    *
    * @hooked woocommerce_pagination - 10
    */
   // do_action( 'woocommerce_after_shop_loop' );

   echo cv_pagination();

elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) :

wc_get_template( 'loop/no-products-found.php' );

endif;

$content = ob_get_clean();

// Display the page
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