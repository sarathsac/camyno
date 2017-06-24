<?php

// Refresh dynamic stylesheet when an admin page is loaded
// add_action( 'admin_init', 'cv_render_dynamic_stylesheet' );

if ( ! function_exists( 'cv_render_dynamic_stylesheet' ) ) :

/**
 * Creates a stylesheet based on user settings
 *
 * @return void
 */
function cv_render_dynamic_stylesheet() {

   global $canvys;

   // Grab the color scheme
   $scheme = cv_get_color_scheme();
   $scheme = $scheme['scheme'];

   // Add the all white scheme
   $scheme['white'] = array(
      'primary_bg'  => 'transparent',            'secondary_bg'      => 'rgba(255,255,255,0.05)',
      'borders'     => 'rgba(255,255,255,0.5)',  'headers'           => 'rgba(255,255,255,1)',
      'content'     => 'rgba(255,255,255,0.65)', 'secondary_content' => 'rgba(255,255,255,0.75)',
      'accent'      => 'rgba(255,255,255,1)',    'focused'           => 'rgba(255,255,255,1)',
   );

   // Add the all black scheme
   $scheme['black'] = array(
      'primary_bg'  => 'transparent',      'secondary_bg'      => 'rgba(0,0,0,0.025)',
      'borders'     => 'rgba(0,0,0,0.15)', 'headers'           => 'rgba(0,0,0,1)',
      'content'     => 'rgba(0,0,0,0.5)',  'secondary_content' => 'rgba(0,0,0,0.65)',
      'accent'      => 'rgba(0,0,0,0.85)', 'focused'           => 'rgba(0,0,0,1)',
   );

   // Include required Google font libraries
   $setting = cv_theme_setting( 'visual', 'font_scheme', 'open_sans' );

   // Create the Google fonts URL
   if ( isset( $canvys['typography_schemes'][$setting]['families'] ) ) {

      $families = $canvys['typography_schemes'][$setting]['families'];

      // Create the URL
      $fonts_url = '//fonts.googleapis.com/css?family=';
      foreach ( $families as $family => $weights ) {
         $fonts_url .= $family . ':';
         foreach ( $weights as $weight ) {
            $fonts_url .= $weight . ',';
         }
         $fonts_url = trim( $fonts_url, ',' ) . '|';
      }
      $fonts_url = trim( $fonts_url, '|' );

      echo '@import url("' . $fonts_url . '");' . "\n";

   }

   // Output the remainder of the content
   do_action( 'cv_render_dynamic_stylesheet', $scheme );
   echo cv_theme_setting( 'advanced', 'css' );

}
endif;