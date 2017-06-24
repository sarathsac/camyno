<?php

if ( ! function_exists( 'cv_load_theme_assets' ) ) :

/**
 * Load required frotnend assets
 */
add_action( 'wp_enqueue_scripts', 'cv_load_theme_assets' );

/**
 * Function to load required assets
 *
 * @return void
 */
function cv_load_theme_assets() {

   global $canvys;

   // Google Maps API
   $api_key = cv_theme_setting( 'advanced', 'google_maps_api_key' );
   $google_maps_api_url = $api_key ? '://maps.googleapis.com/maps/api/js?key='.$api_key : '://maps.google.com/maps/api/js?sensor=true';
   wp_register_script('cv-gmaps-api', is_ssl() ? 'https'.$google_maps_api_url : 'http'.$google_maps_api_url, null, THEME_VER, true );

   // Included JavaScript functionality
   wp_register_script('jquery-theme', THEME_DIR . 'assets/js/theme.js', array( 'underscore', 'jquery' ), THEME_VER, true );

   // FullPage.js API (Only loaded when page sliding is active)
   wp_register_script('jquery-pageSlide', THEME_DIR . 'assets/js/pageSlide.js', array( 'jquery-theme' ), THEME_VER, true );

   // Include full page sliding
   if ( cv_is_page_slide_active() ) {
      wp_enqueue_script('jquery-pageSlide');
   }

   // Include theme functionality
   wp_enqueue_script('jquery-theme');

   // Include WordPress HTML5 Element script
   wp_enqueue_script('wp-mediaelement');

   // Register CSS icons Stylesheet
   wp_register_style( 'cv-theme-icons', THEME_DIR . 'assets/css/icons.css');

   // Register SCSS based Stylesheet
   $stylesheet = cv_theme_setting( 'general', 'disable_responsive' ) ? 'style' : 'style-responsive';
   wp_register_style( 'cv-base-style', THEME_DIR . 'assets/css/' . $stylesheet . '.css');

   // Enqueue all Stylesheets
   wp_enqueue_style('cv-theme-icons');
   wp_enqueue_style('cv-base-style');

   // Make sure media styles are loaded
   wp_enqueue_style('wp-mediaelement');

}
endif;