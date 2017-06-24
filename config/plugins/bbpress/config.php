<?php

// Add theme support for bbPress
add_theme_support( 'bbpress' );

/* ===================================================================== *
 * Called upon deactivation
 * ===================================================================== */

if ( ! function_exists( 'cv_deactivate_bbpress' ) ) :

/**
 * Function to remove the Gravityforms shortcode from all page builder options
 *
 * @return void
 */
function cv_deactivate_bbpress() {

   // Shortcodes to be removed
   $searches = array(
      'cv_bbp_index',
      'cv_bbp_registration',
      'cv_bbp_recovery',
   );

   // Remove now inactive shortcodes from all posts
   cv_refresh_all_builder_values( $searches );

}

$file = 'bbpress/bbpress.php';

register_deactivation_hook( $file, 'cv_deactivate_bbpress' );

endif;

/* ===================================================================== *
 * Load Required Assets
 * ===================================================================== */

/**
 * Load all included bbPress assets
 */
if ( ! function_exists( 'cv_load_bbpress_assets' ) ) :

add_action( 'wp_enqueue_scripts', 'cv_load_bbpress_assets' );

/**
 * Function to load included WooComerce assets
 *
 * @return void
 */
function cv_load_bbpress_assets() {

   // Register Primary events-calendar Stylesheet
   wp_register_style( 'cv-bbpress', THEME_PLUGIN_DIR . 'bbpress/assets/bbpress.css');

   // Enque all stylesheets
   wp_enqueue_style( 'cv-bbpress' );

}
endif;

/* ===================================================================== *
 * Add bbPress specific sidebars
 * ===================================================================== */

if ( ! function_exists( 'cv_register_bbpress_sidebars' ) ) :

/**
 * Function to add the WooCommerce Specific sidebars
 *
 * @return array
 */
function cv_register_bbpress_sidebars( $areas ) {

   $areas['bbpress_forums_sidebar'] = array(
      'name' => __( 'bbPress Sidebar', 'canvys' ),
      'desc' => __( 'The sidebar for your bbPress forums. The default sidebar will be used if this sidebar is not active.', 'canvys' )
   );

   return $areas;

}

add_filter( 'cv_registered_sidebars', 'cv_register_bbpress_sidebars' );

endif;

/* ===================================================================== *
 * Add bbPress specific builder modules
 * ===================================================================== */

// Load required directories
include dirname(__FILE__) . '/shortcodes/class-bbpress-forum.php';
include dirname(__FILE__) . '/shortcodes/class-bbpress-recovery.php';
include dirname(__FILE__) . '/shortcodes/class-bbpress-registration.php';

/**
 * Activate included WooCommerce shortcodes
 * for template builder/shortcode composer integration
 */
$classes = array(
   'CV_bbPress_Index',
   'CV_bbPress_Registration',
   'CV_bbPress_Recovery',
);

foreach ( $classes as $class ) {

   // Make sure the class exists
   if ( ! class_exists( $class ) ) {
      continue;
   }

   // Create shortcode object
   $shortcode = new $class();

   // Add shortcode object to global canvys variable
   $canvys['shortcodes'][$shortcode->config['handle']] = $shortcode;

   // Activate the shortcode
   $shortcode->init();

}

/* ===================================================================== *
 * Activate the bbPress specific settings page
 * ===================================================================== */

/**
 * Activate included bbPress settings page
 * for theme settings integration
 */
$class = 'CV_bbPress_Settings';

if ( ! class_exists( $class ) ) {
   require dirname( __FILE__ ) . '/settings-page.php';
}

// Create the page object
$page = new $class();

// Add page object to global canvys variable
$canvys['theme_settings_pages'][$page->config['slug']] = $page;

// Run the initialization function
$page->init();