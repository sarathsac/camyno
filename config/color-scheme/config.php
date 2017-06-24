<?php

global $canvys;

/**
 * Activate color scheme editor
 */
if ( ! class_exists('CV_Color_Scheme') ) {
   require dirname(__FILE__) . '/class-color-scheme.php';
}

// Create the color scheme object
$canvys['color_scheme'] = new CV_Color_Scheme();

if ( ! function_exists( 'cv_get_color_scheme' ) ) :

/**
 * Supplies the saved color scheme if it exists, if not returns the default
 *
 * @return array
 */
function cv_get_color_scheme() {

   global $canvys;

   $scheme = array();

   // Grab the color scheme setting, if it exists
   if ( get_option( 'cv_color_scheme' ) ) {
      $scheme = get_option( 'cv_color_scheme' );
   }

   // If not, use the default
   else {
      $scheme = array(
         'preset' => 'executive',
         'scheme' => $canvys['color_scheme_presets']['executive']['scheme'],
      );
   }

   return apply_filters( 'cv_color_scheme', $scheme );

}
endif;