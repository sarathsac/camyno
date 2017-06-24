<?php

if ( ! function_exists( 'cv_get_composer_screens' ) ) :

/**
 * Returns an array of all of the screens the shortcode composer is applied to
 *
 * @return array
 */
function cv_get_composer_screens() {
   $screens = apply_filters( 'cv_builder_post_types', array( 'page', 'post', 'portfolio_item' ) );
   $screens = apply_filters( 'cv_composer_post_types', $screens );
   return $screens;
}
endif;

/**
 * Activate included shortcode composer
 */
if ( ! class_exists('CV_Shortcode_Composer') ) {
   require dirname(__FILE__) . '/class-shortcode-composer.php';
}

/**
 * Screens that the shortcode composer can be displayed on
 *
 * Shortcode composer is always activated on screens which have
 * the template builder active.
 */
$screens = cv_get_composer_screens();

// Create the composer object
$canvys['shortcode_composer'] = new CV_Shortcode_Composer( $screens );