<?php

// Global WooCommerce & Canvys object
global $woocommerce, $canvys;

// Declare theme support for WooCommerce
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/* ===================================================================== *
 * Modify number of products displayed per page
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_products_per_page' ) ) :

/**
 * Function to change how many products are displayed per page
 *
 * @return int
 */
function cv_woocommerce_modify_products_per_page( $columns ) {
   return cv_theme_setting( 'woocommerce', 'per_page' ) ? cv_theme_setting( 'woocommerce', 'per_page', '12' ) : -1;
}

add_filter( 'loop_shop_per_page', 'cv_woocommerce_modify_products_per_page', 20 );

endif;

/* ===================================================================== *
 * Add WooCommerce specific sidebars
 * ===================================================================== */

if ( ! function_exists( 'cv_register_woocommerce_sidebars' ) ) :

/**
 * Function to add the WooCommerce Specific sidebars
 *
 * @return array
 */
function cv_register_woocommerce_sidebars( $areas ) {

   $areas['woocommerce_shop_sidebar'] = array(
      'name' => __( 'Shop Sidebar', 'canvys' ),
      'desc' => __( 'The sidebar for your WooCommerce shop. The default sidebar will be used if this sidebar is not active.', 'canvys' )
   );

   return $areas;

}

add_filter( 'cv_registered_sidebars', 'cv_register_woocommerce_sidebars' );

endif;

/* ===================================================================== *
 * Function to be executed when WooCommerce is deactivated
 * ===================================================================== */

if ( ! function_exists( 'cv_deactivate_woocommerce' ) ) :

/**
 * Function to remove the WooCommerce shortcodes from all page builder options
 *
 * @return void
 */
function cv_deactivate_woocommerce() {

   // Shortcodes to be removed
   $searches = array(
      'woocommerce_cart',
      'woocommerce_checkout',
      'woocommerce_my_account',
      'cv_woocommerce_product_list',
   );

   // Remove now inactive shortcodes from all posts
   cv_refresh_all_builder_values( $searches );

}

$file = 'woocommerce/woocommerce.php';

register_deactivation_hook( $file, 'cv_deactivate_woocommerce' );

endif;

/* ===================================================================== *
 * Add WooCommerce specific builder modules
 * ===================================================================== */

// Load required directories
include dirname(__FILE__) . '/shortcodes/product-list.php';
include dirname(__FILE__) . '/shortcodes/woocommerce-cart.php';
include dirname(__FILE__) . '/shortcodes/woocommerce-checkout.php';
include dirname(__FILE__) . '/shortcodes/woocommerce-my-account.php';

/**
 * Activate included WooCommerce shortcodes
 * for template builder/shortcode composer integration
 */
$classes = array(
   'CV_WooCommerce_Cart',
   'CV_WooCommerce_Checkout',
   'CV_WooCommerce_My_Account',
   'cv_woocommerce_product_list',
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
 * Activate the WooCommerce specific settings page
 * ===================================================================== */

/**
 * Activate included WooCommerce settings page
 * for theme settings integration
 */
$class = 'CV_WooCommerce_Settings';

if ( ! class_exists( $class ) ) {
   require dirname( __FILE__ ) . '/settings-page.php';
}

// Create the page object
$page = new $class();

// Add page object to global canvys variable
$canvys['theme_settings_pages'][$page->config['slug']] = $page;

// Run the initialization function
$page->init();