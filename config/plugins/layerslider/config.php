<?php

global $canvys;

// Add theme support for LayerSlider
add_theme_support( 'layerslider' );

if ( ! function_exists( 'cv_deactivate_layerSlider' ) ) :

/**
 * Function to remove the WooCommerce shortcodes from all page builder options
 *
 * @return void
 */
function cv_deactivate_layerSlider() {

   // Shortcodes to be removed
   $searches = array(
      'cv_fullscreen_layerslider',
      'layerslider',
   );

   // Remove now inactive shortcodes from all posts
   cv_refresh_all_builder_values( $searches );

}

$file = 'LayerSlider/layerslider.php';

register_deactivation_hook( $file, 'cv_deactivate_layerSlider' );

endif;

/**
 * Activate included LayerSlider shortcodes
 * for template builder/shortcode composer integration
 */
$classes = array(
   'CV_LayerSlider',
   'CV_Fullscreen_LayerSlider',
);

foreach ( $classes as $class ) {

   // Make sure the class exists
   if ( ! class_exists($class) ) {
      continue;
   }

   // Create shortcode object
   $shortcode = new $class();

   // Add shortcode object to global canvys variable
   $canvys['shortcodes'][$shortcode->config['handle']] = $shortcode;

   // Activate the shortcode
   $shortcode->init();

}