<?php

global $canvys;

/**
 * Activate background editor
 */
if ( ! class_exists('CV_Background') ) {
   require dirname(__FILE__) . '/class-background.php';
}

// Create the color scheme object
$canvys['background'] = new CV_Background();

if ( ! function_exists( 'cv_get_background' ) ) :

/**
 * Supplies the saved cbackground if it exists, if not returns the default
 *
 * @return array
 */
function cv_get_background() {

   // Grab the color background setting, if it exists
   if ( get_option( 'cv_background' ) ) {
      return get_option( 'cv_background' );
   }

   // If not, use the default
   return array(
      'source' => 'shattered',
      'color' => '#ffffff',
      'image' => null,
      'style' => 'cover',
      'repeat' => 'repeat',
      'position' => 'center center',
      'preset_attachment' => 'scroll',
      'custom_attachment' => 'scroll',
   );

}
endif;