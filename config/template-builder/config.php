<?php

if ( ! function_exists( 'cv_get_builder_screens' ) ) :

/**
 * Returns an array of all of the screens the page builder is applied to
 *
 * @return array
 */
function cv_get_builder_screens() {
   return apply_filters( 'cv_builder_post_types', array( 'page', 'portfolio_item' ) );
}
endif;

/**
 * Activate included page builder
 */
if ( ! class_exists('CV_Template_Builder') ) {
   require dirname(__FILE__) . '/class-template-builder.php';
}

/**
 * Screens that the page builder can be displayed on
 *
 * Shortcode composer is always activated on screens which have
 * the template builder active.
 */
$screens = cv_get_builder_screens();

// Create the builder object
$canvys['template_builder'] = new CV_Template_Builder( $screens );

if ( ! function_exists( 'cv_strip_inactive_plugin_shortcodes' ) ) :

/**
 * Removes inactive shortcodes from a string
 *
 * This function will not remove all unused shortcodes, but only the ones
 * that would have been created as a result of this themes integration with
 * certain plugins.
 *
 * @param string $input   The template to remove the shortcodes from
 * @param array $searches Specify list of tags to search for
 * @return void
 */
function cv_strip_inactive_plugin_shortcodes( $input, $searches = array() ) {

   if ( empty( $searches ) ) {

      // LayerSlider
      if ( ! class_exists( 'LS_Sliders') ) {
         $searches[] = 'cv_fullscreen_layerslider';
         $searches[] = 'layerslider';
      }

      // Contact Form 7
      if ( ! class_exists( 'WPCF7_ContactForm') ) {
         $searches[] = 'contact-form-7';
      }

      // Gravity Forms
      if ( ! class_exists( 'GFForms') ) {
         $searches[] = 'gravityform';
      }

      // Gravity Forms
      if ( ! class_exists( 'woocommerce') ) {
         $searches[] = 'woocommerce_cart';
         $searches[] = 'woocommerce_checkout';
         $searches[] = 'woocommerce_my_account';
      }

   }

   // Remove inactive shortcodes
   if ( ! empty( $searches ) ) {
      foreach ( $searches as $search ) {
         preg_match_all( "/\[" . preg_quote( $search ) . ".*?\]/", $input, $matches );
         foreach ( array_unique( $matches[0] ) as $match ) {
            $input = str_replace( $match, '', $input );
         }
      }
   }

   return $input;

}
endif;

if ( ! function_exists( 'cv_refresh_all_builder_values' ) ) :

/**
 * Removes inactive shortcodes from all posts
 *
 * This function will not remove all unused shortcodes, but only the ones
 * that would have been created as a result of this themes integration with
 * certain plugins.
 *
 * @param array $searches Specify list of tags to search for
 * @return void
 */
function cv_refresh_all_builder_values( $searches = array() ) {

   // Post types to be refreshed
   $screens = cv_get_builder_screens();

   // Refresh builder value for all posts
   foreach ( $screens as $screen ) {
      $posts = get_posts( array(
         'post_type' => $screen,
         'posts_per_page' => '-1',
      ) );
      foreach ( $posts as $post ) {
         if ( ! $builder_value = get_post_meta( $post->ID, '_cv_page_template', true ) ) {
            continue;
         }
         $builder_value = cv_strip_inactive_plugin_shortcodes( $builder_value, $searches );
         update_post_meta( $post->ID, '_cv_page_template', $builder_value );
      }
   }

}
endif;