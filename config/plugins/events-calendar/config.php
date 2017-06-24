<?php

global $canvys;

// Add theme support for Events Calendar
add_theme_support( 'eventscalendar' );

if ( ! function_exists( 'cv_add_eventscalendar_composer_support' ) ) :

/**
 * Adds support for the page shortcode composer to the event post type
 *
 * @param array $screens Screens the shortcode composer is applied to
 * @return void
 */
function cv_add_eventscalendar_composer_support( $screens ) {
  $screens[] = 'tribe_events';
  return $screens;
}

add_filter( 'cv_composer_post_types', 'cv_add_eventscalendar_composer_support' );

endif;

/**
 * Load all included events-calendar assets
 */
if ( ! function_exists( 'cv_load_events_calendar_assets' ) ) :

add_action( 'wp_enqueue_scripts', 'cv_load_events_calendar_assets' );

/**
 * Function to load included WooComerce assets
 *
 * @return void
 */
function cv_load_events_calendar_assets() {

   // Register Primary events-calendar Stylesheet
   wp_register_style( 'cv-events-calendar', THEME_PLUGIN_DIR . 'events-calendar/assets/events-calendar.css');

   // Enque all stylesheets
   if ( tribe_get_current_template() ) {
      wp_enqueue_style( 'cv-events-calendar' );
   }

}
endif;