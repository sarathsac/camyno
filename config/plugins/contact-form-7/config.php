<?php

global $canvys;

// Add theme support for Contact Form 7
add_theme_support( 'contactform7' );

/* ===================================================================== *
 * Called upon deactivation
 * ===================================================================== */

if ( ! function_exists( 'cv_deactivate_WPCF7' ) ) :

/**
 * Function to remove the COntact Form 7 shortcode from all page builder options
 *
 * @return void
 */
function cv_deactivate_WPCF7() {

   // Shortcodes to be removed
   $searches = array(
      'contact-form-7'
   );

   // Remove now inactive shortcodes from all posts
   cv_refresh_all_builder_values( $searches );

}

$file = 'contact-form-7/wp-contact-form-7.php';

register_deactivation_hook( $file, 'cv_deactivate_WPCF7' );

endif;

/* ===================================================================== *
 * Prevent standard stylesheets from being loaded
 * ===================================================================== */

if ( ! function_exists( 'cv_prevent_native_WPCF7_stylesheet' ) ) :

/**
 * Function to prevent the native Contact Form 7 stylesheet from loading
 *
 * @return nothing
 */
function cv_prevent_native_WPCF7_stylesheet() {
   wp_dequeue_style( 'contact-form-7' );
   wp_deregister_style( 'contact-form-7' );
}

add_action( 'wp_print_styles', 'cv_prevent_native_WPCF7_stylesheet' );

endif;

/* ===================================================================== *
 * Load included stylesheet
 * ===================================================================== */

if ( ! function_exists( 'cv_load_WPCF7_stylesheet' ) ) :

/**
 * Function to load custom Contact Form 7 stylesheet
 *
 * @return void
 */
function cv_load_WPCF7_stylesheet() {

   // Register custom WPCF7 Stylesheet
   wp_register_style( 'cv-contact-form-7', THEME_PLUGIN_DIR . 'contact-form-7/assets/contact-form-7.css');

   // Enqueue all Stylesheets
   wp_enqueue_style('cv-contact-form-7');

}

add_action( 'wp_enqueue_scripts', 'cv_load_WPCF7_stylesheet' );

endif;

/* ===================================================================== *
 * Activate included Contact Form 7 shortcode
 * ===================================================================== */

/**
 * Activate included Contact Form 7 shortcode
 * for template builder/shortcode composer integration
 */
if ( class_exists('CV_Contact_Form_7') ) {

   // Create shortcode object
   $shortcode = new CV_Contact_Form_7();

   // Add shortcode object to global canvys variable
   $canvys['shortcodes'][$shortcode->config['handle']] = $shortcode;

   // Activate the shortcode
   $shortcode->init();

}