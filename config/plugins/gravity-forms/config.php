<?php

global $canvys;

// Add theme support for Gravity Forms
add_theme_support( 'gravityforms' );

/* ===================================================================== *
 * Called upon deactivation
 * ===================================================================== */

if ( ! function_exists( 'cv_deactivate_WPGF' ) ) :

/**
 * Function to remove the Gravityforms shortcode from all page builder options
 *
 * @return void
 */
function cv_deactivate_WPGF() {

   // Shortcodes to be removed
   $searches = array(
      'gravityform'
   );

   // Remove now inactive shortcodes from all posts
   cv_refresh_all_builder_values( $searches );

}

$file = 'gravityforms/gravityforms.php';

register_deactivation_hook( $file, 'cv_deactivate_WPGF' );

endif;

/* ===================================================================== *
 * Load Required Assets
 * ===================================================================== */

if ( ! function_exists( 'cv_load_WPGF_stylesheet' ) ) :

/**
 * Function to load custom Contact Form 7 stylesheet
 *
 * @return void
 */
function cv_load_WPGF_stylesheet() {

   // Register Primary events-calendar Stylesheet
   wp_register_style( 'cv-gravity-forms', THEME_PLUGIN_DIR . 'gravity-forms/assets/gravity-forms.css');

   // Enque all stylesheets
   wp_enqueue_style( 'cv-gravity-forms' );

}

add_action( 'wp_enqueue_scripts', 'cv_load_WPGF_stylesheet' );

endif;

/* ===================================================================== *
 * Activate Included Shortcode
 * ===================================================================== */

/**
 * Activate included Gravity Form shortcode
 * for template builder/shortcode composer integration
 */
if ( class_exists('CV_Gravity_Form') ) {

   // Create shortcode object
   $shortcode = new CV_Gravity_Form();

   // Add shortcode object to global canvys variable
   $canvys['shortcodes'][$shortcode->config['handle']] = $shortcode;

   // Activate the shortcode
   $shortcode->init();

}